<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Model\Category;

/* include the model */

class CategoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Category $category) {
		/* Get the all attributes in the category model */
		$categorys = $category->get();
		/*  get the view of index of the catogorys with all attributes
		of category model  */
		return view('themes.default1.category.index', compact('categorys'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Category $category) {
		/* Get the all attributes in the category model */
		$category = $category->get();
		/* get the view page to create new category with all attributes
		of category model*/
		return view('themes.default1.category.create', compact('category'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Category $category, ArticleRequest $request) {
		/* Get the whole request from the form and insert into table via model */
		if ($category->fill($request->input())->save()) //True: send success message to index page
		{
			return redirect('kb/category')->with('success', 'Category Inserted Successfully');
		} else //send fail to index page
		{
			return redirect('kb/category')->with('fails', 'Category Not Inserted');
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
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Category $category) {
		/* get the atributes of the category model whose id == $id */
		$category = $category->whereId($id)->first();
		/* get the Edit page the selected category via id */
		return view('themes.default1.category.edit', compact('category'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Category $category, ArticleRequest $request) {
		/* Edit the selected category via id */
		$category = $category->whereId($id)->first();
		/* update the values at the table via model according with the request */
		if ($category->fill($request->input())->save()) //True: redirct to index page with success message
		{
			return redirect('kb/category')->with('success', 'Category Updated Successfully');
		} else //redirect to index with fails message
		{
			return redirect('kb/category')->with('fails', 'Category Not Updated');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Category $category) {
		/*  delete the category selected, id == $id */
		$category = $category->whereId($id)->first();
		if ($category->delete()) //True: redirect to index with success message
		{
			return redirect('kb/category')->with('success', 'Category Deleted Successfully');
		} else //redirect to index page fails message
		{
			return redirect('kb/category')->with('fails', 'Category Not Deleted');
		}
	}

}
