@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('Phòng đang được thuê') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class="active">{{ trans('Phòng trọ') }}</li>
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
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ route('admin.bookings.bookings.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> {{ trans('Tạo thủ tục thuê phòng') }}
                </a>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="tablevehilce" class="table table-bordered table-hover " cellspacing="0" width="100%">
                    <thead>
                        <tr>
{{--                             <th>Check box</th> --}}
                            <th>Tên phòng</th>
                            <th>Ngày thuê phòng</th>
                            <th>Ngày trả phòng</th>
                            <th>Giá Phòng (Đơn vị)</th>
{{--                             <th>Tiền điện (Đơn vị)</th>
                            <th>Tiền nước (Đơn vị)</th> --}}
                            <th>Tiền cọc (Đơn vị)</th>
                            {{-- <th>Người thuê</th> --}}
                            {{-- <th>Trạng thái</th> --}}
                            <th>Chỉnh sửa / Xoá</th>           
                        </tr>
                    </thead>
                </table>


                
                {{-- <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash-o" aria-hidden="true"> Xóa các mục đã chọn</i></button> --}}
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
jQuery(document).ready(function($) {
    //alert(123);
    $("#tablevehilce").on('click',".check-stt",function(){
        var room_id = $(this).attr('data-value');
        var status = $(this).attr('status');
        $.ajax({
            url: "{{ route('admin.room.room.ajaxstatus') }}",
            type: 'get',
            dataType: 'html',
            data: {room_id: room_id,status:status},
            beforeSend: function() {
                        // setting a timeout
                         $("#check"+room_id).html('<p style="color:#3c8dbc"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i></p>');
                    },
        })
        .done(function(data) {
            if(data == 0){
                $("#check"+room_id).html('<span class="label label-danger" style="cursor: pointer; padding:7px" >Đang thuê</span>');
                $("#check"+room_id).attr('status',0);
            }else{
                $("#check"+room_id).html('<span class="label label-success" style="cursor: pointer; padding:7px" >Còn trống</span>');
                $("#check"+room_id).attr('status',1);
            }
        })
        
    })
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $('#tablevehilce').DataTable({
        processing:false,
        serverSide:true,
        ajax:"{{ route('admin.bookings.bookings.indextable') }}",
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
        } ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        columns:[
            // {data:'check',searchable:false},
            {data:'tenphong',searchable:true},
            {data:'ngaythue',searchable:true},
            {data:'ngaytra',searchable:true},
            {data:'giaphong',searchable:true},
            // {data:'tiendien',searchable:true},
            // {data:'tiennuoc',searchable:true},
            {data:'tiencoc',searchable:true},
            // {data:'customer',searchable:false},
            {data:'button',searchable:false},

        ],
    });
    $("#update-checkbox").click(function(){

        var id = [];
        $(':checkbox:checked').each(function(i){
          id[i] = $(this).val();
             //alert(id[i]);
          $.ajax({
              url: "{{ route('admin.room.room.bulkdelete') }}",
              type: 'GET',
              dataType: 'JSON',
              data: {id: id[i]},
          })
          .done(function(data) {
            //console.log(data)
            if(data == 2){
                console.log(data)
                window.location = "{{ route('admin.room.room.index') }}";
            }
            else{
                //window.location
                window.location = "{{ route('admin.room.room.index') }}";                
            }
          })
        });
    })

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
            "sort": true,
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
