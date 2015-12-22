<?php namespace App\Http\Controllers\Common;
// controllers
use App\Http\Controllers\Controller;
// requests
use Illuminate\Http\Request;
use App\Http\Requests\helpdesk\SmtpRequest;
use App\Http\Requests;
// models
use App\Model\helpdesk\Theme\Footer2;
use App\Model\helpdesk\Theme\Footer3;
use App\Model\helpdesk\Theme\Footer4;
use App\Model\helpdesk\Theme\Footer;
use App\Model\helpdesk\Email\Smtp;
use App\Model\helpdesk\Utility\Version_Check;
// classes
use Config;
use Input;
use Crypt;
use Illuminate\Support\Collection;
use App\Model\helpdesk\Settings\Plugin;

/**
 * ***************************
 * Settings Controllers
 * ***************************
 * Controller to keep smtp details and fetch where ever needed
 * @package default
 */
class SettingsController extends Controller {

    /**
     * Create a new controller instance.
     * @return type void
     */
    public function __construct() {
// $this->smtp();
        $this->middleware('auth');
        $this->middleware('roles');
        SettingsController::driver();
        SettingsController::host();
        SettingsController::port();
        SettingsController::from();
        SettingsController::encryption();
        SettingsController::username();
        SettingsController::password();
    }

    /**
     * get the page to create the footer
     * @return response
     */
    public function CreateFooter(Footer $footer) {
        $footer = $footer->whereId('1')->first();
        return view('themes.default1.admin.helpdesk.theme.footer', compact('footer'));
    }

    /**
     * Post footer
     * @param type Footer $footer
     * @param type Request $request
     * @return type response
     */
    public function PostFooter(Footer $footer, Request $request) {
        $footer = $footer->whereId('1')->first();
        if ($footer->fill($request->input())->save()) {
            return redirect('create-footer')->with('success', 'Footer Saved Successfully');
        } else {
            return redirect('create-footer')->with('fails', 'Footer was not Saved');
        }
    }

    /**
     * get the page to create the footer
     * @return response
     */
    public function CreateFooter2(Footer2 $footer2) {
        $footer2 = $footer2->whereId('1')->first();
        return view('themes.default1.admin.helpdesk.theme.footer2', compact('footer2'));
    }

    /**
     * Post footer 2
     * @param type Footer $footer
     * @param type Request $request
     * @return type response
     */
    public function PostFooter2(Footer2 $footer2, Request $request) {
        $footer2 = $footer2->whereId('1')->first();
        if ($footer2->fill($request->input())->save()) {
            return redirect('create-footer2')->with('success', 'Footer Saved Successfully');
        } else {
            return redirect('create-footer2')->with('fails', 'Footer was not Saved');
        }
    }

    /**
     * get the page to create the footer
     * @return response
     */
    public function CreateFooter3(Footer3 $footer3) {
        $footer3 = $footer3->whereId('1')->first();
        return view('themes.default1.admin.helpdesk.theme.footer3', compact('footer3'));
    }

    /**
     * Post footer 3
     * @param type Footer $footer
     * @param type Request $request
     * @return type response
     */
    public function PostFooter3(Footer3 $footer3, Request $request) {
        $footer3 = $footer3->whereId('1')->first();
        if ($footer3->fill($request->input())->save()) {
            return redirect('create-footer3')->with('success', 'Footer Saved Successfully');
        } else {
            return redirect('create-footer3')->with('fails', 'Footer was not Saved');
        }
    }

    /**
     * get the page to create the footer
     * @return response
     */
    public function CreateFooter4(Footer4 $footer4) {
        $footer4 = $footer4->whereId('1')->first();
        return view('themes.default1.admin.helpdesk.theme.footer4', compact('footer4'));
    }

    /**
     * Post footer 4
     * @param type Footer $footer
     * @param type Request $request
     * @return type response
     */
    public function PostFooter4(Footer4 $footer4, Request $request) {
        $footer4 = $footer4->whereId('1')->first();
        if ($footer4->fill($request->input())->save()) {
            return redirect('create-footer4')->with('success', 'Footer Saved Successfully');
        } else {
            return redirect('create-footer4')->with('fails', 'Footer was not Saved');
        }
    }

    /**
     * Driver
     * @return type void
     */
    static function driver() {
        $set = new Smtp;
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.host', $settings->driver);
    }

