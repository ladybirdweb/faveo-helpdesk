<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Git;

use Gitonomy\Git\Exception\RuntimeException;
use Symfony\Component\Process\Process;

/**
 * Administration class for Git repositories.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Admin
{
    /**
     * Initializes a repository and returns the instance.
     *
     * @param string $path    path to the repository
     * @param bool   $bare    indicate to create a bare repository
     * @param array  $options options for Repository creation
     *
     * @throws RuntimeException Directory exists or not writable (only if debug=true)
     *
     * @return Repository
     */
    public static function init($path, $bare = true, array $options = [])
    {
        $process = static::getProcess('init', array_merge(['-q'], $bare ? ['--bare'] : [], [$path]), $options);

        $process->run();

        if (!$process->isSuccessFul()) {
            throw new RuntimeException(sprintf("Error on repository initialization, command wasn't successful (%s). Error output:\n%s", $process->getCommandLine(), $process->getErrorOutput()));
        }

        return new Repository($path, $options);
    }

    /**
     * Checks the validity of a git repository url without cloning it.
     *
     * This will use the `ls-remote` command of git against the given url.
     * Usually, this command returns 0 when successful, and 128 when the
     * repository is not found.
     *
     * @param string $url     url of repository to check
     * @param array  $options options for Repository creation
     *
     * @return bool true if url is valid
     */
    public static function isValidRepository($url, array $options = [])
    {
        $process = static::getProcess('ls-remote', [$url], $options);

        $process->run();

        return $process->isSuccessFul();
    }

    /**
     * Clone a repository to a local path.
     *
     * @param string $path    indicates where to clone repository
     * @param string $url     url of repository to clone
     * @param bool   $bare    indicates if repository should be bare or have a working copy
     * @param array  $options options for Repository creation
     *
     * @return Repository
     */
    public static function cloneTo($path, $url, $bare = true, array $options = [])
    {
        $args = $bare ? ['--bare'] : [];

        return static::cloneRepository($path, $url, $args, $options);
    }

    /**
     * Clone a repository branch to a local path.
     *
     * @param string $path    indicates where to clone repository
     * @param string $url     url of repository to clone
     * @param string $branch  branch to clone
     * @param bool   $bare    indicates if repository should be bare or have a working copy
     * @param array  $options options for Repository creation
     *
     * @return Repository
     */
    public static function cloneBranchTo($path, $url, $branch, $bare = true, $options = [])
    {
        $args = ['--branch', $branch];
        if ($bare) {
            $args[] = '--bare';
        }

        return static::cloneRepository($path, $url, $args, $options);
    }

    /**
     * Mirrors a repository (fetch all revisions, not only branches).
     *
     * @param string $path    indicates where to clone repository
     * @param string $url     url of repository to clone
     * @param array  $options options for Repository creation
     *
     * @return Repository
     */
    public static function mirrorTo($path, $url, array $options = [])
    {
        return static::cloneRepository($path, $url, ['--mirror'], $options);
    }

    /**
     * Internal method to launch effective ``git clone`` command.
     *
     * @param string $path    indicates where to clone repository
     * @param string $url     url of repository to clone
     * @param array  $args    arguments to be added to the command-line
     * @param array  $options options for Repository creation
     *
     * @return Repository
     */
    public static function cloneRepository($path, $url, array $args = [], array $options = [])
    {
        $process = static::getProcess('clone', array_merge(['-q'], $args, [$url, $path]), $options);

        $process->run();

        if (!$process->isSuccessFul()) {
            throw new RuntimeException(sprintf('Error while initializing repository: %s', $process->getErrorOutput()));
        }

        return new Repository($path, $options);
    }

    /**
     * This internal method is used to create a process object.
     */
    private static function getProcess($command, array $args = [], array $options = [])
    {
        $is_windows = defined('PHP_WINDOWS_VERSION_BUILD');
        $options = array_merge([
            'environment_variables' => $is_windows ? ['PATH' => getenv('PATH')] : [],
            'command'               => 'git',
            'process_timeout'       => 3600,
        ], $options);

        $process = new Process(array_merge([$options['command'], $command], $args));
        $process->setEnv($options['environment_variables']);
        $process->setTimeout($options['process_timeout']);
        $process->setIdleTimeout($options['process_timeout']);

        return $process;
    }
}
