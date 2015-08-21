<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

//Route::get('/', 'WelcomeController@index');
//Route::get('/', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
// Route::get('login','Auth\AuthController@getLogin');

$router->get('getmail/{token}', 'Auth\AuthController@getMail');

/*
|-------------------------------------------------------------------------------
|Admin Routes
|-------------------------------------------------------------------------------
| Here is defining entire routes for the Admin Panel
|
|
 */

// To get the dash board
//Route::get('dashboard', 'HomeController@index');

Route::group(['middleware' => 'roles', 'middleware' => 'auth'], function () {
	// resource is a function to process create,edit,read and delete
	Route::resource('groups', 'Admin\GroupController'); // for group module, for CRUD

	Route::resource('departments', 'Admin\DepartmentController'); // for departments module, for CRUD

	Route::resource('teams', 'Admin\TeamController'); // in teams module, for CRUD

	Route::resource('agents', 'Admin\AgentController'); // in agents module, for CRUD

	Route::resource('emails', 'Admin\EmailsController'); // in emails module, for CRUD

	Route::resource('banlist', 'Admin\BanlistController'); // in banlist module, for CRUD

	Route::resource('template', 'Admin\TemplateController'); // in template module, for CRUD

	Route::get('getdiagno', 'Admin\TemplateController@formDiagno'); // for getting form for diagnostic

	Route::post('postdiagno', 'Admin\TemplateController@postDiagno'); // for getting form for diagnostic

	Route::resource('helptopic', 'Admin\HelptopicController'); // in helptopics module, for CRUD

	Route::resource('sla', 'Admin\SlaController'); // in SLA Plan module, for CRUD

	Route::resource('form', 'Admin\FormController'); // in Form module, for CRUD
	//$router->model('id','getcompany');

	Route::get('getcompany', 'Admin\SettingsController@getcompany'); // direct to company setting page

	Route::patch('postcompany/{id}', 'Admin\SettingsController@postcompany'); // Updating the Company table with requests

	Route::get('getsystem', 'Admin\SettingsController@getsystem'); // direct to system setting page

	Route::patch('postsystem/{id}', 'Admin\SettingsController@postsystem'); // Updating the System table with requests

	Route::get('getticket', 'Admin\SettingsController@getticket'); // direct to ticket setting page

	Route::patch('postticket/{id}', 'Admin\SettingsController@postticket'); // Updating the Ticket table with requests

	Route::get('getemail', 'Admin\SettingsController@getemail'); // direct to email setting page

	Route::patch('postemail/{id}', 'Admin\SettingsController@postemail'); // Updating the Email table with requests

	Route::get('getaccess', 'Admin\SettingsController@getaccess'); // direct to access setting page

	Route::patch('postaccess/{id}', 'Admin\SettingsController@postaccess'); // Updating the Access table with requests

	Route::get('getresponder', 'Admin\SettingsController@getresponder'); // direct to responder setting page

	Route::patch('postresponder/{id}', 'Admin\SettingsController@postresponder'); // Updating the Responder table with requests

	Route::get('getalert', 'Admin\SettingsController@getalert'); // direct to alert setting page

	Route::patch('postalert/{id}', 'Admin\SettingsController@postalert'); // Updating the Alert table with requests

	/*  User profile edit get  */
	Route::get('admin-profile', 'Admin\ProfileController@getProfile');

	/*  Admin profile get  */
	Route::get('admin-profile-edit', 'Admin\ProfileController@getProfileedit');

	/* Admin Profile Post */
	Route::patch('admin-profile', 'Admin\ProfileController@postProfileedit');

	/*  Admin Profile Password Post */
	Route::patch('admin-profile-password', 'Admin\ProfileController@postProfilePassword');

	/* get the create footer page for admin */
	Route::get('create-footer', 'SettingsController@CreateFooter');
	
	/* post footer to insert to database */
	Route::patch('post-create-footer/{id}', 'SettingsController@PostFooter');
	
	/* get the create footer page for admin */
	Route::get('create-footer2', 'SettingsController@CreateFooter2');
	
	/* post footer to insert to database */
	Route::patch('post-create-footer2/{id}', 'SettingsController@PostFooter2');
	
	/* get the create footer page for admin */
	Route::get('create-footer3', 'SettingsController@CreateFooter3');
	
	/* post footer to insert to database */
	Route::patch('post-create-footer3/{id}', 'SettingsController@PostFooter3');
	
	/* get the create footer page for admin */
	Route::get('create-footer4', 'SettingsController@CreateFooter4');
	
	/* post footer to insert to database */
	Route::patch('post-create-footer4/{id}', 'SettingsController@PostFooter4');

	/* get the create footer page for admin */
	Route::get('getsmtp',['as'=>'getsmtp','uses'=>'SettingsController@getsmtp']);
	
	/* post footer to insert to database */
	Route::post('post-smtp',['as'=>'post_smtp','uses'=>'SettingsController@postsmtp']);

});
/* calling ticket.blade.php file  */

