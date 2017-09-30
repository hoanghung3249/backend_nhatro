<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div class="well container"  style="margin-top:150px">
	<form action="{{ route('resetpassword') }}" method="post">
	@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
	@if(Session::has('message'))
		<p class="alert alert-info">{{ Session::get('message') }}</p>
	@endif
	{{ csrf_field() }}
	  <div class="form-group">
	  	<h2>Change password</h2>
	    <label for="exampleInputEmail1">New password</label>
	    <input type="password" class="form-control" id="exampleInputEmail1" name="password" aria-describedby="emailHelp" placeholder="Please enter your new password">
	    <input type="hidden" name="token" value="{{ $token }}">
	    <input type="hidden" name="id" value="{{ $id }}">
	    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Confirm password</label>
	    <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirm" placeholder="Password confirm">
	  </div>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>