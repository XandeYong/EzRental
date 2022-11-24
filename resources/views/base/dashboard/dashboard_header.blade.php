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
                        <img class="unselectable" src="{{ asset("/image/account/" . session()->get('account')['image']) }}" alt="img">
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

    <div id="header-2" class="row align-items-center justify-content-center">
        
        <div id="header-back" class="col-1 col-sm-3 text-start ps-4 ps-sm-2">
        @if (isset($back))
            <div class="d-flex">
                <h4 class="m-0 border-right-2">
                    <a class="text-decoration-none" href="{{ $back }}" title="Back to previous page">
                        <i class="ico-sm ico-chevron-left"></i>
                    </a>
                </h4>
            </div>
        @endif
        </div>

        <div id="header-title" class="text-center mx-auto col-10 col-sm-6">
            <h4 class="m-0">{{ $header }}</h4>
        </div>

        <div id="header-button" class="text-end col-1 col-sm-3">
        @if (isset($button))
            @php
                $href = "href=" . $button['link'];
                if (isset($button['status']) && $button['status'] == "disabled") {
                    $href = "";
                } else {
                    $button['status'] = "";
                }
            @endphp

            <a {{ $href }}>
                <button class="btn btn-outline-primary d-none d-lg-inline-block" {{ $button['status'] }}>
                    {{ $button['name'] }}
                </button>
            </a>
        @endif
        </div>
    </div>

    @endif

</div>