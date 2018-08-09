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

<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.edit_user') !!}</h1>
@stop
<!-- /header -->

<!-- content -->
@section('content')
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
<!-- open a form -->
{!! Form::model($users,['url'=>'user/'.$users->id,'method'=>'PATCH']) !!}
 {!!Form::hidden('role',$users->role)!!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            {!! Lang::get('lang.user_credentials') !!}
        </h3>
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('first_name'))
                <li class="error-message-padding">{!! $errors->first('first_name', ':message') !!}</li>
            @endif
            @if($errors->first('last_name'))
                <li class="error-message-padding">{!! $errors->first('last_name', ':message') !!}</li>
            @endif
            @if($errors->first('user_name'))
                <li class="error-message-padding">{!! $errors->first('user_name', ':message') !!}</li>
            @endif
            @if($errors->first('email'))
                <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
            @endif
            @if($errors->first('mobile'))
                <li class="error-message-padding">{!! $errors->first('mobile', ':message') !!}</li>
            @endif
            @if($errors->first('ext'))
                <li class="error-message-padding">{!! $errors->first('ext', ':message') !!}</li>
            @endif
            @if($errors->first('phone_number'))
                <li class="error-message-padding">{!! $errors->first('phone_number', ':message') !!}</li>
            @endif
            @if($errors->first('active'))
                <li class="error-message-padding">{!! $errors->first('active', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="row">
        <?php if(strpos($users->email, '@')){
            $email = $users->email;
        }else{
            $email = "";            
        }?>
            <!-- Email Address : Email : Required -->
            <div class="col-xs-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::label('email',Lang::get('lang.email')) !!}
                @if ($email_mandatory->status == 1 || $email_mandatory->status == '1')
                <span class="text-red"> *</span>
                @endif
                {!! Form::email('email',$email,['class' => 'form-control']) !!}
            </div>
        <!-- User Name : Text : Required-->
            <div class="col-xs-6 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">
                {!! Form::label('user_name',Lang::get('lang.user_name')) !!}<span class="text-red"> *</span>
                {!! Form::text('user_name',null,['class' => 'form-control', 'pattern' => '^[a-zA-Z0-9-_\.]{1,20}$|[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$', 'title' => Lang::get('lang.username_pattern_warning')]) !!}
            </div>
        </div>
        <div class="row">
            <!-- First name : first name : Required -->
            <div class="col-xs-6 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                {!! Form::label('first_name',Lang::get('lang.first_name')) !!}<span class="text-red"> *</span>
                {!! Form::text('first_name',null,['class' => 'form-control']) !!}
            </div>
            <!-- Last name : last name : Required -->
            <div class="col-xs-6 form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                {!! Form::label('last_name',Lang::get('lang.last_name')) !!}
                {!! Form::text('last_name',null,['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 form-group {{ $errors->has('organization') ? 'has-error' : '' }}">
                {!! Form::label('organization',Lang::get('lang.organization')) !!}

               <?php $org_name=App\Model\helpdesk\Agent_panel\Organization::where('id','=',$organization_id)->select('name')->first(); ?>

               @if($org_name)

               <input type="text" id="org_id" class="form-control" name="org_id" value="{!! $org_name->name  !!}"> 

               @else
                <input type="text" id="org_id" class="form-control" name="org_id" > 
               @endif

            </div>
            <div class="col-xs-1 form-group {{ Session::has('country_code_error') ? 'has-error' : '' }}">
                {!! Form::label('country_code',Lang::get('lang.country-code')) !!}
                {!! $errors->first('country_code', '<spam class="help-block">:message</spam>') !!}


                <input type="text" name="country_code" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder = "{{$phonecode}}" >



                <!-- {!! Form::text('country_code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!} -->
            </div>
            <!-- mobile Number : Text :  -->
            <div class="col-md-5 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                {!! Form::label('mobile',Lang::get('lang.mobile')) !!}
                 <input type="text" name="mobile" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$users->mobile}}" >

                <!-- {!! Form::input('number', 'mobile',null,['class' => 'form-control']) !!} -->
            </div>
        </div>
        <div class="row">     
            <div class="col-xs-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                <label for="ext">{!! Lang::get('lang.ext') !!}</label>  
                 <input type="text" name="ext" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$users->ext}}" >
                
                <!-- {!! Form::text('ext',null,['class' => 'form-control']) !!} -->
            </div>
            <div class="col-xs-5 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                <label for="phone_number">{!! Lang::get('lang.phone') !!}</label>

                 <input type="text" name="phone_number" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$users->phone_number}}" >
                <!-- {!! Form::input('number', 'phone_number',null,['class' => 'form-control']) !!} -->
               
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                {!! Form::label('active',Lang::get('lang.status')) !!}
                <div class="row">
                    <div class="col-xs-4">
                        {!! Form::radio('active','1',true) !!} {{Lang::get('lang.active')}}
                    </div>
                    <div class="col-xs-6">
                        {!! Form::radio('active','0') !!} {{Lang::get('lang.inactive')}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 form-group {{ $errors->has('ban') ? 'has-error' : '' }}">
                {!! Form::label('ban',Lang::get('lang.ban')) !!}
                <div class="row">
                    <div class="col-xs-4">
                        {!! Form::radio('ban','1',true) !!} {{Lang::get('lang.enable')}}
                    </div>
                    <div class="col-xs-6">
                        {!! Form::radio('ban','0') !!} {{Lang::get('lang.disable')}}
                    </div>
                </div>
            </div>

        </div>
        <!-- Internal Notes : Textarea -->
        <div class="form-group">
            {!! Form::label('internal_note',Lang::get('lang.internal_notes')) !!}
            {!! Form::textarea('internal_note',null,['class' => 'form-control', 'size' => '30x5']) !!}
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'form-group btn btn-primary'])!!}
    </div>        
</div>
<script>
    $(function() {
        $("textarea").wysihtml5();
        
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
        $('input[type="radio"]').iCheck({
            radioClass: 'iradio_flat-blue'
        });
    
    });        
</script>

<script type="text/javascript">
    // / autocomplete Department name
        $(document).ready(function() {
            $("#org_id").autocomplete({
                source: "{!!URL::route('post.organization.autofill')!!}",
                minLength: 1,
                select: function(evt, ui) {
                   

                }
            });
        });
</script>
@stop
@section('FooterInclude')
<!--<script>
    $('#org').autocomplete({
        minLength: 1,
        source: function (request, response) {
            $.getJSON("{{url('get-organization')}}", {
                term: request.term
            }, function (data) {
                var array = data.error ? [] : $.map(data, function (m) {
                    return {
                        label: m.label,
                        value: m.value
                    };
                });
                response(array);
            });
        },
        select: function (event, ui) {
            $("#org").val(ui.item.label); // display the selected text
            $("#field_id").val(ui.item.value); // save selected id to hidden input
            return false;
        }
    });

</script>-->

@stop