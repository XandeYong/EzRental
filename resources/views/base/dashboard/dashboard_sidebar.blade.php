<div id="sidebar">
    <div class="container-fluid">
        <div id="sidebar-title" class="row">
            <a href="{{ route("dashboard." . strtolower($user)) }}" class="text-decoration-none">
                <div id="sidebar-title-text" >
                    <h1 class="d-flex">
                        <span>Ez</span>
                        <span>Rental</span>
                    </h1>
                </div>
            </a>
        </div>
        
        <div id="navlist" class="row">
            <div id="nav-title" class="col-12">
                <h6>NAVIGATION</h6>
            </div>

            <div class="navlist-list col-12">

                {{-- Side Navigation Content --}}

                @if (strtolower($user) == "tenant")
                    @include("dashboard/tenant/dashboard_sidenav")
                    
                @elseif (strtolower($user) == "owner")
                    @include("dashboard/owner/dashboard_sidenav")

                @elseif (strtolower($user) == "admin")
                    @include("dashboard/admin/dashboard_sidenav")

                @endif

            </div>
        </div>
    </div>
</div>

<div class="hide_sidebar"></div>