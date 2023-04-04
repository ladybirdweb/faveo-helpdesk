<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;
use App\Model\helpdesk\Settings\CommonSettings;
use Illuminate\Support\Arr;

/**
 * CompanyRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class ClientRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $check = $this->check(new CommonSettings());
        if ($check != 0) {
            $custom_rule = $this->getCustomRule();
            $rules = array_merge($check, $custom_rule);

            return $rules;
        }
        $current_rule = [
            'Name'    => 'required',
            'Email'   => 'required|email',
            'Subject' => 'required',
            'Details' => 'required',
            'mobile'  => 'numeric',
            'Phone'   => 'numeric',
        ];
        $custom_rule = $this->getCustomRule();
        $rules = array_merge($current_rule, $custom_rule);

        return $rules;
    }

    public function getHelpTopic()
    {
        $help_topics = new \App\Model\helpdesk\Manage\Help_topic();
        $topic = $this->input('helptopic');
        $help_topic = $help_topics->where('id', $topic)->first();

        return $help_topic;
    }

    public function getCustomRule()
    {
        $custom_form = '';
        $help_topic = $this->getHelpTopic();
        if ($help_topic) {
            $custom_form = $help_topic->custom_form;
        }

        return $this->getForm($custom_form);
    }

    public function getForm($formid)
    {
        $id = '';
        $forms = new \App\Model\helpdesk\Form\Forms();
        $form = $forms->where('id', $formid)->first();
        if ($form) {
            $id = $form->id;
        }

        return $this->getFields($id);
    }

    public function getFields($formid)
    {
        $rules = [];
        $field = new \App\Model\helpdesk\Form\Fields();
        $fields = $field->where('forms_id', $formid)->get();
        if ($fields->count() > 0) {
            foreach ($fields as $fd) {
                if ($fd->required === '1') {
                    $rules[str_replace(' ', '_', $fd->name)] = 'required';
                }
                $rules = array_merge($rules, $this->getChild($fd->id));
            }
        }

        return $rules;
    }

    public function getChild($fieldid)
    {
        $children = new \App\Model\helpdesk\Form\FieldValue();
        $childs = $children->where('field_id', $fieldid)->get();
        $rules = [];
        if ($childs->count() > 0) {
            foreach ($childs as $child) {
                $child_formid = $child->child_id;

                return $this->getForm($child_formid);
            }
        }

        return [];
    }

    /**
     *@category Funcion to set rule if send opt is enabled
     *
     *@param  object  $settings (instance of Model common settings)
     *
     *@author manish.verma@ladybirdweb.com
     *
     *@return array|int
     */
    public function check($settings)
    {
        $settings = $settings->select('status')->where('option_name', '=', 'send_otp')->first();
        $email_mandatory = $settings->select('status')->where('option_name', '=', 'email_mandatory')->first();
        if ($email_mandatory->status == 0 || $email_mandatory->status == '0') {
            if (!\Auth::check()) {
                return [
                    'Name'    => 'required',
                    'Email'   => 'email',
                    'Subject' => 'required',
                    'Details' => 'required',
                    'mobile'  => 'required|numeric',
                    'Phone'   => 'numeric',
                ];
            } else {
                return [
                    'Subject' => 'required',
                    'Details' => 'required',
                ];
            }
        } else {
            return 0;
        }
    }

//    public function purifyArray($array){
//        $purified = [];
//        foreach($array as $key=>$value){
//            if(!is_array($value)){
//                $purified[$key]="required";
//            }else{
//                $purified[] = $this->purifyArray($value);
//            }
//        }
//        return Arr::dot($purified);
//    }
}
