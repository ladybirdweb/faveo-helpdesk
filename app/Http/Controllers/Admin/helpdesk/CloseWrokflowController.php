<?php

namespace App\Http\Controllers\Admin\helpdesk;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\helpdesk\Workflow\WorkflowClose;
use App\Http\Requests\helpdesk\WorkflowCloseRequest;
use App\Http\Controllers\Controller;

class CloseWrokflowController extends Controller {

    private $security;

    public function __construct(WorkflowClose $security) {
        $this->security = $security;
    }

    public function index(WorkflowClose $securitys) {
        $security = $securitys->whereId('1')->first();
        return view('themes.default1.admin.helpdesk.settings.close-workflow.index', compact('security'));
    }

    public function update($id, WorkflowCloseRequest $request) {
        $security = new WorkflowClose();
        $securitys = $security->whereId($id)->first();
        $securitys->days = $request->input('days');
        $securitys->condition = $request->input('condition');
        $securitys->send_email = $request->input('send_email');
        $securitys->status = $request->input('status');

        $securitys->save();
        return \Redirect::back()->with('success', 'Successfully Saved your Settings');
    }

}
