<?php

$date = Date('d-m-Y');
$format = 'Y-m-d';
$day1  = Date($format,strtotime('-1 day'. $date));

$depts = App\Model\helpdesk\Agent\Department::all();
foreach ($depts as $dept) {
	// echo $dept->name;
	$created  =  DB::table('tickets')->select('created_at')->where('dept_id','=',$dept->id)->where('created_at','LIKE','%'.$day1.'%')->count();
	$closed  =  DB::table('tickets')->where('dept_id','=',$dept->id)->where('closed_at','LIKE','%'.$day1.'%')->count();
	$inprogress = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept->id)->where('status', '=', 1)->count();
	$overdues = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept->id)->where('isanswered', '=', 0)->where('status', '=', 1)->get();
	$i = 0;
	foreach ($overdues as $overdue) {
		$sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('id','=',$overdue->sla)->first();
		$ovdate = $overdue->created_at;
		$new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan->grace_period)).'<br/><br/>';
		if(date('Y-m-d H:i:s') > $new_date){
			$i++;
		}
	}
	// echo "created=".$created."<br/>";
	// echo "closed=".$closed."<br/>";
	// echo "inprogress=".$inprogress."<br/>";
	// echo "overdue=".$i."<br/>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SmoothDeal</title>
</head>

<body style="background-color: #666">

<!-- Start Container -->
<table align="center" width="600" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td style="padding: " colspan="2" bgcolor="#FFFFFF">
    <!-- Start Main Text (introduction) -->
        <!-- Main Title -->
        <p style="padding: 15px 30px 20px 50px; margin: 0; font-size: 24px; color: #333; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-align: center;">
            {!! $company !!}
        </p>
        <!-- Main Text -->
        <p style="padding: 0px 30px 20px 50px; margin: 0; font-size: 16px; color: #333; font-weight: normal; font-family: Arial, Helvetica, sans-serif; line-height: 22px; text-align: center;">
            <strong> Daily Report</strong>
        </p>
        <p style="padding: 0px 30px 20px 50px; margin: 0; font-size: 12px; color: #333; font-weight: normal; font-family: Arial, Helvetica, sans-serif; line-height: 22px;">
            <strong>Hi {!! $name !!},</strong> <br> Below mentioned is daily report for {!! $company !!}.
        </p>
    <!-- End Main Text (introduction) -->
    </td>
  </tr>
    

   
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">
    
    <!-- Start - Quick overview table -->
    
        <!-- Quick overview table title -->
        <p style="padding: 25px 0px 20px 0px; margin: 0; font-size: 18px; color: #333; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-align: center;">
            Overview
        </p>
       
@foreach ($depts as $dept) 
   <?php 
    // echo $dept->name;
    $created  =  DB::table('tickets')->select('created_at')->where('dept_id','=',$dept->id)->where('created_at','LIKE','%'.$day1.'%')->count();
    $closed  =  DB::table('tickets')->where('dept_id','=',$dept->id)->where('closed_at','LIKE','%'.$day1.'%')->count();
    $inprogress = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept->id)->where('status', '=', 1)->count();
    $overdues = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept->id)->where('isanswered', '=', 0)->where('status', '=', 1)->get();
    $i = 0;
    foreach ($overdues as $overdue) {
       $sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('id','=',$overdue->sla)->first();
       $ovdate = $overdue->created_at;
       $new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan->grace_period)).'<br/><br/>';
       if(date('Y-m-d H:i:s') > $new_date){
          $i++;
       }
    }
   // echo "created=".$created."<br/>";
   // echo "closed=".$closed."<br/>";
   // echo "inprogress=".$inprogress."<br/>";
   // echo "overdue=".$i."<br/>";
   ?>
            <!-- Overview Table -->
              <table align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #333;" width="500" border="0" cellspacing="0" cellpadding="10">
                <tr >
                    <td align="center" bgcolor="#FFF2D9" colspan="2" style="border: 1px solid #F1DDDD; ">
                        <span style="font-size: 18px; color: #158CCA;"><strong>{!! $dept->name !!}</strong></span>
                    </td>
                </tr>
                
                <tr>
                <td align="center"><strong>New tickets</strong></td>
                    <td align="center"><strong>{!! $created !!}</strong></td>
                </tr>
              <tr>
                <td align="center" bgcolor="#EBEBEB"><strong>Closed tickets</strong></td>
                  <td align="center" bgcolor="#EBEBEB"><strong>{!! $closed !!}</strong></td>
              </tr>
          
                <tr>
                <td align="center"><strong>Inprogress tickets</strong></td>
                    <td align="center"><strong>{!! $inprogress !!}</strong></td>
                </tr>
              <tr>
                <td align="center" bgcolor="#EBEBEB"><strong>Overdue tickets</strong></td>
                  <td align="center" bgcolor="#EBEBEB"><strong>{!! $i !!}</strong></td>
              </tr>
                
                <tr>
                    <td colspan="2" style="height: 10px;"></td>
                </tr>
                </table>
            <!-- End - Overview table -->
        @endforeach
        
       
        
        <tr>
            <td style="padding: " colspan="2" bgcolor="#FFFFFF">
                <p style="padding: 0px 30px 20px 50px; margin: 0; font-size: 11px; color: #333; font-weight: normal; font-family: Arial, Helvetica, sans-serif; line-height: 22px;">
                    We should all work hard to guarantee that all tickets are being addressed in a timely manner.</p>
                
                <p style="padding: 15px 30px 20px 50px; margin: 0; font-size: 16px; color: #333; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Thank You,<br/> Kind Regards,<br/>{!! $company !!}
                </p>
                
                <!-- Main Text -->
                <p style="padding: 0px 30px 20px 50px; margin: 0; font-size: 16px; color: #333; font-weight: normal; font-family: Arial, Helvetica, sans-serif; line-height: 22px; text-align: center; color: #3AB4FF;">
                    <strong>Powered by <a href="http://www.faveohelpdesk.com" target="_blank">Faveo</a></strong>
                </p>
             
            </td>
        </tr>
    </td>
  </tr>

</table>


</body>
</html>
