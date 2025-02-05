{{-- START:: Production Table Function --}}
<script>
  
    // START:: input: Total Tons calculation
        $(document).on('keyup', '#production_material_tons', function(e){
        
            let production_material_tons = parseFloat($(this).val()) || 0;
            
            $('#material-table tbody tr').each(function() {
                // Get the recipe quantity for the current row
                let recipe_quantity = parseFloat($(this).find('.recipe-quantity').val()) || 0;
                let unit_cost = parseFloat($(this).find('.stock-unit-cost').val()) || 0;

                // Calculate production quantity
                let production_quantity_weight = production_material_tons * recipe_quantity;
                // Insert the calculated production quantity into the production-quantity-weight cell
                $(this).find('.production-quantity-weight').val(production_quantity_weight.toFixed(4));

                // Calculate cost
                let total_cost = production_quantity_weight * unit_cost;
                $(this).find('.stock-total-cost').val(total_cost.toFixed(2));

                

            
            });

            checkStockQuantity();// check stock and production quantity
            productionSummaryCalculation();
            
            summaryCalculation();
        });
        
        function checkStockQuantity() {
            
            let disableButton = false; // Flag to track stock status
            
            // loop through each item
            $('#material-table tbody tr').each(function() {
                let production_quantity_weight = parseFloat($(this).find('.production-quantity-weight').val()) || 0;
                let stock_quantity = parseFloat($(this).find('.stock-quantity').val()) || 0;
                
                $('#submit-production-store').prop('disabled',true);
                // Check if stock quantity is greater than production quantity
                // 1)make production_quantity_weight red 2)show status out of stock 3)disable SAVE button
                if (stock_quantity < production_quantity_weight) {
                    $(this).find('.production-quantity-weight').addClass('text-danger');
                    $(this).find('.stock-status-cross').removeClass('d-none');  
                    $(this).find('.stock-status-tick').addClass('d-none');  
                    disableButton = true; // Mark that we need to disable the button

                } else {
                    $(this).find('.production-quantity-weight').removeClass('text-danger'); // Reset color if condition is not met
                    $(this).find('.stock-status-cross').addClass('d-none');  
                    $(this).find('.stock-status-tick').removeClass('d-none');  

                }
            });

            // Disable or enable the button based on stock status
            if (disableButton) {
                $('#submit-production-store').prop('disabled', true);
            } else {
                $('#submit-production-store').prop('disabled', false);
            }
        }

        
    // END:: input: Total Tons calculation    

    // START: Recipe and Material table   
        
        //on Change of recipe dropdown
        $(document).on('select2:select', '#recipe_id', function(e){
            let recipe_id = $(this).val();
            if(recipe_id){
                $('#production_material_tons').prop('disabled', false);
                $('#production_material_tons_message').addClass('d-none');


                getRecipeDetailWithStock(recipe_id);

            }
            else{
                $('#production_material_tons').prop('disabled', true).val('');//adding disable and val empty
                $('#production_material_tons_message').removeClass('d-none');
                $('#material-table tbody').empty();
            }
        
        
        });
            
        function getRecipeDetailWithStock(id) {
            $.get("{{ route('getRecipeDetailWithStock', ':id') }}".replace(':id', id), {
                beforeSend: function() {
                    $('#progressModal').modal('show'); // Show the progress bar before the request is sent
                }
            }).done(function(response) {
                $('#material-table tbody').empty();
                
                // Loop through the response data and append rows to the table
                response.recipeDetails.forEach(function(detail) {
                    $('#material-table tbody').append(
                        `<tr>
                            <td class="text-start">
                                <input type="hidden" name="production_item_id[]" value="${detail.item_id}" readonly>
                                <input type="text" value="${detail.name}" readonly>
                            </td>
                            <td class="d-none">
                                <input type="text" name="production_unit_id[]" value="${detail.base_unit}" readonly>
                            </td>    
                            <td class="text-end">
                                <input type="number" name="" step="0.0001" class="recipe-quantity text-end" value="${detail.quantity}" readonly>
                            </td>
                            <td class="text-end">
                                <input type="number" name="production_quantity_weight[]" step="0.0001" class="production-quantity-weight text-end" readonly>
                            </td>
                            <td class="text-end">
                                <input type="number" name="" step="0.0001" class="stock-quantity text-end" value="${detail.balance}" readonly>
                            </td> 
                            <td class="text-end d-none">
                                <input type="number" name="production_unit_cost[]" step="0.0001" class="stock-unit-cost text-end" value="${detail.purchase_unit_price }" readonly>
                            </td> 
                            <td class="text-end d-none">
                                <input type="number" name="production_item_total_cost[]" step="0.0001" class="stock-total-cost text-end" value="" readonly>
                            </td> 
                           
                            <td class="text-center">
                                <span class="stock-status-tick  bx bxs-check-circle text-success    fs-4"></span>
                                <span class="stock-status-cross bx bxs-x-circle     text-danger     fs-4 d-none"></span>
                            </td>
                        </tr>`
                    );
                });

                $('#progressModal').modal('hide'); // Hide the progress bar after the request completes
                $('#production_material_tons').focus();

            }).fail(function(xhr) {
                alert('Error fetching brand details: ' + xhr.responseText);
            });

        }

    // END: Recipe and Material table    

