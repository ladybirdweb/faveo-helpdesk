<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders your application's "dashboard" for users that
      | are authenticated. Of course, you are free to change or remove the
      | controller as you wish. It is just here to get your app started!
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        // ksjdckjdsnc
        return view('themes/default1/admin/dashboard');
    }

    public function getdata()
    {
        return \View::make('emails/notifications/agent');
    }

    public function getreport()
    {
        return \View::make('test');
    }

    public function pushdata()
    {
        $date2 = strtotime(date('Y-m-d'));
        $date3 = date('Y-m-d');
        $format = 'Y-m-d';
        $date1 = strtotime(date($format, strtotime('-1 month'.$date3)));

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
    }
}