// $router->get('tickets','Admin\ThreadController@getTickets');

/* calling timeline.blade.php file  */

Route::get('time', function () {
	return view('themes.default1.admin.tickets.timeline');
});

/*
|------------------------------------------------------------------
|Agent Routes
|--------------------------------------------------------------------
| Here defining entire Agent Panel routers
|
|
 */
Route::group(['middleware' => 'role.agent', 'middleware' => 'auth'], function () {
	/* User router is used to control the CRUD of user */
	Route::resource('user', 'Agent\UserController');

	/* organization router used to deal CRUD function of organization */
	Route::resource('organizations', 'Agent\OrganizationController');

	/*  User profile get  */
	Route::get('profile',['as'=>'profile' , 'uses'=> 'Agent\UserController@getProfile']);

	/*  User profile edit get  */
	Route::get('profile-edit', ['as'=>'agent-profile-edit','uses'=>'Agent\UserController@getProfileedit']);

	/* User Profile Post */
	Route::patch('agent-profile',['as'=>'agent-profile','uses'=> 'Agent\UserController@postProfileedit']);

	/*  Profile Password Post */
	Route::patch('agent-profile-password/{id}', 'Agent\UserController@postProfilePassword');

	// Route::get('/abcd', 'GuestController@getList');
	// Route::get('/qwer', ['as' => 'thread', 'uses' => 'GuestController@getThread']);

	/*  Fetch Emails */
	Route::get('/test', ['as' => 'thr', 'uses' => 'Agent\MailController@fetchdata']);

	/*  Get Ticket */
	Route::get('/ticket', ['as' => 'ticket', 'uses' => 'Agent\TicketController@ticket_list']);

	/*  Get Open Ticket */
	Route::get('/ticket/open', ['as' => 'open.ticket', 'uses' => 'Agent\TicketController@open_ticket_list']);

	/*  Get Answered Ticket */
	Route::get('/ticket/answered', ['as' => 'answered.ticket', 'uses' => 'Agent\TicketController@answered_ticket_list']);

	/*  Get Tickets Assigned to logged user */
	Route::get('/ticket/myticket', ['as' => 'myticket.ticket', 'uses' => 'Agent\TicketController@myticket_ticket_list']);

	/*  Get Overdue Ticket */
	Route::get('/ticket/overdue', ['as' => 'overdue.ticket', 'uses' => 'Agent\TicketController@overdue_ticket_list']);

	/*  Get Closed Ticket */
	Route::get('/ticket/closed', ['as' => 'closed.ticket', 'uses' => 'Agent\TicketController@closed_ticket_list']);

	/*  Get Create New Ticket */
	Route::get('/newticket', ['as' => 'newticket', 'uses' => 'Agent\TicketController@newticket']);

	/*  Post Create New Ticket */
	Route::post('/newticket/post', ['as' => 'post.newticket', 'uses' => 'Agent\TicketController@post_newticket']);

	/*  Get Thread by ID */
	Route::get('/thread/{id}', ['as' => 'ticket.thread', 'uses' => 'Agent\TicketController@thread']);

	/*  Patch Thread Reply */
	Route::patch('/thread/reply/{id}', ['as' => 'ticket.reply', 'uses' => 'Agent\TicketController@reply']);

	/*  Patch Internal Note */
	Route::patch('/internal/note/{id}', ['as' => 'Internal.note', 'uses' => 'Agent\TicketController@InternalNote']);

	/*  Patch Ticket assigned to whom */
	Route::patch('/ticket/assign/{id}', ['as' => 'assign.ticket', 'uses' => 'Agent\TicketController@assign']);

	/*  Patchi Ticket Edit */
	Route::patch('/ticket/post/edit/{id}', ['as' => 'ticket.post.edit', 'uses' => 'Agent\TicketController@ticket_edit_post']);

	/*  Get Print Ticket */
	Route::get('/ticket/print/{id}', ['as' => 'ticket.print', 'uses' => 'Agent\TicketController@ticket_print']);

	/*  Get Ticket Close */
	Route::get('/ticket/close/{id}', ['as' => 'ticket.close', 'uses' => 'Agent\TicketController@close']);

	/*  Get ticket Resolve */
	Route::get('/ticket/resolve/{id}', ['as' => 'ticket.resolve', 'uses' => 'Agent\TicketController@resolve']);

	/*  Get Ticket Open */
	Route::get('/ticket/open/{id}', ['as' => 'ticket.open', 'uses' => 'Agent\TicketController@open']);

	/*  Get Ticket Delete */
	Route::get('/ticket/delete/{id}', ['as' => 'ticket.delete', 'uses' => 'Agent\TicketController@delete']);

	/*  Get Ban Email */
	Route::get('/email/ban/{id}', ['as' => 'ban.email', 'uses' => 'Agent\TicketController@ban']);

	/*  Get Ticket Surrender */
	Route::get('/ticket/surrender/{id}', ['as' => 'ticket.surrender', 'uses' => 'Agent\TicketController@surrender']);

	Route::get('/aaaa', 'Guest\GuestController@ticket_number');

	/* To show Deleted Tickets */
	Route::get('trash', 'Agent\TicketController@trash');

	/* To show Unassigned Tickets */
	Route::get('unassigned', 'Agent\TicketController@unassigned');

	/* To show dashboard pages */
	Route::get('dashboard', 'Agent\DashboardController@index');
    
    Route::get('agen', 'Agent\DashboardController@ChartData');
	
	/* get image */	
	Route::get('image/{id}', ['as'=>'image', 'uses'=>'Agent\MailController@get_data']);

	Route::get('thread/auto/{id}', 'Agent\TicketController@autosearch');

	Route::get('auto', 'Agent\TicketController@autosearch2');

	Route::patch('search-user', 'Agent\TicketController@usersearch');
	
	Route::patch('add-user', 'Agent\TicketController@useradd');
	
	Route::post('remove-user', 'Agent\TicketController@userremove');

	Route::post('select_all', ['as'=>'select_all' ,'uses'=>'Agent\TicketController@select_all']);

	Route::post('canned/{id}', 'MessageController@show');
	
	Route::get('message' , 'MessageController@show');

	Route::post('lock',['as'=>'lock' , 'uses'=>'Agent\TicketController@lock']);
});

