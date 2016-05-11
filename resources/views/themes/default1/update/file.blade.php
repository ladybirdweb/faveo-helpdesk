@extends('themes.default1.admin.layout.admin')
@section('content')
<div class="box box-primary">
    <div class="row">
        <div class="col-md-12">
            <div class="box-body">
                
                <p>Your files are outdated please update</p>
                <p><a href="{{$url}}" class="btn btn-default">Update Now</a></p>

            </div>
        </div>
    </div>
</div>
@stop