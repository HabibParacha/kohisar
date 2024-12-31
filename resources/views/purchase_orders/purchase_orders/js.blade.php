

<script>
$(document).on('change', '.unit-dropdown-list, .item-discount-type, .item-tax-dropdown', function(e){
    
    let row =  $(this).closest('tr');

    calculation(row);  

});

$(document).on('keyup','.item-gross-weight, .item-per-unit-price, .item-discount-value, .item-cut-percentage, .item-per-package-weight, .item-total-quantity',function(){
    
    let row = $(this).closest('tr');

    calculation(row);  
});

$(document).on('change', '.cut-checkbox', function(e){
    
    let row =  $(this).closest('tr');

    if($(this).prop('checked'))
    {
        
       row.find('.item-cut-percentage').removeClass('d-none');
       row.find('.item-cut-value').removeClass('d-none');
       row.find('.item-after-cut-total-weight').removeClass('d-none');
    }   
    else{
        row.find('.item-cut-percentage').addClass('d-none').val('0');//reest value to 0
        row.find('.item-cut-value').addClass('d-none').val('0');//reest value to 0
        row.find('.item-after-cut-total-weight').addClass('d-none');
        calculation(row);

    }     

});

function calculation(row) {

    let gross_weight = parseFloat(row.find('.item-gross-weight').val()) || 0;
    let price = parseFloat(row.find('.item-price').val()) || 0;

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
        let total_quantity = parseFloat(row.find('.item-total-quantity').val()) || 0;
        let per_package_weight = parseFloat(row.find('.item-per-package-weight').val()) || 0;

        let total_package_weight = per_package_weight * total_quantity;
        row.find('.item-total-package-weight').val(total_package_weight.toFixed(2));

        let net_weight = after_cut_total_weight - total_package_weight
        row.find('.item-net-weight').val(net_weight.toFixed(2));
    //Package Weight Calcaution: end

    //Total Price Calcaution: start    
        let per_unit_price =  parseFloat(row.find('.item-per-unit-price').val()) || 0;
        let total_price = per_unit_price * after_cut_total_weight;
        row.find('.item-total-price').val(total_price.toFixed(2));
    //Total Price Calcaution: end    

    summaryCalculation();

}