/*
|------------------------------------------------------------------
|Guest Routes
|--------------------------------------------------------------------
| Here defining Guest User's routes
|
|
*/
// seasrch
Route::POST('tickets/search/', function() {
       $keyword = Illuminate\Support\Str::lower(Input::get('auto'));
       $models = App\Model\Ticket\Tickets::where('ticket_number', '=',$keyword)->orderby('ticket_number')->take(10)->skip(0)->get();
    $count = count($models);
    return Illuminate\Support\Facades\Redirect::back()->with("contents", $models)->with("counts", $count);
    
});
Route::any('getdata', function() {

   $term = Illuminate\Support\Str::lower(Input::get('term'));
   $data = Illuminate\Support\Facades\DB::table("tickets")->distinct()->select('ticket_number')->where('ticket_number','LIKE',$term.'%')->groupBy('ticket_number')->take(10)->get();
   foreach($data as $v) {
   return [
       'value' => $v->ticket_number
   ];
   }
});

	/* get the form for create a ticket by guest user */
	Route::get('getform', ['as'=>'guest.getform' ,'uses'=> 'Guest\FormController@getForm']);
	/* post the AJAX form for create a ticket by guest user */
	Route::post('postform/{id}', 'Guest\FormController@postForm');
	/* post the form to store the value */
	Route::post('postedform', 'Guest\FormController@postedForm');
	//testing checkbox auto-populate
	Route::get('check', 'CheckController@getcheck');
	Route::post('postcheck/{id}', 'CheckController@postcheck');
	//guest layout
	Route::get('home', ['as'=>'home', 'uses'=>'Guest\WelcomepageController@index']);
	Route::get('/', ['as'=>'/', 'uses'=>'Guest\WelcomepageController@index']);

	//getform
	Route::get('form',['as'=>'form','uses'=>'Guest\GuestController@getForm']);
	//detail ticket information
	Route::get('mytickets/{id}', ['as' => 'ticketinfo', 'uses' => 'Guest\GuestController@singleThread']);
	//ticket ckeck
	Route::post('checkmyticket', 'Guest\GuestController@PostCheckTicket');
	//detail ticket information
	Route::get('check_ticket/{id}', ['as' => 'check_ticket', 'uses' => 'Guest\GuestController@get_ticket_email']);

