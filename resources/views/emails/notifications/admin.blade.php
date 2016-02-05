name;
	$created  =  DB::table('tickets')-&gt;select('created_at')-&gt;where('dept_id','=',$dept-&gt;id)-&gt;where('created_at','LIKE','%'.$day1.'%')-&gt;count();
	$closed  =  DB::table('tickets')-&gt;where('dept_id','=',$dept-&gt;id)-&gt;where('closed_at','LIKE','%'.$day1.'%')-&gt;count();
	$inprogress = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept-&gt;id)-&gt;where('status', '=', 1)-&gt;count();
	$overdues = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept-&gt;id)-&gt;where('status', '=', 1)-&gt;get();
	$i = 0;
	foreach ($overdues as $overdue) {
		$sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('id','=',$overdue-&gt;sla)-&gt;first();
		$ovdate = $overdue-&gt;created_at;
		$new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan-&gt;grace_period)).'<br><br>';
		if(date('Y-m-d H:i:s') &gt; $new_date){
			$i++;
		}
	}
	// echo "created=".$created."<br>";
	// echo "closed=".$closed."<br>";
	// echo "inprogress=".$inprogress."<br>";
	// echo "overdue=".$i."<br>";
}

?&gt;





SmoothDeal





<span>

  <span><span>
    <span>
    
        
        <p>
            {!! $company !!}
        </p>
        
        <p>
            <strong> Daily Report</strong>
        </p>
        <p>
            <strong>Hi {!! $name !!},</strong> <br> Below mentioned are your daily report for your {!! $company !!}.
        </p>
    
    </span>
  </span>
    

   
  <span>
    <span>
    
    
    
        
        <p>
            Overview
        </p>
       
@foreach ($depts as $dept) 
   name;
   $created  =  DB::table('tickets')-&gt;select('created_at')-&gt;where('dept_id','=',$dept-&gt;id)-&gt;where('created_at','LIKE','%'.$day1.'%')-&gt;count();
   $closed  =  DB::table('tickets')-&gt;where('dept_id','=',$dept-&gt;id)-&gt;where('closed_at','LIKE','%'.$day1.'%')-&gt;count();
   $inprogress = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept-&gt;id)-&gt;where('status', '=', 1)-&gt;count();
   $overdues = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept-&gt;id)-&gt;where('status', '=', 1)-&gt;get();
   $i = 0;
   foreach ($overdues as $overdue) {
      $sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('id','=',$overdue-&gt;sla)-&gt;first();
      $ovdate = $overdue-&gt;created_at;
      $new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan-&gt;grace_period)).'<br><br>';
      if(date('Y-m-d H:i:s') &gt; $new_date){
         $i++;
      }
   }
   // echo "created=".$created."<br>";
   // echo "closed=".$closed."<br>";
   // echo "inprogress=".$inprogress."<br>";
   // echo "overdue=".$i."<br>";
   ?&gt;
            
              <span>
                <span><span>
                    <span>
                        <strong>{!! $dept-&gt;name !!}</strong>
                    </span>
                </span>
                
                <span>
                <strong>New tickets</strong>
                    <strong>{!! $created !!}</strong>
                </span>
              <span>
                <strong>Closed tickets</strong>
                  <strong>{!! $closed !!}</strong>
              </span>
          
                <span>
                <strong>Inprogress tickets</strong>
                    <strong>{!! $inprogress !!}</strong>
                </span>
              <span>
                <strong>Overdue tickets</strong>
                  <strong>{!! $i !!}</strong>
              </span>
                
                
                    
                
                </span></span>
            
        @endforeach
        
       
        
        </span></span><span>
            <span>
                <p>
                    We should all work hard to guarantee that all tickets are being addressed in a timely manner.&nbsp;

                </p>
                
                <p>
                    Thank You,<br> Kind Regards,<br>{!! $company !!}
                </p>
                
                
                <p>
                    <strong>     Powered by Faveo</strong>
                </p>
             
            </span>
        </span>
    
  

</span></span>