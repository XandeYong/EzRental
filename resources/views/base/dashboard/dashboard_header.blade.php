<div id="header" class="row">
    <div id="header-1" class="d-flex">
        <div id="header-section-1" class="col d-flex justify-content-start align-items-center ">
            <div id="menu" class="">
                <a href="#">
                    <i class="ico ico-menu"></i>
                </a>
            </div>
        </div>
        <div id="header-section-2" class="col d-flex justify-content-end align-items-center">
            <div id="account">
                <div id="account-icon">
                    <a id="account-frame" href="#" class="" >
                        <img class="unselectable" src="{{ asset("/image/account/profile.png") }}" alt="img">
                    </a>

                    <div id="account-dropdown" class="hide">
                        <div id="account-dropdown-box">
                            <div id="account-header" class="account-box">
                                <h6 id="account-name">{{ session()->get('account')['name']; }}</h6>
                            </div>
                            <div id="account-body" class="account-box">
                                <a href="/">
                                    <div id="back_to_main" class="account-item">
                                        <h6><i class="ico ico-gear"></i>Back to Main Page</h6>
                                    </div>
                                </a>
                                
                                <a href="{{ url("/logout") }}">
                                    <div id="account-logout" class="account-item">
                                        <h6><i class="ico ico-power"></i>Logout</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($header))

    <div id="header-2" class="d-flex">
        
        @if (isset($back))
        <div id="header-back" class="position-absolute">
            <h4 class="m-0 border-right-2">
                <a class="text-decoration-none" href="{{ url()->previous() }}">
                    <i class="ico-sm ico-chevron-left"></i>
                </a>
            </h4>
        </div>
        @endif

        <div id="header-title" class="mx-auto">
            <h4 class="m-0">{{ $header }}</h4>
        </div>
    </div>

    @endif

</div>