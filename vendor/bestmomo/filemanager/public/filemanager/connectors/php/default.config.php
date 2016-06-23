<?php
/**
 *  Filemanager PHP connector
 *  This file should at least declare auth() function 
 *  and instantiate the Filemanager as '$fm'
 *  
 *  IMPORTANT : by default Read and Write access is granted to everyone
 *  Copy/paste this file to 'user.config.php' file to implement your own auth() function
 *  to grant access to wanted users only
 *
 *  filemanager.php
 *  use for ckeditor filemanager
 *
 *  @license  MIT License
 *  @author   Simon Georget <simon (at) linea21 (dot) com>
 *  @copyright  Authors
 */

// Laravel init
require getcwd() . '/../../../../bootstrap/autoload.php';
$app = require_once getcwd() . '/../../../../bootstrap/app.php';

$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

$response = $kernel->handle(
  $request = Illuminate\Http\Request::capture()
);

$id = $app['encrypter']->decrypt($_COOKIE[$app['config']['session.cookie']]);
$app['session']->driver()->setId($id);
$app['session']->driver()->start();

// Folder path
$folderPath = config('filemanager.folder_path');   

// Check if user in authentified
if(!$app['auth']->check()) 
{
  $laravelAuth = false;
} 
else 
{
  // Check if user has all access
  if($app['auth']->user()->accessMediasAll())
  {
    $laravelAuth = true; 
  } 
  elseif(method_exists($app['auth']->user(), 'accessMediasFolder'))
  {
    // Check if user has access to one folder
    if($app['auth']->user()->accessMediasFolder())
    {
      // Folder name with user id
      $folderPath .= 'user' . $app['auth']->id();
      $laravelAuth = true;  
    } 
    else
    {
      $laravelAuth = false;
    }    
  }
  else
  {
    $laravelAuth = false;
  } 
}

/**
 *  Check if user is authorized
 *  
 *
 *  @return boolean true if access granted, false if no access
 */
function auth() 
{
  return $GLOBALS['laravelAuth'];
}

$fm = new Filemanager();

$fm->setFileRoot($folderPath, true);

?>