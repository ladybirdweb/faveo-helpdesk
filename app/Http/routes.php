<?php

'%smtplink%';

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

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

$router->get('getmail/{token}', 'Auth\AuthController@getMail');

/*
  |-------------------------------------------------------------------------------
  | API Routes
  |-------------------------------------------------------------------------------
  | These routes are the API calls.
  |
 */
// Route::group(['prefix' => 'api'], function () {
// 	Route::get('/database-config',['as'=>'database-config','uses'=>'Api\v1\InstallerApiController@config_database']);
// 	Route::get('/system-config',['as'=>'database-config','uses'=>'Api\v1\InstallerApiController@config_system']);
// });

/*
  |-------------------------------------------------------------------------------
  | Admin Routes
  |-------------------------------------------------------------------------------
  | Here is defining entire routes for the Admin Panel
  |
 */
Route::group(['middleware' => 'roles', 'middleware' => 'auth', 'middleware' => 'update'], function () {

    //Notification marking
    Route::post('mark-read/{id}', 'Common\NotificationController@markRead');
    Breadcrumbs::register('notification.list', function($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('All Notifications', route('notification.list'));
    });
    Route::get('notifications-list', ['as' => 'notification.list', 'uses' => 'Common\NotificationController@show']);

    Route::post('notification-delete/{id}', ['as' => 'notification.delete', 'uses' => 'Common\NotificationController@delete']);
    Breadcrumbs::register('notification.settings', function($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Notifications Settings', route('notification.settings'));
    });
    Route::get('settings-notification', ['as' => 'notification.settings', 'uses' => 'Admin\helpdesk\SettingsController@notificationSettings']);
    Route::get('delete-read-notification', 'Admin\helpdesk\SettingsController@deleteReadNoti');
    Route::post('delete-notification-log', 'Admin\helpdesk\SettingsController@deleteNotificationLog');
    // resource is a function to process create,edit,read and delete
    Route::resource('groups', 'Admin\helpdesk\GroupController'); // for group module, for CRUD

    Route::resource('departments', 'Admin\helpdesk\DepartmentController'); // for departments module, for CRUD

    Route::resource('teams', 'Admin\helpdesk\TeamController'); // in teams module, for CRUD

    Route::resource('agents', 'Admin\helpdesk\AgentController'); // in agents module, for CRUD

    Route::resource('emails', 'Admin\helpdesk\EmailsController'); // in emails module, for CRUD

    Route::resource('banlist', 'Admin\helpdesk\BanlistController'); // in banlist module, for CRUD
    /*
     * Templates
     */
    Breadcrumbs::register('template-sets.index', function($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('All Template sets', route('template-sets.index'));
    });
    Breadcrumbs::register('show.templates', function($breadcrumbs) {
        $page = App\Model\Common\Template::whereId(1)->first();
        $breadcrumbs->parent('template-sets.index');
        $breadcrumbs->push('All Templates', route('show.templates', $page->id));
    });
    Breadcrumbs::register('templates.edit', function($breadcrumbs) {
        $page = App\Model\Common\Template::whereId(1)->first();
        $breadcrumbs->parent('show.templates');
        $breadcrumbs->push('Edit Template', route('templates.edit', $page->id));
    });
    Route::resource('templates', 'Common\TemplateController');
    Route::get('get-templates', 'Common\TemplateController@GetTemplates');
    Route::get('templates-delete', 'Common\TemplateController@destroy');
    Route::get('testmail/{id}', 'Common\TemplateController@mailtest');

    Route::resource('template-sets', 'Common\TemplateSetController'); // in template module, for CRUD

    Route::get('delete-sets/{id}', ['as' => 'sets.delete', 'uses' => 'Common\TemplateSetController@deleteSet']);

    Route::get('show-template/{id}', ['as' => 'show.templates', 'uses' => 'Common\TemplateController@showTemplate']);

    Route::get('activate-templateset/{name}', ['as' => 'active.template-set', 'uses' => 'Common\TemplateSetController@activateSet']);

    Route::resource('template', 'Admin\helpdesk\TemplateController'); // in template module, for CRUD

    Route::get('list-directories', 'Admin\helpdesk\TemplateController@listdirectories');

    Route::get('activate-set/{dir}', ['as' => 'active.set', 'uses' => 'Admin\helpdesk\TemplateController@activateset']);

    Route::get('list-templates/{template}/{directory}', ['as' => 'template.list', 'uses' => 'Admin\helpdesk\TemplateController@listtemplates']);

    Route::get('read-templates/{template}/{directory}', ['as' => 'template.read', 'uses' => 'Admin\helpdesk\TemplateController@readtemplate']);

    Route::patch('write-templates/{contents}/{directory}', ['as' => 'template.write', 'uses' => 'Admin\helpdesk\TemplateController@writetemplate']);

    Route::post('create-templates', ['as' => 'template.createnew', 'uses' => 'Admin\helpdesk\TemplateController@createtemplate']);

    Route::get('delete-template/{template}/{path}', ['as' => 'templates.delete', 'uses' => 'Admin\helpdesk\TemplateController@deletetemplate']);

    Route::get('getdiagno', ['as' => 'getdiagno', 'uses' => 'Admin\helpdesk\TemplateController@formDiagno']); // for getting form for diagnostic

    Route::post('postdiagno', 'Admin\helpdesk\TemplateController@postDiagno'); // for getting form for diagnostic

    Route::resource('helptopic', 'Admin\helpdesk\HelptopicController'); // in helptopics module, for CRUD

    Route::resource('sla', 'Admin\helpdesk\SlaController'); // in SLA Plan module, for CRUD

    Route::resource('forms', 'Admin\helpdesk\FormController');

    Route::get('delete-forms/{id}', ['as' => 'forms.delete', 'uses' => 'Admin\helpdesk\FormController@delete']);

    //$router->model('id','getcompany');

    Route::get('agent-profile-page/{id}', ['as' => 'agent.profile.page', 'uses' => 'Admin\helpdesk\AgentController@agent_profile']);

    Route::get('getcompany', 'Admin\helpdesk\SettingsController@getcompany'); // direct to company setting page

    Route::patch('postcompany/{id}', 'Admin\helpdesk\SettingsController@postcompany'); // Updating the Company table with requests

    Route::get('delete-logo', ['as' => 'delete.logo', 'uses' => 'Admin\helpdesk\SettingsController@deleteLogo']); // deleting a logo

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
    // Templates
    Breadcrumbs::register('security.index', function($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Security', route('security.index'));
    });

// Templates > Upload Templates
    Breadcrumbs::register('security.create', function($breadcrumbs) {
        $breadcrumbs->parent('security.index');
        $breadcrumbs->push('Upload security', route('security.create'));
    });

// Templates > [Templates Name]
    Breadcrumbs::register('security.show', function($breadcrumbs, $photo) {
        $breadcrumbs->parent('security.index');
        $breadcrumbs->push($photo->title, route('security.show', $photo->id));
    });

// Templates > [Templates Name] > Edit Templates
    Breadcrumbs::register('security.edit', function($breadcrumbs, $photo) {
        $breadcrumbs->parent('security.show', $photo);
        $breadcrumbs->push('Edit security', route('security.edit', $photo->id));
    });


    Route::resource('security', 'Admin\helpdesk\SecurityController'); // direct to security setting page

    Route::patch('security/{id}', ['as' => 'securitys.update', 'uses' => 'Admin\helpdesk\SecurityController@update']); // direct to security setting page  
    Breadcrumbs::register('statuss.index', function($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('All Status', route('statuss.index'));
    });
    Route::get('setting-status', ['as' => 'statuss.index', 'uses' => 'Admin\helpdesk\SettingsController@getStatuses']); // direct to status setting page

    Route::patch('status-update/{id}', ['as' => 'statuss.update', 'uses' => 'Admin\helpdesk\SettingsController@editStatuses']);
    Breadcrumbs::register('statuss.create', function($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Create Status', route('statuss.create'));
    });
    Route::post('status-create', ['as' => 'statuss.create', 'uses' => 'Admin\helpdesk\SettingsController@createStatuses']);

    Route::get('status-delete/{id}', ['as' => 'statuss.delete', 'uses' => 'Admin\helpdesk\SettingsController@deleteStatuses']);

    Route::get('ticket/status/{id}/{state}', ['as' => 'statuss.state', 'uses' => 'Agent\helpdesk\TicketController@updateStatuses']);
    Breadcrumbs::register('ratings.index', function($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('All Ratings', route('ratings.index'));
    });
    Route::get('getratings', ['as' => 'ratings.index', 'uses' => 'Admin\helpdesk\SettingsController@RatingSettings']);

    Route::get('deleter/{rating}', ['as' => 'ratings.delete', 'uses' => 'Admin\helpdesk\SettingsController@RatingDelete']);

    Breadcrumbs::register('rating.create', function($breadcrumbs) {
        $breadcrumbs->parent('ratings.index');
        $breadcrumbs->push('Create Ratings', route('rating.create'));
    });

    Route::get('create-ratings', ['as' => 'rating.create', 'uses' => 'Admin\helpdesk\SettingsController@createRating']);

    Route::post('store-ratings', ['as' => 'rating.store', 'uses' => 'Admin\helpdesk\SettingsController@storeRating']);

    Breadcrumbs::register('rating.edit', function($breadcrumbs) {
        $page = App\Model\helpdesk\Ratings\Rating::whereId(1)->first();
        $breadcrumbs->parent('ratings.index');
        $breadcrumbs->push('Edit Ratings', route('rating.edit', $page->id));
    });

    Route::get('editratings/{slug}', ['as' => 'rating.edit', 'uses' => 'Admin\helpdesk\SettingsController@editRatingSettings']);

    Route::patch('postratings/{slug}', ['as' => 'settings.rating', 'uses' => 'Admin\helpdesk\SettingsController@PostRatingSettings']);

    Route::get('remove-user-org/{id}', ['as' => 'removeuser.org', 'uses' => 'Agent\helpdesk\UserController@removeUserOrg']);

    Route::get('admin-profile', 'Admin\helpdesk\ProfileController@getProfile'); /*  User profile edit get  */

    Route::get('admin-profile-edit', 'Admin\helpdesk\ProfileController@getProfileedit'); /*  Admin profile get  */

    Route::patch('admin-profile', 'Admin\helpdesk\ProfileController@postProfileedit'); /* Admin Profile Post */

    Route::patch('admin-profile-password', 'Admin\helpdesk\ProfileController@postProfilePassword'); /*  Admin Profile Password Post */

    Route::get('widgets', 'Common\SettingsController@widgets'); /* get the create footer page for admin */

    Route::get('list-widget', 'Common\SettingsController@list_widget'); /* get the list widget page for admin */

    Route::post('edit-widget/{id}', 'Common\SettingsController@edit_widget'); /* get the create footer page for admin */

    Route::get('social-buttons', 'Common\SettingsController@social_buttons'); /* get the create footer page for admin */

    Route::get('list-social-buttons', 'Common\SettingsController@list_social_buttons'); /* get the list widget page for admin */

    Route::post('edit-widget/{id}', 'Common\SettingsController@edit_social_buttons'); /* get the create footer page for admin */

    Route::get('getsmtp', ['as' => 'getsmtp', 'uses' => 'Common\SettingsController@getsmtp']); /* get the create footer page for admin */

    Route::patch('post-smtp', ['as' => 'post_smtp', 'uses' => 'Common\SettingsController@postsmtp']); /* post footer to insert to database */

    Route::get('version-check', ['as' => 'version-check', 'uses' => 'Common\SettingsController@version_check']); /* Check version  */

    Route::post('post-version-check', ['as' => 'post-version-check', 'uses' => 'Common\SettingsController@post_version_check']); /* post Check version */

    Route::get('checkUpdate', ['as' => 'checkupdate', 'uses' => 'Common\SettingsController@getupdate']); /* get Check update */

    Breadcrumbs::register('setting', function($breadcrumbs) {
        $breadcrumbs->push('Admin Panel', route('setting'));
    });

    Route::get('admin', ['as' => 'setting', 'uses' => 'Admin\helpdesk\SettingsController@settings']);

    Route::get('plugins', ['as' => 'plugins', 'uses' => 'Common\SettingsController@Plugins']);

    Route::get('getplugin', ['as' => 'get.plugin', 'uses' => 'Common\SettingsController@GetPlugin']);

    Route::post('post-plugin', ['as' => 'post.plugin', 'uses' => 'Common\SettingsController@PostPlugins']);

    Route::get('getconfig', ['as' => 'get.config', 'uses' => 'Common\SettingsController@fetchConfig']);

    Route::get('plugin/delete/{slug}', ['as' => 'delete.plugin', 'uses' => 'Common\SettingsController@DeletePlugin']);

    Route::get('plugin/status/{slug}', ['as' => 'status.plugin', 'uses' => 'Common\SettingsController@StatusPlugin']);

    //Routes for showing language table and switching language
    Route::get('languages', ['as' => 'LanguageController', 'uses' => 'Admin\helpdesk\LanguageController@index']);

    Route::get('get-languages', ['as' => 'getAllLanguages', 'uses' => 'Admin\helpdesk\LanguageController@getLanguages']);

    Route::get('change-language/{lang}', ['as' => 'lang.switch', 'uses' => 'Admin\helpdesk\LanguageController@switchLanguage']);

    //Route for download language template package
    Route::get('/download-template', ['as' => 'download', 'uses' => 'Admin\helpdesk\LanguageController@download']);

    //Routes for language file upload form-----------You may want to use csrf protection for these route--------------
    Route::post('language/add', 'Admin\helpdesk\LanguageController@postForm');

    Route::get('language/add', ['as' => 'add-language', 'uses' => 'Admin\helpdesk\LanguageController@getForm']);

    //Routes for  delete language package
    Route::get('delete-language/{lang}', ['as' => 'lang.delete', 'uses' => 'Admin\helpdesk\LanguageController@deleteLanguage']);

    Route::get('generate-api-key', 'Admin\helpdesk\SettingsController@GenerateApiKey'); // route to generate api key

    Route::post('validating-email-settings', ['as' => 'validating.email.settings', 'uses' => 'Admin\helpdesk\EmailsController@validatingEmailSettings']); // route to check email input validation
    Route::post('validating-email-settings-on-update/{id}', ['as' => 'validating.email.settings.update', 'uses' => 'Admin\helpdesk\EmailsController@validatingEmailSettingsUpdate']); // route to check email input validation


    Route::get('workflow', ['as' => 'workflow', 'uses' => 'Admin\helpdesk\WorkflowController@index']);
    Route::get('workflow-list', ['as' => 'workflow.list', 'uses' => 'Admin\helpdesk\WorkflowController@workFlowList']);
    Route::get('workflow/create', ['as' => 'workflow.create', 'uses' => 'Admin\helpdesk\WorkflowController@create']);
    Route::post('workflow/store', ['as' => 'workflow.store', 'uses' => 'Admin\helpdesk\WorkflowController@store']);
    Route::get('workflow/edit/{id}', ['as' => 'workflow.edit', 'uses' => 'Admin\helpdesk\WorkflowController@edit']);
    Route::post('workflow/update/{id}', ['as' => 'workflow.update', 'uses' => 'Admin\helpdesk\WorkflowController@update']);
    Route::get('workflow/action-rule/{id}', ['as' => 'workflow.dept', 'uses' => 'Admin\helpdesk\WorkflowController@selectAction']);
    Route::get('workflow/delete/{id}', ['as' => 'workflow.delete', 'uses' => 'Admin\helpdesk\WorkflowController@destroy']);

    /**
     * Api Settings
     */
    Route::get('api', ['as' => 'api.settings.get', 'uses' => 'Common\ApiSettings@show']);
    Route::post('api', ['as' => 'api.settings.post', 'uses' => 'Common\ApiSettings@postSettings']);
});

