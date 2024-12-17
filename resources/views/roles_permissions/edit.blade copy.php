@extends('template.tmp')
@section('content')
<style>
    .first-layer label{
        font-weight: bold;
    }
    .second-layer {
        padding-left: 40px !important; 
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('role-permissions.update',$role_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-5">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Role Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="role" value="{{ $role->name }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-body col-md-6">
                    
                        <input class="form-check-input" id="master-checkbox" type="checkbox">

                        <h4 class="card-title mb-4">Role Permissions</h4>
                            @csrf
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0 table-borderless"> 
                                    
                                        <!-- Invoice Permissions -->

                                    @foreach ($sections as $data)
                                        <tr>
                                            <td>
                                                <table class="">
                                                    @php
                                                        $actions = DB::table('role_permissions')
                                                        ->where('section', $data->section)
                                                        ->where('role_id', $role_id)
                                                        ->get();

                                                        $actionsWithZero = $actions->filter(function ($action) {
                                                            return $action->is_allowed == 0;
                                                        });
                                                        $sectionHasZero =false;
                                                        if ($actionsWithZero->isNotEmpty()) {
                                                            $sectionHasZero = true; 
                                                        } 
                                                                                                                                                                        
                                                    @endphp
                                                    <tr>
                                                        <th class="first-layer">
                                                            <input class="form-check-input section-checkbox" type="checkbox" @if($sectionHasZero == false) checked @endif>
                                                            <label class="form-check-label">{{ $data->section }}</label>
                                                        </th> 
                                                    </tr>
                                                        @foreach ( $actions as $data)
                                                            
                                                    
                                                        <tr>
                                                            <td class="second-layer"> 
                                                                <input class="form-check-input" type="checkbox" @if($data->is_allowed == 1) checked @endif >
                                                                <label class="form-check-label">{{ $data->action }}</label>
                                                                <input type="hidden" name="section[]" value="{{ $data->section }}">
                                                                <input type="hidden" name="action[]" value="{{ $data->action }}">
                                                                <input type="hidden" class="is-allowed" name="is_allowed[]" value="{{ $data->is_allowed }}">
                                                            </td>
                                                        </tr>
                                                    
                                                        @endforeach
                                                </table>
                                            </td>
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
        const $table = $(this).closest('table');
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