    /**
     * SMTP host
     * @return type void
     */
    static function host() {
        $set = new Smtp;
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.host', $settings->host);
    }

    /**
     * SMTP port
     * @return type void
     */
    static function port() {
        $set = new Smtp;
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.port', intval($settings->port));
    }

    /**
     * SMTP from
     * @return type void
     */
    static function from() {
        $set = new Smtp;
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.from', ['address' => $settings->email, 'name' => $settings->company_name]);
    }

    /**
     * SMTP encryption
     * @return type void
     */
    static function encryption() {
        $set = new Smtp;
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.encryption', $settings->encryption);
    }

    /**
     * SMTP username
     * @return type void
     */
    static function username() {
        $set = new Smtp;
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.username', $settings->email);
    }

    /**
     * SMTP password
     * @return type void
     */
    static function password() {
        $settings = Smtp::first();
        if ($settings->password) {
            $pass = $settings->password;
            $password = Crypt::decrypt($pass);
            Config::set('mail.password', $password);
        }
    }

    /**
     * get SMTP
     * @return type view
     */
    public function getsmtp() {
        $settings = Smtp::where('id', '=', '1')->first();
        return view('themes.default1.admin.helpdesk.emails.smtp', compact('settings'));
    }

    /**
     * POST SMTP
     * @return type view
     */
    public function postsmtp(SmtpRequest $request) {
        $data = Smtp::where('id', '=', 1)->first();
        $data->driver = $request->input('driver');
        $data->host = $request->input('host');
        $data->port = $request->input('port');
        $data->encryption = $request->input('encryption');
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->password = Crypt::encrypt($request->input('password'));
        if ($data->save()) {
            return \Redirect::route('getsmtp')->with('success', 'success');
        } else {
            return \Redirect::route('getsmtp')->with('fails', 'fails');
        }
    }

    /**
     * SMTP
     * @return type void
     */
    static function smtp() {
        $settings = Smtp::where('id', '=', '1')->first();
        if ($settings->password) {
            $password = Crypt::decrypt($settings->password);
            Config::set('mail.driver', $settings->driver);
            Config::set('mail.password', $password);
            Config::set('mail.username', $settings->email);
            Config::set('mail.encryption', $settings->encryption);
            Config::set('mail.from', ['address' => $settings->email, 'name' => $settings->name]);
            Config::set('mail.port', intval($settings->port));
            Config::set('mail.host', $settings->host);
        }
    }

    /**
     * Settings
     * @param type Smtp $set 
     * @return type view\
     */
    public function settings(Smtp $set) {
        $settings = $set->where('id', '1')->first();
        return view('themes.default1.admin.settings', compact('settings'));
    }

    /**
     * Post settings
     * @param type Settings $set 
     * @param type Request $request 
     * @return type view
     */
    public function PostSettings(Settings $set, Request $request) {
        $settings = $set->where('id', '1')->first();
        $pass = $request->input('password');
        $password = Crypt::encrypt($pass);
        $settings->password = $password;
        $settings->save();
        if (Input::file('logo')) {
            $name = Input::file('logo')->getClientOriginalName();
            $destinationPath = 'dist/logo';
            $fileName = rand(0000, 9999) . '.' . $name;
            Input::file('logo')->move($destinationPath, $fileName);
            $settings->logo = $fileName;
            $settings->save();
        }
        $settings->fill($request->except('logo', 'password'))->save();
        return redirect()->back()->with('success', 'Settings updated Successfully');
    }

    /**
     * version_check
     * @return type
     */
    public function version_check() {

        $response_url = \URL::route('post-version-check');

        echo "<form action='http://www.faveohelpdesk.com/bill/version' method='post' name='redirect'>";
        echo "<input type='hidden' name='_token' value='csrf_token()'/>";
        echo "<input type='hidden' name='title' value='helpdeskcommunityedition'/>";
        echo "<input type='hidden' name='id' value='19'/>";
        echo "<input type='hidden' name='response_url' value='" . $response_url . "' />";
        echo "</form>";
        echo "<script language='javascript'>document.redirect.submit();</script>";
    }