</script>


{{-- START:: Output Table Function --}}
    <script>
        // Change Item Dropdown
        $(document).on('change', '.output-item-dropdown', function(e){

            let selected_item = $(this).find('option:selected');
            
            let unit_id = selected_item.data('unit-id');
            let unit_weight = parseFloat(selected_item.data('unit-weight')) || 0;

            let row =  $(this).closest('tr');

            let unit_dropdown = row.find('.output-item-unit-dropdown');
            row.find('.output-unit-weight').val(unit_weight.toFixed(2));

            unit_dropdown.val(unit_id).trigger('change');
            
            
            calculation(row);  
            
            // $(this).select2('close');

            
        });

        $(document).on('change', '.surplus-checkbox', function(e){
            e.preventDefault();

            let row =  $(this).closest('tr');
            // Check if the checkbox is checked
            if ($(this).prop('checked')) {
                row.find('.is-surplus-value').val(1);
            }else{
                row.find('.is-surplus-value').val(0);

            }

            summaryCalculation();
        });

        function calculation(row)
        {
            let quantity = parseFloat(row.find('.output-quantity').val()) || 0;
            let unit_weight = parseFloat(row.find('.output-unit-weight').val()) ||0;
            let avg_production_unit_price = $('#materail_avg_unit_price').val() ||0; 
            
            
            let quanity_weight = quantity * unit_weight;
            row.find('.output-quantity-weight').val(quanity_weight.toFixed(2));
          
            let per_unit_cost = avg_production_unit_price * unit_weight;
            row.find('.output-per-unit-cost').val(per_unit_cost.toFixed(2));

            let total_cost = avg_production_unit_price * quanity_weight;
            row.find('.output-total-cost').val(total_cost.toFixed(2));

            

            summaryCalculation();
        }
        //Quantity Value Change
        $(document).on('keyup','.output-quantity', function(e){
            e.preventDefault(); // Prevent the default behavior (form submission)
            
            let row =  $(this).closest('tr');
            calculation(row);  
           
        });

        // Click Add More Button
        $('#btn-add-more').on('click', function(e){
            e.preventDefault();
            appendNewRow();
        });

        //Click Trash Icon
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
            let tableBody = $('#output-table tbody');

            let row = `
            <tr>
                <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>
                <td class="text-center"> 
                    <input class="form-check-input surplus-checkbox" type="checkbox" >
                    <input name="is_surplus[]" class="is-surplus-value" type="hidden" value="0">
                </td>
                <td> 
                    <select  name="output_item_id[]" class="form-control select2 output-item-dropdown" style="width:100%" >                                                
                        <option value="" >Choose...</option>
                        @foreach ($goodItems as $item)
                            <option value="{{$item->id}}" data-unit-id="{{ $item->unit_id }}"  data-unit-weight="{{ $item->unit_weight }}">{{ $item->code.'-'.$item->category->name .'-'.$item->name }}</option>
                        @endforeach

                    </select>

                </td>
                    
                <td class="d-none"> 
                    <select name="output_unit_id[]"  class="form-control select2 output-item-unit-dropdown" style="width:100%">                                                
                        <option>Choose...</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                        @endforeach
                    </select>

                </td> 

                <td>
                    <input type="number" name="output_unit_weight[]" step="0.0001" class="form-control output-unit-weight" readonly>  
                </td>
                <td>
                    <input type="number" name="output_quantity[]" step="0.0001" class="form-control output-quantity">  
                </td>
                <td>
                    <input type="number" name="output_quantity_weight[]" step="0.0001" class="form-control output-quantity-weight" readonly>  
                </td>
                <td>
                    <input type="number" name="output_per_unit_cost[]" step="0.0001" class="form-control output-per-unit-cost" readonly>  
                </td>
                <td>
                    <input type="number" name="output_total_cost[]" step="0.0001" class="form-control output-total-cost" readonly>  
                </td>
                <td class="text-center">  
                    <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                </td>
            </tr>
            `;
        
            tableBody.append(row);
            $('.select2', '#output-table').select2();

        }
    
        function summaryCalculation()
        {
            let output_sub_total_weight = 0;
            let production_sub_total_weight = 0;
            let surplus_sub_total_weight = 0;
            let wastage_quantity_weight = 0;
            let total_production_cost = 0;
            let output_bags = 0;
            let surplus_bags = 0;

            $('.production-quantity-weight').each(function(){
                let production_quantity_weight = parseFloat($(this).val()) || 0;
                production_sub_total_weight+= production_quantity_weight;
            });
            $('#production-sub-total-weight').val(production_sub_total_weight.toFixed(2));



            $('.output-total-cost').each(function(){
                let value = parseFloat($(this).val()) || 0;
                total_production_cost+= value;
            });
            $('#total-production-cost').val(total_production_cost.toFixed(2));



    
            $('.output-quantity-weight').each(function(){

                let row = $(this).closest('tr');

                let isSurplus = row.find('.surplus-checkbox').is(':checked');
                
                let item_quantity_weight = parseFloat($(this).val()) || 0;
                
                if(isSurplus){
                    surplus_sub_total_weight+= item_quantity_weight;
                }
                else{
                    output_sub_total_weight+= item_quantity_weight;
                }
              
            });
            $('#output-sub-total-weight').val(output_sub_total_weight.toFixed(2));
            $('#surplus-sub-total-weight').val(surplus_sub_total_weight.toFixed(2));


            $('.output-quantity').each(function(){

                let row = $(this).closest('tr');

                let isSurplus = row.find('.surplus-checkbox').is(':checked');
                
                let value = parseFloat($(this).val()) || 0;

                if(isSurplus){
                    surplus_bags+= value
                }
                else{
                    output_bags+= value
                }
              
            });
            $('#output-bags').val(output_bags.toFixed(2));
            $('#surplus-bags').val(surplus_bags.toFixed(2));


            $('.output-quantity-weight').each(function(){

                let row = $(this).closest('tr');

                let isSurplus = row.find('.surplus-checkbox').is(':checked');

                let item_quantity_weight = parseFloat($(this).val()) || 0;

                if(isSurplus){
                    surplus_sub_total_weight+= item_quantity_weight;
                }
                else{
                    output_sub_total_weight+= item_quantity_weight;
                }

            });






            outputTableCalculation(production_sub_total_weight);

    
            // checkProductionOutputWeight(output_sub_total_weight, production_sub_total_weight);
        }


        function outputTableCalculation(prodcution_weight)
        {
            let output_item = $('#output-item').val();
            let unit_weight = $('#output-item option:selected').data('unit-weight'); 

           
            let first_row = $('#output-table tbody tr:first');
            let output_item_id = first_row.find('.output-item-dropdown option:selected').val();
            
            let avg_production_unit_price = $('#materail_avg_unit_price').val() ||0; 


            if (output_item == output_item_id) {
               
                let qty = parseFloat(prodcution_weight / unit_weight);
             
                first_row.find('.output-quantity').val(qty.toFixed(2));
                first_row.find('.output-quantity-weight').val((qty*unit_weight).toFixed(2));

                let total_cost = avg_production_unit_price * prodcution_weight;
                first_row.find('.output-total-cost').val(total_cost.toFixed(2));
                summaryCalculation();// becuase once costing is done then we will get production cost vlaue
            }

        }
    
        function checkProductionOutputWeight(output_weight, production_weight) {
            
            if(output_weight > production_weight){
                $('#production-sub-total-weight').addClass('text-danger');
            }else{
                $('#production-sub-total-weight').removeClass('text-danger');
            }
    
            if(output_weight == production_weight){
                $('#submit-production-store').prop('disabled', false);
            }else{
                $('#submit-production-store').prop('disabled', true);
            }
        }
    
    </script>



