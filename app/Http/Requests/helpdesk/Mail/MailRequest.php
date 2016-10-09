<?php

namespace App\Http\Requests\helpdesk\Mail;

use App\Http\Requests\Request;

class MailRequest extends Request
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
        $id = $this->segment(2);
        $rules = [
            'email_address' => 'required|email|unique:emails,id,'.$id,
            'email_name'    => 'required',
            'password'      => 'required',
        ];
        $driver = $this->input('sending_protocol');
        $driver_rules = $this->getDriver($driver);
        $rules = array_merge($rules, $driver_rules);

        return $rules;
    }

    public function getDriver($serviceid)
    {
        $rules = [];
        $mail_services = new \App\Model\MailJob\MailService();
        $mail_service = $mail_services->find($serviceid);
        if ($mail_service) {
            $short = $mail_service->short_name;
            $rules = $this->getRules($short);
        }

        return $rules;
    }

    public function getRules($short)
    {
        $rules = [];
        switch ($short) {
            case 'mailgun':
                $rules = [
                    'domain' => 'required',
                    'secret' => 'required',
                ];

                return $rules;
            case 'mandrill':
                $rules = [
                   'secret' => 'required',
                ];

                return $rules;
            default:
                return $rules;
        }
    }
}
