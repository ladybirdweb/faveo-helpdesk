<?php

$date = Date('d-m-Y');
$format = 'Y-m-d';
$day1  = Date($format,strtotime('-1 day'. $date));

$depts = App\Model\helpdesk\Agent\Department::all();
foreach ($depts as $dept) {
	// echo $dept->name;
	$created  =  DB::table('tickets')->select('created_at')->where('dept_id', $dept->id)->where('team_id', $team_id)->where('created_at','LIKE','%'.$day1.'%')->count();

	$closed  =  DB::table('tickets')->where('dept_id', $dept->id)->where('team_id', $team_id)->where('closed_at','LIKE','%'.$day1.'%')->count();

	$inprogress = App\Model\helpdesk\Ticket\Tickets::where('dept_id', $dept->id)->where('team_id', $team_id)->where('status', '=', 1)->count();

	$overdues = App\Model\helpdesk\Ticket\Tickets::where('dept_id', $dept->id)->where('team_id', $team_id)->where('isanswered', '=', 0)->where('status', '=', 1)->get();

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



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Simples-Minimalistic Responsive Template</title>
      
      <style type="text/css">
         /* Client-specific Styles */
         #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
         body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
         /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
         .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.*/
         #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
         img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
         a img {border:none;}
         .image_fix {display:block;}
         p {margin: 0px 0px !important;}
         table td {border-collapse: collapse;}
         table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
         a {color: #0a8cce;text-decoration: none;text-decoration:none!important;}
         /*STYLES*/
         table[class=full] { width: 100%; clear: both; }
         /*IPAD STYLES*/
         @media only screen and (max-width: 640px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #0a8cce; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #0a8cce !important;
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 440px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
         img[class=banner] {width: 440px!important;height:220px!important;}
         img[class=colimg2] {width: 440px!important;height:220px!important;}
         
         
         }
         /*IPHONE STYLES*/
         @media only screen and (max-width: 480px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #0a8cce; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #0a8cce !important; 
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 280px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
         img[class=banner] {width: 280px!important;height:140px!important;}
         img[class=colimg2] {width: 280px!important;height:140px!important;}
         td[class=mobile-hide]{display:none!important;}
         td[class="padding-bottom25"]{padding-bottom:25px!important;}        
         }
      </style>
   </head>
   <body>
<!-- Start of preheader -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader" >
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="20" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <tr>
                                 <td>
                                    <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                                       	<tbody>
                                          	<tr>
                                             	<td st-title="fulltext-heading" style="font-family: Helvetica, arial, sans-serif; font-size: 40px; color: #333333; line-height: 30px; text-align:center;">
                                                   <b>Faveo</b>HELPDESK
                                              	</td>
                                          	</tr>
                                          	<tr>
                                             	<td st-title="fulltext-heading" style="font-family: Helvetica, arial, sans-serif; font-size: 20px; color: #333333; line-height: 30px; text-align:center;">
                                                   Daily Report
                                              	</td>
                                          	</tr>
                                       	</tbody>
                                    </table>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of preheader -->       
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                
                  <tr>
                     <td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   
<!-- 2columns -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="2columns">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table bgcolor="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <tr>
                                 <td>
                                    <table width="600" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->
                                                <table width="600" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                                   <tbody>
                                                      <!-- Content -->
                                                      <tr>
                                                         <td>
                                                            <table width="600" align="center" border="0" cellpadding="20" cellspacing="0" class="devicewidthinner">
                                                               <tbody style="margin-left:100px;">
                                                                  <tr>
                                                                     <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; line-height:24px;" st-title="2coltitle1">
                                                                        Hi {!! $name !!}
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; line-height:24px; color: #666666;" st-conteent="2colcontent1">
                                                                        Below mentioned is daily report for {!! $company !!}.
                                                                     </td>
                                                                  </tr>
                                                               </tbody>
                                                            </table>
                                                         </td>
                                                      </tr>
                                                      <!-- end of Content -->
                                                      <!-- end of content -->
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                    <!-- end of right column -->
                                 </td>
                              </tr>
                              
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of 2 columns -->

<!-- Start Full Text -->      
<?php 
foreach ($depts as $dept) {
	$created  =  DB::table('tickets')->select('created_at')->where('dept_id','=',$dept->id)->where('team_id','=',$team_id)->where('created_at','LIKE','%'.$day1.'%')->count();

	$closed  =  DB::table('tickets')->where('dept_id','=',$dept->id)->where('team_id','=',$team_id)->where('closed_at','LIKE','%'.$day1.'%')->count();

	$inprogress = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept->id)->where('team_id','=',$team_id)->where('status', '=', 1)->count();

	$overdues = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept->id)->where('team_id','=',$team_id)->where('status', '=', 1)->get();

	$i = 0;
	foreach ($overdues as $overdue) {
		$sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('id','=',$overdue->sla)->first();
		$ovdate = $overdue->created_at;
		$new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan->grace_period)).'<br/><br/>';
		if(date('Y-m-d H:i:s') > $new_date){
			$i++;
		}
	}
	?>
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                             
                              <tr>
                                 <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                             
                              <tr>
                                 <td>
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="1" class="devicewidthinner">
                                       <tbody>
                                           
                                           <!--Table Heading--> 
                                           <tr>
                                               <td st-title="fulltext-heading" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; color: #333333; text-align:center; line-height: 30px;">
                                                   {!! $dept->name !!}
                                               </td>
                                           </tr><!--Table Heading-->
                                        <tr>
                                          
                                            <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; line-height:24px;"> 
                                            <table style="width:100%">
                                                <tr>
                                                	<td><b>Opened</b></td>
                                                    <td>{!! $created !!}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Closed</b></td>
                                                    <td>{!! $closed !!}</td>
                                                </tr>
                                                
                                                <tr>
                                                	<td><b>Inprogress</b></td>
                                                    <td>{!! $inprogress !!}</td>
                                                </tr>
                                                <tr>
                                                	<td><b>Overdue</b></td>
                                                    <td>{!! $i !!}</td>
                                                </tr>
                                                </table>
                                            </td>
                                        </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<?php } ?>
