<?php

namespace App\Http\Controllers\Type;

// controllers
use App\Http\Controllers\Common\NotificationController;
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\TickettypeRequest;
use App\Http\Requests\helpdesk\TickettypeUpdateRequest;
// models
use App\Model\helpdesk\Manage\Tickettype;
use Auth;
use Exception;
// classes
use Illuminate\support\Collection;
use Lang;

/**
 * TicketController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class TicketTypeController extends Controller
{
    public function __construct(PhpMailController $PhpMailController, NotificationController $NotificationController)
    {
        $this->PhpMailController = $PhpMailController;
        $this->NotificationController = $NotificationController;
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * Show the Inbox ticket list page.
     *
     * @return type response
     */
    public function typeIndex()
    {
        try {
            return view('themes.default1.admin.helpdesk.manage.tickettype.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @return type
     */
    public function typeIndex1()
    {
        try {
            $ticket_type = new Tickettype();
            $ticket_type = $ticket_type->select('id', 'name', 'status', 'type_desc', 'ispublic', 'is_default')->get();
            // dd( $ticket_type);

            return \Datatable::Collection($ticket_type)
                            // ->showColumns('name', 'type_desc')

                            ->addColumn('name', function ($model) {
                                if ($model->is_default > 0) {
                                    if (strlen($model->name) > 25) {
                                        return '<p title="'.$model->name.'">'.mb_substr($model->name, 0, 30, 'UTF-8').'...</p> ( Default )';
                                    } else {
                                        return "$model->name ( Default )";
                                    }
                                } else {
                                    if (strlen($model->name) > 25) {
                                        return '<p title="'.$model->name.'">'.mb_substr($model->name, 0, 30, 'UTF-8').'...</p>';
                                    } else {
                                        return $model->name;
                                    }
                                }
                            })
                            ->addColumn('type_desc', function ($model) {
                                if (strlen($model->type_desc) > 25) {
                                    return '<p title="'.$model->type_desc.'">'.mb_substr($model->type_desc, 0, 30, 'UTF-8').'...</p>';
                                } else {
                                    return $model->type_desc;
                                }
                            })
                            ->addColumn('status', function ($model) {
                                if ($model->status == 1) {
                                    return '<p class="btn btn-xs btn-success" style="pointer-events:none">'.Lang::get('lang.active').'</p>';
                                }

                                return '<p class="btn btn-xs btn-danger" style="pointer-events:none">'.Lang::get('lang.inactive').'</p>';
                            })
                            ->addColumn('action', function ($model) {
                                if ($model->is_default > 0) {
                                    return '<a href='.url('ticket-types/'.$model->id.'/edit')." class='btn btn-primary btn-xs'><i class='fa fa-edit' style='color:white;'></i>&nbsp; Edit</a>&nbsp;&nbsp;<a href='#' class='btn btn-primary btn-primary btn-xs' disabled='disabled' ><i class='fa fa-trash' style='color:white;'>&nbsp;&nbsp;</i> Delete </a>";
                                } else {
                                    $url = url('ticket-types/'.$model->id.'/destroy');
                                    $confirmation = deletePopUp($model->id, $url, 'Delete', 'btn btn-primary btn-xs');

                                    return '<a href='.url('ticket-types/'.$model->id.'/edit')." class='btn btn-primary btn-xs'><i class='fa fa-edit' style='color:white;'>&nbsp; </i>&nbsp;Edit</a>&nbsp;&nbsp;".$confirmation;
                                }
                            })
                            ->searchColumns('name')
                            ->orderColumns('name')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @return type
     */
    public function typeCreate()
    {
        return view('themes.default1.admin.helpdesk.manage.tickettype.create');
    }

    public function typeCreate1(TickettypeRequest $request)
    {
        try {
            $tk_type = new Tickettype();
            $tk_type->name = $request->name;
            $tk_type->status = $request->status;
            $tk_type->type_desc = $request->type_desc;

            $tk_type->ispublic = $request->ispublic;
            $tk_type->save();

            return \Redirect::route('ticket.type.index')->with('success', Lang::get('lang.ticket_type_saved_successfully'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param type $priority_id
     *
     * @return type
     */
    public function typeEdit($id)
    {
        try {
            $tk_type = Tickettype::whereid($id)->first();

            return view('themes.default1.admin.helpdesk.manage.tickettype.edit', compact('tk_type'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param PriorityRequest $request
     *
     * @return type
     */
    public function typeEdit1(TickettypeUpdateRequest $request)
    {
        try {
            $id = $request->tk_type_id;
            $tk_type = Tickettype::findOrFail($id);
            $tk_type->name = $request->name;
            $tk_type->status = $request->status;
            $tk_type->type_desc = $request->type_desc;

            $tk_type->ispublic = $request->ispublic;
            $tk_type->save();
            if ($request->input('default_ticket_type') == 'on') {
                Tickettype::where('is_default', '>', '0')
                        ->update(['is_default' => '0']);
                Tickettype::where('id', '=', $id)
                        ->update(['is_default' => $id, 'status'=>1]);
            }

            return \Redirect::route('ticket.type.index')->with('success', Lang::get('lang.ticket_type_updated_successfully'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param type $priority_id
     *
     * @return type
     */
    public function destroy($id)
    {
        try {
            $tk_type = Tickettype::findOrFail($id);

            $tk_type->delete();

            return \Redirect::route('ticket.type.index')->with('success', (Lang::get('lang.ticket_type_deleted_successfully')));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
