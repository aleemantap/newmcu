        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box pull-left">
                            {{-- <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form> --}}
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                             <li class="dropdown">
                                <i class="ti-user dropdown-toggle" data-toggle="dropdown">
                                </i>
                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <div class="notify-name">{{session()->get('user.name')}}</div>
                                    <div class="notify-title">You are {{session()->get('user.userGroup.name')}}</div>
                                    <ul class="nav navbar">
                                        <li><a href=""><i class="fa fa-fw fa-user"></i> Update Profile</a></li>
                                        <li><a href=""><i class="fa fa-fw fa-key"></i> Change Password</a></li>
                                        <li><a href=""><i class="fa fa-fw fa-gear"></i> Setting</a></li>
                                        <li>
                                            <a id="log-out-c"  href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa fa-fw fa-lock"></i>Logout</a>
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                   
                                </div>
                            </li>
                           
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">@yield('title')</h4>
                           
                            @yield('ribbon')
                        </div>
                    </div>
                    <div class="col-sm-4 clearfix">
                        <div class="user-profile pull-right">
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
               @yield('content')
            </div>
        </div>
        <!-- main content area end -->
        
<!-- MODAL -->
@yield('modal')
<!-- END MODAL -->