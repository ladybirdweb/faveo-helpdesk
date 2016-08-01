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
        Route::controllers([
            'auth' => 'Auth\AuthController',
            'password' => 'Auth\PasswordController',
        ]);
    });
    Route::get('account/activate/{token}', ['as' => 'account.activate', 'uses' => 'Auth\AuthController@accountActivate']);
    Route::get('getmail/{token}', 'Auth\AuthController@getMail');
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
        Breadcrumbs::register('notification.list', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push('All Notifications', route('notification.list'));
        });
        Route::get('notifications-list', ['as' => 'notification.list', 'uses' => 'Common\NotificationController@show']);
        Route::post('notification-delete/{id}', ['as' => 'notification.delete', 'uses' => 'Common\NotificationController@delete']);
        Breadcrumbs::register('notification.settings', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push('Notifications Settings', route('notification.settings'));
        });
        Route::get('settings-notification', ['as' => 'notification.settings', 'uses' => 'Admin\helpdesk\SettingsController@notificationSettings']);
        Route::get('delete-read-notification', 'Admin\helpdesk\SettingsController@deleteReadNoti');
        Route::post('delete-notification-log', 'Admin\helpdesk\SettingsController@deleteNotificationLog');
        // resource is a function to process create,edit,read and delete
        Route::resource('groups', 'Admin\helpdesk\GroupController'); // for group module, for CRUD
        Breadcrumbs::register('groups.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.groups'), route('groups.index'));
        });
        Breadcrumbs::register('groups.create', function ($breadcrumbs) {
            $breadcrumbs->parent('groups.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('groups.create'));
        });
        Breadcrumbs::register('groups.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('groups.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('groups/{groups}/edit'));
        });
        Route::resource('departments', 'Admin\helpdesk\DepartmentController'); // for departments module, for CRUD
        Breadcrumbs::register('departments.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.departments'), route('departments.index'));
        });
        Breadcrumbs::register('departments.create', function ($breadcrumbs) {
            $breadcrumbs->parent('departments.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('departments.create'));
        });
        Breadcrumbs::register('departments.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('departments.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('departments/{departments}/edit'));
        });
        Route::resource('teams', 'Admin\helpdesk\TeamController'); // in teams module, for CRUD
        Breadcrumbs::register('teams.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.teams'), route('teams.index'));
        });
        Breadcrumbs::register('teams.create', function ($breadcrumbs) {
            $breadcrumbs->parent('teams.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('teams.create'));
        });
        Breadcrumbs::register('teams.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('teams.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('teams/{teams}/edit'));
        });
        Route::resource('agents', 'Admin\helpdesk\AgentController'); // in agents module, for CRUD
        Breadcrumbs::register('agents.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.agents'), route('agents.index'));
        });
        Breadcrumbs::register('agents.create', function ($breadcrumbs) {
            $breadcrumbs->parent('agents.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('agents.create'));
        });
        Breadcrumbs::register('agents.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('agents.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('agents/{agents}/edit'));
        });
        Route::resource('emails', 'Admin\helpdesk\EmailsController'); // in emails module, for CRUD
        Breadcrumbs::register('emails.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.emails'), route('emails.index'));
        });
        Breadcrumbs::register('emails.create', function ($breadcrumbs) {
            $breadcrumbs->parent('emails.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('emails.create'));
        });
        Breadcrumbs::register('emails.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('emails.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('emails/{emails}/edit'));
        });
        Route::resource('banlist', 'Admin\helpdesk\BanlistController'); // in banlist module, for CRUD
        Breadcrumbs::register('banlist.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.banlists'), route('banlist.index'));
        });
        Breadcrumbs::register('banlist.create', function ($breadcrumbs) {
            $breadcrumbs->parent('banlist.index');
            $breadcrumbs->push(Lang::get('lang.add'), route('banlist.create'));
        });
        Breadcrumbs::register('banlist.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('banlist.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('agents/{agents}/edit'));
        });
        Route::get('banlist/delete/{id}', ['as' => 'banlist.delete', 'uses' => 'Admin\helpdesk\BanlistController@delete']); // in banlist module, for CRUD
        /*
         * Templates
         */
        Breadcrumbs::register('template-sets.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push('All Template sets', route('template-sets.index'));
        });
        Breadcrumbs::register('show.templates', function ($breadcrumbs) {
            $page = App\Model\Common\Template::whereId(1)->first();
            $breadcrumbs->parent('template-sets.index');
            $breadcrumbs->push('All Templates', route('show.templates', $page->id));
        });
        Breadcrumbs::register('templates.edit', function ($breadcrumbs) {
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
        Breadcrumbs::register('getdiagno', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.email_diagnostic'), route('getdiagno'));
        });
        Route::post('postdiagno', ['as' => 'postdiagno', 'uses' => 'Admin\helpdesk\TemplateController@postDiagno']); // for getting form for diagnostic
        Route::resource('helptopic', 'Admin\helpdesk\HelptopicController'); // in helptopics module, for CRUD
        Breadcrumbs::register('helptopic.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.help_topics'), route('helptopic.index'));
        });
        Breadcrumbs::register('helptopic.create', function ($breadcrumbs) {
            $breadcrumbs->parent('helptopic.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('helptopic.create'));
        });
        Breadcrumbs::register('helptopic.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('helptopic.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('helptopic/{helptopic}/edit'));
        });
        Route::resource('sla', 'Admin\helpdesk\SlaController'); // in SLA Plan module, for CRUD
        Breadcrumbs::register('sla.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.sla-plans'), route('sla.index'));
        });
        Breadcrumbs::register('sla.create', function ($breadcrumbs) {
            $breadcrumbs->parent('sla.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('sla.create'));
        });
        Breadcrumbs::register('sla.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('sla.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('sla/{sla}/edit'));
        });
        Route::resource('forms', 'Admin\helpdesk\FormController');
        Route::post('forms/field/{fieldid}/child', [
            'as' => 'forms.field.child',
            'uses' => 'Admin\helpdesk\FormController@addChild',
        ]);
        Route::get('forms/render/child', [
            'as' => 'forms.field.child',
            'uses' => 'Admin\helpdesk\FormController@renderChild',
        ]);
        Breadcrumbs::register('forms.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.forms'), route('forms.index'));
        });
        Breadcrumbs::register('forms.create', function ($breadcrumbs) {
            $breadcrumbs->parent('forms.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('forms.create'));
        });
        Breadcrumbs::register('forms.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('forms.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('forms/{forms}/edit'));
        });
        Breadcrumbs::register('forms.show', function ($breadcrumbs) {
            $breadcrumbs->parent('forms.index');
            $breadcrumbs->push(Lang::get('lang.view'), url('forms/{forms}'));
        });
        Route::get('delete-forms/{id}', ['as' => 'forms.delete', 'uses' => 'Admin\helpdesk\FormController@delete']);
        //$router->model('id','getcompany');
        Route::get('job-scheduler', ['as' => 'get.job.scheder', 'uses' => 'Admin\helpdesk\SettingsController@getSchedular']); //to get ob scheduler form page
        Breadcrumbs::register('get.job.scheder', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.cron-jobs'), route('get.job.scheder'));
        });
        Route::patch('post-scheduler', ['as' => 'post.job.scheduler', 'uses' => 'Admin\helpdesk\SettingsController@postSchedular']); //to update job scheduler
        Route::get('agent-profile-page/{id}', ['as' => 'agent.profile.page', 'uses' => 'Admin\helpdesk\AgentController@agent_profile']);
        Route::get('getcompany', ['as' => 'getcompany', 'uses' => 'Admin\helpdesk\SettingsController@getcompany']); // direct to company setting page
        Breadcrumbs::register('getcompany', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.company_settings'), route('getcompany'));
        });
        Route::patch('postcompany/{id}', 'Admin\helpdesk\SettingsController@postcompany'); // Updating the Company table with requests
        Route::get('delete-logo', ['as' => 'delete.logo', 'uses' => 'Admin\helpdesk\SettingsController@deleteLogo']); // deleting a logo
        Route::get('getsystem', ['as' => 'getsystem', 'uses' => 'Admin\helpdesk\SettingsController@getsystem']); // direct to system setting page
        Breadcrumbs::register('getsystem', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.system-settings'), route('getsystem'));
        });
        Route::patch('postsystem/{id}', 'Admin\helpdesk\SettingsController@postsystem'); // Updating the System table with requests
        Route::get('getticket', ['as' => 'getticket', 'uses' => 'Admin\helpdesk\SettingsController@getticket']); // direct to ticket setting page
        Breadcrumbs::register('getticket', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.ticket-setting'), route('getticket'));
        });
        Route::patch('postticket/{id}', 'Admin\helpdesk\SettingsController@postticket'); // Updating the Ticket table with requests
        Route::get('getemail', ['as' => 'getemail', 'uses' => 'Admin\helpdesk\SettingsController@getemail']); // direct to email setting page
        Breadcrumbs::register('getemail', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.email-settings'), route('getemail'));
        });
        Route::patch('postemail/{id}', 'Admin\helpdesk\SettingsController@postemail'); // Updating the Email table with requests
        // Route::get('getaccess', 'Admin\helpdesk\SettingsController@getaccess'); // direct to access setting page
        // Route::patch('postaccess/{id}', 'Admin\helpdesk\SettingsController@postaccess'); // Updating the Access table with requests
        Route::get('getresponder', ['as' => 'getresponder', 'uses' => 'Admin\helpdesk\SettingsController@getresponder']); // direct to responder setting page
        Breadcrumbs::register('getresponder', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.auto_responce'), route('getresponder'));
        });
        Route::patch('postresponder/{id}', 'Admin\helpdesk\SettingsController@postresponder'); // Updating the Responder table with requests
        Route::get('getalert', ['as' => 'getalert', 'uses' => 'Admin\helpdesk\SettingsController@getalert']); // direct to alert setting page
        Breadcrumbs::register('getalert', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.alert_notices_setitngs'), route('getalert'));
        });
        Route::patch('postalert/{id}', 'Admin\helpdesk\SettingsController@postalert'); // Updating the Alert table with requests
        // Templates
        Breadcrumbs::register('security.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.security_settings'), route('security.index'));
        });
        // Templates > Upload Templates
        Breadcrumbs::register('security.create', function ($breadcrumbs) {
            $breadcrumbs->parent('security.index');
            $breadcrumbs->push('Upload security', route('security.create'));
        });
        // Templates > [Templates Name]
        Breadcrumbs::register('security.show', function ($breadcrumbs, $photo) {
            $breadcrumbs->parent('security.index');
            $breadcrumbs->push($photo->title, route('security.show', $photo->id));
        });
        // Templates > [Templates Name] > Edit Templates
        Breadcrumbs::register('security.edit', function ($breadcrumbs, $photo) {
            $breadcrumbs->parent('security.show', $photo);
            $breadcrumbs->push('Edit security', route('security.edit', $photo->id));
        });
        Route::get('security', ['as' => 'security.index', 'uses' => 'Admin\helpdesk\SecurityController@index']); // direct to security setting page
        Route::resource('close-workflow', 'Admin\helpdesk\CloseWrokflowController'); // direct to security setting page
        Breadcrumbs::register('close-workflow.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.close_ticket_workflow_settings'), route('close-workflow.index'));
        });
        Route::resource('close-workflow', 'Admin\helpdesk\CloseWrokflowController'); // direct to security setting page
        Route::patch('security/{id}', ['as' => 'securitys.update', 'uses' => 'Admin\helpdesk\SecurityController@update']); // direct to security setting page
        Route::get('setting-status', ['as' => 'statuss.index', 'uses' => 'Admin\helpdesk\SettingsController@getStatuses']); // direct to status setting page
        Breadcrumbs::register('statuss.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.status_settings'), route('statuss.index'));
        });
        Route::patch('status-update/{id}', ['as' => 'statuss.update', 'uses' => 'Admin\helpdesk\SettingsController@editStatuses']);
        Breadcrumbs::register('statuss.create', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push('Create Status', route('statuss.create'));
        });
        Route::get('status/edit/{id}', ['as' => 'status.edit', 'uses' => 'Admin\helpdesk\SettingsController@getEditStatuses']);
        Route::post('status-create', ['as' => 'statuss.create', 'uses' => 'Admin\helpdesk\SettingsController@createStatuses']);
        Route::get('status-delete/{id}', ['as' => 'statuss.delete', 'uses' => 'Admin\helpdesk\SettingsController@deleteStatuses']);
        Route::get('ticket/status/{id}/{state}', ['as' => 'statuss.state', 'uses' => 'Agent\helpdesk\TicketController@updateStatuses']);
        Route::get('getratings', ['as' => 'ratings.index', 'uses' => 'Admin\helpdesk\SettingsController@RatingSettings']);
        Breadcrumbs::register('ratings.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.ratings_settings'), route('ratings.index'));
        });
        Route::get('deleter/{rating}', ['as' => 'ratings.delete', 'uses' => 'Admin\helpdesk\SettingsController@RatingDelete']);
        Breadcrumbs::register('rating.create', function ($breadcrumbs) {
            $breadcrumbs->parent('ratings.index');
            $breadcrumbs->push('Create Ratings', route('rating.create'));
        });
        Route::get('create-ratings', ['as' => 'rating.create', 'uses' => 'Admin\helpdesk\SettingsController@createRating']);
        Route::post('store-ratings', ['as' => 'rating.store', 'uses' => 'Admin\helpdesk\SettingsController@storeRating']);
        Breadcrumbs::register('rating.edit', function ($breadcrumbs) {
            $page = App\Model\helpdesk\Ratings\Rating::whereId(1)->first();
            $breadcrumbs->parent('ratings.index');
            $breadcrumbs->push('Edit Ratings');
        });
        Route::get('editratings/{slug}', ['as' => 'rating.edit', 'uses' => 'Admin\helpdesk\SettingsController@editRatingSettings']);
        Route::patch('postratings/{slug}', ['as' => 'settings.rating', 'uses' => 'Admin\helpdesk\SettingsController@PostRatingSettings']);
        Route::get('remove-user-org/{id}', ['as' => 'removeuser.org', 'uses' => 'Agent\helpdesk\UserController@removeUserOrg']);
        Route::get('admin-profile', ['as' => 'admin-profile', 'uses' => 'Admin\helpdesk\ProfileController@getProfile']); /*  User profile edit get  */
        Breadcrumbs::register('admin-profile', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.profile'), route('admin-profile'));
        });
        Route::get('admin-profile-edit', 'Admin\helpdesk\ProfileController@getProfileedit'); /*  Admin profile get  */
        Route::patch('admin-profile', 'Admin\helpdesk\ProfileController@postProfileedit'); /* Admin Profile Post */
        Route::patch('admin-profile-password', 'Admin\helpdesk\ProfileController@postProfilePassword'); /*  Admin Profile Password Post */
        Route::get('widgets', ['as' => 'widgets', 'uses' => 'Common\SettingsController@widgets']); /* get the create footer page for admin */
        Breadcrumbs::register('widgets', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.widget-settings'), route('widgets'));
        });
        Route::get('list-widget', 'Common\SettingsController@list_widget'); /* get the list widget page for admin */
        Route::post('edit-widget/{id}', 'Common\SettingsController@edit_widget'); /* get the create footer page for admin */
        Route::get('social-buttons', ['as' => 'social.buttons', 'uses' => 'Common\SettingsController@social_buttons']); /* get the create footer page for admin */
        Breadcrumbs::register('social.buttons', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.social-widget-settings'), route('social.buttons'));
        });
        Route::get('list-social-buttons', ['as' => 'list.social.buttons', 'uses' => 'Common\SettingsController@list_social_buttons']); /* get the list widget page for admin */
        Route::post('edit-widget/{id}', 'Common\SettingsController@edit_social_buttons'); /* get the create footer page for admin */
        Route::get('version-check', ['as' => 'version-check', 'uses' => 'Common\SettingsController@version_check']); /* Check version  */
        Route::post('post-version-check', ['as' => 'post-version-check', 'uses' => 'Common\SettingsController@post_version_check']); /* post Check version */
        Route::get('admin', ['as' => 'setting', 'uses' => 'Admin\helpdesk\SettingsController@settings']);
        Breadcrumbs::register('setting', function ($breadcrumbs) {
            $breadcrumbs->push(Lang::get('lang.admin_panel'), route('setting'));
        });
        Route::get('plugins', ['as' => 'plugins', 'uses' => 'Common\SettingsController@Plugins']);
        Breadcrumbs::register('plugins', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.plugins'), route('plugins'));
        });
        Route::get('getplugin', ['as' => 'get.plugin', 'uses' => 'Common\SettingsController@GetPlugin']);
        Route::post('post-plugin', ['as' => 'post.plugin', 'uses' => 'Common\SettingsController@PostPlugins']);
        Route::get('getconfig', ['as' => 'get.config', 'uses' => 'Common\SettingsController@fetchConfig']);
        Route::get('plugin/delete/{slug}', ['as' => 'delete.plugin', 'uses' => 'Common\SettingsController@DeletePlugin']);
        Route::get('plugin/status/{slug}', ['as' => 'status.plugin', 'uses' => 'Common\SettingsController@StatusPlugin']);
        //Routes for showing language table and switching language
        Route::get('languages', ['as' => 'LanguageController', 'uses' => 'Admin\helpdesk\LanguageController@index']);
        Breadcrumbs::register('LanguageController', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.language-settings'), route('LanguageController'));
        });
        Route::get('get-languages', ['as' => 'getAllLanguages', 'uses' => 'Admin\helpdesk\LanguageController@getLanguages']);
        Route::get('change-language/{lang}', ['as' => 'lang.switch', 'uses' => 'Admin\helpdesk\LanguageController@switchLanguage']);
        //Route for download language template package
        Route::get('/download-template', ['as' => 'download', 'uses' => 'Admin\helpdesk\LanguageController@download']);
        //Routes for language file upload form-----------You may want to use csrf protection for these route--------------
        Route::post('language/add', 'Admin\helpdesk\LanguageController@postForm');
        Route::get('language/add', ['as' => 'add-language', 'uses' => 'Admin\helpdesk\LanguageController@getForm']);
        Breadcrumbs::register('add-language', function ($breadcrumbs) {
            $breadcrumbs->parent('LanguageController');
            $breadcrumbs->push(Lang::get('lang.add'), route('add-language'));
        });
        //Routes for  delete language package
        Route::get('delete-language/{lang}', ['as' => 'lang.delete', 'uses' => 'Admin\helpdesk\LanguageController@deleteLanguage']);
        Route::get('generate-api-key', 'Admin\helpdesk\SettingsController@GenerateApiKey'); // route to generate api key
        Route::post('validating-email-settings', ['as' => 'validating.email.settings', 'uses' => 'Admin\helpdesk\EmailsController@validatingEmailSettings']); // route to check email input validation
        Route::post('validating-email-settings-on-update/{id}', ['as' => 'validating.email.settings.update', 'uses' => 'Admin\helpdesk\EmailsController@validatingEmailSettingsUpdate']); // route to check email input validation
        Route::get('workflow', ['as' => 'workflow', 'uses' => 'Admin\helpdesk\WorkflowController@index']);
        Breadcrumbs::register('workflow', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.ticket_workflow'), route('workflow'));
        });
        Route::get('workflow-list', ['as' => 'workflow.list', 'uses' => 'Admin\helpdesk\WorkflowController@workFlowList']);
        Route::get('workflow/create', ['as' => 'workflow.create', 'uses' => 'Admin\helpdesk\WorkflowController@create']);
        Breadcrumbs::register('workflow.create', function ($breadcrumbs) {
            $breadcrumbs->parent('workflow');
            $breadcrumbs->push(Lang::get('lang.create'), route('workflow.create'));
        });
        Route::post('workflow/store', ['as' => 'workflow.store', 'uses' => 'Admin\helpdesk\WorkflowController@store']);
        Route::get('workflow/edit/{id}', ['as' => 'workflow.edit', 'uses' => 'Admin\helpdesk\WorkflowController@edit']);
        Breadcrumbs::register('workflow.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('workflow');
            $breadcrumbs->push(Lang::get('lang.edit'), url('workflow/edit/{id}'));
        });
        Route::post('workflow/update/{id}', ['as' => 'workflow.update', 'uses' => 'Admin\helpdesk\WorkflowController@update']);
        Route::get('workflow/action-rule/{id}', ['as' => 'workflow.dept', 'uses' => 'Admin\helpdesk\WorkflowController@selectAction']);
        Route::get('workflow/delete/{id}', ['as' => 'workflow.delete', 'uses' => 'Admin\helpdesk\WorkflowController@destroy']);
        /*
         * Api Settings
         */
        Route::get('api', ['as' => 'api.settings.get', 'uses' => 'Common\ApiSettings@show']);
        Breadcrumbs::register('api.settings.get', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.api_settings'), route('api.settings.get'));
        });
        Route::post('api', ['as' => 'api.settings.post', 'uses' => 'Common\ApiSettings@postSettings']);
        /*
         * Error and debugging
         */
        //route for showing error and debugging setting form page
        Route::get('error-and-debugging-options', ['as' => 'err.debug.settings', 'uses' => 'Admin\helpdesk\ErrorAndDebuggingController@showSettings']);
        Breadcrumbs::register('err.debug.settings', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.error-debug-settings'), route('err.debug.settings'));
        });
        //route for submit error and debugging setting form page
        Route::post('post-settings', ['as' => 'post.error.debug.settings',
            'uses' => 'Admin\helpdesk\ErrorAndDebuggingController@postSettings',]);
        //route to error logs table page
        Route::get('show-error-logs', [
            'as' => 'error.logs',
            'uses' => 'Admin\helpdesk\ErrorAndDebuggingController@showErrorLogs',
        ]);
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
        Breadcrumbs::register('user.index', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.user_directory'), route('user.index'));
        });
        Breadcrumbs::register('user.create', function ($breadcrumbs) {
            $breadcrumbs->parent('user.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('user.create'));
        });
        Breadcrumbs::register('user.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('user.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('user/{user}/edit'));
        });
        Breadcrumbs::register('user.show', function ($breadcrumbs) {
            $breadcrumbs->parent('user.index');
            $breadcrumbs->push(Lang::get('lang.view-profile'), url('user/{user}'));
        });
        Route::get('user-list', ['as' => 'user.list', 'uses' => 'Agent\helpdesk\UserController@user_list']);
        // Route::get('user/delete/{id}', ['as' => 'user.delete' , 'uses' => 'Agent\helpdesk\UserController@destroy']);
        Route::resource('organizations', 'Agent\helpdesk\OrganizationController'); /* organization router used to deal CRUD function of organization */
        Route::get('get-organization',['as'=>'org.get.ajax','uses'=>'Agent\helpdesk\OrganizationController@getOrgAjax']);
        Breadcrumbs::register('organizations.index', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.organizations'), route('organizations.index'));
        });
        Breadcrumbs::register('organizations.create', function ($breadcrumbs) {
            $breadcrumbs->parent('organizations.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('organizations.create'));
        });
        Breadcrumbs::register('organizations.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('organizations.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('organizations/{organizations}/edit'));
        });
        Breadcrumbs::register('organizations.show', function ($breadcrumbs) {
            $breadcrumbs->parent('organizations.index');
            $breadcrumbs->push(Lang::get('lang.view_organization_profile'), url('organizations/{organizations}'));
        });
        Route::get('org-list', ['as' => 'org.list', 'uses' => 'Agent\helpdesk\OrganizationController@org_list']);
        Route::get('org/delete/{id}', ['as' => 'org.delete', 'uses' => 'Agent\helpdesk\OrganizationController@destroy']);
        Route::get('org-chart/{id}', 'Agent\helpdesk\OrganizationController@orgChartData');
