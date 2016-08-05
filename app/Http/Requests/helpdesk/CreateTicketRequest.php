<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;
use App\Model\helpdesk\Settings\CommonSettings;

/**
 * CreateTicketRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class CreateTicketRequest extends Request
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
        $check = $this->check(new CommonSettings);
        if ($check != 0) {
            return $check;
        }

        return [

            'email'     => 'required|email|max:60',
            'first_name'  => 'required|min:3|max:40',
            'helptopic' => 'required',
            // 'dept' => 'required',
            'sla'      => 'required',
            'subject'  => 'required|min:5',
            'body'     => 'required|min:10',
            'priority' => 'required',
        ];
    }

    /**
     *@category Funcion to set rule if send opt is enabled
     *@param Object $settings (instance of Model common settings)
     *@author manish.verma@ladybirdweb.com
     *@return array|int 
     */
    public function check($settings)
    {
        $settings = $settings->select('status')->where('option_name', '=', 'send_otp')->first();
        if ($settings->status == '1' || $settings->status == 1) {
            return [

                'email'     => 'required|email|max:60',
                'first_name'  => 'required|min:3|max:40',
                'helptopic' => 'required',
                // 'dept' => 'required',
                'sla'      => 'required',
                'subject'  => 'required|min:5',
                'body'     => 'required|min:10',
                'priority' => 'required',
                'code'     => 'required',
                'mobile'   => 'required',
            ];
        } else {
            return 0;
        }
    }

}
