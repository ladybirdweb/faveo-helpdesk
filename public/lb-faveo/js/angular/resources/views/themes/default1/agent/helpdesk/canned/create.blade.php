@extends('themes.default1.agent.layout.agent')

@section('Tools')
class="active"
@stop

@section('tools-bar')
active
@stop

@section('tools')
class="active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.canned_response')}}</h1>
@stop

<!-- content -->
@section('content')
<!-- open a form -->
{!! Form::open(['route'=>'canned.store','method' => 'patch']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.create') !!} </h3>
    </div>
    <div class="box-body">
        @if(Session::has('fails'))
         <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            <li class="error-message-padding">{!! Session::get('fails') !!}</li>
        </div>
        @endif

        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('title'))
            <li class="error-message-padding">{!! $errors->first('title', ':message') !!}</li>
            @endif
            @if($errors->first('message'))
            <li class="error-message-padding">{!! $errors->first('message', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="row">
            <!-- username -->
            <div class="col-xs-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                {!! Form::label('title',Lang::get('lang.title')) !!}    <span class="text-red"> *</span>           
                {!! Form::text('title',null,['class' => 'form-control']) !!}
            </div>
            <!-- firstname -->
            <div class="col-xs-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                {!! Form::label('message',Lang::get('lang.message')) !!}<span class="text-red"> *</span>
                {!! Form::textarea('message',null,['class' => 'form-control']) !!}
            </div>

            <div class="col-xs-12 form-group">
                <label name="share">{{Lang::get('lang.share-response-with-department')}}</label>
                <input type='checkbox' name='share' id='share' onclick='someFunction(this.id)' class='selectval icheckbox_flat-blue not-apply'></input>
            </div>
        </div>
        <div class="row share" style="display: none;">
            <div class="col-md-12">
                <label>{!! Lang::get('lang.select-deparment') !!}</label> <span class="text-red"> *</span>
            </div>
            <div class="col-md-12 form-group">
                <select class="form-control select2" name="d_id[]" multiple="multiple" id="departments-filter" data-placeholder="{!! Lang::get('lang.enter-department-name') !!}" style="width: 50%;" disabled="true">
                </select>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div>
<script>
    $(function() {
        //Add text editor
        $("textarea").wysihtml5();
    });

    function someFunction(id) {
        if(document.getElementById('share').checked) {
            $('.share').css('display', 'block');
            $('.select2').attr('disabled', false);
        } else {
            $('.share').css('display', 'none');
            $('.select2').attr('disabled', true);
        }
    }
</script>

@include('themes.default1.agent.helpdesk.selectlists.selectlistjavascript')
<script type="text/javascript">
    $( "#departments-filter" ).addSelectlist({
        maximumSelectionLength : 3
    });
</script>
@stop
