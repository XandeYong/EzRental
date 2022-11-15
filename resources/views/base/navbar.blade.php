<div id="navbar" class="row fixed-top">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <div class="row w-100 align-items-center">

                <div id="nav-title" class="col-12 col-sm-5 col-md-6">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <h3 class="d-flex">
                            <span>EzRental</span>
                        </h3>
                    </a>
                </div>
                
                <div id="nav-item" class="col-12 col-sm-7 col-md-6">
                    <ul class="nav-item nav-link justify-content-center justify-content-sm-center">
                        <li class="px-2">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="px-2">

                            @if (session()->has('account') && session()->get('account')['role'] == 'T')
                            <a href="{{ route('rental_post_list.recommend') }}">Rental Post</a>    
                            @else
                            <a href="{{ route('rental_post_list') }}">Rental Post</a>
                            @endif
                            
                        </li>
                        <li class="px-2">
                            <a href="{{ route('chat') }}">Chat</a>
                        </li>

                        @if (!session()->has('account'))
                        <li class="px-2">
                            <a href="{{ route('login.portal') }}">Login</a>
                        </li>
                        @else
                        <li class="px-2">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="px-2">
                            <a href="{{ route('logout') }}">Logout</a>
                        </li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </nav>
</div>