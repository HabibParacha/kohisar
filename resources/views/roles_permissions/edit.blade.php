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
                    <div class="card-body">
                        <table class="table" style="border-collapse: collapse">
                            <thead>
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
                            </thead>
                            <tbody>
                                @foreach ($sections as $data)
                                    @php
                                        $actions = DB::table('role_permissions')
                                            ->where('section', $data->section)
                                            ->where('role_id', $role_id)
                                            ->get();
                            
                                        $actionsWithZero = $actions->filter(function ($action) {
                                            return $action->is_allowed == 0;
                                        });
                                        $sectionHasZero = false;
                                        if ($actionsWithZero->isNotEmpty()) {
                                            $sectionHasZero = true;
                                        }
                            
                                        $i = 0;
                                    @endphp
                            
                                    <tr>
                                        <td>
                                            <input class="form-check-input section-checkbox" type="checkbox" @if($sectionHasZero == false) checked @endif>
                                            <label class="form-check-label">{{ $data->section }}</label>
                                        </td>
                            
                                        @foreach ($actions as $action)
                                            @if($i == 5) 
                                           
                                                <tr> <!-- Start a new row every 6 actions -->
                                                    <td>
                                                        <input class="form-check-input section-checkbox" type="checkbox" @if($sectionHasZero == false) checked @endif>
                                                        <label class="form-check-label">{{ $data->section }}</label>
                                                    </td>
                                            @endif
                            
                                            <td class="second-layer"> 
                                                <input class="form-check-input" type="checkbox" @if($action->is_allowed == 1) checked @endif>
                                                <label class="form-check-label">{{ $action->action }}</label>
                                                <input type="hidden" name="id[]" value="{{ $action->id }}">
                                                <input type="hidden" class="is-allowed" name="is_allowed[]" value="{{ $action->is_allowed }}">
                                            </td>
                            
                                            @if($i == 9) 
                                                </tr> <!-- Start a new row after every 6 actions -->
                                                @php    $i=4;   @endphp
                                            @endif
                                            
                                            @php  $i++ @endphp
                                            
                                        @endforeach
                                    </tr>
                                @endforeach    
                            </tbody>
                            
                        </table>
                    </div>
                </div>        


                <button type="submit" class="btn btn-primary mt-3">Save Permissions</button>

                
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


