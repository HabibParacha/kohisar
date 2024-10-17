@extends('template.tmp')
@section('title', 'kohisar')


@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                
                <form>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                    <h4 class="card-title mb-4">Item Information</h4>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label  class="form-label">Item Name</label>
                                            <input name="name" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label  class="form-label">Item Code</label>
                                            <input name="code" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Types</label>
                                            <select name="type"  class="select2 form-select" >
                                                <option selected="">Choose...</option>
                                                @foreach ($itemTypes as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                            
                                    </div>
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label  class="form-label">Low Stock Alert Qunatity</label>
                                            <input type="number" class="form-control">
                                        </div>
                                    </div>
                               

                                    <h4 class="card-title mb-2 mt-2">Tax & Pricing</h4>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Tax</label>
                                            <select id="tax-select" name="tax_id"  class="select2 form-select">                                                <option selected="">Choose...</option>
                                                @foreach ($taxes as $tax)
                                                    <option value="{{ $tax->id }}">{{ $tax->name."[".$tax->rate."]" }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select class="form-select select2">
                                                <option selected="">Choose...</option>
                                                <option data-type="exclusive" value="exclusive">Exclusive</option>
                                                <option data-type="inclusive" value="inclusive">Inclusive</option>                                            </select>
                                        </div>                                        
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label  class="form-label">Sell Price</label>
                                            <input name="sell_price"  type="number" class="form-control" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label  class="form-label">Purchase Price</label>
                                            <input name="purchase_price" type="number" class="form-control" step="0.01">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                      
                    </div>
                </form>
            </div>
         </div>
    </div>



@endsection
