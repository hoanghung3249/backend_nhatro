{{-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
	    <label for="exampleInputEmaíl">New password</label>
	    <input type="password" class="form-control" id="exampleInputEmaíl" name="password" aria-describedby="emailHelp" placeholder="Please enter your new password">
	    <input type="hidden" name="token" value="{{ $token }}">
	    <input type="hidden" name="id" value="{{ $id }}">
	    {{ <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}

{{-- 	  </div>

	  <div class="form-group">
	    <label for="exampleInputPasswórd">Confirm password</label>
	    <input type="password" class="form-control" id="exampleInputPasswórd" name="password_confirm" placeholder="Password confirm">
	  </div>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}


@extends('layouts.account')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('content')
    <div class="login-logo">
        <a href="{{ url('/') }}">{{ setting('core::site-name') }}</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">{{ trans('Khôi phục mật khẩu') }}</p>
        @include('partials.notifications')

        <form action="{{ route('resetpassword') }}" method="post">
{{-- 		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif --}}
		@if(Session::has('message'))
			<p class="alert alert-info">{{ Session::get('message') }}</p>
		@endif
		{{ csrf_field() }}
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" autofocus
                   name="password" placeholder="{{ trans('user::auth.password') }}">
            <input type="hidden" name="token" value="{{ $token }}">
	    	<input type="hidden" name="id" value="{{ $id }}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirm') ? ' has-error has-feedback' : '' }}">
            <input type="password" name="password_confirm" class="form-control" placeholder="{{ trans('user::auth.password confirmation') }}">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">
                    {{ trans('Khôi phục mật khẩu') }}
                </button>
            </div>
        </div>
        </form>
    </div>
@stop
