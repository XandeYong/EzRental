<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Login Portal</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    @include('base/head')
    <link rel="stylesheet" href="{{asset("/css/login.css")}}">
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid pt-5">
            @include('base/navbar')

            <div id="content" class="">
                <div class="container mt-4 mb-5 mt-sm-5">

                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-6 col-md-4 mt-3 mt-sm-0">
                            <div class="login_button">
                                <a href="{{route('login.tenant')}}" class="no-deco c-white hover-c-white">
                                    <button class="btn w3-ripple w3-teal h-100 w-100 fs-30px">Login As Tenant</button>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 mt-3 mt-sm-0">
                            <div class="login_button">
                                <a href="{{route('login.owner')}}" class="no-deco c-white hover-c-white">
                                    <button class="btn w3-ripple w3-deep-purple h-100 w-100 fs-30px">Login As Owner</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 justify-content-center">
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="login_button admin">
                                <a href="{{route('login.admin')}}" class="no-deco c-white hover-c-white">
                                    <button class="btn w3-ripple w3-blue h-100 w-100 fs-30px">Login As Admin</button>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @include('base/footer')
    @include('base/script')

</body>
</html>