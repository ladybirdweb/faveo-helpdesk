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
use Exception;
use Form;

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
        $this->middleware('auth', [
            'except' => [
                'renderForm',
                'getType',
                'getAttribute',
                'getForm',
                'createValues',
                'addChild',
                'renderChild',
                'jqueryScript',
                'jqueryCheckboxScript',
                'jquerySelectScript',
            ]
        ]);
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
        } catch (Exception $e) {
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
            $forms = new Forms();
            $form = $forms->find($id);
            //dd($form);
            if ($form) {
                $fields = $form->fields();
                return view('themes.default1.admin.helpdesk.manage.form.preview', compact('form', 'fields'));
            }
            throw new Exception("Sorry we can't find your request");
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Store a new form.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'formname'=>'required|unique:custom_forms,formname',
            'label.*'=>'required',
            'name.*'=>'required',
            'type.*'=>'required',
        ]);
        try {
            $forms = new Forms();
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
                    $field = Fields::create([
                                'forms_id' => $forms->id,
                                'label' => Input::get('label')[$i],
                                'name' => Input::get('name')[$i],
                                'type' => Input::get('type')[$i],
                                'required' => $require[$i],
                    ]);
                    $field_id = $field->id;
                    $this->createValues($field_id, Input::get('value')[$i]);
                }
            }

            return Redirect::back()->with('success', Lang::get('lang.successfully_created_form'));
        } catch (Exception $ex) {

            return redirect()->back()->with('fails', $ex->getMessage());
        }
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

    public function edit($id) {
        try {
            $forms = new Forms();
            $form = $forms->find($id);
            $select_forms = $forms->where('id', '!=', $id)->lists('formname', 'id')->toArray();
            //dd($form);
            if ($form) {
                $fields = $form->fields();
                //dd($fields);
                return view('themes.default1.admin.helpdesk.manage.form.edit', compact('form', 'fields', 'select_forms'));
            }
            throw new Exception("Sorry we can't find your request");
        } catch (Exception $ex) {

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function addChildForm($id) {
        try {
            $forms = new Forms();
            $form = $forms->find($id);
            $select_forms = $forms->where('id', '!=', $id)->lists('formname', 'id')->toArray();
            //dd($form);
            if ($form) {
                $fields = $form->fields();
                //dd($fields);
                return view('themes.default1.admin.helpdesk.manage.form.add-child', compact('form', 'fields', 'select_forms'));
            }
            throw new Exception("Sorry we can't find your request");
        } catch (Exception $ex) {

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'formname'=>'required|unique:custom_forms,formname,'.$id,
            'label.*'=>'required',
            'name.*'=>'required',
            'type.*'=>'required',
        ]);
        try {
            if (!$request->input('formname')) {
                throw new Exception(Lang::get('lang.please_fill_form_name'));
            }
            $form = new Forms();
            $forms = $form->find($id);
            if (!$forms) {
                throw new Exception("Sorry we can not find your request");
            }
            $forms->formname = Input::get('formname');
            $forms->save();
            $count = count(Input::get('name'));
            $field = new Fields();
            $fields = $field->where('forms_id', $forms->id)->get();
            if ($fields->count($fields) > 0) {
                foreach ($fields as $fi) {
                    $fi->delete();
                }
            }
            //dd(Input::get('label'),Input::get('name'),Input::get('type'),Input::get('required'));
            for ($i = 0; $i < $count; $i++) {
                $field = $field->create([
                    'forms_id' => $forms->id,
                    'label' => Input::get('label')[$i],
                    'name' => Input::get('name')[$i],
                    'type' => Input::get('type')[$i],
                    'required' => Input::get('required')[$i],
                ]);
                $field_id = $field->id;
                $this->createValues($field_id, Input::get('value')[$i]);
            }
            return redirect()->back()->with('success', 'updated');
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function renderForm($formid) {
        $html = "";
        $forms = new Forms();
        $form = $forms->find($formid);
        if ($form) {
            $fields = $form->fields();
            foreach ($fields as $field) {
                $html .= self::getForm($field);
            }
        }
        return self::requiredStyle() . $html;
    }

    public static function getType($type) {
        switch ($type) {
            case "select":
                return "select";
            case "text":
                return "text";
            case "email":
                return "email";
            case "textarea":
                return "textarea";
            case "select":
                return "select";
            case "radio":
                return "radio";
            case "checkbox":
                return "checkbox";
            case "hidden":
                return "hidden";
            case "password":
                return "password";
        }
    }

    public static function getAttribute($type) {
        switch ($type) {
            case "select":
                return "null,['class'=>'form-control']";
            case "text":
                return "['class'=>'form-control']";
            case "email":
                return "['class'=>'form-control']";
            case "textarea":
                return "['class'=>'form-control']";
            case "radio":
                return "";
            case "checkbox":
                return "";
            case "hidden":
                return "";
            case "password":
                return "['class'=>'form-control']";
        }
    }

    public static function getForm($field) {
        $required = false;
        $required_class = self::requiredClass($field->required);
        if ($field->required === '1') {
            $required = true;
        }
        $type = $field->type;
        $field_type = self::getType($type);
        switch ($field_type) {
            case "select":
                return self::selectForm($field_type, $field, $required, $required_class);
            case "text":
                return Form::label($field->label, $field->label, ['class' => $required_class]) .
                        Form::$field_type($field->name, NULL, ['class' => "form-control $field->id", 'id' => $field->id, 'required' => $required]);
            case "email":
                return Form::label($field->label, $field->label, ['class' => $required_class]) .
                        Form::$field_type($field->name, NULL, ['class' => "form-control $field->id", 'id' => $field->id, 'required' => $required]);
            case "password":
                return Form::label($field->label, $field->label, ['class' => $required_class]) .
                        Form::$field_type($field->name, ['class' => "form-control $field->id", 'id' => $field->id, 'required' => $required]);

            case "textarea":
                return Form::label($field->label, $field->label, ['class' => $required_class]) .
                        Form::$field_type($field->name, NULL, ['class' => "form-control $field->id", 'id' => $field->id, 'required' => $required]);
            case "radio":
                return self::radioForm($field_type, $field, $required, $required_class);

            case "checkbox":
                return self::checkboxForm($field_type, $field, $required, $required_class);
            case "hidden":
                return Form::$field_type($field->name, NULL, ['id' => $field->id]);
        }
    }

    public function createValues($fieldid, $values, $childid = NULL, $key = "") {
        if ($values) {
            $values_array = explode(',', $values);
            $field_values = new \App\Model\helpdesk\Form\FieldValue();
            $field_value = $field_values->where('field_id', $fieldid)->get();
            if ($field_value->count() > 0) {
                foreach ($field_value as $fv) {
                    $fv->delete();
                }
            }
            if (count($values_array) > 0) {
                foreach ($values_array as $value) {
                    $field_values->create([
                        'field_id' => $fieldid,
                        'child_id' => $childid,
                        'field_key' => $key,
                        'field_value' => $value
                    ]);
                }
            }
        }
    }

    public function addChild($fieldid, Request $request) {
        $ids = $request->except('_token');
        try {
            foreach ($ids as $valueid => $formid) {
                $field_value = new \App\Model\helpdesk\Form\FieldValue();
                $field_values = $field_value->where('field_id', $fieldid);
                $values = $field_values->where('id', $valueid)->first();
                if ($values) {
                    //if ($formid) {
                    $values->child_id = $formid;
                    $values->save();
                    //}
                }
            }
            return redirect()->back()->with('success', 'Updated');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function renderChild(Request $request) {
        $render = "";
        $value = $request->input('valueid');
        $fieldid = $request->input('fieldid');
        $field_values = new \App\Model\helpdesk\Form\FieldValue();
        $field_value = $field_values->where('field_id', $fieldid)->where('field_value', $value)->first();
        $child = "";
        if ($field_value) {
            $child = $field_value->child_id;
        }
        if ($child !== "") {
            $render = $this->renderForm($child);
        }

        return $render;
    }

    public static function jqueryScript($value, $fieldid, $fieldname, $type = "") {
        if ($type == "select") {
            return self::jquerySelectScript($fieldid);
        }
        if ($type == "checkbox") {
            return self::jqueryCheckboxScript($value, $fieldid, $fieldname);
        }
        return '<script>
            $("#' . str_slug($value) . '").on("change", function () {
                var valueid = $("#' . str_slug($value) . '").val();
                var fieldid = $("#' . $fieldid . str_slug($value) . '").val();
                send(valueid,fieldid);
            });
            function send(valueid,fieldid) {
                $.ajax({
                    url: "' . url('forms/render/child/') . '",
                    dataType: "html",
                    data: {"valueid": valueid,"fieldid": fieldid},
                    success: function (response) {
                        $("#' . $fieldname . '").html(response);
                    },
                    error: function (response) {
                        $("#' . $fieldname . '").html(response);
                    }
                });
            }
        </script>';
    }

    public static function jqueryCheckboxScript($value, $fieldid, $fieldname) {
        $fields = new Fields();
        $field = $fields->find($fieldid);
        if ($field) {
            return '<script>
            $("#' . str_slug($value) . '").on("change", function () {
                var valueid = $("#' . str_slug($value) . '").val();
                var fieldid = $("#' . $fieldid . str_slug($value) . '").val();
                send(valueid,fieldid);
            });
            function send(valueid,fieldid) {
                $.ajax({
                    url: "' . url('forms/render/child/') . '",
                    dataType: "html",
                    data: {"valueid": valueid,"fieldid": fieldid},
                    success: function (response) {
                        $("#' . $value . '").html(response);
                    },
                    error: function (response) {
                        $("#' . $value . '").html(response);
                    }
                });
            }
        </script>';
        }
    }

    public static function jquerySelectScript($fieldid) {
        $fields = new Fields();
        $field = $fields->find($fieldid);
        if ($field) {
            return '<script>
    $(document).ready(function () {
        var valueid = $(".' . $fieldid . '").val();
       var fieldid = $("#hidden' . $fieldid . '").val();
                send(valueid,fieldid);
        $(".' . $fieldid . '").on("change", function () {
            valueid = $(".' . $fieldid . '").val();
            var fieldid = $("#hidden' . $fieldid . '").val();
                send(valueid,fieldid);
        });
        function send(valueid,fieldid) {
            $.ajax({
                url: "' . url('forms/render/child/') . '",
                dataType: "html",
                 data: {"valueid": valueid,"fieldid": fieldid},
                success: function (response) {
                    $("#' . $field->name . '").html(response);
                },
                error: function (response) {
                    $("#' . $field->name . '").html(response);
                }
            });
        }
    });

</script>';
        }
    }

    public static function selectForm($field_type, $field, $required, $required_class) {
        $script = self::jqueryScript($field_value = "", $field->id, $field->name, $field_type);
        $form_hidden = Form::hidden('fieldid[]', $field->id, ['id' => "hidden" . $field->id]) . Form::label($field->label, $field->label, ['class' => $required_class]);
        $select = Form::$field_type($field->name, ['' => 'Select', 'Selects' => $field->values()->lists('field_value', 'field_value')->toArray()], null, ['class' => "form-control $field->id", 'id' => $field->id, 'required' => $required]) . "</br>";
        $html = $script . $form_hidden . $select;
        $response_div = "<div id=" . $field->name . "></div>";
        return $html . $response_div;
    }

    public static function radioForm($field_type, $field, $required, $required_class) {
        $radio = "";
        $html = "";
        $values = $field->values()->lists('field_value')->toArray();
        if (count($values) > 0) {
            foreach ($values as $field_value) {

                $script = self::jqueryScript($field_value, $field->id, $field->name, $field_type);
                $radio .= "<div>" . Form::hidden('fieldid[]', $field->id, ['id' => $field->id . str_slug($field_value)]);
                $radio .= Form::$field_type($field->name, $field_value, NULL, ['class' => "$field->id", 'id' => str_slug($field_value), 'required' => $required]) . $script . "<span>   " . $field_value . "</span></div>";
            }
            $html = Form::label($field->label, $field->label, ['class' => $required_class]) . "</br>" . $radio . "<div id=" . $field->name . "></br></div>";
        }
        return $html;
    }

    public static function checkboxForm($field_type, $field, $required, $required_class) {
        $checkbox = "";
        $html = "";
        $values = $field->values()->lists('field_value')->toArray();
        if (count($values) > 0) {
            foreach ($values as $field_value) {
                $script = self::jqueryScript($field_value, $field->id, $field->name, $field_type);
                $checkbox .= "<div>" . Form::hidden('fieldid[]', $field->id, ['id' => $field->id . str_slug($field_value)]);
                $checkbox .= Form::$field_type($field_value, $field_value, NULL, ['class' => "$field->id", 'id' => str_slug($field_value), 'required' => $required]);
                $checkbox .= "<span>   " . $field_value . "</span></div>";
                //$checkbox .="</br>";
                $checkbox .="<div id=" . $field_value . "></div>" . $script;
            }
            $html = Form::label($field->label, $field->label, ['class' => $required_class]) . "</br>" . $checkbox;
        }
        return $html;
    }

    public static function requiredStyle() {

        $style = "<style>
                .required:after {
                                        color: #e32 !important;
                                        content: ' * ' !important;
                                        display:inline !important;
                                    }
                    </style>";
        return $style;
    }

    public static function requiredClass($required) {
        $class = "";
        if ($required === '1') {
            $class = "required";
        }
        return $class;
    }

}