//    Route::post('org-chart-range', ['as' => 'post.org.chart', 'uses' => 'Agent\helpdesk\OrganizationController@orgChartData']);
        Route::post('org-chart-range/{id}/{date1}/{date2}', ['as' => 'post.org.chart', 'uses' => 'Agent\helpdesk\OrganizationController@orgChartData']);
        Route::get('profile', ['as' => 'profile', 'uses' => 'Agent\helpdesk\UserController@getProfile']); /*  User profile get  */
        Breadcrumbs::register('profile', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.my_profile'), route('profile'));
        });
        Route::get('profile-edit', ['as' => 'agent-profile-edit', 'uses' => 'Agent\helpdesk\UserController@getProfileedit']); /*  User profile edit get  */
        Breadcrumbs::register('agent-profile-edit', function ($breadcrumbs) {
            $breadcrumbs->parent('profile');
            $breadcrumbs->push(Lang::get('lang.edit'), url('profile-edit'));
        });
        Route::patch('agent-profile', ['as' => 'agent-profile', 'uses' => 'Agent\helpdesk\UserController@postProfileedit']); /* User Profile Post */
        Route::patch('agent-profile-password/{id}', 'Agent\helpdesk\UserController@postProfilePassword'); /*  Profile Password Post */
        Route::get('canned/list', ['as' => 'canned.list', 'uses' => 'Agent\helpdesk\CannedController@index']); /* Canned list */
        Breadcrumbs::register('canned.list', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.canned_response'), route('canned.list'));
        });
        Route::get('canned/create', ['as' => 'canned.create', 'uses' => 'Agent\helpdesk\CannedController@create']); /* Canned create */
        Breadcrumbs::register('canned.create', function ($breadcrumbs) {
            $breadcrumbs->parent('canned.list');
            $breadcrumbs->push(Lang::get('lang.create'), route('canned.create'));
        });
        Route::patch('canned/store', ['as' => 'canned.store', 'uses' => 'Agent\helpdesk\CannedController@store']); /* Canned store */
        Route::get('canned/edit/{id}', ['as' => 'canned.edit', 'uses' => 'Agent\helpdesk\CannedController@edit']); /* Canned edit */
        Breadcrumbs::register('canned.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('canned.list');
            $breadcrumbs->push(Lang::get('lang.edit'), url('canned/edit/{id}'));
        });
        Route::patch('canned/update/{id}', ['as' => 'canned.update', 'uses' => 'Agent\helpdesk\CannedController@update']); /* Canned update */
        Route::get('canned/show/{id}', ['as' => 'canned.show', 'uses' => 'Agent\helpdesk\CannedController@show']); /* Canned show */
        Route::delete('canned/destroy/{id}', ['as' => 'canned.destroy', 'uses' => 'Agent\helpdesk\CannedController@destroy']); /* Canned delete */
        Route::get('/test', ['as' => 'thr', 'uses' => 'Agent\helpdesk\MailController@fetchdata']); /*  Fetch Emails */
        Route::get('/ticket', ['as' => 'ticket', 'uses' => 'Agent\helpdesk\TicketController@ticket_list']); /*  Get Ticket */
        Route::get('/ticket/inbox', ['as' => 'inbox.ticket', 'uses' => 'Agent\helpdesk\TicketController@inbox_ticket_list']); /*  Get Inbox Ticket */
        Breadcrumbs::register('inbox.ticket', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.inbox'), route('inbox.ticket'));
        });
        Route::get('/ticket/get-inbox', ['as' => 'get.inbox.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_inbox']);  /* Get tickets in datatable */
        Route::get('/ticket/open', ['as' => 'open.ticket', 'uses' => 'Agent\helpdesk\TicketController@open_ticket_list']); /*  Get Open Ticket */
        Breadcrumbs::register('open.ticket', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.open'), route('open.ticket'));
        });
        Route::get('/ticket/get-open', ['as' => 'get.open.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_open']);  /* Get tickets in datatable */
        Route::get('/ticket/answered', ['as' => 'answered.ticket', 'uses' => 'Agent\helpdesk\TicketController@answered_ticket_list']); /*  Get Answered Ticket */
        Breadcrumbs::register('answered.ticket', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.answered'), route('answered.ticket'));
        });
        Route::get('/ticket/get-answered', ['as' => 'get.answered.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_answered']);  /* Get tickets in datatable */
        Route::get('/ticket/myticket', ['as' => 'myticket.ticket', 'uses' => 'Agent\helpdesk\TicketController@myticket_ticket_list']); /*  Get Tickets Assigned to logged user */
        Breadcrumbs::register('myticket.ticket', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.my_tickets'), route('myticket.ticket'));
        });
        Route::get('/ticket/get-myticket', ['as' => 'get.myticket.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_myticket']);  /* Get tickets in datatable */
        Route::get('/ticket/overdue', ['as' => 'overdue.ticket', 'uses' => 'Agent\helpdesk\TicketController@overdue_ticket_list']); /*  Get Overdue Ticket */
        Breadcrumbs::register('overdue.ticket', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.overdue'), route('overdue.ticket'));
        });
        Route::get('/ticket/get-overdue', ['as' => 'get.overdue.ticket', 'uses' => 'Agent\helpdesk\TicketController@getOverdueTickets']); /*  Get Overdue Ticket */
        Route::get('/ticket/closed', ['as' => 'closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@closed_ticket_list']); /*  Get Closed Ticket */
        Breadcrumbs::register('closed.ticket', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.closed'), route('closed.ticket'));
        });
        Route::get('/ticket/get-closed', ['as' => 'get.closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_closed']);  /* Get tickets in datatable */
        Route::get('/ticket/assigned', ['as' => 'assigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@assigned_ticket_list']); /*  Get Assigned Ticket */
        Breadcrumbs::register('assigned.ticket', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.assigned'), route('assigned.ticket'));
        });
        Route::get('/ticket/get-assigned', ['as' => 'get.assigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_assigned']);  /* Get tickets in datatable */
        Route::get('/newticket', ['as' => 'newticket', 'uses' => 'Agent\helpdesk\TicketController@newticket']); /*  Get Create New Ticket */
        Breadcrumbs::register('newticket', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');

            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.create'), route('newticket'));
        });
        Route::post('/newticket/post', ['as' => 'post.newticket', 'uses' => 'Agent\helpdesk\TicketController@post_newticket']); /*  Post Create New Ticket */
        Route::get('/thread/{id}', ['as' => 'ticket.thread', 'uses' => 'Agent\helpdesk\TicketController@thread']); /*  Get Thread by ID */
        Breadcrumbs::register('ticket.thread', function ($breadcrumbs, $id) {
            $breadcrumbs->parent('dashboard');
            $ticket_number = App\Model\helpdesk\Ticket\Tickets::where('id', '=', $id)->first();
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . $ticket_number->ticket_number, url('/thread/{id}'));
        });
        Route::post('/thread/reply/{id}', ['as' => 'ticket.reply', 'uses' => 'Agent\helpdesk\TicketController@reply']); /*  Patch Thread Reply */
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
        Route::get('trash', ['as' => 'get-trash', 'uses' => 'Agent\helpdesk\TicketController@trash']); /* To show Deleted Tickets */
        Breadcrumbs::register('get-trash', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.trash'), route('get-trash'));
        });
        Route::get('/ticket/trash', ['as' => 'get.trash.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_trash']);  /* Get tickets in datatable */
        Route::get('unassigned', ['as' => 'unassigned', 'uses' => 'Agent\helpdesk\TicketController@unassigned']); /* To show Unassigned Tickets */
        Breadcrumbs::register('unassigned', function ($breadcrumbs) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.tickets') . '&nbsp; > &nbsp;' . Lang::get('lang.unassigned'), route('unassigned'));
        });
        Route::get('/ticket/unassigned', ['as' => 'get.unassigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_unassigned']);  /* Get tickets in datatable */
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Agent\helpdesk\DashboardController@index']); /* To show dashboard pages */
        Breadcrumbs::register('dashboard', function ($breadcrumbs) {
            //$breadcrumbs->parent('/');
            $breadcrumbs->push(Lang::get('lang.dashboard'), route('dashboard'));
        });
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
        Breadcrumbs::register('dept.open.ticket', function ($breadcrumbs, $dept) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.department') . '&nbsp; > &nbsp;' . $dept . '&nbsp; > &nbsp;' . Lang::get('lang.open_tickets'), url('/{dept}/open'));
        });
        Route::get('/{dept}/assigned', ['as' => 'dept.inprogress.ticket', 'uses' => 'Agent\helpdesk\TicketController@deptinprogress']); // Inprogress
        Breadcrumbs::register('dept.inprogress.ticket', function ($breadcrumbs, $dept) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.department') . '&nbsp; > &nbsp;' . $dept . '&nbsp; > &nbsp;' . Lang::get('lang.assigned_tickets'), url('/{dept}/inprogress'));
        });
        Route::get('/{dept}/closed', ['as' => 'dept.closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@deptclose']); // Closed
        Breadcrumbs::register('dept.closed.ticket', function ($breadcrumbs, $dept) {
            $breadcrumbs->parent('dashboard');
            $breadcrumbs->push(Lang::get('lang.department') . '&nbsp; > &nbsp;' . $dept . '&nbsp; > &nbsp;' . Lang::get('lang.closed_tickets'), url('/{dept}/closed'));
        });
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
//    Route::POST('tickets/search/', function () {
//        $keyword = Illuminate\Support\Str::lower(Input::get('auto'));
//        $models = App\Model\Ticket\Tickets::where('ticket_number', '=', $keyword)->orderby('ticket_number')->take(10)->skip(0)->get();
//        $count = count($models);
//        return Illuminate\Support\Facades\Redirect::back()->with('contents', $models)->with('counts', $count);
//    });
    Route::any('getdata', function () {
        $term = Illuminate\Support\Str::lower(Input::get('term'));
        $data = Illuminate\Support\Facades\DB::table('tickets')->distinct()->select('ticket_number')->where('ticket_number', 'LIKE', $term . '%')->groupBy('ticket_number')->take(10)->get();
        foreach ($data as $v) {
            return [
                'value' => $v->ticket_number,
            ];
        }
    });

    Route::post('postform/{id}', 'Client\helpdesk\FormController@postForm'); /* post the AJAX form for create a ticket by guest user */
    Route::post('postedform', 'Client\helpdesk\FormController@postedForm'); /* post the form to store the value */
    Route::get('check', 'CheckController@getcheck'); //testing checkbox auto-populate
    Route::post('postcheck/{id}', 'CheckController@postcheck');
    Route::get('get-helptopic-form', 'Client\helpdesk\FormController@getCustomForm');
    Breadcrumbs::register('home', function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('home'));
    });
    Route::get('home', ['as' => 'home', 'uses' => 'Client\helpdesk\WelcomepageController@index']); //guest layout
    Breadcrumbs::register('/', function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('/'));
    });
    Route::get('/', ['as' => '/', 'uses' => 'Client\helpdesk\WelcomepageController@index']);
    Breadcrumbs::register('form', function ($breadcrumbs) {
        $breadcrumbs->push('Create Ticket', route('form'));
    });
    Route::get('create-ticket', ['as' => 'form', 'uses' => 'Client\helpdesk\FormController@getForm']); //getform
    Route::get('mytickets/{id}', ['as' => 'ticketinfo', 'uses' => 'Client\helpdesk\GuestController@singleThread']); //detail ticket information
    Route::post('checkmyticket', 'Client\helpdesk\UnAuthController@PostCheckTicket'); //ticket ckeck

    Route::get('check_ticket/{id}', ['as' => 'check_ticket', 'uses' => 'Client\helpdesk\GuestController@get_ticket_email']); //detail ticket information
    Breadcrumbs::register('check_ticket', function ($breadcrumbs, $id) {
        $page = \App\Model\helpdesk\Ticket\Tickets::whereId(1)->first();
        $breadcrumbs->parent('ticket2');
        $breadcrumbs->push('Check Ticket');
    });
