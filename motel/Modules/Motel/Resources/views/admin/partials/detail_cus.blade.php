<div class="row">
                        <div class="col-md-3" style="border-right: 1px solid #ddd">
                            <div class="row">
                                <div class="col-md-12 text-center">

                                    <img style="width: 200px;height: 200px" src="https://proj-edj.s3-ap-southeast-1.amazonaws.com/20170707021018_no_image.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="task">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3 style="margin-top: 0">{{$info_customer->getHoTen()}}</h3>
                                            </div>
    
                                         </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><b>Email </b> : {{$info_customer->getEmail()}}</p>
                                                <p><b>Ngày sinh </b> : {{$info_customer->getDOB()}}</p>
                                                <p><b>Số chứng minh nhân dân</b> : {{$info_customer->getCMND()}}</p>
                                                <p><b>Giới tính</b> : {{$info_customer->getGioiTinh()}}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <b> Nơi đăng ký hộ khẩu thường trú </b>: {{$info_customer->getNoiDKHKThuongTru()}}</p>
                                                <p> <b> Nguyên quán </b>: {{$info_customer->getNguyenQuan()}}</p>
                                                <p> <b> Số điện thoại </b>: {{$info_customer->getSDT()}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                <a href="{{ route('admin.customer.customer.edit',$info_customer->id) }}" id="update-checkbox" class="btn btn-info btn-flat btn-outline-info" style="float:left;"><i class="fa fa-edit">Chỉnh sửa</i></a>
                                </div>
                            </div>
                        </div>
</div>
