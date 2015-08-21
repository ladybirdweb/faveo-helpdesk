<?php namespace App\Http\Controllers\Agent;
use App\Model\Settings\Company;
use App\Model\Ticket\Ticket_Collaborator;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use View;
use Auth;
use App\Model\Email\Emails;

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
	 *
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
			
			return View::make('themes.default1.agent.dashboard.dashboard');
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
        $ticketlist = DB::table('tickets')
            ->select(DB::raw('MONTHNAME(updated_at) as month'), DB::raw("(closed) as monthNum"),
                DB::raw('count(*) as tickets'))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();
        
        return $ticketlist;
    }

}
