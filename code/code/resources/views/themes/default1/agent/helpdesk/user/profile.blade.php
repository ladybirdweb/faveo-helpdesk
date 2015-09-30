@extends('themes.default1.agent.layout.agent')


@section('content')

@section('Dashboard')
class="active"
@stop

@section('dashboard-bar')
active
@stop

@section('profile')
class="active"
@stop


            @section('profileimg')
	        	@if(Auth::user() && Auth::user()->profile_pic)
                    <img src="{{asset('lb-faveo/profilepic')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                @else
                    @if(Auth::user())
                         <img src="{{ Gravatar::src(Auth::user()->email,200) }}" class="img-circle" alt="User Image">
                    @endif
                @endif
	        @stop



<section class="content">
<div class="row">
{{-- style="background-image:url({{ URL::asset('/dist/img/boxed-bg.jpg')}}); color:#DBDBDB;" --}}
	<div class="col-md-12 box box-primary">
	    <div class="col-md-6">
	       	{{-- <div class="box box-success"> --}}
			{{-- <section class="content"> --}}
	       		{{-- <div class=" box-header"> --}}
			        	<h3><b>User Information</b>&nbsp;&nbsp;<a href="{{URL::route('agent-profile-edit')}}"><i class="fa fa-fw fa-edit"> </i></a></h3>
			        	{{-- </div> --}}
			        <div class="box-body">
			        	<table class="row">
				        	@if($user->gender == 1)
				        		<tr><th class="col-md-8"><h4><b>Gender:<b></h4></th><td class="col-md-6"><h4>{{ 'Male' }}</h4></td></tr>
				        	@else
				        		<tr><th class="col-md-8"><h4><b>gender:</b></h4></th><td class="col-md-6"><h4>{{ 'Female' }}</h4></td></tr>
				        	@endif
				        	<tr><th class="col-md-8"><h4><b>department:</b></h4></th><td class="col-md-6"><h4>{{ $user->primary_dpt }}</h4></td></tr>
				        	<tr><th class="col-md-8"><h4><b>group:</b></h4></th><td  class="col-md-6"><h4>{{ $user->assign_group }}</h4></td></tr>
				        	<tr><th class="col-md-8"><h4><b>Company:</b></h4></th><td  class="col-md-6"> <h4>{{ $user->company }}</h4></td></tr>
				        	<tr><th class="col-md-8"><h4><b>Time-zone:</b></h4></th><td  class="col-md-6"><h4> {{ $user->agent_tzone }}</h4></td></tr>
				        	<tr><th class="col-md-8"><h4><b>Role:</b></h4></th><td  class="col-md-6"> <h4>{{ $user->role }}</h4></td></tr>
			        	</table>
			    	</div>
			    {{-- </section> --}}
		    {{-- </div> --}}
	    </div>
	    <div class="col-md-6">
	      	{{-- <div class="box box-primary"> --}}
	      		{{-- <section class="content"> --}}
	      		<h3><b>Contact Information</b></h3>
		       		<div class="box-body">
			        	<table>
							<tr><th class="col-md-8"><h4><b>Email:</b></h4> </th> <td class="col-md-6"><h4> {{ $user->email }}</h4> </td></tr>
							<tr><th class="col-md-8"><h4><b>Phone Number:</b></h4> </th> <td class="col-md-6"><h4> {{ $user->ext }}{{ $user->phone_number }}</h4> </td></tr>
				        	<tr><th class="col-md-8"><h4><b>Moble:</b></h4></th><td class="col-md-6"><h4> {{ $user->mobile }}</h4></td></tr>
			        	</table>
		        	</div>
		        {{-- </section> --}}
	        </div>
	    {{-- </div> --}}
    </div>
</div>
</section>
@stop