/*
  |------------------------------------------------------------------
  |Agent Routes
  |--------------------------------------------------------------------
  | Here defining entire Agent Panel routers
  |
  |
 */
Route::group(['middleware' => 'role.agent', 'middleware' => 'auth', 'middleware' => 'update'], function () {

    Route::post('chart-range/{date1}/{date2}', ['as' => 'post.chart', 'uses' => 'Agent\helpdesk\DashboardController@ChartData']);

    Route::get('agen1', 'Agent\helpdesk\DashboardController@ChartData');

    Route::post('chart-range', ['as' => 'post.chart', 'uses' => 'Agent\helpdesk\DashboardController@ChartData']);

    Route::post('user-chart-range/{id}/{date1}/{date2}', ['as' => 'post.user.chart', 'uses' => 'Agent\helpdesk\DashboardController@userChartData']);

    Route::get('user-agen/{id}', 'Agent\helpdesk\DashboardController@userChartData');

    Route::get('user-agen1', 'Agent\helpdesk\DashboardController@userChartData');

    Route::post('user-chart-range', ['as' => 'post.user.chart', 'uses' => 'Agent\helpdesk\DashboardController@userChartData']);


    Route::resource('user', 'Agent\helpdesk\UserController'); /* User router is used to control the CRUD of user */

    Route::get('user-list', ['as' => 'user.list', 'uses' => 'Agent\helpdesk\UserController@user_list']);

    // Route::get('user/delete/{id}', ['as' => 'user.delete' , 'uses' => 'Agent\helpdesk\UserController@destroy']);

    Route::resource('organizations', 'Agent\helpdesk\OrganizationController'); /* organization router used to deal CRUD function of organization */

    Route::get('org-list', ['as' => 'org.list', 'uses' => 'Agent\helpdesk\OrganizationController@org_list']);

    Route::get('org/delete/{id}', ['as' => 'org.delete', 'uses' => 'Agent\helpdesk\OrganizationController@destroy']);

    Route::get('profile', ['as' => 'profile', 'uses' => 'Agent\helpdesk\UserController@getProfile']); /*  User profile get  */

    Route::get('profile-edit', ['as' => 'agent-profile-edit', 'uses' => 'Agent\helpdesk\UserController@getProfileedit']); /*  User profile edit get  */

    Route::patch('agent-profile', ['as' => 'agent-profile', 'uses' => 'Agent\helpdesk\UserController@postProfileedit']); /* User Profile Post */

    Route::patch('agent-profile-password/{id}', 'Agent\helpdesk\UserController@postProfilePassword'); /*  Profile Password Post */

    Route::get('canned/list', ['as' => 'canned.list', 'uses' => 'Agent\helpdesk\CannedController@index']); /* Canned list */

    Route::get('canned/create', ['as' => 'canned.create', 'uses' => 'Agent\helpdesk\CannedController@create']); /* Canned create */

    Route::patch('canned/store', ['as' => 'canned.store', 'uses' => 'Agent\helpdesk\CannedController@store']); /* Canned store */

    Route::get('canned/edit/{id}', ['as' => 'canned.edit', 'uses' => 'Agent\helpdesk\CannedController@edit']); /* Canned edit */

    Route::patch('canned/update/{id}', ['as' => 'canned.update', 'uses' => 'Agent\helpdesk\CannedController@update']); /* Canned update */

    Route::get('canned/show/{id}', ['as' => 'canned.show', 'uses' => 'Agent\helpdesk\CannedController@show']); /* Canned show */

    Route::delete('canned/destroy/{id}', ['as' => 'canned.destroy', 'uses' => 'Agent\helpdesk\CannedController@destroy']); /* Canned delete */

    Route::get('/test', ['as' => 'thr', 'uses' => 'Agent\helpdesk\MailController@fetchdata']); /*  Fetch Emails */

    Route::get('/ticket', ['as' => 'ticket', 'uses' => 'Agent\helpdesk\TicketController@ticket_list']); /*  Get Ticket */

    Route::get('/ticket/inbox', ['as' => 'inbox.ticket', 'uses' => 'Agent\helpdesk\TicketController@inbox_ticket_list']); /*  Get Inbox Ticket */

    Route::get('/ticket/get-inbox', ['as' => 'get.inbox.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_inbox']);  /* Get tickets in datatable */

    Route::get('/ticket/open', ['as' => 'open.ticket', 'uses' => 'Agent\helpdesk\TicketController@open_ticket_list']); /*  Get Open Ticket */

    Route::get('/ticket/get-open', ['as' => 'get.open.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_open']);  /* Get tickets in datatable */

    Route::get('/ticket/answered', ['as' => 'answered.ticket', 'uses' => 'Agent\helpdesk\TicketController@answered_ticket_list']); /*  Get Answered Ticket */

    Route::get('/ticket/get-answered', ['as' => 'get.answered.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_answered']);  /* Get tickets in datatable */

    Route::get('/ticket/myticket', ['as' => 'myticket.ticket', 'uses' => 'Agent\helpdesk\TicketController@myticket_ticket_list']); /*  Get Tickets Assigned to logged user */

    Route::get('/ticket/get-myticket', ['as' => 'get.myticket.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_myticket']);  /* Get tickets in datatable */

    Route::get('/ticket/overdue', ['as' => 'overdue.ticket', 'uses' => 'Agent\helpdesk\TicketController@overdue_ticket_list']); /*  Get Overdue Ticket */

    Route::get('/ticket/get-overdue', ['as' => 'get.overdue.ticket', 'uses' => 'Agent\helpdesk\TicketController@getOverdueTickets']); /*  Get Overdue Ticket */

    Route::get('/ticket/closed', ['as' => 'closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@closed_ticket_list']); /*  Get Closed Ticket */

    Route::get('/ticket/get-closed', ['as' => 'get.closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_closed']);  /* Get tickets in datatable */

    Route::get('/ticket/assigned', ['as' => 'assigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@assigned_ticket_list']); /*  Get Assigned Ticket */

    Route::get('/ticket/get-assigned', ['as' => 'get.assigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_assigned']);  /* Get tickets in datatable */

    Route::get('/newticket', ['as' => 'newticket', 'uses' => 'Agent\helpdesk\TicketController@newticket']); /*  Get Create New Ticket */

    Route::post('/newticket/post', ['as' => 'post.newticket', 'uses' => 'Agent\helpdesk\TicketController@post_newticket']); /*  Post Create New Ticket */

    Route::get('/thread/{id}', ['as' => 'ticket.thread', 'uses' => 'Agent\helpdesk\TicketController@thread']); /*  Get Thread by ID */

    Route::patch('/thread/reply/{id}', ['as' => 'ticket.reply', 'uses' => 'Agent\helpdesk\TicketController@reply']); /*  Patch Thread Reply */

    Route::patch('/internal/note/{id}', ['as' => 'Internal.note', 'uses' => 'Agent\helpdesk\TicketController@InternalNote']); /*  Patch Internal Note */

    Route::patch('/ticket/assign/{id}', ['as' => 'assign.ticket', 'uses' => 'Agent\helpdesk\TicketController@assign']); /*  Patch Ticket assigned to whom */

    Route::patch('/ticket/post/edit/{id}', ['as' => 'ticket.post.edit', 'uses' => 'Agent\helpdesk\TicketController@ticketEditPost']); /*  Patchi Ticket Edit */

    Route::get('/ticket/print/{id}', ['as' => 'ticket.print', 'uses' => 'Agent\helpdesk\TicketController@ticket_print']); /*  Get Print Ticket */

    Route::get('/ticket/close/{id}', ['as' => 'ticket.close', 'uses' => 'Agent\helpdesk\TicketController@close']); /*  Get Ticket Close */

    Route::get('/ticket/resolve/{id}', ['as' => 'ticket.resolve', 'uses' => 'Agent\helpdesk\TicketController@resolve']); /*  Get ticket Resolve */

    Route::get('/ticket/open/{id}', ['as' => 'ticket.open', 'uses' => 'Agent\helpdesk\TicketController@open']); /*  Get Ticket Open */

    Route::get('/ticket/delete/{id}', ['as' => 'ticket.delete', 'uses' => 'Agent\helpdesk\TicketController@delete']); /*  Get Ticket Delete */

    Route::get('/email/ban/{id}', ['as' => 'ban.email', 'uses' => 'Agent\helpdesk\TicketController@ban']); /*  Get Ban Email */

    Route::get('/ticket/surrender/{id}', ['as' => 'ticket.surrender', 'uses' => 'Agent\helpdesk\TicketController@surrender']); /*  Get Ticket Surrender */

    Route::get('/aaaa', 'Client\helpdesk\GuestController@ticket_number');

    Route::get('trash', 'Agent\helpdesk\TicketController@trash'); /* To show Deleted Tickets */

    Route::get('/ticket/trash', ['as' => 'get.trash.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_trash']);  /* Get tickets in datatable */

    Route::get('unassigned', 'Agent\helpdesk\TicketController@unassigned'); /* To show Unassigned Tickets */

    Route::get('/ticket/unassigned', ['as' => 'get.unassigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_unassigned']);  /* Get tickets in datatable */
    Breadcrumbs::register('dashboard', function($breadcrumbs) {
        $breadcrumbs->parent('/');
        $breadcrumbs->push('Dashboard', route('dashboard'));
    });
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Agent\helpdesk\DashboardController@index']); /* To show dashboard pages */

    Route::get('agen', 'Agent\helpdesk\DashboardController@ChartData');

    Route::get('image/{id}', ['as' => 'image', 'uses' => 'Agent\helpdesk\MailController@get_data']); /* get image */

    Route::get('thread/auto/{id}', 'Agent\helpdesk\TicketController@autosearch');

    Route::get('auto', 'Agent\helpdesk\TicketController@autosearch2');

    Route::patch('search-user', 'Agent\helpdesk\TicketController@usersearch');

    Route::patch('add-user', 'Agent\helpdesk\TicketController@useradd');

    Route::post('remove-user', 'Agent\helpdesk\TicketController@userremove');

    Route::post('select_all', ['as' => 'select_all', 'uses' => 'Agent\helpdesk\TicketController@select_all']);

    Route::post('canned/{id}', 'Agent\helpdesk\CannedController@get_canned');

    // Route::get('message' , 'MessageController@show');

    Route::post('lock', ['as' => 'lock', 'uses' => 'Agent\helpdesk\TicketController@lock']);

    Route::patch('user-org-assign/{id}', ['as' => 'user.assign.org', 'uses' => 'Agent\helpdesk\UserController@UserAssignOrg']);

    Route::patch('/user-org/{id}', 'Agent\helpdesk\UserController@User_Create_Org');

    Route::patch('/head-org/{id}', 'Agent\helpdesk\OrganizationController@Head_Org');

    // Department ticket

    Route::get('/{dept}/open', ['as' => 'dept.open.ticket', 'uses' => 'Agent\helpdesk\TicketController@deptopen']); // Open

    Route::get('/{dept}/inprogress', ['as' => 'dept.inprogress.ticket', 'uses' => 'Agent\helpdesk\TicketController@deptinprogress']); // Inprogress

    Route::get('/{dept}/closed', ['as' => 'dept.closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@deptclose']); // Closed

    Route::post('rating/{id}', ['as' => 'ticket.rating', 'uses' => 'Agent\helpdesk\TicketController@rating']); /* Get overall Ratings */

    Route::post('rating2/{id}', ['as' => 'ticket.rating2', 'uses' => 'Agent\helpdesk\TicketController@ratingReply']); /* Get reply Ratings */
    // To check and lock tickets
    Route::get('check/lock/{id}', ['as' => 'lock', 'uses' => 'Agent\helpdesk\TicketController@checkLock']);

    Route::patch('/change-owner/{id}', ['as' => 'change.owner.ticket', 'uses' => 'Agent\helpdesk\TicketController@changeOwner']); /* change owner */

    //To merge tickets

    Route::get('/get-merge-tickets/{id}', ['as' => 'get.merge.tickets', 'uses' => 'Agent\helpdesk\TicketController@getMergeTickets']);

    Route::get('/check-merge-ticket/{id}', ['as' => 'check.merge.tickets', 'uses' => 'Agent\helpdesk\TicketController@checkMergeTickets']);

    Route::get('/get-parent-tickets/{id}', ['as' => 'get.parent.ticket', 'uses' => 'Agent\helpdesk\TicketController@getParentTickets']);

    Route::patch('/merge-tickets/{id}', ['as' => 'merge.tickets', 'uses' => 'Agent\helpdesk\TicketController@mergeTickets']);

    //To get department tickets data
    //open tickets of department
    Route::get('/get-open-tickets/{id}', ['as' => 'get.dept.open', 'uses' => 'Agent\helpdesk\Ticket2Controller@getOpenTickets']);

    //close tickets of deartment
    Route::get('/get-closed-tickets/{id}', ['as' => 'get.dept.close', 'uses' => 'Agent\helpdesk\Ticket2Controller@getCloseTickets']);

    //in progress ticket of department
    Route::get('/get-under-process-tickets/{id}', ['as' => 'get.dept.inprocess', 'uses' => 'Agent\helpdesk\Ticket2Controller@getInProcessTickets']);
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
Route::POST('tickets/search/', function () {
    $keyword = Illuminate\Support\Str::lower(Input::get('auto'));
    $models = App\Model\Ticket\Tickets::where('ticket_number', '=', $keyword)->orderby('ticket_number')->take(10)->skip(0)->get();
    $count = count($models);

    return Illuminate\Support\Facades\Redirect::back()->with('contents', $models)->with('counts', $count);
});
Route::any('getdata', function () {

    $term = Illuminate\Support\Str::lower(Input::get('term'));
    $data = Illuminate\Support\Facades\DB::table('tickets')->distinct()->select('ticket_number')->where('ticket_number', 'LIKE', $term . '%')->groupBy('ticket_number')->take(10)->get();
    foreach ($data as $v) {
        return [
            'value' => $v->ticket_number,
        ];
    }
});

Route::get('getform', ['as' => 'guest.getform', 'uses' => 'Client\helpdesk\FormController@getForm']); /* get the form for create a ticket by guest user */

Route::post('postform/{id}', 'Client\helpdesk\FormController@postForm'); /* post the AJAX form for create a ticket by guest user */

Route::post('postedform', 'Client\helpdesk\FormController@postedForm'); /* post the form to store the value */

Route::get('check', 'CheckController@getcheck'); //testing checkbox auto-populate

Route::post('postcheck/{id}', 'CheckController@postcheck');
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});
Route::get('home', ['as' => 'home', 'uses' => 'Client\helpdesk\WelcomepageController@index']); //guest layout
Breadcrumbs::register('/', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('/'));
});
Route::get('/', ['as' => '/', 'uses' => 'Client\helpdesk\WelcomepageController@index']);
Breadcrumbs::register('form', function($breadcrumbs) {
    $breadcrumbs->push('Create Ticket', route('form'));
});
Route::get('create-ticket', ['as' => 'form', 'uses' => 'Client\helpdesk\FormController@getForm']); //getform

