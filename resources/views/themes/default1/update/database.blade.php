@extends('themes.default1.layouts.login')
@section('body')


            <div class="row">
                <div class="col-xs-12">  
                    <h3>Database Update Required</h3>
                    <p>{{ucfirst(Config::get('app.name'))}} has been updated! Before we send you on your own way,
                    we have to update your database to the newest version.</p>
                    <p>The update process may take a little while, so please be patient.</p>
                    <p><a href="{{$url}}" class="btn btn-default">Update {{ucfirst(Config::get('app.name'))}} Database</a></p>
                </div>
            </div>
       
@stop