@extends('themes.default1.admin.layout.admin')

@section('PageHeader')
<h1>{!! Lang::get('lang.templates') !!}</h1>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.edit_templates') !!}</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('failed'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('failed')}}</p>                
        </div>
        @endif
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{!! Lang::get('lang.type') !!}</th>
                    <th>{!! Lang::get('lang.description') !!}</th>
                    <th>{!! Lang::get('lang.action') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                <tr>
                    <?php $type = App\Model\Common\TemplateType::where('id','=',$template->type)->first(); ?>
                    <td>{!! $type->name !!}</td>
                    <td>{!! $template->name !!}</td>
                    <td>
               <!--    {!! link_to_route('templates.edit', Lang::get('lang.edit_templates'),[$template->id],['class'=>'btn btn-primary btn-sm']) !!}  -->
                  
                     <div class="btn-group">
                        <a href="{{route('templates.edit', $template->id)}}" class="btn btn-primary btn-xs"><i class="fa fa-edit">&nbsp;&nbsp;</i>{{Lang::get('lang.edit')}}</a>&nbsp;
                         </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>

<!-- status script -->
<script type="text/javascript">
$(function() {
    $("#example1").dataTable();
    $('#example2').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
    });
});
</script>
<script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
@stop