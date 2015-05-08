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

	/*  Admin profile get  */
	Route::get('admin-profile', 'Admin\ProfileController@getProfile');

	/* Admin Profile Post */
	Route::patch('admin-profile', 'Admin\ProfileController@postProfile');

	/*  Admin Profile Password Post */
	Route::patch('admin-profile-password', 'Admin\ProfileController@postProfilePassword');
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
	Route::get('agent-profile', 'Agent\UserController@getProfile');

	/* User Profile Post */
	Route::patch('agent-profile', 'Agent\UserController@postProfile');

	/*  Profile Password Post */
	Route::patch('agent-profile-password', 'Agent\UserController@postProfilePassword');

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
});

/*
|------------------------------------------------------------------
|Guest Routes
|--------------------------------------------------------------------
| Here defining Guest User's routes
|
|
 */

/* get the form for create a ticket by guest user */
$router->get('getform', 'Guest\FormController@getForm');

/* post the AJAX form for create a ticket by guest user */
$router->post('postform', 'Guest\FormController@postForm');

/* post the form to store the value */
$router->post('postedform', 'Guest\FormController@postedForm');

//testing checkbox auto-populate
$router->get('check', 'CheckController@getcheck');

$router->post('postcheck/{id}', 'CheckController@postcheck');

//guest layout
$router->get('/', 'Guest\OuthouseController@get');

//testing ckeditor
//$router->get('ck','Admin\SettingsController@getck');
//===================================================================================

Route::group(['middleware' => 'role.user', 'middleware' => 'auth'], function () {
	/*  User profile get  */
	Route::get('user-profile', 'Guest\GuestController@getProfile');

	/* User Profile Post */
	Route::patch('profile', 'Guest\GuestController@postProfile');

	/*  Profile Password Post */
	Route::patch('profile-password', 'Guest\GuestController@postProfilePassword');
});
//====================================================================================
/* Get my tickets */
$router->get('myticket', ['as' => 'ticket', 'uses' => 'Guest\GuestController@getMyticket']);

/* Get my ticket thread */
//$router->get('thread/{id}',['as'=>'ticket.thread','uses'=>'Guest\GuestController@getthread']);
// testing
Route::get('testing', 'Agent\MailController@getdata');

/* Check your Ticket */
$router->get('checkticket', 'Guest\GuestController@getCheckTicket');

/* post Check Ticket */
$router->post('postcheck', 'Guest\GuestController@PostCheckTicket');
$router->get('postcheck', 'Guest\GuestController@PostCheckTicket');

/* 404 page */
$router->get('404', 'error\ErrorController@error404');
