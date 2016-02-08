<?php namespace App\Http\Controllers\Client\kb;

use App\Http\Controllers\Controller;
use App\Http\Requests\kb\CommentRequest;
use App\Http\Requests\kb\ContactRequest;
use App\Http\Requests\kb\SearchRequest;
use App\Http\Requests\kb\ProfilePassword;
use App\Model\kb\Article;
use App\Model\kb\Category;
use App\Model\kb\Comment;
use App\Model\kb\Contact;
use App\Model\kb\Faq;	
use App\Model\kb\Page;
use App\Model\kb\Relationship;
use App\Model\kb\Settings;
use Config;
// use Creativeorange\Gravatar\Gravatar;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Redirect;
use Hash;
use Exception;

class UserController extends Controller {

	public function __construct() {
		//$this->middleware('auth');
		//SettingsController::language();
		// $this->port();
		// $this->host();
		// $this->password();
		// $this->encryption();
		// $this->email();
	}

	/**
 	* @param
 	* @return response
 	* @package default
 	*/
	public function getArticle(Article $article, Category $category, Settings $settings) {
		$settings = $settings->first();
		$pagination = $settings->pagination;
		// $article = $article->where('status', '1');
		// $article = $article->where('type', '1');
		$article = $article->paginate($pagination);
        // dd($article);
		$article->setPath('article-list');
		$categorys = $category->get();
		// $time = $this->timezone($utc);
		return view('themes.default1.client.kb.article-list.articles', compact('time', 'categorys', 'article'));
	}

	/**
	 * Get excerpt from string
	 *
	 * @param String $str String to get an excerpt from
	 * @param Integer $startPos Position int string to start excerpt from
	 * @param Integer $maxLength Maximum length the excerpt may be
	 * @return String excerpt
	 */
	static function getExcerpt($str, $startPos = 0, $maxLength = 50) {
		if (strlen($str) > $maxLength) {
			$excerpt = substr($str, $startPos, $maxLength - 3);
			$lastSpace = strrpos($excerpt, ' ');
			$excerpt = substr($excerpt, 0, $lastSpace);
			$excerpt .= '...';
		} else {
			$excerpt = $str;
		}

		return $excerpt;
	}

	public function search(SearchRequest $request, Category $category, Article $article, Settings $settings) {
		$settings = $settings->first();
		$pagination = $settings->pagination;
		$search = $request->input('s');
		$result = $article->search($search)->paginate($pagination);
		$result->setPath('search');
		//dd($result);
		$categorys = $category->get();
		return view('themes.default1.client.kb.article-list.search', compact('categorys', 'result'));
	}

	/**
	 * to show the seleted article
	 * @return response
	 */
	public function show($slug, Article $article, Category $category) {
		//ArticleController::timezone();
            $tz = \App\Model\helpdesk\Settings\System::where('id','1')->first()->time_zone;
            $tz = \App\Model\helpdesk\Utility\Timezones::where('id',$tz)->first()->name;
                                 date_default_timezone_set($tz);
                    $date  = \Carbon\Carbon::now()->toDateTimeString();
		$arti = $article->where('slug', $slug)->where('status','1')->where('type','1')->where('publish_time','<',$date)->first();
                if($arti){
                    return view('themes.default1.client.kb.article-list.show', compact('arti'));
                }
		else{
                    return redirect()->back()->with('fails','No records on publish time');
                }
		
	}

	public function getCategory($slug, Article $article, Category $category, Relationship $relation) {
		/* get the article_id where category_id == current category */
		$catid = $category->where('slug', $slug)->first();
		$id = $catid->id;
		$all = $relation->where('category_id', $id)->get();
		// $all->setPath('');
		/* from whole attribute pick the article_id */
		$article_id = $all->lists('article_id');
		$categorys = $category->get();
		/* direct to view with $article_id */
		return view('themes.default1.client.kb.article-list.category', compact('all','id', 'categorys', 'article_id'));
	}

	public function home(Article $article, Category $category, Relationship $relation) {
     	if (Config::get('database.install') == '%0%') {
       		return redirect('step1');
     	}
     	else
     	{
			//$categorys = $category->get();
			$categorys = $category->get();
			// $categorys->setPath('home');
			/* direct to view with $article_id */
			return view('themes.default1.client.kb.article-list.home', compact('categorys', 'article_id'));
	 	}
	}

	public function Faq(Faq $faq, Category $category) {
		$faq = $faq->where('id', '1')->first();
		$categorys = $category->get();
		return view('themes.default1.client.kb.article-list.faq', compact('categorys', 'faq'));
	}

	/**
	 * get the contact page for user
	 * @return response
	 */
	public function contact(Category $category, Settings $settings) {
		$settings = $settings->whereId('1')->first();
		$categorys = $category->get();
		return view('themes.default1.client.kb.article-list.contact', compact('settings', 'categorys'));
	}

