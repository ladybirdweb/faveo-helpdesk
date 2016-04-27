@extends('themes.default1.admin.layout.admin')
@section('content')
<div class="box box-primary">

    <div class="content-header">
        {!! Form::open(['url'=>'templates','method'=>'post']) !!}
        <h4>{{Lang::get('lang.templates')}}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

    </div>

    <div class="box-body">

        <div class="row">

            <div class="col-md-12">

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('lang.alert')}}!</b> {{Lang::get('lang.success')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('success')}}
                </div>
                @endif
                <!-- fail lang -->
                @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('lang.alert')}}!</b> {{Lang::get('lang.failed')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails')}}
                </div>
                @endif

                <div class="row">

                    <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <!-- first name -->
                        {!! Form::label('name',Lang::get('lang.name'),['class'=>'required']) !!}
                        {!! Form::text('name',null,['class' => 'form-control']) !!}

                    </div>

                    <div class="col-md-6 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        <!-- last name -->
                        {!! Form::label('type',Lang::get('lang.template-types'),['class'=>'required']) !!}
                        {!! Form::select('type',[''=>'Select','Type'=>$type],null,['class' => 'form-control']) !!}

                    </div>
                                        

                </div>
                <div class="row">
                    <div class="col-md-12 form-group {{ $errors->has('url') ? 'has-error' : '' }}">
         
                        {!! Form::label('url',Lang::get('lang.subject')) !!}
                        {!! Form::text('url',null,['class' => 'form-control']) !!}

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        
                        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>
   tinymce.init({
  selector: 'textarea',
  height: 500,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code'
  ],
  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    '//www.tinymce.com/css/codepen.min.css'
  ]
});
</script>
                        
                        {!! Form::label('data',Lang::get('lang.content'),['class'=>'required']) !!}
                        {!! Form::textarea('data',null,['class'=>'form-control','id'=>'textarea']) !!}
                       
                    </div>


                </div>

            </div>

        </div>

    </div>

</div>


{!! Form::close() !!}
@stop