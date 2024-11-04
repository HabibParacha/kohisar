{{-- START:: Production Table Function --}}
<script>
  
    // START:: input: Total Tons calculation
        $(document).on('keyup', '#production_material_tons', function(e){
        
            let production_material_tons = parseFloat($(this).val()) || 0;
            
            $('#material-table tbody tr').each(function() {
                // Get the recipe quantity for the current row
                let recipe_quantity = parseFloat($(this).find('.recipe-quantity').val()) || 0;

                // Calculate production quantity
                let production_quantity_weight = production_material_tons * recipe_quantity;

                // Insert the calculated production quantity into the production-quantity-weight cell
                $(this).find('.production-quantity-weight').val(production_quantity_weight.toFixed(4));

            
            });

            checkStockQuantity();// check stock and production quantity
            summaryCalculation();
        });

        function checkStockQuantity() {
            $('#material-table tbody tr').each(function() {
                let production_quantity_weight = parseFloat($(this).find('.production-quantity-weight').val()) || 0;
                let stock_quantity = parseFloat($(this).find('.stock-quantity').val()) || 0;
                
                // Check if stock quantity is greater than production quantity
                // 1)make production_quantity_weight red 2)show status out of stock 3)disable SAVE button
                if (stock_quantity < production_quantity_weight) {
                    $(this).find('.production-quantity-weight').addClass('text-danger');
                    $(this).find('.stock-status-cross').removeClass('d-none');  
                    $(this).find('.stock-status-tick').addClass('d-none');  

                } else {
                    $(this).find('.production-quantity-weight').removeClass('text-danger'); // Reset color if condition is not met
                    $(this).find('.stock-status-cross').addClass('d-none');  
                    $(this).find('.stock-status-tick').removeClass('d-none');  
                }
            });
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
                            <td>
                                <input type="hidden" name="production_item_id[]" value="${detail.item_id}" readonly>
                                <input type="text" value="${detail.name}" readonly>
                            </td>
                            <td>
                                <input type="text" name="production_unit_id[]" value="${detail.base_unit}" readonly>
                            <td>
                                <input type="number" name="" step="0.0001" class="recipe-quantity text-end" value="${detail.quantity}" readonly>
                            </td>
                            <td>
                                <input type="number" name="production_quantity_weight[]" step="0.0001" class="production-quantity-weight text-end" readonly>
                            </td>
                            <td>
                                <input type="number" name="" step="0.0001" class="stock-quantity text-end" value="${detail.balance}" readonly>
                            </td> 
                           
                            <td>
                                <span class="stock-status-tick  bx bxs-check-circle text-success    fs-4"></span>
                                <span class="stock-status-cross bx bxs-x-circle     text-danger     fs-4 d-none"></span>
                            </td>
                        </tr>`
                    );
                });

                $('#progressModal').modal('hide'); // Hide the progress bar after the request completes
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
            $(this).select2('close');
            
            calculation(row);  
        });

    
        //Quantity Value Change
        $(document).on('keyup','.output-quantity', function(e){
            e.preventDefault(); // Prevent the default behavior (form submission)
            
            let row =  $(this).closest('tr');
            let quantity = parseFloat(row.find('.output-quantity').val()) || 0;
            let unit_weight = parseFloat(row.find('.output-unit-weight').val()) || 0;
            let quanity_weight = quantity*unit_weight;
            row.find('.output-quantity-weight').val(quanity_weight.toFixed(2));
            summaryCalculation();
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
            let tableBody = $('#table tbody');

            let row = `
            <tr>
                <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>

                <td> 
                    <select  name="output_item_id[]" class="form-control select2 output-item-dropdown" >                                                
                        <option value="" >Choose...</option>
                        @foreach ($goodItems as $item)
                            <option value="{{$item->id}}" data-unit-id="{{ $item->unit_id }}"  data-unit-weight="{{ $item->unit_weight }}">{{ $item->code.'-'.$item->category->name .'-'.$item->name }}</option>
                        @endforeach

                    </select>

                </td> 
                <td> 
                    <select name="output_unit_id[]"  class="form-control select2 output-item-unit-dropdown" style="width:100%">                                                
                        <option>Choose...</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                        @endforeach
                    </select>

                </td> 

                <td>
                    <input type="number" step="0.0001" class="form-control output-unit-weight" readonly>  
                </td>
                <td>
                    <input type="number" name="output_quantity[]" step="0.0001" class="form-control output-quantity">  
                </td>
                <td>
                    <input type="number" name="output_quantity_weight[]" step="0.0001" class="form-control output-quantity-weight">  
                </td>
                <td class="text-center">  
                    <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                </td>
            </tr>
            `;
        
            tableBody.append(row);
            $('.select2', 'table').select2();

        }
    
        function summaryCalculation()
        {
            let output_sub_total_weight = 0;
            let production_sub_total_weight = 0;
            let wastage_quantity_weight = 0;
            
    
            $('.output-quantity-weight').each(function(){
                let item_quantity_weight = parseFloat($(this).val()) || 0;
                output_sub_total_weight+= item_quantity_weight;
            });
            $('#output-sub-total-weight').val(output_sub_total_weight.toFixed(2));
    
            
            $('.production-quantity-weight').each(function(){
                let production_quantity_weight = parseFloat($(this).val()) || 0;
                production_sub_total_weight+= production_quantity_weight;
            });
            $('#production-sub-total-weight').val(production_sub_total_weight.toFixed(2));
    
    
            // checkProductionOutputWeight(output_sub_total_weight, production_sub_total_weight);
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
