<?php

namespace App\Http\Controllers\Admin\helpdesk;

// Controller
use App\Http\Controllers\Controller;
// Model
use App\Http\Requests\helpdesk\SecurityRequest;
use App\Model\helpdesk\Settings\Security;
// Request
use Illuminate\Http\Request;
// Class
use Lang;
use Redirect;

/**
 * FormController
 * This controller is used to CRUD Custom Security.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class SecurityController extends Controller
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * list of securitys.
     *
     * @param type Security $securitys
     *
     * @return Response
     */
    public function index(Security $securitys)
    {
        try {
            $security = $securitys->whereId('1')->first();

            return view('themes.default1.admin.helpdesk.settings.security.index', compact('security'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Create security setting.
     *
     * @return Response
     */
    public function create()
    {
        return view('themes.default1.admin.helpdesk.setting.security.security');
    }

    /**
     * Show security.
     *
     * @param int $id
     *
     * @return Response
     */
//    public function show($id)
//    {
//        return view('themes.default1.admin.helpdesk.setting.security.preview', compact('id'));
//    }

    /**
     * Update security details.
     *
     * @return Response
     */
    public function update($id, SecurityRequest $request)
    {
        try {
            $security = new Security();
            $securitys = $security->whereId($id)->first();
            $securitys->lockout_message = $request->input('lockout_message');
            $securitys->backlist_offender = $request->input('backlist_offender');
            $securitys->backlist_threshold = $request->input('backlist_threshold');
            $securitys->lockout_period = $request->input('lockout_period');
            $securitys->days_to_keep_logs = $request->input('days_to_keep_logs');
            $securitys->save();

            return Redirect::back()->with('success', Lang::get('lang.security_settings_saved_successfully'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Delete security details.
     *
     * @param type                                            $id
     * @param \App\Model\helpdesk\Settings\Security           $securitys
     * @param type                                            $field
     * @param \App\Http\Controllers\Admin\helpdesk\Help_topic $help_topic
     *
     * @return type redirect
     */
    public function delete($id, Security $securitys, Fields $field, Help_topic $help_topic)
    {
        $fields = $field->where('securitys_id', $id)->get();
        $help_topics = $help_topic->where('custom_security', '=', $id)->get();
        foreach ($help_topics as $help_topic) {
            $help_topic->custom_security = null;
            $help_topic->save();
        }
        foreach ($fields as $field) {
            $field->delete();
        }
        $securitys = $securitys->where('id', $id)->first();
        $securitys->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
