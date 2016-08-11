<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

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
        $current_rule = [
            'Name'    => 'required',
            'Email'   => 'required|email',
            'Subject' => 'required',
            'Details' => 'required',
        ];
        $custom_rule = $this->getCustomRule();
        $rules = array_merge($current_rule,$custom_rule);
        return $rules;
        
    }
    
    public function getHelpTopic(){
        $help_topics = new \App\Model\helpdesk\Manage\Help_topic();
        $topic = $this->input('helptopic');
        $help_topic = $help_topics->where('id',$topic)->first();
        return $help_topic;
    }
    
    public function getCustomRule(){
        $custom_form = "";
        $help_topic = $this->getHelpTopic();
        if($help_topic){
            $custom_form = $help_topic->custom_form;
            
        }
        return $this->getForm($custom_form);
    }
    
    public function getForm($formid){
        $id = "";
        $forms = new \App\Model\helpdesk\Form\Forms();
        $form = $forms->where('id',$formid)->first();
        if($form){
            $id = $form->id;
            
        }
        return $this->getFields($id);
    }
    
    public function getFields($formid){
        $rules = [];
        $field = new \App\Model\helpdesk\Form\Fields();
        $fields = $field->where('forms_id',$formid)->get();
        if($fields->count()>0){
            foreach($fields as $fd){
                if($fd->required==='1'){
                    $rules[str_slug($fd->name,'_')]="required";
                }
            }
        }
        return $rules;
    }
}
