<div id="sidebar">
    <div class="container-fluid">
        <div id="sidebar-title" class="row">
            <a href="{{ route("dashboard") }}" class="text-decoration-none">
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
                @php $role = session()->get('account')['role']; @endphp
                @if ($role == "T")
                    @include("dashboard/tenant/dashboard_sidenav")
                    
                @elseif ($role == "O")
                    @include("dashboard/owner/dashboard_sidenav")

                @elseif ($role == "A" || $role == "MA")
                    @include("dashboard/admin/dashboard_sidenav")

                @endif

            </div>
        </div>
    </div>
</div>

<div class="hide_sidebar"></div>