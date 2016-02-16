<?php

namespace App\Http\Controllers\Agent\kb;

// controllers
use App\Http\Controllers\client\kb\UserController;
use App\Http\Controllers\Agent\kb\ArticleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\kb\SettingsController;
use App\Http\Controllers\Agent\helpdesk\TicketController;
// request
use App\Http\Requests\kb\PageRequest;
use App\Http\Requests\kb\PageUpdate;
use Illuminate\Http\Request;
// Model
use App\Model\kb\Page;
// classes
use Datatable;
use Exception;

/**
 * PageController
 * This controller is used to CRUD Pages
 *
 * @package 	Controllers
 * @subpackage 	Controller
 * @author     	Ladybird <info@ladybirdweb.com>
 */
class PageController extends Controller {

    /**
     * Create a new controller instance.
     * constructor to check
     * 1. authentication
     * 2. user roles
     * 3. roles must be agent
     * @return void
     */
    public function __construct(Page $page) {
        // checking authentication
        $this->middleware('auth');
        // checking roles
        $this->middleware('roles');
        $this->page = $page;
        SettingsController::language();
    }

    /**
     * Display the list of pages
     * @return type
     */
    public function index() {
        $pages = $this->page->paginate(3);
        $pages->setPath('page');
        try {
            return view('themes.default1.agent.kb.pages.index', compact('pages'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * fetching pages list in chumper datatables
     * @return type
     */
    public function getData() {
        /* fetching chumper datatables */
        return Datatable::collection(Page::All())
                        /* search column name */
                        ->searchColumns('name')
                        /* order column name, description and created */
                        ->orderColumns('name', 'description', 'created')
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
                            return '<span  data-toggle="modal" data-target="#deletepage' . $model->id . '"><a href="#" ><button class="btn btn-danger btn-xs"></a> ' . \Lang::get('lang.delete') . '</button></span>&nbsp;<a href=page/' . $model->slug . '/edit class="btn btn-warning btn-xs">' . \Lang::get('lang.edit') . '</a>&nbsp;<a href=pages/' . $model->slug . ' class="btn btn-primary btn-xs">' . \Lang::get('lang.view') . '</a>
				<div class="modal fade" id="deletepage' . $model->id . '">
        			<div class="modal-dialog">
            			<div class="modal-content">
                			<div class="modal-header">
                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    			<h4 class="modal-title">Are You Sure ?</h4>
                			</div>
                			<div class="modal-body">
                				' . $model->name . '
                			</div>
                			<div class="modal-footer">
	                    		<button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
    			                <a href="page/delete/' . $model->id . '"><button class="btn btn-danger">delete</button></a>
			                </div>
		            	</div>
			        </div>
    			</div>';
                        })
                        ->make();
    }

    /**
     * Show the form for creating a new resource.
     * @return type view
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
        try {
            $this->page->fill($request->except('slug'))->save();
            return redirect('page')->with('success', 'Page created successfully');
        } catch (Exception $e) {
            return redirect('page')->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * To edit a page
     * @param type $slug 
     * @return type view
     */
    public function edit($slug) {
        try {
            $page = $this->page->where('slug', $slug)->first();
            return view('themes.default1.agent.kb.pages.edit', compact('page'));
        } catch (Exception $e) {
            return redirect('page')->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * To update a page
     * @param type $slug 
     * @param type PageUpdate $request 
     * @return type redirect
     */
    public function update($slug, PageUpdate $request) {
        // get pages with respect to slug
        $pages = $this->page->where('slug', $slug)->first();
        $sl = $request->input('slug');
        $slug = str_slug($sl, "-");
        $this->page->slug = $slug;
        try {
            $pages->fill($request->all())->save();
            $pages->slug = $slug;
            $pages->save();
            return redirect('page')->with('success', 'Your Page Updated Successfully');
        } catch (Exception $e) {
            return redirect('page')->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * To Delete a Page
     * @param type $id 
     * @return type redirect
     */
    public function destroy($id) {
        try {
            // get the page to be deleted
            $page = $this->page->whereId($id)->first();
            $page->delete();
            return redirect('page')->with('success', 'Page Deleted Successfully');
        } catch (Exception $e) {
            return redirect('page')->with('fails', $e->errorInfo[2]);
        }
    }

}
