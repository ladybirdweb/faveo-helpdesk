<?php

namespace App\Http\Requests\kb;

use App\Http\Requests\Request;

class SocialRequest extends Request
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
            'linkedin'   => 'url',
            'stumble'    => 'url',
            'google'     => 'url',
            'deviantart' => 'url',
            'flickr'     => 'url',
            'skype'      => 'url',
            'rss'        => 'url',
            'twitter'    => 'url',
            'facebook'   => 'url',
            'youtube'    => 'url',
            'vimeo'      => 'url',
            'pinterest'  => 'url',
            'dribbble'   => 'url',
            'instagram'  => 'url',
        ];
    }
}