	/**
	 * send message to the mail adderess that define in the system
	 * @return response
	 */
	public function postContact(ContactRequest $request, Contact $contact) {
		$this->port();
		$this->host();
		$this->encryption();
		$this->email();
		$this->password();
		//return Config::get('mail');
		$contact->fill($request->input())->save();
		$name = $request->input('name');
		//echo $name;
		$email = $request->input('email');
		//echo $email;
		$subject = $request->input('subject');
		//echo $subject;
		$details = $request->input('message');
		//echo $message;
		//echo $contact->email;
		$mail = Mail::send('themes.default1.client.kb.article-list.contact-details', array('name' => $name, 'email' => $email, 'subject' => $subject, 'details' => $details), function ($message) use ($contact) {
			$message->to($contact->email, $contact->name)->subject('Contact');
		});
		if ($mail) {
			return redirect('contact')->with('success', 'Your details send to System');
		} else {
			return redirect('contact')->with('fails', 'Your details can not send to System');
		}
	}

	public function contactDetails() {
		return view('themes.default1.client.kb.article-list.contact-details');
	}

	/**
	 * To insert the values to the comment table
	 * @param type Article $article
	 * @param type Request $request
	 * @param type Comment $comment
	 * @param type Id $id
	 * @return type response
	 */
	public function postComment($slug, Article $article, CommentRequest $request, Comment $comment) {
		$article = $article->where('slug',$slug)->first();
		$id = $article->id;
		$comment->article_id = $id;
		if ($comment->fill($request->input())->save()) {
			return Redirect::back()->with('success', 'Your comment posted');
		} else {
			return Redirect::back()->with('fails', 'Sorry not processed');
		}
	}

	public function getPage($name, Page $page) {
		$page = $page->where('slug', $name)->first();
		//$this->timezone($page->created_at);
		return view('themes.default1.client.kb.article-list.pages', compact('page'));
	}
	static function port() {
		$setting = Settings::whereId('1')->first();
		Config::set('mail.port', $setting->port);
	}
	static function host() {
		$setting = Settings::whereId('1')->first();
		Config::set('mail.host', $setting->host);
	}
	static function encryption() {
		$setting = Settings::whereId('1')->first();
		Config::set(['mail.encryption' => $setting->encryption, 'mail.username' => $setting->email]);
	}
	static function email() {
		$setting = Settings::whereId('1')->first();
		Config::set(['mail.from' => ['address' => $setting->email, 'name' => 'asd']]);
		//dd(Config::get('mail'));
	}
	static function password() {
		$setting = Settings::whereId('1')->first();
		Config::set(['mail.password' => $setting->password, 'mail.sendmail' => $setting->email]);
	}

	public function getCategoryList(Article $article, Category $category, Relationship $relation) {
		//$categorys = $category->get();
		$categorys = $category->get();
		// $categorys->setPath('home');
		/* direct to view with $article_id */
		return view('themes.default1.client.kb.article-list.categoryList', compact('categorys', 'article_id'));

	}

	// static function timezone($utc) {
	// 	$set = Settings::whereId('1')->first();
	// 	$tz = $set->timezone;
	// 	$format = $set->dateformat;
	// 	//$utc = date('M d Y h:i:s A');
	// 	//echo 'UTC : ' . $utc;
	// 	date_default_timezone_set($tz);

	// 	$offset = date('Z', strtotime($utc));
	// 	//print "offset: $offset \n";
	// 	$date = date($format, strtotime($utc) + $offset);
	// 	return $date;
	// 	//return substr($date, 0, -6);
	// }

    public function clientProfile() {
		$user = Auth::user();
		return view('themes.default1.client.kb.article-list.profile', compact('user'));
	}
    
    public function postClientProfile($id, ProfileRequest $request) {
		$user = Auth::user();
		$user->gender = $request->input('gender');
		$user->save();
		if ($user->profile_pic == 'avatar5.png' || $user->profile_pic == 'avatar2.png') {
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
			return redirect('guest')->with('success', 'Profile Updated sucessfully');
		}
		if ($user->fill($request->except('profile_pic'))->save()) {
			return redirect('guest')->with('success', 'Profile Updated sucessfully');
		}
	}
    
    public function postClientProfilePassword($id, ProfilePassword $request) {
		$user = Auth::user();
		//echo $user->password;
		if (Hash::check($request->input('old_password'), $user->getAuthPassword())) {
			$user->password = Hash::make($request->input('new_password'));
			$user->save();
			return redirect()->back()->with('success', 'Password Updated sucessfully');
		} else {
			return redirect()->back()->with('fails', 'Password was not Updated');
		}
	}

}
