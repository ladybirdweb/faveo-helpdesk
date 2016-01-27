@extends('themes.default1.agent.layout.agent')
@extends('themes.default1.agent.layout.sidebar')    

@section('settings')
    class="active"
@stop

@section('content')
<!-- open a form -->
    {!! Form::model($settings,['url' => 'postsettings/'.$settings->id, 'method' => 'PATCH','files'=>true]) !!}

            <div class="box-header" style="margin:-5px;margin-top:-25px;">
                <h3 class="box-title">{{Lang::get('lang.settings')}}</h3>  {!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}
            </div>
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">{{Lang::get('lang.system')}}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                     {{-- For Form --}}
    <!-- check whether success or not -->
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
        <!-- Name text form Required -->
        <div class="row">
                <div class="col-md-3 form-group">
                    {!! Form::label('pagination',Lang::get('lang.numberofelementstodisplay')) !!}
                    {!! $errors->first('pagination', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('pagination',$settings->pagination,['class' => 'form-control']) !!}
                </div>
            </div>
        </div><!-- /.tab-pane -->
        
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->

<script type="text/javascript">
    $(function () {
        $("textarea").wysihtml5();
    });
</script>

@stop
