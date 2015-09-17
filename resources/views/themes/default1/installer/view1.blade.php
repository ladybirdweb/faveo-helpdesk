@extends('themes.default1.layouts.installer')
@section('content')

<h1>Licence Agreement</h1>
	<div class="login-box-body">
	<!-- form -->
		<form action="{{URL::route('postlicence')}}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<!-- box -->
		<!-- form-group -->
			<div class="form-group" >
						@if(Session::has('fails'))
							<div class="alert alert-danger alert-dismissable">
				            <i class="fa fa-ban"></i>
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p>{!! Session::get('fails') !!}</p>
							</div>
						@endif
				 	Item is covered by our standard licenses. If your end product including the item is going to be free to the end user then a Regular License is what you need. An Extended License is required if the end user must pay to use the end product.</p>
				<!-- form-group -->
				<div class="form-group">
				<label><input type="checkbox" class="flat-red" id="accept" name="accept1"/> I accept</label> <br>
				</div>
				 	<button value="prev" disabled="" id="access1">Prev</button>
				 	<input type="submit" disabled="" value="Next" id="access"/>

			</div>
		<br>
		</form>
	</div>
</p>

	<script type="text/javascript">
		var checker = document.getElementById('accept');
		var sendbtn = document.getElementById('access');
		// when unchecked or checked, run the function
		checker.onchange = function(){
		    if(this.checked){
		        sendbtn.disabled = false;
		    } else {
		        sendbtn.disabled = true;
		    }
		}
		$(function() {
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
	                    checkboxClass: 'icheckbox_flat-red',
	                    radioClass: 'iradio_flat-red'
	                });
		});
	</script>

@stop