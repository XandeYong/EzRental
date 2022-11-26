<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Reset Password</title>
    @include('base/head')
    <link rel="stylesheet" href="{{asset('/css/login.css')}}">
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid">
            @include('base/navbar')

            <div id="content" class="">
                <div class="container mt-4">

                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-8 col-lg-6">
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-heading">Take Attention!</h4>
                                <p>The access key to reset password has been removed, You will not be able to access this page with the same link again.</p>
                                <hr>
                                <p class="mb-0">If require to reset again please go throught the whole process again.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div id="login-model" class="col-12 col-sm-6 col-md-6 col-lg-4">

                            @php
                                $param = ['email' => $email, 'key' => session()->get('reset_password_key', '')];
                            @endphp

                            <form action="{{ route('reset_password.form.reset', $param) }}" method="post">
                                @csrf
                                <div id="l-m-header" class="row">
                                    <div class="text-center">
                                        <h5>Reset Password</h5>
                                    </div>
                                </div>

                                <div id="l-m-body" class="row justify-content-center pt-4 pb-3">

                                    <div id="password-txt" class="col-10 mb-3">
                                        <input type="password" name="password" class="w-100" placeholder="New Password" required>
                                        @if($errors->has('password'))
                                            <span class="x-form-error c-red-error">*{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <div id="login-btn" class="col-10 text-center">
                                        <input type="submit" name="submit" value="Reset">
                                    </div>
                                </div>
                            </form>
                            
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