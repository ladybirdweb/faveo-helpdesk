<?php

namespace App\Http\Controllers\Admin\helpdesk;

// Controller
use App\Http\Controllers\Controller;
// Model
use App\Model\helpdesk\Form\Fields;
use App\Model\helpdesk\Form\Forms;
use App\Model\helpdesk\Manage\Help_topic;
// Request
use Illuminate\Http\Request;
// Class
use Input;
use Redirect;
use Exception;

/**
 * FormController
 * This controller is used to CRUD Custom Forms
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class FormController extends Controller {

    private $fields;
    private $forms;

    public function __construct(Fields $fields, Forms $forms) {
        $this->fields = $fields;
        $this->forms = $forms;
        // $this->middleware('auth');
    }

    /**
     * home
     * @return type
     */
    public function home() {
        return view('forms.home');
    }

    /**
     * list of forms
     * @param type Forms $forms 
     * @return Response
     */
    public function index(Forms $forms) {
        return view('themes.default1.admin.helpdesk.manage.form.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('themes.default1.admin.helpdesk.manage.form.form');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return view('themes.default1.admin.helpdesk.manage.form.preview', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Forms $forms) {
        if (!Input::get('formname')) {
            return Redirect::back()->with('fails', 'Please fill Form name');
        }
        $required = Input::get('required');
        $count = count($required);
        $require = array();
        for ($i = 2; $i < $count + 2; $i++) {
            for ($j = 0; $j < 1; $j++) {
                array_push($require, $required[$i][$j]);
            }
        }
        $forms->formname = Input::get('formname');
        $forms->save();
        $count = count(Input::get('name'));
        $fields = array();
        for ($i = 0; $i <= $count; $i++) {
            if (!empty(Input::get('name')[$i])) {
                array_push($fields, array(
                    'forms_id' => $forms->id,
                    'label' => Input::get('label')[$i],
                    'name' => Input::get('name')[$i],
                    'type' => Input::get('type')[$i],
                    'value' => Input::get('value')[$i],
                    'required' => $require[$i],
                ));
            }
        }
        Fields::insert($fields);
        return Redirect::back()->with('success', 'Successfully created Form');
    }

    public function delete($id, Forms $forms, Fields $field, Help_topic $help_topic) {
        $fields = $field->where('forms_id', $id)->get();
        $help_topics = $help_topic->where('custom_form', '=', $id)->get();
        foreach ($help_topics as $help_topic) {
            $help_topic->custom_form = null;
            $help_topic->save();
        }
        foreach ($fields as $field) {
            $field->delete();
        }
        $forms = $forms->where('id', $id)->first();
        $forms->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

}
