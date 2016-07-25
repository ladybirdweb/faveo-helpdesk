@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('form')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{$form->formname}}</h1>
@stop
@section('content')

<div class="box box-primary">
    <div class="box-body">
        <div class="row">
                @foreach($fields as $field)
                <?php
                $form = App\Http\Controllers\Admin\helpdesk\FormController::getForm($field);
                ?>
                <div class="col-md-10">
                {!! Form::label($field->label,$field->label) !!}
                {!! $form !!}
                </div>
                <div class="col-md-2">
                    @include('themes.default1.admin.helpdesk.manage.form.childpopup')
                </div>
                @endforeach

            </div>

    </div>
</div>
@stop
