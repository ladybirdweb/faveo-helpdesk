<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App;
// requests
use App\Http\Controllers\Controller;
//supports
use App\Http\Requests;
use Config;
//classes
use File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Model\helpdesk\Settings\System;
use Input;
use Lang;
use UnAuth;
use Validator;

/**
 * SlaController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class LanguageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * Switch language at runtime.
     *
     * @param type "" $lang
     *
     * @return type response
     */
    public function switchLanguage($lang)
    {
        $changed = UnAuth::changeLanguage($lang);
        if (!$changed) {
            return \Redirect::back()->with('fails', Lang::get('lang.language-error'));
        } else {
            return \Redirect::back();
        }
    }

    /**
     * Shows language page.
     *
     * @return type response
     */
    public function index()
    {
        return view('themes.default1.admin.helpdesk.language.index');
    }

    /**
     * Shows Language upload form.
     *
     * @return type response
     */
    public function getForm()
    {
        return view('themes.default1.admin.helpdesk.language.create');
    }

    /**
     * Provide language datatable to language page.
     *
     * @return type
     */
    public function getLanguages()
    {
        $path = base_path('resources/lang');
        $values = scandir($path);  //Extracts names of directories present in lang directory
        $values = array_slice($values, 2); // skips array element $value[0] = '.' & $value[1] = '..'
        return \Datatable::collection(new Collection($values))
                        ->addColumn('language', function ($model) {
                            $img_src = "lb-faveo/media/flags/".$model.".png";
                            if ($model == Config::get('app.fallback_locale')) {
                                return '<img src="'.asset($img_src).'"/>&nbsp;'.Config::get('languages.'.$model).' ('.Lang::get('lang.default').')';
                            } else {
                                return '<img src="'.asset($img_src).'"/>&nbsp;'.Config::get('languages.'.$model);
                            }
                        })
                        ->addColumn('id', function ($model) {
                            return $model;
                        })
                        ->addColumn('status', function ($model) {
                            $system = System::select('content')->where('id',1)->first();
                            $sys_lang = $system->content;
                            if ($sys_lang === $model) {
                                return "<span style='color:green'>".Lang::trans('lang.active').'</span>';
                            } else {
                                return "<span style='color:red'>".Lang::trans('lang.inactive').'</span>';
                            }
                        })
                        ->addColumn('Action', function ($model) {
                            $system = System::select('content')->where('id',1)->first();
                            $sys_lang = $system->content;
                            if ($sys_lang === $model) {
                                return "<a href='change-language/".$model."'><input type='button' class='btn btn-info btn-xs btn-flat' disabled value='".Lang::trans('lang.disable')."'/></a>  
                <a href='change-language/".$model."' class='btn btn-danger btn-xs btn-flat' disabled><i class='fa fa-trash' style='color:black;'> </i> ".Lang::trans('lang.delete').'</a>';
                            } else {
                                return "<a href='change-language/".$model."'><input type='button' class='btn btn-info btn-xs btn-flat' value='".Lang::trans('lang.enable')."'/></a>  
                <a href='delete-language/".$model."' class='btn btn-danger btn-xs btn-flat'><i class='fa fa-trash' style='color:black;'> </i> ".Lang::trans('lang.delete').'</a>';
                            }
                        })
                        ->searchColumns('language', 'id')
                        ->make();
    }

    /**
     * handle language file uploading.
     *
     * @return response
     */
    public function postForm()
    {
        try {
            // getting all of the post data
            $file = [
                'File'          => Input::file('File'),
                'language-name' => Input::input('language-name'),
                'iso-code'      => Input::input('iso-code'),
            ];

            // setting up rules
            $rules = [
                'File'          => 'required|mimes:zip|max:30000',
                'language-name' => 'required',
                'iso-code'      => 'required|max:2',
            ]; // and for max size
            // doing the validation, passing post data, rules and the messages
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {

                // send back to the page with the input data and errors
                return Redirect::back()->withInput()->withErrors($validator);
            } else {

                //Checking if package already exists or not in lang folder
                $path = base_path('resources/lang');
                if (in_array(strtolower(Input::get('iso-code')), scandir($path))) {

                    //sending back with error message
                    Session::flash('fails', Lang::get('lang.package_exist'));
                    Session::flash('link', 'change-language/'.strtolower(Input::get('iso-code')));

                    return Redirect::back()->withInput();
                } elseif (!array_key_exists(strtolower(Input::get('iso-code')), Config::get('languages'))) {//Checking Valid ISO code form Languages.php
                    //sending back with error message
                    Session::flash('fails', Lang::get('lang.iso-code-error'));

                    return Redirect::back()->withInput();
                } else {

                    // checking file is valid.
                    if (Input::file('File')->isValid()) {
                        $name = Input::file('File')->getClientOriginalName(); //uploaded file's original name
                        $destinationPath = base_path('public/uploads/'); // defining uploading path
                        $extractpath = base_path('resources/lang').'/'.strtolower(Input::get('iso-code')); //defining extracting path
                        mkdir($extractpath); //creating directroy for extracting uploadd file
                        //mkdir($destinationPath);
                        Input::file('File')->move($destinationPath, $name); // uploading file to given path
                        \Zipper::make($destinationPath.'/'.$name)->extractTo($extractpath); //extracting file to give path
                        //check if Zip extract foldercontains any subfolder
                        $directories = File::directories($extractpath);
                        //$directories = glob($extractpath. '/*' , GLOB_ONLYDIR);
                        if (!empty($directories)) { //if extract folder contains subfolder
                            $success = File::deleteDirectory($extractpath); //remove extracted folder and it's subfolder from lang
                            //$success2 = File::delete($destinationPath.'/'.$name);
                            if ($success) {
                                //sending back with error message
                                Session::flash('fails', Lang::get('lang.zipp-error'));
                                Session::flash('link2', 'http://www.ladybirdweb.com/support/show/how-to-translate-faveo-into-multiple-languages');

                                return Redirect::back()->withInput();
                            }
                        } else {
                            // sending back with success message
                            Session::flash('success', Lang::get('lang.upload-success'));
                            Session::flash('link', 'change-language/'.strtolower(Input::get('iso-code')));

                            return Redirect::route('LanguageController');
                        }
                    } else {
                        // sending back with error message.
                        Session::flash('fails', Lang::get('lang.file-error'));

                        return Redirect::route('form');
                    }
                }
            }
        } catch (\Exception $e) {
            Session::flash('fails', $e->getMessage());
            Redirect::back()->withInput();
        }
    }

    /**
     * allow user to download language template file.
     *
     * @return type
     */
    public function download()
    {
        $path = 'downloads'.DIRECTORY_SEPARATOR.'en.zip';
        $file_path = public_path($path);

        return response()->download($file_path);
    }

    /**
     * This function is used to delete languages.
     *
     * @param type $lang
     *
     * @return type response
     */
    public function deleteLanguage($lang)
    {
        if ($lang !== App::getLocale()) {
            if ($lang !== Config::get('app.fallback_locale')) {
                $deletePath = base_path('resources/lang').'/'.$lang;     //define file path to delete
                $success = File::deleteDirectory($deletePath); //remove extracted folder and it's subfolder from lang
                if ($success) {
                    //sending back with success message
                    Session::flash('success', Lang::get('lang.delete-success'));

                    return Redirect::back();
                } else {
                    //sending back with error message
                    Session::flash('fails', Lang::get('lang.lang-doesnot-exist'));

                    return Redirect::back();
                }
            } else {
                Session::flash('fails', Lang::get('lang.lang-fallback-lang'));

                return redirect('languages');
            }
        } else {
            Session::flash('fails', Lang::get('lang.active-lang-error'));

            return redirect('languages');
        }
    }
}