Route::get('mytickets/{id}', ['as' => 'ticketinfo', 'uses' => 'Client\helpdesk\GuestController@singleThread']); //detail ticket information

Route::post('checkmyticket', 'Client\helpdesk\GuestController@PostCheckTicket'); //ticket ckeck
Breadcrumbs::register('check_ticket', function($breadcrumbs, $id) {
    $page = \App\Model\helpdesk\Ticket\Tickets::whereId(1)->first();
    $breadcrumbs->parent('/');
    $breadcrumbs->push('Check Ticket', route('check_ticket', $page->id));
});
Route::get('check_ticket/{id}', ['as' => 'check_ticket', 'uses' => 'Client\helpdesk\GuestController@get_ticket_email']); //detail ticket information
//testing ckeditor
//===================================================================================
Route::group(['middleware' => 'role.user', 'middleware' => 'auth'], function () {

    Route::get('client-profile', ['as' => 'client.profile', 'uses' => 'Client\helpdesk\GuestController@getProfile']); /*  User profile get  */
    Breadcrumbs::register('ticket2', function($breadcrumbs) {
        $breadcrumbs->push('My Tickets', route('ticket2'));
    });
    Route::get('mytickets', ['as' => 'ticket2', 'uses' => 'Client\helpdesk\GuestController@getMyticket']);

    Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']); /* Get my tickets */

    Route::patch('client-profile-edit', 'Client\helpdesk\GuestController@postProfile'); /* User Profile Post */

    Route::patch('client-profile-password', 'Client\helpdesk\GuestController@postProfilePassword'); /*  Profile Password Post */

    Route::post('post/reply/{id}', ['as' => 'client.reply', 'uses' => 'Client\helpdesk\ClientTicketController@reply']);
});

