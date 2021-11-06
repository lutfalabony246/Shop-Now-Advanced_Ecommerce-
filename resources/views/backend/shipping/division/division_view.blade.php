@extends('admin.admin_master')


@section('admin')

    <div class="container-full">

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-8">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"> All Divisions</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Division Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($divisions as $item)
                                            <tr>
                                                <td> {{ $item->division_name }} </td>
                                                <td>
                                                    <a href="{{ route('division.edit', $item->id) }}"
                                                        class="btn btn-success"> Edit </a>
                                                    <a href="{{ route('division.delete', $item->id) }}"
                                                        class="btn btn-danger">Delete</a>
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
                            <h3 class="box-title">Division Add</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form action="{{ route('add.division') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <h5>Division Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="division_name" class="form-control" id="division_name">
                                        @error('division_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-info" value=" Add Division">
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
