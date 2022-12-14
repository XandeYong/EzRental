
@if (isset($user))

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Login</title>
    @include('base/head')
    <link rel="stylesheet" href="{{asset('/css/admin_login.css')}}">
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid pt-5">
            @include('base/navbar')

            <div id="content" class="">
                <div class="container mt-4">

                    <div class="row justify-content-center">
                        <div id="login-model" class="col-12 col-sm-6 col-md-6 col-lg-4">

                            <form action="{{route('dashboard.' . strtolower($user))}}" method="get">
                                <div id="l-m-header" class="row">
                                    <div class="text-center">
                                        <h5>{{$user}} Login</h5>
                                    </div>
                                </div>

                                <div id="l-m-body" class="row justify-content-center pt-4 pb-3">
                                    <div id="email-txt" class="col-10 mb-3">
                                        <input type="text" name="username" class="w-100" placeholder="E-mail">
                                    </div>
                                    
                                    <div id="password-txt" class="col-10 mb-3">
                                        <input type="password" name="password" class="w-100" placeholder="Password">
                                    </div>

                                    <div id="login-btn" class="col-10 text-center">
                                        <input type="submit" name="login" value="Log In">
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="row justify-content-center mt-5 text-center">
                        <h5>Don't have an account yet? 
                            <a href="{{route('register.' . strtolower($user))}}" class="btn btn-sm btn-outline-success">Register here</a>
                        </h5>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>

    @include('base/footer')
    @include('base/script')

</body>
</html>

@else
    <script>window.location = "/";</script>
@endif