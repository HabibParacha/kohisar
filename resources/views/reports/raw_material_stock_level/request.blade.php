@extends('template.tmp')

@section('title', 'Kohisar')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        <div class="card">
            <form action="{{ route('report.raw-material-stock-level.show') }}" method="POST">
                @csrf
                <div class="card-body">
                    <h4 class="card-title">Raw Material Stock Level</h4>

                    <div class="col-md-12">
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label for="StartDate"> Date</label>
                                <input type="date" name="startDate"  id="StartDate" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                <div id="start"></div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="EndDate">End Date</label>
                                <input type="date" name="endDate" id="EndDate" value="{{ now()->format('Y-m-d') }}" class="form-control" required>
                                <div id="end"></div>
                            </div>  
                            <button class="btn btn-primary my-2" type="submit">Submit</button>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>        

@endsection