<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    
                    <a href="{{ route('admin-dashboard') }}" class="waves-effect">
                        <i class=" mdi mdi-speedometer-slow mb-0"></i>
                        <span key="t-dashboards">Admin Dashboard</span>
                    </a>

                </li>
             
              
               
                <li>
                    <a href="{{route('sale-order.index')}}" class="waves-effect">
                        <i class=" bx bx-file mb-0"></i>
                        <span key="t-dashboards"> Sale Order</span>
                    </a>
                </li>
               
               
         
               
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