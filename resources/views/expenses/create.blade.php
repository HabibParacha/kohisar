@extends('template.tmp')
@section('title', 'kohisar')

@section('content')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    /* Chrome, Safari, Edge, Opera : remove spin input type number*/
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      

    }

    .table>:not(caption)>*>* {
    padding: 0.15rem .15rem !important;
    }

   

    .form-control:disabled, .form-control[readonly] {
    background-color: #eff2f780 !important;
    opacity: 1;
}

</style>
<style>
    .ui-state-highlight {
        height: 40px;
        background-color: #f0f0f0;
    }
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <form id="expense-store" method="POST" enctype="multipart/form-data">
                <!-- start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    {{-- <h4 class="card-title mb-4">Purchase Order</h4> --}}
                                    <h4 class="card-title mb-4">Expense</h4>
        
                                    
                                        
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Supplier</label>
                                                <select name="supplier_id" id="" class="select2 form-control" autofocus>                                                
                                                    <option value="">Choose...</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}">{{ $supplier->business_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                        
                                        </div>
            
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Paid Through</label>
                                                <select name="paid_by_COA" class="select2 form-control" autofocus>                                                
                                                    <option value="">Choose...</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{$account->id}}">{{ $account->id.'-'.$account->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Expense No</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                                    <input type="text" name="expense_no"  class="form-control" value="{{ $newExpenseNo }}" readonly>
                                                </div> 
                                            </div> 
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                                    <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
                                                </div>
                                                
                                            </div> 
                                        </div>
                                       
                                            
                                    </div> 
                                </div>
                            </div>
                        
        
                          
                           
                            
                            
        
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                            
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Expense Details</h4>
                                    <div class="table-responsive">
                                        <table id="table" class="table table-border" style="border-collapse:collapse;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="50px"></th>
                                                    <th class="text-center" width="200px">Account Name</th> 
                                                    <th class="text-center" width="300px">Description</th> 
                                                    <th class="text-center" width="100px">Tax Rate </th> 
                                                    <th class="text-center" width="100px">Exclusive Value</th> 
                                                    <th class="text-center" width="100px">{{ __('tax.name') }}</th> 
                                                    <th class="text-center" width="100px">Inclusive Value</th> 

                                                    <th class="text-center" width="50px"></th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody id="sortable-table">
                                                <tr>
                                                    <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>
                                        
                                                    <td> 
                                                        {{-- coa => chart of account --}}
                                                        <select  name="COA_id[]" class="form-control select2 coa-dropdown-list" style="width: 100%">                                                
                                                            <option >Choose...</option>
                                                            @foreach ($accounts as $account)
                                                                <option value="{{$account->id}}">{{ $account->id.'-'. $account->name }}</option>
                                                            @endforeach
                                                            
                                                        </select>
                                                        
                                                    </td> 
                                                    
                                                
                                                    <td>
                                                        <input type="text" name="description[]"  class="form-control">  
                                                    </td>
                                                    <td> 
                                                        <select  name="tax_percentage[]" class="form-control select2 tax-dropdown-list" style="width: 100%">                                                
                                                            @foreach ($taxes as $tax)
                                                                <option value="{{$tax->rate}}"  data-tax-rate="{{ $tax->rate }}" >{{ $tax->rate }}</option>
                                                            @endforeach
                                                            
                                                        </select>
                                                        
                                                    </td> 
                                                    <td>
                                                        <input type="number" name="amount_exclusive_tax[]" step="0.0001" class="form-control item-amount-exclusive-tax" >  
                                                    </td>
                                                    <td>
                                                        <input type="number" name="calculated_tax_amount[]" step="0.0001" class="form-control item-calculated-tax-amount" readonly>  
                                                    </td>
                                                    <td>
                                                        <input type="number" name="amount_inclusive_tax[]" step="0.0001" class="form-control item-amount-inclusive-tax" readonly>  
                                                    </td>
                                                    
                                                    
                                                    <td class="text-center">  
                                                        <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                                                    </td>
                                                </tr>
                                            
                                            </tbody> 
                                            
                                        </table>
        
                                        <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                                    </div> 
                                    <div class="row mt-3">
                                        <div class="col-md-8">
                                           
                                                <div class="mb-3">
                                                    <div class="form-label fw-bold">Description</div>
                                                    <div class="input-group">
                                                        <textarea class="form-control" rows="4" name="expense_description"></textarea>
                                                    </div> 
                                                </div> 
                                            
                                        </div>
                                        
                                        <div class="col-md-4 d-flex align-items-center">
                                            <table id="summary-table" class="table">
                                                <tr>
                                                    <th width="50%">Total Before Tax</th>
                                                    <td width="50%">
                                                        <input type="number" name="total_exclusive_amount" id="total_exclusive_amount" value="0" class="form-control text-end" readonly>
                                                    </td>
                                                </tr>      
                                                <tr>
                                                    <th width="50%">{{ __('tax.name') }} </th>
                                                    <td width="50%">
                                                        <input type="number" name="total_tax" id="total_tax" value="0" class="form-control text-end" readonly>
                                                    </td>
                                                </tr>      
                                                <tr>
                                                    <th width="50%">Total After Tax</th>
                                                    <td width="50%">
                                                        <input type="number" name="total_inclusive_amount" id="total_inclusive_amount" value="0" class="form-control text-end" readonly>
                                                    </td>
                                                </tr>      
                                            </table>
                                        </div>
                                    </div>  
                                
        
                                
                                </div>
        
                            </div>
                        </div>  
                        <div class="row  mt-2">
                            
                            <div class="col-md-12 text-end">
                                <button type="submit" id="submit-expense-store" class="btn btn-success w-md">Save</button>
                                <a href="{{ route('expense.index') }}"class="btn btn-secondary w-md ">Cancel</a>
            
                            </div>
    
                        </div> 
                    </div> 
                </form>      
             
            </div>
         </div>
    </div>

    

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   


