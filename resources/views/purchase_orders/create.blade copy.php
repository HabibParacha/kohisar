@extends('template.tmp')
@section('title', 'pagetitle')

@section('content')
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
                                        <input type="text" name="invoice_no" id="invoice_no" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Due Date</label>
                                        <input type="date" name="due_date" id="due_date" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Reference No</label>
                                        <input type="text" name="reference_no" id="reference_no" class="form-control">
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
                                <table id="table" class="table" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">#</th> 
                                            <th style="width:15%;" >Item</th> 
                                            <th style="width:10%" >Unit</th>
                                            <th style="width:10%" >Unit Quantity</th>
                                            <th style="width:10%" >Quantity</th>
                                            <th style="width:10%" >Unit Price</th>
                                            <th style="width:10%" >QTY * Price</th>

                                            <th style="width:10%" >Discount</th>
                                            <th style="width:10%" >Sub Total</th>
                                            <th style="width:10%" >Tax</th>
                                            <th style="width:10%" >Tax Value</th>
                                            <th style="width:10%" >Total</th>
                                          
                                            <th></th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td> 
                                                <select name="item_id[]" id="item_id_1" class="form-control select2 item-dropdown" style="width:100%">                                                
                                                    <option>Choose...</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{$item->id}}"  data-unit-id="{{ $item->unit_id }}"  >{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>












                                            <td> 
                                                <select name="unit_id[]"  class="form-control select2" style="width:100%">                                                
                                                    <option>Choose...</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{$unit->id}}">{{ $unit->base_unit }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td> <input type="text" name="quantity[]" class="form-control item-quantity">  </td>
                                            <td> <input type="text" name="" class="form-control">  </td>
                                            <td> <input type="text" name="" class="form-control">  </td>
                                            <td> <input type="text" name="" class="form-control">  </td>
                                            <td>
                                                <div class="d-flex">
                                                    <input type="text" name="discount_value[]" class="form-control ">
                                                    <select name="discount_type[]"  class="form-select">                                                
                                                        <option value="fixed">Fixed</option>
                                                        <option value="percentage">%</option>
                                                    </select>
                                                </div>    
                                            </td>
                                            <td> <input type="text" name="" class="form-control  ">  </td>

                                            <td> 
                                                <select name="tax_id[]"  class="form-control select2" style="width:100%">                                                
                                                    <option>No Tax</option>
                                                    @foreach ($taxes as $tax)
                                                        <option value="{{$tax->id}}">{{ $tax->rate }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td> <input type="text" name="" class="form-control  ">  </td>

                                            <td> <input type="text" name="item_total[]" class="form-control item-total">  </td>

                                            <td>  <a href=""><span class="bx bx-trash text-danger remove-item"></span></a> </td>
                                        </tr>
                                    </tbody> 
                                </table>

                                <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                            </div> 
                           

                            <div class="row">
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-4">
                                    <table class="table">
                                        <tr>
                                            <th>Item Total</th>
                                            <td>1000</td>
                                        </tr>
                                        <tr>
                                            <th>GST (18%)</th>
                                            <td>180</td>
                                        </tr>
                                       
                                        <tr>
                                            <th>Discount (10%)</th>
                                            <td>180</td>
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


    <script>    
        $('#btn-add-more').on('click', function(e){
            e.preventDefault();
            alert("YES");
            appendNewRow();
        });
        $('.remove-item').on('click', function(e){
            e.preventDefault();

            $(this).closest('tr').remove();
            alert("YES");
        });


        function appendNewRow(){
            let tableBody = $('#table tbody');

            let row = `
            <tr>
                <td>1</td>
                <td> <input type="text" name="" id="" value="" class="form-control">  </td>
                <td> <input type="text" name="" id="" value="" class="form-control">  </td>
                <td> <input type="text" name="" id="" value="" class="form-control">  </td>
                <td> <input type="text" name="" id="" value="" class="form-control">  </td>
                <td> <input type="text" name="" id="" value="" class="form-control">  </td>
                <td> <input type="text" name="" id="" value="" class="form-control">  </td>
                <td> <input type="text" name="" id="" value="" class="form-control">  </td>
                <td>  <a href=""><span class="bx bx-trash text-danger remove-item"></span></a> </td>
            </tr>
            `;
            tableBody.append(row);

        }


        function calculation()
        {

        }

        


    </script>
    

@endsection
