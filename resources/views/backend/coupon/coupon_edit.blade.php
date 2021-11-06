@extends('admin.admin_master')


@section('admin')


    <div class="container-full">

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-8">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Coupon Edit</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">


                            <form action="{{ route('coupon.update', $coupons->id) }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="id" value="{{ $coupons->id }}">

                                <div class="form-group">
                                    <h5>Coupon Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="coupon_name" value="{{ $coupons->coupon_name }}"
                                            class="form-control" id="coupon_name">
                                        @error('coupon_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5>Coupon Discount% <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="coupon_discount" value="{{ $coupons->coupon_discount }}"
                                            class="form-control" id="coupon_discount">
                                        @error('coupon_discount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Coupon Validate <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="date" name="coupon_validity"
                                            min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ $coupons->coupon_validity }}" class="form-control"
                                            id="coupon_validity">
                                        @error('coupon_validity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-info" value="Update coupon">
                                </div>

                            </form>

                        </div>
                    </div>


                </div>

                <div class="col-4"></div>

                <!-- /.col -->

            </div>
    </div>
    </section>
    </div>

@endsection
