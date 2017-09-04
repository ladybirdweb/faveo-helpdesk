<?php

namespace App\Http\Controllers\Utility;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Flow\Request;
use Response;

class UploadController extends Controller
{
    public function upload()
    {
        try {
            $request = new \Flow\Request();
            $destination = $this->fileName($this->getPrivateDir(), $request);
            $config = $this->setConfig();
            $file = new \Flow\File($config, $request);
            $response = Response::make('', 200);

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!$file->checkChunk()) {
                    return Response::make('', 404);
                }
            } else {
                if ($file->validateChunk()) {
                    $file->saveChunk();
                } else {
                    // error, invalid chunk upload request, retry
                    return Response::make('', 400);
                }
            }
            if ($file->validateFile() && $file->save($destination)) {
                $response = Response::make('success', 200);
            }

            return $response;
        } catch (\Exception $e) {
            $result = $e->getMessage();

            return response()->json(compact('result'), 500);
        }
    }

    public function filename($dir, $request)
    {
        $destination = $this->getPrivateDir().'/'.$request->getFileName();
        if (\File::exists($destination)) {
            $destination = $this->getPrivateDir().'/'.str_random(4).'_'.$request->getFileName();
        }

        return $destination;
    }

    public function filenamePublic($dir, $request)
    {
        $destination = $this->getPublicDir().'/'.$request->getFileName();
        if (\File::exists($destination)) {
            $destination = $this->getPublicDir().'/'.str_random(4).'_'.$request->getFileName();
        }

        return $destination;
    }

    public function setConfig()
    {
        $config = new \Flow\Config();
        $temp_folder = $this->getPrivateDir().'/chunk';
        \File::makeDirectory($temp_folder, 0775, true, true);
        $config->setTempDir($temp_folder);

        return $config;
    }

    public function setConfigPublic()
    {
        $config = new \Flow\Config();
        $temp_folder = $this->getPublicDir().'/chunk';
        \File::makeDirectory($temp_folder, 0775, true, true);
        $config->setTempDir($temp_folder);

        return $config;
    }

    public function getPrivateDir()
    {
        try {
            $settings = new \App\Model\helpdesk\Settings\CommonSettings();
            $private = $settings->getOptionValue('storage', 'private-root', true);
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $dir = storage_path('app/private/'.$year.'/'.$month.'/'.$day);
            if ($private) {
                $dir = $private.DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.DIRECTORY_SEPARATOR.$day;
            }
            if (!\File::isDirectory($dir)) {
                \File::makeDirectory($dir, 0775, true);
            }
            if (!\File::isWritable($dir)) {
                throw new \Exception("$dir need write permission");
            }

            return $dir;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getPublicDir()
    {
        $settings = new \App\Model\helpdesk\Settings\CommonSettings();
        $private = $settings->getOptionValue('storage', 'public-root', true);
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $dir = public_path('uploads/'.$year.'/'.$month.'/'.$day);
        if ($private) {
            $dir = $private.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.DIRECTORY_SEPARATOR.$day;
        }
        if (!\File::isDirectory($dir)) {
            \File::makeDirectory($dir, 0775, true);
        }
        if (!\File::isWritable($dir)) {
            throw new \Exception("$dir need write permission");
        }

        return $dir;
    }

    public function getPrivate()
    {
        $settings = new \App\Model\helpdesk\Settings\CommonSettings();
        $private = $settings->getOptionValue('storage', 'private-root', true);
        if ($private) {
            $dir = $private.DIRECTORY_SEPARATOR.'private';
        } else {
            $dir = storage_path('app/private');
        }
        //dd($dir);
        return $dir;
    }

    public function files(\Illuminate\Http\Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 5;
        $offset = ($page * $perPage) - $perPage;
        $directory = $this->dir($request->all());
        $files = \File::allFiles($directory);
        $file_contents = [];
        $file_five = array_slice($files, $offset, $perPage);

        foreach ($file_five as $key => $file) {
            chmod($file->getPathname(), 0775);
            $mime = \File::mimeType($file->getPathname());
            $file_contents[$key]['pathname'] = $file->getPathname();
            $file_contents[$key]['extension'] = $file->getExtension();
            $file_contents[$key]['filename'] = $file->getFilename();
            $file_contents[$key]['size'] = $file->getSize();
            $file_contents[$key]['type'] = substr($mime, 0, strpos($mime, '/'));
            $file_contents[$key]['path'] = $file->getPath();
            if (starts_with($mime, 'image')) {
                $file_contents[$key]['type'] = 'image';
                $file_contents[$key]['base_64'] = "data:$mime;base64,".base64_encode(file_get_contents($file->getPathname()));
            }
            if (mime($mime) != 'image' || mime($file->getExtension()) != 'image') {
                chmod($file_contents[$key]['pathname'], 1204);
            }
        }
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($file_contents, count($files), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);

        return $paginator->toJson();
    }

    public function filesSearch(\Illuminate\Http\Request $request)
    {
        $term = $request->input('term');
        $dir = $this->getPrivate().DIRECTORY_SEPARATOR.$term.'.*';
        $files = glob($dir);
        if (count($files) > 0) {
            foreach ($files as $file) {
                $info = pathinfo($file);
                echo 'File found: extension '.$info['extension'].'<br>';
            }
        } else {
            echo "No file name exists called $term. Regardless of extension.";
        }
    }

    public function dir($request = [])
    {
        $directory = $this->getPrivate();
        if (checkArray('year', $request)) {
            $directory = $directory.DIRECTORY_SEPARATOR.checkArray('year', $request);
        }
        if (checkArray('year', $request) && checkArray('month', $request)) {
            $directory = $directory.DIRECTORY_SEPARATOR.checkArray('month', $request);
        }
        if (checkArray('year', $request) && checkArray('month', $request) && checkArray('day', $request)) {
            $directory = $directory.DIRECTORY_SEPARATOR.checkArray('day', $request);
        }
        if (!is_dir($directory)) {
            throw new \Exception('Invalid directory', 401);
        }

        return $directory;
    }

    public function dirPublic($request = [])
    {
        $directory = public_path('uploads');
        if (checkArray('year', $request)) {
            $directory = $directory.DIRECTORY_SEPARATOR.checkArray('year', $request);
        }
        if (checkArray('year', $request) && checkArray('month', $request)) {
            $directory = $directory.DIRECTORY_SEPARATOR.checkArray('month', $request);
        }
        if (checkArray('year', $request) && checkArray('month', $request) && checkArray('day', $request)) {
            $directory = $directory.DIRECTORY_SEPARATOR.checkArray('day', $request);
        }
        if (!is_dir($directory)) {
            throw new \Exception('Invalid directory', 401);
        }

        return $directory;
    }

    public function uploadPublic()
    {
        try {
            $request = new \Flow\Request();

            $destination = $this->filenamePublic($this->getPublicDir(), $request);
            $config = $this->setConfigPublic();
            $file = new \Flow\File($config, $request);
            $response = Response::make('', 200);

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!$file->checkChunk()) {
                    return Response::make('', 404);
                }
            } else {
                if ($file->validateChunk()) {
                    $file->saveChunk();
                } else {
                    // error, invalid chunk upload request, retry
                    return Response::make('', 400);
                }
            }
            if ($file->validateFile() && $file->save($destination)) {
                $mime = \File::mimeType($destination);
                $extension = \File::extension($destination);
                if (mime($mime) != 'image' || mime($extension) != 'image') {
                    chmod($destination, 1204);
                }

                $response = Response::make('success', 200);
            }

            return $response;
        } catch (\Exception $e) {
            $result = $e->getMessage();

            return response()->json(compact('result'), 500);
        }
    }

    public function filesPublic(\Illuminate\Http\Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 5;
        $offset = ($page * $perPage) - $perPage;
        $directory = $this->dirPublic($request->all());
        $files = \File::allFiles($directory);
        $file_contents = [];
        $file_five = array_slice($files, $offset, $perPage);

        foreach ($file_five as $key => $file) {
            chmod($file->getPathname(), 0775);
            $mime = \File::mimeType($file->getPathname());
            $file_contents[$key]['pathname'] = $file->getPathname();
            $file_contents[$key]['extension'] = $file->getExtension();
            $file_contents[$key]['filename'] = $file->getFilename();
            $file_contents[$key]['size'] = $file->getSize();
            $file_contents[$key]['type'] = substr($mime, 0, strpos($mime, '/'));
            $file_contents[$key]['path'] = $file->getPath();
            $file_contents[$key]['base_64'] = asset(strstr($file->getPathname(), 'uploads'));
            if (mime($mime) != 'image' || mime($file->getExtension()) != 'image') {
                chmod($file_contents[$key]['pathname'], 1204);
            }
        }
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($file_contents, count($files), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);

        return $paginator->toJson();
    }

    public function filesSearchPublic(\Illuminate\Http\Request $request)
    {
        $term = $request->input('term');
        $dir = $this->getPrivate().DIRECTORY_SEPARATOR.$term.'.*';
        $files = glob($dir);
        if (count($files) > 0) {
            foreach ($files as $file) {
                $info = pathinfo($file);
                echo 'File found: extension '.$info['extension'].'<br>';
            }
        } else {
            echo "No file name exists called $term. Regardless of extension.";
        }
    }
}
