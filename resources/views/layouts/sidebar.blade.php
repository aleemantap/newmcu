<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="/home"><img src={{ asset("assets/images/icon/logo2.png") }} alt="logo"></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu"> 
                    @if(!Auth::guest())
                        @each('layouts.menu', session()->get('menus'), 'menu')    
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>