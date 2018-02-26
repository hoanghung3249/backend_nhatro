@extends('layouts.account')

@section('title')
    {{ trans('Khôi phục mật khẩu') }} | @parent
@stop

@section('content')
    <div class="login-logo">
        <a href="{{ url('/') }}">{{ setting('core::site-name') }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">{{ trans('Nhập vào email đăng ký để khôi phục mật khẩu') }}</p>
        @include('partials.notifications')

        {!! Form::open(['route' => 'reset.post']) !!}
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" autofocus
                       name="email" placeholder="{{ trans('user::auth.email') }}" value="{{ old('email')}}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">
                        {{ trans('Khôi phục mật khẩu') }}
                    </button>
                </div>
            </div>
        {!! Form::close() !!}

        <a href="{{ route('login') }}" class="text-center">{{ trans('Tôi đã nhớ lại mật khẩu') }}</a>
    </div>
@stop
