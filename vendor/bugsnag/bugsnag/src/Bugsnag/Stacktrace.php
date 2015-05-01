<?php

class Bugsnag_Stacktrace
{
    private static $DEFAULT_NUM_LINES = 7;
    private static $MAX_LINE_LENGTH = 200;

    public $frames = array();
    private $config;

    public static function generate($config)
    {
        // Reduce memory usage by omitting args and objects from backtrace
        if (version_compare(PHP_VERSION, '5.3.6') >= 0) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS & ~DEBUG_BACKTRACE_PROVIDE_OBJECT);
        } elseif (version_compare(PHP_VERSION, '5.2.5') >= 0) {
            $backtrace = debug_backtrace(false);
        } else {
            $backtrace = debug_backtrace();
        }

        return self::fromBacktrace($config, $backtrace, "[generator]", 0);
    }

    public static function fromFrame($config, $file, $line)
    {
        $stacktrace = new Bugsnag_Stacktrace($config);
        $stacktrace->addFrame($file, $line, "[unknown]");

        return $stacktrace;
    }

    public static function fromBacktrace($config, $backtrace, $topFile, $topLine)
    {
        $stacktrace = new Bugsnag_Stacktrace($config);

        // PHP backtrace's are misaligned, we need to shift the file/line down a frame
        foreach ($backtrace as $frame) {
            if (!self::frameInsideBugsnag($frame)) {
                $stacktrace->addFrame(
                    $topFile,
                    $topLine,
                    isset($frame['function']) ? $frame['function'] : null,
                    isset($frame['class']) ? $frame['class'] : null
                );
            }

            if (isset($frame['file']) && isset($frame['line'])) {
                $topFile = $frame['file'];
                $topLine = $frame['line'];
            } else {
                $topFile = "[internal]";
                $topLine = 0;
            }
        }

        // Add a final stackframe for the "main" method
        $stacktrace->addFrame($topFile, $topLine, '[main]');

        return $stacktrace;
    }

    public static function frameInsideBugsnag($frame)
    {
        return isset($frame['class']) && strpos($frame['class'], 'Bugsnag_') === 0;
    }

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function toArray()
    {
        return $this->frames;
    }

    public function addFrame($file, $line, $method, $class = null)
    {
        // Account for special "filenames" in eval'd code
        $matches = array();
        if (preg_match("/^(.*?)\((\d+)\) : (?:eval\(\)'d code|runtime-created function)$/", $file, $matches)) {
            $file = $matches[1];
            $line = $matches[2];
        }

        // Construct the frame
        $frame = array(
            'lineNumber' => $line,
            'method' => $method,
        );

        // Attach some lines of code for context
        if($this->config->sendCode) {
            $frame['code'] = $this->getCode($file, $line, Bugsnag_Stacktrace::$DEFAULT_NUM_LINES);
        }

        // Check if this frame is inProject
        $frame['inProject'] = !is_null($this->config->projectRootRegex) && preg_match($this->config->projectRootRegex, $file);

        // Strip out projectRoot from start of file path
        if (is_null($this->config->stripPathRegex)) {
            $frame['file'] = $file;
        } else {
            $frame['file'] = preg_replace($this->config->stripPathRegex, '', $file);
        }

        if (!empty($class)) {
            $frame['class'] = $class;
        }

        $this->frames[] = $frame;
    }

    private function getCode($path, $line, $numLines)
    {
        if (empty($path) || empty($line) || !file_exists($path)) {
            return NULL;
        }

        try {
            // Get the number of lines in the file
            $file = new SplFileObject($path);
            $file->seek(PHP_INT_MAX);
            $totalLines = $file->key() + 1;

            // Work out which lines we should fetch
            $start = max($line - floor($numLines / 2), 1);
            $end = $start + ($numLines - 1);
            if ($end > $totalLines) {
                $end = $totalLines;
                $start = max($end - ($numLines - 1), 1);
            }

            // Get the code for this range
            $code = array();

            $file->seek($start - 1);
            while ($file->key() < $end) {
                $code[$file->key() + 1] = rtrim(substr($file->current(), 0, Bugsnag_Stacktrace::$MAX_LINE_LENGTH));
                $file->next();
            }

            return $code;
        } catch (RuntimeException $ex) {
            return null;
        }
    }
}
