<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Extensive Book Accountancy Software" name="description" />
    <meta content="Extensive Books, UAE" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL('/')}}/assets/images/favicon.ico">
    <!-- Bootstrap Css -->
    <link href="{{URL('/')}}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{URL('/')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{URL('/')}}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{URL('/')}}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL('/')}}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{URL('/')}}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{URL('/')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{URL('/')}}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <link href="{{URL('/')}}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{URL('/')}}/assets/libs/chenfengyuan/datepicker/datepicker.min.css">

    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/assets/libs/toastr/build/toastr.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    {{-- sortable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">


    
     <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> -->
    <!-- Responsive datatable examples -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->

    <!-- my own model -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Are you sure to delete this information ?</p>
                    <p class="text-center">
                        <a href="#" class="btn btn-danger " id="delete_link">Delete</a>
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button>
                    </p>
                </div>

            </div>
        </div>
    </div>
    <!-- end of my own model -->
<style>
    tbody, td, tfoot, th, thead, tr {
 
    vertical-align: middle !important;
}


</style>

<style>
  .datepicker {
  z-index:1001 !important;
}
</style>


<style>
 

.select2-container .select2-selection--single {
    background-color: #fff;
    border: 1px solid #ced4da;
    height: 38px
}
.select2-container .select2-selection--single:focus {
    outline: 0;
    border: 1px solid rgb(64, 148, 218);

}
.select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: .75rem;
    color: #495057
}
.select2-container .select2-selection--single .select2-selection__arrow {
    height: 34px;
    width: 34px;
    right: 3px
}
.select2-container .select2-selection--single .select2-selection__arrow b {
    border-color: #adb5bd transparent transparent transparent;
    border-width: 6px 6px 0 6px
}
.select2-container .select2-selection--single .select2-selection__placeholder {
    color: #495057
}
.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #adb5bd transparent!important;
    border-width: 0 6px 6px 6px!important
}
.select2-container--default .select2-search--dropdown {
    /*padding: 10px;*/
    background-color: #fff
}
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da;
    background-color: #fff;
    color: #74788d;
    outline: 0
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #556ee6
}
.select2-container--default .select2-results__option[aria-selected=true] {
    /*background-color: #f8f9fa;*/
    /*color: #343a40*/
}
.select2-container--default .select2-results__option[aria-selected=true]:hover {
    background-color: #556ee6;
    color: #fff
}
.select2-results__option {
    padding: 6px 12px
}
.select2-container[dir=rtl] .select2-selection--single .select2-selection__rendered {
    padding-left: .75rem
}
.select2-dropdown {
    border: 1px solid rgba(0, 0, 0, .15);
    background-color: #fff;
    -webkit-box-shadow: 0 .75rem 1.5rem rgba(18, 38, 63, .03);
    box-shadow: 0 .75rem 1.5rem rgba(18, 38, 63, .03)
}
.select2-search input {
    border: 1px solid #f6f6f6
}
.select2-container .select2-selection--multiple {
    min-height: 38px;
    background-color: #fff;
    border: 1px solid #ced4da!important
}
.select2-container .select2-selection--multiple .select2-selection__rendered {
    padding: 2px .75rem
}
.select2-container .select2-selection--multiple .select2-search__field {
    border: 0;
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field::-webkit-input-placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field::-moz-placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field:-ms-input-placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field::-ms-input-placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field::placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-selection__choice {
    background-color: #eff2f7;
    border: 1px solid #f6f6f6;
    border-radius: 1px;
    padding: 0 7px
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #ced4da
}
.select2-container--default .select2-results__group {
    font-weight: 600
}
.select2-result-repository__avatar {
    float: left;
    width: 60px;
    margin-right: 10px
}
.select2-result-repository__avatar img {
    width: 100%;
    height: auto;
    border-radius: 2px
}
.select2-result-repository__statistics {
    margin-top: 7px
}
.select2-result-repository__forks, .select2-result-repository__stargazers, .select2-result-repository__watchers {
    display: inline-block;
    font-size: 11px;
    margin-right: 1em;
    color: #adb5bd
}
.select2-result-repository__forks .fa, .select2-result-repository__stargazers .fa, .select2-result-repository__watchers .fa {
    margin-right: 4px
}
.select2-result-repository__forks .fa.fa-flash::before, .select2-result-repository__stargazers .fa.fa-flash::before, .select2-result-repository__watchers .fa.fa-flash::before {
    content: "\f0e7";
    font-family: 'Font Awesome 5 Free'
}
.select2-results__option--highlighted .select2-result-repository__forks, .select2-results__option--highlighted .select2-result-repository__stargazers, .select2-results__option--highlighted .select2-result-repository__watchers {
    color: rgba(255, 255, 255, .8)
}
.select2-result-repository__meta {
    overflow: hidden
}



/* remove input type number arrow up and down */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number]{
    -moz-appearance: textfield;
}
</style>

