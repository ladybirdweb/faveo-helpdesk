<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\LibraryController as Utility;
use App\Model\Update\BarNotification;
use Artisan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UpgradeController extends Controller
{
    public $dir;

    public function __construct()
    {
        $dir = base_path();
        $this->dir = $dir;
    }

    public function getLatestVersion()
    {
        try {
            $name = \Config::get('app.name');
            //dd($name);
            //serial key should be encrypted data
            $serial_key = '64JAHF9WVJA4GCUZ';
            //order number should be encrypted data
            $order_number = '44596328';
            $url = env('APP_URL');
            $data = [
                'serial_key'   => $serial_key,
                'order_number' => $order_number,
                'name'         => $name,
                'version'      => Utility::getFileVersion(),
                'request_type' => 'check_update',
                'url'          => $url,
            ];
            $data = Utility::encryptByFaveoPublicKey(json_encode($data));
            //dd($data);
            $post_data = [
                'data' => $data,
            ];
            $url = 'http://faveohelpdesk.com/billing/public/verification';
            if (Str::contains($url, ' ')) {
                $url = str_replace(' ', '%20', $url);
            }
            $curl = $this->postCurl($url, $post_data);
            if (is_array($curl)) {
                if (array_key_exists('status', $curl)) {
                    if ($curl['status'] == 'success') {
                        if (array_key_exists('version', $curl)) {
                            return $curl['version'];
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function downloadLatestCode()
    {
        $name = \Config::get('app.name');
        $durl = 'http://www.faveohelpdesk.com/billing/public/download-url';
        if (Str::contains($durl, ' ')) {
            $durl = str_replace(' ', '%20', $durl);
        }
        $data = [
            'name' => $name,
        ];
        $download = $this->postDownloadCurl($durl, $data);

        $download_url = $download['zipball_url'];

        return $download_url;
    }

    public function saveLatestCodeAtTemp($download_url)
    {
        echo '<p>Downloading New Update</p>';
        $context = stream_context_create(
            [
                'http' => [
                    'header' => 'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
                ],
            ]
        );

        $newUpdate = file_get_contents($download_url, false, $context);
        if (!is_dir("$this->dir/UPDATES/")) {
            \File::makeDirectory($this->dir.'/UPDATES/', 0777);
        }

        $dlHandler = fopen($this->dir.'/UPDATES/'.'/faveo-helpdesk-master.zip', 'w');
        if (!fwrite($dlHandler, $newUpdate)) {
            echo '<p>Could not save new update. Operation aborted.</p>';
            exit;
        }
        fclose($dlHandler);
        echo '<p>Update Downloaded And Saved</p>';
    }

    public function doUpdate()
    {
        try {
            $memory_limit = ini_get('memory_limit');
            if ($memory_limit < 256) {
                echo '<ul class=list-unstyled>';
                echo "<li style='color:red;'>Sorry we can not process your request because of limited memory! You have only  $memory_limit. For this you need atleast 256 MB</li>";
                echo '</ul>';

                return 0;
            }
            if (!extension_loaded('zip')) {
                echo '<ul class=list-unstyled>';
                echo "<li style='color:red;'>Sorry we can not process your request because you don't have ZIP extension contact your system admin</li>";
                echo '</ul>';

                return 0;
            }
            //Artisan::call('down');
            $update = $this->dir.'/UPDATES';
            //Open The File And Do Stuff
            $zipHandle = zip_open($update.'/faveo-helpdesk-master.zip');
            //dd($update . '/faveo-' . $aV . '.zip');

            echo '<ul class=list-unstyled>';
            while ($aF = zip_read($zipHandle)) {
                $thisFileName = zip_entry_name($aF);
                $thisFileDir = dirname($thisFileName);

                //Continue if its not a file
                if (substr($thisFileName, -1, 1) == '/') {
                    continue;
                }

                //Make the directory if we need to...
                if (!is_dir($update.'/'.$thisFileDir.'/')) {
                    \File::makeDirectory($update.'/'.$thisFileDir, 0775, true, true);
                    // mkdir($update.'/'. $thisFileDir, 0775);
                    echo '<li style="color:white;">Created Directory '.$thisFileDir.'</li>';
                }

                //Overwrite the file
                if (!is_dir($update.'/'.$thisFileName)) {
                    echo '<li style="color:white;">'.$thisFileName.'...........';
                    $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                    $contents = str_replace("\r\n", "\n", $contents);
                    $updateThis = '';

                    //If we need to run commands, then do it.
                    if ($thisFileName == $thisFileDir.'/.env') {
                        if (is_file($update.'/'.$thisFileDir.'/.env')) {
                            unlink($update.'/'.$thisFileDir.'/.env');
                            unlink($update.'/'.$thisFileDir.'/config/database.php');
                        }
                        echo' EXECUTED</li>';
                    } else {
                        $updateThis = fopen($update.'/'.$thisFileName, 'w');
                        fwrite($updateThis, $contents);
                        fclose($updateThis);
                        unset($contents);
                        echo' UPDATED</li>';
                    }
                }
            }
            echo '</ul>';
            //Artisan::call('migrate', ['--force' => true]);
            return true;
        } catch (Exception $ex) {
            echo '<ul class=list-unstyled>';
            echo "<li style='color:red;'>".$ex->getMessage().'</li>';
            echo '</ul>';
        }
    }

    public function copyToActualDirectory($latest_version)
    {
        try {
            echo '<ul class=list-unstyled>';
            $directory = "$this->dir/UPDATES";
            $destination = $this->dir;
//        $destination = "/Applications/AMPPS/www/test/new";
            $directories = \File::directories($directory);

//        echo "current directory => $directory <br>";
//        echo "Destination Directory => $destination <br>";
            foreach ($directories as $source) {
                $success = \File::copyDirectory($source, $destination);
                echo '<li class="success">&raquo; </li>';
            }

            \File::deleteDirectory($directory);

            $this->deleteBarNotification('new-version');

            echo "<li style='color:green;'>&raquo; Faveo Updated to v".Utility::getFileVersion().'</li>';
            echo '</ul>';
        } catch (Exception $ex) {
            echo '<ul class=list-unstyled>';
            echo "<li style='color:red;'>".$ex->getMessage().'</li>';
            echo '</ul>';
        }
        exit;
    }

    public function deleteBarNotification($key)
    {
        try {
            $noti = new BarNotification();
            $notifications = $noti->where('key', $key)->get();
            foreach ($notifications as $notify) {
                $notify->delete();
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function fileUpdate()
    {
        try {
            $latest_version = $this->getLatestVersion();
            if (Utility::getFileVersion() < $latest_version) {
                $url = url('file-upgrade');

                return view('themes.default1.update.file', compact('url'));
            }

            return redirect('dashboard')->with('fails', 'Could not find latest realeases from repository.');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function fileUpgrading(Request $request)
    {
        try {
            //
            $latest_version = $this->getLatestVersion();

            $current_version = Utility::getFileVersion();
            if ($latest_version != '') {
                if (Utility::getFileVersion() < $latest_version) {
                    return view('themes.default1.update.update', compact('latest_version', 'current_version', 'request'));
                }
            }

            return redirect('dashboard')->with('fails', 'Could not find latest realeases from repository.');

//            else {
//                return redirect()->back();
//            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function testScroll()
    {
        $ex = 1000;
        echo '<ul style=list-unstyled>';
        for ($i = 0; $i < $ex; $i++) {
            echo "<li style='color:white;'>updated</li>";
        }
        echo '</ul>';
    }

    public function fileUpgrading1(Request $request)
    {
        if (Utility::getFileVersion() < Utility::getDatabaseVersion()) {
            $latest_version = $this->getLatestVersion();
//            dd($latest_version);
            $current_version = Utility::getFileVersion();
            //dd($current_version);
            if ($latest_version != '') {
                echo "<p>CURRENT VERSION: $current_version</p>";
                echo '<p>Reading Current Releases List</p>';
                if ($latest_version > $current_version) {
                    echo '<p>New Update Found: v'.$latest_version.'</p>';
                    $found = true;
                    if (!is_file("$this->dir/UPDATES/faveo-helpdesk-master.zip")) {
                        if ($request->get('dodownload') == true) {
                            $download_url = $this->downloadLatestCode();
                            if ($download_url != null) {
                                $this->saveLatestCodeAtTemp($download_url);
                            } else {
                                echo '<p>Error in you network connection.</p>';
                            }
                        } else {
                            echo '<p>Latest code found. <a href='.url('file-upgrade?dodownload=true').'>&raquo; Download Now?</a></p>';
                            exit;
                        }
                    } else {
                        echo '<p>Update already downloaded.</p>';
                    }
                    if ($request->get('doUpdate') == true) {
                        $updated = $this->doUpdate();
                    } else {
                        echo '<p>Update ready. <a href='.url('file-upgrade?doUpdate=true').'>&raquo; Install Now?</a></p>';
                        exit;
                    }

                    if ($updated == true) {
                        $this->copyToActualDirectory($latest_version);
                    } elseif ($found != true) {
                        echo '<p>&raquo; No update is available.</p>';
                    }
                } else {
                    echo '<p>Could not find latest realeases.</p>';
                }
            } else {
                echo '<p>Could not find latest realeases from repository.</p>';
            }
        } else {
            return redirect()->back();
        }
    }

    public function getCurl($url)
    {
        try {
            $curl = Utility::_isCurl();
            if (!$curl) {
                throw new Exception('Please enable your curl function to check latest update');
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            if (curl_exec($ch) === false) {
                echo 'Curl error: '.curl_error($ch);
            }
            $data = curl_exec($ch);
            curl_close($ch);

            return $data;
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postDownloadCurl($url, $data)
    {
        try {
            $curl = Utility::_isCurl();
            if (!$curl) {
                throw new Exception('Please enable your curl function to check latest update');
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            if (curl_exec($ch) === false) {
                echo 'Curl error: '.curl_error($ch);
            }
            $data = curl_exec($ch);
            curl_close($ch);

            return json_decode($data, true);
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postCurl($url, $data)
    {
        try {
            $curl = Utility::_isCurl();
            if (!$curl) {
                throw new Exception('Please enable your curl function to check latest update');
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            if (curl_exec($ch) === false) {
                echo 'Curl error: '.curl_error($ch);
            }
            $data = curl_exec($ch);
            curl_close($ch);
            $data = Utility::decryptByFaveoPrivateKey($data);

            return json_decode($data, true);
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function databaseUpdate()
    {
        try {
            if (Utility::getFileVersion() > Utility::getDatabaseVersion()) {
                $url = url('database-upgrade');
                //$string = "Your Database is outdated please upgrade <a href=$url>Now !</a>";
                return view('themes.default1.update.database', compact('url'));
            } else {
                return redirect()->back();
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function databaseUpgrade()
    {
        try {
            if (Utility::getFileVersion() > Utility::getDatabaseVersion()) {
                Artisan::call('migrate', ['--force' => true]);

                return redirect('dashboard')->with('success', 'Database updated');
            } else {
                return redirect()->back();
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