<script>  
    $(document).ready(function () {
        // appendNewRow();
    });
    //  Detect Enter key in input fields
   
    $('#expense-store').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });


    $(document).on('change', '.item-dropdown-list', function(e){
        
        let selected_item = $(this).find('option:selected');
        
        let unit_id = selected_item.data('unit-id');
        
        let row =  $(this).closest('tr');
        
        let unit_dropdown = row.find('.unit-dropdown-list');

        unit_dropdown.val(unit_id).trigger('change');

        $(this).select2('close');
        
        calculation(row);  


    });

   
   
    //Quantity Value on keyup sum the quantity
    $(document).on('keyup', '.item-amount-exclusive-tax', function(e) {
        let row = $(this).closest('tr');  

        calculation(row);
       
    });
    $(document).on('select2:select', '.tax-dropdown-list', function(){
        let row = $(this).closest('tr');  

        calculation(row);
    });

    function calculation(row)
    {
        let tax = row.find('.tax-dropdown-list option:selected').val(); 

        let tax_percentage = row.find('.tax-dropdown-list option:selected').data('tax-rate');

        let amount_exclusive_tax = parseFloat(row.find('.item-amount-exclusive-tax').val()) || 0;

        let calculated_tax_amount = tax_percentage ? (amount_exclusive_tax * tax_percentage / 100) : 0; // Ensure selected_tax_value is not undefined
        row.find('.item-calculated-tax-amount').val(calculated_tax_amount.toFixed(2));
        
        let amount_inclusive_tax = amount_exclusive_tax + calculated_tax_amount;
        row.find('.item-amount-inclusive-tax ').val(amount_inclusive_tax.toFixed(2));



        summaryCalculation();
    } 


    

    function summaryCalculation()
    {
        let total_exclusive_amount = 0;
        let total_tax = 0;
        let total_inclusive_amount = 0;


        //total before tax
        $('.item-amount-exclusive-tax').each(function(){
            total_exclusive_amount +=  parseFloat($(this).val()) || 0;
        });
        $('#total_exclusive_amount').val(total_exclusive_amount.toFixed(2));

        // total tax
        $('.item-calculated-tax-amount').each(function(){
            total_tax +=  parseFloat($(this).val()) || 0;
        });
        $('#total_tax').val(total_tax.toFixed(2));

        //total after tax
        $('.item-amount-inclusive-tax').each(function(){
            total_inclusive_amount +=  parseFloat($(this).val()) || 0;
        });
        $('#total_inclusive_amount').val(total_inclusive_amount.toFixed(2));
    }


   


    $('#btn-add-more').on('click', function(e){
        e.preventDefault();

        appendNewRow();
       
    });
    
    $(document).on('click', '.remove-item', function(e) {
        e.preventDefault();
        
        // Show a confirmation dialog
        if (confirm("Are you sure you want to remove this item?")) {
            // If confirmed, remove the row
            $(this).closest('tr').remove();
            
            // Recalculate the summary
            summaryCalculation();
        }
    });

   

    function appendNewRow(){
        let tableBody = $('#table tbody');

        let row = `
        <tr>
            <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>

            <td> 
                {{-- coa => chart of account --}}
                <select  name="COA_id[]" class="form-control select2 coa-dropdown-list" style="width: 100%">                                                
                    <option >Choose...</option>
                    @foreach ($accounts as $account)
                        <option value="{{$account->id}}">{{ $account->id.'-'. $account->name }}</option>
                    @endforeach
                    
                </select>
                
            </td> 
            
        
            <td>
                <input type="text" name="description[]"  class="form-control">  
            </td>
            <td> 
                <select  name="tax_percentage[]" class="form-control select2 tax-dropdown-list" style="width: 100%">                                                
                    @foreach ($taxes as $tax)
                        <option value="{{$tax->id}}"  data-tax-rate="{{ $tax->rate }}" >{{ $tax->rate }}</option>
                    @endforeach
                    
                </select>
                
            </td> 
            <td>
                <input type="number" name="amount_exclusive_tax[]" step="0.0001" class="form-control item-amount-exclusive-tax" >  
            </td>
            <td>
                <input type="number" name="calculated_tax_amount[]" step="0.0001" class="form-control item-calculated-tax-amount" readonly>  
            </td>
            <td>
                <input type="number" name="amount_inclusive_tax[]" step="0.0001" class="form-control item-amount-inclusive-tax" readonly>  
            </td>
            
            
            <td class="text-center">  
                <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
            </td>
        </tr>
        `;
      
        tableBody.append(row);
        $('.select2', 'table').select2();

    }



