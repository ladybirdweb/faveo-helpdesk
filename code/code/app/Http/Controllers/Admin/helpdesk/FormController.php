<?php namespace App\Http\Controllers\Admin\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\FormRequest;
// models
use App\Model\helpdesk\Manage\Forms;
use App\Model\helpdesk\Utility\Form_type;
use App\Model\helpdesk\Utility\Form_visibility;

/**
 * FormController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class FormController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 * @param type Forms $form
	 * @return type Response
	 */
	public function index(Forms $form) {
		try {
			/* declare variable $forms to hold the values of table form */
			$forms = $form->get();
			/* Direct to index page with Form table values */
			return view('themes.default1.admin.helpdesk.manage.form.index', compact('forms'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * @param type Form_visibility $visibility
	 * @param type Form_type $type
	 * @return type Response
	 */
	public function create(Form_visibility $visibility, Form_type $type) {
		try {
			/* Direct to Create page */
			return view('themes.default1.admin.helpdesk.manage.form.create', compact('visibility', 'type'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type Forms $form
	 * @param type FormRequest $request
	 * @return type Response
	 */
	public function store(Forms $form, FormRequest $request) {
		try {
			/* Fill the all request to the Table */
			/* Checking Whether function Success or not */
			if ($form->fill($request->input())->save() == true) {
				/*  Redirect to Index page with Success Message  */
				return redirect('form')->with('success', 'Form Created Successfully');
			} else {
				/* Redirect to Index page with Fail Message */
				return redirect('form')->with('fails', 'Form can not Create');
			}
		} catch (Exception $e) {
			/* Redirect to Index page with Fail Message */
			return redirect('form')->with('fails', 'Form can not Create');
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
	 * @param type int  $id
	 * @param type Forms $form
	 * @param type Form_visibility $visibility
	 * @param type Form_type $type
	 * @return type Response
	 */
	public function edit($id, Forms $form, Form_visibility $visibility, Form_type $type) {
		try {
			/* declare variable $forms to hold the values of a row by Id */
			$forms = $form->whereId($id)->first();
			/* Direct to Edit page with Form table's perticular row using Id */
			return view('themes.default1.admin.helpdesk.manage.form.edit', compact('forms', 'visibility', 'type'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * @param type int $id
	 * @param type Forms $form
	 * @param type FormRequest $request
	 * @return type Response
	 */
	public function update($id, Forms $form, FormRequest $request) {
		try {
			/* declare variable $forms to hold the values of a row by Id */
			$forms = $form->whereId($id)->first();
			/* Fill the values to the row of a selected, by Id */
			/* Check Whether function is Success or not */
			if ($forms->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('form')->with('success', 'Form Updated Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('form')->with('fails', 'Form can not Update');
			}
		} catch (Exception $e) {
			/* Redirect to Index page with Fail Message */
			return redirect('form')->with('fails', 'Form can not Create');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @param type Forms $form
	 * @return type Response
	 */
	public function destroy($id, Forms $form) {
		try {
			/* declare variable $forms to hold the values of a row by Id */
			$forms = $form->whereId($id)->first();
			/* Delete the values to the row of a selected, by Id */
			/* Check whether the fuction success or not */
			if ($forms->delete() == true) {
				/* redirect to Index page with Success Message */
				return redirect('form')->with('success', 'Form Deleted Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('form')->with('fails', 'Form can not Deleted');
			}
		} catch (Exception $e) {
			/* Redirect to Index page with Fail Message */
			return redirect('form')->with('fails', 'Form can not Create');
		}
	}
}
