<a href="#child"  data-toggle="modal" class="btn btn-primary" data-target="#child{{$field->id}}">Add Child</a>
<div class="modal fade" id="child{{$field->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
                {!! Form::model($field,['url'=>'forms/field/'.$field->id.'/child','method'=>'POST']) !!}
            </div>
            <div class="modal-body">
                <!-- Form  -->
                <div class="row">
                    @forelse($field->values()->get() as $value)
                    <div class="col-md-12">
                        <b>{{$value->field_value}}</b>
                         {!! Form::select($value->id,[''=>'Select','Forms'=>$select_forms],$value->childId(),['class'=>'form-control']) !!}
                    </div>
                    @empty 
                    <div class="col-md-12">
                        <p>No values</p>
                    </div>
                    @endforelse
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="{{trans('lang.save')}}">
                {!! Form::close() !!}
            </div>
            <!-- /Form -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
