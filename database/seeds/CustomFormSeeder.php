<?php

use Illuminate\Database\Seeder;

class CustomFormSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->seedForms();
        $this->seedRequired();
    }

    public function seedForms() {
        \DB::table('forms')->truncate();
        $json = "[{
        'title': 'Requester',
        'label':'Requester',
        'type':'email',
        'agentCCfield':true,
        'customerCCfield':false,
        'customerDisplay':true,
        'agentRequiredFormSubmit':true,
        'customerRequiredFormSubmit':true,
        'default':'yes',
        'value':'',
        'customer_name':true,
        'customer_email':true,
        'customer_mobile':true,
        'agent_name':true,
        'agent_email':true,
        'agent_mobile':true
        },{
        'title': 'Subject',
        'label':'Subject',
        'type':'text',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'default':'yes',
        'value':''
        },{
        'title': 'Status',
        'label':'Status',
        'type':'select',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'value':'',
        'api':'status',
        'options':[
           
        ],
        'default':'yes'
        },{
        'title': 'Priority',
        'label':'Priority',
        'type':'select',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'value':'',
        'api':'priority',
        'options':[
           
        ],
        'default':'yes'
        },{
        'title': 'Help Topic',
        'label':'Help Topic',
        'type':'select',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'value':'',
        'api':'helptopic',
        'options':[
           
        ],
        'default':'yes'
        },{
        'title': 'Assigned',
        'label':'Assigned',
        'type':'select',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'value':'',
        'api':'assigned_to',
        'options':[
           
        ],
        'default':'yes'
        },{
        'title': 'Description',
        'label':'Description',
        'type':'textarea',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':''
        },{
        'title': 'Company',
        'label':'Company',
        'type':'select',
        'agentRequiredFormSubmit':false,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':'',
        'api':'company',
        'options':[
           
        ]
        }]
";
        $json = trim(preg_replace('/\s+/', ' ', $json));
        $form = "ticket";
        \DB::table('forms')->insert(['form' => $form, 'json' => $json]);
    }

    public function seedRequired() {
        \DB::table('required_fields')->truncate();
        $fields = [
            ['name' => 'Requester', 'is_agent_required' => 1, 'is_client_required' => 1],
            ['name' => 'Subject', 'is_agent_required' => 1, 'is_client_required' => 1],
            ['name' => 'Type', 'is_agent_required' => 1, 'is_client_required' => 1],
            ['name' => 'Status', 'is_agent_required' => 1, 'is_client_required' => 1],
            ['name' => 'Priority', 'is_agent_required' => 1, 'is_client_required' => 1],
            ['name' => 'Group', 'is_agent_required' => 1, 'is_client_required' => 1],
            ['name' => 'Agent', 'is_agent_required' => 1, 'is_client_required' => 1],
            ['name' => 'Description', 'is_agent_required' => 1, 'is_client_required' => 1],
            ['name' => 'Company', 'is_agent_required' => 1, 'is_client_required' => 1],
        ];
        $form = "ticket";
        foreach ($fields as $field) {
            \DB::table('required_fields')->insert(['name' => $field['name'], 'form' => $form, 'is_agent_required' => $field['is_agent_required'], 'is_client_required' => $field['is_client_required']]);
        }
    }
    

}
