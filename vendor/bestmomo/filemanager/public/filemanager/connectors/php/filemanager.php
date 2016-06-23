<?php
// only for debug
// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
// ini_set('display_errors', '1');
/**
 *	Filemanager PHP connector
 *
 *	filemanager.php
 *	use for ckeditor filemanager plug-in by Core Five - http://labs.corefive.com/Projects/FileManager/
 *
 *	@license	MIT License
 *	@author		Riaan Los <mail (at) riaanlos (dot) nl>
 *  @author		Simon Georget <simon (at) linea21 (dot) com>
 *	@copyright	Authors
 */

require_once('filemanager.class.php');

// for php 5.2 compatibility
if (!function_exists('array_replace_recursive')) {
	function array_replace_recursive($array, $array1) {
		function recurse($array, $array1) {
			foreach($array1 as $key => $value) {
				// create new key in $array, if it is empty or not an array
				if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) {
					$array[$key] = array();
				}

				// overwrite the value in the base array
				if (is_array($value)) {
					$value = recurse($array[$key], $value);
				}
				$array[$key] = $value;
			}
			return $array;
		}

		// handle the arguments, merge one by one
		$args = func_get_args();
		$array = $args[0];
		if (!is_array($array)) {
			return $array;
		}
		for ($i = 1; $i < count($args); $i++) {
			if (is_array($args[$i])) {
				$array = recurse($array, $args[$i]);
			}
		}
		return $array;

	}
}

// if user file is defined we include it, else we include the default file
(file_exists('user.config.php')) ? include_once('user.config.php') : include_once('default.config.php');

// auth() function is already defined
// and Filemanager is instantiated as $fm

$response = '';

if(!auth()) {
  $fm->error($fm->lang('AUTHORIZATION_REQUIRED'));
}

if(!isset($_GET)) {
  $fm->error($fm->lang('INVALID_ACTION'));
} else {

  if(isset($_GET['mode']) && $_GET['mode']!='') {

    switch($_GET['mode']) {
      	
      default:

        $fm->error($fm->lang('MODE_ERROR'));
        break;

      case 'getinfo':

        if($fm->getvar('path')) {
          $response = $fm->getinfo();
        }
        break;

      case 'getfolder':
        	
        if($fm->getvar('path')) {
          $response = $fm->getfolder();
        }
        break;

      case 'rename':

        if($fm->getvar('old') && $fm->getvar('new')) {
          $response = $fm->rename();
        }
        break;

      case 'move':
        // allow "../"
        if($fm->getvar('old') && $fm->getvar('new') && $fm->getvar('root')) {
          $response = $fm->move();
        }
        break;

      case 'editfile':
        	 
        if($fm->getvar('path')) {
        	$response = $fm->editfile();
        }
        break;
        
      case 'delete':

        if($fm->getvar('path')) {
          $response = $fm->delete();
        }
        break;

      case 'addfolder':

        if($fm->getvar('path') && $fm->getvar('name')) {
          $response = $fm->addfolder();
        }
        break;

      case 'download':
        if($fm->getvar('path')) {
          $fm->download();
        }
        break;
        
      case 'preview':
        if($fm->getvar('path')) {
        	if(isset($_GET['thumbnail'])) {
        		$thumbnail = true;
        	} else {
        		$thumbnail = false;
        	}
          $fm->preview($thumbnail);
        }
        break;
    }

  } else if(isset($_POST['mode']) && $_POST['mode']!='') {

    switch($_POST['mode']) {
      	
      default:

        $fm->error($fm->lang('MODE_ERROR'));
        break;
        	
      case 'add':

        if($fm->postvar('currentpath')) {
          $fm->add();
        }
        break;

    	case 'replace':
    
	    	if($fm->postvar('newfilepath')) {
	    		$fm->replace();
	    	}
	    	break;
    
	    case 'savefile':
	    	
	    	if($fm->postvar('content', false) && $fm->postvar('path')) {
	    		$response = $fm->savefile();
	    	}
	    	break;
    }

  }
}

echo json_encode($response);
die();
?>