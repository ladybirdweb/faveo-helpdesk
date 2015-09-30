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
	Route::resource('groups', 'Admin\helpdesk\GroupController'); // for group module, for CRUD

	Route::resource('departments', 'Admin\helpdesk\DepartmentController'); // for departments module, for CRUD

	Route::resource('teams', 'Admin\helpdesk\TeamController'); // in teams module, for CRUD

	Route::resource('agents', 'Admin\helpdesk\AgentController'); // in agents module, for CRUD

	Route::resource('emails', 'Admin\helpdesk\EmailsController'); // in emails module, for CRUD

	Route::resource('banlist', 'Admin\helpdesk\BanlistController'); // in banlist module, for CRUD

	Route::resource('template', 'Admin\helpdesk\TemplateController'); // in template module, for CRUD

	Route::get('getdiagno', 'Admin\helpdesk\TemplateController@formDiagno'); // for getting form for diagnostic

	Route::post('postdiagno', 'Admin\helpdesk\TemplateController@postDiagno'); // for getting form for diagnostic

	Route::resource('helptopic', 'Admin\helpdesk\HelptopicController'); // in helptopics module, for CRUD

	Route::resource('sla', 'Admin\helpdesk\SlaController'); // in SLA Plan module, for CRUD

	Route::resource('form', 'Admin\helpdesk\FormController'); // in Form module, for CRUD
	//$router->model('id','getcompany');

	Route::get('agent-profile-page/{id}',['as'=>'agent.profile.page','uses'=>'Admin\helpdesk\AgentController@agent_profile']);


	Route::get('getcompany', 'Admin\helpdesk\SettingsController@getcompany'); // direct to company setting page

	Route::patch('postcompany/{id}', 'Admin\helpdesk\SettingsController@postcompany'); // Updating the Company table with requests

	Route::get('getsystem', 'Admin\helpdesk\SettingsController@getsystem'); // direct to system setting page

	Route::patch('postsystem/{id}', 'Admin\helpdesk\SettingsController@postsystem'); // Updating the System table with requests

	Route::get('getticket', 'Admin\helpdesk\SettingsController@getticket'); // direct to ticket setting page

	Route::patch('postticket/{id}', 'Admin\helpdesk\SettingsController@postticket'); // Updating the Ticket table with requests

	Route::get('getemail', 'Admin\helpdesk\SettingsController@getemail'); // direct to email setting page

	Route::patch('postemail/{id}', 'Admin\helpdesk\SettingsController@postemail'); // Updating the Email table with requests

	// Route::get('getaccess', 'Admin\helpdesk\SettingsController@getaccess'); // direct to access setting page

	// Route::patch('postaccess/{id}', 'Admin\helpdesk\SettingsController@postaccess'); // Updating the Access table with requests

	Route::get('getresponder', 'Admin\helpdesk\SettingsController@getresponder'); // direct to responder setting page

	Route::patch('postresponder/{id}', 'Admin\helpdesk\SettingsController@postresponder'); // Updating the Responder table with requests

	Route::get('getalert', 'Admin\helpdesk\SettingsController@getalert'); // direct to alert setting page

	Route::patch('postalert/{id}', 'Admin\helpdesk\SettingsController@postalert'); // Updating the Alert table with requests

	/*  User profile edit get  */
	Route::get('admin-profile', 'Admin\helpdesk\ProfileController@getProfile');

	/*  Admin profile get  */
	Route::get('admin-profile-edit', 'Admin\helpdesk\ProfileController@getProfileedit');

	/* Admin Profile Post */
	Route::patch('admin-profile', 'Admin\helpdesk\ProfileController@postProfileedit');

	/*  Admin Profile Password Post */
	Route::patch('admin-profile-password', 'Admin\helpdesk\ProfileController@postProfilePassword');

	/* get the create footer page for admin */
	Route::get('create-footer', 'Common\SettingsController@CreateFooter');
	
	/* post footer to insert to database */
	Route::patch('post-create-footer/{id}', 'Common\SettingsController@PostFooter');
	
	/* get the create footer page for admin */
	Route::get('create-footer2', 'Common\SettingsController@CreateFooter2');
	
	/* post footer to insert to database */
	Route::patch('post-create-footer2/{id}', 'Common\SettingsController@PostFooter2');
	
	/* get the create footer page for admin */
	Route::get('create-footer3', 'Common\SettingsController@CreateFooter3');
	
	/* post footer to insert to database */
	Route::patch('post-create-footer3/{id}', 'Common\SettingsController@PostFooter3');
	
	/* get the create footer page for admin */
	Route::get('create-footer4', 'Common\SettingsController@CreateFooter4');
	
	/* post footer to insert to database */
	Route::patch('post-create-footer4/{id}', 'Common\SettingsController@PostFooter4');

	/* get the create footer page for admin */
	Route::get('getsmtp',['as'=>'getsmtp','uses'=>'Common\SettingsController@getsmtp']);
	
	/* post footer to insert to database */
	Route::patch('post-smtp',['as'=>'post_smtp','uses'=>'Common\SettingsController@postsmtp']);

	/* Check version  */
	Route::get('version-check',['as'=>'version-check','uses'=>'Common\SettingsController@version_check']);

	/* post Check version */	
	Route::post('post-version-check',['as'=>'post-version-check','uses'=>'Common\SettingsController@post_version_check']);

	/* get Check update */	
	Route::get('checkUpdate',['as'=>'checkupdate','uses'=>'Common\SettingsController@getupdate']);
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
	Route::resource('user', 'Agent\helpdesk\UserController');

	/* organization router used to deal CRUD function of organization */
	Route::resource('organizations', 'Agent\helpdesk\OrganizationController');

	/*  User profile get  */
	Route::get('profile',['as'=>'profile' , 'uses'=> 'Agent\helpdesk\UserController@getProfile']);

	/*  User profile edit get  */
	Route::get('profile-edit', ['as'=>'agent-profile-edit','uses'=>'Agent\helpdesk\UserController@getProfileedit']);

	/* User Profile Post */
	Route::patch('agent-profile',['as'=>'agent-profile','uses'=> 'Agent\helpdesk\UserController@postProfileedit']);

	/*  Profile Password Post */
	Route::patch('agent-profile-password/{id}', 'Agent\helpdesk\UserController@postProfilePassword');

	// Route::get('/abcd', 'GuestController@getList');
	// Route::get('/qwer', ['as' => 'thread', 'uses' => 'GuestController@getThread']);

	/*  Fetch Emails */
	Route::get('/test', ['as' => 'thr', 'uses' => 'Agent\helpdesk\MailController@fetchdata']);

	/*  Get Ticket */
	Route::get('/ticket', ['as' => 'ticket', 'uses' => 'Agent\helpdesk\TicketController@ticket_list']);

	/*  Get Inbox Ticket */
	Route::get('/ticket/inbox', ['as' => 'inbox.ticket', 'uses' => 'Agent\helpdesk\TicketController@inbox_ticket_list']);

	/*  Get Open Ticket */
	Route::get('/ticket/open', ['as' => 'open.ticket', 'uses' => 'Agent\helpdesk\TicketController@open_ticket_list']);

	/*  Get Answered Ticket */
	Route::get('/ticket/answered', ['as' => 'answered.ticket', 'uses' => 'Agent\helpdesk\TicketController@answered_ticket_list']);

	/*  Get Tickets Assigned to logged user */
	Route::get('/ticket/myticket', ['as' => 'myticket.ticket', 'uses' => 'Agent\helpdesk\TicketController@myticket_ticket_list']);

	/*  Get Overdue Ticket */
	Route::get('/ticket/overdue', ['as' => 'overdue.ticket', 'uses' => 'Agent\helpdesk\TicketController@overdue_ticket_list']);

	/*  Get Closed Ticket */
	Route::get('/ticket/closed', ['as' => 'closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@closed_ticket_list']);

	/*  Get Assigned Ticket */
	Route::get('/ticket/assigned', ['as' => 'assigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@assigned_ticket_list']);

	/*  Get Create New Ticket */
	Route::get('/newticket', ['as' => 'newticket', 'uses' => 'Agent\helpdesk\TicketController@newticket']);

	/*  Post Create New Ticket */
	Route::post('/newticket/post', ['as' => 'post.newticket', 'uses' => 'Agent\helpdesk\TicketController@post_newticket']);

	/*  Get Thread by ID */
	Route::get('/thread/{id}', ['as' => 'ticket.thread', 'uses' => 'Agent\helpdesk\TicketController@thread']);

	/*  Patch Thread Reply */
	Route::patch('/thread/reply/{id}', ['as' => 'ticket.reply', 'uses' => 'Agent\helpdesk\TicketController@reply']);

	/*  Patch Internal Note */
	Route::patch('/internal/note/{id}', ['as' => 'Internal.note', 'uses' => 'Agent\helpdesk\TicketController@InternalNote']);

	/*  Patch Ticket assigned to whom */
	Route::patch('/ticket/assign/{id}', ['as' => 'assign.ticket', 'uses' => 'Agent\helpdesk\TicketController@assign']);

	/*  Patchi Ticket Edit */
	Route::patch('/ticket/post/edit/{id}', ['as' => 'ticket.post.edit', 'uses' => 'Agent\helpdesk\TicketController@ticket_edit_post']);

	/*  Get Print Ticket */
	Route::get('/ticket/print/{id}', ['as' => 'ticket.print', 'uses' => 'Agent\helpdesk\TicketController@ticket_print']);

	/*  Get Ticket Close */
	Route::get('/ticket/close/{id}', ['as' => 'ticket.close', 'uses' => 'Agent\helpdesk\TicketController@close']);

	/*  Get ticket Resolve */
	Route::get('/ticket/resolve/{id}', ['as' => 'ticket.resolve', 'uses' => 'Agent\helpdesk\TicketController@resolve']);

	/*  Get Ticket Open */
	Route::get('/ticket/open/{id}', ['as' => 'ticket.open', 'uses' => 'Agent\helpdesk\TicketController@open']);

	/*  Get Ticket Delete */
	Route::get('/ticket/delete/{id}', ['as' => 'ticket.delete', 'uses' => 'Agent\helpdesk\TicketController@delete']);

	/*  Get Ban Email */
	Route::get('/email/ban/{id}', ['as' => 'ban.email', 'uses' => 'Agent\helpdesk\TicketController@ban']);

	/*  Get Ticket Surrender */
	Route::get('/ticket/surrender/{id}', ['as' => 'ticket.surrender', 'uses' => 'Agent\helpdesk\TicketController@surrender']);

	Route::get('/aaaa', 'Client\helpdesk\GuestController@ticket_number');

	/* To show Deleted Tickets */
	Route::get('trash', 'Agent\helpdesk\TicketController@trash');

	/* To show Unassigned Tickets */
	Route::get('unassigned', 'Agent\helpdesk\TicketController@unassigned');

	/* To show dashboard pages */
	Route::get('dashboard', 'Agent\helpdesk\DashboardController@index');
    
    Route::get('agen', 'Agent\helpdesk\DashboardController@ChartData');
	
	/* get image */	
	Route::get('image/{id}', ['as'=>'image', 'uses'=>'Agent\helpdesk\MailController@get_data']);

	Route::get('thread/auto/{id}', 'Agent\helpdesk\TicketController@autosearch');

	Route::get('auto', 'Agent\helpdesk\TicketController@autosearch2');

	Route::patch('search-user', 'Agent\helpdesk\TicketController@usersearch');
	
	Route::patch('add-user', 'Agent\helpdesk\TicketController@useradd');
	
	Route::post('remove-user', 'Agent\helpdesk\TicketController@userremove');

	Route::post('select_all', ['as'=>'select_all' ,'uses'=>'Agent\helpdesk\TicketController@select_all']);

	Route::post('canned/{id}', 'MessageController@show');
	
	Route::get('message' , 'MessageController@show');

	Route::post('lock',['as'=>'lock' , 'uses'=>'Agent\helpdesk\TicketController@lock']);

	Route::patch('user-org-assign/{id}', ['as'=>'user.assign.org',	'uses'=>'Agent\helpdesk\UserController@UserAssignOrg']);

	Route::patch('/user-org/{id}','Agent\helpdesk\UserController@User_Create_Org');

	Route::patch('/head-org/{id}','Agent\helpdesk\OrganizationController@Head_Org');
	
	// Department ticket
	// Open
	Route::get('/{dept}/open',['as'=>'dept.open.ticket','uses'=>'Agent\helpdesk\TicketController@deptopen']);
	// Inprogress
	Route::get('/{dept}/inprogress',['as'=>'dept.inprogress.ticket','uses'=>'Agent\helpdesk\TicketController@deptinprogress']);
	// Closed
	Route::get('/{dept}/closed',['as'=>'dept.closed.ticket','uses'=>'Agent\helpdesk\TicketController@deptclose']);
	
});
// cscdds
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
	Route::get('getform', ['as'=>'guest.getform' ,'uses'=> 'Client\helpdesk\FormController@getForm']);
	/* post the AJAX form for create a ticket by guest user */
	Route::post('postform/{id}', 'Client\helpdesk\FormController@postForm');
	/* post the form to store the value */
	Route::post('postedform', 'Client\helpdesk\FormController@postedForm');
	//testing checkbox auto-populate
	Route::get('check', 'CheckController@getcheck');
	Route::post('postcheck/{id}', 'CheckController@postcheck');
	//guest layout
	Route::get('home', ['as'=>'home', 'uses'=>'Client\helpdesk\WelcomepageController@index']);
	Route::get('/', ['as'=>'/', 'uses'=>'Client\helpdesk\WelcomepageController@index']);

	//getform
	Route::get('form',['as'=>'form','uses'=>'Client\helpdesk\GuestController@getForm']);
	//detail ticket information
	Route::get('mytickets/{id}', ['as' => 'ticketinfo', 'uses' => 'Client\helpdesk\GuestController@singleThread']);
	//ticket ckeck
	Route::post('checkmyticket', 'Client\helpdesk\GuestController@PostCheckTicket');
	//detail ticket information
	Route::get('check_ticket/{id}', ['as' => 'check_ticket', 'uses' => 'Client\helpdesk\GuestController@get_ticket_email']);

