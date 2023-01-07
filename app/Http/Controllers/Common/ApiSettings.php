<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Model\Api\ApiSetting;
use App\Model\helpdesk\Ticket\Tickets;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Lang;
use Log;

class ApiSettings extends Controller
{
    public $api;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['ticketDetailEvent', 'postHook', 'postForm']]);
        $this->middleware('roles', ['except' => ['ticketDetailEvent', 'postHook', 'postForm']]);

        $api = new ApiSetting();
        $this->api = $api;
    }

    public function show()
    {
        try {
            /* fetch the values of system from system table */
            $systems = DB::table('settings_system')->whereId('1')->first();
            $details = [];
            $ticket_detail = '';
            $settings = $this->api;
            if ($settings->get()->count() > 0) {
                $details = $this->api->pluck('value', 'key')->toArray();
            }
            if (array_key_exists('ticket_detail', $details)) {
                $ticket_detail = $details['ticket_detail'];
            }

            return view('themes.default1.common.api.settings', compact('ticket_detail', 'systems'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postSettings(Request $request)
    {
        $this->validate($request, [
            'ticket_detail' => 'url',
        ]);

        try {
            // dd($request->input());
            DB::table('settings_system')
            ->where('id', 1)
            ->update(['api_enable'  => Input::get('api_enable'),
                'api_key_mandatory' => Input::get('api_key_mandatory'),
                'api_key'           => Input::get('api_key'), ]);
            $settings = $this->api;
            if ($settings->get()->count() > 0) {
                foreach ($settings->get() as $set) {
                    $set->delete();
                }
            }
            foreach ($request->except('_token') as $key => $value) {
                $settings->create(['key' => $key, 'value' => $value]);
            }

            return redirect()->back()->with('success', Lang::get('lang.updated_successfully'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function ticketDetailEvent($detail)
    {
        try {
            $ticket = new Tickets();
            $ticketid = $detail->ticket_id;
            $data = $ticket
                    ->join('ticket_thread', function ($join) use ($ticketid) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->where('ticket_thread.ticket_id', '=', $ticketid);
                    })
                    ->join('users', 'ticket_thread.user_id', '=', 'users.id')
                    ->select('ticket_thread.title', 'ticket_thread.body', 'users.first_name', 'users.last_name', 'users.email', 'ticket_thread.created_at')
                    ->get()
                    ->toJson();
            $this->postHook($data);
        } catch (Exception $ex) {
            dd($ex);

            throw new Exception($ex->getMessage());
        }
    }

    public function postHook($data)
    {
        try {
            $set = $this->api->where('key', 'ticket_detail')->first();
            if ($set) {
                if ($set->value) {
                    $this->postForm($data, $set->value);
                }
            }
        } catch (Exception $ex) {
            dd($ex);

            throw new Exception($ex->getMessage());
        }
    }

    public function postForm($data, $url)
    {
        try {
            $post_data = [
                'data' => $data,
            ];
            $upgrade_controller = new \App\Http\Controllers\Update\UpgradeController();
            $upgrade_controller->postCurl($url, $post_data);
            Log::info('ticket details has send to : '.$url.' and details are : '.$data);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}
