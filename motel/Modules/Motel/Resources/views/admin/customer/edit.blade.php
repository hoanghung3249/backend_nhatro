@extends('layouts.master')

@section('content-header')
@section('styles')
{{--     {!! Theme::style('css/vendor/datepicker/datepicker3.css') !!}
    {!! Theme::script('js/vendor/datepicker/bootstrap-datepicker.js') !!} --}}
    {{-- <script type="text/javascript" src ="/modules/media/js/media-partial.js"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />

@stop
<h1>
    {{ trans('Chỉnh sửa thông tin khách') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class=""><a href="{{ URL::route('admin.customer.customer.index') }}">{{ trans('Danh sách khách') }}</a></li>
    <li class="active">{{ trans('user::users.breadcrumb.new') }}</li>
</ol>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('user::users.navigation.back to index') }}</dd>
    </dl>
@stop
@section('content')
{!! Form::model($cus,['route' => ['admin.customer.customer.update', $cus], 'method' => 'put']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                            <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                                    {!! Form::label('full_name', trans('Họ tên')) !!}
                                    {!! Form::text('full_name', old('full_name'), ['class' => 'form-control', 'placeholder' => trans('Vui lòng nhập vào họ tên')]) !!}
                                    {!! $errors->first('full_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    {!! Form::label('email', trans('Địa chỉ email (Nếu có)')) !!}
                                    {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: abc@gmail.com')]) !!}
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                        {!! Form::label('dob', 'Ngày sinh') !!}
                                        <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' class="form-control" value="{{$cus->getDOB()}}" name="dob" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        
                                    </div>
                                    {!! $errors->first('dob', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                            <div class="form-group{{ $errors->has('cmnd') ? ' has-error' : '' }}">
                                    {!! Form::label('cmnd', trans('Chứng minh nhân dân')) !!}
                                    {!! Form::number('cmnd', old('cmnd'), ['class' => 'form-control', 'placeholder' => trans('Vui lòng nhập vào số chứng minh nhân dân')]) !!}
                                    {!! $errors->first('cmnd', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    {!! Form::label('phone', trans('Số điện thoại')) !!}
                                    {!! Form::number('phone', old('phone'), ['class' => 'form-control', 'placeholder' => trans('Vui lòng nhập vào số điện thoại')]) !!}
                                    {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('birth_place') ? ' has-error' : '' }}">
                                    {!! Form::label('birth_place', trans('Nguyên quán')) !!}
                                    {!! Form::text('birth_place', old('birth_place'), ['class' => 'form-control', 'placeholder' => trans('Vui lòng nhập vào nguyên quán')]) !!}
                                    {!! $errors->first('birth_place', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('permanent_address') ? ' has-error' : '' }}">
                                    {!! Form::label('permanent_address', trans('Nơi đăng ký hộ khẩu thường trú')) !!}
                                    {!! Form::text('permanent_address', old('permanent_address'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: 976/28/4 Lê Văn Thọ, phường 13, quận Gò Vấp, TPHCM')]) !!}
                                    {!! $errors->first('permanent_address', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    {!! Form::label('gender', trans('Giới tính')) !!}
                                    <label class="radio-inline">Nam
                                        <input class="flat-blue" type="radio" name="gender" value="1" @if($cus->gender ==1) checked=""@endif>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="radio-inline">Nữ
                                        <input class="flat-blue" type="radio" name="gender" value="0" @if($cus->gender ==0) checked=""@endif>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('user::button.create') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.customer.customer.index')}}"><i class="fa fa-times"></i> {{ trans('user::button.cancel') }}</a>
                </div>
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}
@stop
@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('user::users.navigation.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
{{-- {!! JsValidator::formRequest('Modules\Motel\Http\Requests\CreateCustomerRequest') !!} --}}
<script type="text/javascript">
    jQuery(document).ready(function() {
        $(".js-example-basic-single").select2();
        $(".js-multiple").select2();
        // $('.datepicker').datepicker({
        //     format: 'dd M yyyy',
        //     autoclose: true,
        //     toggleActive: false
        //  });
        $('#datetimepicker1').datetimepicker({
            format : 'YYYY-MM-DD',
        });
        $('#datetimepicker2').datetimepicker({
            format : 'DD-MM-YYYY',
        }).attr('readonly','readonly');
        $("#datetimepicker2").keydown(false);
    });
</script>
<script type="text/javascript">
    CKEDITOR.replace('ckeditor_des',{
      height: '150px',
      toolbar:[
      ['Source','-','NewPage','Preview','-','Templates'],
      ['Styles','Format','Font','FontSize'],
      ['TextColor','BGColor'],
      ]
    });
    CKEDITOR.replace('ckeditor_info',{
      height: '150px',
      toolbar:[
      ['Source','-','NewPage','Preview','-','Templates'],
      ['Styles','Format','Font','FontSize'],
      ['TextColor','BGColor'],
      ]
    });
  </script>


<script>
$( document ).ready(function() {
    $(document).keypressAction({
        actions: [
            { key: 'b', route: "<?= route('admin.user.user.index') ?>" }
        ]
    });
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
});
</script>
@endpush
