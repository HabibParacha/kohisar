@extends('template.tmp')
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
                                            <th>Permissions</th>
                                            <th>Section</th>
                                            <th>Action</th>
                                            @foreach ($roles as $role)
                                                <th><a href="{{ route('role-permissions.edit',$role->id) }}">{{ $role->name }}</a></th>
                                            @endforeach

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $permission->section}}</td>
                                                <td>{{ $permission->action}}</td>
                                                @foreach ($roles as $role)

                                                    @php
                                                        $data = DB::table('role_permissions')
                                                        ->where('permission_id',$permission->id)
                                                        ->where('role_id',$role->id)
                                                        ->first();


                                                        $is_allowed = ($data!=null) ? $data->is_allowed : 0;
                                                        $data_id = ($data!=null) ? $data->id : 0;
                                                        $data_role_id = $role->id;
                                                       
                                                        $data_permission_id = $permission->id;
                                                        $data_section = $permission->section;
                                                        $data_action = $permission->action;
                                                        $data_route_name = $permission->route_name;
                                                       
                                                    @endphp
                                                    <td>
                                                        <input class="form-check-input"
                                                         data-id="{{ $data_id }}"
                                                         data-role-id="{{ $data_role_id }}"
                                                         
                                                         data-permission-id="{{ $data_permission_id }}"
                                                         data-section="{{ $data_section }}"
                                                         data-action="{{ $data_action }}"
                                                         data-route-name="{{ $data_route_name }}"

                                                         type="checkbox" 
                                                         @if($is_allowed == 1) 
                                                            checked 
                                                         @endif 
                                                         readonly>
                                                        
                                                    
                                                    </td>
                                                
                                                @endforeach
                                                
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
{{-- <script>
    $('.form-check-input').on('click', function(){
        if ($(this).prop('checked') === true) {
            // Action when the section checkbox is checked
            $(this).closest('tr').find('.is-allowed').val(1);
        } else {
            // Action when the section checkbox is unchecked
            $(this).closest('tr').find('.is-allowed').val(0);
        }
    });
    
    $('.form-check-input').on('click', function(){
        // console.log($(this).data('id'));
        // console.log($(this).data('section'));
        // console.log($(this).data('action'));

        let id = $(this).data('id');
        let section = $(this).data('section');
        let action = $(this).data('action');
        let value = ($(this).prop('checked')) ? 1 :0;

       
        
        if(id == 0)
        {
            create(id,section,action,value);
        }else{
            update(id,value);
        }
        
        
    });

    function create(id,section,action,value){
        console.log(id,section,action,value);
    }

    function  update(id,value){
        console.log(id,value);
    }
</script> --}}


<script>
    $('.form-check-input').on('click', function(){
        if ($(this).prop('checked') === true) {
            // Action when the section checkbox is checked
            $(this).closest('tr').find('.is-allowed').val(1);
        } else {
            // Action when the section checkbox is unchecked
            $(this).closest('tr').find('.is-allowed').val(0);
        }
    });
    
    $('.form-check-input').on('click', function(){
        let id = $(this).data('id');
        let role_id = $(this).data('role-id');
        let value = ($(this).prop('checked')) ? 1 : 0;


        let permission_id = $(this).data('permission-id');
        let section = $(this).data('section');
        let action = $(this).data('action');
        let route_name = $(this).data('route-name');


        console.log(id,
role_id,
value,
permission_id,
section,
action,
route_name);
        
        $.ajax({
            url: "{{ route('role-permissions.ajax') }}",  // The URL for your controller's store function
            type: 'GET',  // The request type
            data: {
                id: id,
                role_id: role_id,
                value: value,
                permission_id: permission_id,
                section: section,
                action: action,
                route_name: route_name,
            },
            success: function(response) {
                // Handle success response
                console.log('Data successfully saved:', response);
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error saving data:', error);
            }
        });
    });

    
</script>


 @endsection   