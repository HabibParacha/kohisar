@extends('template.tmp')
@section('content')
<style>
    .first-layer label{
        font-weight: bold;
    }
    .second-layer {
        padding-left: 50px !important; 
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('role-permissions.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-5">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Role Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="role">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                          
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0 table-borderless"> 
                                    
                                    <tr>
                                        <th width="20%" >
                                            <input class="form-check-input" id="master-checkbox" type="checkbox">
    
                                            <label class="card-title">Role Permissions</label>
                                        </th>
                                        <th width="10%"></th>
                                        <th width="10%"></th>
                                        <th width="10%"></th>
                                        <th width="10%"></th>
                                        <th width="10%"></th>
                                    </tr>

                                    @foreach ($sections as $data)

                                        <tr>        
                                            <th class="first-layer">
                                                <input class="form-check-input section-checkbox" type="checkbox">
                                                <label class="form-check-label">{{ $data->section }}</label>
                                            </th>
                                             
                                            @php
                                                $actions = DB::table('permissions')->where('section', $data->section)->get();
                                                $i = 0;
                                            @endphp
                                                
                                                        
                                                
                                            @foreach ( $actions as $data)



                                            @if($i == 5) 
                                        
                                                <tr> <!-- Start a new row every 6 actions -->
                                                    <th>
                                                        <input class="form-check-input section-checkbox" type="checkbox">
                                                        <label class="form-check-label">{{ $data->section }}</label>
                                                    </th>
                                            @endif       



                                                <td class="second-layer"> 
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">{{ $data->action }}</label>
                                                    <input type="hidden" name="permission_id[]" value="{{ $data->id }}">
                                                    <input type="hidden" name="section[]" value="{{ $data->section }}">
                                                    <input type="hidden" name="action[]" value="{{ $data->action }}">
                                                    <input type="hidden" name="route_name[]" value="{{ $data->route_name }}">
                                                    <input type="hidden" class="is-allowed" name="is_allowed[]" value="0">
                                                </td>

                                                @if($i == 9) 
                                                    </tr> <!-- Start a new row after every 6 actions -->
                                                    @php    $i=4;   @endphp
                                                @endif
                                        
                                                @php  $i++ @endphp
                                            @endforeach
                                                    
                                                       
                                        </tr>          
                                    @endforeach
                                </table>
                            </div>
                            <!-- end table-responsive -->
                
                            <!-- Optionally add submit button or further action -->
                            <button type="submit" class="btn btn-primary mt-3">Save Permissions</button>
                        </form>
                    </div>
                </div>
            </form>
        </div>    
    </div>    
</div>    
<script>
    $('.section-checkbox').on('click', function(){
        const $table = $(this).closest('tr');
        $table.find('.form-check-input').prop('checked', $(this).prop('checked'));
        
        if ($(this).prop('checked') === true) {
            // Action when the section checkbox is checked
            $table.find('.is-allowed').val(1);
        } else {
            // Action when the section checkbox is unchecked
            $table.find('.is-allowed').val(0);
        }
    });

    $('.form-check-input').on('click', function(){
        if ($(this).prop('checked') === true) {
            // Action when the section checkbox is checked
            $(this).closest('tr').find('.is-allowed').val(1);
        } else {
            // Action when the section checkbox is unchecked
            $(this).closest('tr').find('.is-allowed').val(0);
        }
    });
    $('#master-checkbox').on('click', function(){
       
        
        if ($(this).prop('checked') === true) {
            // Action when the section checkbox is checked
            $('.is-allowed').val(1); 
            $('.form-check-input').prop('checked',true);
        } else {
            // Action when the section checkbox is unchecked
            $('.is-allowed').val(0);
            $('.form-check-input').prop('checked',false);

        }
    });

</script>

@endsection


