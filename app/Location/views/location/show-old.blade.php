@extends('themes.default1.admin.layout.admin')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.show-location')}}  


    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 
            {{ucfirst($location->title)}}  
            <a href="{{url('service-desk/location-types/'.$location->id.'/edit')}}" class="btn btn-default">{{Lang::get('service::lang.edit')}}</a>
        </h4>
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
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">


                <!-- /.box-header -->

                <table class="table table-condensed">

                    <tr>

                        <td>{{Lang::get('service::lang.title')}}</td>
                        <td>
                            {!!$location->title!!}
                        </td>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.email')}}</td>
                        <td>
                            {!!$location->email!!}
                        </td>
                    </tr>

                    <tr>
                        <td>{{Lang::get('service::lang.phone')}}</td>
                        <td>
                            {!!$location->phone!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.address')}}</td>
                        <td>
                            {!!$location->address!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.location_category')}}</td>
                        <td>
                            {!!$location->locationCategory()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.department')}}</td>
                        <td>
                            {!!$location->departments()!!}
                        </td>
                    </tr>
                    
                </table>
            </div>

        </div>
        <!-- /.box -->
    </div>
</div>


@stop
