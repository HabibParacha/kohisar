@extends('template.tmp')

@section('title', 'Kohisar')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        <div class="card">
            <form action="{{ route('report.material-received-history.show') }}" method="POST" target="_blank">
                @csrf
                <div class="card-body">
                    <h4 class="card-title">Raw Material Received History</h4>

                    <div class="col-md-12">
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label for="StartDate">Start Date</label>
                                <input type="date" name="startDate"  id="StartDate" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                <div id="start"></div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="EndDate">End Date</label>
                                <input type="date" name="endDate" id="EndDate" value="{{ now()->format('Y-m-d') }}" class="form-control" required>
                                <div id="end"></div>
                            </div>
                           
                            <div class="form-group mt-2">
                                <label for="EndDate">Suppliers</label>
                                <select id="supplier_id" name="supplier_id" class="select2 form-control" style="width: 100%">
                                    <option value="">Choose...</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->business_name }}</option>
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