</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <!-- start of header -->
        @include('template.header')
        <!-- end of header -->
        
        {{-- @include('template.sidebar') --}}
        <!-- ========== Left Sidebar Start ========== -->
        @if(Auth::user()->type == "admin")    
        @include('template.sidebars.admin')

        @else
        @include('template.sidebars.saleman')

        @endif

      
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
      
        
        @yield('content')
    
        
        
        <!-- END layout-wrapper -->
       
        

                                            
        <div id="appModal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appModalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="appModalDescription"></p>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

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

        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script>
            // Create an instance of Notyf
            let notyf = new Notyf({
                duration: 3000,
                position: {
                    x: 'right',
                    y: 'top',
                },
            });
        </script>
        @if(Session::get('success'))
            <script>
                notyf.error("Your Are Not Authorized Please Contact Admin");
            </script>
        @endif

{{-- <script>
    // Set up inactivity timer (15 minutes = 900,000 ms)
    let inactivityTimer;
    const INACTIVITY_TIME = 12000; // 15 minutes
    const sessionWarningTime = INACTIVITY_TIME - 10000; // Show modal 10 seconds before timeout

    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        inactivityTimer = setTimeout(showInactivityModal, sessionWarningTime);
    }

    function showInactivityModal() {
        // Show modal after 15 minutes of inactivity
        $('#inactivityModal').modal('show');
    }

    // Event listeners to detect user activity
    $(document).on('mousemove keypress', function () {
        resetInactivityTimer();
    });

    // Handle Stay Live button click
    $('#stayAliveButton').click(function () {
        $.ajax({
            url: '/refresh-session',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                // Reload the page or just close the modal
                $('#inactivityModal').modal('hide');
                resetInactivityTimer();
            },
            error: function () {
                alert('Error refreshing session');
            }
        });
    });

    // Handle Logout button click
    $('#logoutButton').click(function () {
        window.location.href = '/logout';
    });

    // Initialize inactivity timer on page load
    $(document).ready(function () {
        resetInactivityTimer();
    });
</script> --}}
        
        <script>
            




            function globleDelete(id) {
                alert("yes");
                // $('#submit-model-destroy').data('id', id);
                $('#delete-model').modal('show');
            }
               
            

        </script>

        <!-- JAVASCRIPT -->
        <!--  <script src="{{URL('/')}}/assets/libs/jquery/jquery.min.js"></script> -->
        <script src="{{URL('/')}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/node-waves/waves.min.js"></script>
        <!-- apexcharts -->
        {{-- <script src="{{URL('/')}}/assets/libs/apexcharts/apexcharts.min.js"></script> --}}
        <!-- dashboard init -->
        {{-- <script src="{{URL('/')}}/assets/js/pages/dashboard.init.js"></script> --}}
        <!-- form mask init -->
        {{-- <script src="{{URL('/')}}/assets/js/pages/form-mask.init.js"></script> --}}
        <!-- App js -->
        <script src="{{URL('/')}}/assets/js/app.js"></script>
        <!-- form mask -->
        {{-- <script src="{{URL('/')}}/assets/libs/inputmask/min/jquery.inputmask.bundle.min.js"></script> --}}
        <!-- form mask init -->
        <!-- Required datatable js -->
        <script src="{{URL('/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/jszip/jszip.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        <!-- Responsive examples -->
        <script src="{{URL('/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="{{URL('/')}}/assets/js/pages/datatables.init.js"></script>

        <!-- apexcharts -->
        {{-- <script src="{{URL('/')}}/assets/libs/apexcharts/apexcharts.min.js"></script> --}}

        {{-- <script src="{{URL('/')}}/assets/js/pages/profile.init.js"></script> --}}
        <script src="{{URL('/')}}/assets/libs/select2/js/select2.min.js"></script>

        <!-- init js -->
        <script src="{{URL('/')}}/assets/js/pages/ecommerce-select2.init.js"></script>

        <!-- Sweet Alerts js -->
        <script src="{{URL('/')}}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

        <!-- Sweet alert init js-->
        <script src="{{URL('/')}}/assets/js/pages/sweet-alerts.init.js"></script>

        <!-- form repeater js -->
        <script src="{{URL('/')}}/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

        <script src="{{URL('/')}}/assets/js/pages/form-repeater.int.js"></script>


        <script src="{{URL('/')}}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/chenfengyuan/datepicker/datepicker.min.js"></script>
  
        {{-- sortable --}}
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 
        <!-- toastr plugin -->
        <script src="{{URL('/')}}/assets/libs/toastr/build/toastr.min.js"></script>
        <!-- toastr init -->
        <script src="{{URL('/')}}/assets/js/pages/toastr.init.js"></script>
        <script type="text/javascript">
            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

           

            // function delete_confirm2(url, id) { 
            //     url = '{{URL::TO('/')}}/'+url+'/'+ id';
            //     jQuery('#staticBackdrop').modal('show', {
            //         backdrop: 'static'
            //     });
            //     document.getElementById('delete_link').setAttribute('href', url);

            // }



            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });


            $("#success-alert").fadeTo(4000, 500).slideUp(100, function() {
                $("#success-alert").slideUp(500);
                $("#success-alert").alert('close');
            });
        </script>

      

 








</body>


 
</html>