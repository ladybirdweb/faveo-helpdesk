<?php namespace App\Http\Controllers\Agent\kb;
use App\Http\Controllers\client\kb\UserController;
use App\Http\Controllers\admin\kb\ArticleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\kb\SettingsController;
use App\Http\Requests\kb\CategoryRequest;
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Model\kb\Category;
use App\Model\kb\Relationship;
use Datatable;
use Redirect;

/**
 * CategoryController
 *
 * @package Controllers
 * @subpackage Controller
 * @author     Ladybird <info@ladybirdweb.com>
 */

class CategoryController extends Controller {

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

	/**
	 * Indexing all Category
	 * @param type Category $category
	 * @return Response
	 */
	public function index() {

		/*  get the view of index of the catogorys with all attributes
		of category model  */
		return view('themes.default1.agent.kb.category.index');
	}
	public function getData() {

		//return 'kfjhje';

		return Datatable::collection(Category::All())
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
				//return '<a href=category/delete/' . $model->id . ' class="btn btn-danger btn-flat">Delete</a>&nbsp;<a href=category/' . $model->id . '/edit class="btn btn-warning btn-flat">Edit</a>&nbsp;<a href=article-list class="btn btn-warning btn-flat">View</a>';
				return '<span  data-toggle="modal" data-target="#banemail"><a href="#" ><button class="btn btn-danger btn-xs"></a>'. \Lang::get("lang.delete") .'</button></span>&nbsp;<a href=category/' . $model->slug . '/edit class="btn btn-warning btn-xs">'. \Lang::get("lang.edit") .'</a>&nbsp;<a href=article-list class="btn btn-primary btn-xs">'. \Lang::get("lang.view") .'</a>
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
                    <a href="category/delete/' . $model->id . '"><button class="btn btn-danger">delete</button></a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>';
			})
			->make();

	}

	/**
	 * Create a Category
	 * @param type Category $category
	 * @return Response
	 */
	public function create(Category $category) {
		/* Get the all attributes in the category model */
		$category = $category->get();
		/* get the view page to create new category with all attributes
		of category model*/
		return view('themes.default1.agent.kb.category.create', compact('category'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Category $category, CategoryRequest $request) {
		/* Get the whole request from the form and insert into table via model */

		$sl = $request->input('slug');
		$slug = str_slug($sl, "-");

		$category->slug = $slug;
		//$category->save();

		if ($category->fill($request->except('slug'))->save()) //True: send success message to index page
		{
			return Redirect::back()->with('success', 'Category Inserted Successfully');
		} else //send fail to index page
		{
			return Redirect::back()->with('fails', 'Category Not Inserted');
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
	public function edit($slug, Category $category) {

		$cid = $category->where('slug', $slug)->first();
		$id = $cid->id;
		/* get the atributes of the category model whose id == $id */
		$category = $category->whereId($id)->first();
		/* get the Edit page the selected category via id */
		return view('themes.default1.agent.kb.category.edit', compact('category'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($slug, Category $category, CategoryRequest $request) {
		
		/* Edit the selected category via id */
		$category = $category->where('slug', $slug)->first();
		$sl = $request->input('slug');
		$slug = str_slug($sl, "-");

		$category->slug = $slug;
		/* update the values at the table via model according with the request */
		if ($category->fill($request->except('slug'))->save()) //True: redirct to index page with success message
		{
			return redirect('category')->with('success', 'Category Updated Successfully');
		} else //redirect to index with fails message
		{
			return redirect('category')->with('fails', 'Category Not Updated');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Category $category, Relationship $relation) {
		$relation = $relation->where('category_id', $id)->delete();
		// $relation->delete();
		/*  delete the category selected, id == $id */
		$category = $category->whereId($id)->first();
		if ($category->delete()) //True: redirect to index with success message
		{
			return Redirect::back()->with('success', 'Category Deleted Successfully');
		} else //redirect to index page fails message
		{
			return Redirect::back()->with('fails', 'Category Not Deleted');
		}
	}

}
