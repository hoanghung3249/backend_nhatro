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
<style>
.suggest-holder {
    width: 150px;
}
    .suggest-holder input {
        width: 146px;
        border: 1px solid rgba(0,120,0,.6);
    }
    .suggest-holder ul {
        display: none;
        list-style: none;
        margin: 0;
        padding: 0;
        border: 1px solid rgba(0,120,0,.6);
        margin-top: -6px;
    }
        .suggest-holder li {
            padding: 5px;
        }
        .suggest-holder li:hover {
            cursor: pointer;
        }
        .ui-state-active{
            background: rgba(0,120,0, .2)!important;
        }
        /*#9bd0ef*/
/*        .suggest-holder li:hover, li.active {
            background: rgba(0,120,0, .2);
        }*/
            .suggest-name {
                font-weight: bold;
                display: block;
                height: 15px;
            }
            .suggest-description {
                font-style: italic;
                font-size: 11px;
                color: #999;
            }

</style>
<h1>
    {{ trans('Tạo mới thủ tục') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class=""><a href="{{ URL::route('admin.bookings.bookings.index') }}">{{ trans('Phòng đang được thuê') }}</a></li>
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
                            <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                                    {!! Form::label('full_name', trans('Họ tên')) !!}
                                    {!! Form::text('full_name', old('full_name'), ['id'=> 'full_name','class' => 'form-control', 'placeholder' => trans('Nhập vào tên phòng')]) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
{{--                                 <div class="beta-comp">
                                    <form role="search" method="get" id="searchform" action="">
                                        <input type="text" value="" name="s" id="s" placeholder="Nhập từ khóa..." />
                                        <button class="fa fa-search" type="submit" id="searchsubmit"></button>
                                    </form>
                                </div> --}}

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    {!! Form::label('name', trans('Ngày thuê')) !!}
                                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('Nhập vào ngày thuê phòng')]) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('erea') ? ' has-error' : '' }}">
                                    {!! Form::label('erea', trans('Tiền cọc')) !!}
                                    {!! Form::number('erea', old('erea'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: 20')]) !!}
                                    {!! $errors->first('erea', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    {!! Form::label('name', trans('Tên phòng')) !!}
                                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('Nhập vào tên phòng')]) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    {!! Form::label('name', trans('Gía phòng')) !!}
                                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('Nhập vào gía phòng')]) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <hr />
                        <h1>Thành viên thuê phòng</h1>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover data-table" id="myTable" cellspacing="0" width="100%">
                                     <thead>
                                        <tr>
                                            <th style="width:8%">Check box</th>
                                            <th>Họ Tên</th>
                                            <th>Ngày Sinh</th>
                                            <th>Giới Tính</th>
                                            <th>Số Điện Thoại</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
{{--                                         <tr>
                                            <td>asd</td>
                                            <td>asd</td>
                                            <td>asd</td>
                                            <td>asd</td>
                                            <td>asd</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
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



        $( "#full_name" ).autocomplete({
            source: "{{ route('admin.bookings.bookings.autocompletecustomer') }}",
            minlenght:1,
            autoFocus: true,
            select:function(e,ui){
                //console.log(ui);
                // window.location.href = "dat-hang/"+ui.item.id;
                $(this).val('');
                var id_cus = ui.item.id;
                $('#myTable > tbody:last-child').append('<tr><td><i class="fa fa-times del aria-hidden="true" style="cursor:pointer;color:red"><input id="id_cus" type="hidden" value='+ui.item.id+' ></i></td><td>'+ui.item.value+'</td><td>'+ui.item.dob+'</td><td>'+ui.item.gender+'</td><td>'+ui.item.phone+'</td></tr>');

                
                return false; 


            },
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .append("<li><span class='suggest-name'>" + item.value + "</span><span class='suggest-description'>" + item.phone + "</span></li>")
            .appendTo( ul );
        };
        $("body").on("click",".del",function(){
            $(this).parent().parent().remove();
        })

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
