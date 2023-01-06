<?php

namespace App\Http\Controllers\Admin\helpdesk\SocialMedia;

use App\Http\Controllers\Controller;
use App\Model\helpdesk\Settings\SocialMedia;
use Exception;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles'], ['except' => ['configService']]);
    }

    public function settings($provider)
    {
        try {
            $social = new SocialMedia();

            return view('themes.default1.admin.helpdesk.settings.social-media.settings', compact('social', 'provider'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postSettings($provider, Request $request)
    {
        $this->validate($request, [
            'client_id'     => 'required',
            'client_secret' => 'required',
            'redirect'      => 'required|url',
        ]);

        try {
            $requests = $request->except('_token');
            $this->insertProvider($provider, $requests);

            return redirect()->back()->with('success', 'Updated');
        } catch (Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function deleteProvider($provider, $requests)
    {
        $social = new SocialMedia();
        $socials = $social->where('provider', $provider)->get();
        if ($socials->count() > 0) {
            foreach ($socials as $media) {
                if (array_key_exists($media->key, $requests)) {
                    $media->delete();
                }
            }
        }
    }

    public function insertProvider($provider, $requests = [])
    {
        $this->deleteProvider($provider, $requests);
        $social = new SocialMedia();
        foreach ($requests as $key => $value) {
            $social->create([
                'provider' => $provider,
                'key'      => $key,
                'value'    => $value,
            ]);
        }
    }

    public function index()
    {
        try {
            $social = new SocialMedia();

            return view('themes.default1.admin.helpdesk.settings.social-media.index', compact('social'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function configService()
    {
        $social = new SocialMedia();
        $services = $this->services();
        foreach ($services as $service) {
            \Config::set("services.$service.client_id", $social->getvalueByKey($service, 'client_id'));
            \Config::set("services.$service.client_secret", $social->getvalueByKey($service, 'client_secret'));
            \Config::set("services.$service.redirect", $social->getvalueByKey($service, 'redirect'));
        }
        // dd(\Config::get('services'));
    }

    public function services()
    {
        return [
            'facebook',
            'google',
            'github',
            'twitter',
            'linkedin',
            'bitbucket',
        ];
    }
}
