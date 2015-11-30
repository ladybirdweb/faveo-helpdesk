<?php namespace App\Http\Controllers\Agent\kb;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\kb\SettingsController;
use App\Http\Controllers\Client\kb\UserController;
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Requests\kb\ArticleRequest;
use App\Model\kb\Article;
use App\Model\kb\Category;
use App\Model\kb\Relationship;
use App\Model\kb\Settings;
use Auth;
use Chumper\Datatable\Table;
use Datatable;
use DB;
use Illuminate\Http\Request;
use App\Model\kb\Comment;

/* include the article model to access the article table */
use Redirect;
use Exception;

/**
 * ArticleController
 *
 * @package Controllers
 * @subpackage Controller
 * @author     Ladybird <info@ladybirdweb.com>
 */

class ArticleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
		SettingsController::language();
	}
	public function test() {
		//$table = $this->setDatatable();
		return view('themes.default1.agent.kb.article.test');

	}
	public function getData() {

		//return 'kfjhje';

		return Datatable::collection(Article::All())
			->searchColumns('name')
			->orderColumns('name', 'description')
			->addColumn('name', function ($model) {
				return $model->name;
			})
			->addColumn('Created', function ($model) {
				$t = $model->created_at;
				return TicketController::usertimezone($t);
			})
			->addColumn('Actions', function ($model) {
				//return '<a href=article/delete/ ' . $model->id . ' class="btn btn-danger btn-flat" onclick="myFunction()">Delete</a>&nbsp;<a href=article/' . $model->id . '/edit class="btn btn-warning btn-flat">Edit</a>&nbsp;<a href=show/' . $model->id . ' class="btn btn-warning btn-flat">View</a>';
				//return '<form action="article/delete/ ' . $model->id . '" method="post" onclick="alert()"><button type="sumbit" value="Delete"></button></form><a href=article/' . $model->id . '/edit class="btn btn-warning btn-flat">Edit</a>&nbsp;<a href=show/' . $model->id . ' class="btn btn-warning btn-flat">View</a>';
				return '<span  data-toggle="modal" data-target="#banemail"><a href="#" ><button class="btn btn-danger btn-xs"></a> ' . \Lang::get('lang.delete') . ' </button></span>&nbsp;<a href=article/' . $model->slug . '/edit class="btn btn-warning btn-xs">' . \Lang::get('lang.edit') . '</a>&nbsp;<a href=show/'.$model->slug .' class="btn btn-primary btn-xs">' . \Lang::get('lang.view') . '</a>
				<div class="modal fade" id="banemail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Are You Sure ?</h4>
                </div>
                <div class="modal-body">
                '.$model->name.'
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
                    <a href="article/delete/'.$model->slug.'"><button class="btn btn-danger">delete</button></a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>';
			})
			->make();
	}

	/**
	 * Index for Articles
	 * @param type Article $article
	 * @return type Response
	 */
	public function index() {
		/* show the index page with article list */
		return view('themes.default1.agent.kb.article.index');
	}

	/**
	 * Creating a Article
	 * @param type Category $category
	 * @return type Response
	 */
	public function create(Category $category) {
		//$cat = $category->whereId(33)->first();
		//$tm = $cat->created_at;
		//$this->usertimezone($tm);
		// // /* get the attributes of the category */
		$category = $category->lists('id', 'name');
		/* get the create page  */
		return view('themes.default1.agent.kb.article.create', compact('category'));
	}

	/**
	 * Insert the values to the article table
	 * @param type Article $article
	 * @param type ArticleRequest $request
	 * @return type
	 */
	public function store(Article $article, ArticleRequest $request) {

			$sl = $request->input('slug');
			$slug = str_slug($sl, "-");
			$article->slug = $slug;
		$article->fill($request->except('created_at','slug'))->save();
		$requests = $request->input('category_id');
		$id = $article->id;
		foreach ($requests as $req) {
			DB::insert('insert into article_relationship (category_id, article_id) values (?,?)', [$req, $id]);
		}
		/* insert the values to the article table  */
		if ($article->fill($request->except('slug'))->save()) //true: redirect to index page with success message
		{
			return redirect('article')->with('success', 'Article Inserted Successfully');
		} else //redirect to index page with fail message
		{
			return redirect('article')->with('fails', 'Article Not Inserted');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Edit an Article by id
	 * @param type Integer $id
	 * @param type Article $article
	 * @param type Relationship $relation
	 * @param type Category $category
	 * @return Response
	 */
	public function edit($slug, Article $article, Relationship $relation, Category $category) {

		$aid = $article->where('slug', $slug)->first();
		$id = $aid->id;

		/* define the selected fields */
		$assign = $relation->where('article_id', $id)->lists('category_id');
		/* get the attributes of the category */
		$category = $category->lists('id', 'name');
		/* get the selected article and display it at edit page  */
		/* Get the selected article with id */
		$article = $article->whereId($id)->first();
		/* send to the edit page */
		return view('themes.default1.agent.kb.article.edit', compact('assign', 'article', 'category'));
	}

	/**
	 * Update an Artile by id
	 * @param type Integer $id
	 * @param type Article $article
	 * @param type Relationship $relation
	 * @param type ArticleRequest $request
	 * @return Response
	 */
	public function update($slug, Article $article, Relationship $relation,
		ArticleRequest $request) {
		$aid = $article->where('slug', $slug)->first();
		$id = $aid->id;
		$sl = $request->input('slug');
			$slug = str_slug($sl, "-");
			$article->slug = $slug;
		/* get the attribute of relation table where id==$id */
		$relation = $relation->where('article_id', $id);
		$relation->delete();
		/* get the request of the current articles */
		$article = $article->whereId($id)->first();
		$requests = $request->input('category_id');
		$id = $article->id;
		foreach ($requests as $req) {
			DB::insert('insert into article_relationship (category_id, article_id) values (?,?)', [$req, $id]);
		}
		/* update the value to the table */
		if ($article->fill($request->except('slug'))->save()) //true: redirect to index page with success message
		{
			return redirect('article')->with('success', 'Article Updated Successfully');
		} else // redirect to index page with fails message
		{
			return redirect('article')->with('fails', 'Article Not Updated');
		}
	}

	/**
	 * Delete an Agent by id
	 * @param type $id
	 * @param type Article $article
	 * @return Response
	 */
	public function destroy($slug, Article $article, Relationship $relation, Comment $comment) {
    	
    	/* delete the selected article from the table */
		$article = $article->where('slug',$slug)->first(); //get the selected article via id
		//dd($article);
		$id = $article->id;
        $comments = $comment->where('article_id',$id)->get();

        if($comments)
        {
        	foreach($comments as $comment)
        	$comment->delete();
        }
		
		$relation = $relation->where('article_id', $id)->first();
		if($relation)
		{
			$relation->delete();
		}
		if($article)
		{
			if ($article->delete()) //true:redirect to index page with success message
			{
				return Redirect::back()->with('success', 'Article Deleted Successfully');
			} else //redirect to index page with fails message
			{
				return Redirect::back()->with('fails', 'Article Not Deleted');
			}

		} 
		else
		{
		
			return Redirect::back()->with('fails', 'Article can Not Deleted');
			
		}
		
	}

	static function usertimezone($utc) {
		$user = Auth::user();
		$tz = $user->timezone;
		$set = Settings::whereId('1')->first();
		$format = $set->dateformat;
		//$utc = date('M d Y h:i:s A');
		//echo 'UTC : ' . $utc;
		date_default_timezone_set($tz);

		$offset = date('Z', strtotime($utc));
		//print "offset: $offset \n";
		$date = date($format, strtotime($utc) + $offset);
		echo $date;
		//return substr($date, 0, -6);

	}

}
