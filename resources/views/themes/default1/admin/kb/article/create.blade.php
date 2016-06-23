@extends('themes.default1.agent.layout.kb')

@section('article')
    active
@stop
@section('add-article')
    class="active"
@stop
        <script type="text/javascript" src="{{asset('lb-faveo/dist/js/nicEdit.js')}}"></script>
        <script type="text/javascript">
            bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        </script>
@section('content')
{!! Form::open(array('action' => 'Admin\kb\ArticleController@store' , 'method' => 'post') )!!}

<div class="row">
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
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
    @if(!$category)
    <div class="alert alert-warning alert-dismissable">
        <i class="fa fa-info"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Create a Category 
    </div>
    @endif
    	
		<div class="box-body">
			<div class="col-md-9">
			<div class="box box-primary">
			<div class="box-header">
	 			<h4 class="box-title">Add Article</h4>
			</div>
			<div class="box-body">
			<div class="row">

				<div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}" >

					{!! Form::label('name',Lang::get('lang.name')) !!}
					{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
					{!! Form::text('name',null,['class' => 'form-control']) !!}
				</div>

				<div class="col-md-6 form-group {{ $errors->has('slug') ? 'has-error' : '' }}" >

					{!! Form::label('slug',Lang::get('lang.slug')) !!}
					{!! $errors->first('slug', '<spam class="help-block">:message</spam>') !!}
					{!! Form::text('slug',null,['class' => 'form-control']) !!}
				</div>
			</div>

				<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
				{!! Form::label('description',Lang::get('lang.description')) !!}
				{!! $errors->first('description', '<spam class="help-block">:message</spam>') !!}
				<div class="form-group" style="background-color:white">
					{!! Form::textarea('description',null,['class' => 'form-control color','size' => '128x20','id'=>'myNicEditor','placeholder'=>'Enter the description']) !!}
				</div>
				</div>
			</div>
			</div>

		</div>

	<ul style="list-style-type:none;">
	<li>
	<div class="col-md-3">
	<div class="box box-default">
	<div class="box-header with-border">
                  <h3 class="box-title">{{Lang::get('lang.publish')}}</h3>
	</div>
				<div class="box-body">
					<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">

						{!! Form::label('type',Lang::get('lang.status')) !!}
						{!! $errors->first('type', '<spam class="help-block">:message</spam>') !!}
						<div class="row">
							<div class="col-xs-4">
								{!! Form::radio('type','1',true) !!}{{Lang::get('lang.published')}}
							</div>
							<div class="col-xs-3">
								{!! Form::radio('type','0',null) !!}{{Lang::get('lang.draft')}}
							</div>
						</div>
					</div>


					<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">

						{!! Form::label('status',Lang::get('lang.visibility')) !!}
						{!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
						<div class="row">
							<div class="col-xs-3">
								{!! Form::radio('status','1',true) !!}{{Lang::get('lang.public')}}
								</div>
								<div class="row">
							<div class="col-xs-3">
								{!! Form::radio('status','0',null) !!}{{Lang::get('lang.private')}}
								</div>
					</div>

				</div>

			</div>
		</div>
		<div class="box-footer" style="background-color:#f5f5f5;">
		<div style="margin-left:140px;">

				{!! Form::submit(Lang::get('lang.publish'),['class'=>'btn btn-primary'])!!}
		</div>

		</div>

</li>
<li>
<div class="col-md-3">
	<div class="box box-default">
				<div class="box-header with-border">
                  <h3 class="box-title">{{Lang::get('lang.category')}}</h3>
                </div>
			<div class="box-body" style="height:190px; overflow-y:auto;">

				<div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
		{{-- {!! Form::label('category_id','Category') !!} --}}
				{!! $errors->first('category_id', '<spam class="help-block">:message</spam>') !!}
					@while (list($key, $val) = each($category))
					<div class="row">
						<div class="form-group">
							<div class="col-md-1">
								<input type="checkbox" name="category_id[]" value="<?php echo $val;?>">
							</div>
							<div class="col-md-10">
								<?php echo $key;?>
							</div>
						</div>
					</div>
					@endwhile

				</div>
		</div>
		{!! Form::close() !!}
		<div class="box-footer" style="background-color:#f5f5f5;">

				<span class="btn btn-info btn-sm" data-toggle="modal" data-target="#j">{{Lang::get('lang.addcategory')}}</span>
				<div class="modal" id="j">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        {!! Form::open(['method'=>'post','action'=>'Admin\kb\CategoryController@store']) !!}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">{{Lang::get('lang.addcategory')}}</h4>
                            </div>
                            <div class="modal-body">
                               	@include('themes.default1.admin.kb.category.form')
                            </div>
                            <div class="modal-footer">
                              	<div class="form-group">
                                    {!! Form::submit('Add')!!}
                                </div>
                            	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                        {!! Form::close() !!}
                      	</div>
                     </div>
                    </div>
		</div>
	</div>
</div>
</li>
</ul>
{{-- {!! Form::close() !!} --}}
@stop
@section('FooterInclude')

@stop