//testing ckeditor
//===================================================================================
Route::group(['middleware' => 'role.user', 'middleware' => 'auth'], function () {
	/*  User profile get  */
	Route::get('client-profile', 'Client\helpdesk\GuestController@getProfile');
    Route::get('mytickets', ['as' => 'ticket2', 'uses' => 'Client\helpdesk\GuestController@getMyticket']);
	/* Get my tickets */
    Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']);
	/* User Profile Post */
	Route::patch('client-profile-edit', 'Client\helpdesk\GuestController@postProfile');
	/*  Profile Password Post */
	Route::patch('client-profile-password', 'Client\helpdesk\GuestController@postProfilePassword');
});

//====================================================================================
/* Check your Ticket */
Route::get('checkticket', 'Client\helpdesk\GuestController@getCheckTicket');	
/* Get my tickets */
Route::get('myticket', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@getMyticket']);
/* Get my tickets */
Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']);
/* post Check Ticket */
Route::post('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket');
Route::get('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket');

/* 404 page */
Route::get('404', 'error\ErrorController@error404');

// installer
Route::get('/serial', array(
	'as' => 'serialkey',
	'uses' => 'Installer\helpdesk\InstallController@serialkey',
));
Route::post('/CheckSerial/{id}', array(
	'as' => 'CheckSerial',
	'uses' => 'Installer\helpdesk\InstallController@PostSerialKey',
));
Route::get('/step1', array(
	'as' => 'licence',
	'uses' => 'Installer\helpdesk\InstallController@licence',
));
Route::post('/step1post', array(
	'as' => 'postlicence',
	'uses' => 'Installer\helpdesk\InstallController@licencecheck',
));
Route::get('/step2', array(
	'as' => 'prerequisites',
	'uses' => 'Installer\helpdesk\InstallController@prerequisites',
));
Route::post('/step2post', array(
	'as' => 'postprerequisites',
	'uses' => 'Installer\helpdesk\InstallController@prerequisitescheck',
));
Route::get('/step3', array(
	'as' => 'localization',
	'uses' => 'Installer\helpdesk\InstallController@localization',
));
Route::post('/step3post', array(
	'as' => 'postlocalization',
	'uses' => 'Installer\helpdesk\InstallController@localizationcheck',
));
Route::get('/step4', array(
	'as' => 'configuration',
	'uses' => 'Installer\helpdesk\InstallController@configuration',
));
Route::post('/step4post', array(
	'as' => 'postconfiguration',
	'uses' => 'Installer\helpdesk\InstallController@configurationcheck',
));
Route::get('/step5', array(
	'as' => 'database',
	'uses' => 'Installer\helpdesk\InstallController@database',
));
Route::get('/step6', array(
	'as' => 'account',
	'uses' => 'Installer\helpdesk\InstallController@account',
));
Route::post('/step6post', array(
	'as' => 'postaccount',
	'uses' => 'Installer\helpdesk\InstallController@accountcheck',
));
Route::get('/final', array(
	'as' => 'final',
	'uses' => 'Installer\helpdesk\InstallController@finalize',
));
Route::post('/finalpost', array(
	'as' => 'postfinal',
	'uses' => 'Installer\helpdesk\InstallController@finalcheck',
));
Route::patch('/postconnection', array(
	'as' => 'postconnection',
	'uses' => 'Installer\helpdesk\InstallController@postconnection',
));



// cron job link
Route::get('readmails',['as' => 'readmails', 'uses' => 'Agent\helpdesk\MailController@readmails']);

// to list of routes
Route::get('/aaa',function(){
	$routeCollection = Route::getRoutes();
echo "<table style='width:100%'>";
    echo "<tr>";
        echo "<td width='10%'><h4>HTTP Method</h4></td>";
        echo "<td width='10%'><h4>Route</h4></td>";
        echo "<td width='10%'><h4>Url</h4></td>";
        echo "<td width='80%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
            echo "<td>" . $value->getMethods()[0] . "</td>";
            echo "<td>" . $value->getName() . "</td>";
            echo "<td>" . $value->getPath() . "</td>";
            echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
echo "</table>";
});

Route::get('503',function(){
	return view('errors.503');
});

Route::get('404',function(){
	return view('errors.404');
});


Route::get('testmail',function(){
	$e = "hello";
	Config::set('mail.host', 'smtp.gmail.com');
		\Mail::send('errors.report', array('e' => $e), function ($message) {
			$message->to('sujitprasad4567@gmail.com', 'sujit prasad')->subject('Error');
		});
});


// Route::get('smp','HomeController@getsmtp');