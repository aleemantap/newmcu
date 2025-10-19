 
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-9">
                        <div class="breadcrumbs-area clearfix" style="display : flex; justify-content: left; align-items:center;">
                            <h4 class="page-title pull-left">{{ $title_page_left }}</h4>
                            {{-- <ul class="breadcrumbs pull-left">
                                <li><a href="/">Home</a></li>
                                <li><span>{{ $title_page_right }}</span></li>
                            </ul> --}}
                            <!-- RIBBON -->
                            {{-- <div id="ribbon"> --}}
                                @yield('ribbon')
                            {{-- </div> --}}
                            <!-- END RIBBON -->
                        </div>
                    </div>
                    <div class="col-sm-3 clearfix">
                        <div class="user-profile pull-right">
                            {{-- <img class="avatar user-thumb" src="{{ asset('assets/images/author/avatar.png') }}" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">Kumkum Rai <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Message</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div> --}}
                            
                        </div> 
                    </div>
                </div>
            </div>
            