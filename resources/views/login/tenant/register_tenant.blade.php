<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Base</title>
    @include('base/head')
    <link rel="stylesheet" href="{{asset('/css/admin_login.css')}}">
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid">
            @include('base/navbar')

            <div id="content" class="">
                <div class="container mt-4">

                    <div class="row justify-content-center">
                        <div id="login-model" class="col-12 col-sm-6 col-md-6 col-lg-4">

                            <form action="./backend/login.php" method="post">
                                <div id="l-m-header" class="row">
                                    <div class="text-center">
                                        <h5>Register Tenant Account</h5>
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
                                        <input type="submit" name="login" value="Register">
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="row justify-content-center mt-5 text-center">
                        <h5>Already have an account? 
                            <a href="{{route('login.tenant')}}" class="btn btn-sm btn-outline-success">Login here</a>
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