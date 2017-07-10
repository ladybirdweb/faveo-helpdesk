@extends('themes.default1.admin.layout.admin')
<style type="text/css" media="screen">
   .permission-menu{
        width: 300px !important;
   }  
.permisson-drop:hover, .permisson-drop:active, .permisson-drop.hover {
    background-color: #e7e7e7 !important;

}
.permisson-drop {
    background-color: #f4f4f4;
    color: #444;
    border-color: #ddd;
    width: 90%;
}
.permisson-drop {
    border-radius: 3px;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: 1px solid transparent;
}
.permisson-drop {
    -moz-user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857;
    margin-bottom: 0;
    padding: 6px 12px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}
.open > .dropdown-menu {
    overflow: auto;
    height: 220px;
}     
</style>
@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('agents')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.staffs')}}</h1>
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

<!-- open a form -->
<?php //dd($user->agent_tzone); ?>
{!! Form::model($user, ['url' => 'agents/'.$user->id,'method' => 'PATCH'] )!!}

<!-- <section class="content"> -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.edit_an_agent') !!}</h3>	
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('user_name'))
            <li class="error-message-padding">{!! $errors->first('user_name', ':message') !!}</li>
            @endif
            @if($errors->first('first_name'))
            <li class="error-message-padding">{!! $errors->first('first_name', ':message') !!}</li>
            @endif
            @if($errors->first('last_name'))
            <li class="error-message-padding">{!! $errors->first('last_name', ':message') !!}</li>
            @endif
            @if($errors->first('email'))
            <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
            @endif
            @if($errors->first('ext'))
            <li class="error-message-padding">{!! $errors->first('ext', ':message') !!}</li>
            @endif
            @if($errors->first('phone_number'))
            <li class="error-message-padding">{!! $errors->first('phone_number', ':message') !!}</li>
            @endif
            @if($errors->first('mobile'))
            <li class="error-message-padding">{!! $errors->first('mobile', ':message') !!}</li>
            @endif
            @if($errors->first('active'))
            <li class="error-message-padding">{!! $errors->first('active', ':message') !!}</li>
            @endif
            @if($errors->first('role'))
            <li class="error-message-padding">{!! $errors->first('role', ':message') !!}</li>
            @endif
            @if($errors->first('group'))
            <li class="error-message-padding">{!! $errors->first('group', ':message') !!}</li>
            @endif
            @if($errors->first('primary_department'))
            <li class="error-message-padding">{!! $errors->first('primary_department', ':message') !!}</li>
            @endif
            @if($errors->first('agent_time_zone'))
            <li class="error-message-padding">{!! $errors->first('agent_time_zone', ':message') !!}</li>
            @endif
            @if($errors->first('team'))
            <li class="error-message-padding">{!! $errors->first('team', ':message') !!}</li>
            @endif 
        </div>
        @endif
        @if(Session::has('fails2'))
            <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
                <li class="error-message-padding">{!! Session::get('fails2') !!}</li>
            </div>
        @endif
        <div class="row">
            <!-- username -->
            <div class="col-xs-4 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">

                {!! Form::label('user_name',Lang::get('lang.user_name')) !!} <span class="text-red"> *</span>

                {!! Form::text('user_name',null,['class' => 'form-control']) !!}

            </div>

            <!-- firstname -->
            <div class="col-xs-4 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">

                {!! Form::label('first_name',Lang::get('lang.first_name')) !!} <span class="text-red"> *</span>

                {!! Form::text('first_name',null,['class' => 'form-control']) !!}

            </div>

            <!-- Lastname -->
            <div class="col-xs-4 form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">

                {!! Form::label('last_name',Lang::get('lang.last_name')) !!} <span class="text-red"> *</span>

                {!! Form::text('last_name',null,['class' => 'form-control']) !!}

            </div>

        </div>

        <div class="row">
            <!-- Email -->
            <div class="col-xs-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">

                {!! Form::label('email',Lang::get('lang.email_address')) !!} <span class="text-red"> *</span>

                {!! Form::email('email',null,['class' => 'form-control']) !!}

            </div>

            <div class="col-xs-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">

                <label for="ext">EXT</label>	

                {!! Form::text('ext',null,['class' => 'form-control']) !!}

            </div>
            <!--country code-->
            <div class="col-xs-1 form-group {{ Session::has('country_code') ? 'has-error' : '' }}">

                {!! Form::label('country_code',Lang::get('lang.country-code')) !!}
                {!! Form::text('country_code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!}

            </div>
            <!-- phone -->
            <div class="col-xs-3 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">

                {!! Form::label('phone_number',Lang::get('lang.phone')) !!}

                {!! Form::text('phone_number',null,['class' => 'form-control']) !!}

            </div>

            <!-- Mobile -->
            <div class="col-xs-3 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">

                {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}

                {!! Form::input('number', 'mobile',null,['class' => 'form-control']) !!}

            </div>

        </div>
        <!-- Agent signature -->
        <div>

            <h4>{{Lang::get('lang.agent_signature')}}</h4>

        </div>

        <div class="">

            {!! Form::textarea('agent_sign',null,['class' => 'form-control','size' => '30x5']) !!}

        </div>


        <div>
            <h4>{{Lang::get('lang.account_status_setting')}}</h4>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <!-- acccount type -->
                <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">

                    {!! Form::label('active',Lang::get('lang.status')) !!}

                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('active','1',true) !!} {{ Lang::get('lang.active') }}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('active','0',null) !!} {{Lang::get('lang.inactive')}}
                        </div>
                    </div>

                </div>
                <!-- role -->
                

            </div>
            <div class="col-xs-6">
            <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">

                    {!! Form::label('role',Lang::get('lang.role')) !!}

                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('role','admin',true) !!} {{Lang::get('lang.admin')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('role','agent',null) !!} {{Lang::get('lang.agent')}}
                        </div>
                    </div>
                </div>
                </div>
            <!-- day light saving -->
            {{-- <div class="col-xs-6"> --}}
            
            {{-- <div> --}}
            {{-- <div class="row"> --}}
            {{-- {!! Form::label('',Lang::get('lang.day_light_saving')) !!} --}}
            {{-- <div class="col-xs-2"> --}}
            {{-- {!! Form::checkbox('daylight_save',1,null,['class' => 'checkbox']) !!} --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}

            <!-- limit access -->
            {{-- <div > --}}
            {{-- <div class="row"> --}}
            {{-- {!! Form::label('limit_access',Lang::get('lang.limit_access')) !!} --}}
            {{-- <div class="col-xs-2"> --}}
            {{-- {!! Form::checkbox('limit_access',1,null,['class' => 'checkbox']) !!} --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}

            <!-- directory listing -->
            {{-- <div> --}}
            {{-- <div class="row"> --}}
            {{-- {!! Form::label('directory_listing',Lang::get('lang.directory_listing')) !!} --}}
            {{-- <div class="col-xs-2"> --}}
            {{-- {!! Form::checkbox('directory_listing',1,null,['class' => 'checkbox']) !!} --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}

            <!-- vocation mode -->
            {{-- <div> --}}
            {{-- <div class="row"> --}}
            {{-- {!! Form::label('vocation_mode',Lang::get('lang.vocation_mode')) !!} --}}
            {{-- <div class="col-xs-2"> --}}
            {{-- {!! Form::checkbox('vocation_mode',1,null,null,['class' => 'checkbox']) !!} --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
        <div class="row">
            
             <div class="col-xs-4 form-group {{ $errors->has('group') ? 'has-error' : '' }}">
                {!! Form::label('assign_group', Lang::get('lang.assigned_group')) !!}
                
               <div class="dropdown">
                       <button class="permisson-drop" type="button" id="menu1" data-toggle="dropdown" onclick="closeDropdown()">Permissions<span class="caret"></span></button>
                         <ul class="dropdown-menu permission-menu" role="menu" aria-labelledby="menu1">
                            <li role="presentation">
                                    <span style="padding-left: 10px">Agent Permission</span><span style="float: right;padding: 4px;cursor: pointer;" onclick="closeDropdown()"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg>
                                    </span>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('create_ticket','Create Ticket')">
                                    <span id="create_ticket" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Create Ticket</span></a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('edit_ticket','Edit Ticket')">
                                    <span id="edit_ticket" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Edit Ticket</span></a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('post_ticket','Post Ticket')">
                                    <span id="post_ticket" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Post Ticket</span></a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('close_ticket','Close Ticket')">
                                    <span id="close_ticket" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Close Ticket</span></a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('transfer_ticket','Transfer Ticket')">
                                    <span id="transfer_ticket" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Transfer Ticket</span></a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('delete_ticket','Delete Ticket')">
                                    <span id="delete_ticket" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Delete Ticket</span></a>
                            </li>
                            
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('assign_ticket','Assign Ticket')">
                                    <span id="assign_ticket" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Assign Ticket</span></a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('access_kb','Access Kb')">
                                    <span id="access_kb" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Access Kb</span></a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('ban_email','Ban Emails')">
                                    <span id="ban_email" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Ban Email</span></a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('organisation_document_upload','Organisation Document Upload')">
                                    <span id="organisation_document_upload" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Organisation Document Upload</span></a>
                            </li>
                            
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('email_verification','Email Verification')">
                                    <span id="email_verification" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Email Verification</span></a>
                            </li>
                            
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('mobile_verification','Mobile Verification')">
                                    <span id="mobile_verification" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Mobile Verification</span></a>
                            </li>
                            
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="permissionSelect('account_activate','Account Activation')">
                                    <span id="account_activate" style="display: none"><svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path>
                                    </svg>
                                    <input  type="hidden"></span>
                                    <span>Account Activation</span></a>
                            </li>
                        </ul>
                </div>
                <div id="view-permission" style="width: 90%;text-align: center;border:1px solid gainsboro"></div>
            </div>
            <!-- primary department -->
            <div class="col-xs-4 form-group {{ $errors->has('primary_department') ? 'has-error' : '' }}">
                {!! Form::label('primary_dpt', Lang::get('lang.primary_department')) !!} <span class="text-red"> *</span>

                {!!Form::select('primary_department', [''=>Lang::get('lang.select_a_department'), Lang::get('lang.departments')=>$departments->pluck('name','id')->toArray()],$user->primary_dpt,['class' => 'form-control select']) !!}
            </div>

            <!-- agent timezone -->
            <div class="col-xs-4 form-group {{ $errors->has('agent_time_zone') ? 'has-error' : '' }}">
                {!! Form::label('agent_tzone', Lang::get('lang.agent_time_zone')) !!} <span class="text-red"> *</span>

                {!!Form::select('agent_time_zone', [''=>Lang::get('lang.select_a_time_zone'), Lang::get('lang.time_zones')=>$timezones->pluck('name','id')->toArray()],$user->agent_tzone,['class' => 'form-control select']) !!}
            </div>
        </div>

        <!-- team -->
        <div class="{{ $errors->has('team') ? 'has-error' : '' }}">
            {!! Form::label('agent_tzone',Lang::get('lang.assigned_team')) !!} <span class="text-red"> *</span>
        </div>
        @while (list($key, $val) = each($teams))
        <div class="form-group ">
            <input type="checkbox" name="team[]" value="<?php echo $val; ?> " <?php
            if (in_array($val, $assign)) {
                echo ('checked');
            }
            ?> > &nbsp;<?php echo "  " . $key; ?><br/>
        </div>
        @endwhile
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div>
<script>
$(document).ready(function() {
    $(".numberOnly").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
     var permision = {!!$user->permision()->pluck("permision")!!};
     console.log(permision);
     $.each(permision[0], function(key, value) {
        if(key=="create_ticket"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Create Ticket</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="edit_ticket"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Edit Ticket</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="post_ticket"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Post Ticket</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="close_ticket"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Close Ticket</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="delete_ticket"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Delete Ticket</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="assign_ticket"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Assign Ticket</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="ban_email"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Ban Email</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="access_kb"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Access Kb</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="transfer_ticket"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Transfer Ticket</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="organisation_document_upload"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Organisation Document Upload</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         
         else if(key=="email_verification"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Email Verification</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="mobile_verification"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Mobile Verification</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
         else if(key=="account_activate"){
          $('#'+key).css('display','inline-block');
          $('#view-permission').append("<p id='"+key+"1'>Account Activation</p>");
          $('#'+key).find('input').attr('name','permission['+key+']');
          $('#'+key).find('input').attr('value','1');
         }
     }); 

  function permissionSelect(x,y){
   
     $('#submit').removeAttr('disabled');
    if($('#'+x).css('display')=='none'){

        $('#'+x).css('display','inline-block');
        $('#'+x).find('input').attr('name','permission['+x+']');
        $('#'+x).find('input').attr('value','1');
        $('#view-permission').append("<p id='"+x+"1'>"+y+"</p>")
    }
    else{
        $('#'+x).css('display','none');
        $('#'+x).find('input').removeAttr('name');
        $('#view-permission').find('#'+x+'1').remove();
    }
     
  }
  function closeDropdown(){
      $('.permission-menu').toggle();
  }

  $(document).click(function(event) {
     if($('.permission-menu').css('display')=='block'){
         $('.permission-menu').hide();
    }
  });
$('.permission-menu').click(function(event){
     event.stopPropagation();
 });
</script>
{!!Form::close()!!}
@stop