{{-- END:: Output Table Function --}}

<script>

    function productionSummaryCalculation()
    {
        
        let materail_recipe_qty_total = 0;
        let materail_production_qty_total = 0;
        let materail_stock_qty_total = 0;
        let materail_avg_unit_price = 0;
        let materail_total_cost = 0;
        
        $('.recipe-quantity').each(function(){
            let value = parseFloat($(this).val()) || 0;
            materail_recipe_qty_total+= value;
        });
        $('#materail_recipe_qty_total').val(materail_recipe_qty_total.toFixed(2));


        $('.production-quantity-weight').each(function(){
            let value = parseFloat($(this).val()) || 0;
            materail_production_qty_total+= value;
        });
        $('#materail_production_qty_total').val(materail_production_qty_total.toFixed(2));

        $('.stock-quantity').each(function(){
            let value = parseFloat($(this).val()) || 0;
            materail_stock_qty_total+= value;
        });
        $('#materail_stock_qty_total').val(materail_stock_qty_total.toFixed(2));

       
        $('.stock-total-cost').each(function(){
            let value = parseFloat($(this).val()) || 0;
            materail_total_cost+= value;
        });
        $('#materail_total_cost').val(materail_total_cost.toFixed(2));

        materail_avg_unit_price = materail_total_cost/materail_production_qty_total;
        $('#materail_avg_unit_price').val(materail_avg_unit_price.toFixed(2));

        
    }
    $(document).on('select2:select','#output-item', function(e){
        e.preventDefault();
        let selected_item = $(this).val();
        let table = $('#output-table tbody');
        table.empty();// remove tbody all rows
        appendNewRow();// add new row
     
        table.find('tr:first').find('.output-item-dropdown').val(selected_item).trigger('change');

       
        
    });
    
</script>


{{-- START:: sortable #sortable-table --}}
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
{{-- END:: sortable #sortable-table --}}
