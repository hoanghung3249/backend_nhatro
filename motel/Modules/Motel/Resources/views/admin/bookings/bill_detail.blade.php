@extends('layouts.master')

@section('content-header')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="jquery.masknumber.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<h1>
    {{ trans("Hóa đơn tháng") }} {{ Carbon\Carbon::now()->timezone('Asia/Ho_Chi_Minh')->format('m') }}
</h1>

<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class="active">{{ trans('Cấu hình') }}</li>
</ol>
@stop

@section('content')
<style type="text/css">
       .button_action {
        display: inline-flex !important;
    }
</style>
<div class="row">
    <div class="col-xs-12">
{{--         <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ route('admin.bookings.bookings.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> {{ trans('Tạo thủ tục thuê phòng') }}
                </a>
            </div>
        </div> --}}
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
            <form action="{{ route('admin.bills.bills.postbillsdetail') }}" method="POST" class="form-inline" style="padding-top: 15px">
            <input type="hidden" name="bill_id" value="{{$bills->id}}">
            {{ csrf_field() }}
                <table id="tablevehilce" class="table table-bordered table-hover data-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="10%">Nội dung thanh toán</th>
                            <th width="10%">Đơn giá</th>
                            <th width="10%">Chỉ số cũ</th>
                            <th width="25%">Chỉ số mới</th>  
                            <th width="10%">Số lượng</th>
                            <th width="20%">Thành tiền</th>          
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiền điện</td>
                            <td align="right" id="tiendien" data-tiendien="{{$config->payment_on_electricity}}">{{ number_format($config->payment_on_electricity,0,'.','.') }}</td>
                            <input type="hidden" name="tiendiencontroller" value="{{$config->payment_on_electricity}}">
                            <td><input class="form-control" type="number" id="chisodiencu" name="electricity_index" value="{{ (int)$electricity_index }}"></td>
                            <td><input class="form-control" type="number" id="chisodienmoi" name="electricity_index_new"  @if($bills_detail_month_now->electricity_index != null) value="{{$bills_detail_month_now->electricity_index}}" @endif></td>
                            <td></td>
                            <td id="thanhtiendien" align="right">@if($bills_detail_month_now->payment_on_electricity == null) {{ number_format($config->payment_on_electricity,0,'.','.') }} @else {{number_format($bills_detail_month_now->payment_on_electricity,0,'.','.')}} @endif</td>
                            <input type="hidden" id="tiendieninput" name="tiendieninput" value="{{$config->payment_on_electricity}}">
                        </tr>
                        <tr>
                            <td>Tiền nước</td>
                            <td align="right" id="tiennuoc" data-tiennuoc="{{$config->payment_of_water}}">{{ number_format($config->payment_of_water,0,'.','.') }}</td>
                            <input type="hidden" name="tiennuoccontroller" value="{{$config->payment_of_water}}">
                            <td><input class="form-control" type="number" id="chisonuoccu" name="water_index" value="{{ (int)$water_index }}"></td>
                            <td><input class="form-control" type="number" id="chisonuocmoi" name="water_index_new" @if($bills_detail_month_now->water_index != null) value="{{$bills_detail_month_now->water_index}}" @endif></td>
                            <td></td>
                            <td align="right" id="thanhtiennuoc">@if($bills_detail_month_now->payment_of_water == null) {{ number_format($config->payment_of_water,0,'.','.') }} @else {{number_format($bills_detail_month_now->payment_of_water,0,'.','.')}} @endif</td>
                            <input type="hidden" id="tiennuocinput" name="tiennuocinput" value="{{$config->payment_of_water}}">
                        </tr>
                        <tr>
                            <td>Tiền đổ rác</td>
                            <td align="right" id="tienrac" data-tienrac="{{$config->trash}}">{{ number_format($config->trash,0,'.','.') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right">@if($bills_detail_month_now->trash == null) {{ number_format($config->trash,0,'.','.') }} @else {{number_format($bills_detail_month_now->trash,0,'.','.')}} @endif</td>
                            <input type="hidden" id="tienracinput" name="tienracinput" value="{{$config->trash}}">
                        </tr>
                        <tr>
                            <td>Tiền Internet</td>
                            <td align="right" id="tieninternet" data-internet="{{$config->internet}}">@if($bills_detail_month_now->internet == null) {{ number_format($config->internet,0,'.','.') }}  @else {{number_format($bills_detail_month_now->internet,0,'.','.')}} @endif </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right">{{ number_format($config->internet,0,'.','.') }}</td>
                            <input type="hidden" id="tieninternetinput" name="tieninternetinput" value="{{$config->internet}}">
                        </tr>

                        <tr>
                            <td>Tiền giữ xe</td>
                            <td align="right" id="tienxe" data-tienxe="{{$config->parking}}"> {{ number_format($config->parking,0,'.','.') }}</td>
                            <input type="hidden" name="tienxecontroller" value="{{$config->parking}}">
                            <td></td>
                            <td></td>
                            <td><input class="form-control" type="number" id="soxe" readonly="" name="soxe" value="{{ $bills->getBooking->number_of_bike }}"></td>
                            <td align="right" id="thanhtiengiuxe">@if($bills_detail_month_now->parking == null) {{ number_format($config->parking,0,'.','.') }}  @else {{number_format($bills_detail_month_now->parking,0,'.','.')}} @endif</td>
                            <input type="hidden" id="tienxeinput" name="tienxeinput" value="{{$config->parking}}">
                        </tr>
                        <tr>
                            <td>Tiền phòng</td>
                            <td align="right" id="tienphong" data-tienphong="{{$room_price}}">@if($bills_detail_month_now->room_rates == null) {{ $price_room }} @else {{number_format($bills_detail_month_now->room_rates,0,'.','.')}} @endif</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right">{{ $price_room }}</td>
                            <input type="hidden" id="tienphonginput" name="tienphonginput" value="{{$room_price}}">
                        </tr>
                        <tr>

                            <td colspan="5" style="background-color: #CCC; font-weight: bold;" align="right">Tổng cộng</td>
                            <td align="right" style="font-weight: bold;" id="tongcong">{{ number_format($total,0,'.','.') }}</td>
                            <input type="hidden" id="tongconginput" name="tongconginput" value="{{$total}}">
                        </tr>
                        <tr>
                            <td colspan="5" style="font-weight: bold;" align="right">Nợ</td>
                            <td align="right" style="font-weight: bold;">@if($owe == 0) 0 @else {{ number_format($owe,0,'.','.') }} @endif</td>
                            <input type="hidden" id="noinput" name="noinput" value="{{$owe}}">
                        </tr>
                        <tr>
                            <td colspan="4" style="font-weight: bold;" align="right">
                                <div class="form-group{{ $errors->has('erea') ? ' has-error' : '' }}">
                                        {!! Form::label('paid_day', 'Ngày trả') !!}
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' class="form-control" @if($bills->date_paid != null) value="{{ Carbon\Carbon::parse($bills->date_paid)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y')}}" @endif name="paid_day" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                {!! $errors->first('paid_day', '<span class="help-block">:message</span>') !!}
                                </div>
                            </td>
                            <td style="font-weight: bold;" align="right">Đã trả</td>
                            <td align="right" style="font-weight: bold;"><input id="datra" align="right" class="form-control" data-thousands="." type="text" name="datra" @if($bills->date_paid != null) value="{{number_format($bills->paid,0,'.','.') }}" @endif></td>
                            <input type="hidden" id="datrainput" name="datrainput" value="0">
                        </tr>
                        <tr>
                            <td colspan="5" style="font-weight: bold;" align="right">Còn lại</td>
                            <td align="right" style="font-weight: bold;" id="conlai">@if($bills->paid==null || $bills->paid == 0) {{ number_format($total,0,'.','.') }} @else {{ number_format($total-$bills->paid,0,'.','.') }} @endif</td>
                            <input type="hidden" id="conlaiinput" name="conlaiinput" value="0">
                        </tr>
                    </tbody>
                </table>
                <div align="right">
                    <a title="Cập nhật" class="btn btn-default btn-flat update" href="javascript:void(0)" style="margin-right:3px"><i class="fa fa-history"></i></a>
                </div>
                
                <button class="btn btn-primary btn-flat" type="submit" style="padding: 5px 12px;"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                </form>
            
                
                {{-- <a href="" class="btn btn-info btn-flat" >Export Vehicle</a> --}}


            <!-- /.box-body -->
            </div>
        <!-- /.box -->
    </div>
