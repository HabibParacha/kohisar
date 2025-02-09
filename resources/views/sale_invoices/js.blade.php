
<script>
    
    $('#btn-add-more').on('click', function(e){
        e.preventDefault();

        appendNewRow();
       
    });
    
   
   

    function appendNewRow(){
        let tableBody = $('#table tbody');

        let row = `
                <tr class="">
                    <td class="text-end"><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>
    
                    <td class=""> 
                        <select  name="item_id[]" class="form-control select2 item-dropdown" style="width:100%">                                                
                            <option value="" >Choose...</option>
                            @foreach ($itemGoods as $item)
                                <option value="{{$item->id}}"
                                 data-stock="{{ $item->balance }}"  
                                 data-unit-weight="{{ $item->unit_weight }}"
                                 data-sell-price="{{ $item->sell_price }}"
                                 data-purchase-price="{{ $item->purchase_price }}"
                                >
                                 {{ $item->code.'-'.$item->category_name .'-'.$item->name }}</option>
                            @endforeach
    
                        </select>

                    </td> 
                    
                    <td class="text-end">
                        <input type="number" name="unit_weight[]" step="0.0001" class=" text-end form-control item-unit-weight" readonly>  
                    </td>
                    <td class="text-end">
                        <input type="number"  step="0.0001" class=" text-end form-control item-stock-balance" readonly>  
                    </td>
                    <td class="text-end">
                        <input type="number" name="total_quantity[]" step="0.0001" class=" text-end form-control item-total-quantity" >  
                    </td>
                    <td class="text-end">
                        <input type="number" name="net_weight[]" step="0.0001" class=" text-end form-control item-net-weight" readonly>  
                    </td>
                    <td class="text-end">
                         <input type="number" name="purchase_unit_price[]" step="0.0001" class="text-end form-control item-purchase-unit-price" readonly>  
                        <input type="number" name="per_unit_price[]" step="0.0001" class=" text-end form-control item-per-unit-price">  
                    </td>
                    <td class="text-end">
                        <input type="number" name="total_price[]" step="0.0001" class=" text-end form-control item-total-price" readonly>  
                    </td>

                    <td>
                        <input type="number" name="discount_value[]" value="0" step="0.01" class="form-control item-discount-value" >
                    </td>
    
                    <td>
                        <select name="discount_type[]"  class="form-select item-discount-type">                                                
                            <option selected value="percentage">%</option>
                            <option  value="fixed">Fixed</option>
                        </select>
                    </td>
                    <td class="text-end">
                        <input type="number" name="discount_unit_price[]" value="0" step="0.01" class=" text-end form-control item-discount-unit-price" readonly>
                    </td>
                    
                    
                    <td class="text-end">
                        <input type="number" name="discount_amount[]" value="0" step="0.01" class=" text-end form-control item-discount-amount" readonly>
                    </td>

                    

                    <td class="text-end"> 
                        <input type="number" name="total_purchase_price[]" step="0.0001" class="text-end form-control item-total-purchase-price" readonly>  

                        <input type="number" name="after_discount_total_price[]" class=" text-end form-control item-after-discount" readonly>  
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
    
    $(document).on('keyup','#wth-rate, #gst-rate, #commission-rate, #shipping', function(e){
        summaryCalculation();

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


    
       //  Detect Enter key in input fields
    $('#sale-invoice-store').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });

    // warehouse dropdown called on change of party
    $(document).ready(function () {
        $('#party_id').on('select2:select', function(e){
            e.preventDefault();

            let party_id = $(this).find('option:selected').val();

            var warehouseDropdown = $('#party_warehouse_id');
            
            $.ajax({
                url: `{{ route('party-warehouse.fetchList','') }}/${party_id}`,
                type: 'GET',
                beforeSend: function() {
                    warehouseDropdown.append('<option value="">Loading...</option>');
                },
                success: function(data) {
                    warehouseDropdown.empty(); // Clear current options
                    console.log(data);

                    warehouseDropdown.append('<option selected value="">Choose...</option>');
                    
                    // Check if data is empty
                    if (data.length === 0) {
                        warehouseDropdown.append('<option disabled>No records found</option>');
                    } else {
                        // Append the new items
                        $.each(data, function(index, warehouse) {
                            warehouseDropdown.append(new Option(warehouse.name, warehouse.id));
                        });
                    }

                    // Close the dropdown
                    warehouseDropdown.select2('close');
                    // Notify select2 about the change
                    warehouseDropdown.trigger('change');
                    warehouseDropdown.select2('open');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    alert('Failed to load items. Please try again.'); // Optional user feedback
                }
            });
            
        });
    });
    

    //item Dropdown Change
    $(document).on('change', '.item-dropdown', function(e){
        
        let selected_item = $(this).find('option:selected');
        
        let unit_id = selected_item.data('unit-id');
        let unit_weight = parseFloat(selected_item.data('unit-weight')) || 0;
        let stock_balance = parseFloat(selected_item.data('stock')) || 0;
        let sell_price = parseFloat(selected_item.data('sell-price')) || 0;
        let purchase_price = parseFloat(selected_item.data('purchase-price')) || 0;

        let row =  $(this).closest('tr');
        
        let unit_dropdown = row.find('.item-unit-dropdown');
        row.find('.item-unit-weight').val(unit_weight.toFixed(2));
        row.find('.item-stock-balance').val(stock_balance.toFixed(0));//remove decimal
        row.find('.item-per-unit-price').val(sell_price.toFixed(0));//remove decimal
        row.find('.item-purchase-unit-price').val(purchase_price.toFixed(2));//remove decimal



        unit_dropdown.val(unit_id).trigger('change');
        $(this).select2('close');
        
        calculation(row);  
    });

    $(document).on('change', '.item-discount-type', function(e){
        let row = $(this).closest('tr');

        calculation(row);  
    });


    //input: quantity, unit price
    $(document).on('keyup','.item-total-quantity, .item-per-unit-price, .item-discount-value',function(){
        let row = $(this).closest('tr');

        calculation(row);  
    });

    
    function calculation(row) {

        let quantity = parseFloat(row.find('.item-total-quantity').val()) || 0;
        let per_unit_price = parseFloat(row.find('.item-per-unit-price').val()) || 0;
        let purchase_unit_price = parseFloat(row.find('.item-purchase-unit-price').val()) || 0;
        let unit_weight = parseFloat(row.find('.item-unit-weight').val()) || 0;
        let stock_balance = parseFloat(row.find('.item-stock-balance').val()) || 0;

        //Check Quantity with Stock Qunatity : Start
            let stop = 0;
            if(quantity > stock_balance)
            {
                stop = 1;
                
            }
            if(stop == 1)
            {
                $('#submit-sale-invoice-store').prop('disabled',true);
                row.addClass('bg-danger');
            }else{
                $('#submit-sale-invoice-store').prop('disabled',false);
                row.removeClass('bg-danger');

            }
        //Check Quantity with Stock Qunatity : End


        //Amount: start    
            let total_purchase_price = quantity * purchase_unit_price;
            row.find('.item-total-purchase-price').val(total_purchase_price.toFixed(2));
            
            let total_price = quantity * per_unit_price;
            row.find('.item-total-price').val(total_price.toFixed(2));


            let net_weight = quantity*unit_weight;
            row.find('.item-net-weight').val(net_weight.toFixed(2));
            

        //Amount: end    


        // Discount Calculation: start


            let discount_type = row.find('.item-discount-type').val();
            let discount_value = parseFloat(row.find('.item-discount-value').val()) || 0;
            let discount_unit_price = 0;

            // Calculate after discount based on discount type
            if (discount_type === "fixed") {
                discount_unit_price = Math.max(per_unit_price - discount_value, 0); // Avoid negative values
                } else if (discount_type === "percentage" && per_unit_price > 0) {
                    // Calculate percentage discount
                    let percentage_amount = (per_unit_price * discount_value) / 100;
                    discount_unit_price = Math.max(per_unit_price - percentage_amount, 0); // Avoid negative values
                }
                row.find('.item-discount-unit-price').val(discount_unit_price.toFixed(2));



            let after_discount = 0;
            let discount_amount = 0;


            if(discount_unit_price > 0 && discount_unit_price < per_unit_price)
            {
                after_discount = quantity * discount_unit_price;
                discount_amount = total_price-after_discount;

            }else{
                after_discount = total_price;
                discount_amount = 0;
            }
            if(discount_unit_price > per_unit_price)
            {
                alert('Wrong input: discount unit price cannot be greater than the original unit price.');
            }

            row.find('.item-discount-amount').val(discount_amount.toFixed(2));
            row.find('.item-after-discount').val(after_discount.toFixed(2));

        // Discount Calculation: end

        summaryCalculation();

    }

    function summaryCalculation()
    {
        let sub_total = 0;
        let total_before_discount = 0;
        let total_after_discount = 0;
        let discount_total = 0;
        let grand_total = 0;
        let discount_grand_total =0;

        let shipping = 0;

        let commission_amount = 0;
        let wth_amount = 0;
        let gst_amount = 0;

        let inventory = 0;

        let grand_total_purchase_price = 0;

        let x_freight_checkbox = $('#x-freight-checkbox').prop('checked');
        let total_freight = parseFloat($('#total-freight').val()) || 0;

        $('.item-total-price').each(function(){
            let item_total_price = parseFloat($(this).val()) || 0;
            total_before_discount+= item_total_price;
        });

        $('.item-after-discount').each(function(){
            let item_discount_value = parseFloat($(this).val()) || 0;
            total_after_discount+= item_discount_value;
        });


        $('.item-total-purchase-price').each(function(){
            grand_total_purchase_price += parseFloat($(this).val()) || 0;
        });




        $('#sub-total').val(total_after_discount.toFixed(2));

       


        discount_grand_total = total_before_discount-total_after_discount;
        if(discount_grand_total > 0){
            $('#discount-total').val(discount_grand_total.toFixed(2));
        }else{
            $('#discount-total').val(0);

        }


        // Calculate the withholding amount
        let wth_rate = parseFloat($('#wth-rate').val());
        if( wth_rate > 0){
            wth_amount = parseFloat((total_after_discount * wth_rate) / 100);
            $('#wth-amount').val(wth_amount.toFixed(2));
        }
        // Calculate the gst amount
        let gst_rate = parseFloat($('#gst-rate').val());
        if( gst_rate > 0){
            
            gst_amount = parseFloat((total_after_discount * gst_rate) / 100);
            $('#gst-amount').val(gst_amount.toFixed(2));
        }

        // Calculate the Commission amount
        let commission_rate = parseFloat($('#commission-rate').val());
        if( commission_rate > 0){
            commission_amount = parseFloat((total_after_discount * commission_rate) / 100);
            $('#commission-amount').val(commission_amount.toFixed(2));
        }

        inventory = total_after_discount - commission_amount;
        grand_total = total_after_discount + wth_amount + gst_amount;
        // if(x_freight_checkbox)
        // {
        //     inventory = total_after_discount - commission_amount;
        //     grand_total = total_after_discount + wth_amount + gst_amount;

        // }else{
        //     inventory = total_after_discount - (commission_amount + shipping);
        //     grand_total = total_after_discount + wth_amount + gst_amount;

        // }


        $('#grand-total').val(grand_total.toFixed(2));

        $('#inventory').val(inventory.toFixed(2));
        $('#grand-total-purchase-price').val(grand_total_purchase_price.toFixed(2));


        invoiceDetailSummary();

    }

    function invoiceDetailSummary()
    {
        let qty = 0;
        let total_weight = 0;
        
        $('.item-total-quantity').each(function(){
            let data = parseFloat($(this).val()) || 0;
            qty+= data;
        }); 
        $('#qty').text(qty);

        $('.item-net-weight').each(function(){
            let data = parseFloat($(this).val()) || 0;
            total_weight+= data;
        }); 
        $('#total-weight').text(total_weight.toFixed(2));



    }

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



