<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * AgentRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class TicketEditRequest extends Request
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
            // 'subject' => 'required',
            // 'sla_paln' => 'required',
            // 'help_topic' => 'required',
            // 'ticket_source' => 'required',
            // 'ticket_priority' => 'required',
        ];
    }
}
