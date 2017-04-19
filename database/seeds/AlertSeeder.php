<?php

use Illuminate\Database\Seeder;
use App\Model\helpdesk\Settings\Alert;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Alert::truncate();
        $array = $this->getValues();
        foreach ($array as $value){
            Alert::create($value);
        }
    }
    
    public function getValues(){
        return [
            [
                'key'=>'new_ticket_alert',
                'value'=>'1',
            ],
            [
                'key'=>'new_ticket_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'new_ticket_alert_persons',
                'value'=>'admin,department_manager,department_members',
            ],
            [
                'key'=>'ticket_assign_alert',
                'value'=>'1',
            ],
            [
                'key'=>'ticket_assign_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'ticket_assign_alert_persons',
                'value'=>'assigned_agent_team',
            ],
            [
                'key'=>'notification_alert',
                'value'=>'1',
            ],
            [
                'key'=>'notification_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'notification_alert_persons',
                'value'=>'admin,agent,department_manager,team_lead',
            ],
            [
                'key'=>'internal_activity_alert',
                'value'=>'1',
            ],
            [
                'key'=>'internal_activity_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'internal_activity_alert_persons',
                'value'=>'assigned_agent_team',
            ],
            [
                'key'=>'ticket_transfer_alert',
                'value'=>'1',
            ],
            
            
            
            
            [
                'key'=>'ticket_transfer_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'ticket_transfer_alert_persons',
                'value'=>'assigned_agent_team,department_members',
            ],
            [
                'key'=>'registration_alert',
                'value'=>'1',
            ],
            [
                'key'=>'registration_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'registration_alert_persons',
                'value'=>'client',
            ],
            [
                'key'=>'new_user_alert',
                'value'=>'1',
            ],
            
            
            [
                'key'=>'new_user_alert_mode',
                'value'=>'system',
            ],
            [
                'key'=>'new_user_alert_persons',
                'value'=>'admin',
            ],
            [
                'key'=>'reply_alert',
                'value'=>'1',
            ],
            [
                'key'=>'reply_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'reply_alert_persons',
                'value'=>'client',
            ],
            [
                'key'=>'reply_notification_alert',
                'value'=>'1',
            ],
            
            
            [
                'key'=>'reply_notification_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'reply_notification_alert_persons',
                'value'=>'assigned_agent_team',
            ],
            
            [
                'key'=>'new_ticket_confirmation_alert',
                'value'=>'1',
            ],
            [
                'key'=>'new_ticket_confirmation_alert_mode',
                'value'=>'email',
            ],
            [
                'key'=>'new_ticket_confirmation_alert_persons',
                'value'=>'client',
            ],
            
            [
                'key'=>'sla_alert',
                'value'=>'1',
            ],
            [
                'key'=>'sla_alert_mode',
                'value'=>'email,system',
            ],
            [
                'key'=>'sla_alert_persons',
                'value'=>'assigned_agent_team,department_manager,admin',
            ],
            
        ];
    }
}
