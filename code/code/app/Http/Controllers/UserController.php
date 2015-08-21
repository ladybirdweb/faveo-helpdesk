<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\CommentRequest;
use App\Model\Article;
use App\Model\Category;
use App\Model\Contact;
use App\Model\Comment;
use App\Model\Faq;
use App\Model\Relationship;
use App\Model\Settings;
use Illuminate\Http\Request;
use Mail;
use App\Http\Controllers\SettingsController;



class UserController extends Controller {

	

	public function __construct() {
		SettingsController::smtp();
	}

	/**
	 * @param
	 * @return response
	 * @package default
	 */
	public function getArticle(Article $article, Category $category) {

		$article = $article->where('status', '1');
		$article = $article->where('type', '1');
		$article = $article->paginate(5);
		$article->setPath('article-list');
		$categorys = $category->get();

		return view('themes.default1.user.article-list.articles', compact('categorys', 'article'));
	}

/**
 * Get excerpt from string
 *
 * @param String $str String to get an excerpt from
 * @param Integer $startPos Position int string to start excerpt from
 * @param Integer $maxLength Maximum length the excerpt may be
 * @return String excerpt
 */
	static function getExcerpt($str, $startPos = 0, $maxLength = 10) {
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

	public function search(Request $request, Category $category, Article $article) {
		$search = $request->input('s');
		$result = $article->search($search)->paginate(5);
		$result->setPath('search');
		//dd($result);
		$categorys = $category->get();
		return view('themes.default1.user.article-list.search', compact('categorys', 'result'));
	}

/**
 * to show the seleted article
 * @return response
 */
	public function show($id, Article $article, Category $category) {

		$arti = $article->whereId($id)->first();
		$categorys = $category->get();
		return view('themes.default1.user.article-list.show', compact('arti', 'categorys'));

	}
	public function getCategory($id, Category $category, Relationship $relation) {
		/* get the article_id where category_id == current category */
		$all = $relation->where('category_id', $id)->paginate(4);
                $all->setPath('');
		/* from whole attribute pick the article_id */
		$article_id = $all->lists('article_id');

		$categorys = $category->where('id', $id)->get();

		/* direct to view with $article_id */
		return view('themes.default1.user.article-list.category', compact('all','categorys', 'article_id'));    
	}

	public function home(Category $category) {

		$categorys = $category->get();
                
		/* direct to view with $article_id */
		return view('themes.default1.user.article-list.home', compact('categorys', 'article_id'));

	}

	public function Faq(Faq $faq, Category $category) {
		$faq = $faq->where('id', '1')->first();
		$categorys = $category->get();
		return view('themes.default1.user.article-list.faq', compact('categorys', 'faq'));
	}

	/**
	 * get the contact page for user
	 * @return response
	 */
	public function contact(Category $category, Settings $settings) {
		$settings = $settings->whereId('1')->first();
		$categorys = $category->get();
		return view('themes.default1.user.article-list.contact', compact('settings', 'categorys'));
	}

	/**
	 * send message to the mail adderess that define in the system
	 * @return response
	 */
	public function postContact(ContactRequest $request, Contact $contact) {

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

		$mail = Mail::send('themes.default1.user.article-list.contact-details', array('name' => $name, 'email' => $email, 'subject' => $subject, 'details' => $details), function ($message) use ($contact) {
			$message->to($contact->email, $contact->name)->subject('Contact');
		});
		if ($mail) {
			return redirect('contact')->with('success', 'Your details send to System');
		} else {
			return redirect('contact')->with('fails', 'Your details can not send to System');
		}
	}
	public function contactDetails() {
		return view('themes.default1.user.article-list.contact-details');
	}
        public function postComment($id, CommentRequest $request, Comment $comment) {

		$comment->article_id = $id;
		if ($comment->fill($request->input())->save()) {
			return \Redirect::back()->with('success', 'Your comment has been posted');
		} else {
			return \Redirect::back()->with('fails', 'Sorry Error processing your comment');
		}
	}

}
