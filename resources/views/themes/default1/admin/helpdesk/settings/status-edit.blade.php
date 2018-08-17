@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('status')
class="active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.status_settings') !!}</h1>
@stop

@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop


@section('content')
{!! Form::model($status,['route'=>['statuss.update', $status->id],'method'=>'PATCH','files' => true]) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.edit_details') !!}</h4>
    </div><!-- /.box-header -->
    <div class="box-body">
         @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @foreach ($errors->all() as $error)
            <li class="error-message-padding">{{ $error }}</li>
            @endforeach 
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('failed'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('failed')}}</p>                
        </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.name') !!}: <span class="text-red"> *</span></label><br>
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('sort') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.display_order') !!}: <span class="text-red"> *</span></label><br>
                    <input type="number" name="sort" min="1" class="form-control" value="{!! $status->sort !!}">
                </div>  
            </div><div class="col-md-2">
                <div class="form-group {{ $errors->has('icon_class') ? 'has-error' : '' }}">
                    <i class=></i>
                    <label>{!! Lang::get('lang.icon_class') !!}: <span class="text-red"> *</span></label><br>
                    <select class="form-control icons"  name="icon_class" style="font-family: FontAwesome, sans-serif;" required>
                        <option <?php if ($status->icon_class == "fa fa fa-edit") echo 'selected="selected"' ?> value="fa fa-edit">&#xf044</option>
                        <option <?php if ($status->icon_class == "fa fa-folder-open") echo 'selected="selected"' ?> value="fa fa-folder-open">&#xf07c</option>
                        <option <?php if ($status->icon_class == "fa fa-minus-circle") echo 'selected="selected"' ?> value="fa fa-minus-circle">&#xe082</option>
                        <option <?php if ($status->icon_class == "glyphicon glyphicon-alert") echo 'selected="selected"' ?> value="glyphicon glyphicon-alert">&#xe209</option>
                        <option <?php if ($status->icon_class == "fa fa fa-bars") echo 'selected="selected"' ?> value="fa fa-bars">&#xf0c9</option>
                        <option <?php if ($status->icon_class == "fa fa-bell-o") echo 'selected="selected"' ?> value="fa fa-bell-o">&#xf0a2</option>
                        <option <?php if ($status->icon_class == "fa fa-bookmark-o") echo 'selected="selected"' ?> value="fa fa-bookmark-o">&#xf097</option>
                        <option <?php if ($status->icon_class == "fa fa-bug") echo 'selected="selected"' ?> value="fa fa-bug">&#xf188</option>
                        <option <?php if ($status->icon_class == "fa fa-bullhorn") echo 'selected="selected"' ?> value="fa fa-bullhorn">&#xf0a1</option>
                        <option <?php if ($status->icon_class == "fa fa-calendar") echo 'selected="selected"' ?> value="fa fa-calendar">&#xf073</option>
                        <option <?php if ($status->icon_class == "fa fa-cart-plus") echo 'selected="selected"' ?> value="fa fa-cart-plus">&#xf217</option>
                        <option <?php if ($status->icon_class == "fa fa-check") echo 'selected="selected"' ?> value="fa fa-check">&#xf00c</option>
                        <option <?php if ($status->icon_class == "fa fa-check-circle") echo 'selected="selected"' ?> value="fa fa-check-circle">&#xf058</option>
                        <option <?php if ($status->icon_class == "fa fa-check-circle-o") echo 'selected="selected"' ?> value="fa fa-check-circle-o">&#xf05d</option>
                        <option <?php if ($status->icon_class == "fa fa-check-square") echo 'selected="selected"' ?> value="fa fa-check-square">&#xf14a</option>
                        <option <?php if ($status->icon_class == "fa fa-check-square-o") echo 'selected="selected"' ?> value="fa fa-check-square-o">&#xf046</option>
                        <option <?php if ($status->icon_class == "fa fa-circle-o-notch") echo 'selected="selected"' ?> value="fa fa-circle-o-notch">&#xf1ce</option>
                        <option <?php if ($status->icon_class == "fa fa-clock-o") echo 'selected="selected"' ?> value="fa fa-clock-o">&#xf017</option>
                        <option <?php if ($status->icon_class == "fa fa-close") echo 'selected="selected"' ?> value="fa fa-close">&#xf00d</option>
                        <option <?php if ($status->icon_class == "fa fa-code") echo 'selected="selected"' ?> value="fa fa-code">&#xf121</option>
                        <option <?php if ($status->icon_class == "fa fa-hand-paper-o") echo 'selected="selected"' ?> value="fa fa-hand-paper-o">&#xf256</option>
                        <option <?php if ($status->icon_class == "fa fa-hourglass-half") echo 'selected="selected"' ?> value="fa fa-hourglass-half">&#xf252</option>
                        <option <?php if ($status->icon_class == "fa fa-cog") echo 'selected="selected"' ?> value="fa fa-cog">&#xf013</option>
                        <option <?php if ($status->icon_class == "fa fa-cogs") echo 'selected="selected"' ?> value="fa fa-cogs">&#xf085</option>
                        <option <?php if ($status->icon_class == "fa fa-comment") echo 'selected="selected"' ?> value="fa fa-comment">&#xf075</option>
                        <option <?php if ($status->icon_class == "fa fa-comment-o") echo 'selected="selected"' ?> value="fa fa-comment-o">&#xf0e5</option>
                        <option <?php if ($status->icon_class == "fa fa-commenting") echo 'selected="selected"' ?> value="fa fa-commenting">&#xf27a</option>
                        <option <?php if ($status->icon_class == "fa fa-commenting-o") echo 'selected="selected"' ?> value="fa fa-commenting-o">&#xf27b</option>
                        <option <?php if ($status->icon_class == "fa fa-comments") echo 'selected="selected"' ?> value="fa fa-comments">&#xf086</option>
                        <option <?php if ($status->icon_class == "fa fa-comments-o") echo 'selected="selected"' ?> value="fa fa-comments-o">&#xf0e6</option>
                        <option <?php if ($status->icon_class == "fa fa-edit") echo 'selected="selected"' ?> value="fa fa-edit">&#xf044</option>
                        <option <?php if ($status->icon_class == "fa fa-envelope-o") echo 'selected="selected"' ?> value="fa fa-envelope-o">&#xf003</option>
                        <option <?php if ($status->icon_class == "fa fa-exchange") echo 'selected="selected"' ?> value="fa fa-exchange">&#xf0ec</option>
                        <option <?php if ($status->icon_class == "fa fa-exclamation") echo 'selected="selected"' ?> value="fa fa-exclamation">&#xf12a</option>
                        <option <?php if ($status->icon_class == "fa fa-exclamation-triangle") echo 'selected="selected"' ?> value="fa fa-exclamation-triangle">&#xf071</option>
                        <option <?php if ($status->icon_class == "fa fa-external-link") echo 'selected="selected"' ?> value="fa fa-external-link">&#xf08e</option>
                        <option <?php if ($status->icon_class == "fa fa-eye") echo 'selected="selected"' ?> value="fa fa-eye">&#xf06e</option>
                        <option <?php if ($status->icon_class == "fa fa-feed") echo 'selected="selected"' ?> value="fa fa-feed">&#xf09e</option>
                        <option <?php if ($status->icon_class == "fa fa-flag-o") echo 'selected="selected"' ?> value="fa fa-flag-o">&#xf11d</option>
                        <option <?php if ($status->icon_class == "fa fa-flash") echo 'selected="selected"' ?> value="fa fa-flash">&#xf0e7</option>
                        <option <?php if ($status->icon_class == "fa fa-folder-o") echo 'selected="selected"' ?> value="fa fa-folder-o">&#xf114</option>
                        <option <?php if ($status->icon_class == "fa fa-folder-open-o") echo 'selected="selected"' ?> value="fa fa-folder-open-o">&#xf115</option>
                        <option <?php if ($status->icon_class == "fa fa-group") echo 'selected="selected"' ?> value="fa fa-group">&#xf0c0</option>
                        <option <?php if ($status->icon_class == "fa fa-info") echo 'selected="selected"' ?> value="fa fa-info">&#xf129</option>
                        <option <?php if ($status->icon_class == "fa fa-life-ring") echo 'selected="selected"' ?> value="fa fa-life-ring">&#xf1cd</option>
                        <option <?php if ($status->icon_class == "fa fa-line-chart") echo 'selected="selected"' ?> value="fa fa-line-chart">&#xf201</option>
                        <option <?php if ($status->icon_class == "fa fa-location-arrow") echo 'selected="selected"' ?> value="fa fa-location-arrow">&#xf124</option>
                        <option <?php if ($status->icon_class == "fa fa-lock") echo 'selected="selected"' ?> value="fa fa-lock">&#xf023</option>
                        <option <?php if ($status->icon_class == "fa fa-mail-forward") echo 'selected="selected"' ?> value="fa fa-mail-forward">&#xf064</option>
                        <option <?php if ($status->icon_class == "fa fa-mail-reply") echo 'selected="selected"' ?> value="fa fa-mail-reply">&#xf112</option>
                        <option <?php if ($status->icon_class == "fa fa-mail-reply-all") echo 'selected="selected"' ?> value="fa fa-mail-reply-all">&#xf122</option>
                        <option <?php if ($status->icon_class == "fa fa-times") echo 'selected="selected"' ?> value="fa fa-times">&#xf00d</option>
                        <option <?php if ($status->icon_class == "fa fa-trash-o") echo 'selected="selected"' ?> value="fa fa-trash-o">&#xf014</option>
                        <option <?php if ($status->icon_class == "fa fa-user") echo 'selected="selected"' ?> value="fa fa-user">&#xf007</option>
                        <option <?php if ($status->icon_class == "fa fa-user-plus") echo 'selected="selected"' ?> value="fa fa-user-plus">&#xf234</option>
                        <option <?php if ($status->icon_class == "fa fa-user-secret") echo 'selected="selected"' ?> value="fa fa-user-secret">&#xf21b</option>
                        <option <?php if ($status->icon_class == "fa fa-user-times") echo 'selected="selected"' ?> value="fa fa-user-times">&#xf235</option>
                        <option <?php if ($status->icon_class == "fa fa-users") echo 'selected="selected"' ?> value="fa fa-users">&#xf0c0</option>
                        <option <?php if ($status->icon_class == "fa fa-wrench") echo 'selected="selected"' ?> value="fa fa-wrench">&#xf0ad</option>
                        <option <?php if ($status->icon_class == "fa fa-circle-o-notch") echo 'selected="selected"' ?> value="fa fa-circle-o-notch">&#xf1ce</option>
                        <option <?php if ($status->icon_class == "fa fa-refresh") echo 'selected="selected"' ?> value="fa fa-refresh">&#xf021</option>
                        <option <?php if ($status->icon_class == "fa fa-spinner") echo 'selected="selected"' ?> value="fa fa-spinner">&#xf110</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <!-- gender -->
            {!! Form::label('gender',Lang::get('lang.resolved_status')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg3') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('state','closed',true) !!} {{Lang::get('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('state','open') !!} {{Lang::get('lang.no')}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <!-- Email user -->
            {!! Form::label('gender',Lang::get('lang.deleted_status')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg2') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('delete','yes') !!} {{Lang::get('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('delete','no') !!} {{Lang::get('lang.no')}}
                </div>
            </div>        
        </div>
        <div class="form-group">
            <!-- gender -->
            {!! Form::label('gender',Lang::get('lang.notify_user')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg1') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('email_user','yes') !!} {{Lang::get('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('email_user','no') !!} {{Lang::get('lang.no')}}
                </div>
            </div>        
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
    {!! Form::close() !!}
</div> 
@stop