    /**
     * post_version_check
     * @return type
     */
    public function post_version_check(Request $request) {

        $current_version = \Config::get('app.version');

        $new_version = $request->value;

        if ($current_version == $new_version) {
// echo "No, new Updates";
            return redirect()->route('checkupdate')->with('info', ' No, new Updates');
        } elseif ($current_version < $new_version) {
            $version = Version_Check::where('id', '=', '1')->first();
            $version->current_version = $current_version;
            $version->new_version = $new_version;
            $version->save();
// echo "Version " . $new_version . " is Available";
            return redirect()->route('checkupdate')->with('info', ' Version ' . $new_version . ' is Available');
        } else {
// echo "Error Checking Version";
            return redirect()->route('checkupdate')->with('info', ' Error Checking Version');
        }
    }

    public function getupdate() {
        return \View::make('themes.default1.admin.helpdesk.settings.checkupdate');
    }

    public function Plugins() {
        return view('themes.default1.admin.helpdesk.settings.plugins');
    }

    public function GetPlugin() {
        $plugins = $this->fetchConfig();
        //dd($plugins);


        return \Datatable::collection(new Collection($plugins))
                        ->searchColumns('name')
                        ->addColumn('name', function($model) {
                            if (array_has($model, 'path')) {
                                if ($model['status'] == 0) {
                                    $activate = "<a href=" . url('plugin/status/' . $model['path']) . ">Activate</a>";
                                    $settings = " ";
                                } else {
                                    $settings = "<a href=" . url($model['settings']) . ">Settings</a> | ";
                                    $activate = "<a href=" . url('plugin/status/' . $model['path']) . ">Deactivate</a>";
                                }

                                $delete = "<a href=  id=delete".$model['path']." data-toggle=modal data-target=#del".$model['path']."><span style='color:red'>Delete</span></a>"
                                        . "<div class='modal fade' id=del".$model['path'].">
                                            <div class='modal-dialog'>
                                                <div class=modal-content>  
                                                    <div class=modal-header>
                                                        <h4 class=modal-title>Delete</h4>
                                                    </div>
                                                    <div class=modal-body>
                                                       <p>Are you Sure ?</p>
                                                        <div class=modal-footer>
                                                            <button type=button class='btn btn-default pull-left' data-dismiss=modal id=dismis>" . \Lang::get('lang.close') . "</button>
                                                            <a href=" . url('plugin/delete/' . $model['path']) . "><button class='btn btn-danger'>Delete</button></a>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                $action = "<br><br>" . $delete . " | " . $settings . $activate;
                            } else {
                                $action = '';
                            }
                            return ucfirst($model['name']) . $action;
                        })
                        ->addColumn('description', function($model) {
                            return ucfirst($model['description']);
                        })
                        ->addColumn('author', function($model) {
                            return ucfirst($model['author']);
                        })
                        ->addColumn('website', function($model) {
                            return "<a href=".$model['website']." target=_blank>".$model['website']."</a>";
                        })
                        ->addColumn('version', function($model) {
                            return $model['version'];
                        })
                        ->make();
    }

    /**
     * Reading the Filedirectory
     * @return type
     */
    public function ReadPlugins() {
        $dir = app_path() . '/Plugins';
        $plugins = array_diff(scandir($dir), array('.', '..'));
        return $plugins;
    }

    /**
     * After plugin post
     * @param Request $request
     * @return type
     */
    public function PostPlugins(Request $request) {
        $v = $this->validate($request, ['plugin' => 'required|mimes:application/zip,zip,Zip']);

        $plug = new Plugin();
        $file = $request->file('plugin');
        //dd($file);
        $destination = app_path() . '/Plugins';
        $zipfile = $file->getRealPath();


        /**
         * get the file name and remove .zip
         */
        $filename2 = $file->getClientOriginalName();
        $filename2 = str_replace('.zip', '', $filename2);
        $filename1 = ucfirst($file->getClientOriginalName());
        $filename = str_replace('.zip', '', $filename1);
        mkdir($destination . '/' . $filename);
        /**
         * extract the zip file using zipper
         */
        \Zipper::make($zipfile)->folder($filename2)->extractTo($destination . '/' . $filename);

        $file = app_path() . '/Plugins/' . $filename; // Plugin file path

        if (file_exists($file)) {

            $seviceporvider = $file . '/ServiceProvider.php';
            $config = $file . '/config.php';
            if (file_exists($seviceporvider) && file_exists($config)) {
                /**
                 * move to faveo config
                 */
                $faveoconfig = config_path() . '/plugins/' . $filename . '.php';
                if ($faveoconfig) {

                    copy($config, $faveoconfig);
                    /**
                     * write provider list in app.php line 128
                     */
                    $app = base_path() . '/config/app.php';
                    $str = "\n\n\t\t\t'App\\Plugins\\$filename" . "\\ServiceProvider',";
                    $line_i_am_looking_for = 128;
                    $lines = file($app, FILE_IGNORE_NEW_LINES);
                    $lines[$line_i_am_looking_for] = $str;
                    file_put_contents($app, implode("\n", $lines));
                    $plug->create(['name' => $filename, 'path' => $filename,'status'=>1]);
                    return redirect()->back()->with('success', 'Installed SuccessFully');
                } else {
                    /**
                     * delete if the plugin hasn't config.php and ServiceProvider.php
                     */
                    $this->deleteDirectory($file);
                    return redirect()->back()->with('fails', 'Their is no ' . $file);
                }
            } else {
                /**
                 * delete if the plugin hasn't config.php and ServiceProvider.php
                 */
                $this->deleteDirectory($file);
                return redirect()->back()->with('fails', 'Their is no <b>config.php or ServiceProvider.php</b>  ' . $file);
            }
        } else {
            /**
             * delete if the plugin Name is not equal to the folder name
             */
            $this->deleteDirectory($file);
            return redirect()->back()->with('fails', '<b>Plugin File Path is not exist</b>  ' . $file);
        }
    }

