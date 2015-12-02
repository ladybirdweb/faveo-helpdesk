<?php namespace App\Http\Controllers\Agent\kb;

use App\Http\Controllers\client\kb\UserController;
use App\Http\Controllers\Agent\kb\ArticleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\kb\SettingsController;
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Requests\kb\PageRequest;
use App\Http\Requests\kb\PageUpdate;
use App\Model\kb\Page;
use Datatable;
use Illuminate\Http\Request;

class PageController extends Controller {

	/**
	 * Contructor for both Authentication and Model Injecting
	 * @param type Page $page
	 * @return type
	 */
	public function __construct(Page $page) {
		$this->middleware('auth');
		$this->middleware('roles');
		$this->page = $page;
		SettingsController::language();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		$pages = $this->page->paginate(3);
		$pages->setPath('page');
		return view('themes.default1.agent.kb.pages.index', compact('pages'));

	}

	public function getData() {

		//return 'kfjhje';

		return Datatable::collection(Page::All())
			->searchColumns('name')
			->orderColumns('name', 'description', 'created')
			->addColumn('name', function ($model) {
				return $model->name;
			})

			->addColumn('Created', function ($model) {

				$t = $model->created_at;
				return TicketController::usertimezone($t);
			})
			->addColumn('Actions', function ($model) {

				//return '<a href=page/delete/' . $model->id . ' class="btn btn-danger btn-flat">Delete</a>&nbsp;<a href=page/' . $model->id . '/edit class="btn btn-warning btn-flat">Edit</a>&nbsp;<a href=article-list class="btn btn-warning btn-flat">View</a>';
				return '<span  data-toggle="modal" data-target="#deletepage' . $model->id . '"><a href="#" ><button class="btn btn-danger btn-xs"></a> '. \Lang::get('lang.delete') .'</button></span>&nbsp;<a href=page/' . $model->slug . '/edit class="btn btn-warning btn-xs">'. \Lang::get('lang.edit') .'</a>&nbsp;<a href=pages/' . $model->slug . ' class="btn btn-primary btn-xs">'. \Lang::get('lang.view') .'</a>
				<div class="modal fade" id="deletepage' . $model->id . '">
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
                    <a href="page/delete/' . $model->id . '"><button class="btn btn-danger">delete</button></a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>';
			})
			->make();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return view('themes.default1.agent.kb.pages.create');
	}

	/**
	 * To insert a value to the table Page
	 * @param type Request $request
	 * @return type
	 */
	public function store(PageRequest $request) {
			$sl = $request->input('slug');
			$slug = str_slug($sl, "-");

			$this->page->slug = $slug;

		$this->page->fill($request->except('slug'))->save();
		return redirect('page');
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
	 * To edit a page
	 * @param type $id
	 * @return type
	 */
	public function edit($slug) {
		$page = $this->page->where('slug', $slug)->first();
		return view('themes.default1.agent.kb.pages.edit', compact('page'));
	}

	/**
	 * To update a page
	 * @param type $id
	 * @param type Request $request
	 * @return type
	 */
	public function update($slug, PageUpdate $request) {
		$pages = $this->page->where('slug', $slug)->first();
		$sl = $request->input('slug');
			$slug = str_slug($sl, "-");

			$this->page->slug = $slug;
		//$id = $page->id;
		$pages->fill($request->all())->save();
		$pages->slug = $slug;
		$pages->save();
		return redirect('page')->with('success', 'Your Page Updated Successfully');
	}

	/**
	 * To Delete one Page
	 * @param type $id
	 * @return type
	 */
	public function destroy($id) {
		$page = $this->page->whereId($id)->first();
		$page->delete();
		return redirect('page')->with('success', 'Page Deleted Successfully');
	}

}