//====================================================================================

Route::get('checkticket', 'Client\helpdesk\ClientTicketController@getCheckTicket'); /* Check your Ticket */

Route::get('myticket', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@getMyticket']); /* Get my tickets */

Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']); /* Get my tickets */

Route::post('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket'); /* post Check Ticket */

Route::get('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket');

Route::post('post-ticket-reply/{id}', 'Client\helpdesk\FormController@post_ticket_reply');

/* 404 page */
// Route::get('404', 'error\ErrorController@error404');

/*
  |============================================================
  |  Installer Routes
  |============================================================
  |  These routes are for installer
  |
 */
Route::get('/serial', ['as' => 'serialkey', 'uses' => 'Installer\helpdesk\InstallController@serialkey']);
Route::post('/CheckSerial/{id}', ['as' => 'CheckSerial', 'uses' => 'Installer\helpdesk\InstallController@PostSerialKey']);
Route::get('/step1', ['as' => 'licence', 'uses' => 'Installer\helpdesk\InstallController@licence']);
Route::post('/step1post', ['as' => 'postlicence', 'uses' => 'Installer\helpdesk\InstallController@licencecheck']);
Route::get('/step2', ['as' => 'prerequisites', 'uses' => 'Installer\helpdesk\InstallController@prerequisites']);
Route::post('/step2post', ['as' => 'postprerequisites', 'uses' => 'Installer\helpdesk\InstallController@prerequisitescheck']);
// Route::get('/step3', ['as' => 'localization', 'uses' => 'Installer\helpdesk\InstallController@localization']);
// Route::post('/step3post', ['as' => 'postlocalization', 'uses' => 'Installer\helpdesk\InstallController@localizationcheck']);
Route::get('/step3', ['as' => 'configuration', 'uses' => 'Installer\helpdesk\InstallController@configuration']);
Route::post('/step4post', ['as' => 'postconfiguration', 'uses' => 'Installer\helpdesk\InstallController@configurationcheck']);
Route::get('/step4', ['as' => 'database', 'uses' => 'Installer\helpdesk\InstallController@database']);
Route::get('/step5', ['as' => 'account', 'uses' => 'Installer\helpdesk\InstallController@account']);
Route::post('/step6post', ['as' => 'postaccount', 'uses' => 'Installer\helpdesk\InstallController@accountcheck']);
Route::get('/final', ['as' => 'final', 'uses' => 'Installer\helpdesk\InstallController@finalize']);
Route::post('/finalpost', ['as' => 'postfinal', 'uses' => 'Installer\helpdesk\InstallController@finalcheck']);
Route::post('/postconnection', ['as' => 'postconnection', 'uses' => 'Installer\helpdesk\InstallController@postconnection']);

/*
  |=============================================================
  |  Cron Job links
  |=============================================================
  |	These links are for cron job execution
  |
 */
Route::get('readmails', ['as' => 'readmails', 'uses' => 'Agent\helpdesk\MailController@readmails']);
Route::get('notification', ['as' => 'notification', 'uses' => 'Agent\helpdesk\NotificationController@send_notification']);
Route::get('auto-close-tickets', ['as' => 'auto.close', 'uses' => 'Agent\helpdesk\TicketController@autoCloseTicket']);

/*
  |=============================================================
  |  View all the Routes
  |=============================================================
 */
Route::get('/aaa', function () {
    $routeCollection = Route::getRoutes();
    echo "<table style='width:100%'>";
    echo '<tr>';
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Url</h4></td>";
    echo "<td width='80%'><h4>Corresponding Action</h4></td>";
    echo '</tr>';
    foreach ($routeCollection as $value) {
        echo '<tr>';
        echo '<td>' . $value->getMethods()[0] . '</td>';
        echo '<td>' . $value->getName() . '</td>';
        echo '<td>' . $value->getPath() . '</td>';
        echo '<td>' . $value->getActionName() . '</td>';
        echo '</tr>';
    }
    echo '</table>';
});

/*
  |=============================================================
  |  Error Routes
  |=============================================================
 */
Route::get('503', function () {
    return view('errors.503');
});
Route::get('404', function () {
    return view('errors.404');
});

/*
  |=============================================================
  |  Test mail Routes
  |=============================================================
 */
Route::get('testmail', function () {
    $e = 'hello';
    Config::set('mail.host', 'smtp.gmail.com');
    \Mail::send('errors.report', ['e' => $e], function ($message) {
        $message->to('sujitprasad4567@gmail.com', 'sujit prasad')->subject('Error');
    });
});

/*  For the crud of catogory  */
$router->resource('category', 'Agent\kb\CategoryController');
$router->get('category/delete/{id}', 'Agent\kb\CategoryController@destroy');
/*  For the crud of article  */
$router->resource('article', 'Agent\kb\ArticleController');
$router->get('article/delete/{id}', 'Agent\kb\ArticleController@destroy');
/* get settings */
$router->get('kb/settings', ['as' => 'settings', 'uses' => 'Agent\kb\SettingsController@settings']);
/* post settings */
$router->patch('postsettings/{id}', 'Agent\kb\SettingsController@postSettings');
//Route for administrater to access the comment
$router->get('comment', ['as' => 'comment', 'uses' => 'Agent\kb\SettingsController@comment']);
/* Route to define the comment should Published */
$router->get('published/{id}', ['as' => 'published', 'uses' => 'Agent\kb\SettingsController@publish']);
/* Route for deleting comments */
$router->delete('deleted/{id}', ['as' => 'deleted', 'uses' => 'Agent\kb\SettingsController@delete']);
/* Route for Profile  */
// $router->get('profile', ['as' => 'profile', 'uses' => 'Agent\kb\SettingsController@getProfile']);
/* Profile Update */
// $router->patch('post-profile', ['as' => 'post-profile', 'uses' =>'Agent\kb\SettingsController@postProfile'] );
/* Profile password Update */
// $router->patch('post-profile-password/{id}',['as' => 'post-profile-password', 'uses' => 'Agent\kb\SettingsController@postProfilepassword']);
/* delete Logo */
$router->get('delete-logo/{id}', ['as' => 'delete-logo', 'uses' => 'Agent\kb\SettingsController@deleteLogo']);
/* delete Background */
$router->get('delete-background/{id}', ['as' => 'delete-background', 'uses' => 'Agent\kb\SettingsController@deleteBackground']);
$router->resource('page', 'Agent\kb\PageController');
$router->get('get-pages', ['as' => 'api.page', 'uses' => 'Agent\kb\PageController@getData']);
$router->get('page/delete/{id}', ['as' => 'pagedelete', 'uses' => 'Agent\kb\PageController@destroy']);
$router->get('comment/delete/{id}', ['as' => 'commentdelete', 'uses' => 'Agent\kb\SettingsController@delete']);
$router->get('get-articles', ['as' => 'api.article', 'uses' => 'Agent\kb\ArticleController@getData']);
$router->get('get-categorys', ['as' => 'api.category', 'uses' => 'Agent\kb\CategoryController@getData']);
$router->get('get-comment', ['as' => 'api.comment', 'uses' => 'Agent\kb\SettingsController@getData']);
$router->get('test', 'ArticleController@test');

$router->post('image', 'Agent\kb\SettingsController@image');

$router->get('direct', function () {
    return view('direct');
});

// Route::get('/',['as'=>'home' , 'uses'=> 'client\kb\UserController@home'] );
/* post the comment from show page */
$router->post('postcomment/{slug}', ['as' => 'postcomment', 'uses' => 'Client\kb\UserController@postComment']);
/* get the article list */
Breadcrumbs::register('article-list', function($breadcrumbs) {
    $breadcrumbs->push('Article List', route('article-list'));
});
$router->get('article-list', ['as' => 'article-list', 'uses' => 'Client\kb\UserController@getArticle']);
// /* get search values */
$router->get('search', ['as' => 'search', 'uses' => 'Client\kb\UserController@search']);
/* get the selected article */
$router->get('show/{slug}', ['as' => 'show', 'uses' => 'Client\kb\UserController@show']);
Breadcrumbs::register('category-list', function($breadcrumbs) {
    $breadcrumbs->push('Category List', route('category-list'));
});
$router->get('category-list', ['as' => 'category-list', 'uses' => 'Client\kb\UserController@getCategoryList']);
/* get the categories with article */
$router->get('category-list/{id}', ['as' => 'categorylist', 'uses' => 'Client\kb\UserController@getCategory']);
/* get the home page */
$router->get('knowledgebase', ['as' => 'home', 'uses' => 'Client\kb\UserController@home']);
/* get the faq value to user */
// $router->get('faq',['as'=>'faq' , 'uses'=>'Client\kb\UserController@Faq'] );
/* get the cantact page to user */
$router->get('contact', ['as' => 'contact', 'uses' => 'Client\kb\UserController@contact']);
/* post the cantact page to controller */
$router->post('post-contact', ['as' => 'post-contact', 'uses' => 'Client\kb\UserController@postContact']);
//to get the value for page content
$router->get('pages/{name}', ['as' => 'pages', 'uses' => 'Client\kb\UserController@getPage']);
//profile
// $router->get('client-profile',['as' => 'client-profile', 'uses' => 'Client\kb\UserController@clientProfile']);
// Route::patch('client-profile-edit',['as' => 'client-profile-edit', 'uses' => 'Client\kb\UserController@postClientProfile']);
// Route::patch('client-profile-password/{id}',['as' => 'client-profile-password', 'uses' => 'Client\kb\UserController@postClientProfilePassword']);

Route::get('/inbox/data', ['as' => 'api.inbox', 'uses' => 'Agent\helpdesk\TicketController@get_inbox']);

Route::get('/report', 'HomeController@getreport');
Route::get('/reportdata', 'HomeController@pushdata');

/*
 * ================================================================================================
 * @version v1
 * @access public
 * @copyright (c) 2016, Ladybird web solution
 * @author Vijay Sebastian<vijay.sebastian@ladybirdweb.com>
 * @name Faveo
 */
Route::group(['prefix' => 'api/v1'], function () {
    Route::post('register', 'Api\v1\TokenAuthController@register');
    Route::post('authenticate', 'Api\v1\TokenAuthController@authenticate');
    Route::get('authenticate/user', 'Api\v1\TokenAuthController@getAuthenticatedUser');

    Route::get('/database-config', ['as' => 'database-config', 'uses' => 'Api\v1\InstallerApiController@config_database']);
    Route::get('/system-config', ['as' => 'database-config', 'uses' => 'Api\v1\InstallerApiController@config_system']);

    /*
     * Helpdesk
     */
    Route::group(['prefix' => 'helpdesk'], function () {

        Route::post('create', 'Api\v1\ApiController@createTicket');
        Route::post('reply', 'Api\v1\ApiController@ticketReply');
        Route::post('edit', 'Api\v1\ApiController@editTicket');
        Route::post('delete', 'Api\v1\ApiController@deleteTicket');
        Route::post('assign', 'Api\v1\ApiController@assignTicket');

        Route::get('open', 'Api\v1\ApiController@openedTickets');
        Route::get('unassigned', 'Api\v1\ApiController@unassignedTickets');
        Route::get('closed', 'Api\v1\ApiController@closeTickets');
        Route::get('agents', 'Api\v1\ApiController@getAgents');
        Route::get('teams', 'Api\v1\ApiController@getTeams');
        Route::get('customers', 'Api\v1\ApiController@getCustomers');
        Route::get('customer', 'Api\v1\ApiController@getCustomer');
        Route::get('ticket-search', 'Api\v1\ApiController@searchTicket');
        Route::get('ticket-thread', 'Api\v1\ApiController@ticketThreads');
        Route::get('url', 'Api\v1\ApiExceptAuthController@checkUrl');
        Route::get('check-url', 'Api\v1\ApiExceptAuthController@urlResult');
        Route::get('api_key', 'Api\v1\ApiController@generateApiKey');
        Route::get('help-topic', 'Api\v1\ApiController@getHelpTopic');
        Route::get('sla-plan', 'Api\v1\ApiController@getSlaPlan');
        Route::get('priority', 'Api\v1\ApiController@getPriority');
        Route::get('department', 'Api\v1\ApiController@getDepartment');
        Route::get('tickets', 'Api\v1\ApiController@getTickets');
        Route::get('ticket', 'Api\v1\ApiController@getTicketById');
        Route::get('inbox', 'Api\v1\ApiController@inbox');
        Route::get('trash', 'Api\v1\ApiController@getTrash');
        Route::get('my-tickets-agent', 'Api\v1\ApiController@getMyTicketsAgent');
        Route::post('internal-note', 'Api\v1\ApiController@internalNote');

        /*
         * Newly added
         */

        Route::get('customers-custom', 'Api\v1\ApiController@getCustomersWith');
        Route::get('collaborator/search', 'Api\v1\ApiController@collaboratorSearch');
        Route::post('collaborator/create', 'Api\v1\ApiController@addCollaboratorForTicket');
        Route::post('collaborator/remove', 'Api\v1\ApiController@deleteCollaborator');
        Route::post('collaborator/get-ticket', 'Api\v1\ApiController@getCollaboratorForTicket');
        Route::get('my-tickets-user', 'Api\v1\ApiController@getMyTicketsUser');
    });

    /*
     * Testing Url
     */
    Route::get('create/user', 'Api\v1\TestController@createUser');
    Route::get('create/ticket', 'Api\v1\TestController@createTicket');
    Route::get('ticket/reply', 'Api\v1\TestController@ticketReply');
    Route::get('ticket/edit', 'Api\v1\TestController@editTicket');
    Route::get('ticket/delete', 'Api\v1\TestController@deleteTicket');

    Route::get('ticket/open', 'Api\v1\TestController@openedTickets');
    Route::get('ticket/unassigned', 'Api\v1\TestController@unassignedTickets');
    Route::get('ticket/closed', 'Api\v1\TestController@closeTickets');
    Route::get('ticket/assign', 'Api\v1\TestController@assignTicket');
    Route::get('ticket/agents', 'Api\v1\TestController@getAgents');
    Route::get('ticket/teams', 'Api\v1\TestController@getTeams');
    Route::get('ticket/customers', 'Api\v1\TestController@getCustomers');
    Route::get('ticket/customer', 'Api\v1\TestController@getCustomer');
    Route::get('ticket/search', 'Api\v1\TestController@getSearch');
    Route::get('ticket/thread', 'Api\v1\TestController@ticketThreads');
    Route::get('ticket/url', 'Api\v1\TestController@url');
    Route::get('ticket/api', 'Api\v1\TestController@generateApiKey');
    Route::get('ticket/help-topic', 'Api\v1\TestController@getHelpTopic');
    Route::get('ticket/sla-plan', 'Api\v1\TestController@getSlaPlan');
    Route::get('ticket/priority', 'Api\v1\TestController@getPriority');
    Route::get('ticket/department', 'Api\v1\TestController@getDepartment');
    Route::get('ticket/tickets', 'Api\v1\TestController@getTickets');
    Route::get('ticket/inbox', 'Api\v1\TestController@inbox');
    Route::get('ticket/internal', 'Api\v1\TestController@internalNote');
    Route::get('ticket/trash', 'Api\v1\TestController@trash');
    Route::get('ticket/my', 'Api\v1\TestController@myTickets');
    Route::get('ticket', 'Api\v1\TestController@getTicketById');
    /*
     * Newly added
     */
    Route::get('ticket/customers-custom', 'Api\v1\TestController@getCustomersWith');

    Route::get('generate/token', 'Api\v1\TestController@generateToken');
    Route::get('get/user', 'Api\v1\TestController@getAuthUser');
});
/**
 * Update module
 */
Route::get('database-update', ['as' => 'database.update', 'uses' => 'Update\UpgradeController@databaseUpdate']);
Route::get('database-upgrade', ['as' => 'database', 'uses' => 'Update\UpgradeController@databaseUpgrade']);
Route::get('file-update', ['as' => 'file.update', 'uses' => 'Update\UpgradeController@fileUpdate']);
Route::get('file-upgrade', ['as' => 'file.upgrade', 'uses' => 'Update\UpgradeController@fileUpgrading']);

/**
 * Webhook
 */
\Event::listen('ticket.details', function($details) {
    $api_control = new \App\Http\Controllers\Common\ApiSettings();
    $api_control->ticketDetailEvent($details);
});
