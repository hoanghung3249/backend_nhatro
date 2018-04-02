@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('Quản lý khách hàng') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class="active">{{ trans('Quản lý khách hàng') }}</li>
</ol>
@stop

@section('content')
<style type="text/css">
       .button_action {
        display: inline-flex !important;
    }
</style>
<form action="{{ route('admin.customer.customer.bulkdelete') }}" method="get">
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ route('admin.customer.customer.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> {{ trans('Tạo mới khách hàng') }}
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
                            <th>Check box</th>
                            <th>Họ Tên</th>
                            <th>Ngày Sinh</th>
                            <th>Giới Tính</th>
                            <th>Số Điện Thoại</th>
                            <th>Phòng Đang Ở</th>
                            <th>Chi Tiết / Xoá</th>           
                        </tr>
                    </thead>
                </table>


                
                <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash-o" aria-hidden="true"> Xoá các mục đã chọn</i></button>
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
        <button type="submit" class="btn btn-danger btn-flat btn-outline" style="float:left;"><i class="fa fa-trash"> Xác nhận</i></button>
        <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">Huỷ bỏ</button>
      </div>
    </div>

  </div>
</div>
</form>
@include('core::partials.delete-modal')
@stop

@push('js-stack')
<?php $locale = App::getLocale(); ?>
{{-- <script type="text/javascript">
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
</script> --}}

<script type="text/javascript">
    $(document).ready(function(){

    $("body").on('click', '.chitiet', function() {
      var idcus = $(this).attr("idcus");
      $.ajax({
        url: "{{ route('admin.customer.customer.customerdetail') }}",
        type: 'GET',
        dataType: 'HTML',
        data: {
          idcus : idcus,
        },
      })
      .done(function(result) {
        $("#modal-detail-customer").modal('show');
        $(".modal-body").html(result);

      });
    });





    $('#tablevehilce').DataTable({
        processing:false,
        serverSide:true,
        ajax:"{{ route('admin.customer.customer.indextable') }}",
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
        } ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        language: {
            "lengthMenu": "Hiển thị _MENU_ dữ liệu trên 1 trang",
            "zeroRecords": "Không tìm thấy dữ liệu",
            "info": "Hiển thị trang _PAGE_ trong tổng _PAGES_ trang",
            "infoEmpty": "Không có dữ liệu",
            "search":         "Tìm kiếm:",
            "infoFiltered": "(Đã tìm kiếm trong tổng cộng _MAX_ dữ liệu)",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Kế tiếp",
                "previous":   "Lùi lại"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
        },
        columns:[
            {data:'check',searchable:false},
            {data:'fullname',searchable:true},
            {data:'dob',searchable:true},
            {data:'gender',searchable:true},
            {data:'phone',searchable:true},
            {data:'tenphong',searchable:true},
            {data:'button',searchable:false},

        ],
    });
    $("#update-checkbox").click(function(){

        var id = [];
        $(':checkbox:checked').each(function(i){
          id[i] = $(this).val();
             //alert(id[i]);
          $.ajax({
              url: "{{ route('admin.customer.customer.bulkdelete') }}",
              type: 'GET',
              dataType: 'JSON',
              data: {id: id[i]},
          })
          .done(function(data) {
            //console.log(data)
            if(data == 2){
                console.log(data)
                window.location = "{{ route('admin.customer.customer.index') }}";
            }
            else{
                //window.location
                window.location = "{{ route('admin.customer.customer.index') }}";                
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