<!-- /.col (MAIN) -->
</div>
</div>
<div id="myModal" class="modal fade modal-danger in" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="delete-confirmation-title">Thông báo</h4>
        </div>
        <div class="modal-body">
            <div class="default-message">
                                        Bạn có chắc chắn muốn xoá không ?
                                </div>
            <div class="custom-message"></div>
        </div>
      <div class="modal-footer">
        <button type="submit" id="update-checkbox" class="btn btn-danger btn-flat btn-outline" style="float:left;"><i class="fa fa-trash"> Xác nhận</i></button>
        <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">Huỷ bỏ</button>
      </div>
    </div>

  </div>
</div>
@include('core::partials.delete-modal')
@stop

@push('js-stack')
<?php $locale = App::getLocale(); ?>
<script type="text/javascript">


    function addPeriod(nStr){
      nStr += '';
      var x = nStr.split('.');
      var x1 = x[0];
      var x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + '.' + '$2');
      }
     return x1 + x2;
     }
    jQuery(document).ready(function($) {
        $('#datra').maskNumber({
          integer: true,
        });
        $('#datra').blur(function(){
            $(this).css("float","right");
        })
        $(".update").on("click",function(){
            if($("#chisodiencu").val()){
                var chisodiencu = $("#chisodiencu").val();
            }else{
                var chisodiencu = 0;
            }
            if($("#chisodienmoi").val()){
                var chisodienmoi = $("#chisodienmoi").val();
            }else{
                var chisodienmoi = 0;
            }


            if($("#chisonuoccu").val()){
                var chisonuoccu = $("#chisonuoccu").val();
            }else{
                var chisonuoccu = 0;
            }
            if($("#chisonuocmoi").val()){
                var chisonuocmoi = $("#chisonuocmoi").val();
            }else{
                var chisonuocmoi = 0;
            }
            // var chisodiencu = $("#chisodiencu").val();
            // var chisodienmoi = $("#chisodienmoi").val();

            var tiendien = $("#tiendien").attr('data-tiendien');

            // var chisonuoccu = $("#chisonuoccu").val();
            // var chisonuocmoi = $("#chisonuocmoi").val();

            var tiennuoc = $("#tiennuoc").attr('data-tiennuoc');
            //alert(tiennuoc);

            var soxe = $("#soxe").val();
            var tiengiuxe = $("#tienxe").attr("data-tienxe");

            var tienrac = $("#tienrac").attr("data-tienrac");
            var tieninternet = $("#tieninternet").attr("data-internet");
            var tienphong = $("#tienphong").attr("data-tienphong");
            //alert(tienphong);

            if($("#datra").val()){
                var datra = $("#datra").val();
                var datra = datra.replace(/\./g,'');
                //datrainput
            }else{
                var datra = 0;
            }
            $("#datrainput").val(datra);
            //alert(datra);
            
            //alert(datra);
            var thanhtiendien = parseInt(tiendien) * (parseInt(chisodienmoi) - parseInt(chisodiencu));
            var thanhtiennuoc = parseInt(tiennuoc) * (parseInt(chisonuocmoi) - parseInt(chisonuoccu));
            var thanhtiengiuxe = parseInt(tiengiuxe) * parseInt(soxe);

            var tongcong = parseInt(thanhtiendien) + parseInt(thanhtiennuoc) + parseInt(thanhtiengiuxe) + parseInt(tienrac) +parseInt(tieninternet) + parseInt(tienphong);
            var conlai = parseInt(tongcong) - parseInt(datra);

            $("#thanhtiendien").html(addPeriod(thanhtiendien));
            $("#tiendieninput").val(thanhtiendien);

            $("#thanhtiengiuxe").html(addPeriod(thanhtiengiuxe));
            $("#tienxeinput").val(thanhtiengiuxe);

            $("#thanhtiennuoc").html(addPeriod(thanhtiennuoc));
            $("#tiennuocinput").val(thanhtiennuoc);

            $("#tongcong").html(addPeriod(tongcong));
            $("#tongconginput").val(tongcong);

            $("#conlai").html(addPeriod(conlai));
            $("#conlaiinput").val(conlai);


        })
        $('#datetimepicker2').datetimepicker({
            format : 'DD-MM-YYYY',
        });
    });
</script>


<script type="text/javascript">
    $( document ).ready(function() {
        $(document).keypressAction({
            actions: [
                { key: 'c', route: "<?= route('admin.user.user.create') ?>" }
            ]
        });
    });
    $(function () {
        $('.data-table').dataTable({
            "paginate": true,
            "lengthChange": true,
            "filter": true,
            "sort": false,
            "info": true,
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "language": {
                "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
            }
        });
    });

</script>
@endpush
