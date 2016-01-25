<?php namespace App\Http\Controllers\Agent\kb;

// Controllers
use App\Http\Controllers\client\kb\UserController;
use App\Http\Controllers\admin\kb\ArticleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\kb\SettingsController;
use App\Http\Controllers\Agent\helpdesk\TicketController;

// Requests
use App\Http\Requests\kb\CategoryRequest;
use App\Http\Requests\kb\CategoryUpdate;

// Model
use App\Model\kb\Category;
use App\Model\kb\Relationship;

// Classes
use Datatable;
use Redirect;
use Exception;

/**
 * CategoryController
 * This controller is used to CRUD category 
 *
 * @package 	Controllers
 * @subpackage 	Controller
 * @author     	Ladybird <info@ladybirdweb.com>
 */
class CategoryController extends Controller {

	/**
	 * Create a new controller instance.
	 * constructor to check
	 * 1. authentication
	 * 2. user roles
	 * 3. roles must be agent
	 * @return void
	 */
	public function __construct() {
		// checking authentication
		$this->middleware('auth');
		// checking roles
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
		try{
			return view('themes.default1.agent.kb.category.index');	
		} catch (Exception $e) {
			return redirect()->back()->with('fails', $e->errorInfo[2]);
		}
	}

	/**
	 * fetching category list in chumper datatables
	 * @return type chumper datatable
	 */
	public function getData() {
		/* fetching chumper datatables */
		return Datatable::collection(Category::All())
			/* search column name */
			->searchColumns('name')
			/* order column name and description */
			->orderColumns('name', 'description')
			/* add column name */
			->addColumn('name', function ($model) {
				return $model->name;
			})
			/* add column Created */
			->addColumn('Created', function ($model) {
				$t = $model->created_at;
				return TicketController::usertimezone($t);
			})
			/* add column Actions */
			/* there are action buttons and modal popup to delete a data column */
			->addColumn('Actions', function ($model) {
				return '<span  data-toggle="modal" data-target="#deletecategory' . $model->slug . '"><a href="#" ><button class="btn btn-danger btn-xs"></a>'. \Lang::get("lang.delete") .'</button></span>&nbsp;<a href=category/' . $model->id . '/edit class="btn btn-warning btn-xs">'. \Lang::get("lang.edit") .'</a>&nbsp;<a href=article-list class="btn btn-primary btn-xs">'. \Lang::get("lang.view") .'</a>
				<div class="modal fade" id="deletecategory' . $model->slug . '">
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
            			</div>
        			</div>
    			</div>';
			})
			->make();

	}

	/**
	 * Create a Category
	 * @param type Category $category
	 * @return type view
	 */
	public function create(Category $category) {
		/* Get the all attributes in the category model */
		$category = $category->get();
		/* get the view page to create new category with all attributes
		of category model*/
		try {
			return view('themes.default1.agent.kb.category.create', compact('category'));	
		} catch(Exception $e) {
			return redirect()->back()->with('fails',$e->errorInfo[2]);
		}
	}

	/**
	 * To store the selected category
	 * @param type Category $category 
	 * @param type CategoryRequest $request 
	 * @return type Redirect
	 */
	public function store(Category $category, CategoryRequest $request) {
		/* Get the whole request from the form and insert into table via model */
		$sl = $request->input('slug');
		$slug = str_slug($sl, "-");
		$category->slug = $slug;
		// send success message to index page
		try{
			$category->fill($request->except('slug'))->save();
			return Redirect::back()->with('success', 'Category Inserted Successfully');
		} catch(Exception $e) {
			return Redirect::back()->with('fails', 'Category Not Inserted'.'<li>'.$e->errorInfo[2].'</li>');
		}
	}

	/**
	 * Show the form for editing the specified category.
	 * @param type $slug 
	 * @param type Category $category 
	 * @return type view
	 */
	public function edit($slug, Category $category) {
		// fetch the category
		$cid = $category->where('id', $slug)->first();
		$id = $cid->id;
		/* get the atributes of the category model whose id == $id */
		$category = $category->whereId($id)->first();
		/* get the Edit page the selected category via id */
		return view('themes.default1.agent.kb.category.edit', compact('category'));
	}

	/**
	 * Update the specified Category in storage.
	 * @param type $slug 
	 * @param type Category $category 
	 * @param type CategoryUpdate $request 
	 * @return type redirect
	 */
	public function update($slug, Category $category, CategoryUpdate $request) {
		
		/* Edit the selected category via id */
		$category = $category->where('id', $slug)->first();
		$sl = $request->input('slug');
		$slug = str_slug($sl, "-");
		// dd($slug);
		$category->slug = $slug;
		/* update the values at the table via model according with the request */
		//redirct to index page with success message
		try{
			$category->fill($request->all())->save();
			$category->slug = $slug;
			$category->save();
			return redirect('category')->with('success', 'Category Updated Successfully');	
		} catch(Exception $e) {
			//redirect to index with fails message
			return redirect('category')->with('fails', 'Category Not Updated'.'<li>'.$e->errorInfo[2].'</li>');
		}
	}

	/**
	 * Remove the specified category from storage.
	 * @param type $id 
	 * @param type Category $category 
	 * @param type Relationship $relation 
	 * @return type Redirect
	 */
	public function destroy($id, Category $category, Relationship $relation) {

		$relation = $relation->where('category_id', $id)->first();
		if($relation != null){
			return Redirect::back()->with('fails', 'Category Not Deleted');
		}
		else {
			/*  delete the category selected, id == $id */
			$category = $category->whereId($id)->first();
			// redirect to index with success message
			try{
				$category->delete();
				return Redirect::back()->with('success', 'Category Deleted Successfully');
			} catch(Exception $e){
				return Redirect::back()->with('fails', 'Category Not Deleted'.'<li>'.$e->errorInfo[2].'</li>');
			}			
		}
	}

}
