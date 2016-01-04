<?php namespace App\Http\Controllers\Admin\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests;
use Illuminate\Http\Request;
//supports
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
//classes
use Input;
use Config;
use Validator;
use Zipper;
use App;
use Lang;
use Cache;
use File;

/**
 * SlaController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class LanguageController extends Controller {

    /**
     * Create a new controller instance.
     * @return type void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * Switch language at runtime
     * @param type "" $lang
     * @return type response
     */
    public function switchLanguage($lang) {
            //if(Cache::has('language'))
            //{
              //  return Cache::get('language');
            //} else return 'false';
           // Cache::put('language',$)

            if(array_key_exists($lang, Config::get('languages'))) {
                // dd(array_key_exists($lang, Config::get('languages')));
                // app()->setLocale($lang);

                    Cache::forever('language', $lang);
                // dd(Cache::get('language'));
                // dd()
            } else {
                return Redirect::back()->with('message', 'Language package not found in your lang directroy.');
            }
            return Redirect::back();
        }

   

    /**
     *Shows language page
     *@return type response
     */
    public function index(){
        return view('themes.default1.admin.helpdesk.language.index');
    }

   
    /**
     *Shows Language upload form
     *@return type response
     */
     public function getForm(){
        return view('themes.default1.admin.helpdesk.language.create');
    }
   

    /**
     *Provide language datatable to language page
     *@return type 
     */
    public function getLanguages()
    {
        $path = 'code/resources/lang';
        $values = scandir($path);  //Extracts names of directories present in lang directory
        $values = array_slice($values, 2); // skips array element $value[0] = '.' & $value[1] = '..' 
        return \Datatable::collection(new Collection($values))
        
        ->addColumn('language', function($model){
                return Config::get('languages.'.$model);
            })
        
        ->addColumn('id', function($model){
            return $model;
        })
        
        ->addColumn('status',function($model){
            if(Lang::getLocale()===$model){return "<span style='color:green'>".Lang::trans("lang.active")."</span>"; } else return "<span style='color:red'>".Lang::trans("lang.inactive")."</span>";
        })
        
        ->addColumn('Action', function($model){
            if(Lang::getLocale()===$model){
                return "<a href='change-language/".$model."'><input type='button' class='btn btn-info btn-xs btn-flat' disabled value='". Lang::trans("lang.disable")."'/></a>  
                <a href='change-language/".$model."' class='btn btn-danger btn-xs btn-flat' disabled><i class='fa fa-trash' style='color:black;'> </i> ". Lang::trans("lang.delete")."</a>";
            } else {
                return "<a href='change-language/".$model."'><input type='button' class='btn btn-info btn-xs btn-flat' value='". Lang::trans("lang.enable")."'/></a>  
                <a href='delete-language/".$model."' class='btn btn-danger btn-xs btn-flat'><i class='fa fa-trash' style='color:black;'> </i> ". Lang::trans("lang.delete")."</a>";
            }
        })
        ->searchColumns('language','id')
        
        ->make();
    }
    

    /**
     *handle language file uploading
     *@return response  
     */
    public function postForm() {
        // getting all of the post data
        $file = array(
                    'File'          => Input::file('File'),
                    'language-name' => Input::input('language-name'),
                    'iso-code'      => Input::input('iso-code')
                );
        
        // setting up rules
        $rules = array( 
                        'File'          => 'required|mimes:zip|max:30000',
                        'language-name' => 'required',
                        'iso-code'      => 'required|max:2'  
                    ); // and for max size 
        
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            
            // send back to the page with the input data and errors
            return Redirect::back()->withInput()->withErrors($validator);
        
        } else {
            
            
            //Checking if package already exists or not in lang folder
            $path = 'code/resources/lang';
            if (in_array(Input::get('iso-code'), scandir($path))) {
                
                //sending back with error message
                Session::flash('fails', "Language package already exists.");
                Session::flash('link',"change-language/".Input::get('iso-code'));
                return Redirect::back()->withInput();
            
            } elseif (!array_key_exists(Input::get('iso-code'), Config::get('languages'))){//Checking Valid ISO code form Languages.php 
                
                //sending back with error message
                Session::flash('fails', "Enter correct ISO-code");
                return Redirect::back()->withInput();
            
            } else {
                
                // checking file is valid.
                if (Input::file('File')->isValid()) {
                    
                    $name = Input::file('File')->getClientOriginalName(); //uploaded file's original name
                    $destinationPath = 'code/public/uploads/'; // defining uploading path
                    $extractpath = 'code/resources/lang/'.Input::get('iso-code');//defining extracting path
                    mkdir($extractpath); //creating directroy for extracting uploadd file
                    //mkdir($destinationPath);
                    Input::file('File')->move($destinationPath, $name); // uploading file to given path
                    \Zipper::make($destinationPath.'/'.$name)->extractTo($extractpath);//extracting file to give path
                    
                    //check if Zip extract foldercontains any subfolder
                    $directories = File::directories($extractpath);
                    //$directories = glob($extractpath. '/*' , GLOB_ONLYDIR);
                    if(!empty($directories)){ //if extract folder contains subfolder
                        $success = File::deleteDirectory($extractpath); //remove extracted folder and it's subfolder from lang
                        //$success2 = File::delete($destinationPath.'/'.$name);
                        
                        if($success){
                            //sending back with error message
                            Session::flash('fails', 'Error in directory structure. Zip file must contain language php files only. Try Again.');
                            return Redirect::back()->withInput();   
                        }
                    
                    } else {
                    
                    // sending back with success message
                    Session::flash('success', "uploaded successfully.");
                    Session::flash('link',"change-language/".Input::get('iso-code'));
                    return Redirect::route('LanguageController');
                    
                    }
                    
                } else {
                    
                    // sending back with error message.
                    Session::flash('fails', 'uploaded file is not valid');
                    return Redirect::route('form');

                }
                
            }
        }
    }


    /**
     *allow user to download language template file
     *@return type
     */
    Public function download()
    {
        return response()->download('code/public/downloads/en.zip');
    }

    /**
     * This function is used to delete languages
     * @param type $lang 
     * @return type response
     */
    public function deleteLanguage($lang){
        if($lang !== App::getLocale()){    
            $deletePath = 'code/resources/lang/'.$lang;     //define file path to delete
            $success = File::deleteDirectory($deletePath); //remove extracted folder and it's subfolder from lang
            if($success){
                //sending back with success message
                Session::flash('success', 'Language package deleted successfully.');
                return Redirect::back();   
            } else {
                //sending back with error message
                Session::flash('fails', 'Language package does not exist.');
                return Redirect::back(); 
            }
        } else {
            //sending back with error message
            Session::flash('fails', 'Language package can not be deleted when it is active.');
            return redirect('languages');    
        }
    }
   

}
