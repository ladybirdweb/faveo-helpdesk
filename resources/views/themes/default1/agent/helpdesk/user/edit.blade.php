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
<h1>{!! Lang::get('lang.edit') !!}</h1>
@stop
<!-- /header -->

<!-- content -->
@section('content')
<!-- open a form -->
{!! Form::model($users,['url'=>'user/'.$users->id,'method'=>'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            User Credentials
        </h3>
        <a class="pull-right" href="{{route('user.show', $users->id)}}">
					View profile
				</a>
        <?php
						$user_org = App\Model\helpdesk\Agent_panel\User_org::where('user_id','=', $users->id)->first();
					?>
						@if($user_org == null)
						<b>{!! Lang::get('lang.organization') !!}</b>

							<a href="" class="pull-right"  data-toggle="modal" data-target="#assign"><i class="fa fa-hand-o-right" style="color:orange;"> </i> {!! Lang::get('lang.assign') !!} </a>
							<a href="" data-toggle="modal" data-target="#create_org" class="pull-right"> {{Lang::get('lang.create')}} <b style="color:#000"> / </b>&nbsp; </a>
						@else
		<?php 	$org_id = $user_org->org_id;
				$organization = App\Model\helpdesk\Agent_panel\Organization::where('id','=',$org_id)->first(); ?>
                                                <div class="pull-right">
                                                    <span><b>{!! Lang::get('lang.organization') !!}</b>
                                                        <a href="{!! URL::route('organizations.show',$organization->id) !!}" >{!! $organization->name !!}</a></span>&nbsp;&nbsp;
&nbsp;
						@endif
					
    </div>
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
                        <select id="org" class="form-control" name="org">
<?php
$orgs = App\Model\helpdesk\Agent_panel\Organization::all();
?>
                            <optgroup label="Select Organizations">
                                @foreach($orgs as $org)
                                    <option  value="{{$org->id}}">{!! $org->name !!}</option>
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

    <div class="box-body">
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('email'))
            <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
            @endif
            @if($errors->first('user_name'))
            <li class="error-message-padding">{!! $errors->first('user_name', ':message') !!}</li>
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
        <!-- Email Address : Email : Required -->
        <div class="row">
            <div class="col-md-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::label('email',Lang::get('lang.email')) !!}
                {!! Form::email('email',null,['disabled'=>'disabled', 'class' => 'form-control']) !!}
            </div>
            <!-- Full Name : Text : Required-->
            <div class="col-md-4 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">
                {!! Form::label('user_name',Lang::get('lang.full_name')) !!}
                {!! Form::text('user_name',null,['class' => 'form-control']) !!}
            </div>
            <!-- mobile Number : Text :  -->
            <div class="col-md-4 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                {!! Form::label('mobile',Lang::get('lang.mobile')) !!}
                {!! Form::text('mobile',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                <label for="ext">{!! Lang::get('lang.ext') !!}</label>	
                {!! Form::text('ext',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-5 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                <label for="phone_number">{!! Lang::get('lang.phone') !!}</label>
                {!! Form::text('phone_number',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-3 form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                {!! Form::label('active',Lang::get('lang.status')) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::radio('active','1',true) !!} {{Lang::get('lang.active')}}
                    </div>
                    <div class="col-xs-12">
                        {!! Form::radio('active','0') !!} {{Lang::get('lang.inactive')}}
                    </div>
                </div>
            </div>
            <div class="col-xs-3 form-group {{ $errors->has('ban') ? 'has-error' : '' }}">
                {!! Form::label('ban',Lang::get('lang.ban')) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::radio('ban','1',true) !!} {{Lang::get('lang.enable')}}
                    </div>
                    <div class="col-xs-12">
                        {!! Form::radio('ban','0') !!} {{Lang::get('lang.disable')}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Internal Notes : Textarea -->
        <div class="form-group">
            {!! Form::label('internal_note',Lang::get('lang.internal_notes')) !!}
            {!! Form::textarea('internal_note',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary'])!!}
    </div>        
</div>
<script>
    $(function () {
        $("textarea").wysihtml5();
    });
</script>
@stop