function summaryCalculation()
{
    let sub_total = 0;
    let sub_total_stock = 0;
    let tax_total = 0;
    let discount_total = 0;
    let grand_total = 0;
    let total_bags = 0;

    let x_freight_checkbox = $('#x-freight-checkbox').prop('checked');
    let total_freight = parseFloat($('#total-freight').val()) || 0;
    let total_net_weight = 0;
    let xfreight_per_kg = 0;// this will be added to per kg price supplier if x-freight is enabled

    
    $('.item-net-weight').each(function(){
        total_net_weight += parseFloat($(this).val()) || 0;
    });

    $('.item-total-price').each(function(){
        let item_total_price = parseFloat($(this).val()) || 0;
        sub_total+= item_total_price;
    });
    $('#sub-total').val(sub_total.toFixed(2));


    $('.item-total-quantity').each(function(){
        let value = parseFloat($(this).val()) || 0;
        total_bags+= value;
    });
    $('#total-bags').val(total_bags.toFixed(2));

    
    if(x_freight_checkbox && total_freight > 0){
        xfreight_per_kg = total_freight/total_net_weight;
        
    }else{
        let value = sub_total - total_freight;
        $('#sub-total').val(value.toFixed(2));
    }

    // 

    $('.item-total-price').each(function(){
        let row = $(this).closest('tr');

        let total_price = parseFloat($(this).val());
        let net_weight = parseFloat(row.find('.item-net-weight').val());

        let unit_price = parseFloat(total_price/net_weight);
        
        let stock_unit_price = parseFloat(unit_price + xfreight_per_kg);
        row.find('.item-per-unit-price-stock').val(stock_unit_price.toFixed(3));


        let stock_total_price = parseFloat(stock_unit_price * net_weight);
        row.find('.item-total-price-stock').val(stock_total_price.toFixed(2));

    });

    $('.item-total-price-stock').each(function(){
        sub_total_stock+= parseFloat($(this).val()) || 0;
    });
    $('#sub-total-stock').val(sub_total_stock.toFixed(2));

    grand_total = sub_total;
    $('#grand-total').val(grand_total.toFixed(2));


    

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

$('#x-freight-checkbox').on('click', function(e){
    toggleXFreightValue();
    summaryCalculation();
});
$('#total-freight').on('keyup', function(e){
    summaryCalculation();
});

function toggleXFreightValue(){
    let xfreightCheckbox = $('#x-freight-checkbox').prop('checked');
    if(xfreightCheckbox){
        $('#is-x-freight').val('1');
    }else{
        $('#is-x-freight').val('0');
    }
}


function appendNewRow(){
    let tableBody = $('#table tbody');

    let row = 
    `<tr>
        <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>
        <td> 
            <select  name="item_id[]" class="form-control select2 item-dropdown-list" style="width:150px">                                                
               
                
            </select>
            
        </td>  
    
        <td class="text-end"> 
            <input  type="number" name="gross_weight[]" step="0.0001" class="form-control item-gross-weight"  autocomplete="off">  
        </td>

        <td class="text-center"> 
            <input class="form-check-input cut-checkbox" type="checkbox">
        </td>
        <td> 
            <input type="number" name="cut_percentage[]"  step="0.0001" class="form-control item-cut-percentage d-none"  autocomplete="off">  
        </td>
        <td> 
            <input type="number" name="cut_value[]" value="0" step="0.0001" class="form-control item-cut-value d-none text-end" readonly>  
        </td>
        <td> 
            <input type="number" name="after_cut_total_weight[]" step="0.0001" class="form-control item-after-cut-total-weight d-none text-end" readonly>  
        </td>



        <td> 
            <input type="number" name="total_quantity[]" step="0.0001" class="form-control item-total-quantity"  autocomplete="off">  
        </td>
        <td> 
            <input type="number" name="per_package_weight[]" step="0.0001" class="form-control item-per-package-weight"  autocomplete="off">  
        </td>
        <td> 
            <input type="number" name="total_package_weight[]" value="0" step="0.0001" class="form-control item-total-package-weight text-end" readonly>  
        </td>
        <td> 
            <input type="number" name="net_weight[]" value="0" step="0.0001" class="form-control item-net-weight text-end" readonly>  
        </td>
        


        <td> 
            <input type="number" name="per_unit_price[]" step="0.0001" class="form-control item-per-unit-price"  autocomplete="off">  
        </td>
        

        <td > 
            <input type="number" name="total_price[]" step="0.0001" class="form-control item-total-price text-end" readonly>  
        </td>
        <td> 
            <input type="number" name="per_unit_price_stock[]" step="0.0001" class="form-control item-per-unit-price-stock text-end"  readonly>  
        </td>
        

        <td > 
            <input type="number" name="total_price_stock[]" step="0.0001" class="form-control item-total-price-stock text-end" readonly>  
        </td>


        <td class="text-center">  
            <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
        </td>

    </tr>`;
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
    $(document).ready(function () {
        $('#item-store').on('submit', function(e) {
                e.preventDefault();
                var submit_btn = $('#submit-item-store');
                let createformData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('item.store') }}",
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
                        
                        submit_btn.prop('disabled', false).html('Create Item');  

                        if(response.success == true){
                            $('#add-item').modal('hide'); 
                            $('#item-store')[0].reset();  // Reset all form data
                        
                            notyf.success({
                                message: response.message, 
                                duration: 3000
                            });
                        }else{
                            notyf.error({
                                message: response.message,
                                duration: 5000
                            });
                        }   
                    },
                    error: function(e) {
                        submit_btn.prop('disabled', false).html('Create Item');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });
    });
</script>