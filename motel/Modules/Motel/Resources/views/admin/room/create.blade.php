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
    {{ trans('Tạo mới phòng') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class=""><a href="{{ URL::route('admin.room.room.index') }}">{{ trans('Danh sách phòng') }}</a></li>
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
{!! Form::open(['route' => 'admin.room.room.store', 'method' => 'post']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    {!! Form::label('name', trans('Tên phòng')) !!}
                                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('Nhập vào tên phòng')]) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('erea') ? ' has-error' : '' }}">
                                    {!! Form::label('erea', trans('Diện tích (mét vuông)')) !!}
                                    {!! Form::number('erea', old('erea'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: 20')]) !!}
                                    {!! $errors->first('erea', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('erea') ? ' has-error' : '' }}">
                                    {!! Form::label('unit_price', trans('Giá phòng (VNĐ)')) !!}
                                    {!! Form::number('unit_price', old('unit_price'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: 5000000')]) !!}
                                    {!! $errors->first('unit_price', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('payment_on_electricity') ? ' has-error' : '' }}">
                                    {!! Form::label('payment_on_electricity', trans('Tiền điện (/Kwh)')) !!}
                                    {!! Form::number('payment_on_electricity', old('payment_on_electricity'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: 3500')]) !!}
                                    {!! $errors->first('payment_on_electricity', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('payment_of_water') ? ' has-error' : '' }}">
                                    {!! Form::label('payment_of_water', trans('Tiền nước (/m3)')) !!}
                                    {!! Form::number('payment_of_water', old('payment_of_water'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: 20000')]) !!}
                                    {!! $errors->first('payment_of_water', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('user::button.create') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.room.room.index')}}"><i class="fa fa-times"></i> {{ trans('user::button.cancel') }}</a>
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
{!! JsValidator::formRequest('Modules\Motel\Http\Requests\CreateRoomRequest') !!}
<script type="text/javascript">
    jQuery(document).ready(function() {
        $(".js-example-basic-single").select2();
        $(".js-multiple").select2();
        $('.datepicker').datepicker({
            format: 'dd M yyyy',
            autoclose: true,
            toggleActive: false
         });
        $('#datetimepicker1').datetimepicker({
            format : 'YYYY-MM-DD',
        });
        $('#datetimepicker2').datetimepicker({
            format : 'YYYY-MM-DD',
        });
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
