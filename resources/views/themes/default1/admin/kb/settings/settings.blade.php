@extends('themes.default1.admin.layout.kb')
@section('settings')
    class="active"
@stop
<script type="text/javascript" src="{{asset('dist/js/SetnicEdit.js')}}"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
@section('content')
<!-- open a form -->
    {!! Form::model($settings,['url' => 'postsettings/'.$settings->id, 'method' => 'PATCH','files'=>true]) !!}

            <div class="box-header">
                <h3 class="box-title">{{Lang::get('lang.settings')}}</h3>  {!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}
            </div>
            <div class="box-body">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">{{Lang::get('lang.system')}}</a></li>
                  <li><a href="#tab_2" data-toggle="tab">{{Lang::get('lang.smtp')}}</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     {{-- For Form --}}
    <!-- check whether success or not -->
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Alert!</b> Failed.
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
        <!-- Name text form Required -->
            <div class="row">
                <div class="col-md-3 form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                    {!! Form::label('company_name',Lang::get('lang.companyname')) !!}
                    {!! $errors->first('company_name', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('company_name',$settings->company_name,['class' => 'form-control']) !!}
                </div>
                <div class="col-md-3 form-group {{ $errors->has('website') ? 'has-error' : '' }}">
                    {!! Form::label('website',Lang::get('lang.website')) !!}
                    {!! $errors->first('website', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('website',$settings->website,['class' => 'form-control']) !!}
                </div>
                <div class="col-md-3 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    {!! Form::label('phone',Lang::get('lang.phone')) !!}
                    {!! $errors->first('phone', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('phone',$settings->phone,['class' => 'form-control']) !!}
                </div>
                {{--  <div class="col-md-3 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    {!! Form::label('language',Lang::get('lang.language')) !!}
                        {!!Form::select('language',['en'=>'English','ch'=>'Chinese'] ,null,['class' => 'form-control select']) !!}
                </div>
 --}}
                    <div class="col-md-12 form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                {!! Form::label('address',Lang::get('lang.address')) !!}
                {!! $errors->first('address', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::textarea('address',null,['class' => 'form-control','size' => '128x10','id'=>'address','placeholder'=>'Enter the address']) !!}
                </div>
                    <div class="col-md-3 form-group">
                           {!! Form::label('logo',Lang::get('lang.logo')) !!}
                           {!! Form::file('logo') !!}
                        @if($settings->logo)
                           <img src="{{asset('lb-faveo/dist/image/'.$settings->logo)}}" />
                           <a href="{{url('delete-logo/'.$settings->id)}}">{{Lang::get('lang.delete')}}</a>
                        @endif
                    </div>
                    <div class="col-md-3 form-group">
                        {!! Form::label('pagination',Lang::get('lang.numberofelementstodisplay')) !!}
                        {!! $errors->first('pagination', '<spam class="help-block">:message</spam>') !!}
                        {!! Form::text('pagination',$settings->pagination,['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-3 form-group">
                        {!! Form::label('timezone',Lang::get('lang.timezone')) !!}
                        {!!Form::select('timezone',$time->pluck('location','location') ,null,['class' => 'form-control select']) !!}
                    </div>
                     </div>
                  </div><!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <div class="row">
                <div class="col-md-4 form-group {{ $errors->has('port') ? 'has-error' : '' }}">
                    {!! Form::label('port',Lang::get('lang.portnumber')) !!}
                    {!! $errors->first('port', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('port',$settings->port,['class' => 'form-control']) !!}
                </div>
                <div class="col-md-4 form-group {{ $errors->has('host') ? 'has-error' : '' }}">
                    {!! Form::label('host',Lang::get('lang.host')) !!}
                    {!! $errors->first('host', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('host',$settings->host,['class' => 'form-control']) !!}
                </div>
                <div class="col-md-4 form-group {{ $errors->has('encryption') ? 'has-error' : '' }}">
                    {!! Form::label('encryption',Lang::get('lang.encryption')) !!}
                    {!! $errors->first('encryption', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('encryption',$settings->encryption,['class' => 'form-control']) !!}
                </div>
                <div class="col-md-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email',Lang::get('lang.settingsemail')) !!}
                    {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('email',$settings->email,['class' => 'form-control']) !!}
                </div>
                <div class="col-md-4 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password',Lang::get('lang.password')) !!}
                    {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::password('password',['class' => 'form-control']) !!}
                </div>
                <div class="col-md-4 form-group">
                        {!! Form::label('dateformat',Lang::get('lang.dateformat')) !!}
                        {!!Form::select('dateformat',$date->pluck('format','format') ,null,['class' => 'form-control select']) !!}
                    </div>
            </div>
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->
@stop
@section('FooterInclude')

@stop

<!-- /content -->