<!-- end of full text -->
<!-- 2columns -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="2columns">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table bgcolor="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <tr>
                                 <td>
                                    <table width="600" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- Spacing -->
                                          <tr>
                                             <td width="100%" height="20"></td>
                                          </tr>
                                          <!-- Spacing -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->
                                                <table width="600" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                                   <tbody>
                                                      <!-- Content -->
                                                      <tr>
                                                         <td>
                                                            <table width="600" align="center" border="0" cellpadding="20" cellspacing="0" class="devicewidthinner">
                                                               <tbody>
                                                                  <tr>
                                                                     <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; line-height:24px; color: #666666;" st-conteent="2colcontent1">
                                                                        We should all work hard to guarantee that all tickets are being addressed in a timely manner. 
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; line-height:24px; color: #666666;" st-conteent="2colcontent1">
                                                                        Thank You,
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; line-height:24px; color: #666666;" st-conteent="2colcontent1">
                                                                        Kind Regards,
                                                                     </td>
                                                                   </tr>
                                                                   <tr>
                                                                     <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; line-height:24px; color: #666666;" st-conteent="2colcontent1">
                                                                        {!! $company !!}
                                                                     </td>
                                                                  	</tr>
                                                               </tbody>
                                                            </table>
                                                         </td>
                                                      </tr>
                                                      <!-- end of Content -->
                                                      <!-- end of content -->
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                    <!-- end of left column -->
                                    <!-- end of right column -->
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="10"></td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of 2 columns -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:0px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   

<!-- Start of Postfooter -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="postfooter" >
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="20" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <tr>
                           		<td valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 14px;color: #666666; text-align:center;" st-content="postfooter">
                                    Powered by <a href="#" style="text-decoration: none; color: #0a8cce">Faveo</a>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="20"></td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of postfooter -->
   
   </body>
   </html>










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
            <strong>Hi {!! $name !!},</strong> <br> Below mentioned are your daily report for your {!! $company !!}.
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
<?php 
foreach ($depts as $dept) {
   $created  =  DB::table('tickets')->select('created_at')->where('dept_id','=',$dept->id)->where('team_id','=',$team_id)->where('created_at','LIKE','%'.$day1.'%')->count();

   $closed  =  DB::table('tickets')->where('dept_id','=',$dept->id)->where('team_id','=',$team_id)->where('closed_at','LIKE','%'.$day1.'%')->count();

   $inprogress = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept->id)->where('team_id','=',$team_id)->where('status', '=', 1)->count();

   $overdues = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$dept->id)->where('team_id','=',$team_id)->where('status', '=', 1)->get();

   $i = 0;
   foreach ($overdues as $overdue) {
      $sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('id','=',$overdue->sla)->first();
      $ovdate = $overdue->created_at;
      $new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan->grace_period)).'<br/><br/>';
      if(date('Y-m-d H:i:s') > $new_date){
         $i++;
      }
   }
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
        <?php  } ?>
        
        
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
  <tr>

  </tr>

</table>


</body>
</html>