</script>


<script>
    $(function() {
        // Enable full sorting for tbody rows, allowing drag and drop from bottom to top
        $("#sortable-table").sortable({
            handle: ".handle",  // Set the 'handle' option to the bx-menu icon
            placeholder: "ui-state-highlight",  // Placeholder while dragging
            axis: "y",  // Restrict dragging to vertical movement
            update: function(event, ui) {
                // This event is triggered when the row has been moved
                console.log('Row moved');
            }
        }).disableSelection();  // Disable text selection while dragging
    });
</script>



<script>
    $('#expense-store').on('submit', function(e) {
        e.preventDefault();
        var submit_btn = $('#submit-expense-store');
        let createformData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('expense.store') }}",
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            data: createformData,
            enctype: "multipart/form-data",
            beforeSend: function() {
                submit_btn.prop('disabled', true);
                submit_btn.html('Processing');
            },
            success: function(response) {
                
                submit_btn.prop('disabled', false).html('Save');  

                if(response.success == true){
                    $('#expense-store')[0].reset();  // Reset all form data
                
                    notyf.success({
                        message: response.message, 
                        duration: 3000
                    });

                    // Redirect after success notification
                    setTimeout(function() {
                        window.location.href = '{{ route("expense.index") }}';
                    }, 200); // Redirect after 3 seconds (same as notification duration)


                }else{
                    notyf.error({
                        message: response.message,
                        duration: 5000
                    });
                }   
            },
            error: function(e) {
                submit_btn.prop('disabled', false).html('Save');
            
                notyf.error({
                    message: e.responseJSON.message,
                    duration: 5000
                });
            }
        });
    });
            
</script>
    
@endsection
