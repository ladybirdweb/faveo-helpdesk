<?php

namespace App\Http\Controllers\Agent\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// models
use App\User;
// classes
use Auth;
use DB;
use Exception;
use View;

/**
 * DashboardController
 * This controlleris used to fetch dashboard in the agent panel.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class DashboardController2 extends Controller
{
    /**
     * Create a new controller instance.
     * constructor to check
     * 1. authentication
     * 2. user roles
     * 3. roles must be agent.
     *
     * @return void
     */
    public function __construct()
    {
        // checking for authentication
        $this->middleware('auth');
        // checking if the role is agent
        $this->middleware('role.agent');
    }

    /**
     * Get the dashboard page.
     *
     * @return type view
     */
    public function index()
    {
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
     * Fetching dashboard graph data to implement graph.
     *
     * @return type Json
     */
    public function ChartData($date111 = '', $date122 = '')
    {
        $date11 = strtotime($date122);
        $date12 = strtotime($date111);
        if ($date11 && $date12) {
            $date2 = $date12;
            $date1 = $date11;
        } else {
            // generating current date
            $date2 = strtotime(date('Y-m-d'));
            $date3 = date('Y-m-d');
            $format = 'Y-m-d';
            // generating a date range of 1 month
            $date1 = strtotime(date($format, strtotime('-1 month'.$date3)));
        }
        $return = '';
        $last = '';
        for ($i = $date1; $i <= $date2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);

            $created = \DB::table('tickets')->select('created_at')->where('created_at', 'LIKE', '%'.$thisDate.'%')->count();
            $closed = \DB::table('tickets')->select('closed_at')->where('closed_at', 'LIKE', '%'.$thisDate.'%')->count();
            $reopened = \DB::table('tickets')->select('reopened_at')->where('reopened_at', 'LIKE', '%'.$thisDate.'%')->count();

            $value = ['date' => $thisDate, 'open' => $created, 'closed' => $closed, 'reopened' => $reopened];
            $array = array_map('htmlentities', $value);
            $json = html_entity_decode(json_encode($array));
            $return .= $json.',';
        }
        $last = rtrim($return, ',');

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
