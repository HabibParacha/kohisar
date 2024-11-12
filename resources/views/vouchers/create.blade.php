@extends('template.tmp')
@section('title', 'Kohisar')


@section('content')



<style type="text/css">
    .form-control {
        border-radius: 0 !important;


    }

    .select2 {
        border-radius: 0 !important;
        width: 100% !important;

    }


    .swal2-popup {
        font-size: 0.8rem;
        font-weight: inherit;
        color: #5E5873;
    }

    .select2-container--default .select2-search--dropdown {
        padding: 1px !important;
        background-color: #556ee6 !important;
    }
</style>



<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Voucher</h4>
                    <div class="page-title-right ">
                    </div>



                </div>
            </div>
            <form method="post" id="">

                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="row">

                            <!-- <img src="{{ asset('assets/images/logo/ft.png') }}" alt=""> -->

                            <div class="col-6">

                                <textarea name="narration_main" id="narration_main" cols="30" rows="7"
                                    class="form-control" placeholder="Narration"></textarea>
                                <div class="clearfix mt-1"></div>
                            </div>

                            <div class="col-6">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Invoice#</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="invoice_no" id="main_invoice" class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Voucher Type</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select id="voucher-type" class="form-control select2">
                                                    <option value="">Choose..</option>
                                                    @foreach ($voucher_types as $type)
                                                    <option value="{{ $type->code }}">
                                                        {{ $type->code . '-' . $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Account</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" name="" id="main_coa_id">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Date</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="date" name="date" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <hr class="invoice-spacing">


                        <div class='row'>
                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                <table id="table-voucher" style="border-collapse: collapse;" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr class="bg-light borde-1 border-light " style="height: 40px;">
                                            <th width="2%" class="p-1"><input id="check_all" type="checkbox"
                                                    style="margin-left: 13px;" /></th>
                                            <th width="10%">Account</th>
                                            <th width="12%">Customer</th>
                                            <th width="12%">Supplier</th>
                                            <th width="10%">Narration</th>


                                            <th width="5%">Invoice</th>
                                            <th width="5%">Ref No</th>
                                            <th width="5%">Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-light border-1 border-light">
                                            <td class=" bg-light border-1 border-light"><input class="case"
                                                    type="checkbox" style="margin-left: 15px;" />
                                            </td>
                                            <td>
                                                <select name="chart_of_account_id[]" class="form-control select2 account-dropdown">
                                                    <option value="">Select Account</option>
                                                    @foreach ($chart_of_accounts as $account )
                                                        <option value="{{ $account->account_code }}" data-account-code="{{ $account->account_code }}" >{{ $account->account_code.'-'.$account->account_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="customer_id[]" class="form-control select2 customer-dropdown">
                                                    <option value="">Select Account</option>
                                                    @foreach ($customers as $customer )
                                                        <option value="{{ $customer->id }}">{{ $customer->business_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="supplier_id[]" class="form-control select2 supplier-dropdown">
                                                    <option value="">Select Account</option>
                                                    @foreach ($suppliers as $supplier )
                                                        <option value="{{ $supplier->id }}">{{ $supplier->business_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                           
                                            <td>
                                                <input type="text" name="narration[]" class="form-control"
                                                    autocomplete="off">
                                            </td>


                                            <td>
                                                <input type="text" name="invoice_no[]" class=" form-control"
                                                    autocomplete="off">
                                            </td>
                                            <td>
                                                <input type="text" name="reference_no[]" class=" form-control"
                                                    autocomplete="off">
                                            </td>
                                            <td>
                                                <input type="number" name="amount[]" step="0.001" class=" form-control"
                                                    autocomplete="off">
                                            </td>

                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light border-1 border-light " style="height: 40px;">
                                            <th width="2%"> </th>
                                            <th width="10%"> </th>
                                            <th width="10%"> </th>
                                            <th width="12%"> </th>
                                            <th width="10%"> </th>


                                            <th width="5%"> </th>
                                            <th width="5%"> </th>
                                            <th width="5%"><input type="text" readonly="" class=" form-control "
                                                    id="sum_dr"> </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-1 mb-2" style="margin-left: 29px;">
                            <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                                <button class="btn btn-danger delete" type="button"><i
                                        class="bx bx-trash align-middle font-medium-3 me-25"></i>Delete</button>
                                <button id="btn-add-more" class="btn btn-success addmore" type="button"><i
                                        class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add
                                    More</button>
                            </div>
                            <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                                <div id="result"></div>
                            </div>
                            <br>

                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div>
                            <div class="mt-2"><button type="submit" id="submitBtn"
                                    class="btn btn-primary w-lg float-right">Save</button>

                                <a href="" class="btn btn-secondary w-lg float-right">Cancel</a>


                                <div class='d-none' id="resultdiv">
                                    <div class="well text-center">
                                        <h2>Last Voucher No: <span id="InvoiceMasterID" class="text-danger">
                                            </span> </h2>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </form>







        </div>
        <!-- card end -->
    </div>
</div>

<!-- END: Content-->
<script>

    $(document).on('select2:select', '#voucher-type', function(e){
        let code = $(this).val();
        getAccountsByCategory(code);
        
    });


    $(document).on('select2:select', '.customer-dropdown', function(e){
        // let code = $(this).val();
        let row = $(this).closest('tr');

        let code = 112100;
        row.find('.account-dropdown').val(code).trigger('change');
        
    });
    $(document).on('select2:select', '.supplier-dropdown', function(e){
        // let code = $(this).val();
        let row = $(this).closest('tr');

        let code = 211100;
        row.find('.account-dropdown').val(code).trigger('change');
        
    });

   $('#btn-add-more').on('click', function(e){
        e.preventDefault();

        appendNewRow();
       
    });




   function getAccountsByCategory(code) {
            

            // Make the AJAX GET request
            $.get("{{ route('chart-of-account.getByCategory', ':code') }}".replace(':code', code))
                .done(function(response) {
                    const $select = $('#main_coa_id');
                    $select.empty(); // Clear any existing options

                    $select.append(new Option('Choose...', ''));
                    response.forEach(account => {
                        $select.append(new Option(account.account_name, account.id));
                    });

                })
                .fail(function(xhr) {
                    // Display error message if available
                    const errorMessage = xhr.responseJSON ? xhr.responseJSON.message : xhr.responseText;
                    alert('Error fetching account options: ' + errorMessage);
                    
                    // Hide the progress bar in case of failure
                    $('#progressModal').modal('hide');
                });
        }


        function appendNewRow(){
        let tableBody = $('#table-voucher tbody');

        let row = `
            <tr class="bg-light border-1 border-light">
                <td class=" bg-light border-1 border-light"><input class="case"
                        type="checkbox" style="margin-left: 15px;" />
                </td>
                <td>
                    <select name="chart_of_account_id[]" class="form-control select2 account-dropdown">
                        <option value="">Select Account</option>
                        @foreach ($chart_of_accounts as $account )
                            <option value="{{ $account->account_code }}" data-account-code="{{ $account->account_code }}" >{{ $account->account_code.'-'.$account->account_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="customer_id[]" class="form-control select2 customer-dropdown">
                        <option value="">Select Account</option>
                        @foreach ($customers as $customer )
                            <option value="{{ $customer->id }}">{{ $customer->business_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="supplier_id[]" class="form-control select2 supplier-dropdown">
                        <option value="">Select Account</option>
                        @foreach ($suppliers as $supplier )
                            <option value="{{ $supplier->id }}">{{ $supplier->business_name }}</option>
                        @endforeach
                    </select>
                </td>

                
                <td>
                    <input type="text" name="narration[]" class="form-control"
                        autocomplete="off">
                </td>


                <td>
                    <input type="text" name="invoice_no[]" class=" form-control"
                        autocomplete="off">
                </td>
                <td>
                    <input type="text" name="reference_no[]" class=" form-control"
                        autocomplete="off">
                </td>
                <td>
                    <input type="number" name="amount[]" step="0.001" class=" form-control"
                        autocomplete="off">
                </td>

            </tr>
        `;
      
        tableBody.append(row);
        $('.select2', '#table-voucher').select2();

    }

</script>

@endsection