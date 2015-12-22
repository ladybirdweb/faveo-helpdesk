<?php namespace App\Http\Controllers\Agent\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\OrganizationRequest;
/* include organization model */
use App\Http\Requests\helpdesk\OrganizationUpdate;
// models
/* Define OrganizationRequest to validate the create form */
use App\Model\helpdesk\Agent_panel\Organization;
/* Define OrganizationUpdate to validate the create form */
use App\Model\helpdesk\Agent_panel\User_org_head;

/**
 * OrganizationController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class OrganizationController extends Controller {

	/**
	 * Create a new controller instance.
	 * constructor to check
	 * 1. authentication
	 * 2. user roles
	 * 3. roles must be agent
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('role.agent');
		// $this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 * @param type Organization $org
	 * @return type Response
	 */
	public function index() {
		try {
			/* get all values of table organization */
			return view('themes.default1.agent.helpdesk.organization.index');
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * This function is used to display the list of Organizations
	 * @return datatable
	 */
	public function org_list() {
		return \Datatable::collection(Organization::all())
			->searchColumns('name')
			->orderColumns('name', 'website')
			->addColumn('name', function ($model) {
				return $model->name;
			})
			->addColumn('website', function ($model) {
				$website = $model->website;
				return $website;
			})
			->addColumn('phone', function ($model) {
				$phone = $model->phone;
				return $phone;
			})
			->addColumn('Actions', function ($model) {
				//return '<a href=article/delete/ ' . $model->id . ' class="btn btn-danger btn-flat" onclick="myFunction()">Delete</a>&nbsp;<a href=article/' . $model->id . '/edit class="btn btn-warning btn-flat">Edit</a>&nbsp;<a href=show/' . $model->id . ' class="btn btn-warning btn-flat">View</a>';
				//return '<form action="article/delete/ ' . $model->id . '" method="post" onclick="alert()"><button type="sumbit" value="Delete"></button></form><a href=article/' . $model->id . '/edit class="btn btn-warning btn-flat">Edit</a>&nbsp;<a href=show/' . $model->id . ' class="btn btn-warning btn-flat">View</a>';
				return '<span  data-toggle="modal" data-target="#deletearticle'.$model->id .'"><a href="#" ><button class="btn btn-danger btn-xs"></a> ' . \Lang::get('lang.delete') . ' </button></span>&nbsp;<a href="'.route('organizations.edit', $model->id).'" class="btn btn-warning btn-xs">' . \Lang::get('lang.edit') . '</a>&nbsp;<a href="'.route('organizations.show', $model->id).'" class="btn btn-primary btn-xs">' . \Lang::get('lang.view') . '</a>
				<div class="modal fade" id="deletearticle'.$model->id .'">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Are You Sure ?</h4>
                </div>
                <div class="modal-body">
                '.$model->user_name.'
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
                    <a href="'.route('org.delete',$model->id).'"><button class="btn btn-danger">delete</button></a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>';
			})
			->make();
	}

	/**
	 * Show the form for creating a new resource.
	 * @return type Response
	 */
	public function create() {
		try {
			return view('themes.default1.agent.helpdesk.organization.create');
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type Organization $org
	 * @param type OrganizationRequest $request
	 * @return type Response
	 */
	public function store(Organization $org, OrganizationRequest $request) {
		try {
			/* Insert the all input request to organization table */
			/* Check whether function success or not */
			if ($org->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('organizations')->with('success', 'Organization  Created Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('organizations')->with('fails', 'Organization can not Create');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('organizations')->with('fails', 'Organization can not Create');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param type $id
	 * @param type Organization $org
	 * @return type Response
	 */
	public function show($id, Organization $org) {
		try {
			/* select the field by id  */
			$orgs = $org->whereId($id)->first();
			/* To view page */
			return view('themes.default1.agent.helpdesk.organization.show', compact('orgs'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param type $id
	 * @param type Organization $org
	 * @return type Response
	 */
	public function edit($id, Organization $org) {
		try {
			/* select the field by id  */
			$orgs = $org->whereId($id)->first();
			/* To view page */
			return view('themes.default1.agent.helpdesk.organization.edit', compact('orgs'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param type $id
	 * @param type Organization $org
	 * @param type OrganizationUpdate $request
	 * @return type Response
	 */
	public function update($id, Organization $org, OrganizationUpdate $request) {
		try {
			/* select the field by id  */
			$orgs = $org->whereId($id)->first();
			/* update the organization table   */
			/* Check whether function success or not */
			if ($orgs->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('organizations')->with('success', 'Organization  Updated Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('organizations')->with('fails', 'Organization  can not Update');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('organizations')->with('fails', 'Organization  can not Update');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @return type Response
	 */
	public function destroy($id, Organization $org) {
		try {
			// User_org
			/* select the field by id  */
			$orgs = $org->whereId($id)->first();
			/* Delete the field selected from the table */
			/* Check whether function success or not */
			if ($orgs->delete() == true) {
				/* redirect to Index page with Success Message */
				return redirect('organizations')->with('success', 'Organization  Deleted Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('organizations')->with('fails', 'Organization  can not Delete');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('organizations')->with('fails', 'Organization  can not Delete');
		}
	}

	public function Head_Org($id){

		$head_user = \Input::get('user');
		
		$org_head = Organization::where('id','=',$id)->first();
		$org_head->head = $head_user; 
		$org_head->save(); 
		return 1;
	}

}
