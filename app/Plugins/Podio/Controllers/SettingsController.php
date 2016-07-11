<?php

namespace App\Plugins\Podio\Controllers;

use App\Http\Controllers\Controller;
use App\Plugins\Podio\Model\Podio;
use Illuminate\Http\Request;
use Input;
use Schema;

/**
 *@version 1.0.0
 */
class SettingsController extends Controller
{
    /**
     * @category constructor fucntion to call createPodioTable()
     */
    public function __construct()
    {
        require_once base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Podio'.DIRECTORY_SEPARATOR.'podio-php'.DIRECTORY_SEPARATOR.'PodioAPI.php'; // Require Podio client Library file to work with Podio API
        if (!Schema::hasTable('podio')) {
            $this->createPodioTable();
        } else {
            $podio_user = \DB::table('podio')
            ->where('id', '=', 1)->first();
            // dd($podio_user);
        }
        if (!Schema::hasTable('podio_client_item')) {
            $this->createPodioClientTable();
        }
        if (!Schema::hasTable('podio_app_item')) {
            $this->createPodioTicketTable();
        }
    }

    /**
     *@category function to show Podio plugin setting page
     *
     *@param null
     *
     *@return view response
     */
    public function index()
    {
        $path = app_path().'/Plugins/Podio/views';
        \View::addNamespace('plugins', $path);
        $podio_info = \DB::table('podio')
            ->select('client_id', 'client_secret', 'username')
            ->where('id', '=', 1)->first();
        if ($podio_info == null) {
            return view('plugins::settings');
        } else {
            return view('plugins::edit', compact('podio_info'));
        }
    }

    /**
     *@category this function is called by ajax and it calls Podio's api to authenticate user's podio account
     *and saves information in database
     *
     *@param null
     *
     *@return int|string response
     */
    public function postSetting()
    {
        $values = Input::all();
        $value = $values['input'];
        $client_id = $value[1];
        $client_secret = $value[2];
        $username = $value[3];
        $password = $value[4];
        if ($client_id != '' && $client_secret != ''
            && $username != '' && $password != '') {
            // try{
                \Podio::setup($client_id, $client_secret);
            $auth = \Podio::authenticate_with_password($username, $password);
            if ($auth == true) {
                $podio_data = \DB::table('podio')
                                    ->where('id', '=', 1)
                                    ->get();
                if (count($podio_data) > 0) {
                    \DB::table('podio')
                        ->where('id', '=', 1)
                        ->update([
                                'client_id'     => $value[1],
                                'client_secret' => $value[2],
                                'username'      => $value[3],
                                'password'      => $value[4],
                            ]);
                } else {
                    $podio = new Podio();
                    $podio->client_id = $value[1];
                    $podio->client_secret = $value[2];
                    $podio->username = $value[3];
                    $podio->password = $value[4];
                    $podio->save();
                }
                \Podio::$oauth;

                return 1;
            }
            // } catch(PodioError $e) {
            //     dd($e);
            // }
        } else {
            return 0;
        }
    }

    /**
     *@category function to fetch available organizations which are accessible by authorized user and it is called by ajax request
     *
     *@param null
     *return string option list of arganiation
     */
    public function orgIndex()
    {
        $auth = $this->setup();
        if ($auth == true) {
            $data = \PodioOrganization::get_all();
            $data_count = count($data);
            if ($data_count != 0) {
                foreach ($data as  $value) {
                    $data2 = (array) $value;
                    foreach ($data2 as $key => $value) {
                        echo "<option name='org_id' value=".$value['org_id'].'>'.$value['name'].'</option>';
                        break;
                    }
                }
            } else {
                return 0;
            }
        } else {
            return $auth;
        }
    }

    /**
     *@category function to fecth the list of available spaces in the organization selected by user, gets called by ajax request
     *
     *@param null
     *
     *@return string list of all avialble spaces
     */
    public function spaceIndex()
    {
        $auth = $this->setup();
        if ($auth == true) {
            $space_id = Input::get('input');
            $data = \PodioSpace::get_for_org($space_id);
            foreach ($data as  $value) {
                $data2 = (array) $value;
                foreach ($data2 as $key => $value) {
                    echo "<option name='org_id' value=".$value['space_id'].'>'.$value['name'].'</option>';
                    break;
                }
            }
        } else {
            return $auth;
        }
    }

