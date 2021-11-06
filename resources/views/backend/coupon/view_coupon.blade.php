@extends('admin.admin_master')


@section('admin')

    <div class="container-full">

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-8">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"> All Coupons</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>

                                            <th>Coupon Name</th>
                                            <th>Coupon Discount</th>
                                            <th>Coupon Validity</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($coupons as $item)
                                            <tr>
                                                <td> {{ $item->coupon_name }} </td>

                                                <td> {{ $item->coupon_discount }} </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse($item->coupon_validity)->format('D,d F Y') }}
                                                </td>
                                                <td>
                                                    @if ($item->coupon_validity >= Carbon\Carbon::now()->format('Y-m-d'))
                                                        <span class="badge bade-pill badge-success">Active </span>
                                                    @else
                                                        <span class="badge bade-pill badge-danger">InActive </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('coupon.edit', $item->id) }}"
                                                        class="btn btn-success btn-sm"> Edit </a>

                                                    <a href="{{ route('coupon.delete', $item->id) }}"
                                                        class="btn btn-danger btn-sm">Delete</a>
                                                </td>


                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                    <!-- /.box -->
                </div>
                <!-- /.col -->



                <div class="col-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Coupon Add</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">


                            <form action="{{ route('coupon.add') }}" method="POST" enctype="multipart/form-data">

                                @csrf

                                {{-- <input type="hidden" name="id" value="{{ $coupons->id }}"> --}}



                                <div class="form-group">
                                    <h5>Coupon Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="coupon_name" class="form-control" id="coupon_name">
                                        @error('coupon_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5>Coupon Discount% <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="coupon_discount" class="form-control"
                                            id="coupon_discount">
                                        @error('coupon_discount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Coupon Validate <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="date" name="coupon_validity"
                                            min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control"
                                            id="coupon_validity">
                                        @error('coupon_validity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-info" value=" Add Coupon">
                                </div>

                            </form>

                        </div>
                    </div>


                </div>




            </div>
    </div>
    </section>
    </div>

@endsection
