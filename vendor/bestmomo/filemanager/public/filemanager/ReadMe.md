Filemanager
========================

FM is an open-source file manager released under MIT license. It is an alternative to elfinder or CKFinder.

Support
-------

Filemanager is under free license. If you want to support the filemanager development or just thank its main maintainer by paying a beer, you can make a donation by clicking the following button : 
[![Donate](https://www.paypal.com/en_US/i/btn/x-click-but21.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=2M5GWH9NLNEZL) 



Main features
-------------

* A Filemanager relying on jquery.
* Available in more than 20 languages.
* [Highly customizable](https://github.com/simogeo/Filemanager/wiki/Filemanager-configuration-file)
* Can work as standalone application
* Easy integration with RTE like CKEditor, TinyMCE and so on.
* Easy integration with [colorbox jquery plugin](https://github.com/simogeo/Filemanager/wiki/How-to-use-the-filemanager-with-colorbox-%3F) or [HTML simple textfield](https://github.com/simogeo/Filemanager/wiki/How-to-use-the-filemanager-from-a-simple-textfield-%3F)
* Several computer language connectors available. **PHP is up-to-date**
* Ability to upload, delete, modify, download and move files
* Ability to create folders
* Support user permissions - based on session
* Handle system permissions
* Ability to pass config user file in URL
* Multiple uploads support - based on [dropzonejs](http://www.dropzonejs.com)
* Online text / code edition - based on [codeMirror](http://codemirror.net/)
* Online documents viewer - based on [viewerJS](http://viewerjs.org/)
* [Opening a given folder](https://github.com/simogeo/Filemanager/wiki/How-to-open-a-given-folder-different-from-root-folder-when-opening-the-filemanager%3F)
* [Opening exclusively a given folder](https://github.com/simogeo/Filemanager/wiki/How-to-open-%28exclusively%29-a-given-subfolder-%3F)
* [Passing parameters to the FM](https://github.com/simogeo/Filemanager/wiki/Passing-parameters-to-the-FM)
* [File types restriction](https://github.com/simogeo/Filemanager/wiki/Set-up-upload-restriction-on-file-type)
* Video and audio player relying on web browser capabilities
* Textbox Search filter
* Thumbnails generation
* Image auto-resize
* File size limit
* File exclusion based on name and patterns
* Images files only
* Prevent files overwriting (or not)
* Switch from list to grid view and vice-versa
* Copy direct file URL
* [CSS Themes](https://github.com/simogeo/Filemanager/wiki/Create-your-own-theme) - **Please, share your themes with others !**
* and more ...


Screenshot
-------------

![Filemanager Screenshot](http://i57.tinypic.com/35cqw74.png)


Documentation
-------------

Filemanager is highly documented on the [wiki pages](https://github.com/simogeo/Filemanager/wiki). API, see below.


Installation and Setup
----------------------

**Preamble**

Since many changes have been done recently, only PHP and MVC connectors are now available. You can try the latest version for others connectors, but with no warranty they implement all features and work correctly.

To use other connectors, please download v0.8 version from https://github.com/simogeo/Filemanager/archive/v0.8.zip
(PHP, ASHX, ASP, CFM, lasso, PL and JSP connectors are available)

A JSP/Java connector implementation is available at : https://github.com/th-schwarz/C5Connector.Java 

---

**(1)** Check out a copy of the FileManager from the repository using Git :

git clone http://github.com/simogeo/Filemanager.git

or download the archive from Github : https://github.com/simogeo/Filemanager/archive/master.zip

You can place the FileManager anywhere within your web serving root directory.

**(2)** Make a copy of the default configuration file ("filemanager.config.js.default" located in the scripts directory), removing the '.default' from the end of the filename, and edit the options according to the following wiki page : https://github.com/simogeo/Filemanager/wiki/Filemanager-configuration-file
   Having a look on configuration cases study may also be helpful to you : https://github.com/simogeo/Filemanager/wiki/Specify-user-folder%2C-configuration-cases

**(3a)** If you are integrating the FileManager with FCKEditor, open your fckconfig.js file and find the lines which specify what file browser to use for images, links, etc. Look toward the bottom of the file. You will need to change lines such as this:

```javascript
FCKConfig.ImageBrowser = false ;
FCKConfig.ImageBrowserURL = FCKConfig.BasePath + 'filemanager/browser/default/browser.html?Type=Image&Connector=../../connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ;
```

...to this:

```javascript
FCKConfig.ImageBrowser = true ;
FCKConfig.ImageBrowserURL = '[Path to Filemanager]/index.html' ;
```

**(3b)** If you are integrating the FileManager with CKEditor 3.x or higher, simply set the URL when you configure your instance, like so:

```javascript
CKEDITOR.replace('instancename', {
	filebrowserBrowseUrl: '[Path to Filemanager]/index.html',
	...other configuration options...
});
```

If you want to use the **modal dialog mode** (instead of pop-up), please refer to [the dedicated wiki page](https://github.com/simogeo/Filemanager/wiki/How-to-open-the-Filemanager-from-CKEditor-in-a-modal-window-%3F).

**(3c)** If you are integrating the FileManager with TinyMCE (>= 3.0), you should:

Create a Javascript callback function that will open the FileManager index.html base page (see URL below for examples)
Add a line like: "file_browser_callback : 'name_of_callback_function'" in the tinyMCE.init command
See http://www.tinymce.com/wiki.php/TinyMCE3x:How-to_implement_a_custom_file_browser for more details.

See also the dedicated wiki page, with TinyMCE 4 sample : https://github.com/simogeo/Filemanager/wiki/How-to-use-the-Filemanager-with-tinyMCE--3-or-4-%3F


**(4)** Last but not least, **worry about security**!

For **PHP connector** : copy/paste the `/connectors/php/default.config.php` to `/connectors/php/user.config.php` to define your own authentication function.
To do so, you will find an example on the [dedicated wiki page](https://github.com/simogeo/Filemanager/wiki/Security-concern).

**jQuery dependency and compatibility**

We try to keep updating jQuery core library regularly.
If, for any reason, you can't use the embedded jQuery version just now that the Filemanager will probably work with a jQuery version >= 1.6.
You'll have to use the [jQuery.migrate() plugin](https://github.com/jquery/jquery-migrate) to use it with jQuery version 1.9+.


Set-up & security
-----------------

**Important** : The Filemanager is designed to work without any special configuration but **using it without any configuration is VERY unsafe**.
Please set-up your own **authentication function**, based on [default file](https://github.com/simogeo/Filemanager/blob/master/connectors/php/default.config.php) and refering to the [dedicated wiki page](https://github.com/simogeo/Filemanager/wiki/Security-concern).


API
---


Connector Location
------------------
You can create a connector for your server side language of choice by following this simple API. You must have a script at the following location which can respond to HTTP GET requests by returning an appropriate JSON object:

	[path to FileManager]/connectors/[language extension]/filemanager.[language extension]

FileManager currently includes connectors for PHP, MVC, JSP, lasso, ASP, ASHX, PL and CFM in the following locations:

	PHP: .../connectors/php/filemanager.php
	ASP.NET MVC Framework .../connectors/mvc/FilemanagerController.cs
	JSP: .../connectors/jsp/filemanager.jsp
	lasso: .../connectors/lasso/filemanager.lasso
	ASP: .../connectors/asp/filemanager.asp
	ASHX: .../connectors/ashx/filemanager.asp
	PL: .../connectors/pl/filemanager.pl
	CFM: .../connectors/cfm/filemanager.cfm

As long as a script exists at this location to respond to requests, you may split up the code (external libraries, configuration files, etc.) however you see fit.


Error Handling
--------------
Every response should include two keys specific to error handling: Error, and Code. If an error occurs in your script, you may populate these keys with whatever values you feel are most appropriate. If there is no error, Error should remain empty or null, and Code should be empty, null, or zero (0). Do not use zero for any actual errors. The following example would be an appropriate response if the connector uses an external file for configuration (recommended), but that file cannot be found:

```json
{
  "Error": "Configuration file missing.",
  "Code":  -1
}
```

Methods
-------
Your script should include support for the following methods/functions. GET requests from FileManager include a parameter "mode" which will indicate which type of response to return. Additional parameters will provide other information required to fulfill the request, such as the current directory.

getinfo
-------
The `getinfo` method returns information about a single file. Requests with mode "getinfo" will include an additional parameter, "path", indicating which file to inspect. A boolean parameter "getsize" indicates whether the dimensions of the file (if an image) should be returned. 

Example Request:

	[path to connector]?mode=getinfo&path=/UserFiles/Image/logo.png&getsize=true

Example Response:

```json
{
  "Path": "/UserFiles/Image/logo.png",
  "Filename": "logo.png",
  "File Type": "png",
  "Preview": "/UserFiles/Image/logo.png",
  "Protected": 0,
  "Properties": {
    "Date Created": null,
    "Date Modified": "02/09/2007 14:01:06",
    "filemtime": 1360237058,
    "Height": 14,
    "Width": 14,
    "Size": 384
  },
  "Error": "",
  "Code": 0
}
```

The keys are as follows:

	Path: The path to the file. Should match what was passed in the request.

	Filename: The name of the file, i.e., the last part of the path.

	File Type: The file extension, "dir" if a directory, or "txt" if missing/unknown.

	Preview: Path to a preview image. If the file is an image that can be displayed in a web browser (i.e., gif, jpg, or png), you should return the path to the image. Otherwise, check to see if there is a matching file icon based on the file extension, constructing the path like so:
	
		Directories: images/fileicons/_Open.png		
		Files: images/fileicons/[extension].png		
		Unknown: images/fileicons/default.png
		
	Protected: Indicates if the file has some reading / writing restrictions. If not, set to 0. Else set to 1. 
	
	Properties: A nested JSON object containing specific properties of the file.
	
		Date Created: The file's creation date, if available.
		Date Modified: The file's modification date, if available.
		Height: If an image, the height in pixels.
		Width: If an image, the width in pixels.
		Size: The file size in bytes.
	
	Capabilities (optional): You can limit the operation buttons shown for a specific file. It is an array containing ['select','delete','rename','download'] (for all capabilities), or [] (for no capabilities). If not present, all capabilities are enabled.
	
	Error: An error message, or empty/null if there was no error.
	
	Code: An error code, or 0 if there was no error.


getfolder
---------
The `getfolder` method returns an array of file and folder objects representing the contents of the given directory (indicated by a "path" parameter). It should call the getinfo method to retrieve the properties of each file. A boolean parameter "getsizes" indicates whether image dimensions should be returned for each item. Folders should always be returned before files.
Optionally a "type" parameter can be specified to restrict returned files (depending on the connector). If a "type" parameter is given for the main index.html URL, the same parameter value is reused and passed to getfolder. This can be used for example to only show image files in a file system tree.

Example Request:

	[path to connector]?mode=getfolder&path=/UserFiles/Image/&getsizes=true&type=images

Example Response:

```json
{
  "/UserFiles/Image/logo.png": {
    "Path": "/UserFiles/Image/logo.png",
    "Filename": "logo.png",
    "File Type": "png",
    "Preview": "/UserFiles/Image/logo.png",
    "Protected": 0,
    "Properties": {
      "Date Created": null,
      "Date Modified": "02/09/2007 14:01:06",
      "filemtime": 1360237058,
      "Height": 14,
      "Width": 14,
      "Size": 384
    },
    "Error": "",
    "Code": 0
  },
  "/UserFiles/Image/icon.png": {
    "Path": "/UserFiles/Image/icon.png",
    "Filename": "icon.png",
    "File Type": "png",
    "Preview": "/UserFiles/Image/icon.png",
    "Properties": {
      "Date Created": null,
      "Date Modified": "02/09/2007 14:01:06",
      "filemtime": 1360237058,
      "Height": 14,
      "Width": 14,
      "Size": 384
    },
    "Error": "",
    "Code": 0
  },
  "/UserFiles/folder/":{
    "Path":"/UserFiles/folder/",
    "Filename":"folder",
    "File Type":"dir",
    "Preview":"images\/fileicons\/_Open.png",
    "Properties": {
      "Date Created":null,
      "Date Modified": "02/09/2007 14:01:06",
      "filemtime": 1360237058,
      "Height":null,
      "Width":null,
      "Size":null
    },
    "Error":"",
    "Code":0
  }
}
```

Each key in the array is the path to an individual item, and the value is the file object for that item.


rename
------
The `rename` method renames the item at the path given in the "old" parameter with the name given in the "new" parameter and returns an object indicating the results of that action.

Example Request:

	[path to connector]?mode=rename&old=/UserFiles/Image/logo.png&new=id.png

Example Response:

```json
{
  "Error": "No error",
  "Code": 0,
  "Old Path": "/a_folder_renamed/thisisareallylongincrediblylongfilenamefortesting.txt",
  "Old Name": "thisisareallylongincrediblylongfilenamefortesting.txt",
  "New Path": "/a_folder_renamed/a_renamed_file",
  "New Name": "a_renamed_file"
}
```

move
------
The `move` method move "old" file or directory to specified "new" directory. It is possible to specify absolute path from fileRoot dir or relative path from "old" item. "root" value is mandatory to secure that relative paths don't get above fileRoot.

Example Request: Move file
	
	[path to connector]?mode=move&old=/uploads/images/original/Image/logo.png&new=/moved/&root=/uploads/images/

Example Response:

```json
{
  "Error": "No error",
  "Code": 0,
  "Old Path": "/uploads/images/original/Image/",
  "Old Name": "logo.png",
  "New Path": "/uploads/images/moved/",
  "New Name": "logo.png"
}
```

Example Request: Move directory to not existing directory (will be created)
	
	[path to connector]?mode=move&old=/uploads/images/original/Image&new=../new_dir/&root=/uploads/images/

Example Response:

```json
{
  "Error": "No error",
  "Code": 0,
  "Old Path": "/uploads/images/original/",
  "Old Name": "Image",
  "New Path": "/uploads/new_dir/",
  "New Name": "Image"
}
```



delete
------
The `delete` method deletes the item at the given path.

Example Request:

	[path to connector]?mode=delete&path=/UserFiles/Image/logo.png

Example Response:

```json
{
  "Error": "No error",
  "Code": 0,
  "Path": "/UserFiles/Image/logo.png"
}
```

add
---
The `add` method adds the uploaded file to the specified path. Unlike the other methods, this method must return its JSON response wrapped in an HTML `<textarea>`, so the MIME type of the response is text/html instead of text/plain. The upload form in the File Manager passes the current path as a POST param along with the uploaded file. The response includes the path as well as the name used to store the file. The uploaded file's name should be safe to use as a path component in a URL, so URL-encoded at a minimum.

Example Response:

```json
{
  "Path": "/UserFiles/Image/",
  "Name": "new_logo.png",
  "Error": "No error",
  "Code": 0
}
```

replace
---
The `replace` method allow the user to replace a specific file whatever the new filename - at least, the new file should have the same extension the original has. The old file is automatically overwritten. Unlike the other methods, this method must return its JSON response wrapped in an HTML `<textarea>`, so the MIME type of the response is text/html instead of text/plain. The *dynamic* upload form in the File Manager passes the current file path as a POST param along with the uploaded file. The response includes the path as well as the name used to store the file.

Example Response:

```json
{
  "Path": "/UserFiles/Image/",
  "Name": "new_logo.png",
  "Error": "No error",
  "Code": 0
}
```

editfile
--------
The `editfile` method returns the content of a given file (passed as parameter). It gives the user the ability to edit a file online (extensions are specified in configuration file). Handled as GET request.

Example request:

	[path to connector]?mode=editfile&path=/UserFiles/MyFolder/myfile.txt

Example Response:

```json
{
  "Error": "No error",
  "Code": 0,
  "Path": "/UserFiles/MyFolder/myfile.txt",
  "Content": "Content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n\Phasellus eu erat lorem.\r\n\r\n\Bye!"
}
```

savefile
--------
The `save` method will overwrite the content of the current file. The edit form in the File Manager passes the mode (as `savefile`), path of the current file and the content as POST parameters.

Example Response:

```json
{
  "Error": "No error",
  "Code": 0,
  "Path": "/UserFiles/MyFolder/myfile.txt"
}
```

preview
--------
The `preview` method serves the requested image for displaying. The image path is passed through the `path` parameter. If `thumbnail=true` parameter is passed, the method will return an image thumbnail. An extra parameter such as UNIX time can be added to the URL to prevent cache issue.

Example Request:

	[path to connector]?mode=preview&path=/UserFiles/new%20logo.png&thumbnail=true


addfolder
---------
The `addfolder` method creates a new directory on the server within the given path.

Example Request:

	[path to connector]?mode=addfolder&path=/UserFiles/&name=new%20logo.png

Example Response:

```json
{
  "Parent": "/UserFiles/",
  "Name": "new_logo.png",
  "Error": "No error",
  "Code": 0
}
```


download
--------
The `download` method serves the requested file to the user. We currently use a MIME type of "application/x-download" to force the file to be downloaded rather than displayed in a browser. In the future we may make exceptions for specific file types that often have in-browser viewers such as PDF's and various movie formats (Flash, Quicktime, etc.).

Example Request:

	[path to connector]?mode=download&path=/UserFiles/new%20logo.png

	
MIT LICENSE
---

Copyright (c) 2011-2013 Jason Huck, Simon Georget
http://opensource.org/licenses/MIT

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

 