    /**
     *@category function to create a table "Podio" in database if does not exist
     *
     *@param null
     *
     *@author manish.verma@ladybirdweb.com
     *
     *@return null;
     */
    public function createPodioTable()
    {
        if (!Schema::hasTable('podio')) {
            Schema::create('podio', function ($table) {
                $table->increments('id');
                $table->string('client_id');
                $table->string('client_secret');
                $table->string('username');
                $table->string('password');
                $table->string('client_app_id');
                $table->string('faveo_app_id');
                $table->string('faveo_app_token');
                $table->integer('podio_isactive');
                $table->timestamps();
            });
            // $this->seedPodio();
        }
    }

    /**
     *@category function to create a new apps in Podio workspace
     *
     *@param null
     *
     *@return string|int $auth|1
     */
    public function createApp()
    {
        $status_data = \DB::table('ticket_status')
            ->select('id', 'name')
            ->get();
        $status_data2 = [];
        foreach ($status_data as $value) {
            array_push($status_data2, ['text' => $value->name]);
        }

        $priority_data = \DB::table('ticket_priority')
            ->select('priority_id', 'priority')
            ->get();
        $priority_data2 = [];
        foreach ($priority_data as $value) {
            array_push($priority_data2, ['text' => $value->priority]);
        }

        $auth = $this->setup();
        if ($auth == true) {
            $space_id = (int) Input::get('input2');
            $app_name = Input::get('input3');
            $item_name = Input::get('input4');
            $ar = [
                'config' => [
                    'type'                  => 'standard',
                    'app_item_id_padding'   => 1,
                    'app_item_id_prefix'    => '',
                    'show_app_item_id'      => false,
                    'allow_comments'        => true,
                    'allow_create'          => true,
                    'allow_edit'            => true,
                    'allow_attachments'     => true,
                    'silent_creates'        => false,
                    'silent_edits'          => false,
                    'disable_notifications' => false,
                    'default_view'          => 'badge',
                    'allow_tags'            => false,
                    'icon'                  => '55.png',
                    'name'                  => 'Client',
                    'item_name'             => 'user',
                ],
                'space_id' => $space_id,
                'fields'   => [
                   [
                    'config' => [
                        'label'    => 'Name',
                        'delta'    => 1,
                        'settings' => [
                            'size' => 'small',
                        ],
                        'required' => false,
                        ],
                        'type' => 'text',
                    ],
                    [
                    'config' => [
                        'label'    => 'Email',
                        'delta'    => 2,
                        'settings' => [
                            'size' => 'medium',
                        ],
                        'required' => false,
                        ],
                        'type' => 'email',
                    ],
                    [
                    'config' => [
                        'label'    => 'phone',
                        'delta'    => 3,
                        'settings' => [
                            'size' => 'medium',
                        ],
                        'required' => false,
                        ],
                        'type' => 'phone',
                    ],
                ],
            ];
            $response = \PodioApp::create($ar);
            if ($response == null) {
                return $response;
            } else {
                $client_app_id = $response->app_id;
                $ar2 = [
                    'config' => [
                        'type'                  => 'standard',
                        'app_item_id_padding'   => 1,
                        'app_item_id_prefix'    => '',
                        'show_app_item_id'      => false,
                        'allow_comments'        => true,
                        'allow_create'          => true,
                        'allow_edit'            => true,
                        'allow_attachments'     => true,
                        'silent_creates'        => false,
                        'silent_edits'          => false,
                        'disable_notifications' => false,
                        'default_view'          => 'badge',
                        'allow_tags'            => false,
                        'icon'                  => '396.png',
                        'name'                  => "$app_name",
                        'item_name'             => "$item_name",
                    ],
                    'space_id' => $space_id,
                    'fields'   => [
                       [
                        'config' => [
                            'label'    => 'Ticket Number',
                            'delta'    => 2,
                            'settings' => [
                                'size' => 'small',
                            ],
                            'required' => true,
                            ],
                            'type' => 'text',
                        ],
                        [
                        'config' => [
                            'label'    => 'Subject',
                            'delta'    => 1,
                            'settings' => [
                                'size' => 'small',
                            ],
                            'required' => true,
                            ],
                            'type' => 'text',
                        ],
                        [
                        'config' => [
                            'label'    => 'Description',
                            'delta'    => 3,
                            'settings' => [
                                'size' => 'large',
                            ],
                            'required' => false,
                            ],
                            'type' => 'text',
                        ],
                        [
                        'config' => [
                            'label'    => 'From',
                            'delta'    => 4,
                            'settings' => [
                                'referenced_apps' => [
                                    [
                                        'app_id' => $client_app_id,
                                    ],
                                ],
                                'multiple' => false,
                            ],
                            'required' => false,
                            ],
                            'type' => 'app',
                        ],
                        [
                        'config' => [
                            'label'    => 'Created at',
                            'delta'    => 5,
                            'settings' => [
                                'size' => 'large',
                            ],
                            'required' => false,
                            ],
                            'type' => 'date',
                        ],
                        [
                        'config' => [
                            'label'    => 'Assigned to',
                            'delta'    => 8,
                            'settings' => [
                                'type' => 'all_users',
                            ],
                            'required' => false,
                            ],
                            'type' => 'contact',
                        ],
                        [
                        'config' => [
                            'label'    => 'Priority',
                            'delta'    => 6,
                            'settings' => [
                                'options'  => $priority_data2,
                                'multiple' => false,
                                'display'  => 'inline',
                            ],
                            'required' => false,
                            ],
                            'type' => 'category',
                        ],
                        [
                        'config' => [
                            'label'    => 'Status',
                            'delta'    => 7,
                            'settings' => [
                                'options'  => $status_data2,
                                'multiple' => false,
                                'display'  => 'inline',
                            ],
                            'required' => false,
                            ],
                            'type' => 'category',
                        ],
                    ],
                ];
                $response = \PodioApp::create($ar2);
                if ($response == null) {
                    return $response;
                } else {
                    $faveo_app_id = $response->app_id;
                    \DB::table('podio')->where('id', '=', 1)
                    ->update(['client_app_id' => $client_app_id,
                        'faveo_app_id'        => $faveo_app_id, ]);

                    return 1;
                }
            }
        } else {
            return $auth;
        }
    }

