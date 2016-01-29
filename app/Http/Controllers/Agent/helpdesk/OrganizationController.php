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
use App\Model\helpdesk\Agent_panel\User_org;
// classes
use Exception;

/**
 * OrganizationController
 * This controller is used to CRUD organization detail.
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
	 * @return void
	 */
	public function __construct() {
        // checking for authentication
		$this->middleware('auth');
        // checking if the role is agent
		$this->middleware('role.agent');
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
		// chumper datable package call to display Advance datatable
		return \Datatable::collection(Organization::all())
			/* searchable name */
			->searchColumns('name')
			/* order by name and website */
			->orderColumns('name', 'website')
			/* column name */
			->addColumn('name', function ($model) {
				// return $model->name;
				if(strlen($model->name) > 20) {
                    $orgname = substr($model->name, 0, 25);
                    $orgname = substr($orgname, 0, strrpos($orgname, ' ')).' ...'; 
                } else {
                	$orgname = $model->name;
                }
				return $orgname;
			})
			/* column website */
			->addColumn('website', function ($model) {
				$website = $model->website;
				return $website;
			})
			/* column phone number */
			->addColumn('phone', function ($model) {
				$phone = $model->phone;
				return $phone;
			})
			/* column action buttons */
			->addColumn('Actions', function ($model) {
				// displaying action buttons 
				// modal popup to delete data
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
	 * Show the form for creating a new organization.
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
	 * Store a newly created organization in storage.
	 * @param type Organization $org
	 * @param type OrganizationRequest $request
	 * @return type Redirect
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
	 * Display the specified organization.
	 * @param type $id
	 * @param type Organization $org
	 * @return type view
	 */
	public function show($id, Organization $org) {
		try {
			/* select the field by id  */
			$orgs = $org->whereId($id)->first();
			/* To view page */
			return view('themes.default1.agent.helpdesk.organization.show', compact('orgs'));
		} catch (Exception $e) {
			return redirect()->back()->with('fails', $e->errorInfo[2]);
		}
	}

	/**
	 * Show the form for editing the specified organization.
	 * @param type $id
	 * @param type Organization $org
	 * @return type view
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
	 * Update the specified organization in storage.
	 * @param type $id
	 * @param type Organization $org
	 * @param type OrganizationUpdate $request
	 * @return type Redirect
	 */
	public function update($id, Organization $org, OrganizationUpdate $request) {
		
			/* select the field by id  */
			$orgs = $org->whereId($id)->first();
			/* update the organization table   */
			/* Check whether function success or not */
			try {
				if ($orgs->fill($request->input())->save() == true) {
					/* redirect to Index page with Success Message */
					return redirect('organizations')->with('success', 'Organization  Updated Successfully');
				} else {
					/* redirect to Index page with Fails Message */
					return redirect('organizations')->with('fails', 'Organization  can not Update');
				}
			} catch (Exception $e) {
				/* redirect to Index page with Fails Message */
				return redirect('organizations')->with('fails', $e->errorInfo[2]);
			}
	}

	/**
	 * Delete a specified organization from storage.
	 * @param type int $id
	 * @return type Redirect
	 */
	public function destroy($id, Organization $org, User_org $user_org) {
		
			/* select the field by id  */
			$orgs = $org->whereId($id)->first();
			$user_orgs = $user_org->where('org_id','=',$id)->get();
			foreach ($user_orgs as $user_org) {
				$user_org->delete();
			}
			/* Delete the field selected from the table */
			/* Check whether function success or not */
			try {
				$orgs->delete();
				/* redirect to Index page with Success Message */
				return redirect('organizations')->with('success', 'Organization  Deleted Successfully');
			} catch (Exception $e) {
				/* redirect to Index page with Fails Message */
				return redirect('organizations')->with('fails', $e->errorInfo[2]);
			}
	}

	/**
	 * Soring an organization head
	 * @param type $id 
	 * @return type boolean
	 */
	public function Head_Org($id){
		// get the user to make organization head
		$head_user = \Input::get('user');
		// get an instance of the selected organization
		$org_head = Organization::where('id','=',$id)->first();
		$org_head->head = $head_user; 
		// save the user to organization head
		$org_head->save(); 
		return 1;
	}

}
