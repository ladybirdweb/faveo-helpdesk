 ﻿/*
 Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */
 
 /**
  * @fileOverview The "filebrowser" plugin that adds support for file uploads and
  *               browsing.
  *
  * When a file is uploaded or selected inside the file browser, its URL is
  * inserted automatically into a field defined in the <code>filebrowser</code>
  * attribute. In order to specify a field that should be updated, pass the tab ID and
  * the element ID, separated with a colon.<br /><br />
  *
  * <strong>Example 1: (Browse)</strong>
  *
  * <pre>
  * {
  * 	type : 'button',
  * 	id : 'browse',
  * 	filebrowser : 'tabId:elementId',
  * 	label : editor.lang.common.browseServer
  * }
  * </pre>
  *
  * If you set the <code>filebrowser</code> attribute for an element other than
  * the <code>fileButton</code>, the <code>Browse</code> action will be triggered.<br /><br />
  *
  * <strong>Example 2: (Quick Upload)</strong>
  *
  * <pre>
  * {
  * 	type : 'fileButton',
  * 	id : 'uploadButton',
   * 	filebrowser : 'tabId:elementId',
   * 	label : editor.lang.common.uploadSubmit,
   * 	'for' : [ 'upload', 'upload' ]
   * }
   * </pre>
   *
   * If you set the <code>filebrowser</code> attribute for a <code>fileButton</code>
   * element, the <code>QuickUpload</code> action will be executed.<br /><br />
   *
   * The filebrowser plugin also supports more advanced configuration performed through
   * a JavaScript object.
   *
   * The following settings are supported:
   *
   * <ul>
   * <li><code>action</code> – <code>Browse</code> or <code>QuickUpload</code>.</li>
   * <li><code>target</code> – the field to update in the <code><em>tabId:elementId</em></code> format.</li>
   * <li><code>params</code> – additional arguments to be passed to the server connector (optional).</li>
   * <li><code>onSelect</code> – a function to execute when the file is selected/uploaded (optional).</li>
   * <li><code>url</code> – the URL to be called (optional).</li>
   * </ul>
   *
   * <strong>Example 3: (Quick Upload)</strong>
   *
   * <pre>
   * {
   * 	type : 'fileButton',
   * 	label : editor.lang.common.uploadSubmit,
   * 	id : 'buttonId',
 64  * 	filebrowser :
 65  * 	{
 66  * 		action : 'QuickUpload', // required
 67  * 		target : 'tab1:elementId', // required
 68  * 		params : // optional
 69  * 		{
 70  * 			type : 'Files',
 71  * 			currentFolder : '/folder/'
 72  * 		},
 73  * 		onSelect : function( fileUrl, errorMessage ) // optional
 74  * 		{
 75  * 			// Do not call the built-in selectFuntion.
 76  * 			// return false;
 77  * 		}
 78  * 	},
 79  * 	'for' : [ 'tab1', 'myFile' ]
 80  * }
 81  * </pre>
 82  *
 83  * Suppose you have a file element with an ID of <code>myFile</code>, a text
 84  * field with an ID of <code>elementId</code> and a <code>fileButton</code>.
 85  * If the <code>filebowser.url</code> attribute is not specified explicitly,
 86  * the form action will be set to <code>filebrowser[<em>DialogWindowName</em>]UploadUrl</code>
 87  * or, if not specified, to <code>filebrowserUploadUrl</code>. Additional parameters
 88  * from the <code>params</code> object will be added to the query string. It is
 89  * possible to create your own <code>uploadHandler</code> and cancel the built-in
 90  * <code>updateTargetElement</code> command.<br /><br />
 91  *
 92  * <strong>Example 4: (Browse)</strong>
 93  *
 94  * <pre>
 95  * {
 96  * 	type : 'button',
 97  * 	id : 'buttonId',
 98  * 	label : editor.lang.common.browseServer,
 99  * 	filebrowser :
100  * 	{
101  * 		action : 'Browse',
102  * 		url : '/ckfinder/ckfinder.html&type=Images',
103  * 		target : 'tab1:elementId'
104  * 	}
105  * }
106  * </pre>
107  *
108  * In this example, when the button is pressed, the file browser will be opened in a
109  * popup window. If you do not specify the <code>filebrowser.url</code> attribute,
110  * <code>filebrowser[<em>DialogName</em>]BrowseUrl</code> or
111  * <code>filebrowserBrowseUrl</code> will be used. After selecting a file in the file
112  * browser, an element with an ID of <code>elementId</code> will be updated. Just
113  * like in the third example, a custom <code>onSelect</code> function may be defined.
114  */
 ( function()
 {
 	/*
118 	 * Adds (additional) arguments to given url.
119 	 *
120 	 * @param {String}
121 	 *            url The url.
122 	 * @param {Object}
123 	 *            params Additional parameters.
124 	 */
 	function addQueryString( url, params )
 	{
 		var queryString = [];
 
 		if ( !params )
 			return url;
 		else
 		{
 			for ( var i in params )
 				queryString.push( i + "=" + encodeURIComponent( params[ i ] ) );
 		}
 
 		return url + ( ( url.indexOf( "?" ) != -1 ) ? "&" : "?" ) + queryString.join( "&" );
 	}
 
 	/*
141 	 * Make a string's first character uppercase.
142 	 *
143 	 * @param {String}
144 	 *            str String.
145 	 */
 	function ucFirst( str )
 	{
 		str += '';
 		var f = str.charAt( 0 ).toUpperCase();
 		return f + str.substr( 1 );
 	}
 
 	/*
154 	 * The onlick function assigned to the 'Browse Server' button. Opens the
155 	 * file browser and updates target field when file is selected.
156 	 *
157 	 * @param {CKEDITOR.event}
158 	 *            evt The event object.
159 	 */
 	function browseServer( evt )
 	{
 		var dialog = this.getDialog();
 		var editor = dialog.getParentEditor();
 
 		editor._.filebrowserSe = this;
 
 		var width = editor.config[ 'filebrowser' + ucFirst( dialog.getName() ) + 'WindowWidth' ]
				|| editor.config.filebrowserWindowWidth || '80%';
		var height = editor.config[ 'filebrowser' + ucFirst( dialog.getName() ) + 'WindowHeight' ]
 				|| editor.config.filebrowserWindowHeight || '70%';
 
 		var params = this.filebrowser.params || {};
 		params.CKEditor = editor.name;
 		params.CKEditorFuncNum = editor._.filebrowserFn;
 		if ( !params.langCode )
 			params.langCode = editor.langCode;
 
		var url = addQueryString( this.filebrowser.url, params );
		// TODO: V4: Remove backward compatibility (#8163).
 		editor.popup( url, width, height, editor.config.filebrowserWindowFeatures || editor.config.fileBrowserWindowFeatures );
 	}
 
 	/*
184 	 * The onlick function assigned to the 'Upload' button. Makes the final
185 	 * decision whether form is really submitted and updates target field when
186 	 * file is uploaded.
187 	 *
188 	 * @param {CKEDITOR.event}
189 	 *            evt The event object.
190 	 */
 	function uploadFile( evt )
 	{
 		var dialog = this.getDialog();
 		var editor = dialog.getParentEditor();
 
 		editor._.filebrowserSe = this;
 
 		// If user didn't select the file, stop the upload.
 		if ( !dialog.getContentElement( this[ 'for' ][ 0 ], this[ 'for' ][ 1 ] ).getInputElement().$.value )
 			return false;
 
 		if ( !dialog.getContentElement( this[ 'for' ][ 0 ], this[ 'for' ][ 1 ] ).getAction() )
 			return false;
 
 		return true;
 	}
 
 	/*
209 	 * Setups the file element.
210 	 *
211 	 * @param {CKEDITOR.ui.dialog.file}
212 	 *            fileInput The file element used during file upload.
213 	 * @param {Object}
214 	 *            filebrowser Object containing filebrowser settings assigned to
215 	 *            the fileButton associated with this file element.
216 	 */
 	function setupFileElement( editor, fileInput, filebrowser )
 	{
 		var params = filebrowser.params || {};
 		params.CKEditor = editor.name;
 		params.CKEditorFuncNum = editor._.filebrowserFn;
 		if ( !params.langCode )
 			params.langCode = editor.langCode;
 
 		fileInput.action = addQueryString( filebrowser.url, params );
 		fileInput.filebrowser = filebrowser;
 	}
 
 	/*
230 	 * Traverse through the content definition and attach filebrowser to
231 	 * elements with 'filebrowser' attribute.
232 	 *
233 	 * @param String
234 	 *            dialogName Dialog name.
235 	 * @param {CKEDITOR.dialog.definitionObject}
236 	 *            definition Dialog definition.
237 	 * @param {Array}
238 	 *            elements Array of {@link CKEDITOR.dialog.definition.content}
239 	 *            objects.
240 	 */
 	function attachFileBrowser( editor, dialogName, definition, elements )
 	{
 		var element, fileInput;
 
 		for ( var i in elements )
 		{
 			element = elements[ i ];
 
 			if ( element.type == 'hbox' || element.type == 'vbox' || element.type == 'fieldset' )
 				attachFileBrowser( editor, dialogName, definition, element.children );
 
 			if ( !element.filebrowser )
 				continue;
 
 			if ( typeof element.filebrowser == 'string' )
 			{
 				var fb =
 				{
 					action : ( element.type == 'fileButton' ) ? 'QuickUpload' : 'Browse',
 					target : element.filebrowser
 				};
 				element.filebrowser = fb;
 			}
 
 			if ( element.filebrowser.action == 'Browse' )
 			{
 				var url = element.filebrowser.url;
 				if ( url === undefined )
 				{
 					url = editor.config[ 'filebrowser' + ucFirst( dialogName ) + 'BrowseUrl' ];
 					if ( url === undefined )
 						url = editor.config.filebrowserBrowseUrl;
 				}
 
 				if ( url )
 				{
 					element.onClick = browseServer;
 					element.filebrowser.url = url;
 					element.hidden = false;
 				}
 			}
 			else if ( element.filebrowser.action == 'QuickUpload' && element[ 'for' ] )
 			{
 				url = element.filebrowser.url;
 				if ( url === undefined )
 				{
 					url = editor.config[ 'filebrowser' + ucFirst( dialogName ) + 'UploadUrl' ];
 					if ( url === undefined )
 						url = editor.config.filebrowserUploadUrl;
 				}
 
 				if ( url )
 				{
 					var onClick = element.onClick;
 					element.onClick = function( evt )
 					{
 						// "element" here means the definition object, so we need to find the correct
 						// button to scope the event call
 						var sender = evt.sender;
 						if ( onClick && onClick.call( sender, evt ) === false )
 							return false;
 
 						return uploadFile.call( sender, evt );
 					};
 
 					element.filebrowser.url = url;
 					element.hidden = false;
 					setupFileElement( editor, definition.getContents( element[ 'for' ][ 0 ] ).get( element[ 'for' ][ 1 ] ), element.filebrowser );
 				}
 			}
 		}
 	}
 
 	/*
315 	 * Updates the target element with the url of uploaded/selected file.
316 	 *
317 	 * @param {String}
318 	 *            url The url of a file.
319 	 */
 	function updateTargetElement( url, sourceElement )
 	{
 		var dialog = sourceElement.getDialog();
 		var targetElement = sourceElement.filebrowser.target || null;
 
 		// If there is a reference to targetElement, update it.
 		if ( targetElement )
 		{
 			var target = targetElement.split( ':' );
 			var element = dialog.getContentElement( target[ 0 ], target[ 1 ] );
 			if ( element )
 			{
 				element.setValue( url );
 				dialog.selectPage( target[ 0 ] );
 			}
 		}
 	}
 
 	/*
339 	 * Returns true if filebrowser is configured in one of the elements.
340 	 *
341 	 * @param {CKEDITOR.dialog.definitionObject}
342 	 *            definition Dialog definition.
343 	 * @param Stri344 	 *            tabId The tab id where element(s) can be found.
345 	 * @param String
346 	 *            elementId The element id (or ids, separated with a semicolon) to check.
347 	 */
 	function isConfigured( definition, tabId, elementId )
 	{
 		if ( elementId.indexOf( ";" ) !== -1 )
 		{
 			var ids = elementId.split( ";" );
 			for ( var i = 0 ; i < ids.length ; i++ )
 			{
 				if ( isConfigured( definition, tabId, ids[i] ) )
 					return true;
 			}
 			return false;
 		}
 
 		var elementFileBrowser = definition.getContents( tabId ).get( elementId ).filebrowser;
 		return ( elementFileBrowser && elementFileBrowser.url );
 	}
 
 	function setUrl( fileUrl, data )
 	{
 		var dialog = this._.filebrowserSe.getDialog(),
 			targetInput = this._.filebrowserSe[ 'for' ],
 			onSelect = this._.filebrowserSe.filebrowser.onSelect;
 
 		if ( targetInput )
 			dialog.getContentElement( targetInput[ 0 ], targetInput[ 1 ] ).reset();
 
 		if ( typeof data == 'function' && data.call( this._.filebrowserSe ) === false )
 			return;
 
 		if ( onSelect && onSelect.call( this._.filebrowserSe, fileUrl, data ) === false )
 			return;
 
 		// The "data" argument may be used to pass the error message to the editor.
 		if ( typeof data == 'string' && data )
 			alert( data );
 
 		if ( fileUrl )
 			updateTargetElement( fileUrl, this._.filebrowserSe );
 	}
 
 	CKEDITOR.plugins.add( 'filebrowser',
 	{
 		init : function( editor, pluginPath )
 		{
 			editor._.filebrowserFn = CKEDITOR.tools.addFunction( setUrl, editor );
 			editor.on( 'destroy', function () { CKEDITOR.tools.removeFunction( this._.filebrowserFn ); } );
 		}
 	} );
 
 	CKEDITOR.on( 'dialogDefinition', function( evt )
 	{
 		var definition = evt.data.definition,
 			element;
 		// Associate filebrowser to elements with 'filebrowser' attribute.
 		for ( var i in definition.contents )
 		{
 			if ( ( element = definition.contents[ i ] ) )
 			{
 				attachFileBrowser( evt.editor, evt.data.name, definition, element.elements );
 				if ( element.hidden && element.filebrowser )
 				{
 					element.hidden = !isConfigured( definition, element[ 'id' ], element.filebrowser );
 				}
 			}
 		}
 	} );
 
 } )();
 
 /**
418  * The location of an external file browser that should be launched when the <strong>Browse Server</strong>
419  * button is pressed. If configured, the <strong>Browse Server</strong> button will appear in the
420  * <strong>Link</strong>, <strong>Image</strong>, and <strong>Flash</strong> dialog windows.
421  * @see The <a href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)">File Browser/Uploader</a> documentation.
422  * @name CKEDITOR.config.filebrowserBrowseUrl
423  * @since 3.0
424  * @type String
425  * @default <code>''</code> (empty string = disabled)
426  * @example
427  * config.filebrowserBrowseUrl = '/browser/browse.php';
428  */
 
 /**
431  * The location of the script that handles file uploads.
432  * If set, the <strong>Upload</strong> tab will appear in the <strong>Link</strong>, <strong>Image</strong>,
433  * and <strong>Flash</strong> dialog windows.
434  * @name CKEDITOR.config.filebrowserUploadUrl
435  * @see The <a href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)">File Browser/Uploader</a> documentation.
436  * @since 3.0
437  * @type String
438  * @default <code>''</code> (empty string = disabled)
439  * @example
440  * config.filebrowserUploadUrl = '/uploader/upload.php';
441  */
 
 /**
444  * The location of an external file browser that should be launched when the <strong>Browse Server</strong>
445  * button is pressed in the <strong>Image</strong> dialog window.
446  * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserBrowseUrl}</code>.
447  * @name CKEDITOR.config.filebrowserImageBrowseUrl
448  * @since 3.0
449  * @type String
450  * @default <code>''</code> (empty string = disabled)
451  * @example
452  * config.filebrowserImageBrowseUrl = '/browser/browse.php?type=Images';
453  */
 
 /**
456  * The location of an external file browser that should be launched when the <strong>Browse Server</strong>
457  * button is pressed in the <strong>Flash</strong> dialog window.
458  * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserBrowseUrl}</code>.
459  * @name CKEDITOR.config.filebrowserFlashBrowseUrl
460  * @since 3.0
461  * @type String
462  * @default <code>''</code> (empty string = disabled)
463  * @example
464  * config.filebrowserFlashBrowseUrl = '/browser/browse.php?type=Flash';
465  */
 
 /**
468  * The location of the script that handles file uploads in the <strong>Image</strong> dialog window.
469  * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserUploadUrl}</code>.
470  * @name CKEDITOR.config.filebrowserImageUploadUrl
471  * @since 3.0
472  * @type String
473  * @default <code>''</code> (empty string = disabled)
474  * @example
475  * config.filebrowserImageUploadUrl = '/uploader/upload.php?type=Images';
476  */
 
 /**
479  * The location of the script that handles file uploads in the <strong>Flash</strong> dialog window.
480  * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserUploadUrl}</code>.
481  * @name CKEDITOR.config.filebrowserFlashUploadUrl
482  * @since 3.0
483  * @type String
484  * @default <code>''</code> (empty string = disabled)
485  * @example
486  * config.filebrowserFlashUploadUrl = '/uploader/upload.php?type=Flash';
487  */
 
 /**
490  * The location of an external file browser that should be launched when the <strong>Browse Server</strong>
491  * button is pressed in the <strong>Link</strong> tab of the <strong>Image</strong> dialog window.
492  * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserBrowseUrl}</code>.
493  * @name CKEDITOR.config.filebrowserImageBrowseLinkUrl
494  * @since 3.2
495  * @type String
496  * @default <code>''</code> (empty string = disabled)
497  * @example
498  * config.filebrowserImageBrowseLinkUrl = '/browser/browse.php';
499  */
 
 /**
502  * The features to use in the file browser popup window.
503  * @name CKEDITOR.config.filebrowserWindowFeatures
504  * @since 3.4.1
505  * @type String
506  * @default <code>'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes'</code>
507  * @example
508  * config.filebrowserWindowFeatures = 'resizable=yes,scrollbars=no';
509  */
 
 /**
512  * The width of the file browser popup window. It can be a number denoting a value in
513  * pixels or a percent string.
514  * @name CKEDITOR.config.filebrowserWindowWidth
515  * @type Number|String
516  * @default <code>'80%'</code>
517  * @example
518  * config.filebrowserWindowWidth = 750;
519  * @example
520  * config.filebrowserWindowWidth = '50%';
521  */
 
 /**
524  * The height of the file browser popup window. It can be a number denoting a value in
525  * pixels or a percent string.
526  * @name CKEDITOR.config.filebrowserWindowHeight
527  * @type Number|String
528  * @default <code>'70%'</code>
529  * @example
530  * config.filebrowserWindowHeight = 580;
531  * @example
532  * config.filebrowserWindowHeight = '50%';
533  */
 