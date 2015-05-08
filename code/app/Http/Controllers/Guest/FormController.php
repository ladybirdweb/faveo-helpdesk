<?php
namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
/* include help topic model */
use App\Model\Form\Form_details;
/* Include form_name model */
use App\Model\Form\Form_name;
/* include form_detals model */
/* Include form_value model */
use App\Model\Manage\Help_topic;
use App\User;
use Form;
use Illuminate\Http\Request;
/* Validate form TicketForm using */
use Input;

/**
 * FormController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class FormController extends Controller {

	/**
	 * This Function to get the form for the ticket
	 * @param type Form_name $name
	 * @param type Form_details $details
	 * @param type Help_topic $topics
	 * @return type Response
	 */
	public function getForm(Form_name $name, Form_details $details, Help_topic $topics) {
		// name of the form where status==1
		$name = $name->where('status', 1)->get();
		//get label and the type from form_detail table where form_name_id of form_detail
		// equal to form_name table's id
		$ids = $name->where('id', 2);
		foreach ($ids as $i) {
			$id = $i->id;
		}
		//get form_name_id from form_detail and save to detail_form_name_id
		$detail_form_name_id = $details->where('form_name_id', $id)->get();
		$count = count($detail_form_name_id);
		// foreach($detail_form_name_id as $details)
		// {
		//    		echo $details->label;
		//    	}
		return view('themes.default1.client.guest-user.form', compact('name', 'detail_form_name_id', 'topics'));
	}

	/**
	 * This Function to post the form for the ticket
	 * @param type Form_name $name
	 * @param type Form_details $details
	 * @return type string
	 */
	public function postForm(Form_name $name, Form_details $details) {
		$name = $name->where('status', 1)->get();
		$ids = $name->where('id', 2);
		foreach ($ids as $i) {
			$id = $i->id;
			//echo $id;
		}
		$field = $details->where('form_name_id', $id)->get();
		$var = " ";
		foreach ($field as $key) {
			$type = $key->type;
			$label = $key->label;
			$var .= "," . $type . "-" . $label;
		}
		return $var;
		// foreach($outs as $out)
		// {
		// 	return $out;
		// }
		// $var=" ";
		// foreach ($field as $key) {
		// $field=$key->field_name;
		// $id=$key->form_id;
		// $var.=",".$field;
		// }
		// return $var;
		// // $var=$field.$id;
		// // return
		// // return Response::json(array(
		//        // 'field' => $field,
		//        // 'id' => $id
		//        // ));
	}

	/**
	 * Posted form
	 * @param type Request $request
	 * @param type User $user
	 */
	public function postedForm(Request $request, User $user) {
		$user->name = $request->input('Name');
		$user->email = $request->input('Email');
		$user->save();
	}
}
