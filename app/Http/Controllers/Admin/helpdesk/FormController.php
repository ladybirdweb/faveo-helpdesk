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
use Lang;
use Redirect;

/**
 * FormController
 * This controller is used to CRUD Custom Forms.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class FormController extends Controller {

    private $fields;
    private $forms;

    public function __construct(Fields $fields, Forms $forms) {
        $this->fields = $fields;
        $this->forms = $forms;
        $this->middleware('auth');
    }

    /**
     * home.
     *
     * @return type
     */
    public function home() {
        return view('forms.home');
    }

    /**
     * list of forms.
     *
     * @param type Forms $forms
     *
     * @return Response
     */
    public function index(Forms $forms) {
        try {
            return view('themes.default1.admin.helpdesk.manage.form.index', compact('forms'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * create a new form.
     *
     * @return Response
     */
    public function create() {
        try {
            return view('themes.default1.admin.helpdesk.manage.form.form');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Show a new form.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id) {
        try {
            return view('themes.default1.admin.helpdesk.manage.form.preview', compact('id'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Store a new form.
     *
     * @return Response
     */
    public function store(Forms $forms) {
        if (!Input::get('formname')) {
            return Redirect::back()->with('fails', Lang::get('lang.please_fill_form_name'));
        }
        $required = Input::get('required');
        $count = count($required);
        $require = [];
        for ($i = 2; $i < $count + 2; $i++) {
            for ($j = 0; $j < 1; $j++) {
                array_push($require, $required[$i][$j]);
            }
        }
        $forms->formname = Input::get('formname');
        $forms->save();
        $count = count(Input::get('name'));
        $fields = [];
        for ($i = 0; $i <= $count; $i++) {
            if (!empty(Input::get('name')[$i])) {
                array_push($fields, [
                    'forms_id' => $forms->id,
                    'label' => Input::get('label')[$i],
                    'name' => Input::get('name')[$i],
                    'type' => Input::get('type')[$i],
                    'value' => Input::get('value')[$i],
                    'required' => $require[$i],
                ]);
            }
        }
        Fields::insert($fields);

        return Redirect::back()->with('success', Lang::get('lang.successfully_created_form'));
    }

    /**
     * Delete Form.
     *
     * @param type                           $id
     * @param \App\Model\helpdesk\Form\Forms $forms
     * @param type                           $field
     * @param type                           $help_topic
     *
     * @return type redirect
     */
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

        return redirect()->back()->with('success', Lang::get('lang.form_deleted_successfully'));
    }

}
