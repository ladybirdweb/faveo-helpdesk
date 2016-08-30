@extends('themes.default1.admin.layout.admin')
@section('content')

<section class="content-heading-anchor">
    <h1>
        {{Lang::get('telephone::lang.telephone-integration')}}  


    </h1>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> {{Lang::get('telephone::lang.integrate')}}  </h4>
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
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif

    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{Lang::get('telephone::lang.provider')}}</th>
                            <th>{{Lang::get('telephone::lang.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @forelse($telephone->get() as $telephone)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{ucfirst($telephone->name)}}</td>
                            <td><a href="{{url('telephone/'.$telephone->short.'/settings')}}" class="btn btn-sm btn-primary">{{Lang::get('telephone::lang.settings')}}</a></td>
                        </tr>
                        <?php $i++;?>
                        @empty 
                        <tr>
                            <td>No Providers registered</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