    /**
     *@category function to setup client_id and client secret for podio api
     *
     *@param null
     *
     *@return array
     */
    public function setup()
    {
        $podio_data = \DB::table('podio')
                      ->where('id', '=', 1)
                      ->first();
        $values = [];
        array_push($values, $podio_data->client_id);
        array_push($values, $podio_data->client_secret);
        array_push($values, $podio_data->username);
        array_push($values, $podio_data->password);
        \Podio::setup($values[0], $values[1]);
        $result = \Podio::authenticate_with_password($values[2], $values[3]);

        return $result;
    }

    /**
     *@category function to submit and authenticate last step's form
     *
     *@param null
     *
     *@return string|1 (error exception text on fail or 1 on success)
     */
    public function authApp()
    {
        $app_id = Input::get('input1');
        $app_token = Input::get('input2');
        $podio = Podio::select('client_secret', 'client_id')
        ->where('id', '=', 1)->first();
        $client_id = $podio->client_id;
        $client_secret = $podio->client_secret;
        \Podio::setup($client_id, $client_secret);
        $result = \Podio::authenticate_with_app($app_id, $app_token);
        if ($result == true) {
            \DB::table('podio')->where('id', '=', 1)
            ->update(['faveo_app_token' => $app_token]);

            return 1;
        } else {
            return $result;
        }

        return 1;
    }

    /**
     *@category function to create podio_client_item table in db
     *
     *@param null
     *
     *@return null
     */
    public function createPodioClientTable()
    {
        if (!Schema::hasTable('podio_client_item')) {
            Schema::create('podio_client_item', function ($table) {
                $table->increments('id');
                $table->string('user_id');
                $table->string('podio_item_id');
                $table->timestamps();
            });
            // $this->seedPodio();
        }
    }

    /**
     *@category function to create podio_ticket_item table in db
     *
     *@param null
     *
     *@return null
     */
    public function createPodioTicketTable()
    {
        if (!Schema::hasTable('podio_ticket_item')) {
            Schema::create('podio_ticket_item', function ($table) {
                $table->increments('id');
                $table->string('ticket_id');
                $table->string('podio_item_id');
                $table->timestamps();
            });
            // $this->seedPodio();
        }
    }
}
