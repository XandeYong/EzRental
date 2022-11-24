@php
    $email = "";
    $password = "";

    if ($user == "Tenant") {
        $email = "Kailey@gmail.com";
        $password = "Vruqm3C6j4";

    } else if ($user == "Owner") {
        $email = "tmoss2@gmail.com";
        $password = "ObJc0pVXUEIg";
        
    } else if ($user == "Admin") {
        $email = "pbrandt1@gmail.com";
        $password = "I0pVObJcKH";

    } else if ($user == "Master") {
        $email = "jonstrosin@gmail.com";
        $password = "KLEIgoXUKD";
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Login</title>
    @include('base/head')
    <link rel="stylesheet" href="{{asset('/css/login.css')}}">
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid pt-5">
            @include('base/navbar')

            <div id="content" class="">
                <div class="container mt-4">

                    @if(session()->has('error_msg'))
                    <div class="row justify-content-center">
                        <div id="error_msg" class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session()->get('error_msg') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        
                        @php session()->forget('error_msg') @endphp
                    </div>
                    @endif

                    <div class="row justify-content-center">
                        <div id="login-model" class="col-12 col-sm-6 col-md-6 col-lg-4">

                            <form action="{{ route('login.portal.login') }}" method="post">
                                @csrf
                                <div id="l-m-header" class="row">
                                    <div class="text-center">
                                        <h5>{{ $user }} Login</h5>
                                    </div>
                                </div>

                                <div id="l-m-body" class="row justify-content-center pt-4 pb-3">
                                    <div id="email-txt" class="col-10 mb-3">
                                        <input type="email" name="email" class="w-100" placeholder="E-mail" required value="{{ $email }}">
                                    </div>
                                    
                                    <div id="password-txt" class="col-10 mb-3">
                                        <input type="password" name="password" class="w-100" placeholder="Password" required value="{{ $password }}">
                                    </div>

                                    <input type="text" value="{{ $user }}" name="role" hidden required>

                                    <div id="login-btn" class="col-10 text-center">
                                        <input type="submit" name="login" value="Log In">
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    @if ($user != 'Admin')
                    <div class="row justify-content-center mt-5 text-center">
                        <h5>Don't have an account yet? 
                            <a href="{{route('register.' . strtolower($user))}}" class="btn btn-sm btn-outline-success">Register here</a>
                        </h5>
                    </div>
                    @endif

                    <div class="row justify-content-center mt-5 text-center">
                        <h5>Forget your password? 
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#forget_password_modal">Reset here</button>
                        </h5>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>

    <!-- Forget Password Modal -->
    <div class="modal modal-lg fade" id="forget_password_modal" tabindex="-1" aria-labelledby="forget password modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form class="x-form" action="{{ route('login.portal.forget_password') }}" method="POST"
                    x-alert="Please check your email for password reset link.">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Request a password reset</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="forget_email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="forget_email" id="forget_email" placeholder="Enter your email address here...">
                            @if ($errors->has('forget_email'))
                                <span class="c-red-error">*{{ $errors->first('forget_email') }}</span>
                            @endif
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button id="rent_submit" type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @include('base/footer')
    @include('base/script')


</body>
</html>