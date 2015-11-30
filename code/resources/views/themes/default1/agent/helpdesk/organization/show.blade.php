@extends('themes.default1.agent.layout.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('organizations')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
{{-- <div><h1 style="margin-top:-10px;margin-bottom:-10px;">Organization Profile</h1></div>
<a href="{{route('organizations.edit', $orgs->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
 --}}
<div class="box-header" style="margin-top:-15px;margin-bottom:-15px;"><h3 class="box-title">{!! Lang::get('lang.organization_profile') !!}</h3><a href="{{route('organizations.edit', $orgs->id)}}" class="btn btn-info btn-sm btn-flat pull-right"><i class="fa fa-edit" style="color:black;"> </i> {!! Lang::get('lang.edit') !!}</a></div>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

<div class="row">

<?php  $org_hd = App\Model\helpdesk\Agent_panel\Organization::where('id','=',$orgs->id)->first();  ?>
<div id="alert-success" class="alert alert-success alert-dismissable" style="display:none;">
        <i class="fa  fa-check-circle"> </i> <b> Success <span id="get-success"></span></b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
        <div class="col-md-4">
                <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua">
                  <h3 class="widget-user-username">{{$orgs->name}}</h3>
                  <h5 class="widget-user-desc">{!! $orgs->website !!}</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        @if($orgs->phone)<li><a>
                        <b>{!! Lang::get('lang.phone') !!}</b>  
                        <span class="pull-right"> {{$orgs->phone}}</span></a></li>@endif
                        @if($orgs->address)<li><a>
                        <b>{!! Lang::get('lang.address') !!}</b>  
                        <br/> <center>{!! $orgs->address !!}</center></a></li>@endif
                        @if($orgs->internal_notes)<li><a>
                        <b>{!! Lang::get('lang.internal_notes') !!}</b>  
                        <br/> <center>{!! $orgs->internal_notes !!}</center></a></li>@endif
                    </ul>
                    <button data-toggle="modal" data-target="#assign_head" id="button_select" class="btn btn-primary btn-flat btn-block">{!! Lang::get('lang.select_department_manager') !!}</button>
                </div>
              </div>

              <div id="refresh"> 
              @if($org_hd->head > 0)
              <?php $users = App\User::where('id','=',$org_hd->head)->first();  ?>
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-yellow">
                  <div class="widget-user-image">
                    <img class="img-circle"  src="{{ Gravatar::src( $users->email) }}" alt="User Avatar">
                  </div><!-- /.widget-user-image -->
                  <h3 class="widget-user-username">{!! $users->user_name !!}</h3>
                  <h5 class="widget-user-desc">{!! Lang::get('lang.organization-s_head') !!}</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">{!! Lang::get('lang.e-mail') !!} <span class="pull-right">{!! $users->email !!}</span></a></li>
                    <li><a href="#">{!! Lang::get('lang.phone') !!} <span class="pull-right">{!! $users->phone_number !!}</span></a></li>
                  </ul>
                </div>
              </div>
              
              @endif
              </div>

              

        </div>
        <div class="col-md-8">
            <div class="box box-primary">
            <?php
                $user_orgs = App\Model\helpdesk\Agent_panel\User_org::where('org_id','=',$orgs->id)->paginate(5);
                ?>
                <div class="box-header">
                    <h3 class="box-title">{!! Lang::get('lang.users_of') !!} {{$orgs->name}}</h3>
                    <div class="pull-right" style="margin-top:-25px;margin-bottom:-25px;">
                        <?php echo $user_orgs->setPath('../organizations/'.$orgs->id)->render(); ?>
                    </div>
                </div>   
                <hr style="margin-top:0px;margin:bottom:0px;"> 
                
                <div class="box-body">
                        <table class="table table-hover table-bordered">
                            <tbody><tr>
                              <th>{!! Lang::get('lang.name') !!}</th>
                              <th>{!! Lang::get('lang.email') !!}</th>
                              <th>{!! Lang::get('lang.phone') !!}</th>
                              <th>{!! Lang::get('lang.status') !!}</th>
                              <th>{!! Lang::get('lang.ban') !!}</th>
                            </tr>

                            @foreach($user_orgs as $user_org)
                            <?php 
                            $user_detail = App\User::where('id','=',$user_org->user_id)->first();
                             ?>
                            <tr>
                              <td>{!! $user_detail->user_name !!}</td>
                              <td>{!! $user_detail->email !!}</td>
                              <td>{!! $user_detail->phone_number !!}</td>
                                @if($user_detail->active == 1)
                                    <td><span class="label label-success">{!! Lang::get('lang.active') !!}</span></td>
                                @elseif($user_detail->active == 0)
                                    <td><span class="label label-warning">{!! Lang::get('lang.inactive') !!}</span></td>
                                @endif
                              <td>{!! $user_detail->ban !!}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>    
                <div class="box-footer">
                    
                </div>                    
            </div>
        </div>
</div>


<!-- Organisation Assign Modal -->
    <div class="modal fade" id="assign_head">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::model($orgs->id, ['id'=>'org_head','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('lang.assign') !!}</h4>
                </div>
                <div id="assign_alert" class="alert alert-success alert-dismissable" style="display:none;">
                    <button id="assign_dismiss" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>Alert!</h4>
                    <div id="message-success1"></div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6" id="assign_loader" style="display:none;">
                            <img src="{{asset("lb-faveo/dist/img/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                    </div>
                    <div id="assign_body">
                        <p>{!! Lang::get('lang.please_select_an_user') !!}</p>
                        <select id="user" class="form-control" name="user">
<?php
$org_heads = App\Model\helpdesk\Agent_panel\User_org::where('org_id','=',$orgs->id)->get();
?>
                            <optgroup label="Select Organizations">
                                @foreach($org_heads as $org_head)
                                <?php  $user_org_heads = App\User::where('id','=',$org_head->user_id)->first();  ?>
                                    <option  value="{{$user_org_heads->id}}">{!! $user_org_heads->user_name !!}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis4">{!! Lang::get('lang.close') !!}</button>
                    <button type="submit" class="btn btn-success pull-right" id="submt2">{!! Lang::get('lang.assign') !!}</button>
                </div>
                {!! Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


<script type="text/javascript">
// Assign a ticket
    jQuery(document).ready(function($) {
// create org
        $('#org_head').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../head-org/{!! $orgs->id !!}",
                dataType: "html",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#assign_body").hide();
                    $("#assign_loader").show();
                },
                success: function(response) {
                    $("#assign_loader").hide();
                    $("#assign_body").show();
                    
                    if (response == 1) {
                        message = "Organization head added Successfully."
                        $("#dismiss").trigger("click");
                        $("#refresh").load("../organizations/{!! $orgs->id !!}  #refresh");
                        // $("#refresh2").load("../thread/1  #refresh2");
                        // $("#show").show();
                        $("#alert-success").show();
                        $('#get-success').html(message);
                        setInterval(function(){$("#alert-success").hide(); },4000);   
                    }
                }
            })
            return false;
        });
    });

</script>

@stop

<!-- /content -->