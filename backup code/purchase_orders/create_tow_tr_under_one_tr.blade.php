@extends('template.tmp')
@section('title', 'pagetitle')

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

    table tbody tr input.form-control{
    
        border-radius: 0rem !important;
        font-size: 11px;
    
    }

    #summary-table input.form-control{
        border: 0;
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
                <!-- start page title -->
                <form>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Purchase Order</h4>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Supplier</label>
                                        <select id="supplier_id" name="supplier_id"  class="select2 form-select">                                                
                                            <option selected="">Choose...</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">
                                                    {{ $supplier->business_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                                        
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Sale Person </label>
                                        <select id="saleman_id" name="saleman_id"  class="select2 form-select">                                                
                                            <option selected="">Choose...</option>
                                            <option>Saleman 1</option>
                                            <option>Saleman 2</option>
                                        </select>
                                    </div>                                        
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Invoice No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                            <input type="text" name="invoice_no" id="invoice_no" class="form-control">
                                        </div> 
                                    </div> 
                                </div>

                             
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                            <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                       
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Payment Terms</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-money" ></span> </div>
                                            <select name="payment_terms" id="payment_terms"  class="form-control">
                                                <option selected value="">Choose...</option>
                                                @foreach ($paymentTerms as $term )
                                                    <option value="{{ $term['value'] }}">{{ $term['name'] }}</option>
                                                    
                                                @endforeach

                                            </select>
                                        </div>
                                       
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Due Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                            <input type="date" name="due_date" id="due_date" class="form-control">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Reference No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-file" ></span> </div>
                                            <input type="text" name="reference_no" id="reference_no" class="form-control">
                                        </div> 
                                    </div> 
                                </div>
                               
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">File</label>
                                        <input type="file" name="file" id="file" class="form-control">
                                    </div> 
                                </div>
                                
                                
                            </div>
                        </div>    

                    </div>

                    <div class="card">
                      
                        <div class="card-body">
                            <h4 class="card-title mb-4">Purchase Order</h4>
                            <div class="table-responsive">
                                <table id="table" class="table table-border" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="50"></th>
                                            <th class="text-center" width="250">Item</th> 
                                            <th class="text-center" width="150">Unit</th>
                                            <th class="text-center" width="100">Unit <br> Qty</th>
                                            <th class="text-center" width="100">Qty</th>
                                            <th class="text-center" width="100">Gross <br> Qty</th>
                                            <th class="text-center" width="50">Cut <br>(%)</th>
                                            <th class="text-center" width="100">Cut <br> Value</th>
                                            <th class="text-center" width="100">After <br> Cut</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-table">
                                    
                                  
                                        <tr>
                                           <td colspan="9">
                                                <table>
                                                    <tr>
                                                        <td><a href=""><i class="bx bx-menu handle"></i></a> </td>
                                                        <td> 
                                                            <select name="item_id[]" class="form-control select2 item-dropdown-list" style="width:100%">                                                
                                                                <option >Choose...</option>
                                                                @foreach ($items as $item)
                                                                    <option value="{{$item->id}}"  data-unit-id="{{ $item->unit_id }}"  >{{ $item->name }}</option>
                                                                @endforeach
                                                                
                                                            </select>
                                                            
                                                        </td>
            
            
                                                        <td> 
                                                            <select name="unit_id[]"  class="form-control select2 unit-dropdown-list" style="width:100%">                                                
                                                                <option>Choose...</option>
                                                                @foreach ($units as $unit)
                                                                    <option value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                                                                @endforeach
                                                            </select>
                                                            
                                                        </td>
            
            
                                                        <td> 
                                                            <input type="number" name="unit_quantity[]" step="0.01" class="form-control item-unit-quantity " readonly>  
                                                        </td>
                                                        
                                                        
                                                        <td> 
                                                            <input type="number" name="quantity[]" step="0.01" class="form-control item-quantity">  
                                                        </td>
            
                                                        <td> 
                                                            <input type="number" name="gross_weight[]" step="0.01" class="form-control gross-weight" readonly>  
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="cut_percentage[]" value="0" step="0.01" class="form-control item-cut-percentage">  
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="cut_value[]" value="0" step="0.01" class="form-control item-cut-value" readonly>  
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="after_cut_total_weight[]" step="0.01" class="form-control item-after-cut-total-weight" readonly>  
                                                        </td>
            
            
            
                                                        <td> 
                                                            <input type="number" name="per_package_weight[]" value="0" step="0.01" class="form-control item-per-package-weight">  
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td> 
                                                            <input type="number" name="total_package_weight[]" value="0" step="0.01" class="form-control item-total-package-weight" readonly>  
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="net_weight[]" value="0" step="0.01" class="form-control item-net-weight" readonly>  
                                                        </td>
                                                    
            
            
            
                                                        <td> 
                                                            <input type="number" name="price[]" step="0.01" class="form-control item-price">  
                                                        </td>
            
                                                        <td> 
                                                            <input type="number" name="quantity_price[]" step="0.01" class="form-control item-quantity-price" readonly>  
                                                        </td>
            
            
            
            
                                                    
            
            
                                                        <td>
                                                            <input type="number" name="discount_value[]" value="0" step="0.01" class="form-control item-discount-value" >
                                                        </td>
                                                        <td>
                                                            <select name="discount_type[]"  class="form-select item-discount-type">                                                
                                                                <option selected value="fixed">Fixed</option>
                                                                <option value="percentage">%</option>
                                                            </select>
                                                        </td>
            
                                                        <td> 
                                                            <input type="number" name="after_discount[]" class="form-control item-after-discount" readonly>  
                                                        </td>
                                                        <td> 
                                                            <select name="tax_id[]"  class="form-control select2 item-tax-dropdown" style="width:100%">                                                
                                                                @foreach ($taxes as $tax)
                                                                    <option  value="{{$tax->id}}" data-tax-rate="{{ $tax->rate }}" >{{ $tax->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="tax_value[]" class="form-control item-tax-value" readonly>  
                                                        </td>
            
                                                        <td class="text-center">  
                                                            <a href=""><span class="bx bx-trash text-danger remove-item"></span></a> 
                                                        </td>
                                                        
                                                    </tr>
                                                </table> 
                                           </td>
                                        </tr>
                                        <tr>
                                           <td colspan="9">
                                                <table>
                                                    <tr>
                                                        <td><a href=""><i class="bx bx-menu handle"></i></a> </td>
                                                        <td> 
                                                            <select name="item_id[]" class="form-control select2 item-dropdown-list" style="width:100%">                                                
                                                                <option >Choose...</option>
                                                                @foreach ($items as $item)
                                                                    <option value="{{$item->id}}"  data-unit-id="{{ $item->unit_id }}"  >{{ $item->name }}</option>
                                                                @endforeach
                                                                
                                                            </select>
                                                            
                                                        </td>
            
            
                                                        <td> 
                                                            <select name="unit_id[]"  class="form-control select2 unit-dropdown-list" style="width:100%">                                                
                                                                <option>Choose...</option>
                                                                @foreach ($units as $unit)
                                                                    <option value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                                                                @endforeach
                                                            </select>
                                                            
                                                        </td>
            
            
                                                        <td> 
                                                            <input type="number" name="unit_quantity[]" step="0.01" class="form-control item-unit-quantity " readonly>  
                                                        </td>
                                                        
                                                        
                                                        <td> 
                                                            <input type="number" name="quantity[]" step="0.01" class="form-control item-quantity">  
                                                        </td>
            
                                                        <td> 
                                                            <input type="number" name="gross_weight[]" step="0.01" class="form-control gross-weight" readonly>  
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="cut_percentage[]" value="0" step="0.01" class="form-control item-cut-percentage">  
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="cut_value[]" value="0" step="0.01" class="form-control item-cut-value" readonly>  
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="after_cut_total_weight[]" step="0.01" class="form-control item-after-cut-total-weight" readonly>  
                                                        </td>
            
            
            
                                                        <td> 
                                                            <input type="number" name="per_package_weight[]" value="0" step="0.01" class="form-control item-per-package-weight">  
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td> 
                                                            <input type="number" name="total_package_weight[]" value="0" step="0.01" class="form-control item-total-package-weight" readonly>  
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="net_weight[]" value="0" step="0.01" class="form-control item-net-weight" readonly>  
                                                        </td>
                                                    
            
            
            
                                                        <td> 
                                                            <input type="number" name="price[]" step="0.01" class="form-control item-price">  
                                                        </td>
            
                                                        <td> 
                                                            <input type="number" name="quantity_price[]" step="0.01" class="form-control item-quantity-price" readonly>  
                                                        </td>
            
            
            
            
                                                    
            
            
                                                        <td>
                                                            <input type="number" name="discount_value[]" value="0" step="0.01" class="form-control item-discount-value" >
                                                        </td>
                                                        <td>
                                                            <select name="discount_type[]"  class="form-select item-discount-type">                                                
                                                                <option selected value="fixed">Fixed</option>
                                                                <option value="percentage">%</option>
                                                            </select>
                                                        </td>
            
                                                        <td> 
                                                            <input type="number" name="after_discount[]" class="form-control item-after-discount" readonly>  
                                                        </td>
                                                        <td> 
                                                            <select name="tax_id[]"  class="form-control select2 item-tax-dropdown" style="width:100%">                                                
                                                                @foreach ($taxes as $tax)
                                                                    <option  value="{{$tax->id}}" data-tax-rate="{{ $tax->rate }}" >{{ $tax->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td> 
                                                            <input type="number" name="tax_value[]" class="form-control item-tax-value" readonly>  
                                                        </td>
            
                                                        <td class="text-center">  
                                                            <a href=""><span class="bx bx-trash text-danger remove-item"></span></a> 
                                                        </td>
                                                        
                                                    </tr>
                                                </table> 
                                           </td>
                                        </tr>
                                    </tbody> 
                                </table>   


                               

                                <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                            </div> 
                           

                            <div class="row">
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-4">
                                    <table id="summary-table" class="table">
                                        <tr>
                                            <th>Sub Total</th>
                                            <td>
                                                <input type="number" name="sub_total" id="sub-total" value="0" class="form-control" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>GST (18%)</th>
                                            <td>
                                                <input type="number" name="tax_total" id="tax-total" value="0" class="form-control" >
                                            </td>
                                        </tr>
                                       
                                        <tr>
                                            <th>Discount</th>
                                            <td>
                                                <input type="number" name="discount_total" id="discount-total" value="0" class="form-control" >
                                            </td>
                                        </tr>
                                       
                                    </table>
                                </div>
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
  

    $(document).on('change', '.item-dropdown-list', function(e){
        
        let selected_item = $(this).find('option:selected');
        
        let unit_id = selected_item.data('unit-id');
        
        let row =  $(this).closest('table');
        
        let unit_dropdown = row.find('.unit-dropdown-list');

        unit_dropdown.val(unit_id).trigger('change');
        
        calculation(row);  


    });
    $(document).on('change', '.unit-dropdown-list, .item-discount-type, .item-tax-dropdown', function(e){
    
        let row =  $(this).closest('table');
    
        calculation(row);  

    });

    $(document).on('keyup','.item-unit-quantity, .item-quantity, .item-price, .item-discount-value, .item-cut-percentage, .item-per-package-weight',function(){
        
        let row = $(this).closest('table');

        calculation(row);  
    });

   
    function calculation(row) {

        let quantity = parseFloat(row.find('.item-quantity').val()) || 0;
        let price = parseFloat(row.find('.item-price').val()) || 0;

        // Calculate total price for quantity and price
        let quantity_price = quantity * price;
        row.find('.item-quantity-price').val(quantity_price.toFixed(2));

        //Unit Quantity
        let selected_unit_base_value = row.find('.unit-dropdown-list option:selected').data('base-unit-value');
        row.find('.item-unit-quantity').val(selected_unit_base_value);

        //Gross Weight
        let gross_weight = selected_unit_base_value * quantity;
        row.find('.gross-weight').val(gross_weight.toFixed(2));


        //Cut Calcaution:start
            let cut_percentage = parseFloat(row.find('.item-cut-percentage').val()) || 0;
            let after_cut_total_weight =  gross_weight; 
            if(cut_percentage > 0){
                cut_value = (cut_percentage/100) * gross_weight;
                row.find('.item-cut-value').val(cut_value.toFixed(2));

                after_cut_total_weight = gross_weight - cut_value;

            }
            row.find('.item-after-cut-total-weight').val(after_cut_total_weight.toFixed(2));
        //Cut Calcaution:end


        //Package Weight Calcaution: start
            let per_package_weight = parseFloat(row.find('.item-per-package-weight').val()) || 0;
            let total_package_weight = per_package_weight * quantity;
            row.find('.item-total-package-weight').val(total_package_weight.toFixed(2));

            let net_weight = after_cut_total_weight - total_package_weight
            row.find('.item-net-weight').val(net_weight.toFixed(2));
        //Package Weight Calcaution: end



        // Discount Calculation: start
            let discount_type = row.find('.item-discount-type').val();
            let discount_value = parseFloat(row.find('.item-discount-value').val()) || 0;

            let after_discount = 0;

            // Calculate after discount based on discount type
            if (discount_type === "fixed") {
                after_discount = Math.max(quantity_price - discount_value, 0); // Avoid negative values
            } else if (discount_type === "percentage" && quantity_price > 0) {
                // Calculate percentage discount
                let percentage_amount = (quantity_price * discount_value) / 100;
                after_discount = Math.max(quantity_price - percentage_amount, 0); // Avoid negative values
            }
            row.find('.item-after-discount').val(after_discount.toFixed(2));
        // Discount Calculation: end


        let tax_rate = row.find('.item-tax-dropdown option:selected').data('tax-rate');
        let tax_value = (tax_rate / 100) * after_discount;

        if(after_discount > 0){
            row.find('.item-tax-value').val(tax_value.toFixed(2));

        }

        summaryCalculation();

    }

    function summaryCalculation()
    {
        let sub_total = 0;
        let tax_total = 0;
        let discount_total = 0;

        $('.item-after-discount').each(function(){
            let item_after_discount_value = parseFloat($(this).val()) || 0;
            sub_total+= item_after_discount_value;
        });
        $('#sub-total').val(sub_total);

        $('.item-tax-value').each(function(){
            let item_tax_value = parseFloat($(this).val()) || 0;
            tax_total+= item_tax_value;
        });
        $('#tax-total').val(tax_total);


        $('.item-discount-value').each(function(){
            let item_discount_value = parseFloat($(this).val()) || 0;
            discount_total+= item_discount_value;
        });
        $('#discount-total').val(discount_total);


    }

    

   

  

    $('#btn-add-more').on('click', function(e){
        e.preventDefault();
        appendNewRow();
       
    });
    $('.remove-item').on('click', function(e){
        e.preventDefault();

        $(this).closest('table').remove();
        alert("YES");
    });


    function appendNewRow(){
        let tableBody = $('#table tbody');

        let row = `
           <tr>
                <td colspan="9">
                    <table>
                        <tr>
                            <td><a href=""><i class="bx bx-menu handle"></i></a> </td>
                            <td> 
                                <select name="item_id[]" class="form-control select2 item-dropdown-list" style="width:100%">                                                
                                    <option >Choose...</option>
                                    @foreach ($items as $item)
                                        <option value="{{$item->id}}"  data-unit-id="{{ $item->unit_id }}"  >{{ $item->name }}</option>
                                    @endforeach
                                    
                                </select>
                                
                            </td>


                            <td> 
                                <select name="unit_id[]"  class="form-control select2 unit-dropdown-list" style="width:100%">                                                
                                    <option>Choose...</option>
                                    @foreach ($units as $unit)
                                        <option value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                                    @endforeach
                                </select>
                                
                            </td>


                            <td> 
                                <input type="number" name="unit_quantity[]" step="0.01" class="form-control item-unit-quantity " readonly>  
                            </td>
                            
                            
                            <td> 
                                <input type="number" name="quantity[]" step="0.01" class="form-control item-quantity">  
                            </td>

                            <td> 
                                <input type="number" name="gross_weight[]" step="0.01" class="form-control gross-weight" readonly>  
                            </td>
                            <td> 
                                <input type="number" name="cut_percentage[]" value="0" step="0.01" class="form-control item-cut-percentage">  
                            </td>
                            <td> 
                                <input type="number" name="cut_value[]" value="0" step="0.01" class="form-control item-cut-value" readonly>  
                            </td>
                            <td> 
                                <input type="number" name="after_cut_total_weight[]" step="0.01" class="form-control item-after-cut-total-weight" readonly>  
                            </td>



                            <td> 
                                <input type="number" name="per_package_weight[]" value="0" step="0.01" class="form-control item-per-package-weight">  
                            </td>
                        </tr>

                        <tr>
                            <td> 
                                <input type="number" name="total_package_weight[]" value="0" step="0.01" class="form-control item-total-package-weight" readonly>  
                            </td>
                            <td> 
                                <input type="number" name="net_weight[]" value="0" step="0.01" class="form-control item-net-weight" readonly>  
                            </td>
                        



                            <td> 
                                <input type="number" name="price[]" step="0.01" class="form-control item-price">  
                            </td>

                            <td> 
                                <input type="number" name="quantity_price[]" step="0.01" class="form-control item-quantity-price" readonly>  
                            </td>




                        


                            <td>
                                <input type="number" name="discount_value[]" value="0" step="0.01" class="form-control item-discount-value" >
                            </td>
                            <td>
                                <select name="discount_type[]"  class="form-select item-discount-type">                                                
                                    <option selected value="fixed">Fixed</option>
                                    <option value="percentage">%</option>
                                </select>
                            </td>

                            <td> 
                                <input type="number" name="after_discount[]" class="form-control item-after-discount" readonly>  
                            </td>
                            <td> 
                                <select name="tax_id[]"  class="form-control select2 item-tax-dropdown" style="width:100%">                                                
                                    @foreach ($taxes as $tax)
                                        <option  value="{{$tax->id}}" data-tax-rate="{{ $tax->rate }}" >{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td> 
                                <input type="number" name="tax_value[]" class="form-control item-tax-value" readonly>  
                            </td>

                            <td class="text-center">  
                                <a href=""><span class="bx bx-trash text-danger remove-item"></span></a> 
                            </td>
                            
                        </tr>
                    </table> 
                </td>
            </tr>
                            
        `;
        tableBody.append(row);
        $('.select2', 'table').select2();

    }


    

        


</script>


<script>
    $(document).ready(function() {
        // Function to update due date
        function updateDueDate() {
            var selectedDate = $('#date').val();  // Get the selected date
            var paymentTerm = parseInt($('#payment_terms').val());  // Get the payment term
            
            if (selectedDate) {
                var dueDate = new Date(selectedDate);
                dueDate.setDate(dueDate.getDate() + paymentTerm);  // Add payment term to the date
                
                // Format the date to YYYY-MM-DD
                var year = dueDate.getFullYear();
                var month = ("0" + (dueDate.getMonth() + 1)).slice(-2);
                var day = ("0" + dueDate.getDate()).slice(-2);
                
                $('#due_date').val(`${year}-${month}-${day}`);  // Update the due date input
            }
        }

        // Trigger when the date or payment terms change
        $('#date, #payment_terms').on('change', function() {
            updateDueDate();
        });

        $('#due_date').on('change', function(){
            $('#payment_terms').val('');
        })
    });
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
    

@endsection

