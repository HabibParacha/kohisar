<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    
                    <a href="{{ route('admin-dashboard') }}" class="waves-effect">
                   
                        <i class="
                        mdi mdi-speedometer-slow mb-0"></i>

                        <span key="t-dashboards">Admin Dashboard</span>
                    </a>

                </li>
         
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-cart-outline"></i>
                        <span key="t-ecommerce">CRM</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                      
                        <li> <a href="{{ route('user.index') }}" key="t-products">Users</a></li>
                        <li> <a href="{{ route('brand.index') }}" key="t-products">Brands</a></li>
                        <li> <a href="{{ route('category.index') }}" key="t-products">Categories</a></li>
                        <li> <a href="{{ route('tax.index') }}" key="t-products">Taxes</a></li>
                        <li> <a href="{{ route('warehouse.index') }}" key="t-products">Warehouses</a></li>
                        <li> <a href="{{ route('unit.index') }}" key="t-products">Units</a></li>
                        {{-- <li> <a href="{{ route('product.create') }}" key="t-products">Product Create</a></li> --}}
                        <li> <a href="{{ route('item.index') }}" key="t-products">Items</a></li>
                        <li> <a href="{{ route('party-index','supplier') }}" key="t-products">Supplier</a></li>
                        <li> <a href="{{ route('party-index','customer') }}" key="t-products">Customer</a></li>
                        <li> <a href="{{ route('purchase-order.index') }}" key="t-products">Purchase Order</a></li>
                    
                       


                    </ul>
                </li>
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-cart-outline"></i>
                        <span key="t-ecommerce">Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                    </ul>
                </li> --}}
           
              
           
             
                <li>
                    <a href="#" class="waves-effect" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off"></i>
                        <span key="t-calendar">Logout</span>
                    </a>
                </li>
                
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>