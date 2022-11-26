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

                            <form action="{{ route('login.portal.register') }}" method="post">
                                @csrf
                                <div id="l-m-header" class="row">
                                    <div class="text-center">
                                        <h5>Register {{$user}} Account</h5>
                                    </div>
                                </div>

                                <div id="l-m-body" class="row justify-content-center pt-4 pb-3">

                                    <input type="hidden" name="role" value="{{ $user }}" hidden>

                                    <div id="name-txt" class="col-10 mb-3">
                                        <input type="text" name="name" value="{{ old('name') }}" class="w-100" placeholder="Name" required>
                                        @if($errors->has('name'))
                                            <span class="x-form-error c-red-error">*{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    <div id="name-txt" class="col-10 mb-3">
                                        <label class="form-check-label" for="input_dob">
                                            Date of Birth
                                        </label>
                                        <input type="date" name="dob" value="{{ old('dob') }}" id="input_dob" class="w-100 hideArrow" placeholder="Birth Of Date" required>
                                        @if($errors->has('dob'))
                                            <span class="x-form-error c-red-error">*{{ $errors->first('dob') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-10 mb-3">
                                        <div>Gender </div>
                                        <div class="form-check">
                                            <input class="form-check-input me-2" type="radio" name="gender" value="M" id="input_gender_male" required {{ old('gender') ?? (old('gender') == 'M') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="input_gender_male">
                                            Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input me-2" type="radio" name="gender" value="F" id="input_gender_female" required {{ old('gender') ?? (old('gender') == 'F') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="input_gender_female">
                                            Female
                                            </label>
                                        </div>
                                        @if($errors->has('gender'))
                                            <span class="x-form-error c-red-error">*{{ $errors->first('gender') }}</span>
                                        @endif
                                    </div>

                                    <div id="email-txt" class="col-10 mb-3">
                                        <input type="tel" name="phoneNumber" value="{{ old('phoneNumber') }}" class="w-100" placeholder="Mobile Phone Number" required>
                                        @if($errors->has('phoneNumber'))
                                            <span class="x-form-error c-red-error">*{{ $errors->first('phoneNumber') }}</span>
                                        @endif
                                    </div>

                                    <div id="email-txt" class="col-10 mb-3">
                                        <input type="text" name="email" value="{{ old('email') }}" class="w-100" placeholder="E-mail" required>
                                        @if($errors->has('email'))
                                            <span class="x-form-error c-red-error">*{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div id="password-txt" class="col-10 mb-3">
                                        <input type="password" name="password" value="{{ old('password') }}" class="w-100" placeholder="Password" required>
                                        @if($errors->has('password'))
                                            <span class="x-form-error c-red-error">*{{ $errors->first('password') }}</span>
                                        @endif
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