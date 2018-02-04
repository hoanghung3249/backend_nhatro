@extends('layouts.master')

@section('content-header')
@section('styles')
{{--     {!! Theme::style('css/vendor/datepicker/datepicker3.css') !!}
    {!! Theme::script('js/vendor/datepicker/bootstrap-datepicker.js') !!} --}}
    {{-- <script type="text/javascript" src ="/modules/media/js/media-partial.js"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
{{--   <base href="{{ asset('') }}"> --}}

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
    {{ trans('Chỉnh sửa thủ tục') }}
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
{!! Form::model($booking,['route' => ['admin.bookings.bookings.update', $booking], 'method' => 'put']) !!}
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
                                    <p>Bạn có thể nhập vào từ khoá để tìm kiếm tên khách hàng theo danh sách mà bạn đã tạo tại mục "Danh sách người thuê".</p>
                                    {!! Form::text('full_name', old('full_name'), ['id'=> 'full_name','class' => 'form-control', 'placeholder' => trans('Nhập từ khoá để tìm kiếm tên ( Ví dụ: Ng... )')]) !!}
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

                            <div class="form-group{{ $errors->has('unit_price') ? ' has-error' : '' }}">
                                    {!! Form::label('unit_price', trans('Gía phòng')) !!}
                                    {!! Form::text('unit_price', old('unit_price'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: 5000000')]) !!}
                                    {!! $errors->first('unit_price', '<span class="help-block">:message</span>') !!}
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('down_payment') ? ' has-error' : '' }}">
                                    {!! Form::label('down_payment', trans('Tiền cọc')) !!}
                                    {!! Form::number('down_payment', old('down_payment'), ['disabled','class' => 'form-control', 'placeholder' => trans('Ví dụ: 2000000')]) !!}
                                    {!! $errors->first('down_payment', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                {!! Form::label('name', 'Phòng đang ở') !!}
{{--                                     <select class="js-example-basic-single form-control" name="room_id" id="room_id">
                                    <option value="0">Phòng</option>
                                    @foreach($room as $item)
                                      <option value="{{ $item->id }}" @if($item->id == $booking->room_id || $item->id == old('room_id')) selected="" @endif>{{ $item->name }}</option>
                                    @endforeach
                                    </select> --}}
                                    <input type="text" disabled="" class="form-control" name="room_id" value="{{ $booking->getRoom->name }}">
                                   {{--  {!! Form::text('room_id', old('room_id'), ['disabled','class' => 'form-control']) !!} --}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                            {!! Form::label('start_date', 'Ngày thuê') !!}
                                            <div class='input-group date' id='datetimepicker2'>
                                            <input disabled type='text' class="form-control" value="{{ $booking->getNgaythue() }}" name="start_date" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                            
                                        </div>
                                        {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('number_of_bike') ? ' has-error' : '' }}">
                                            {!! Form::label('number_of_bike', trans('Số lượng xe')) !!}
                                            {!! Form::number('number_of_bike', old('number_of_bike'), ['class' => 'form-control', 'placeholder' => trans('Ví dụ: 2')]) !!}
                                            {!! $errors->first('number_of_bike', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2">Ghi chú</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control ckeditor" name="note">{{ $booking->note }}</textarea>
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
                                        @foreach($customer_of_room as $item)
                                        <tr data-id ="{{ $item->id }}">
                                            <td><i class="fa fa-times del aria-hidden="true" style="cursor:pointer;color:red"><input id="id_cus" name="id_cus[]" class="id_cus" type="hidden" value='{{ $item->id }}' ></i></td>
                                            <td>{{ $item->getHoTen() }}</td>
                                            <td>{{ $item->getDOB() }}</td>
                                            <td>{{ $item->getGioiTinh() }}</td>
                                            <td>{{ $item->getSDT() }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('Cập nhật') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.room.room.index')}}"><i class="fa fa-times"></i> {{ trans('Hủy bỏ') }}</a>
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
{{-- {!! JsValidator::formRequest('Modules\Motel\Http\Requests\CreateRoomRequest') !!} --}}
<script type="text/javascript">
    jQuery(document).ready(function() {

        var arr_id = [];
        $("#full_name").change(function(event) {
            
            $.ajax({
                url: '{{ route('admin.bookings.bookings.getallcusajax') }}',
                type: 'get',
                dataType: 'html',

            })
            .done(function(data) {
                console.log(data);
            })
        });

        

        $(".id_cus").each(function(key , value){
            arr_id.push(parseInt( $(this).val()) );
        });

        $(".js-example-basic-single").select2({ width: '100%' });
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
            format : 'DD-MM-YYYY',
        });


        $( "#full_name" ).autocomplete({
            source: "{{ route('admin.bookings.bookings.autocompletecustomer') }}",
            minlenght:1,
            autoFocus: true,
            select:function(e,ui){
                $(this).val('');
                var id_cus = ui.item.id;
                arr_id.push(id_cus);
                //console.log(arr_id);
                $('#myTable > tbody:last-child').append('<tr data-id ="'+ui.item.id+'"><td><i class="fa fa-times del aria-hidden="true" style="cursor:pointer;color:red"><input id="id_cus" name="id_cus[]" class="id_cus" type="hidden" value='+ui.item.id+' ></i></td><td>'+ui.item.value+'</td><td>'+ui.item.dob+'</td><td>'+ui.item.gender+'</td><td>'+ui.item.phone+'</td></tr>');
                $('html, body').animate({ scrollTop: $(document).height() }, 1200);
                return false;

            },
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            //console.log(item);
                if(arr_id.length > 0){
                var flag = false;
                arr_id.forEach(function(value){
                    if(item.id == value){
                        flag = true;
                    } 
                });
                if(flag){
                    return $("");
                }
            }
          return $( "<li>" )
            .append("<li><img src ='{{ URL::to('images/p2.png') }}' style ='float:left; width:34px; border:1px solid #0000'><span class='suggest-name'>" +"&nbsp;" + item.value + "</span><span class='suggest-description'>" +"&nbsp;" + item.phone + "</span></li>")
            .appendTo( ul );
        };
        $("body").on("click",".del",function(){
            $(this).parent().parent().remove();

            
            var a = $(this).parent().parent().attr("data-id");
            arr_id.splice(
                arr_id.indexOf(
                    parseInt(
                        $(this).parent().parent().
                        find(".id_cus").val()
                    )
                ),1);
            //console.log(arr_id);
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
