<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\CompanyRequest;
use App\Http\Requests\helpdesk\EmailRequest;
use App\Http\Requests\helpdesk\RatingUpdateRequest;
use App\Http\Requests\helpdesk\StatusRequest;
use App\Http\Requests\helpdesk\SystemRequest;
// models
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Email\Template;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Notification\UserNotification;
use App\Model\helpdesk\Ratings\Rating;
use App\Model\helpdesk\Settings\Alert;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\Email;
use App\Model\helpdesk\Settings\Responder;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Utility\Date_format;
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\Model\helpdesk\Workflow\WorkflowClose;
use App\Model\helpdesk\Settings\CommonSettings;
use DateTime;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\TicketStatusType;
use App\Model\helpdesk\Ticket\Tickets;
// classes
use DB;
use Exception;
use File;
use Illuminate\Http\Request;
use Input;
use Lang;
use Finder;

/**
 * SettingsController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class StatusController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // $this->smtp();
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function getStatuses() {
        try {
            /* fetch the values of company from company table */
            $statuss = Ticket_Status::where('purpose_of_status', '!=', 3)->where('purpose_of_status', '!=', 4)->paginate('10');
            /* Direct to Company Settings Page */
            return view('themes.default1.admin.helpdesk.settings.status.index', compact('statuss'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * create a status.
     *
     * @param \App\Model\helpdesk\Ticket\Ticket_Status  $statuss
     * @param \App\Http\Requests\helpdesk\StatusRequest $request
     *
     * @return type redirect
     */
    public function createStatuses(Ticket_Status $statuss) {
        $status_types = TicketStatusType::where('id', '<', 3)->get();
        return view('themes.default1.admin.helpdesk.settings.status.create', compact('status_types'));
    }

    /**
     * create a status.
     *
     * @param \App\Model\helpdesk\Ticket\Ticket_Status  $statuss
     * @param \App\Http\Requests\helpdesk\StatusRequest $request
     *
     * @return type redirect
     */
    public function storeStatuses(StatusRequest $request) {
        try {
            $statuss = new Ticket_Status;
            /* fetch the values of company from company table */
            $statuss->name = $request->input('name');
            $statuss->order = $request->input('sort');
            $statuss->icon = $request->input('icon_class');
            $statuss->icon_color = $request->input('icon_color');
            if ($request->input('visibility_for_client') == 'yes') {
                $statuss->visibility_for_client = 1;
                $statuss->secondary_status = null;
            } else {
                $statuss->visibility_for_client = 0;
                $statuss->secondary_status = $request->input('secondary_status');
            }
            $statuss->purpose_of_status = $request->input('purpose_of_status');

            if ($request->input('client') != null) {
                $email1 = $request->input('client');
            } else {
                $email1 = 0;
            }
            if ($request->input('agent') != null) {
                $email2 = $request->input('agent');
            } else {
                $email2 = 0;
            }
            if ($request->input('admin') != null) {
                $email3 = $request->input('admin');
            } else {
                $email3 = 0;
            }
            $email = $email1 + $email2 + $email3;
            $statuss->send_email = $email;
            // $statuss->send_email = $request->message;

            $statuss->allow_client = $request->allow_client;

            if ($request->default == 'on') {
                $default_statuses = Ticket_Status::where('purpose_of_status', $request->purpose_of_status)->get();
                foreach ($default_statuses as $default_status) {
                    $default_status->default = null;
                    $default_status->save();
                }
                $statuss->default = 1;
            }
           $statuss->halt_sla = $request->input('halt_sla');
            $statuss->save();
            /* Direct to Company Settings Page */
            return redirect()->route('statuss.index')->with('success', Lang::get('lang.status_has_been_created_successfully'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function getEditStatuses($id) {
        try {
            /* fetch the values of company from company table */
            $status = Ticket_Status::find($id);
            /* Direct to Company Settings Page */
            return view('themes.default1.admin.helpdesk.settings.status.edit', compact('status'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function editStatuses($id, StatusRequest $request) {
        try {
            $status = Ticket_Status::whereId($id)->first();

            if ($request->input('client') != null) {
                $email1 = $request->input('client');
            } else {
                $email1 = 0;
            }
            if ($request->input('agent') != null) {
                $email2 = $request->input('agent');
            } else {
                $email2 = 0;
            }
            if ($request->input('admin') != null) {
                $email3 = $request->input('admin');
            } else {
                $email3 = 0;
            }
            $email = $email1 + $email2 + $email3;

            if ($status->purpose_of_status == $request->input('purpose_of_status')) {
                $status->purpose_of_status = $request->input('purpose_of_status');
            } else {
                $ticket_with_same_status = Tickets::where('status', $status->id)->first();
                if (isset($ticket_with_same_status)) {
                    return redirect()->back()->with('fails', Lang::get('lang.unable_to_change_the_purpose_of_status_there_are_tickets_with_this_status'));
                } else {
                    $status->purpose_of_status = $request->input('purpose_of_status');
                }
            }

            if ($request->input('purpose_of_status') == 2) {
                $status->send_email = $email;
            } else {
                $status->send_email = 0;
            }
            $status->send_email=$email;
            $status->message = $request->message;

            /* fetch the values of company from company table */
            $status->name = $request->input('name');
            $status->order = $request->input('sort');
            $status->icon = $request->input('icon_class');
            $status->icon_color = $request->input('icon_color');
            if ($request->input('visibility_for_client') == '1') {
                $status->secondary_status = null;
            } else {
                $status->secondary_status = $request->input('secondary_status');
            }

            $status->visibility_for_client = $request->input('visibility_for_client');

            $status->allow_client = $request->allow_client;

            if ($request->default == 'on') {
                $default_statuses = Ticket_Status::where('purpose_of_status', $request->purpose_of_status)->get();
                foreach ($default_statuses as $default_status) {
                    $default_status->default = null;
                    $default_status->save();
                }
                $status->default = 1;
            }
            $status->halt_sla = $request->input('halt_sla');
            // dd($status->hault_sla);
            $status->save();
            /* Direct to Company Settings Page */
            return redirect()->route('statuss.index')->with('success', Lang::get('lang.status_has_been_updated_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * delete a status.
     *
     * @param type $id
     *
     * @return type redirect
     */
    public function deleteStatuses($id) {
        try {
            $status_to_delete = Ticket_Status::whereId($id)->first();
            if ($status_to_delete->default == 1 || $id == Finder::statusApproval()) {
                return redirect()->back()->with('fails', Lang::get('lang.you_cannot_delete_a_default_ticket_status'));
            }
            $ticket_with_status = Tickets::where('status', $id)->first();

            if (isset($ticket_with_status)) {
                $default_status = Finder::defaultStatus($status_to_delete->purpose_of_status);
                $tickets = DB::table('tickets')->where('status', '=', $id)->update(['status' => $default_status->id]);
                $status_to_delete->delete();
                return redirect()->back()->with('success', '<li>' . Lang::get('lang.associated_tickets_moved_to_default_status') . '<li>' . Lang::get('lang.status_deleted_successfully'));
            } else {
                $status_to_delete->delete();
                return redirect()->back()->with('success', '<li>' . Lang::get('lang.status_deleted_successfully'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

}


