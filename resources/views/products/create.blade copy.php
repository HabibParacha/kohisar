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
                                <h4 class="card-title mb-4">Product Information</h4>
                                {{-- <a type="button" data-bs-toggle="collapse" data-bs-target="#product-information" aria-expanded="true" aria-controls="product-information">
                                    <span class="fa fa-close"></span>
                                </a> --}}
                                
                                <div id="product-information">
        
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label  class="form-label">Product Name</label>
                                                <input name="name" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Category</label>
                                                <select id="category_id" name="category_id"  class="select2 form-select" >
                                                    <option selected="">Choose...</option>
                                                    @foreach ($categories as $category)
                                                        <option value="">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Brand</label>
                                                <select  id="brand_id" name="brand_id"  class="select2 form-select" >
                                                    <option selected="">Choose...</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Unit</label>
                                                <select name="unit_id"  class="select2 form-select" >
                                                    <option selected="">Choose...</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{$unit->id}}">{{ "Purchase: ".$unit->base_unit." | Sale: " .$unit->child_unit}}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Warehouse</label>
                                                <select name="warehouse_id"  class="select2 form-select" >
                                                    <option selected="">Choose...</option>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label  class="form-label">Low Stock Alert Qunatity</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">Description</label>
                                                <textarea name="" id="" cols="30" rows="10" class="form-control">
                                                </textarea>   
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            
                            
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Tax</h4>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tax</label>
                                            <select id="tax-select" name="tax_id"  class="select2 form-select">                                                <option selected="">Choose...</option>
                                                @foreach ($taxes as $tax)
                                                    <option value="{{ $tax->id }}">{{ $tax->name."[".$tax->rate."]" }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select class="form-select select2">
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




                        

                    }
                });



                // Event listener for variable product radio button
                $('#variable-product-radio').on('click', function() {
                    if ($(this).prop('checked')) {

                    }
                });
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
    </script>


@endsection
