<?php

namespace App\Http\Controllers\Agent\kb;

// Controllers
use App\Http\Controllers\Controller;
// Request
use App\Http\Requests\kb\ProfilePassword;
use App\Http\Requests\kb\ProfileRequest;
use App\Http\Requests\kb\SettingsRequests;
use App\Model\helpdesk\Utility\Date_format;
// Model
use App\Model\helpdesk\Utility\Timezones;
use App\Model\kb\Comment;
use App\Model\kb\Settings;
use Auth;
// Classes
use Config;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Image;
use Input;
use Lang;

/**
 * SettingsController
 * This controller is used to perform settings in the setting page of knowledgebase.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     * constructor to check
     * 1. authentication
     * 2. user roles
     * 3. roles must be agent.
     *
     * @return void
     */
    public function __construct()
    {
        // checking authentication
        $this->middleware('auth');
        // checking roles
        $this->middleware('roles');
        $this->language();
    }

    /**
     * to get the settings page.
     *
     * @return response
     */
    public function settings(Settings $settings, Timezones $time, Date_format $date)
    {
        /* get the setting where the id == 1 */
        $settings = $settings->whereId('1')->first();
        $time = $time->get();
        //$date = $date->get();
        return view('themes.default1.agent.kb.settings.settings', compact('date', 'settings', 'time'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function postSettings($id, Settings $settings, SettingsRequests $request)
    {
        try {
            /* fetch the values of company request  */
            $settings = $settings->whereId('1')->first();
            if (Input::file('logo')) {
                $name = Input::file('logo')->getClientOriginalName();
                $destinationPath = 'lb-faveo/dist/image';
                $fileName = rand(0000, 9999).'.'.$name;
                //echo $fileName;
                Input::file('logo')->move($destinationPath, $fileName);
                $settings->logo = $fileName;
                //$thDestinationPath = 'dist/th';
                Image::make($destinationPath.'/'.$fileName, [
                    'width'     => 300,
                    'height'    => 300,
                    'grayscale' => false,
                ])->save('lb-faveo/dist/image/'.$fileName);
            }
            if (Input::file('background')) {
                $name = Input::file('background')->getClientOriginalName();
                $destinationPath = 'lb-faveo/dist/image';
                $fileName = rand(0000, 9999).'.'.$name;
                echo $fileName;
                Input::file('background')->move($destinationPath, $fileName);
                $settings->background = $fileName;
                //$thDestinationPath = 'dist/th';
                Image::make($destinationPath.'/'.$fileName, [
                    'width'     => 300,
                    'height'    => 300,
                    'grayscale' => false,
                ])->save('lb-faveo/dist/image/'.$fileName);
            }
            /* Check whether function success or not */
            if ($settings->fill($request->except('logo', 'background'))->save() == true) {
                /* redirect to Index page with Success Message */
                return redirect()->back()->with('success', Lang::get('lang.settings_updated_successfully'));
            } else {
                /* redirect to Index page with Fails Message */
                return redirect()->back()->with('fails', Lang::get('lang.settings_can_not_updated'));
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect()->back()->with('fails', Lang::get('lang.settings_can_not_updated'));
        }
    }

    /**
     * To Moderate the commenting.
     *
     * @param type Comment $comment
     *
     * @return Response
     */
    public function comment(Comment $comment)
    {
        return view('themes.default1.agent.kb.settings.comment');
    }

    /**
     * getdata.
     *
     * @return type
     */
    public function getData()
    {
        return \Datatable::collection(Comment::All())
                        ->searchColumns('details', 'comment', 'created')
                        ->orderColumns('details')
                        ->addColumn('details', function ($model) {
                            $name = "<p>$model->name</p><br>";
                            $email = "<p>$model->email</p><br>";
                            $website = "<p>$model->website</p><br>";

                            return $name.$email.$website;
                        })

                        ->addColumn('comment', function ($model) {
                            $created = faveoDate($model->created_at);

                            return $model->comment."<p>$created</p>";
                        })
                        ->addColumn('status', function ($model) {
                            $status = $model->status;
                            if ($status == 1) {
                                return '<p style="color:blue"">'.\Lang::get('lang.published');
                            } else {
                                return '<p style="color:red"">'.\Lang::get('lang.not_published');
                            }
                        })

                        ->addColumn('Actions', function ($model) {
                            return '<div class="row"><div class="col-md-12"><a href=comment/delete/'.$model->id.' class="btn btn-danger btn-xs">'.\Lang::get('lang.delete').'</a></div><div class="col-md-12"><a href=published/'.$model->id.' class="btn btn-warning btn-xs">'.\Lang::get('lang.publish').'</a></div></div>';
                        })
                        ->make();
    }

    /**
     * Admin can publish the comment.
     *
     * @param type         $id
     * @param type Comment $comment
     *
     * @return bool
     */
    public function publish($id, Comment $comment)
    {
        $comment = $comment->whereId($id)->first();
        $comment->status = 1;
        if ($comment->save()) {
            return redirect('comment')->with('success', $comment->name.'-'.Lang::get('lang.comment_published'));
        } else {
            return redirect('comment')->with('fails', Lang::get('lang.can_not_process'));
        }
    }

    /**
     * delete the comment.
     *
     * @param type         $id
     * @param type Comment $comment
     *
     * @return type
     */
    public function delete($id, Comment $comment)
    {
        $comment = $comment->whereId($id)->first();
        if ($comment->delete()) {
            return redirect('comment')->with('success', $comment->name."'s!".Lang::get('lang.comment_deleted'));
        } else {
            return redirect('comment')->with('fails', Lang::get('lang.can_not_process'));
        }
    }

    /**
     * get profile page.
     *
     * @return type view
     */
    public function getProfile()
    {
        $time = Timezone::all();
        $user = Auth::user();

        return view('themes.default1.agent.kb.settings.profile', compact('user', 'time'));
    }

    /**
     * Post profile page.
     *
     * @param type ProfileRequest $request
     *
     * @return type redirect
     */
    public function postProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->gender = $request->input('gender');
        $user->save();
        if (is_null($user->profile_pic)) {
            if ($request->input('gender') == 1) {
                $name = 'avatar5.png';
                $destinationPath = 'lb-faveo/dist/img';
                $user->profile_pic = $name;
            } elseif ($request->input('gender') == 0) {
                $name = 'avatar2.png';
                $destinationPath = 'lb-faveo/dist/img';
                $user->profile_pic = $name;
            }
        }
        if (Input::file('profile_pic')) {
            //$extension = Input::file('profile_pic')->getClientOriginalExtension();
            $name = Input::file('profile_pic')->getClientOriginalName();
            $destinationPath = 'lb-faveo/dist/img';
            $fileName = rand(0000, 9999).'.'.$name;
            //echo $fileName;
            Input::file('profile_pic')->move($destinationPath, $fileName);
            $user->profile_pic = $fileName;
        } else {
            $user->fill($request->except('profile_pic', 'gender'))->save();

            return redirect()->back()->with('success1', 'Profile Updated sucessfully');
        }
        if ($user->fill($request->except('profile_pic'))->save()) {
            return redirect('profile')->with('success1', 'Profile Updated sucessfully');
        } else {
            return redirect('profile')->with('fails1', 'Profile Not Updated sucessfully');
        }
    }

    /**
     * post profile password.
     *
     * @param type                 $id
     * @param type ProfilePassword $request
     *
     * @return type redirect
     */
    public function postProfilePassword($id, ProfilePassword $request)
    {
        $user = Auth::user();
        //echo $user->password;

        if (Hash::check($request->input('old_password'), $user->getAuthPassword())) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return redirect('profile')->with('success2', 'Password Updated sucessfully');
        } else {
            return redirect('profile')->with('fails2', 'Old password Wrong');
        }
    }

    /**
     * het locale for language.
     *
     * @return type config set
     */
    public static function language()
    {
        // $set = Settings::whereId(1)->first();
        // $lang = $set->language;
        Config::set('app.locale', 'en');
        Config::get('app');
    }
}