    /**
     * Delete the directory
     * @param type $dir
     * @return boolean
     */
    public function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    public function ReadConfigs() {
        $dir = app_path() . '/Plugins/';
        $files = array_diff(scandir($dir), array('.', '..', 'ServiceProvider.php'));

        $plugins = array();
        if ($files) {
            foreach ($files as $key => $file) {
                $plugin = $dir . $file;
                $plugins[$key] = array_diff(scandir($plugin), array('.', '..', 'ServiceProvider.php'));
                $plugins[$key]['file'] = $plugin;
            }
            foreach ($plugins as $plugin) {

                $dir = $plugin['file'];
                //opendir($dir);
                if ($dh = opendir($dir)) {

                    while (($file = readdir($dh)) !== false) {

                        if ($file == 'config.php') {
                            $config[] = $dir . '/' . $file;
                        }
                    }
                    closedir($dh);
                }
            }

            return $config;
        } else {
            return 'null';
        }
    }

    public function fetchConfig() {
        $configs = $this->ReadConfigs();
        //dd($configs);
        $plug = new Plugin;
        $plug = $plug->select('path', 'status')->orderBy('name')->get()->toArray();
        //dd($plug[0]['path']);
        if ($configs !== 'null') {
            foreach ($configs as $key => $config) {
                $fields[$key] = include $config;
                if ($plug != null) {
                    $fields[$key]['path'] = $plug[$key]['path'];
                    $fields[$key]['status'] = $plug[$key]['status'];
                }
                //dd($fields);
            }

            return $fields;
        } else {
            return array();
        }
    }

    public function DeletePlugin($slug) {

        $dir = app_path() . '/Plugins/' . $slug;
        $this->deleteDirectory($dir);

        /**
         * remove service provider from app.php
         */
        $str = "'App\\Plugins\\$slug" . "\\ServiceProvider',";
        $path_to_file = base_path() . '/config/app.php';

        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace($str, "//", $file_contents);
        file_put_contents($path_to_file, $file_contents);


        $plugin = new Plugin();
        $plugin = $plugin->where('path', $slug)->first();
        $plugin->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    public function StatusPlugin($slug) {
        $plug = new Plugin;
        $plug = $plug->where('name', $slug)->first();
        $status = $plug->status;
        if ($status == 0) {
            $plug->status = 1;

            $app = base_path() . '/config/app.php';
            $str = "'App\\Plugins\\$slug" . "\\ServiceProvider',";
            $line_i_am_looking_for = 128;
            $lines = file($app, FILE_IGNORE_NEW_LINES);
            $lines[$line_i_am_looking_for] = $str;
            file_put_contents($app, implode("\n", $lines));
        }
        if ($status == 1) {
            $plug->status = 0;
            /**
             * remove service provider from app.php
             */
            $str = "'App\\Plugins\\$slug" . "\\ServiceProvider',";
            $path_to_file = base_path() . '/config/app.php';

            $file_contents = file_get_contents($path_to_file);
            $file_contents = str_replace($str, "//", $file_contents);
            file_put_contents($path_to_file, $file_contents);
        }
        $plug->save();
        return redirect()->back()->with('success', 'Status has changed');
    }

}
