
<div class="box-body" >
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

	<div class="row">

		<div class="col-xs-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">

			{!! Form::label('name','Name') !!}
			{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('name',null,['class' => 'form-control']) !!}

		</div>

		{{--  --}}

		<div class="col-xs-4 form-group {{ $errors->has('status') ? 'has-error' : '' }}">

			{!! Form::label('status','Status') !!}
			{!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
			<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('status','1',true) !!}Active
				</div>
				<div class="col-xs-3">
					{!! Form::radio('status','0',null) !!}Inactive
				</div>
			</div>
		</div>

	</div>
		<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
				{!! Form::label('description','Description') !!}
				{!! $errors->first('description', '<spam class="help-block">:message</spam>') !!}

					{!! Form::textarea('description',null,['class' => 'form-control','size' => '50x10','id'=>'myNicEditor','placeholder'=>'Enter the description']) !!}
		</div>
</div>

