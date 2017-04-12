@extends('themes.default1.agent.layout.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('user')
class="active"
@stop

@section('HeadInclude')
<style>
.tooltip1 {
    position: relative;
    /*display: inline-block;*/
    /*border-bottom: 1px dotted black;*/
}

.tooltip1 .tooltiptext {
    visibility: hidden;
    width: 100%;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.tooltip1:hover .tooltiptext {
    visibility: visible;
}
</style>
@stop
<!-- header -->
@section('PageHeader')

@if($users->role == 'user')
<h1>{!! Lang::get('lang.user_profile') !!} </h1>

@elseif($users->role == 'agent')
<h1>{!! Lang::get('lang.agent_profile') !!} </h1>
@endif
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')

@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<!-- success message -->
<div id="alert-success" class="alert alert-success alert-dismissable" style="display:none;">
    <i class="fa fa-check-circle"> </i> <b>  <span id="get-success"></span></b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div>
<!-- INfo message -->
<div id="alert-danger" class="alert alert-danger alert-dismissable" style="display:none;">
    <i class="fa fa-ban"> </i> <b>  <span id="get-danger"></span></b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div>
@if(Session::has('success1'))
<div id="success-alert" class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"> </i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success1')}}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails1'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!} ! </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails1')}}
</div>
@endif
<?php $table = \Datatable::table()
                ->addColumn(
                        "", Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();?>
<div class="row">
    <div class="col-md-3">
        <div class="box box-primary" >
            <div class="box-header">
                <!-- <a href="{{route('user.edit', $users->id)}}" data-toggle="tooltip" data-placement="left" class="pull-right" title="{!! Lang::get('lang.edit') !!}"><i class="fa fa-edit"></i></a> -->
            </div>
            <div class="box-body ">
                <div>
                    <center>
                        <img src="{{ $users->profile_pic }}" class="img-circle" alt="User Image" style="border:3px solid #CBCBDA;padding:3px;">  
                        @if($users->first_name || $users->last_name)
                        <?php $name_of_user = $users->first_name.' '.$users->last_name; ?>
                        @else
                        <?php  $name_of_user = $users->user_name; ?>
                        @endif
                        <h4 class="" title="{{$name_of_user}}">{{str_limit($name_of_user, 25)}}</h4>
                    </center>
                </div>
            </div>
            @if($users->user_name)
            <div class="box-footer">
                <b>{{Lang::get('lang.user_name')}}</b>
                <a class="pull-right" title="{{$users->user_name}}" href="{{route('user.show', $users->id)}}">
                    {{str_limit($users->user_name,10) }}
                </a>
            </div>
            @endif
            <div class="box-footer">
                <b>{{Lang::get('lang.email')}}</b>
                <a class="pull-right" title="{{$users->email}}" href="{{route('user.show', $users->id)}}">
                    {{str_limit($users->email,10) }}
                </a>
            </div>
             @if($users->is_delete != '1')
            @if($users->role=='user')
            <div class="box-footer">
                <div id="refresh-org">
                    <?php
                    $user_org = App\Model\helpdesk\Agent_panel\User_org::where('user_id', '=', $users->id)->first();
                    ?>
                    @if($user_org == null)
                    <b>{!! Lang::get('lang.organization') !!}</b>
                    <a href="" class="pull-right"  data-toggle="modal" data-target="#assign"><i class="fa fa-hand-o-right" style="color:orange;"> </i> {!! Lang::get('lang.assign') !!} </a>
                    <a href="" data-toggle="modal" data-target="#create_org" class="pull-right"> {{Lang::get('lang.create')}} |&nbsp;</a>
                    @endif
                    @if($user_org != null)
                    <?php
                    $org_id = $user_org->org_id;
                    $organization = App\Model\helpdesk\Agent_panel\Organization::where('id', '=', $org_id)->first();
                    ?>
                    <b>{!! Lang::get('lang.organization') !!}</b>

                    &nbsp;&nbsp;&nbsp;

                    <a href=""   data-toggle="modal" data-target="#editassign" title="{{$organization->name}}"> <span style="color:green;">{{str_limit($organization->name,15)}}</span> </a>


                    <a class="pull-right" href="#" data-toggle="modal" data-target="#{{$org_id}}delete" title="{!! Lang::get('lang.remove') !!}"><i class="fa fa-times" style="color:red;"> </i></a> 
                    <div class="modal fade" id="{{$org_id}}delete">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Remove user from Organization</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to Remove ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    {!! link_to_route('removeuser.org','Remove User',[$org_id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
                                </div>
                            </div> 
                        </div>
                    </div> 
                    @endif

                </div>
            </div>
            @endif

            <div class="box-footer">
                <b>{{Lang::get('lang.role')}}</b>
                <a class="pull-right">

                    <span style="color:green;">{!! $users->role !!}</span>

                </a>
            </div>

            <div class="box-footer">
                <b>{{Lang::get('lang.status')}}</b>
                <a class="pull-right">
                    @if($users->active == '1')
                    <span style="color:green;"> <span class="glyphicon glyphicon-ok-circle"></span>  <span class="glyphicon glyphicon-user"></span></span>
                    @else
                    <span style="color:red;"><span class="glyphicon glyphicon-ban-circle"></span><span class="glyphicon glyphicon-user"></span></span>
                    @endif
                </a>
            </div>            
            @if($users->country_code)
            <div class="box-footer">
                <b>{{Lang::get('lang.country_code')}}</b>
                <a class="pull-right"> {{$users->country_code}}</a>
            </div>
            @endif
            @if($users->ext)
            <div class="box-footer">
                <b>{{Lang::get('lang.ext')}}</b>
                <a class="pull-right"> {{$users->ext}}</a>
            </div>
            @endif
            @if($users->mobile)
            <div class="box-footer">
                <b>{{Lang::get('lang.mobile')}}</b>
                <a class="pull-right"> {{$users->mobile}}</a>
            </div>
            @endif
            @if($users->phone_number)
            <div class="box-footer">
                <b>{{Lang::get('lang.phone')}}</b>
                <a class="pull-right"> {{$users->phone_number}}</a>
            </div>
            @endif
            @if($users->internal_note)
            <div class="box-footer">
                <b>{{Lang::get('lang.internal_notes')}}</b>
                <br/>
                {!! $users->internal_note !!}
            </div>
            @endif
            @if($users->twitterLink()!=="")
            <div class="box-footer">
                {!! $users->twitterLink() !!}
            </div>
            @endif
             @endif
        </div>
    </div>
    <div class="col-md-9" style="margin-left:-10px;">


        <!-- Delete -->
        <form action="{!!URL::route('user.post.delete', $users->id)!!}" method="post" role="form">
            <div class="modal fade" id="addNewCategoryModal3" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            @if($users->role=='user')
                            <h4 class="modal-title" id="titleLabel">{{Lang::get('lang.delete_user')}}</h4>
                            @endif 
                            @if($users->role=='agent')
                            <h4 class="modal-title" id="titleLabel">{{Lang::get('lang.delete_agent')}}</h4>
                            @endif


                        </div>

                        <div class="modal-body">
                            What should be done with content owned by this user?</br>

                            <!-- <select name="type_of_delete" class="form-control">
                            <option value="ban_delete">Ban and delete </option>
                            <option value="delete">Delete</option>
                            </select>
 -->





                            <?php $user = App\User::where('id', $users->id)->first(); ?>
                            @if($user->role == 'agent')
                            {!! Form::label('delete_all_content',Lang::get('lang.delete_all_content')) !!} <span class="text-red"> *</span>
                            <?php
                            $open = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', $users->id)->where('status', '=', '1')->get();
                            ?>
                            <?php $user = App\User::where('id', $users->id)->first(); ?>
                            <?php
                            $open = count(App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', $users->id)->where('status', '=', '1')->get());
                            ?>

                            @if(!$open)
                            
                            @elseif($open)
                            <input type="checkbox" id="delete_checkbox" name="delete_all" value="1">

                            @endif
                            @endif
                            <!--    Hi Admin 
                                @if($users->role=='agent')  
                                Assign  tickets of the agent will delete?
                                Create ticket By agent Will Delete?
                                @elseif($users->role=='user')
                                Crete ticket by user Will Delete?
                                @endif -->
                            <!--  -->
                            <?php $user = App\User::where('id', $users->id)->first(); ?>
                            <?php
                            $open = count(App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', $users->id)->where('status', '=', '1')->get());
                            $counted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '3')->get());
                            $deleted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '5')->get());
                            ?>
                            @if($open>0 && $user->role == 'agent')  
                            <div id="delete_assign_body">
                                <p>{!! Lang::get('lang.whome_do_you_want_to_assign_ticket') !!}?</p>
                                <select id="asssign" class="form-control" name="assign_to">
                                    <?php
                                    $assign = App\User::where('role', '!=', 'user')->get();
                                    $count_assign = count($assign);
                                    $teams = App\Model\helpdesk\Agent\Teams::all();
                                    $count_teams = count($teams);
                                    ?>
                                    <!--    <optgroup label="Teams ( {!! $count_teams !!} )">
                                           @foreach($teams as $team)
                                           <option  value="team_{{$team->id}}">{!! $team->name !!}</option>
                                           @endforeach
                                       </optgroup> -->
                                    <optgroup label="Agents ( {!! $count_assign !!} )">
                                        @foreach($assign as $user)
                                        <option  value="user_{{$user->id}}">{{$user->first_name." ".$user->last_name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            @endif

                        </div>

                    </div>

                    <div class="box-footer">
                        {!! Form::submit(Lang::get('lang.confirm_deletion'),['class'=>'btn btn-primary'])!!}
                    </div>

                </div>
            </div>
        </form>
    </div>
    <!-- Role -->
    <!-- Admin -->
    <form action="{!!URL::route('user.post.rolechangeadmin', $users->id)!!}" method="post" role="form">
        <div class="modal fade" id="addNewCategoryModal4" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="titleLabel">{{Lang::get('lang.role_change')}}:</h4>
                    </div>

                    <div class="modal-body">

                        <?php
                        $groups = App\Model\helpdesk\Agent\Groups::all(array('id', 'name'));
                        $departments = App\Model\helpdesk\Agent\Department::all(array('id', 'name'));
                        ?>

                        <!-- <div class="col-xs-4 form-group {{ $errors->has('group') ? 'has-error' : '' }}"> -->
                        {!! Form::label('assign_group',Lang::get('lang.assigned_group')) !!} <span class="text-red"> *</span>
                        {!!Form::select('group',[Lang::get('lang.groups')=>$groups->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
                        <!-- </div> -->
                        <!-- primary dept -->
                        <!-- <div class="col-xs-4 form-group {{ $errors->has('primary_department') ? 'has-error' : '' }}"> -->
                        {!! Form::label('primary_dpt',Lang::get('lang.primary_department')) !!} <span class="text-red"> *</span>
                        {!! Form::select('primary_department', [Lang::get('lang.departments')=>$departments->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
                        <!-- </div> -->

                    </div>

                </div>
                <div class="box-footer">
                    {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
                </div>

            </div>
        </div>
    </form>
    <!-- user -->
    <form action="{!!URL::route('user.post.rolechangeuser', $users->id)!!}" method="post" role="form">
        <div class="modal fade" id="addNewCategoryModal2" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="titleLabel">{{Lang::get('lang.role_change')}}:</h4>
                    </div>

                    <div class="modal-body">


                        Are u sure?
                        Role Change Agent To User

                    </div>

                </div>
                <div class="box-footer">
                    {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
                </div>

            </div>
        </div>
    </form>
    <!-- agent -->
    <form action="{!!URL::route('user.post.rolechangeagent', $users->id)!!}" method="post" role="form">
        <div class="modal fade" id="addNewCategoryModal1" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="titleLabel">{{Lang::get('lang.role_change')}}:</h4>
                    </div>

                    <div class="modal-body">

                        <?php
                        $groups = App\Model\helpdesk\Agent\Groups::all(array('id', 'name'));
                        $departments = App\Model\helpdesk\Agent\Department::all(array('id', 'name'));
                        ?>

                        <!-- <div class="col-xs-4 form-group {{ $errors->has('group') ? 'has-error' : '' }}"> -->
                        {!! Form::label('assign_group',Lang::get('lang.assigned_group')) !!} <span class="text-red"> *</span>
                        {!!Form::select('group',[Lang::get('lang.groups')=>$groups->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
                        <!-- </div> -->
                        <!-- primary dept -->
                        <!-- <div class="col-xs-4 form-group {{ $errors->has('primary_department') ? 'has-error' : '' }}"> -->
                        {!! Form::label('primary_dpt',Lang::get('lang.primary_department')) !!} <span class="text-red"> *</span>
                        {!! Form::select('primary_department', [Lang::get('lang.departments')=>$departments->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
                        <!-- </div> -->

                    </div>

                </div>
                <div class="box-footer">
                    {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
                </div>

            </div>
        </div>
    </form>
    <!-- Change password -->

    <div class="modal fade" id="addNewCategoryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="titleLabel">{{Lang::get('lang.change_password')}}:</h4>
                </div>

                <div class="modal-body">

                    <button class="btn btn-warning pull-right" id="changepassword">{{Lang::get('lang.password_generator')}}</button>

                    <br/>
                    <form name="myForm" action="{!!URL::route('user.post.changepassword', $users->id)!!}" method="post" role="form" onsubmit="return validateForm()">
                        <div class="form-group">

                            <!-- <div class="form-group {{ $errors->has('change_password') ? 'has-error' : '' }}"> -->
                            {!! Form::label('New password',Lang::get('lang.new_password')) !!} <span class="text-red"> *</span>
                            <input type="text" class="form-control" name="change_password" id="changepassword1" >

                            <p id="demo" style="color:red"></p>

                            <!-- </div> -->

                        </div>

                </div>

            </div>
            <div class="box-footer">
                {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary','id'=>'savepassword'])!!}
            </div>
            </form>
        </div>
    </div>

    <!-- Restore -->
      <!-- Admin -->
    <form action="{!!URL::route('user.restore', $users->id)!!}" method="post" role="form">
        <div class="modal modal-fade" id="addNewCategoryModal8" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="titleLabel">{{Lang::get('lang.restore')}}:</h4>
                    </div>

                    <div class="modal-body">

                     Are you Sure?

                    </div>

                </div>
                <div class="box-footer">
                    {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
                </div>

            </div>
        </div>
    </form>
    <script>
$(document).ready(function(){ 
        $("#delete_checkbox").click(function() {
            // alert('ok');

            $("#delete_assign_body").toggle();

        });
        });

    </script>

    <script>
        function validateForm() {
            var x = document.forms["myForm"]["change_password"].value;
            if (x == null || x == "") {
                // alert("please enter your password");
                document.getElementById("demo").innerHTML = "Enter Password";
                return false;
            }
        }
    </script>
    <script>

        $('#changepassword').click(function() {
            $.ajax({
                type: 'get',
                url: '{{route("user.changepassword")}}',
                // data: {settings_approval: settings_approval},
                success: function(result) {
                    // with('success', Lang::get('lang.approval_settings-created-successfully'));
                    // alert("Hi, testing");
                    // var x =result;
                    var sum = result;

                    document.getElementById("changepassword1").value = sum;

                }
            });

        });

    </script>
    <div class="col-md-9" >
        {{-- detals table starts --}}
        <?php
        $user = App\User::where('id', $users->id)->first();
        // dd( $user->role);

        if ($users->role != 'user') {
            $open = count(App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', $users->id)->where('status', '=', '1')->get());
            $tickets = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', $users->id)->where('status', '=', '3')->orderBy('id', 'DESC')->paginate(20);
            $counted = count(App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', $users->id)->where('status', '=', '3')->get());
            $deleted = count(App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', $users->id)->where('status', '=', '5')->get());
        }
        if ($users->role == 'user') {
            $open = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '1')->get());
            $tickets = App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '3')->orderBy('id', 'DESC')->paginate(20);
            $counted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '3')->get());
            $deleted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '5')->get());
            // dd($deleted);
        }
        ?>
        <div class="row" >
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <div class="box box-primary">

                        </br>
                        <div style="margin-left:1%;">
                            @if($users->is_delete != '1')
                            @if(Auth::user()->role == 'admin')

                            @if($users->role == 'user')
                            <div class="btn-group">
                                <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal1">{{Lang::get('lang.change_role_to_agent')}}</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal4">{{Lang::get('lang.change_role_to_admin')}}</button>
                            </div>
                            @else
                            <div class="btn-group">
                                <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal2">{{Lang::get('lang.change_role_to_user')}}</button>
                                <!-- <button type="button" class="btn btn-primary" id="role_user">Change Role TO User</button> -->
                            </div>
                            <div class="btn-group">
                                <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal4">{{Lang::get('lang.change_role_to_admin')}}</button>
                            </div>
                            @endif
                            @endif
                            @if(Auth::user()->role == 'admin')
                            <a href="{{route('user.edit', $users->id)}}"><button type="button"  href="{{route('user.edit', $users->id)}}" class="btn btn-primary btn-sm">{{Lang::get('lang.edit')}}</button></a>
                            <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal">{{Lang::get('lang.change_password')}}</button>
                            <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal3">{{Lang::get('lang.delete')}}</button>
                           
                            @endif

                            @if(Auth::user()->role == 'agent')
                            @if($users->role == 'user')
                            <a href="{{route('user.edit', $users->id)}}"><button type="button"  href="{{route('user.edit', $users->id)}}" class="btn btn-primary btn-sm">{{Lang::get('lang.edit')}}</button></a>
                            <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal">{{Lang::get('lang.change_password')}}</button>
                            <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal3">{{Lang::get('lang.delete')}}</button>
                            
                            @endif
                            @endif
                            @else
                            @if(Auth::user()->role == 'admin')
                            <div id="page" class="hfeed site">
    <article class="hentry error404 text-center">
        <h1 class="error-title"><i class="fa fa-trash text-info" style="color: grey"></i><span class="visible-print text-danger">0</span></h1>
        <h2 class="entry-title text-muted">{!! Lang::get('lang.user-account-is-deleted') !!}</h2>
        <div class="entry-content clearfix">
            <p class="lead">{!! Lang::get('lang.delete-account-caution-info') !!}</p>
            <p><button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#addNewCategoryModal8">{{Lang::get('lang.restore-user')}}</button></a></p>
        </div><!-- .entry-content -->
    </article><!-- .hentry -->
</div><!-- #page -->
                            <div class="row">
                                <div class="col-md-12">
                                    
                                </div>
                            </div>
                            @endif


                            @if(Auth::user()->role == 'agent')
                            @if($users->role == 'user')
                            This is a deleted contact 
                            <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal8">{{Lang::get('lang.restore')}}</button>
                            @elseif($users->role == 'agent')
                            This is a deleted contact 
                            @endif
                            @endif

<!-- 
                           This was Deleted profile <a href="{{route('user.restore', $users->id)}}"><button type="button"  href="{{route('user.restore', $users->id)}}" class="btn btn-info btn-xl">{{Lang::get('lang.restore')}}</button></a> -->
                            @endif
                        </div>


@if($users->is_delete != '1')
                        <div style="padding:1%;">
                            <ul class="nav nav-tabs" >

                                </br>
                                <li class="active"><a href="#tab_1" id="open_tab" data-toggle="tab">{!! Lang::get('lang.open_tickets') !!} ({{$open}})</a></li>
                                <li><a href="#tab_2" id="closed_tab" data-toggle="tab">{!! Lang::get('lang.closed_tickets') !!} ({{$counted}})</a></li>
                                <li><a href="#tab_3" id="deleted_tab" data-toggle="tab">{!! Lang::get('lang.deleted_tickets') !!} ({{$deleted}})</a></li>
                            </ul>
                            
                            <div class="tab-content no-padding">
                                    @if(Session::has('success'))
                                    <div id="success-alert" class="alert alert-success alert-dismissable">
                                        <i class="fa  fa-check-circle"> </i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        {{Session::get('success')}}
                                    </div>
                                    @endif
                                    <!-- failure message -->
                                    @if(Session::has('fails'))
                                    <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!} ! </b>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        {{Session::get('fails')}}
                                    </div>
                                    @endif
                                    {!! Form::open(['id'=>'modalpopup', 'route'=>'select_all','method'=>'post']) !!}
                                        <div class="mailbox-controls">
                                            <!-- Check all button -->
                                            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                                            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}" id="delete" onclick="appendValue(id)">
                                            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}"  id="close" onclick="appendValue('close')">
                                            <input type="submit" class="btn btn-default text-blue btn-sm" name="submit" value="{!! Lang::get('lang.open') !!}" id="open" onclick="appendValue(id)" style="display: none;">
                                            <div class="pull-right">
                                            </div>
                                            <!--</div>-->
        <div id="more-option" class="btn-group">
            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" id="d2">
                <i class="fa fa-reorder" style="color:teal;"> </i>
                    {!! Lang::get('lang.sort-by') !!} <span class="caret"></span>
            </button>
                <ul  class="dropdown-menu pull-right">
                    <li data-toggle="modal" data-target="#ChangeOwner"><a href="#" class="toggle-vis" data-column="7"><i class="fa fa-plus-square-o" style="color:green;"> </i>{!!Lang::get('lang.created-at')!!}</a></li>
                </ul>
        </div>
                                        </div>
                                <div class="tab-pane active" id="tab_1">
                                </div>
                                <div class="tab-pane active" id="tab_2">
                                </div>
                                <div class="tab-pane active" id="tab_3">
                                </div>
                                <div class="box-body mailbox-messages"  id="refresh">
                                        <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>{!! Lang::get('lang.loading') !!}...</b></p>
                                        <!-- table -->

                                        {!!$table->render('vendor.Chumper.template')!!}

                                </div><!-- /.mail-box-messages -->
                        </div><!-- /.col -->          
                    </div>
                </div>
                {!!Form::close()!!}

                <!-- /.row -->
            </div>
        </div>
         @endif
          @if($users->is_delete != '1')
        
            <div class="col-md-12">
                <link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
                <div class="box box-info">
                    <div class="box-header with-border">
                        @if($users->role=='user')
                        <h3 class="box-title">{!! Lang::get('lang.user_report') !!}</h3>
                        @endif 
                        @if($users->role=='agent')
                        <h3 class="box-title">{!! Lang::get('lang.agent_report') !!}</h3>
                        @endif

                    </div>
                    <div class="box-body">
                        <form id="foo">
                            <div  class="form-group">
                                <div class="row">
                                    <div class='col-sm-3'>
                                        {!! Form::label('date', Lang::get("lang.start_date").':') !!}
                                        {!! Form::text('start_date',null,['class'=>'form-control','id'=>'datepicker4'])!!}
                                    </div>
                                    <?php
                                    $start_date = App\Model\helpdesk\Ticket\Tickets::where('id', '=', '1')->first();
                                    if ($start_date != null) {
                                        $created_date = $start_date->created_at;
                                        $created_date = explode(' ', $created_date);
                                        $created_date = $created_date[0];
                                        $start_date = date("m/d/Y", strtotime($created_date . ' -1 months'));
                                    } else {
                                        $start_date = date("m/d/Y", strtotime(date("m/d/Y") . ' -1 months'));
                                    }
                                    ?>
                                    <script type="text/javascript">
                                        $(function() {
                                            var timestring1 = "{!! $start_date !!}";
                                            var timestring2 = "{!! date('m/d/Y') !!}";
                                            $('#datepicker4').datetimepicker({
                                                format: 'DD/MM/YYYY',
                                                minDate: moment(timestring1).startOf('day'),
                                                maxDate: moment(timestring2).startOf('day')
                                            });
                                            //                $('#datepicker').datepicker()
                                        });
                                    </script>
                                    <div class='col-sm-3'>
                                        {!! Form::label('start_time', Lang::get("lang.end_date").':') !!}
                                        {!! Form::text('end_date',null,['class'=>'form-control','id'=>'datetimepicker3'])!!}
                                    </div>
                                    <script type="text/javascript">
                                        $(function() {
                                            var timestring1 = "{!! $start_date !!}";
                                            var timestring2 = "{!! date('m/d/Y') !!}";
                                            $('#datetimepicker3').datetimepicker({
                                                format: 'DD/MM/YYYY',
                                                minDate: moment(timestring1).startOf('day'),
                                                maxDate: moment(timestring2).startOf('day')
                                            });
                                        });
                                    </script>
                                    <div class='col-sm-3'>
                                        {!! Form::label('filter', Lang::get("lang.filter").':') !!}<br>
                                        <input type="submit" value="{!! Lang::get('lang.submit') !!}" class="btn btn-primary">
                                    </div>
                                    <div class="col-sm-10">
                                        <label class="lead">{!! Lang::get('lang.Legend') !!}:</label>
                                        <div class="row">
                                            <style>
                                                #legend-holder { border: 1px solid #ccc; float: left; width: 25px; height: 25px; margin: 1px; }
                                            </style>

                                            @if($users->role=='user')

                                            <div class="col-md-4"><span id="legend-holder" style="background-color: #6C96DF;"></span>&nbsp; <span class="lead"> <span id="total-created-tickets" ></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.created') !!} </span></div>
                                            @endif 
                                            @if($users->role=='agent')
                                            <div class="col-md-4"><span id="legend-holder" style="background-color: #6C96DF;"></span>&nbsp; <span class="lead"> <span id="total-created-tickets" ></span> {!! Lang::get('lang.assign_tickets') !!}  </span></div>

                                            @endif


                                            <div class="col-md-4"><span id="legend-holder" style="background-color: #6DC5B2;"></span>&nbsp; <span class="lead"> <span id="total-reopen-tickets" class="lead"></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.reopen') !!}  </span></div> 
                                            <div class="col-md-4"><span id="legend-holder" style="background-color: #E3B870;"></span>&nbsp; <span class="lead"> <span id="total-closed-tickets" class="lead"></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.closed') !!}  </span></div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="legendDiv"></div>
                        <div class="chart">
                            <canvas class="chart-data" id="tickets-graph" width="1000" height="250"></canvas>   
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
    
    <!-- END CUSTOM TABS -->
    {{-- MODAL POPUPS --}}
    <div class="modal fade" id="create_org">
        <div class="modal-dialog" style="width:84%;height:70%;">
            <div class="modal-content">
                {!! Form::model($users->id, ['id'=>'form','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidd en="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('lang.create_organization') !!}</h4>
                </div>
                <div class="modal-body">
                    <!-- failure message -->                                
                    <div class="alert alert-danger alert-dismissable" id="alert-danger" style="display:none;"> 
                        <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!} ! <span id="get-danger"></span> </b>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>                              
                    <div class="row" id="hide">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.name') !!}</label>
                                <input type="text" name="name" class="form-control">
                                <spam id="error-name" style="display:none;position:fixed" class="call-out text-red">This is a required field</spam>
                                <spam id="error-name1" style="display:none;position:fixed" class="call-out text-red">! Allready Taken</spam>
                                <br/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.phone') !!}</label>
                                <input type="number" name="phone" class="form-control">
                                <br/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.website') !!}</label>
                                <input type="url" name="website" placeholder="https://www.example.com" class="form-control">
                                <spam id="error-website" style="display:none" class="help-block text-red">! Allready Taken</spam>
                                <br/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.address') !!}</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.internal_notes') !!}</label>
                                <textarea name="internal" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="show2" style="display:none;">
                        <div class="row row-md-12">
                            <div class="col-xs-5">
                            </div>
                            <div class="col-xs-2">
                                <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">
                            </div>
                            <div class="col-xs-5">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis">{!! Lang::get('lang.close') !!}</button>
                    <input type="submit" class="btn btn-primary pull-right" value="{!! Lang::get('lang.update') !!}">
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->   
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-dialog" role="document">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="custom-alert-body" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-left yes" data-dismiss="modal">{{Lang::get('lang.ok')}}</button>
                    <button type="button" class="btn btn-default no">{{Lang::get('lang.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // create org
            var option = null;
            $('#form').on('submit', function() {
                $.ajax({
                    type: "POST",
                    url: "../user-org/{{$users->id}}",
                    dataType: "html",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $("#hide").hide();
                        $("#show2").show();
                    },
                    success: function(response) {
                        $("#show2").hide();
                        $("#hide").show();
                        if (response == 0) {
                            message = "Organization added successfully."
                            $("#dismis").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-success").show();
                            $('#get-success').html(message);
                            setInterval(function() {
                                $("#alert-success").hide();
                            }, 6000);
                            window.location.reload(true);

                        } else {
                            message = response;
                            $("#alert-danger").show();
                            $('#get-danger').html(message);
                        }
                    }
                })
                return false;
            });

            $('#delete').on('click', function () {
                option = 0;
                $('#myModalLabel').html("{{Lang::get('lang.delete-tickets')}}");
            });

            $('#close').on('click', function () {
                option = 1;
                $('#myModalLabel').html("{{Lang::get('lang.close-tickets')}}");
            });

            $('#open').on('click', function () {
                option = 2;
                $('#myModalLabel').html("{{Lang::get('lang.open-tickets')}}");
            });

            $("#modalpopup").on('submit', function (e) {
                e.preventDefault();
                var msg = "{{Lang::get('lang.confirm')}}";
                var values = getValues();
                if (values == "") {
                    msg = "{{Lang::get('lang.select-ticket')}}";
                    $('.yes').html("{{Lang::get('lang.ok')}}");
                    $('#myModalLabel').html("{{Lang::get('lang.alert')}}");
                } else {
                    $('.yes').html("Yes");
                }
                $('#custom-alert-body').html(msg);
                $("#myModal").css("display", "block");
            });

            $(".closemodal, .no").click(function () {
                $("#myModal").css("display", "none");
            });

            $(".closemodal, .no").click(function () {
                $("#myModal").css("display", "none");
            });

            $('.yes').click(function () {
                var values = getValues();
                if (values == "") {
                    $("#myModal").css("display", "none");
                } else {
                    $("#myModal").css("display", "none");
                    $("#modalpopup").unbind('submit');
                    if (option == 0) {
                        $('#delete').click();
                    } else if (option == 1) {
                        $('#close').click();
                    } else {
                        $('#open').click();
                    }
                }
            });

            function getValues() {
                var values = $('.selectval:checked').map(function () {
                    return $(this).val();
                }).get();
                return values;
            }
        });
    </script>
    <!-- Organisation Assign Modal -->
    <div class="modal fade" id="assign">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::model($users->id, ['id'=>'org_assign','method' => 'PATCH'] )!!}
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
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                    </div>
                    <div id="assign_body">
                        <p>{!! Lang::get('lang.please_select_an_organization') !!}</p>

                        <input type="text" id="org" class="form-control" name="org">

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


    <!-- Edit Organisation Assign Modal -->
    <!-- edit assign oranization -->

    <?php
    $assign_org_id = App\Model\helpdesk\Agent_panel\User_org::where('user_id', '=', $users->id)->first();
    if ($assign_org_id) {
        $organization = App\Model\helpdesk\Agent_panel\Organization::where('id', '=', $assign_org_id->org_id)->first();
    }
    ?>
    @if($assign_org_id)

    <div class="modal fade" id="editassign">
        <div class="modal-dialog">

            <div class="modal-content">
                {!! Form::model($users->id, ['id'=>'org_edit_assign','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="editdismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('lang.assign') !!}</h4>
                </div>
                <!--   <div id="assign_alert" class="alert alert-success alert-dismissable" style="display:none;">
                      <button id="assign_dismiss" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <h4><i class="icon fa fa-check"></i>Alert!</h4>
                      <div id="message-success1"></div>
                  </div> -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6" id="assign_loader" style="display:none;">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                    </div>
                    <div id="assign_body">
                        <p>{!! Lang::get('lang.please_select_an_organization') !!}</p>



                        <input type="text" id="editorg" class="form-control" name="org" value="{{$organization->name}}">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis4">{!! Lang::get('lang.close') !!}</button>
                    <button type="submit" class="btn btn-success pull-right" id="submt3">{!! Lang::get('lang.assign') !!}</button>
                </div>
                {!! Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endif
    @endif
    {!! $table->script('vendor.Chumper.tuser-javascript') !!}
    <script type="text/javascript">
        // Assign a ticket
        jQuery(document).ready(function($) {
            // create org
            $('#org_assign').on('submit', function() {
                $.ajax({
                    type: "POST",
                    url: "../user-org-assign/{{$users->id}}",
                    dataType: "html",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $("#hide").hide();
                        $("#show2").show();
                    },
                    success: function(response) {
                        $("#show2").hide();
                        $("#hide").show();

                        if (response == 1) {
                            message = "Organization added successfully."
                            $("#dismiss").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-success").show();
                            $('#get-success').html(message);
                            setInterval(function() {
                                $("#alert-success").hide();
                            }, 4000);
                            window.location.reload(true);
                        }



                        if (response == 0) {
                            message = " Organization not found"
                            $("#dismiss").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-danger").show();
                            $('#get-danger').html(message);
                            setInterval(function() {
                                $("#alert-danger").hide();
                            }, 4000);
                        }

                        if (response == 2) {
                            message = "Select Organization"
                            $("#dismiss").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-danger").show();
                            $('#get-danger').html(message);
                            setInterval(function() {
                                $("#alert-danger").hide();
                            }, 4000);
                        }




                    }
                })
                return false;
            });
        });

        // edit assign organization

        jQuery(document).ready(function($) {
            // create org
            $('#org_edit_assign').on('submit', function() {
                $.ajax({
                    type: "POST",
                    url: "../user-org-edit-assign/{{$users->id}}",
                    dataType: "html",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $("#hide").hide();
                        $("#show2").show();
                    },
                    success: function(response) {
                        $("#editassign").hide();
                        $("#hide").show();

                        if (response == 1) {
                            message = "Organization added successfully."
                            $("#dismiss").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-success").show();
                            $('#get-success').html(message);
                            setInterval(function() {
                                $("#alert-success").hide();
                            }, 4000);
                            window.location.reload(true);

                        }

                        if (response == 0) {
                            message = " Organization not found"
                            $("#dismiss").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-danger").show();
                            $('#get-danger').html(message);
                            setInterval(function() {
                                $("#alert-danger").hide();
                            }, 4000);
                            window.location.reload(true);

                        }

                        if (response == 2) {
                            message = "Select Organization"
                            $("#dismiss").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-danger").show();
                            $('#get-danger').html(message);
                            setInterval(function() {
                                $("#alert-danger").hide();
                            }, 4000);
                            window.location.reload(true);

                        }
                    }
                })
                return false;
            });
        });





// autocomplete organization name
        $(document).ready(function() {
            $("#org").autocomplete({
                source: "{!!URL::route('post.organization.autofill')!!}",
                minLength: 1,
                select: function(evt, ui) {
                    // // this.form.phone_number.value = ui.item.phone_number;
                    // // this.form.user_name.value = ui.item.user_name;
                    // if(ui.item.first_name) {
                    //     this.form.first_name.value = ui.item.first_name;
                    // }
                    // if(ui.item.last_name) {
                    //     this.form.last_name.value = ui.item.last_name;
                    // }

                }
            });
        });


        $(document).ready(function() {
            $("#editorg").autocomplete({
                source: "{!!URL::route('post.organization.autofill')!!}",
                minLength: 1,
                select: function(evt, ui) {


                }
            });
        });

//close autocomplite


        $(function() {
            //Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function() {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $(" input[type='checkbox']").iCheck("uncheck");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $("input[type='checkbox']").iCheck("check");
                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                }
                $(this).data("clicks", !clicks);
            });
        });



        $(function() {
            // Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function() {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
                } else {
                    //Check all checkboxes
                    $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
                }
                $(this).data("clicks", !clicks);
            });
        });


        $(document).ready(function() { /// Wait till page is loaded
            $('#click').click(function() {
                $('#refresh').load('open #refresh');
                $("#show").show();
            });
        });



        $(function() {
            $("textarea").wysihtml5();
        });
    </script>
    <div id="refresh"> 
        <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
    </div>
    <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON("../user-agen/<?php echo $users->id; ?>", function(result) {
                var labels = [], open = [], closed = [], reopened = [], open_total = 0, closed_total = 0, reopened_total = 0;
                for (var i = 0; i < result.length; i++) {
                    labels.push(result[i].date);
                    open.push(result[i].open);
                    closed.push(result[i].closed);
                    reopened.push(result[i].reopened);

                    open_total += parseInt(result[i].open);
                    closed_total += parseInt(result[i].closed);
                    reopened_total += parseInt(result[i].reopened);
                }
                var buyerData = {
                    labels: labels,
                    datasets: [
                        {
                            label: "Open Tickets",
                            fillColor: "rgba(93, 189, 255, 0.05)",
                            strokeColor: "rgba(2, 69, 195, 0.9)",
                            pointColor: "rgba(2, 69, 195, 0.9)",
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: open
                        }
                        , {
                            label: "Closed Tickets",
                            fillColor: "rgba(255, 206, 96, 0.08)",
                            strokeColor: "rgba(221, 129, 0, 0.94)",
                            pointColor: "rgba(221, 129, 0, 0.94)",
                            pointStrokeColor: "rgba(60,141,188,1)",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(60,141,188,1)",
                            data: closed

                        }
                        , {
                            label: "Reopened Tickets",
                            fillColor: "rgba(104, 255, 220, 0.06)",
                            strokeColor: "rgba(0, 149, 115, 0.94)",
                            pointColor: "rgba(0, 149, 115, 0.94)",
                            pointStrokeColor: "rgba(60,141,188,1)",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(60,141,188,1)",
                            data: reopened
                        }
                    ]
                };
                $("#total-created-tickets").html(open_total);
                $("#total-reopen-tickets").html(reopened_total);
                $("#total-closed-tickets").html(closed_total);
                var myLineChart = new Chart(document.getElementById("tickets-graph").getContext("2d")).Line(buyerData, {
                    showScale: true,
                    //Boolean - Whether grid lines are shown across the chart
                    scaleShowGridLines: true,
                    //String - Colour of the grid lines
                    scaleGridLineColor: "rgba(0,0,0,.05)",
                    //Number - Width of the grid lines
                    scaleGridLineWidth: 1,
                    //Boolean - Whether to show horizontal lines (except X axis)
                    scaleShowHorizontalLines: true,
                    //Boolean - Whether to show vertical lines (except Y axis)
                    scaleShowVerticalLines: true,
                    //Boolean - Whether the line is curved between points
                    bezierCurve: true,
                    //Number - Tension of the bezier curve between points
                    bezierCurveTension: 0.3,
                    //Boolean - Whether to show a dot for each point
                    pointDot: true,
                    //Number - Radius of each point dot in pixels
                    pointDotRadius: 1,
                    //Number - Pixel width of point dot stroke
                    pointDotStrokeWidth: 1,
                    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                    pointHitDetectionRadius: 10,
                    //Boolean - Whether to show a stroke for datasets
                    datasetStroke: true,
                    //Number - Pixel width of dataset stroke
                    datasetStrokeWidth: 1,
                    //Boolean - Whether to fill the dataset with a color
                    datasetFill: true,
                    //String - A legend template
                    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                    maintainAspectRatio: true,
                    //Boolean - whether to make the chart responsive to window resizing
                    responsive: true,
                });

            });
            $('#click me').click(function() {
                $('#foo').submit();
            });
            $('#foo').submit(function(event) {
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var date1 = $('#datepicker4').val();
                var date2 = $('#datetimepicker3').val();
                var formData = date1.split("/").join('-');
                var dateData = date2.split("/").join('-');
                // process the form
                $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: '../user-chart-range/<?php echo $users->id; ?>/' + dateData + '/' + formData, // the url where we want to POST
                    data: formData, // our data object
                    dataType: 'json', // what type of data do we expect back from the server

                    success: function(result2) {

                        var labels = [], open = [], closed = [], reopened = [], open_total = 0, closed_total = 0, reopened_total = 0;

                        for (var i = 0; i < result2.length; i++) {

                            labels.push(result2[i].date);
                            open.push(result2[i].open);
                            closed.push(result2[i].closed);
                            reopened.push(result2[i].reopened);

                            open_total += parseInt(result2[i].open);
                            closed_total += parseInt(result2[i].closed);
                            reopened_total += parseInt(result2[i].reopened);
                        }
                        var buyerData = {
                            labels: labels,
                            datasets: [
                                {
                                    label: "Open Tickets",
                                    fillColor: "rgba(93, 189, 255, 0.05)",
                                    strokeColor: "rgba(2, 69, 195, 0.9)",
                                    pointColor: "rgba(2, 69, 195, 0.9)",
                                    pointStrokeColor: "#c1c7d1",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: open
                                }
                                , {
                                    label: "Closed Tickets",
                                    fillColor: "rgba(255, 206, 96, 0.08)",
                                    strokeColor: "rgba(221, 129, 0, 0.94)",
                                    pointColor: "rgba(221, 129, 0, 0.94)",
                                    pointStrokeColor: "rgba(60,141,188,1)",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(60,141,188,1)",
                                    data: closed

                                }
                                , {
                                    label: "Reopened Tickets",
                                    fillColor: "rgba(104, 255, 220, 0.06)",
                                    strokeColor: "rgba(0, 149, 115, 0.94)",
                                    pointColor: "rgba(0, 149, 115, 0.94)",
                                    pointStrokeColor: "rgba(60,141,188,1)",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(60,141,188,1)",
                                    data: reopened
                                }
                            ]
                        };
                        $("#total-created-tickets").html(open_total);
                        $("#total-reopen-tickets").html(reopened_total);
                        $("#total-closed-tickets").html(closed_total);
                        var myLineChart = new Chart(document.getElementById("tickets-graph").getContext("2d")).Line(buyerData, {
                            showScale: true,
                            //Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines: true,
                            //String - Colour of the grid lines
                            scaleGridLineColor: "rgba(0,0,0,.05)",
                            //Number - Width of the grid lines
                            scaleGridLineWidth: 1,
                            //Boolean - Whether to show horizontal lines (except X axis)
                            scaleShowHorizontalLines: true,
                            //Boolean - Whether to show vertical lines (except Y axis)
                            scaleShowVerticalLines: true,
                            //Boolean - Whether the line is curved between points
                            bezierCurve: true,
                            //Number - Tension of the bezier curve between points
                            bezierCurveTension: 0.3,
                            //Boolean - Whether to show a dot for each point
                            pointDot: true,
                            //Number - Radius of each point dot in pixels
                            pointDotRadius: 1,
                            //Number - Pixel width of point dot stroke
                            pointDotStrokeWidth: 1,
                            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                            pointHitDetectionRadius: 10,
                            //Boolean - Whether to show a stroke for datasets
                            datasetStroke: true,
                            //Number - Pixel width of dataset stroke
                            datasetStrokeWidth: 1,
                            //Boolean - Whether to fill the dataset with a color
                            datasetFill: true,
                            //String - A legend template
                            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                            maintainAspectRatio: true,
                            //Boolean - whether to make the chart responsive to window resizing
                            responsive: true,
                        });
                        myLineChart.options.responsive = false;
                        $("#tickets-graph").remove();
                        $(".chart").html("<canvas id='tickets-graph' width='1000' height='250'></canvas>");
                        var myLineChart1 = new Chart(document.getElementById("tickets-graph").getContext("2d")).Line(buyerData, {
                            showScale: true,
                            //Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines: true,
                            //String - Colour of the grid lines
                            scaleGridLineColor: "rgba(0,0,0,.05)",
                            //Number - Width of the grid lines
                            scaleGridLineWidth: 1,
                            //Boolean - Whether to show horizontal lines (except X axis)
                            scaleShowHorizontalLines: true,
                            //Boolean - Whether to show vertical lines (except Y axis)
                            scaleShowVerticalLines: true,
                            //Boolean - Whether the line is curved between points
                            bezierCurve: true,
                            //Number - Tension of the bezier curve between points
                            bezierCurveTension: 0.3,
                            //Boolean - Whether to show a dot for each point
                            pointDot: true,
                            //Number - Radius of each point dot in pixels
                            pointDotRadius: 1,
                            //Number - Pixel width of point dot stroke
                            pointDotStrokeWidth: 1,
                            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                            pointHitDetectionRadius: 10,
                            //Boolean - Whether to show a stroke for datasets
                            datasetStroke: true,
                            //Number - Pixel width of dataset stroke
                            datasetStrokeWidth: 1,
                            //Boolean - Whether to fill the dataset with a color
                            datasetFill: true,
                            //String - A legend template
                            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                            maintainAspectRatio: true,
                            //Boolean - whether to make the chart responsive to window resizing
                            responsive: true,
                        });


                    }
                });
                // using the done promise callback
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });
        });
    </script>
    <script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
    <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
    @stop
