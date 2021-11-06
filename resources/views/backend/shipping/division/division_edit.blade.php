@extends('admin.admin_master')


@section('admin')


    <div class="container-full">

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-8">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Division Edit</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form action="{{ route('division.update') }}" method="POST" >
                                @csrf

                                <input type="hidden" name="id" value="{{ $division->id }}">
                                <div class="form-group">
                                    <h5>Division Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="division_name" value="{{ $division->division_name }}"
                                            class="form-control" id="division_name">
                                        @error('division_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-info" value="Update Division">
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
