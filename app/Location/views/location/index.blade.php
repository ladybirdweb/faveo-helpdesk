@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('tickets-bar')
active
@stop

@section('location')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.location') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop

<!-- content -->
@section('content')


    @if (Session::has('message'))
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ Session::get('message') }}</p>
    </div>
    @endif
    @if (Session::has('fails'))
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ Session::get('fails') }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4>{{Lang::get('lang.list_of_location')}}</h4>
                    <div class="pull-right">

                        <a href="{!!URL::route('helpdesk.location.create')!!}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;
                        {{Lang::get('lang.create_location')}}</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">


 <table class="table table-bordered dataTable" id="myTable">
        <thead>
            <tr>
                <th width="100px">{{Lang::get('lang.name')}}</th>
                <th width="100px">{{Lang::get('lang.email')}}</th>
                <th width="100px">{{Lang::get('lang.phone')}}</th>
                
                <th width="100px">{{Lang::get('lang.address')}}</th>
              
                <th width="100px">{{Lang::get('lang.action')}}</th>
            </tr>
            </thead>
         
            <!-- Foreach @var$topics as @var topic -->
             <tbody>
            @foreach($locations as $location)
            @if($location->id == 1)
                       
                        <?php
                        $disable = 'disabled';
                        ?>
                        @else
                        <?php
                        $disable = '';
                        ?>
                        @endif

            <tr style="padding-bottom:-30px">
               <td title="{{$location->title}}">{{str_limit($location->title, 15)}}</td>
               <td title="{{$location->email}}">{{str_limit($location->email, 15)}}</td>
               <td>{{$location->phone}}</td>
               <td title="{{$location->address}}">{{str_limit($location->address, 15)}}</td>
               <td>
                  
                 {!! Form::open(['route'=>['helpdesk.location.delete', $location->id],'method'=>'post']) !!}
                    <a href="{{route('helpdesk.location.edit',$location->id)}}" class="btn btn-primary btn-xs "><i class="fa fa-edit" style="color:white;"> </i> &nbsp;{!! Lang::get('lang.edit') !!}</a>&nbsp;
                    <!-- To pop up a confirm Message -->
                    {!! Form::button('<i class="fa fa-trash" style="color:white;"> </i> &nbsp;'.Lang::get('lang.delete'),
                    ['type' => 'submit',
                    'class'=> 'btn btn-primary btn-xs  '.$disable,
                    'onclick'=>'return confirm("Are you sure?")'])
                    !!}
                    </div>
                    {!! Form::close() !!}



               </td>

                @endforeach
            </tr>
            </tbody>
            <!-- Set a link to Create Page -->

        </table>
    </div>
</div>
    
<script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="{{asset("lb-sample/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-sample/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    $("#myTable").dataTable();
   
});

</script>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
</section>
<!-- /.content -->
</div>

@stop