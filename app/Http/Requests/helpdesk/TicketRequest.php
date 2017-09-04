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
        $error = '';

        try {
            $size = $this->size();
            if ($size > 800 || $size == 0) {
                throw new \Exception('File size exceeded', 422);
            }
        } catch (\Exception $ex) {
            dd($ex);
            $error = $this->error($ex);
        }
//        return [
//            'attachment' => 'not_in:'.$error,
//        ];
    }

    public function size()
    {
        $files = $this->file('attachment');
        if (!$files) {
            throw new \Exception('exceeded', 422);
        }
        $size = 0;
        if (count($files) > 0) {
            foreach ($files as $file) {
                $size += $file->getSize();
            }
        }

        return $size;
    }

    public function error($e)
    {
        if ($this->ajax() || $this->wantsJson()) {
            $message = $e->getMessage();
            if (is_object($message)) {
                $message = $message->toArray();
            }

            return $message;
        }
    }
}
