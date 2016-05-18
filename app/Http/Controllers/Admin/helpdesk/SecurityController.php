<?php

namespace App\Http\Controllers\Admin\helpdesk;

// Controller
use App\Http\Controllers\Controller;
// Model
use App\Model\helpdesk\Settings\Security;
use App\Http\Requests\helpdesk\SecurityRequest;
// Request
use Illuminate\Http\Request;
// Class
use Input;
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
        $security = $securitys->whereId('1')->first();
        return view('themes.default1.admin.helpdesk.settings.security.index', compact('security'));
    }

    /**
     * Show the security for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('themes.default1.admin.helpdesk.setting.security.security');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return view('themes.default1.admin.helpdesk.setting.security.preview', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function update($id, SecurityRequest $request)
    {
        $security = new Security();
$securitys = $security->whereId($id)->first();
  $securitys->lockout_message = $request->input('lockout_message');
    $securitys->backlist_offender = $request->input('backlist_offender');
      $securitys->backlist_threshold = $request->input('backlist_threshold');
      $securitys->lockout_period = $request->input('lockout_period');  
          $securitys->days_to_keep_logs = $request->input('days_to_keep_logs'); 
          $securitys->save();
        return Redirect::back()->with('success', 'Successfully Saved your Settings');
    }

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
