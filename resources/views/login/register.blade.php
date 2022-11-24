<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Register</title>
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
                        <div id="login-model" class="col-12 col-sm-6 col-md-6 col-lg-4">

                            <form action="#" method="post">
                                <div id="l-m-header" class="row">
                                    <div class="text-center">
                                        <h5>Register {{$user}} Account</h5>
                                    </div>
                                </div>

                                <div id="l-m-body" class="row justify-content-center pt-4 pb-3">

                                    <div id="name-txt" class="col-10 mb-3">
                                        <input type="text" name="name" class="w-100" placeholder="Name" required>
                                    </div>

                                    <div id="name-txt" class="col-10 mb-3">
                                        <label class="form-check-label" for="input_dob">
                                            Date of Birth
                                        </label>
                                        <input type="date" name="name" id="input_dob" class="w-100 hideArrow" placeholder="Birth Of Date" required>
                                    </div>

                                    <div class="col-10 mb-3">
                                        <div>Gender </div>
                                        <div class="form-check">
                                            <input class="form-check-input me-2" type="radio" name="gender" id="input_gender_male" required>
                                            <label class="form-check-label" for="input_gender_male">
                                            Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input me-2" type="radio" name="gender" id="input_gender_female" required>
                                            <label class="form-check-label" for="input_gender_female">
                                            Female
                                            </label>
                                        </div>
                                    </div>

                                    <div id="email-txt" class="col-10 mb-3">
                                        <input type="tel" name="phone" class="w-100" placeholder="Mobile Phone Number" required>
                                    </div>

                                    <div id="email-txt" class="col-10 mb-3">
                                        <input type="text" name="email" class="w-100" placeholder="E-mail" required>
                                    </div>
                                    
                                    <div id="password-txt" class="col-10 mb-3">
                                        <input type="password" name="password" class="w-100" placeholder="Password" required>
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
                            <a href="{{route('login.' . strtolower($user))}}" class="btn btn-sm btn-outline-success">Login here</a>
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