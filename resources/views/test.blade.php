@extends('template.tmp')
@section('title', 'kohisar')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                                
                <div class="card-body">
                    <h4 class="card-title mb-4">Invoice Details</h4>
                    <div class="table-responsive">
                        <table id="table" class="table table-border" style="border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <th  width="10" class="text-start" ></th>
                                    <th  width="200" class="text-start" >Item</th> 
                                    <th  width="50" class="text-center">Unit wgt.</th> 
                                    <th  width="50" class="text-center">Stock Bal.</th> 
                                    <th  width="50" class="text-center">Qty</th> 
                                    <th  width="100" class="text-center">Total  wgt.</th> 
                                    <th  width="50" class="text-center">Retail Price</th> 
                                    <th  width="100" class="text-center">Total Price  </th> 

                                    <th  width="50" class="text-center">Discount</th>
                                    <th  width="50" class="text-center">Discount Type</th>
                                    
                                    <th  width="50" class="text-center">Discount Unit Price </th>
                                    <th  width="100" class="text-center">Discount Amount</th>
                                    <th  width="100" class="text-center">Total After Discount</th>
                                    <th class="text-center" width="20"></th>
                                
                                </tr>
                            </thead>
                            <tbody id="sortable-table">
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
                                        <input type="number" name="after_discount_total_price[]" class=" text-end form-control item-after-discount" readonly>  
                                    </td>
                                    
                                    
                                    
                                    <td class="text-center">  
                                        <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                                    </td>
                                </tr>
                                
                            
                            </tbody> 
                         
                        </table>

                        <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                    </div> 
                

                

                </div>

            </div>
        </div>
    </div>
</div>
@endsection