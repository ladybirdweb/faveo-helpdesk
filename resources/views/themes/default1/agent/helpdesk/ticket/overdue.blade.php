@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('overdue')
class="active"
@stop

@section('content')
<!-- Main content -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Overdue </h3> 
    </div><!-- /.box-header -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"> </i> 
            <b> Success </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> 
            <b> Fail! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
    <div class="box-body no-padding ">
       
    {!! Form::open(['route'=>'select_all','method'=>'post']) !!}

        <div class="mailbox-controls">
        <h3 class="pull-right" style="margin-top:0;margin-bottom:0;"> </h3>
            <!-- Check all button -->
            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
            <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a>
            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="Delete">
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="Close">
        </div>
<div class="mailbox-messages" id="refresh">
        <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>{!! Lang::get('lang.loading') !!}...</b></p>
        <!-- table -->
            {!! Datatable::table()
        ->addColumn(
                    "",
                    Lang::get('lang.subject'),
                    Lang::get('lang.ticket_id'),
                    Lang::get('lang.from'),
                    Lang::get('lang.last_replier'),
                    Lang::get('lang.assigned_to'),
                    Lang::get('lang.last_activity'))
        ->setUrl(route('get.overdue.ticket')) 
        ->setClass('table table-hover table-bordered table-striped')       
        ->render();!!}

        </div><!-- /.mail-box-messages -->
        {!! Form::close() !!}
    </div><!-- /.box-body -->
</div><!-- /. box -->


<script>
      $(function () {
        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }          
          $(this).data("clicks", !clicks);
        });
      });



    $(function() {
        // Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function() {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
            } else {
                //Check all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
            }
            $(this).data("clicks", !clicks);
        });
    });


    $(document).ready(function() { /// Wait till page is loaded
        $('#click').click(function() {
            $('#refresh').load('open #refresh');
            $("#show").show();
        });
    });

</script>
@stop