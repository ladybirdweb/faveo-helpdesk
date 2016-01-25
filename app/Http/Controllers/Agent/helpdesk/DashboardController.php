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
use Exception;

/**
 * DashboardController
 * This controlleris used to fetch dashboard in the agent panel
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
        // checking for authentication
		$this->middleware('auth');
        // checking if the role is agent
		$this->middleware('role.agent');
	}

	/**
	 * Get the dashboard page
	 * @return type view
	 */
	public function index() {
		// if(Auth::user()->role == "user"){
			// return \Redirect::route('home');		
		// }
        try {
            return View::make('themes.default1.agent.helpdesk.dashboard.dashboard');  
        } catch (Exception $e) {
            return View::make('themes.default1.agent.helpdesk.dashboard.dashboard');  
        }
	}

    /**
     * Fetching dashboard graph data to implement graph
     * @return type Json
     */
    public function ChartData()
    {

        // $date11 = strtotime(\Input::get('start_date'));
        // $date12 = strtotime(\Input::get('end_date'));
        // if($date11 && $date12){
        //     $date2 = $date12;
        //     $date1 = $date11;
        // } else {
            // generating current date
            $date2 = strtotime(Date('Y-m-d'));
            $date3 = Date('Y-m-d');
            $format = 'Y-m-d';
            // generating a date range of 1 month
            $date1  = strtotime(Date($format,strtotime('-1 month'. $date3)));
        // }

        $return = "";
        $last = "";
        // fetching dashboard data for each day on a 1 month fixed range
        // this range can also be fetched on a requested rannge of date
        for ( $i = $date1; $i <= $date2; $i = $i + 86400 ) {
            $thisDate = date( 'Y-m-d', $i ); 
            // created tickets
            $created = \DB::table('tickets')->select('created_at')->where('created_at','LIKE','%'.$thisDate.'%')->count();
            // closed tickets
            $closed = \DB::table('tickets')->select('closed_at')->where('closed_at','LIKE','%'.$thisDate.'%')->count();
            // reopened tickets
            $reopened = \DB::table('tickets')->select('reopened_at')->where('reopened_at','LIKE','%'.$thisDate.'%')->count();          
            // storing in array format
            $value = ['date' => $thisDate, 'open' => $created, 'closed' => $closed, 'reopened' => $reopened];
            $array = array_map('htmlentities',$value);
            // encoding the values in jsom format
            $json = html_entity_decode(json_encode($array));
            $return .= $json.',';
        }
        // combining all the values in a single variable and returning that variable in Json.
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
