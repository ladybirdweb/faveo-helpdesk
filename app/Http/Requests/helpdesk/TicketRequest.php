<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * TicketRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class TicketRequest extends Request
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
        $panel = 'agent';
        $rules = $this->check($panel);

        return $rules;
    }

    public function messages()
    {
        $panel = 'agent';
        $message = \App\Model\Custom\Required::
                where('form', 'ticket')
                ->select("$panel as panel", 'field', 'label')
                ->where(function ($query) use ($panel) {
                    return $query->whereNotNull($panel)
                            ->where($panel, '!=', '');
                })
                ->get()
                ->transform(function ($value) {
                    $panel = $value->panel;
                    if (str_contains($panel, ':')) {
                        $explode = explode(':', $panel);
                        $panel = $explode[0];
                    }
                    $request["$value->field.$panel"] = "$value->label is required";

                    return $request;
                })
                ->collapse()
                ->toArray();

        return $message;
    }

    public function check($panel)
    {
        $required = \App\Model\Custom\Required::
                where('form', 'ticket')
                ->select("$panel as panel", 'field', 'option')
                ->where(function ($query) use ($panel) {
                    return $query->whereNotNull($panel)
                            ->where($panel, '!=', '');
                })
                ->get()
                ->transform(function ($value) {
                    $option = $value->option;
                    if ($option) {
                        $option = ','.$value->option;
                    }
                    $request[$value->field] = $value->panel.$option;

                    return $request;
                })
                ->collapse()
                ->toArray();
        //dd($required);
        return $required;
    }
}
