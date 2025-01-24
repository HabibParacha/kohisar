@extends('template.tmp')

@section('title', 'Kohisar')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        <div class="card">
            <form action="{{ route('average-costing.itemHistoryShow') }}" method="POST" target="_blank">
                @csrf
                <div class="card-body">
                    <h4 class="card-title">Raw Material Received History</h4>

                    <div class="col-md-12">
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label >Date</label>
                                <input type="date" name="date"  id="date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                            </div>
                        
                           
                            <div class="form-group mt-2">
                                <label for="EndDate">Items</label>
                                <select id="item_id" name="item_id" class="select2 form-control" style="width: 100%">
                                    <option value="">Choose...</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button  class="btn btn-primary my-2" type="submit">Submit</button>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>        

@endsection