// show ticket via have a ticket
    Route::get('show-ticket/{id}/{code}', ['as' => 'show.ticket', 'uses' => 'Client\helpdesk\UnAuthController@showTicketCode']); //detail ticket information
    Breadcrumbs::register('show.ticket', function ($breadcrumbs) {
        $breadcrumbs->push('Ticket', route('form'));
    });
//testing ckeditor
//===================================================================================
    Route::group(['middleware' => 'role.user', 'middleware' => 'auth'], function () {
        Route::get('client-profile', ['as' => 'client.profile', 'uses' => 'Client\helpdesk\GuestController@getProfile']); /*  User profile get  */
        Breadcrumbs::register('client.profile', function ($breadcrumbs) {
            $breadcrumbs->push('My Profile');
        });
        Breadcrumbs::register('ticket2', function ($breadcrumbs) {
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
    /*
      |============================================================
      |  Installer Routes
      |============================================================
      |  These routes are for installer
      |
     */
    Route::get('/serial', ['as' => 'serialkey', 'uses' => 'Installer\helpdesk\InstallController@serialkey']);
    Route::post('/CheckSerial/{id}', ['as' => 'CheckSerial', 'uses' => 'Installer\helpdesk\InstallController@PostSerialKey']);
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
      |	These links are for cron job execution
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
    Route::get('500', ['as' => 'error500', function () {
            return view('errors.500');
        }]);
    Breadcrumbs::register('error500', function ($breadcrumbs) {
        $breadcrumbs->push('500');
    });
    Route::get('404', ['as' => 'error404', function () {
            return view('errors.404');
        }]);
    Breadcrumbs::register('error404', function ($breadcrumbs) {
        $breadcrumbs->push('404');
    });

    Route::get('error-in-database-connection', ['as' => 'errordb', function() {
            return view('errors.db');
        }]);

    Breadcrumbs::register('errordb', function ($breadcrumbs) {
        $breadcrumbs->push('Error establishing connection to database');
    });

    Route::get('unauthorized', ['as' => 'unauth', function() {
            return view('errors.unauth');
        }]);

    Breadcrumbs::register('unauth', function ($breadcrumbs) {
        $breadcrumbs->push('Unauthorized Access');
    });
    Route::get('board-offline', ['as' => 'board.offline', function () {
            return view('errors.offline');
        }]);
    Breadcrumbs::register('board.offline', function ($breadcrumbs) {
        $breadcrumbs->push('Board Offline');
    });
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
    Breadcrumbs::register('category.index', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push(Lang::get('lang.category'), route('category.index'));
    });
    Breadcrumbs::register('category.create', function ($breadcrumbs) {
        $breadcrumbs->parent('category.index');
        $breadcrumbs->push(Lang::get('lang.add'), route('category.create'));
    });
    Breadcrumbs::register('category.edit', function ($breadcrumbs) {
        $breadcrumbs->parent('category.index');
        $breadcrumbs->push(Lang::get('lang.edit'), url('category/{category}/edit'));
    });
    Breadcrumbs::register('category.show', function ($breadcrumbs) {
        $breadcrumbs->parent('category.index');
        $breadcrumbs->push(Lang::get('lang.view'), url('category/{category}'));
    });
    Route::get('category/delete/{id}', 'Agent\kb\CategoryController@destroy');
    /*  For the crud of article  */
    Route::resource('article', 'Agent\kb\ArticleController');
    Breadcrumbs::register('article.index', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push(Lang::get('lang.article'), route('article.index'));
    });
    Breadcrumbs::register('article.create', function ($breadcrumbs) {
        $breadcrumbs->parent('article.index');
        $breadcrumbs->push(Lang::get('lang.add'), route('article.create'));
    });
    Breadcrumbs::register('article.edit', function ($breadcrumbs) {
        $breadcrumbs->parent('article.index');
        $breadcrumbs->push(Lang::get('lang.edit'), url('article/{article}/edit'));
    });
    Breadcrumbs::register('article.show', function ($breadcrumbs) {
        $breadcrumbs->parent('article.index');
        $breadcrumbs->push(Lang::get('lang.view'), url('article/{article}'));
    });
    Route::get('article/delete/{id}', 'Agent\kb\ArticleController@destroy');
    /* get settings */
    Route::get('kb/settings', ['as' => 'settings', 'uses' => 'Agent\kb\SettingsController@settings']);
    Breadcrumbs::register('settings', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push(Lang::get('lang.settings'), route('settings'));
    });
    /* post settings */
    Route::patch('postsettings/{id}', 'Agent\kb\SettingsController@postSettings');
    //Route for administrater to access the comment
    Route::get('comment', ['as' => 'comment', 'uses' => 'Agent\kb\SettingsController@comment']);
    Breadcrumbs::register('comment', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push(Lang::get('lang.comments'), route('comment'));
    });
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
    Breadcrumbs::register('page.index', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push(Lang::get('lang.pages'), route('page.index'));
    });
    Breadcrumbs::register('page.create', function ($breadcrumbs) {
        $breadcrumbs->parent('page.index');
        $breadcrumbs->push(Lang::get('lang.add'), route('page.create'));
    });
    Breadcrumbs::register('page.edit', function ($breadcrumbs) {
        $breadcrumbs->parent('page.index');
        $breadcrumbs->push(Lang::get('lang.edit'), url('page/{page}/edit'));
    });
    Breadcrumbs::register('page.show', function ($breadcrumbs) {
        $breadcrumbs->parent('page.index');
        $breadcrumbs->push(Lang::get('lang.view'), url('page/{page}'));
    });
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
    Breadcrumbs::register('article-list', function ($breadcrumbs) {
        $breadcrumbs->push('Article List', route('article-list'));
    });
    Route::get('article-list', ['as' => 'article-list', 'uses' => 'Client\kb\UserController@getArticle']);
    // /* get search values */
    Route::get('search', ['as' => 'search', 'uses' => 'Client\kb\UserController@search']);
    Breadcrumbs::register('search', function ($breadcrumbs) {
        $breadcrumbs->push('Knowledge-base', route('home'));
        $breadcrumbs->push('Search Result');
    });
    /* get the selected article */
    Route::get('show/{slug}', ['as' => 'show', 'uses' => 'Client\kb\UserController@show']);
    Breadcrumbs::register('show', function ($breadcrumbs) {
        $breadcrumbs->push('Knowledge-base', route('home'));
        $breadcrumbs->push('Article List', route('article-list'));
        $breadcrumbs->push('Article');
    });
    Route::get('category-list', ['as' => 'category-list', 'uses' => 'Client\kb\UserController@getCategoryList']);
    Breadcrumbs::register('category-list', function ($breadcrumbs) {
        $breadcrumbs->push('Category List', route('category-list'));
    });
    /* get the categories with article */
    Route::get('category-list/{id}', ['as' => 'categorylist', 'uses' => 'Client\kb\UserController@getCategory']);
    Breadcrumbs::register('categorylist', function ($breadcrumbs) {
        $breadcrumbs->push('Category List', route('category-list'));
        $breadcrumbs->push('Category');
    });
    Route::post('show/rating/{id}', ['as' => 'show.rating', 'uses' => 'Client\helpdesk\UnAuthController@rating']); /* Get overall Ratings */
    Route::post('show/rating2/{id}', ['as' => 'show.rating2', 'uses' => 'Client\helpdesk\UnAuthController@ratingReply']); /* Get reply Ratings */
    Route::get('show/change-status/{status}/{id}', ['as' => 'show.change.status', 'uses' => 'Client\helpdesk\UnAuthController@changeStatus']); /* Get reply Ratings */
    /* get the home page */
    Route::get('knowledgebase', ['as' => 'home', 'uses' => 'Client\kb\UserController@home']);
    /* get the faq value to user */
    // $router->get('faq',['as'=>'faq' , 'uses'=>'Client\kb\UserController@Faq'] );
    /* get the cantact page to user */
    Route::get('contact', ['as' => 'contact', 'uses' => 'Client\kb\UserController@contact']);
    Breadcrumbs::register('contact', function ($breadcrumbs) {
        $breadcrumbs->parent('/');
        $breadcrumbs->push(Lang::get('lang.contact'), route('contact'));
    });
    /* post the cantact page to controller */
    Route::post('post-contact', ['as' => 'post-contact', 'uses' => 'Client\kb\UserController@postContact']);
    //to get the value for page content
    Route::get('pages/{name}', ['as' => 'pages', 'uses' => 'Client\kb\UserController@getPage']);
    Breadcrumbs::register('pages', function ($breadcrumbs) {
        $breadcrumbs->push('Pages');
    });
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
        Route::post('register', 'Api\v1\ApiController@register');
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
            Route::get('dependency', 'Api\v1\ApiController@dependency');
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

        /*
         * FCM token response
         */
        Route::post('fcmtoken', ['as' => 'fcmtoken', 'uses' => 'Common\PushNotificationController@fcmToken']);
    });
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
    /**
     * Queue
     */
    Breadcrumbs::register('queue', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push(Lang::get('lang.queues'), route('queue'));
    });
    Route::get('queue', ['as' => 'queue', 'uses' => 'Job\QueueController@index']);
    Route::get('form/queue', ['as' => 'queue.form', 'uses' => 'Job\QueueController@getForm']);
    Breadcrumbs::register('queue.edit', function ($breadcrumbs) {
        $id = \Input::segment(2);
        $breadcrumbs->parent('queue');
        $breadcrumbs->push(Lang::get('lang.edit'), route('queue.edit',$id));
    });
    Route::get('queue/{id}', ['as' => 'queue.edit', 'uses' => 'Job\QueueController@edit']);
    Route::post('queue/{id}', ['as' => 'queue.update', 'uses' => 'Job\QueueController@update']);
    Route::get('queue/{id}/activate', ['as' => 'queue.activate', 'uses' => 'Job\QueueController@activate']);
});
