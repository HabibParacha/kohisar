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

                                <a class="dropdown-item" href="{{ URL('/InvoiceCreate') }}"><i class="bx bx-plus "></i>
                                    Invoice</a>
                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item" href="{{ route('voucher.create','BP') }}">
                                    <i class="bx bx-plus "></i> BP-Bank Payment
                                </a>
                                <a class="dropdown-item" href="{{  route('voucher.create','BR') }}">
                                    <i class="bx bx-plus "></i> BR-Bank Receipt
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{  route('voucher.create','CP') }}">
                                    <i class="bx bx-plus "></i> CP-Cash Payment
                                </a>
                                <a class="dropdown-item" href="{{ route('voucher.create','CR') }}">
                                    <i class="bx bx-plus "></i> CR-Cash Receipt
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{  route('voucher.create','JV') }}">
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

                            </div>
                        </div><!-- /btn-group -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-light dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">Accounts Reports <i
                                    class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu">

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
                    <a class="dropdown-item text-danger" href=""><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                            key="t-logout">Logout</span></a>
                </div>
            </div>



        </div>
    </div>
</header>