@extends('themes.default1.admin.layout.admin')
@section('content')

<section class="content-heading-anchor">
    <h1>
        {{Lang::get('zapier::lang.zapier-integrations')}}  


    </h1>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap2/bootstrap-switch.css" rel="stylesheet">
</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> {{Lang::get('zapier::lang.applications')}}  </h4>
        <!-- /.box-header -->
        <!-- form start -->
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
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- fail message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.failed')}}.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif

    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-borderless table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Application</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        @forelse($apps as $app)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{ucfirst(camel_case($app))}}</td>
                            <td>
                                {!! Form::checkbox($app,null,$zapier->status($app),['id'=>'status']) !!}
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @empty 
                        <tr>
                            <td>--</td>
                            <td>No applications</td>
                            <td>--</td>
                        </tr>
                        @endforelse 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('FooterInclude')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.js"></script>
<script>
$.fn.bootstrapSwitch.defaults.size = 'normal';
$.fn.bootstrapSwitch.defaults.onColor = 'success';
$.fn.bootstrapSwitch.defaults.offColor = 'danger';
$("[id='status']").bootstrapSwitch({
    onSwitchChange: function(event, state){
        var app = event.currentTarget.name;
        $.ajax({
            url : "{{url('zapier/activate')}}/"+app,
            data : {'status':state},
            type: 'POST',
        });
    }
});

</script>
@stop
