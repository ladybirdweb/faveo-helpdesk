<?php

use Illuminate\Database\Seeder;

class CustomFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('forms')->truncate();
        \App\Model\Custom\Required::truncate();
        $this->seedTicketForm();
//        $this->seedUserForm();
//        $this->seedOrganisationForm();
        //$this->seedRequired();
    }

    public function seedTicketForm()
    {
        $json = "[{
        'title': 'Requester',
        'agentlabel':[
                 {'language':'en','label':'Requester','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Requester','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'email',
        'agentCCfield':true,
        'customerCCfield':false,
        'customerDisplay':true,
        'agentRequiredFormSubmit':true,
        'customerRequiredFormSubmit':true,
        'default':'yes',
        'value':'',
        'unique':'requester'
        },{
        'title': 'Subject',
        'agentlabel':[
                 {'language':'en','label':'Subject','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Subject','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'text',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'default':'yes',
        'value':'',
        'unique':'subject'
        },{
        'title': 'Type',
        'agentlabel':[
                 {'language':'en','label':'Type','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Type','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'select',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'value':'',
        'api':'type',
        'options':[
        ],
        'default':'yes',
        'unique':'type'
        },{
        'title': 'Status',
        'agentlabel':[
                 {'language':'en','label':'Status','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Status','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'select',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'value':'',
        'api':'status',
        'options':[
           
        ],
        'default':'yes',
        'unique':'status'
        },{
        'title': 'Priority',
        'agentlabel':[
                 {'language':'en','label':'Priority','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Priority','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'select',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'value':'',
        'api':'priority',
        'options':[
           
        ],
        'default':'yes',
        'unique':'priority'
        },{
        'title': 'Help Topic',
        'agentlabel':[
                 {'language':'en','label':'Help Topic','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Help Topic','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'multiselect',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'value':'',
        'api':'helptopic',
        'options':[
           
        ],
        'default':'yes',
        'unique':'help_topic'
        },{
        'title': 'Department',
        'agentlabel':[
                 {'language':'en','label':'Department','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Department','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'multiselect',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'value':'',
        'api':'department',
        'options':[
           
        ],
        'default':'yes',
        'unique':'department',
        'linkHelpTopic':false
        },{
        'title': 'Assigned',
        'agentlabel':[
                 {'language':'en','label':'Assigned','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Assigned','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'select',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'value':'',
        'api':'assigned_to',
        'options':[
           
        ],
        'default':'yes',
        'unique':'assigned'
        },{
        'title': 'Description',
        'agentlabel':[
                 {'language':'en','label':'Description','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Description','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'textarea',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':'',
        'unique':'description',
        'media_option':true
        },
        {
        'title': 'Company',
        'agentlabel':[
                 {'language':'en','label':'Company','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Company','flag':'".faveoUrl('lb-faveo/flags/en.png')."'}
                ],
        'type':'select',
        'agentRequiredFormSubmit':false,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':'',
        'api':'company',
        'options':[
           
        ],
        'unique':'company'
        },
        {
        'title': 'Captcha',
        'agentShow':true,
        'customerDisplay':true,
        'default':'yes'
        }
        ]
";
        $json = trim(preg_replace('/\s+/', ' ', $json));
        $form = 'ticket';
        \DB::table('forms')->insert(['form' => $form, 'json' => $json]);
        $form_controller = new \App\Http\Controllers\Utility\FormController();
        $form_controller->saveRequired($form);
    }

    public function seedUserForm()
    {
        $json = "[{
        'title': 'First Name',
        'agentlabel':[
                 {'language':'en','label':'First Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'First Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'text',
        'customerDisplay':true,
        'agentRequiredFormSubmit':true,
        'customerRequiredFormSubmit':true,
        'default':'yes',
        'value':'',
        'unique':'first_name'
        },{
        'title': 'Last Name',
        'agentlabel':[
                 {'language':'en','label':'Last Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Last Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'text',
        'customerDisplay':true,
        'agentRequiredFormSubmit':true,
        'customerRequiredFormSubmit':true,
        'default':'yes',
        'value':'',
        'unique':'last_name'
        },{
        'title': 'Work Phone',
        'agentlabel':[
                 {'language':'en','label':'Work Phone','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Work Phone','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'number',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'default':'yes',
        'value':'',
        'unique':'phone_number'
        },{
        'title': 'Email',
        'agentlabel':[
                 {'language':'en','label':'Email','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Email','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'email',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'value':'',
        'default':'yes',
        'unique':'email'
        },{
        'title': 'Mobile Phone',
        'agentlabel':[
                 {'language':'en','label':'Mobile Phone','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Mobile Phone','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'number',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'value':'',
        'default':'yes',
        'unique':'mobile'
        },{
        'title': 'Address',
        'agentlabel':[
                 {'language':'en','label':'Address','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Address','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'textarea',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':true,
        'value':'',
        'default':'no',
        'unique':'address'
        },{
        'title': 'Organisation',
        'agentlabel':[
                 {'language':'en','label':'Organisation','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Organisation','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'select2',
        'agentRequiredFormSubmit':false,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':'',
        'unique':'organisation'
        
        },{
        'title': 'Department Name',
        'agentlabel':[
                 {'language':'en','label':'Department Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Department Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'select',
        'agentRequiredFormSubmit':false,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':'',
        'unique':'department',
        'options':[
           
        ],
        'api':'organisationdept'
        },
        {
        'title': 'Captcha',
        'agentShow':true,
        'customerDisplay':true,
        'default':'yes'
        }]";
        $json = trim(preg_replace('/\s+/', ' ', $json));
        $form = 'user';
        \DB::table('forms')->insert(['form' => $form, 'json' => $json]);
        $form_controller = new \App\Http\Controllers\Utility\FormController();
        $form_controller->saveRequired($form);
    }

    public function seedOrganisationForm()
    {
        $json = "[{
        'title': 'Company Name',
        'agentlabel':[
                 {'language':'en','label':'Company Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Company Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'text',
        'customerDisplay':true,
        'agentRequiredFormSubmit':true,
        'customerRequiredFormSubmit':true,
        'default':'yes',
        'value':'',
        'unique':'name'
        },{
        'title': 'Phone',
        'agentlabel':[
                 {'language':'en','label':'Phone','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Phone','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'number',
        'customerDisplay':true,
        'agentRequiredFormSubmit':false,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':'',
        'unique':'phone'
        },{
        'title': 'Company Domain Name',
        'agentlabel':[
                 {'language':'en','label':'Company Domain Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Company Domain Name','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'select2',
        'agentRequiredFormSubmit':false,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':'',
        'unique':'domain'
        },{
        'title': 'Description',
        'agentlabel':[
                 {'language':'en','label':'Description','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Description','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'textarea',
        'agentRequiredFormSubmit':false,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'value':'',
        'default':'yes',
        'unique':'internal_notes'
        },{
        'title': 'Address',
        'agentlabel':[
                 {'language':'en','label':'Address','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Address','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'textarea',
        'agentRequiredFormSubmit':false,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'value':'',
        'default':'yes',
        'unique':'address'
        },{
        'title': 'Manager',
        'agentlabel':[
                 {'language':'en','label':'Manager','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Manager','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'select',
        'agentRequiredFormSubmit':false,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'value':'',
        'default':'yes',
        'unique':'head',
        'api':'assigned_to'
        },{
        'title': 'Department',
        'agentlabel':[
                 {'language':'en','label':'Department','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'clientlabel':[
                 {'language':'en','label':'Department','flag':'".asset('lb-faveo/flags/en.png')."'}
                ],
        'type':'select2',
        'agentRequiredFormSubmit':false,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'yes',
        'value':'',
        'unique':'department'
        }]";
        $json = trim(preg_replace('/\s+/', ' ', $json));
        $form = 'organisation';
        \DB::table('forms')->insert(['form' => $form, 'json' => $json]);
        $form_controller = new \App\Http\Controllers\Utility\FormController();
        $form_controller->saveRequired($form);
    }
}
