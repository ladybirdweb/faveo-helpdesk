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
Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => 'update', 'middleware' => 'install'], function () {
        Auth::routes();
        Route::post('login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'post.login']);
        Route::post('auth/register', ['uses' => 'Auth\AuthController@postRegister', 'as' => 'post.register']);
        Route::post('password/reset', ['uses' => 'Auth\PasswordController@reset', 'as' => 'post.reset']);
        Route::get('auth/logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'get.logout']);
        Route::get('social/login/redirect/{provider}/{redirect?}', ['uses' => 'Auth\AuthController@redirectToProvider', 'as' => 'social.login']);
        Route::get('social/login/{provider}', ['as'=>'social.login.callback', 'uses'=>'Auth\AuthController@handleProviderCallback']);
        Route::get('social-sync', ['as'=>'social.sync', 'uses'=>'Client\helpdesk\GuestController@sync']);
    });

    /*
      |-------------------------------------------------------------------------------
      | @Anjali
      |-------------------------------------------------------------------------------
      | Here is defining entire routes for the Admin Panel
      |
     */
    Route::get('password/email/{one?}/{two?}/{three?}/{four?}/{five?}', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
    Breadcrumbs::register('password.email', function ($breadcrumbs) {
        $breadcrumbs->parent('/');
        $breadcrumbs->push('Login', url('auth/login'));
        $breadcrumbs->push('Forgot Password', url('password/email'));
    });

    // register page
    Route::get('auth/register/{one?}/{two?}/{three?}/{four?}/{five?}', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
    Breadcrumbs::register('auth.register', function ($breadcrumbs) {
        $breadcrumbs->parent('/');
        $breadcrumbs->push('Login', url('auth/login'));
        $breadcrumbs->push('Create Account', url('auth/register'));
    });

    // Auth login
    Route::get('auth/login/{one?}/{two?}/{three?}/{four?}/{five?}', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
    Breadcrumbs::register('auth.login', function ($breadcrumbs) {
        $breadcrumbs->parent('/');
        $breadcrumbs->push('Create Account', url('auth/register'));
        $breadcrumbs->push('Login', url('auth/login'));
    });

    Route::get('account/activate/{token}', ['as' => 'account.activate', 'uses' => 'Auth\AuthController@accountActivate']);
    Route::get('getmail/{token}', 'Auth\AuthController@getMail');
    Route::get('verify-otp', ['as' => 'otp-verification', 'uses' => 'Auth\AuthController@getVerifyOTP']);
    Route::post('verify-otp', ['as' => 'otp-verification', 'uses' => 'Auth\AuthController@verifyOTP']);
    Route::post('resend/opt', ['as' => 'resend-otp', 'uses' => 'Auth\AuthController@resendOTP']);

    /*
      |-------------------------------------------------------------------------------
      | Admin Routes
      |-------------------------------------------------------------------------------
      | Here is defining entire routes for the Admin Panel
      |
     */
    Route::group(['middleware' => 'roles', 'middleware' => 'auth', 'middleware' => 'install', 'middleware' => 'update'], function () {
        //Notification marking
        Route::post('mark-read/{id}', 'Common\NotificationController@markRead');
        Route::post('mark-all-read/{id}', 'Common\NotificationController@markAllRead');

        Route::get('notifications-list', ['as' => 'notification.list', 'uses' => 'Common\NotificationController@show']);
        Route::post('notification-delete/{id}', ['as' => 'notification.delete', 'uses' => 'Common\NotificationController@delete']);
        Route::get('notifications-list/delete', ['as' => 'notification.delete.all', 'uses' => 'Common\NotificationController@deleteAll']);

        Route::get('settings-notification', ['as' => 'notification.settings', 'uses' => 'Admin\helpdesk\SettingsController@notificationSettings']);
        Route::get('delete-read-notification', 'Admin\helpdesk\SettingsController@deleteReadNoti');
        Route::post('delete-notification-log', 'Admin\helpdesk\SettingsController@deleteNotificationLog');
        // resource is a function to process create,edit,read and delete
        Route::resource('groups', 'Admin\helpdesk\GroupController'); // for group module, for CRUD

        Route::resource('departments', 'Admin\helpdesk\DepartmentController'); // for departments module, for CRUD

        Route::resource('teams', 'Admin\helpdesk\TeamController'); // in teams module, for CRUD
        Route::get('/teams/show/{id}', ['as' => 'teams.show', 'uses' => 'Admin\helpdesk\TeamController@show']); /*  Get Team View */
        Breadcrumbs::register('teams.show', function ($breadcrumbs) {
            $breadcrumbs->parent('teams.index');
            $breadcrumbs->push(Lang::get('lang.show'), url('teams/{teams}/show'));
        });
        Route::get('getshow/{id}', ['as' => 'teams.getshow.list', 'uses' => 'Admin\helpdesk\TeamController@getshow']);
        Route::resource('agents', 'Admin\helpdesk\AgentController'); // in agents module, for CRUD

        Route::resource('emails', 'Admin\helpdesk\EmailsController'); // in emails module, for CRUD

        Route::resource('banlist', 'Admin\helpdesk\BanlistController'); // in banlist module, for CRUD

        Route::get('banlist/delete/{id}', ['as' => 'banlist.delete', 'uses' => 'Admin\helpdesk\BanlistController@delete']); // in banlist module, for CRUD
        /*
         * Templates
         */

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

        Route::post('postdiagno', ['as' => 'postdiagno', 'uses' => 'Admin\helpdesk\TemplateController@postDiagno']); // for getting form for diagnostic
        Route::resource('helptopic', 'Admin\helpdesk\HelptopicController'); // in helptopics module, for CRUD

        Route::resource('sla', 'Admin\helpdesk\SlaController'); // in SLA Plan module, for CRUD

        Route::resource('forms', 'Admin\helpdesk\FormController');
        Route::get('forms/add-child/{formid}', ['as' => 'forms.add.child', 'uses' => 'Admin\helpdesk\FormController@addChildForm']);
        Route::post('forms/field/{fieldid}/child', [
            'as'   => 'forms.field.child',
            'uses' => 'Admin\helpdesk\FormController@addChild',
        ]);
        Route::get('forms/render/child', [
            'as'   => 'forms.field.child',
            'uses' => 'Admin\helpdesk\FormController@renderChild',
        ]);

        Route::get('delete-forms/{id}', ['as' => 'forms.delete', 'uses' => 'Admin\helpdesk\FormController@delete']);
        //$router->model('id','getcompany');
        Route::get('job-scheduler', ['as' => 'get.job.scheder', 'uses' => 'Admin\helpdesk\SettingsController@getSchedular']); //to get ob scheduler form page

        Route::patch('post-scheduler', ['as' => 'post.job.scheduler', 'uses' => 'Admin\helpdesk\SettingsController@postSchedular']); //to update job scheduler
        Route::get('agent-profile-page/{id}', ['as' => 'agent.profile.page', 'uses' => 'Admin\helpdesk\AgentController@agent_profile']);
        Route::get('getcompany', ['as' => 'getcompany', 'uses' => 'Admin\helpdesk\SettingsController@getcompany']); // direct to company setting page

        Route::patch('postcompany/{id}', 'Admin\helpdesk\SettingsController@postcompany'); // Updating the Company table with requests
        Route::get('delete-logo', ['as' => 'delete.logo', 'uses' => 'Admin\helpdesk\SettingsController@deleteLogo']); // deleting a logo
        Route::get('getsystem', ['as' => 'getsystem', 'uses' => 'Admin\helpdesk\SettingsController@getsystem']); // direct to system setting page

        Route::patch('postsystem/{id}', 'Admin\helpdesk\SettingsController@postsystem'); // Updating the System table with requests
        Route::get('getticket', ['as' => 'getticket', 'uses' => 'Admin\helpdesk\SettingsController@getticket']); // direct to ticket setting page

        Route::patch('postticket/{id}', 'Admin\helpdesk\SettingsController@postticket'); // Updating the Ticket table with requests
        Route::get('getemail', ['as' => 'getemail', 'uses' => 'Admin\helpdesk\SettingsController@getemail']); // direct to email setting page

        Route::get('ticket/tooltip', ['as'=>'ticket.tooltip', 'uses'=>'Agent\helpdesk\TicketController@getTooltip']);

        Route::patch('postemail/{id}', 'Admin\helpdesk\SettingsController@postemail'); // Updating the Email table with requests
        // Route::get('getaccess', 'Admin\helpdesk\SettingsController@getaccess'); // direct to access setting page
        // Route::patch('postaccess/{id}', 'Admin\helpdesk\SettingsController@postaccess'); // Updating the Access table with requests
        Route::get('getresponder', ['as' => 'getresponder', 'uses' => 'Admin\helpdesk\SettingsController@getresponder']); // direct to responder setting page

        Route::patch('postresponder/{id}', 'Admin\helpdesk\SettingsController@postresponder'); // Updating the Responder table with requests
        Route::get('getalert', ['as' => 'getalert', 'uses' => 'Admin\helpdesk\SettingsController@getalert']); // direct to alert setting page

        Route::patch('postalert/{id}', 'Admin\helpdesk\SettingsController@postalert'); // Updating the Alert table with requests
        // Templates

        Route::get('security', ['as' => 'security.index', 'uses' => 'Admin\helpdesk\SecurityController@index']); // direct to security setting page
        Route::resource('close-workflow', 'Admin\helpdesk\CloseWrokflowController'); // direct to security setting page

        Route::resource('close-workflow', 'Admin\helpdesk\CloseWrokflowController'); // direct to security setting page
        Route::patch('security/{id}', ['as' => 'securitys.update', 'uses' => 'Admin\helpdesk\SecurityController@update']); // direct to security setting page
        Route::get('setting-status', ['as' => 'statuss.index', 'uses' => 'Admin\helpdesk\SettingsController@getStatuses']); // direct to status setting page

        Route::patch('status-update/{id}', ['as' => 'statuss.update', 'uses' => 'Admin\helpdesk\SettingsController@editStatuses']);

        Route::get('status/edit/{id}', ['as' => 'status.edit', 'uses' => 'Admin\helpdesk\SettingsController@getEditStatuses']);
        Route::post('status-create', ['as' => 'statuss.create', 'uses' => 'Admin\helpdesk\SettingsController@createStatuses']);
        Route::get('status-delete/{id}', ['as' => 'statuss.delete', 'uses' => 'Admin\helpdesk\SettingsController@deleteStatuses']);
        Route::get('ticket/status/{id}/{state}', ['as' => 'statuss.state', 'uses' => 'Agent\helpdesk\TicketController@updateStatuses']);
        Route::get('getratings', ['as' => 'ratings.index', 'uses' => 'Admin\helpdesk\SettingsController@RatingSettings']);

        Route::get('deleter/{rating}', ['as' => 'ratings.delete', 'uses' => 'Admin\helpdesk\SettingsController@RatingDelete']);

        Route::get('create-ratings', ['as' => 'rating.create', 'uses' => 'Admin\helpdesk\SettingsController@createRating']);
        Route::post('store-ratings', ['as' => 'rating.store', 'uses' => 'Admin\helpdesk\SettingsController@storeRating']);

        Route::get('editratings/{slug}', ['as' => 'rating.edit', 'uses' => 'Admin\helpdesk\SettingsController@editRatingSettings']);
        Route::patch('postratings/{slug}', ['as' => 'settings.rating', 'uses' => 'Admin\helpdesk\SettingsController@PostRatingSettings']);
        Route::get('remove-user-org/{id}', ['as' => 'removeuser.org', 'uses' => 'Agent\helpdesk\UserController@removeUserOrg']);
        Route::get('admin-profile', ['as' => 'admin-profile', 'uses' => 'Admin\helpdesk\ProfileController@getProfile']); /*  User profile edit get  */

        Route::get('admin-profile-edit', 'Admin\helpdesk\ProfileController@getProfileedit'); /*  Admin profile get  */
        Route::patch('admin-profile', 'Admin\helpdesk\ProfileController@postProfileedit'); /* Admin Profile Post */
        Route::patch('admin-profile-password', 'Admin\helpdesk\ProfileController@postProfilePassword'); /*  Admin Profile Password Post */
        Route::get('widgets', ['as' => 'widgets', 'uses' => 'Common\SettingsController@widgets']); /* get the create footer page for admin */

        Route::get('list-widget', 'Common\SettingsController@list_widget'); /* get the list widget page for admin */
        Route::post('edit-widget/{id}', 'Common\SettingsController@edit_widget'); /* get the create footer page for admin */
        Route::get('social-buttons', ['as' => 'social.buttons', 'uses' => 'Common\SettingsController@social_buttons']); /* get the create footer page for admin */

        Route::get('list-social-buttons', ['as' => 'list.social.buttons', 'uses' => 'Common\SettingsController@list_social_buttons']); /* get the list widget page for admin */
        Route::post('edit-widget/{id}', 'Common\SettingsController@edit_social_buttons'); /* get the create footer page for admin */
        Route::get('version-check', ['as' => 'version-check', 'uses' => 'Common\SettingsController@version_check']); /* Check version  */
        Route::post('post-version-check', ['as' => 'post-version-check', 'uses' => 'Common\SettingsController@post_version_check']); /* post Check version */
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
        /*
         * Api Settings
         */
        Route::get('api', ['as' => 'api.settings.get', 'uses' => 'Common\ApiSettings@show']);

        Route::post('api', ['as' => 'api.settings.post', 'uses' => 'Common\ApiSettings@postSettings']);
        /*
         * Error and debugging
         */
        //route for showing error and debugging setting form page
        Route::get('error-and-debugging-options', ['as' => 'err.debug.settings', 'uses' => 'Admin\helpdesk\ErrorAndDebuggingController@showSettings']);

        //route for submit error and debugging setting form page
        Route::post('post-settings', ['as' => 'post.error.debug.settings',
            'uses'                         => 'Admin\helpdesk\ErrorAndDebuggingController@postSettings', ]);
        //route to error logs table page
        Route::get('show-error-logs', [
            'as'   => 'error.logs',
            'uses' => 'Admin\helpdesk\ErrorAndDebuggingController@showErrorLogs',
        ]);

        /*
         * Approval
         */
        Route::get('approval/settings', ['as' => 'approval.settings', 'uses' => 'Agent\helpdesk\TicketController@settingsApproval']);
        Route::post('settingsUpdateApproval/settings', ['as' => 'settingsUpdateApproval.settings', 'uses' => 'Agent\helpdesk\TicketController@settingsUpdateApproval']);

        Route::get('/ticket/approval/closed', ['as' => 'closed.approvel.ticket', 'uses' => 'Agent\helpdesk\TicketController@approverClosedTicketList']); /*  Get Closed Ticket */

        Route::get('/ticket/get-approval', ['as' => 'get.approval.ticket', 'uses' => 'Agent\helpdesk\TicketController@getApproval']);  /* Get tickets in datatable */
        Route::get('/ticket/close/get-approval/{id}', ['as' => 'get.close.approval.ticket', 'uses' => 'Agent\helpdesk\TicketController@getCloseapproval']);  /* Get tickets in datatable */

        /*
         * Labels
         */

        Route::resource('labels', 'Admin\helpdesk\Label\LabelController');
        Route::get('labels-ajax', ['as'=>'labels.ajax', 'uses'=>'Admin\helpdesk\Label\LabelController@ajaxTable']);
        Route::get('labels/delete/{id}', ['as' => 'labels.destroy', 'uses' => 'Admin\helpdesk\Label\LabelController@destroy']);

        Route::get('clean-dummy-data', ['as' => 'clean-database', 'uses' => 'Admin\helpdesk\SettingsController@getCleanUpView']);
        Route::post('post-clean-dummy-data', ['as' => 'post-clean-database', 'uses' => 'Admin\helpdesk\SettingsController@postCleanDummyData']);
    });
    /*
      |------------------------------------------------------------------
      |Agent Routes
      |--------------------------------------------------------------------
      | Here defining entire Agent Panel routers
      |
      |
     */
    Route::group(['middleware' => 'role.agent', 'middleware' => 'auth', 'middleware' => 'install', 'middleware' => 'update'], function () {
        Route::post('chart-range/{date1}/{date2}', ['as' => 'post.chart', 'uses' => 'Agent\helpdesk\DashboardController@ChartData']);
        Route::get('agen1', 'Agent\helpdesk\DashboardController@ChartData');
        Route::post('chart-range', ['as' => 'post.chart', 'uses' => 'Agent\helpdesk\DashboardController@ChartData']);
        Route::post('user-chart-range/{id}/{date1}/{date2}', ['as' => 'post.user.chart', 'uses' => 'Agent\helpdesk\DashboardController@userChartData']);
        Route::get('user-agen/{id}', 'Agent\helpdesk\DashboardController@userChartData');
        Route::get('user-agen1', 'Agent\helpdesk\DashboardController@userChartData');
        Route::post('user-chart-range', ['as' => 'post.user.chart', 'uses' => 'Agent\helpdesk\DashboardController@userChartData']);
        Route::resource('user', 'Agent\helpdesk\UserController'); /* User router is used to control the CRUD of user */
        Route::get('user-export', ['as' => 'user.export', 'uses' => 'Agent\helpdesk\UserController@getExportUser']); /* User router is used to control the CRUD of user */
        Route::post('user-export', ['as' => 'user.export.post', 'uses' => 'Agent\helpdesk\UserController@exportUser']); /* User router is used to control the CRUD of user */

        Route::get('user-list', ['as' => 'user.list', 'uses' => 'Agent\helpdesk\UserController@user_list']);

        // Route::get('user/delete/{id}', ['as' => 'user.delete' , 'uses' => 'Agent\helpdesk\UserController@destroy']);
        Route::resource('organizations', 'Agent\helpdesk\OrganizationController'); /* organization router used to deal CRUD function of organization */
        Route::get('get-organization', ['as' => 'org.get.ajax', 'uses' => 'Agent\helpdesk\OrganizationController@getOrgAjax']);

        Route::get('org-list', ['as' => 'org.list', 'uses' => 'Agent\helpdesk\OrganizationController@org_list']);
        Route::get('organization-autofill', ['as' => 'post.organization.autofill', 'uses' => 'Agent\helpdesk\OrganizationController@organizationAutofill']); //auto fill organization name
        Route::get('org/delete/{id}', ['as' => 'org.delete', 'uses' => 'Agent\helpdesk\OrganizationController@destroy']);
        Route::get('org-chart/{id}', 'Agent\helpdesk\OrganizationController@orgChartData')->name('org-chart-data');
//    Route::post('org-chart-range', ['as' => 'post.org.chart', 'uses' => 'Agent\helpdesk\OrganizationController@orgChartData']);
        Route::post('org-chart-range/{id}/{date1}/{date2}', ['as' => 'post.org.chart', 'uses' => 'Agent\helpdesk\OrganizationController@orgChartData']);
        Route::get('profile', ['as' => 'profile', 'uses' => 'Agent\helpdesk\UserController@getProfile']); /*  User profile get  */

        Route::get('profile-edit', ['as' => 'agent-profile-edit', 'uses' => 'Agent\helpdesk\UserController@getProfileedit']); /*  User profile edit get  */

        Route::post('verify-number', ['as' => 'agent-verify-number', 'uses' => 'Agent\helpdesk\UserController@resendOTP']);
        Route::post('verify-number2', ['as' => 'post-agent-verify-number', 'uses' => 'Agent\helpdesk\UserController@verifyOTP']);

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
        Route::get('/newticket', ['as' => 'newticket', 'uses' => 'Agent\helpdesk\TicketController@newticket']); /*  Get Create New Ticket */

        Route::get('/newticket/autofill', ['as' => 'post.newticket.autofill', 'uses' => 'Agent\helpdesk\TicketController@autofill']);

        Route::post('/newticket/post', ['as' => 'post.newticket', 'uses' => 'Agent\helpdesk\TicketController@post_newticket']); /*  Post Create New Ticket */
        Route::get('/thread/{id}', ['as' => 'ticket.thread', 'uses' => 'Agent\helpdesk\TicketController@thread']); /*  Get Thread by ID */

        Route::post('/thread/reply/{id}', ['as' => 'ticket.reply', 'uses' => 'Agent\helpdesk\TicketController@reply']); /*  Patch Thread Reply */
        Route::patch('/internal/note/{id}', ['as' => 'Internal.note', 'uses' => 'Agent\helpdesk\TicketController@InternalNote']); /*  Patch Internal Note */
        Route::patch('/ticket/assign/{id}', ['as' => 'assign.ticket', 'uses' => 'Agent\helpdesk\TicketController@assign']); /*  Patch Ticket assigned to whom */
        Route::patch('/ticket/post/edit/{id}', ['as' => 'ticket.post.edit', 'uses' => 'Agent\helpdesk\TicketController@ticketEditPost']); /*  Patchi Ticket Edit */
        Route::post('/ticket/print/{id}', ['as' => 'ticket.print', 'uses' => 'Agent\helpdesk\TicketController@ticket_print']); /*  Get Print Ticket */
        Route::post('/ticket/close/{id}', ['as' => 'ticket.close', 'uses' => 'Agent\helpdesk\TicketController@close']); /*  Get Ticket Close */
        Route::post('/ticket/resolve/{id}', ['as' => 'ticket.resolve', 'uses' => 'Agent\helpdesk\TicketController@resolve']); /*  Get ticket Resolve */
        Route::post('/ticket/open/{id}', ['as' => 'ticket.open', 'uses' => 'Agent\helpdesk\TicketController@open']); /*  Get Ticket Open */
        Route::post('/ticket/delete/{id}', ['as' => 'ticket.delete', 'uses' => 'Agent\helpdesk\TicketController@delete']); /*  Get Ticket Delete */
        Route::get('/email/ban/{id}', ['as' => 'ban.email', 'uses' => 'Agent\helpdesk\TicketController@ban']); /*  Get Ban Email */
        Route::get('/ticket/surrender/{id}', ['as' => 'ticket.surrender', 'uses' => 'Agent\helpdesk\TicketController@surrender']); /*  Get Ticket Surrender */
        Route::get('/aaaa', 'Client\helpdesk\GuestController@ticket_number');
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
        Route::patch('user-org-edit-assign/{id}', ['as' => 'user.editassign.org', 'uses' => 'Agent\helpdesk\UserController@UsereditAssignOrg']);
        Route::patch('/user-org/{id}', 'Agent\helpdesk\UserController@User_Create_Org');
        Route::patch('/head-org/{id}', 'Agent\helpdesk\OrganizationController@Head_Org');

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

        // route for graphical reporting
        Route::get('report', ['as' => 'report.index', 'uses' => 'Agent\helpdesk\ReportController@index']); /* To show dashboard pages */

        // default route to get the data for the first time
        Route::get('help-topic-report', 'Agent\helpdesk\ReportController@chartdataHelptopic');
        // route to get the data on change
        Route::post('help-topic-report/{date1}/{date2}/{id}', ['as' => 'report.helptopic', 'uses' => 'Agent\helpdesk\ReportController@chartdataHelptopic']); /* To show dashboard pages */
        Route::post('help-topic-pdf', ['as' => 'help.topic.pdf', 'uses' => 'Agent\helpdesk\ReportController@helptopicPdf']);
        // Route to get details of agents
        Route::post('get-agents', ['as' => 'get-agents', 'uses' => 'Agent\helpdesk\UserController@getAgentDetails']);

        /*
         * Label
         */
        Route::get('labels-ticket', ['as'=>'labels.ticket', 'uses'=>'Admin\helpdesk\Label\LabelController@attachTicket']);
        Route::get('json-labels', ['as'=>'labels.json', 'uses'=>'Admin\helpdesk\Label\LabelController@getLabel']);

        /*
         * Tags
         */
        Route::get('add-tag', ['as'=>'tag.add', 'uses'=>'Agent\helpdesk\Filter\TagController@addToFilter']);
        Route::get('get-tag', ['as'=>'tag.get', 'uses'=>'Agent\helpdesk\Filter\TagController@getTag']);

        Route::group(['middleware' => ['force.option', 'role.agent']], function () {
            Route::get('tickets', ['as' => 'tickets-view', 'uses' => 'Agent\helpdesk\TicketController@getTicketsView']);
        });
        Route::get('get-filtered-tickets', ['as'=>'get-filtered-tickets', 'uses'=>'Agent\helpdesk\Filter\FilterController@getFilter']);
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
//    Route::POST('tickets/search/', function () {
//        $keyword = Illuminate\Support\Str::lower(Input::get('auto'));
//        $models = App\Model\Ticket\Tickets::where('ticket_number', '=', $keyword)->orderby('ticket_number')->take(10)->skip(0)->get();
//        $count = count($models);
//        return Illuminate\Support\Facades\Redirect::back()->with('contents', $models)->with('counts', $count);
//    });
    Route::any('getdata', function () {
        $term = Illuminate\Support\Str::lower(Input::get('term'));
        $data = Illuminate\Support\Facades\DB::table('tickets')->distinct()->select('ticket_number')->where('ticket_number', 'LIKE', $term.'%')->groupBy('ticket_number')->take(10)->get();
        foreach ($data as $v) {
            return [
                'value' => $v->ticket_number,
            ];
        }
    });

    Route::post('postform/{id}', 'Client\helpdesk\FormController@postForm'); /* post the AJAX form for create a ticket by guest user */
    Route::post('postedform', ['as'=>'client.form.post', 'uses'=>'Client\helpdesk\FormController@postedForm']); /* post the form to store the value */
    //Route::get('check', 'CheckController@getcheck'); //testing checkbox auto-populate
    //Route::post('postcheck/{id}', 'CheckController@postcheck');
    Route::get('get-helptopic-form', 'Client\helpdesk\FormController@getCustomForm')->name('get-helptopic-form');

    Route::get('home', ['as' => 'home', 'uses' => 'Client\helpdesk\WelcomepageController@index']); //guest layout

    Route::get('/', ['as' => '/', 'uses' => 'Client\helpdesk\WelcomepageController@index']);

    Route::get('create-ticket', ['as' => 'form', 'uses' => 'Client\helpdesk\FormController@getForm']); //getform
    Route::get('mytickets/{id}', ['as' => 'ticketinfo', 'uses' => 'Client\helpdesk\GuestController@singleThread']); //detail ticket information
    Route::post('checkmyticket', 'Client\helpdesk\UnAuthController@PostCheckTicket'); //ticket ckeck

    Route::get('check_ticket/{id}', ['as' => 'check_ticket', 'uses' => 'Client\helpdesk\GuestController@get_ticket_email']); //detail ticket information

    // show ticket via have a ticket
    Route::get('show-ticket/{id}/{code}', ['as' => 'show.ticket', 'uses' => 'Client\helpdesk\UnAuthController@showTicketCode']); //detail ticket information

//testing ckeditor
    //===================================================================================
    Route::group(['middleware' => 'role.user', 'middleware' => 'auth'], function () {
        Route::get('client-profile', ['as' => 'client.profile', 'uses' => 'Client\helpdesk\GuestController@getProfile']); /*  User profile get  */

        Route::get('mytickets', ['as' => 'ticket2', 'uses' => 'Client\helpdesk\GuestController@getMyticket']);
        Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']); /* Get my tickets */
        Route::patch('client-profile-edit', 'Client\helpdesk\GuestController@postProfile'); /* User Profile Post */
        Route::patch('client-profile-password', 'Client\helpdesk\GuestController@postProfilePassword'); /*  Profile Password Post */
        Route::post('post/reply/{id}', ['as' => 'client.reply', 'uses' => 'Client\helpdesk\ClientTicketController@reply']);
        Route::post('verify-client-number', ['as' => 'client-verify-number', 'uses' => 'Client\helpdesk\GuestController@resendOTP']);

        Route::post('verify-client-number2', ['as' => 'post-client-verify-number', 'uses' => 'Client\helpdesk\GuestController@verifyOTP']);
    });
    //====================================================================================
    Route::get('checkticket', 'Client\helpdesk\ClientTicketController@getCheckTicket'); /* Check your Ticket */
    Route::get('myticket', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@getMyticket']); /* Get my tickets */
    Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']); /* Get my tickets */
    Route::post('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket'); /* post Check Ticket */
    Route::get('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket');
    Route::post('post-ticket-reply/{id}', 'Client\helpdesk\FormController@post_ticket_reply');
    /*
      |============================================================
      |  Installer Routes
      |============================================================
      |  These routes are for installer
      |
     */
    Route::get('/serial', ['as' => 'serialkey', 'uses' => 'Installer\helpdesk\InstallController@serialkey']);
    Route::post('/post-serial', ['as' => 'post.serialkey', 'uses' => 'Installer\helpdesk\InstallController@postSerialKeyToFaveo']);
    Route::post('/CheckSerial', ['as' => 'CheckSerial', 'uses' => 'Installer\helpdesk\InstallController@PostSerialKey']);
    Route::get('/JavaScript-disabled', ['as' => 'js-disabled', 'uses' => 'Installer\helpdesk\InstallController@jsDisabled']);
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
    Route::get('/change-file-permission', ['as' => 'change-permission', 'uses' => 'Installer\helpdesk\InstallController@changeFilePermission']);
    /*
      |=============================================================
      |  Cron Job links
      |=============================================================
      | These links are for cron job execution
      |
     */
    Route::get('readmails', ['as' => 'readmails', 'uses' => 'Agent\helpdesk\MailController@readmails']);
    Route::get('notification', ['as' => 'notification', 'uses' => 'Agent\helpdesk\NotificationController@send_notification']);
    Route::get('auto-close-tickets', ['as' => 'auto.close', 'uses' => 'Client\helpdesk\UnAuthController@autoCloseTickets']);
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
            echo '<td>'.$value->getMethods()[0].'</td>';
            echo '<td>'.$value->getName().'</td>';
            echo '<td>'.$value->getPath().'</td>';
            echo '<td>'.$value->getActionName().'</td>';
            echo '</tr>';
        }
        echo '</table>';
    });
    /*
      |=============================================================
      |  Error Routes
      |=============================================================
     */
    Route::get('500', ['as' => 'error500', function () {
        return view('errors.500');
    }]);

    Route::get('404', ['as' => 'error404', function () {
        return view('errors.404');
    }]);

    Route::get('error-in-database-connection', ['as' => 'errordb', function () {
        return view('errors.db');
    }]);

    Route::get('unauthorized', ['as' => 'unauth', function () {
        return view('errors.unauth');
    }]);

    Route::get('board-offline', ['as' => 'board.offline', function () {
        return view('errors.offline');
    }]);

    /*
      |=============================================================
      |  Test mail Routes
      |=============================================================
     */
//    Route::get('testmail', function () {
//        $e = 'hello';
//        Config::set('mail.host', 'smtp.gmail.com');
//        \Mail::send('errors.report', ['e' => $e], function ($message) {
//            $message->to('sujitprasad4567@gmail.com', 'sujit prasad')->subject('Error');
//        });
//    });
    /*  For the crud of catogory  */
    Route::resource('category', 'Agent\kb\CategoryController');

    Route::get('category/delete/{id}', 'Agent\kb\CategoryController@destroy');
    /*  For the crud of article  */
    Route::resource('article', 'Agent\kb\ArticleController');

    Route::get('article/delete/{id}', 'Agent\kb\ArticleController@destroy');
    /* get settings */
    Route::get('kb/settings', ['as' => 'settings', 'uses' => 'Agent\kb\SettingsController@settings']);

    /* post settings */
    Route::patch('postsettings/{id}', 'Agent\kb\SettingsController@postSettings');
    //Route for administrater to access the comment
    Route::get('comment', ['as' => 'comment', 'uses' => 'Agent\kb\SettingsController@comment']);

    /* Route to define the comment should Published */
    Route::get('published/{id}', ['as' => 'published', 'uses' => 'Agent\kb\SettingsController@publish']);
    /* Route for deleting comments */
    Route::delete('deleted/{id}', ['as' => 'deleted', 'uses' => 'Agent\kb\SettingsController@delete']);
    /* Route for Profile  */
    // $router->get('profile', ['as' => 'profile', 'uses' => 'Agent\kb\SettingsController@getProfile']);
    /* Profile Update */
    // $router->patch('post-profile', ['as' => 'post-profile', 'uses' =>'Agent\kb\SettingsController@postProfile'] );
    /* Profile password Update */
    // $router->patch('post-profile-password/{id}',['as' => 'post-profile-password', 'uses' => 'Agent\kb\SettingsController@postProfilepassword']);
    /* delete Logo */
    Route::get('delete-logo/{id}', ['as' => 'delete-logo', 'uses' => 'Agent\kb\SettingsController@deleteLogo']);
    /* delete Background */
    Route::get('delete-background/{id}', ['as' => 'delete-background', 'uses' => 'Agent\kb\SettingsController@deleteBackground']);
    Route::resource('page', 'Agent\kb\PageController');

    Route::get('get-pages', ['as' => 'api.page', 'uses' => 'Agent\kb\PageController@getData']);
    Route::get('page/delete/{id}', ['as' => 'pagedelete', 'uses' => 'Agent\kb\PageController@destroy']);
    Route::get('comment/delete/{id}', ['as' => 'commentdelete', 'uses' => 'Agent\kb\SettingsController@delete']);
    Route::get('get-articles', ['as' => 'api.article', 'uses' => 'Agent\kb\ArticleController@getData']);
    Route::get('get-categorys', ['as' => 'api.category', 'uses' => 'Agent\kb\CategoryController@getData']);
    Route::get('get-comment', ['as' => 'api.comment', 'uses' => 'Agent\kb\SettingsController@getData']);

    Route::post('image', 'Agent\kb\SettingsController@image');
    Route::get('direct', function () {
        return view('direct');
    });
    // Route::get('/',['as'=>'home' , 'uses'=> 'client\kb\UserController@home'] );
    /* post the comment from show page */
    Route::post('postcomment/{slug}', ['as' => 'postcomment', 'uses' => 'Client\kb\UserController@postComment']);
    /* get the article list */

    Route::get('article-list', ['as' => 'article-list', 'uses' => 'Client\kb\UserController@getArticle']);
    // /* get search values */
    Route::get('search', ['as' => 'search', 'uses' => 'Client\kb\UserController@search']);

    /* get the selected article */
    Route::get('show/{slug}', ['as' => 'show', 'uses' => 'Client\kb\UserController@show']);

    Route::get('category-list', ['as' => 'category-list', 'uses' => 'Client\kb\UserController@getCategoryList']);

    /* get the categories with article */
    Route::get('category-list/{id}', ['as' => 'categorylist', 'uses' => 'Client\kb\UserController@getCategory']);

    Route::post('show/rating/{id}', ['as' => 'show.rating', 'uses' => 'Client\helpdesk\UnAuthController@rating']); /* Get overall Ratings */
    Route::post('show/rating2/{id}', ['as' => 'show.rating2', 'uses' => 'Client\helpdesk\UnAuthController@ratingReply']); /* Get reply Ratings */
    Route::get('show/change-status/{status}/{id}', ['as' => 'show.change.status', 'uses' => 'Client\helpdesk\UnAuthController@changeStatus']); /* Get reply Ratings */
    /* get the home page */
    Route::get('knowledgebase', ['as' => 'home', 'uses' => 'Client\kb\UserController@home']);
    /* get the faq value to user */
    // $router->get('faq',['as'=>'faq' , 'uses'=>'Client\kb\UserController@Faq'] );
    /* get the cantact page to user */
    Route::get('contact', ['as' => 'contact', 'uses' => 'Client\kb\UserController@contact']);

    /* post the cantact page to controller */
    Route::post('post-contact', ['as' => 'post-contact', 'uses' => 'Client\kb\UserController@postContact']);
    //to get the value for page content
    Route::get('pages/{name}', ['as' => 'pages', 'uses' => 'Client\kb\UserController@getPage']);

    //profile
    // $router->get('client-profile',['as' => 'client-profile', 'uses' => 'Client\kb\UserController@clientProfile']);
    // Route::patch('client-profile-edit',['as' => 'client-profile-edit', 'uses' => 'Client\kb\UserController@postClientProfile']);
    // Route::patch('client-profile-password/{id}',['as' => 'client-profile-password', 'uses' => 'Client\kb\UserController@postClientProfilePassword']);
    Route::get('/inbox/data', ['as' => 'api.inbox', 'uses' => 'Agent\helpdesk\TicketController@get_inbox']);
//    Route::get('/report', 'HomeController@getreport');
//    Route::get('/reportdata', 'HomeController@pushdata');

    /*
     * Update module
     */
    Route::get('database-update', ['as' => 'database.update', 'uses' => 'Update\UpgradeController@databaseUpdate']);
    Route::get('database-upgrade', ['as' => 'database.upgrade', 'uses' => 'Update\UpgradeController@databaseUpgrade']);
    Route::get('file-update', ['as' => 'file.update', 'uses' => 'Update\UpgradeController@fileUpdate']);
    Route::get('file-upgrade', ['as' => 'file.upgrade', 'uses' => 'Update\UpgradeController@fileUpgrading']);
    /*
     * Webhook
     */
    \Event::listen('ticket.details', function ($details) {
        $api_control = new \App\Http\Controllers\Common\ApiSettings();
        $api_control->ticketDetailEvent($details);
    });

    Route::get('test', ['as' => 'test', 'uses' => 'Common\PushNotificationController@response']);

    Route::get('mail/config/service', ['as' => 'mail.config.service', 'uses' => 'Job\MailController@serviceForm']);
    /*
     * Queue
     */

    Route::get('queue', ['as' => 'queue', 'uses' => 'Job\QueueController@index']);
    Route::get('form/queue', ['as' => 'queue.form', 'uses' => 'Job\QueueController@getForm']);

    Route::get('queue/{id}', ['as' => 'queue.edit', 'uses' => 'Job\QueueController@edit']);
    Route::post('queue/{id}', ['as' => 'queue.update', 'uses' => 'Job\QueueController@update']);
    Route::get('queue/{id}/activate', ['as' => 'queue.activate', 'uses' => 'Job\QueueController@activate']);
    Route::get('get-ticket-number', ['as' => 'get.ticket.number', 'uses' => 'Admin\helpdesk\SettingsController@getTicketNumber']);
    Route::get('genereate-pdf/{threadid}', ['as' => 'thread.pdf', 'uses' => 'Agent\helpdesk\TicketController@pdfThread']);

    /*
     * Url Settings
     */

    Route::get('url/settings', ['as' => 'url.settings', 'uses' => 'Admin\helpdesk\UrlSettingController@settings']);
    Route::patch('url/settings', ['as' => 'url.settings.post', 'uses' => 'Admin\helpdesk\UrlSettingController@postSettings']);

    /*
     * Social media settings
     */

    Route::get('social/media', ['as'=>'social', 'uses'=>'Admin\helpdesk\SocialMedia\SocialMediaController@index']);
    Route::get('social/media/{provider}', ['as'=>'social.media', 'uses'=>'Admin\helpdesk\SocialMedia\SocialMediaController@settings']);
    Route::post('social/media/{provider}', ['as'=>'social.media.post', 'uses'=>'Admin\helpdesk\SocialMedia\SocialMediaController@postSettings']);
    /*
     * Ticket_Priority Settings
     */
    Route::get('ticket/priority', ['as' => 'priority.index', 'uses' => 'Admin\helpdesk\PriorityController@priorityIndex']);
    Route::post('user/ticket/priority', ['as' => 'user.priority.index', 'uses' => 'Admin\helpdesk\PriorityController@userPriorityIndex']);

    Route::get('get_index', ['as' => 'priority.index1', 'uses' => 'Admin\helpdesk\PriorityController@priorityIndex1']);
    Route::get('ticket/priority/create', ['as' => 'priority.create', 'uses' => 'Admin\helpdesk\PriorityController@priorityCreate']);
    Route::post('ticket/priority/create1', ['as' => 'priority.create1', 'uses' => 'Admin\helpdesk\PriorityController@priorityCreate1']);
    Route::post('ticket/priority/edit1', ['as' => 'priority.edit1', 'uses' => 'Admin\helpdesk\PriorityController@priorityEdit1']);
    Route::get('ticket/priority/{ticket_priority}/edit', ['as' => 'priority.edit', 'uses' => 'Admin\helpdesk\PriorityController@priorityEdit']);
    Route::get('ticket/priority/{ticket_priority}/destroy', ['as' => 'priority.destroy', 'uses' => 'Admin\helpdesk\PriorityController@destroy']);
    // user---arindam
    Route::post('rolechangeadmin/{id}', ['as' => 'user.post.rolechangeadmin',  'uses' =>'Agent\helpdesk\UserController@changeRoleAdmin']);
    Route::post('rolechangeagent/{id}', ['as' => 'user.post.rolechangeagent',  'uses' =>'Agent\helpdesk\UserController@changeRoleAgent']);
    Route::post('rolechangeuser/{id}', ['as' => 'user.post.rolechangeuser',  'uses' =>'Agent\helpdesk\UserController@changeRoleUser']);
    Route::get('password', ['as' => 'user.changepassword',  'uses' =>'Agent\helpdesk\UserController@randomPassword']);
    Route::post('changepassword/{id}', ['as' => 'user.post.changepassword',  'uses' =>'Agent\helpdesk\UserController@randomPostPassword']);
    Route::post('delete/{id}', ['as' => 'user.post.delete',  'uses' =>'Agent\helpdesk\UserController@deleteAgent']);

    // deleted user list
    Route::get('deleted/user', ['as' => 'user.deleted', 'uses' => 'Agent\helpdesk\UserController@deletedUser']);

    Route::post('restore/{id}', ['as' => 'user.restore', 'uses' => 'Agent\helpdesk\UserController@restoreUser']);

    // Breadcrumbs::register('open.ticket', function ($breadcrumbs) {
    //     $breadcrumbs->parent('dashboard');
    //     $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.open'), route('open.ticket'));
    // });
    Route::get('swtich-language/{id}', ['as' => 'switch-user-lang', 'uses' => 'Client\helpdesk\UnAuthController@changeUserLanguage']);
});
