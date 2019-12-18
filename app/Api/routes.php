<?php

    /*
     * ================================================================================================
     * @version v1
     * @access public
     * @copyright (c) 2016, Ladybird web solution
     * @author Vijay Sebastian<vijay.sebastian@ladybirdweb.com>
     * @name Faveo
     */
    Route::group(['prefix' => 'api/v1'], function () {
        Route::post('authenticate', '\App\Api\v1\TokenAuthController@authenticate');
        Route::get('authenticate/user', '\App\Api\v1\TokenAuthController@getAuthenticatedUser');
        Route::get('/database-config', ['as' => 'database-config', 'uses' => '\App\Api\v1\InstallerApiController@config_database']);
        Route::get('/system-config', ['as' => 'database-config', 'uses' => '\App\Api\v1\InstallerApiController@config_system']);
        /*
         * Helpdesk
         */
        Route::group(['prefix' => 'helpdesk'], function () {
            Route::post('create', '\App\Api\v1\ApiController@createTicket');
            Route::post('reply', '\App\Api\v1\ApiController@ticketReply');
            Route::post('edit', '\App\Api\v1\ApiController@editTicket');
            Route::post('delete', '\App\Api\v1\ApiController@deleteTicket');
            Route::post('assign', '\App\Api\v1\ApiController@assignTicket');
            Route::get('open', '\App\Api\v1\ApiController@openedTickets');
            Route::get('unassigned', '\App\Api\v1\ApiController@unassignedTickets');
            Route::get('closed', '\App\Api\v1\ApiController@closeTickets');
            Route::get('agents', '\App\Api\v1\ApiController@getAgents');
            Route::get('teams', '\App\Api\v1\ApiController@getTeams');
            Route::get('customers', '\App\Api\v1\ApiController@getCustomers');
            Route::get('customer', '\App\Api\v1\ApiController@getCustomer');
            Route::get('ticket-search', '\App\Api\v1\ApiController@searchTicket');
            Route::get('ticket-thread', '\App\Api\v1\ApiController@ticketThreads');
            Route::get('url', '\App\Api\v1\ApiExceptAuthController@checkUrl');
            Route::get('check-url', '\App\Api\v1\ApiExceptAuthController@urlResult');
            Route::get('api_key', '\App\Api\v1\ApiController@generateApiKey');
            Route::get('help-topic', '\App\Api\v1\ApiController@getHelpTopic');
            Route::get('sla-plan', '\App\Api\v1\ApiController@getSlaPlan');
            Route::get('priority', '\App\Api\v1\ApiController@getPriority');
            Route::get('department', '\App\Api\v1\ApiController@getDepartment');
            Route::get('tickets', '\App\Api\v1\ApiController@getTickets');
            Route::get('ticket', '\App\Api\v1\ApiController@getTicketById');
            Route::get('inbox', '\App\Api\v1\ApiController@inbox');
            Route::get('trash', '\App\Api\v1\ApiController@getTrash');
            Route::get('my-tickets-agent', '\App\Api\v1\ApiController@getMyTicketsAgent');
            Route::post('internal-note', '\App\Api\v1\ApiController@internalNote');
            /*
             * Newly added
             */
            Route::get('customers-custom', '\App\Api\v1\ApiController@getCustomersWith');
            Route::get('collaborator/search', '\App\Api\v1\ApiController@collaboratorSearch');
            Route::post('collaborator/create', '\App\Api\v1\ApiController@addCollaboratorForTicket');
            Route::post('collaborator/remove', '\App\Api\v1\ApiController@deleteCollaborator');
            Route::post('collaborator/get-ticket', '\App\Api\v1\ApiController@getCollaboratorForTicket');
            Route::get('my-tickets-user', '\App\Api\v1\ApiController@getMyTicketsUser');
            Route::get('dependency', '\App\Api\v1\ApiController@dependency');
            Route::post('register', '\App\Api\v1\ApiController@createUser');
        });

        /*
         * FCM token response
         */
        Route::post('fcmtoken', ['as' => 'fcmtoken', 'uses' => 'Common\PushNotificationController@fcmToken']);
    });
    /*
     * ================================================================================================
     * @version v1
     * @access public
     * @copyright (c) 2016, Ladybird web solution
     * @author Manish Verma<manish.verma@ladybirdweb.com>
     * @name Faveo
     */
    Route::group(['prefix' => 'api/v2'], function () {
        /*
         * Helpdesk
         */
        Route::group(['prefix' => 'helpdesk'], function () {
            Route::get('tickets', '\App\Api\v2\TicketController@getTickets');
        });
    });
