{{-- @extends('template.tmp')
@section('title', 'kohisar')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h3 class="mb-sm-0 font-size-18">Roles</h3>

                            <div class="page-title-right d-flex">

                                <div class="page-btn">
                                    <a href="{{ route('role-permissions.create') }}" class="btn btn-added btn-primary" ><i class="me-2 fa fa-plus"></i>Role</a>
                                </div>  
                            </div>



                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">


                        <div class="card">

                            <div class="card-body">
                                <table id="table" class="table table-striped table-sm " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <a href="{{ route('role-permissions.show', $role->id) }}"><i class="fa fa-eye"></i></a>
                                                    <a href="{{ route('role-permissions.edit', $role->id) }}"><i class="fa fa-pencil-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

 @endsection    --}}