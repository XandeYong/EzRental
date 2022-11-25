

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Home</title>
    @include('base/head')
    <link rel="stylesheet" href="{{asset('css/index.css')}}" />
    <link rel="stylesheet" href="{{asset('css/sidenav.css')}}" />
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid pt-5 pt-sm-4">
            @include('base/navbar')

            <div class="row background-image-1">
                <div class="container mt-5 mt-sm-5">

                    <div class="row">
                        <div class="col">
                            
                            <div class="welcome w-25 py-1 py-sm-2 py-md-3">
                                <h2 class="c-white text-center">Welcome to EzRental</h2>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>

            {{-- login success message --}}
            @if(session()->has('access_message'))
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            <div id="login_message" class="message-popup">
                                <div class="alert alert-danger alert-dismissible mx-auto" role="alert">
                                    {{ session()->get('access_message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php session()->forget('access_message') @endphp
            @endif

        </div>
    </div>

    @include('base/footer')
    @include('base/script')
    <script src="{{ asset('vendor/xande/scripting.js') }}"></script>

</body>
</html>