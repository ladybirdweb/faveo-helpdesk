@extends('themes.default1.agent.layout.agent')
@extends('themes.default1.agent.layout.sidebar')    

@section('settings')
class="active"
@stop


@section('content')
<!-- open a form -->
{!! Form::model($settings,['url' => 'postsettings/'.$settings->id, 'method' => 'PATCH','files'=>true]) !!}

<div class="box-header" style="margin:-5px;margin-top:-25px;">
    <h3 class="box-title">{{Lang::get('lang.kb-settings')}}</h3> 
</div>
<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">{{Lang::get('lang.system')}}</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            {{-- For Form --}}
            <!-- check whether success or not -->
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('success')}}
            </div>
            @endif
            <!-- failure message -->
            @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>{!! lang::get('lang.alert') !!}!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('fails')}}
            </div>
            @endif
            @if(Session::has('errors'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>{!! Lang::get('lang.alert') !!}!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <br/>
                @if($errors->first('pagination'))
                <li class="error-message-padding">{!! $errors->first('pagination', ':message') !!}</li>
                @endif         
            </div>
            @endif
            <!-- Name text form Required -->
            <div class="row">
                <div class="col-md-3 form-group">
                    {!! Form::label('pagination',Lang::get('lang.numberofelementstodisplay')) !!} <span class="text-red"> *</span>
                    <input type="number" class="form-control" name='pagination' value="{!! $settings->pagination !!}" min="2">
                </div>
            </div>
        </div><!-- /.tab-pane -->
    </div><!-- /.tab-pane -->
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div><!-- /.tab-content -->
<script type="text/javascript">
    $(function() {
        $("textarea").wysihtml5();
    });
</script>
@stop
