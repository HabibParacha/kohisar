@extends('template.tmp')
@section('title', 'pagetitle')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                
                <form>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Tax</h4>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tax</label>
                                            <select id="tax_id" name="tax_id"  class="select2 form-select">                                                <option selected="">Choose...</option>
                                                @foreach ($taxes as $tax)
                                                    <option data-rate="{{ $tax->rate }}" value="{{$tax->id}}">{{ $tax->rate}}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select id="tax-type" name="tax_type"  class="select2 form-select">
                                                <option selected="">Choose...</option>
                                                <option data-type="exclusive" value="exclusive">Exclusive</option>
                                                <option data-type="inclusive" value="inclusive">Inclusive</option>                                            </select>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>    

                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Pricing & Stocks</h4>

                                <div class="d-flex">
                                    <div class="form-check mb-3">
                                        <label class="form-check-label">Single Product</label>
                                        <input class="form-check-input" type="radio" name="product_type" id="single-product-radio">
                                    </div>
                                    <div class="form-check mb-3 mx-3">
                                        <label class="form-check-label">Varibale Product</label>
                                        <input class="form-check-input" type="radio"  name="product_type" id="variable-product-radio" >
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <select class="form-select d-none" id="varient_id">                                            <option selected="">Choose...</option>
                                            <option selected value="choose">choose</option>
                                            @foreach ($variation as $varient)
                                                <option data-id="{{ $varient->id }}" data-values="{{ $varient->values }}" value="{{ $varient->id }}">{{ $varient->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>                                        
                                </div>


                                <div class="table-responsive">
                                    <table class="table" id="variant-table">
                                        <thead>
                                            <!-- Table Header Row 1 -->
                                            <tr class="border">
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="2" class="text-center border">Default Purchase Price</th>
                                                <th></th>
                                                <th class="text-center border">Selling Price</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                
                                               
                                            </tr>
                                            <!-- Table Header Row 2 -->
                                            <tr class="border">
                                                <th class="text-center border d-none">Value</th>
                                                <th class="text-center border">SKU</th>
                                                <th class="text-center border">barcode</th>
                                                <th class="text-center border">Exc Tax</th> 
                                                <th class="text-center border">inc Tax</th>
                                                <th class="text-center border">Margin %</th>
                                                <th class="text-center border"></th>
                                                <th class="text-center border">Low Stock Alert</th>
                                                <th class="text-center border">Prepration Time</th>
                                                <th class="text-center border">Weight</th>
                                                <th class="text-center border">Image</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows based on selected radio -->
                                            
                                        </tbody>
                                    </table>
                                    
                                </div>




                            </div>    

                        </div>
                    </div>
                </form>
            </div>
         </div>
    </div>
    <script>
            $(document).ready(function() {
                // Event listener for single product radio button
                

                $('#single-product-radio').on('click', function() {
                    if ($(this).prop('checked')) {


                        $('#varient_id').addClass('d-none');// hide Variant Attribute
                        $('#varient-select').val('choose');// reset the value to choose
                        
                        appendRowsToTableVariant(['singleProduct']);
                        
                        // Hide the first column
                        setColumnVisibility('#variant-table', 'first', 'hide');
                        // Hide the last column
                        setColumnVisibility('#variant-table', 'last', 'hide');
                        

                    }
                });



                // Event listener for variable product radio button
                $('#variable-product-radio').on('click', function() {
                    if ($(this).prop('checked')) {

                        $('#varient_id').removeClass('d-none');// hide Variant Attribute

                        // show the first column
                        setColumnVisibility('#variant-table', 'first', 'show');
                        // show the last column
                        setColumnVisibility('#variant-table', 'last', 'show');
                    }
                });

                $('#single-product-radio').click();//firing an event when page all functions are loaded

            });


    </script>

    <script>
        function appendRowsToTableVariant(values) {

            // Get the table body element
            var tableBody = $('#variant-table tbody');

            // Clear existing rows (if needed)
            tableBody.empty();

            // Loop through the values and append them to the table
            values.forEach(function(value, index) {
                var row = `
                    <tr>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-variation-name"  name="variation_name[]" value="${value}">
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-SKU" name="SKU[]">
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-barcode"  name="barcode[]">
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-purchase-excl-tax" name="purchase_excl_tax[]">
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-purchase-incl-tax" name="purchase_incl_tax[]" readonly>
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-profit-margin"  name="profit_margin[]">
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-selling-price"  name="selling_price[]" readonly>
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-low-stock-alert"  name="low_stock_alert[]">
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-time"  name="preparation_time[]">
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="text" class="form-control variant-weight"  name="product_weight[]">
                            </div>
                        </td>
                        <td class="border">
                            <div class="add-product">
                                <input type="file" class="form-control variant-image"  name="image[]" id="images">
                            </div>
                        </td>
                        <td class="border">
                            <button type="button" class="btn btn-danger delete-row">Delete</button>
                        </td>
                    </tr>
                `;

                // Append the row to the table body
                tableBody.append(row);
            });
        }

        // Assuming you are appending the rows to a tbody with an id of "variant-table"
        $('#variant-table').on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
        });

        //variant Dropdown
        $('#varient_id').change(function() {
            var values = $(this).find(':selected').data('values');// selected variation attribute, data-values store
        
            appendRowsToTableVariant(values);// calling function to append the rows in #variant-table

        });

        function setColumnVisibility(tableId, column, action) {
            // Check if the action is to hide or show columns
            var className = (action === 'hide') ? 'd-none' : '';

            // Apply the action to the specified column (first or last)
            $(tableId + ' tr').each(function() {
                if (column === 'first') {
                    $(this).find('td:first, th:first').removeClass('d-none').addClass(className);
                } else if (column === 'last') {
                    $(this).find('td:last, th:last').removeClass('d-none').addClass(className);
                }
            });
        }

    </script>

    <script>
          function calculateTax(row) {
            var selectedTaxRate = $('#tax_id').find('option:selected').data('rate');

            alert(selectedTaxRate);
            
            var selectedTaxType = $('#tax-type').find('option:selected').data('type');

            
            //purchase exclusive tax
            var purchase_excl_tax = parseFloat(row.find('.variant-purchase-excl-tax').val()) || 0;

            //set value of purchase excl tax = price
            // var purchaseExclTaxValue = price;

                //purchase inclusive tax  
            var purchase_incl_tax = purchase_excl_tax * (1 + selectedTaxRate / 100);

            var margin = parseFloat(row.find('.variant-profit-margin').val()) || 0;
            
            
            var sale_excl_tax = purchase_excl_tax * (1 + margin / 100);
            
            var sale_incl_tax = purchase_incl_tax * (1 + margin / 100);
            

            if(selectedTaxType == "exclusive"){
                
                row.find('.variant-purchase-incl-tax').val(purchase_incl_tax.toFixed(2));
                row.find('.variant-selling-price').val(sale_excl_tax.toFixed(2));

                // var selling_price = margin * 

                
            }
            if(selectedTaxType == "inclusive"){
                
                row.find('.variant-purchase-incl-tax').val(purchase_incl_tax.toFixed(2));
                row.find('.variant-selling-price').val(sale_incl_tax.toFixed(2));
                
            }
            
        }

        
        // Event listener for tax-type change and #tax_id
        $('#tax-type, #tax_id').on('change', function() {
            
            $('#variant-table tbody tr').each(function() {
                var row = $(this);
                calculateTax(row);
            });
        });
        
        // Event listeners to trigger calculation on value or qty change
        $(document).on('input', '.variant-purchase-excl-tax, .variant-profit-margin', function() {
            var row = $(this).closest('tr');
            calculateTax(row);
        });


      
    </script>


@endsection
