<?php

namespace App\Http\Requests\helpdesk\Job;

use App\Http\Requests\Request;

class TaskRequest extends Request
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
        return [
            'fetching-commands'     => 'required_if:email_fetching,1',
            'notification-commands' => 'required_if:notification_cron,1',
            'work-commands'         => 'required_if:condition,1',
            'workflow-dailyAt'      => 'required_if:work-commands,dailyAt',
            'notification-dailyAt'  => 'required_if:notification-commands,dailyAt',
            'fetching-dailyAt'      => 'required_if:fetching-commands,dailyAt',
        ];
    }

    public function messages()
    {
        return [
            'fetching-commands.required_if'     => 'Please choose your Email Fetching timing',
            'notification-commands.required_if' => 'Please choose your Email Notification timing',
            'work-commands.required_if'         => 'Please choose your Auto-close Workflow timing',
            'workflow-dailyAt.required_if'      => 'Please enter the time for Auto-close Workflow timing',
            'notification-dailyAt.required_if'  => 'Please enter the time for Email Notification timing',
            'fetching-dailyAt.required_if'      => 'Please enter the time for Email Fetching timing',

        ];
    }
}
