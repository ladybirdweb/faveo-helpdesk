@extends('themes.default1.admin.layout.admin')
<link href="{{asset("lb-faveo/js/intlTelInput.css")}}" rel="stylesheet" type="text/css">
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
<h1>{{Lang::get('lang.agents')}}</h1>
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
{!! Form::open(array('action' => 'Admin\helpdesk\AgentController@store' , 'method' => 'post','id'=>'Form') )!!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.create_an_agent') !!}</h3>    
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
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
            @if($errors->first('country_code'))
            <li class="error-message-padding">{!! $errors->first('country_code', ':message') !!}</li>
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
            <!-- email address -->
            <div class="col-xs-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::label('email',Lang::get('lang.email_address')) !!} <span class="text-red"> *</span>
                {!! Form::email('email',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-6 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">
                {!! Form::label('user_name',Lang::get('lang.user_name')) !!} <span class="text-red"> *</span>
                {!! Form::text('user_name',null,['class' => 'form-control', 'pattern' => '^[a-zA-Z0-9-_\.]{1,20}$|[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$', 'title' => Lang::get('lang.username_pattern_warning')]) !!}
            </div>
        </div>
        <div class="row">
            <!-- firstname -->
            <div class="col-xs-6 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                {!! Form::label('first_name',Lang::get('lang.first_name')) !!} <span class="text-red"> *</span>
                {!! Form::text('first_name',null,['class' => 'form-control']) !!}
            </div>
            <!-- lastname -->
            <div class="col-xs-6 form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                {!! Form::label('last_name',Lang::get('lang.last_name')) !!}
                {!! Form::text('last_name',null,['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
             <!-- phone -->
            <div class="col-xs-5 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                {!! Form::label('phone_number',Lang::get('lang.phone')) !!}
                {!! Form::input('text','phone_number',null,['class' => 'form-control numberOnly', 'id' => 'phone_number']) !!}
            </div>

             <div class="col-xs-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                <label for="ext">{!! Lang::get('lang.ext') !!}</label>  
                {!! Form::text('ext',null,['class' => 'form-control numberOnly']) !!}
            </div>
            
            {{Form::hidden('country_code', null)}}
            <!-- Mobile -->
            <div class="col-xs-6 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}
                @if($aoption == 'mobile' || $aoption == 'email,mobile')<span class="text-red"> *</span>@endif
                <!-- {!! Form::text('mobile',null,['class' => 'form-control']) !!} -->
                {!! Form::input('text','mobile',null,['class' => 'form-control numberOnly', 'id' => 'mobile']) !!}

            </div>
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
                            {!! Form::radio('active','1',true) !!} {{Lang::get('lang.active')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('active','0',null) !!} {{Lang::get('lang.inactive')}}
                        </div>
                    </div>
                </div>
                <!-- Role -->
                
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
        </div>
        <div class="row">
            <!-- assigned group -->
            <div class="col-xs-4 form-group {{ $errors->has('group') ? 'has-error' : '' }}">
                {!! Form::label('assign_group',Lang::get('lang.assigned_group')) !!}
                <!-- {!!Form::select('group',[''=>Lang::get('lang.select_a_group')],null,['class' => 'form-control select']) !!} -->
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
            <!-- primary dept -->
            <div class="col-xs-4 form-group {{ $errors->has('primary_department') ? 'has-error' : '' }}">
                {!! Form::label('primary_dpt',Lang::get('lang.primary_department')) !!} <span class="text-red"> *</span>
             {!! Form::select('primary_department[]', [Lang::get('lang.departments')=>$departments->pluck('name','id')->toArray()],null,['multiple'=>true,'class'=>"form-control select2" ,'id'=>"primary_department"]) !!}
<!-- <input type="" name="primary_department[]" class="form-control select2" id="primary_department"> -->
            </div>
          
            <!-- timezone -->
            <div class="col-xs-4 form-group {{ $errors->has('agent_time_zone') ? 'has-error' : '' }}">
                {!! Form::label('agent_tzone',Lang::get('lang.agent_time_zone')) !!} <span class="text-red"> *</span>
                {!! Form::select('agent_time_zone', [''=>Lang::get('lang.select_a_time_zone'),Lang::get('lang.time_zones')=>$timezones->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
        </div>
        <!-- Assign team -->
        <div class="form-group {{ $errors->has('team') ? 'has-error' : '' }}">
            {!! Form::label('agent_tzone',Lang::get('lang.assigned_team')) !!} 


             @while (list($key, $val) = each($teams))
            <div class="form-group ">
                <input type="checkbox" name="team[]" value="<?php echo $val; ?>"  > <?php echo $key; ?><br/>
            </div>
            @endwhile


        </div>
        <div class="row">
            <div class="col-xs-12">
            <h4>{!! Lang::get('lang.agent_signature') !!}</h4>
            </div>
            <div class="col-xs-12">
                {!! Form::textarea('agent_sign',null,['class' => 'form-control','size' => '30x5','id'=>'ckeditor']) !!}
            </div>
        </div>
        
    </div>
    <div class="box-footer">
<!--        {!! Form::submit(Lang::get('lang.create'),['class'=>'form-group btn btn-primary'])!!}-->
<!--        {!!Form::button('<i class="fa fa-floppy-o" aria-hidden="true">&nbsp;&nbsp;</i>'.Lang::get('lang.save'),['type' => 'submit', 'class' =>'btn btn-primary'])!!}-->
            <button type="submit" class="btn btn-primary" id="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'>&nbsp;</i> Saving..."><i class="fa fa-floppy-o">&nbsp;&nbsp;</i>{!!Lang::get('lang.save')!!}</button>
    
    </div>
</div>
{!!Form::close()!!}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{asset("lb-faveo/js/intlTelInput.js")}}"></script>
<script type="text/javascript">
    var telInput = $('#mobile');
    telInput.intlTelInput({
        geoIpLookup: function(callback) {
            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        initialCountry: "auto",
        separateDialCode: true,
        utilsScript: "{{asset('lb-faveo/js/utils.js')}}"
    });
    $('.intl-tel-input').css('width', '100%');

    telInput.on('blur', function() {
        if ($.trim(telInput.val())) {
            if (!telInput.intlTelInput("isValidNumber")) {
                telInput.parent().addClass('has-error');
            }
        }
    });
    $('input').on('focus', function() {
        $(this).parent().removeClass('has-error');
    });

    $('form').on('submit', function(e){
        $('input[name=country_code]').attr('value', $('.selected-dial-code').text());
    });
</script>
    <script>
        $('#primary_department').select2({

            // alert('ogkkggk');
           placeholder: "{{Lang::get('lang.Choose_departments...')}}",
            minimumInputLength: 2,
            ajax: {
               url: '{{route("agent.dept.search")}}',
                 dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

    </script>
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
  function permissionSelect(x,y){
    $('#submit').removeAttr('disabled');
    if($('#'+x).css('display')=='none'){

        $('#'+x).css('display','inline-block');
        $('#'+x).find('input').attr('name','permission['+x+']');
        $('#'+x).find('input').attr('value',"1");
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


   <!--   type: 'post',
            url: '{{route("settingsUpdateApproval.settings")}}', -->


<script type="text/javascript">
    $(function() {
        $('.select2-selection--multiple').css('border-radius','0px');
        $('.select2-selection__rendered').css('margin-bottom','-7px');
    });
    </script>


@stop