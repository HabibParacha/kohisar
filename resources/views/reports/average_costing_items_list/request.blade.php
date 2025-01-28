@extends('template.tmp')

@section('title', 'Raw Material Average Price List')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        <div class="card">
            <form action="{{ route('average-costing.itemsListShow') }}" method="POST" target="_blank">
                @csrf
                <div class="card-body">
                    <h4 class="card-title">Raw Material Average Price List</h4>

                    <div class="col-md-12">
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label >Date</label>
                                <input type="date" name="date"  id="date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
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