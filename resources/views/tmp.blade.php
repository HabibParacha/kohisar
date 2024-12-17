
<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesbrand.com/skote-django/layouts/form-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 16 May 2021 18:23:16 GMT -->
<head>

        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{asset('assets/libs/chenfengyuan/datepicker/datepicker.min.css')}}">

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>

<style>
    .main-content {

    overflow: visible;
}
</style>
    <body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
           
 <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <!-- start of header -->
            @include('template.header')
            <!-- end of header -->

            <!-- ========== Left Sidebar Start ========== -->
             @include('template.sidebar')
            <!-- Left Sidebar End -->
            

             @yield('content')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        
                       

                        

                       
                        

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <!-- Inactivity Modal -->
                    <div class="modal fade" id="inactivityModal" tabindex="-1" aria-labelledby="inactivityModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="inactivityModalLabel">Session Timeout Warning</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Your session is about to expire. Do you want to stay logged in or log out?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="stayAliveButton">Stay Live</button>
                                    <button type="button" class="btn btn-danger" id="logoutButton">Log Out</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Inactivity Modal -->


         <!-- start of footer -->
@include('template.footer')
<!-- end of footer -->
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
       

        <!-- form advanced init -->
        <script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>

        <script src="{{asset('assets/js/app.js')}}"></script>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.js"></script>
    

<script>
    $("#success-alert").fadeTo(4000, 500).slideUp(100, function(){
     $("#success-alert").slideUp(500);
    $("#success-alert").alert('close');
});
</script>

<script>
    $(document).ready(function() {
        const dateRangeDisplay = $('#selectedRange');
        const startDateInput = $('#StartDate');
        const endDateInput = $('#EndDate');

        // Function to display selected range
        function setDateRange(start, end) {
            dateRangeDisplay.text(`${start.format('YYYY-MM-DD')} to ${end.format('YYYY-MM-DD')}`);
            startDateInput.val(start.format('YYYY-MM-DD'));
            endDateInput.val(end.format('YYYY-MM-DD'));
        }

        // Handle predefined date ranges
        $('.dropdown-menu a').click(function() {
            let range = $(this).data('range');
            let start, end;

            switch (range) {
                case 'today':
                    start = end = moment();
                    break;
                case 'this_week':
                    start = moment().startOf('week');
                    end = moment().endOf('week');
                    break;
                case 'this_month':
                    start = moment().startOf('month');
                    end = moment().endOf('month');
                    break;
                case 'this_quarter':
                    start = moment().startOf('quarter');
                    end = moment().endOf('quarter');
                    break;
                case 'this_year':
                    start = moment().startOf('year');
                    end = moment().endOf('year');
                    break;
                case 'ytd':
                    start = moment().startOf('year');
                    end = moment();
                    break;
                case 'yesterday':
                    start = end = moment().subtract(1, 'days');
                    break;
                case 'previous_week':
                    start = moment().subtract(1, 'weeks').startOf('week');
                    end = moment().subtract(1, 'weeks').endOf('week');
                    break;
                case 'previous_month':
                    start = moment().subtract(1, 'months').startOf('month');
                    end = moment().subtract(1, 'months').endOf('month');
                    break;
                case 'previous_quarter':
                    start = moment().subtract(1, 'quarters').startOf('quarter');
                    end = moment().subtract(1, 'quarters').endOf('quarter');
                    break;
                case 'previous_year':
                    start = moment().subtract(1, 'years').startOf('year');
                    end = moment().subtract(1, 'years').endOf('year');
                    break;
                case 'custom':
                    $('#customDateRange').daterangepicker({
                        opens: 'right',
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    }, function(start, end) {
                        setDateRange(start, end);
                    });
                    return; // Exit here to prevent predefined ranges logic
            }

            setDateRange(start, end);
        });

        // Initialize custom range datepicker
        $('#customDateRange').daterangepicker({
            opens: 'right',
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

    });
</script>



    </body>


 </html>