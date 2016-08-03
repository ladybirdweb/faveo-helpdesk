<?php

namespace App\Http\Controllers\Admin\helpdesk;

use App\Http\Controllers\Controller;
use App\Http\Requests\helpdesk\WorkflowCloseRequest;
use App\Model\helpdesk\Workflow\WorkflowClose;
use Lang;

/**
 * |=================================================
 * | CloseWrokflowController
 * |=================================================
 * In this controller the functionalities fo close ticket workflow defined.
 */
class CloseWrokflowController extends Controller
{
    private $security;

    public function __construct(WorkflowClose $security)
    {
        $this->security = $security;
    }

    /**
     * get the workflow settings page.
     *
     * @param \App\Model\helpdesk\Workflow\WorkflowClose $securitys
     *
     * @return type view
     */
    public function index(WorkflowClose $securitys)
    {
        try {
            $security = $securitys->whereId('1')->first();

            return view('themes.default1.admin.helpdesk.settings.close-workflow.index', compact('security'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * updating the workflow settings for closing ticket.
     *
     * @param type                                             $id
     * @param \App\Http\Requests\helpdesk\WorkflowCloseRequest $request
     *
     * @return type redirect
     */
    public function update($id, WorkflowCloseRequest $request)
    {
        try {
            $security = new WorkflowClose();
            $securitys = $security->whereId($id)->first();
            $securitys->days = $request->input('days');
//            $securitys->condition = $request->input('condition');
            $securitys->send_email = $request->input('send_email');
            $securitys->status = $request->input('status');
            $securitys->save();

            return \Redirect::back()->with('success', Lang::get('lang.successfully_saved_your_settings'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
