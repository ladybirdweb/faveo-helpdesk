<?php namespace App\Http\Controllers\Agent\kb;

use App\Http\Controllers\Agent\kb\ArticleController;
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Controllers\Controller;
use App\Http\Requests\kb\FooterRequest;
use App\Http\Requests\kb\ProfilePassword;
use App\Http\Requests\kb\ProfileRequest;
use App\Http\Requests\kb\SettingsRequests;
use App\Http\Requests\kb\SocialRequest;
use App\Model\kb\Comment;
use App\Model\kb\DateFormat;
use App\Model\kb\Faq;
use App\Model\kb\Settings;
use App\Model\kb\Side1;
use App\Model\kb\Side2;
use App\Model\kb\Social;
use App\Model\helpdesk\Utility\Timezones;
use Auth;
use Config;
use Datatable;
use Hash;
use Illuminate\Http\Request;
use Image;
use Input;

class SettingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
		$this->language();
	}

	/**
	 * to get the settings page
	 * @return response
	 * @package default
	 */
	public function settings(Settings $settings, Timezones $time, DateFormat $date) {

		/* get the setting where the id == 1 */
		$settings = $settings->whereId('1')->first();
		$time = $time->get();
		//$date = $date->get();
		return view('themes.default1.agent.kb.settings.settings', compact('date', 'settings', 'time'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postSettings($id, Settings $settings, SettingsRequests $request) {
		try
		{
			/* fetch the values of company request  */
			$settings = $settings->whereId('1')->first();

			if (Input::file('logo')) {
				$name = Input::file('logo')->getClientOriginalName();

				$destinationPath = 'lb-faveo/dist/image';
				$fileName = rand(0000, 9999) . '.' . $name;
				//echo $fileName;

				Input::file('logo')->move($destinationPath, $fileName);

				$settings->logo = $fileName;
				//$thDestinationPath = 'dist/th';

				Image::make($destinationPath . '/' . $fileName, array(
					'width' => 300,
					'height' => 300,
					'grayscale' => false,
				))->save('lb-faveo/dist/image/' . $fileName);
			}
			if (Input::file('background')) {
				$name = Input::file('background')->getClientOriginalName();

				$destinationPath = 'lb-faveo/dist/image';
				$fileName = rand(0000, 9999) . '.' . $name;
				echo $fileName;

				Input::file('background')->move($destinationPath, $fileName);

				$settings->background = $fileName;
				//$thDestinationPath = 'dist/th';

				Image::make($destinationPath . '/' . $fileName, array(
					'width' => 300,
					'height' => 300,
					'grayscale' => false,
				))->save('lb-faveo/dist/image/' . $fileName);
			}

			/* Check whether function success or not */

			if ($settings->fill($request->except('logo', 'background'))->save() == true) {
				/* redirect to Index page with Success Message */

				return redirect('settings')->with('success', 'Settings Updated Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('settings')->with('fails', 'Settings can not Updated');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('settings')->with('fails', 'Settings can not Updated');
		}

	}

/**
 * to get the faq view page
 * @return response
 */
	public function Faq(Faq $faq) {
		/* fetch the values of faq  */
		$faq = $faq->whereId('1')->first();
		return view('themes.default1.agent.settings.faq', compact('faq'));

	}
	public function postfaq($id, Faq $faq, Request $request) {
		$faq = $faq->whereId('1')->first();
		if ($faq->fill($request->input())->save()) {
			return redirect('create-faq')->with('success', 'Faq updated Successfully');
		} else {
			return redirect('craete-faq')->with('fails', 'Faq not updated');
		}
	}

	/**
	 *  get the create page to insert the values to database
	 * @return type response
	 */
	public function CreateSocialLink(Social $social) {
		$social = $social->whereId('1')->first();
		return view('themes.default1.agent.kb.settings.social', compact('social'));
	}

	/**
	 *
	 * @param type Social $social
	 * @param type Request $request
	 * @return type resonse
	 */
	public function PostSocial(Social $social, SocialRequest $request) {
		$social = $social->whereId('1')->first();
		if ($social->fill($request->input())->save()) {
			return redirect('social')->with('success', 'Your Social Links Stored');
		} else {
			return redirect('social')->with('fails', 'Sorry Can not Performe');
		}
	}

	/**
	 * To Moderate the commenting
	 * @param type Comment $comment
	 * @return Response
	 */
	public function comment(Comment $comment) {
		return view('themes.default1.agent.kb.settings.comment');
	}

	/**
	 * getdata
	 * @return type 
	 */
	public function getData() {
		return \Datatable::collection(Comment::All())
			->searchColumns('name', 'email', 'comment', 'created')
			->orderColumns('name')
			->addColumn('name', function ($model) {
				return $model->name;
			})
			->addColumn('email', function ($model) {
				return $model->email;
			})
			->addColumn('website', function ($model) {
				return $model->website;
			})
			->addColumn('comment', function ($model) {
				return $model->comment;
			})
			->addColumn('status', function ($model) {
				$status = $model->status;
				if ($status == 1) {
					return '<p style="color:blue"">'.\Lang::get('lang.published');
				} else {
					return '<p style="color:red"">'.\Lang::get('lang.not_published');
				}
			})
			->addColumn('Created', function ($model) {
				return TicketController::usertimezone(date($model->created_at));
			})
			->addColumn('Actions', function ($model) {
				return '<a href=comment/delete/' . $model->id . ' class="btn btn-danger btn-xs">'.\Lang::get('lang.delete').'</a>&nbsp;<a href=published/' . $model->id . ' class="btn btn-warning btn-xs">'.\Lang::get('lang.publish').'</a>';
			})
			->make();
	}

	/**
	 * Admin can publish the comment
	 * @param type $id
	 * @param type Comment $comment
	 * @return bool
	 */
	public function publish($id, Comment $comment) {
		$comment = $comment->whereId($id)->first();
		$comment->status = 1;
		if ($comment->save()) {
			return redirect('comment')->with('success', $comment->name . '-' . 'Comment Published');
		} else {
			return redirect('comment')->with('fails', 'Can not Process');
		}
	}

	/**
	 * delete the comment
	 * @param type $id
	 * @param type Comment $comment
	 * @return type
	 */
	public function delete($id, Comment $comment) {
		$comment = $comment->whereId($id)->first();
		if ($comment->delete()) {
			return redirect('comment')->with('success', $comment->name . "'s!" . 'Comment Deleted');
		} else {
			return redirect('comment')->with('fails', 'Can not Process');
		}
	}

	public function getProfile() {
		$time = Timezone::all();
		$user = Auth::user();
		return view('themes.default1.agent.kb.settings.profile', compact('user', 'time'));
	}

	public function postProfile(ProfileRequest $request) {
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
			$fileName = rand(0000, 9999) . '.' . $name;
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
	public function postProfilePassword($id, ProfilePassword $request) {
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
	 * To delete the logo
	 * @param type $id
	 * @param type Settings $setting
	 * @return type
	 */
	public function deleteLogo($id, Settings $setting) {
		$setting = $setting->whereId($id)->first();
		$setting->logo = '';
		$setting->save();
		return redirect('settings')->with('success', 'Settings Updated Successfully');

	}

	public function deleteBackground($id, Settings $setting) {
		$setting = $setting->whereId($id)->first();
		$setting->background = '';
		$setting->save();
		return redirect('settings')->with('success', 'Settings Updated Successfully');

	}

	/**
	 * Get the View of create Side widget page
	 * @param type Side1 $side
	 * @return View
	 */
	public function side1(Side1 $side) {
		$side = $side->where('id', '1')->first();
		return view('themes.default1.agent.kb.settings.side1', compact('side'));
	}

	/**
	 * Post function of Side1 Page
	 * @param type $id
	 * @param type Side1 $side
	 * @param type Request $request
	 * @return view
	 */
	public function postside1($id, Side1 $side, Request $request) {
		$side = $side->whereId($id)->first();
		if ($side->fill($request->input())->save()) {
			return redirect('side1')->with('success', 'Side Widget 1 Created !');
		} else {
			return redirect('side1')->with('fails', 'Whoops ! Something went Wrong ! ');
		}
	}

	/**
	 * Get the View for side widget creat
	 * @param type Side2 $side
	 * @return type
	 */
	public function side2(Side2 $side) {
		$side = $side->where('id', '1')->first();
		return view('themes.default1.agent.kb.settings.side2', compact('side'));
	}

	/**
	 * Post functio for side
	 * @param type $id
	 * @param type Side2 $side
	 * @param type Request $request
	 * @return response
	 */
	public function postside2($id, Side2 $side, Request $request) {
		$side = $side->whereId($id)->first();
		if ($side->fill($request->input())->save()) {
			return redirect('side2')->with('success', 'Side Widget 2 Created !');
		} else {
			return redirect('side2')->with('fails', 'Whoops ! Something went Wrong ! ');
		}
	}

	static function language() {
		// $set = Settings::whereId(1)->first();
		// $lang = $set->language;
		Config::set('app.locale', 'en');
		Config::get('app');
	}

}
