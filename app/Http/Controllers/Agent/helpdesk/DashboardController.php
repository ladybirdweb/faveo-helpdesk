<?php namespace App\Http\Controllers\Agent\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// models
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Ticket\Ticket_Collaborator;
use App\Model\helpdesk\Email\Emails;
use App\User;
// classes
use DB;
use View;
use Auth;

/**
 * DashboardController
 *
 * @package   	Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class DashboardController extends Controller {

	/**
	 * Create a new controller instance.
	 * constructor to check
	 * 1. authentication
	 * 2. user roles
	 * 3. roles must be agent
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('role.agent');
	}

	/**
	 * Show the form for creating a new resource.
	 * @return type Response
	 */
	public function index() {
		try {
			if(Auth::user()->role == "user"){
				return \Redirect::route('home');		
			}
			return View::make('themes.default1.agent.helpdesk.dashboard.dashboard');
		} catch (Exception $e) {
			return view('404');
		}
	}

    /**
     * ChartData
     * @return type
     */
    public function ChartData()
    {
    	    	      $date2 = strtotime(Date('Y-m-d'));
	      $date3 = Date('Y-m-d');
    	  $format = 'Y-m-d';
      	$date1  = strtotime(Date($format,strtotime('-1 month'. $date3)));
      
      $return = "";
      $last = "";
      for ( $i = $date1; $i <= $date2; $i = $i + 86400 ) {
          $thisDate = date( 'Y-m-d', $i ); 
      
          $created = \DB::table('tickets')->select('created_at')->where('created_at','LIKE','%'.$thisDate.'%')->count();
          $closed = \DB::table('tickets')->select('closed_at')->where('closed_at','LIKE','%'.$thisDate.'%')->count();
          $reopened = \DB::table('tickets')->select('reopened_at')->where('reopened_at','LIKE','%'.$thisDate.'%')->count();
          
          $value = ['date' => $thisDate, 'open' => $created, 'closed' => $closed, 'reopened' => $reopened];
          $array = array_map('htmlentities',$value);
          $json = html_entity_decode(json_encode($array));
          $return .= $json.',';
      }
      $last = rtrim($return,',');

      return '['.$last.']';
      
        // $ticketlist = DB::table('tickets')
        //     ->select(DB::raw('MONTH(updated_at) as month'),DB::raw('SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as closed'),DB::raw('SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as reopened'),DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as open'),DB::raw('SUM(CASE WHEN status = 5 THEN 1 ELSE 0 END) as deleted'),
        //         DB::raw('count(*) as totaltickets'))
        //     ->groupBy('month')
        //     ->orderBy('month', 'asc')
        //     ->get();
     
        // return $ticketlist;
    }

}