//testing ckeditor
//===================================================================================
Route::group(['middleware' => 'role.user', 'middleware' => 'auth'], function () {
	/*  User profile get  */
	Route::get('client-profile', 'Guest\GuestController@getProfile');
    Route::get('mytickets', ['as' => 'ticket2', 'uses' => 'Guest\GuestController@getMyticket']);
	/* Get my tickets */
    Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Guest\GuestController@thread']);
	/* User Profile Post */
	Route::patch('client-profile-edit', 'Guest\GuestController@postProfile');
	/*  Profile Password Post */
	Route::patch('client-profile-password', 'Guest\GuestController@postProfilePassword');
});

//====================================================================================
/* Check your Ticket */
Route::get('checkticket', 'Guest\GuestController@getCheckTicket');	
/* Get my tickets */
Route::get('myticket', ['as' => 'ticket', 'uses' => 'Guest\GuestController@getMyticket']);
/* Get my tickets */
Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Guest\GuestController@thread']);
/* post Check Ticket */
Route::post('postcheck', 'Guest\GuestController@PostCheckTicket');
Route::get('postcheck', 'Guest\GuestController@PostCheckTicket');

/* 404 page */
Route::get('404', 'error\ErrorController@error404');

// installer
Route::get('/serial', array(
	'as' => 'serialkey',
	'uses' => 'Installer\InstallController@serialkey',
));
Route::post('/CheckSerial/{id}', array(
	'as' => 'CheckSerial',
	'uses' => 'Installer\InstallController@PostSerialKey',
));
Route::get('/step1', array(
	'as' => 'licence',
	'uses' => 'Installer\InstallController@licence',
));
Route::post('/step1post', array(
	'as' => 'postlicence',
	'uses' => 'Installer\InstallController@licencecheck',
));
Route::get('/step2', array(
	'as' => 'prerequisites',
	'uses' => 'Installer\InstallController@prerequisites',
));
Route::post('/step2post', array(
	'as' => 'postprerequisites',
	'uses' => 'Installer\InstallController@prerequisitescheck',
));
Route::get('/step3', array(
	'as' => 'localization',
	'uses' => 'Installer\InstallController@localization',
));
Route::post('/step3post', array(
	'as' => 'postlocalization',
	'uses' => 'Installer\InstallController@localizationcheck',
));
Route::get('/step4', array(
	'as' => 'configuration',
	'uses' => 'Installer\InstallController@configuration',
));
Route::post('/step4post', array(
	'as' => 'postconfiguration',
	'uses' => 'Installer\InstallController@configurationcheck',
));
Route::get('/step5', array(
	'as' => 'database',
	'uses' => 'Installer\InstallController@database',
));
Route::get('/step6', array(
	'as' => 'account',
	'uses' => 'Installer\InstallController@account',
));
Route::post('/step6post', array(
	'as' => 'postaccount',
	'uses' => 'Installer\InstallController@accountcheck',
));
Route::get('/final', array(
	'as' => 'final',
	'uses' => 'Installer\InstallController@finalize',
));
Route::post('/finalpost', array(
	'as' => 'postfinal',
	'uses' => 'Installer\InstallController@finalcheck',
));
Route::patch('/postconnection', array(
	'as' => 'postconnection',
	'uses' => 'Installer\InstallController@postconnection',
));



// cron job link
Route::get('readmails',['as' => 'readmails', 'uses' => 'Agent\MailController@readmails']);

// to list of routes
// Route::get('/aaa',function(){
// 	$routeCollection = Route::getRoutes();
// echo "<table style='width:100%'>";
//     echo "<tr>";
//         echo "<td width='10%'><h4>HTTP Method</h4></td>";
//         echo "<td width='10%'><h4>Route</h4></td>";
//         echo "<td width='80%'><h4>Corresponding Action</h4></td>";
//     echo "</tr>";
//     foreach ($routeCollection as $value) {
//         echo "<tr>";
//             echo "<td>" . $value->getMethods()[0] . "</td>";
//             echo "<td>" . $value->getName() . "</td>";
//             echo "<td>" . $value->getActionName() . "</td>";
//         echo "</tr>";
//     }
// echo "</table>";
// });

Route::get('503',function(){
	return view('errors.503');
});

Route::get('404',function(){
	return view('errors.404');
});
