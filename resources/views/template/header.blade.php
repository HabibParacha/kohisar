<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ URL('/dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL('/') }}/assets/images/square.svg" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL('/') }}/assets/images/square.svg" alt="" height="40">
                        {{ env('APP_NAME') }}
                    </span>
                </a>

                <a href="{{ URL('/Dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL('/') }}/assets/images/square.svg" alt="" height="40">
                    </span>
                    <span class="logo-lg ">
                        <h5 class="mt-4 text-white"> {{ env('APP_NAME') }}</h5>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search  d-none d-xl-block">
                <div class="position-relative">
                    <div class="d-flex gap-2 flex-wrap">



                        <div class="btn-group">
                            <button type="button" class="  btn btn-outline-light dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false"><i class=" text-success far fa-bookmark
                                    font-size-16 align-middle me-2"></i>Favoriate
                                <i class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu" style="margin: 0px;">

                                <a class="dropdown-item" href="{{ route('sale-invoice.create') }}"><i class="bx bx-plus "></i>
                                    Sale Invoice</a>
                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item" href="{{ route('voucher.create') }}">
                                    <i class="bx bx-plus "></i> Voucher
                                </a>
                               
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{  route('voucher.createJournalVoucher') }}">
                                    <i class="bx bx-plus "></i> Journal Voucher
                                </a>




                            </div>
                        </div><!-- /btn-group -->


                        <div class="btn-group">
                            <button type="button" class="  btn btn-outline-light dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">Party Reports <i
                                    class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu" style="margin: 0px;">

                            </div>
                        </div><!-- /btn-group -->

                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-light dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">Inventory Reports <i
                                    class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('report.fetchRawMaterailStock') }}">Raw Material</a>
                                <a class="dropdown-item" href="{{ route('report.fetchFinishedGoodsStock') }}">Finshed Good Stock</a>
                                <a class="dropdown-item" href="{{ route('report.production.request') }}">Production Report</a>
                                <a class="dropdown-item" href="{{ route('report.raw-material-history.request') }}">Raw Material History</a>
                                <a class="dropdown-item" href="{{ route('report.material-received-history.request') }}">Material Received History</a>
                                <a class="dropdown-item" href="{{ route('report.raw-material-stock-level.request') }}">Material Stock Level</a>

                            </div>
                        </div><!-- /btn-group -->
                      



                        <div class="btn-group">
                            <a href="{{ route('account-reports.request') }}"  class="btn btn-outline-light"
                               >Accounts Reports</a>
                            <div class="dropdown-menu">

                               
                                <a class="dropdown-item  " >Vochers</a>
                                {{-- <a class="dropdown-item" href="">Cash Book</a> --}}
                                <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item" href="{{ route('account-reports.daybook') }}">Day book</a> --}}
                                {{-- <a class="dropdown-item" href="">General Ledger</a>
                                <a class="dropdown-item" href="">Trial Balance</a>
                                <a class="dropdown-item" href="">Trial with
                                    acitivity</a>
                                <a class="dropdown-item" href="">Profit & Loss</a>
                                <a class="dropdown-item" href="">Balance Sheet</a>
                                <a class="dropdown-item" href="">Party Balances</a>
                             
                                <a class="dropdown-item" href="">Bank Reconciliation</a>
                                <a class="dropdown-item" href="">Tax Report</a>
                                <a class="dropdown-item" href="">Invoice Summary List</a>
                                <a class="dropdown-item" href="">Invoice Detail</a>
                                <a class="dropdown-item" href="">Payment Summary</a>
                                <a class="dropdown-item" href="">Expense Report</a> --}}

                            </div>
                        </div><!-- /btn-group -->

                    </div>
                </div>
            </form>


        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{ URL('/') }}/assets/images/users/avatar-1.jpg" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 " key="t-henry">Setting</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="">
                        <i class="bx bx-user font-size-16 align-middle me-1"></i>
                        <span key="t-profile">Profile</span></a>


                    <a class="dropdown-item d-block" href=""><i class="bx bx-wrench font-size-16 align-middle me-1"></i>
                        <span key="t-settings">Change
                            Password</span></a>



                    <div class="dropdown-divider"></div>
                   <form action="{{ route("logout") }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger"><i
                        class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                        key="t-logout">Logout</span></button>
                   </form>
                </div>
            </div>



        </div>
    </div>
</header>