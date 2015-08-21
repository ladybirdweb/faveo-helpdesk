<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Model\Article;
use App\Model\Category;
use App\Model\Relationship;
use DB;
/* include the article model to access the article table */

class ArticleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 * @param Object
	 */
	public function index(Article $article) {
		/* get the index of the whole article list */
		$articles = $article->get();
		/* show the index page with article list */
		return view('themes.default1.article.index', compact('articles'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Category $category) {
		/* get the attributes of the category */
		$category = $category->lists('id', 'name');
		/* get the create page  */
		return view('themes.default1.article.create', compact('category'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Article $article, ArticleRequest $request) {
		$article->fill($request->input())->save();

		$requests = $request->input('category_id');

		$id = $article->id;
               
		foreach ($requests as $req) {
			DB::insert('insert into article_relationship (category_id, article_id) values (?,?)', [$req, $id]);

		}
		/* insert the values to the article table  */
		if ($article->fill($request->input())->save()) //true: redirect to index page with success message
		{
			return redirect('kb/article')->with('success', 'Article Inserted Successfully');
		} else //redirect to index page with fail message
		{
			return redirect('kb/article')->with('fails', 'Article Not Inserted');
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id, object $article
	 * @return Response
	 */
	public function edit($id, Article $article, Relationship $relation, Category $category) {

		/* define the selected fields */
		$assign = $relation->where('article_id', $id)->lists('category_id');
		/* get the attributes of the category */
		$category = $category->lists('id', 'name');
		/* get the selected article and display it at edit page  */
		/* Get the selected article with id */
		$article = $article->whereId($id)->first();
		/* send to the edit page */
		return view('themes.default1.article.edit', compact('assign', 'article', 'category'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id, object $article, object $request
	 * @return Response
	 */
	public function update($id, Article $article, Relationship $relation,
		ArticleRequest $request) {

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
		if ($article->fill($request->input())->save()) //true: redirect to index page with success message
		{
			return redirect('kb/article')->with('success', 'Article Updated Successfully');
		} else // redirect to index page with fails message
		{
			return redirect('kb/article')->with('fails', 'Article Not Updated');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id, object $article
	 * @return Response
	 */
	public function destroy($id, Article $article) {
		/* delete the selected article from the table */
		$article = $article->whereId($id)->first(); //get the selected article via id
		if ($article->delete()) //true:redirect to index page with success message
		{
			return redirect('kb/article')->with('success', 'Article Deleted Successfully');
		} else //redirect to index page with fails message
		{
			return redirect('kb/article')->with('fails', 'Article Not Deleted');
		}
	}

}
