@if (isset($user))
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>EzRental | Profile</title>

        @include('../base/dashboard/dashboard_head')
        {{-- <link rel="stylesheet" href="{{ asset("/css/dashboard/dashboard_index.css")}}"> --}}
        <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_profile.css') }}">

    </head>

    <body>

        @include('../base/dashboard/dashboard_sidebar')

        <div id="wrapper">
            <div class="container-fluid">
                @include('../base/dashboard/dashboard_header')

                <div id="content" class="row justify-content-center">

                    {{-- Code here --}}
                    <div class="col col-sm-10 col-md-8 col-lg-10">

                        {{-- Profile Details --}}
                        <div class="container">

                            <form action="/dashboard/profile/validateEditProfileDetails" method="post"
                                    onsubmit="return confirm('Are you sure you want to edit profile?');" enctype="multipart/form-data">
                                    @csrf
                                {{-- Check is the profile empty --}}
                                @if ($profile->isEmpty())
                                    
                                        <label colspan="6">No Profile found</label>
                                    
                                @else
                                <div class="row row-gap align-items-center">

                                    <div class="col-12 col-lg-5 col-xl-4 mb-3 mb-lg-0 img-thumbnail py-3">
                                        <img src="/image/account/{{ $profile[0]->image }}" class="img-fluid rounded" alt="...">
                                        <div class="pt-3 px-2">
                                            <input class="form-control text-center" type="file" name="image">
                                            @if($errors->has('image'))
                                            <span class="c-red-error">*{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                        
                                    </div>

                                    <div class="col-12 col-lg-7 col-xl-8">
                                        <div class="card">

                                            <div class="card-header">
                                                <h5>Information</h5>
                                            </div>

                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-4 col-lg-3">
                                                            <label>ID :</label>
                                                        </div>
                                                        <div class="col-12 col-sm-8 col-lg-9">
                                                            <label>{{ $profile[0]->account_id }}</label>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-4 col-lg-3">
                                                            <label>Name :</label>
                                                        </div>
                                                        <div class="col-12 col-sm-8 col-lg-9">
                                                            <input class="form-control" type="text" name="name" value="{{ old('name', $profile[0]->name) }}" placeholder="Please Enter your name here" required>
                                                            @if($errors->has('name'))
                                                            <span class="c-red-error">*{{ $errors->first('name') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>  
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-4 col-lg-3">
                                                            <label>Gender :</label>
                                                        </div>
                                                        <div class="col-12 col-sm-8 col-lg-9">

                                                            @if($errors->any())
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="gender"  value="M" {{ old('gender') == "M" ? 'checked' : '' }} required  />
                                                                <label class="form-check-label" >
                                                                    Male
                                                                </label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="gender"  value="F" {{ old('gender') == "F" ? 'checked' : '' }}  required />
                                                                <label class="form-check-label" >
                                                                    Female
                                                                </label>
                                                            </div>
                                                            @if($errors->has('gender'))
                                                            <span class="c-red-error">*{{ $errors->first('gender') }}</span>
                                                            @endif
                                                            @else
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="gender"  value="M" required @if ($profile[0]->gender == "M") checked @endif />
                                                                <label class="form-check-label" >
                                                                    Male
                                                                </label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="gender"  value="F" required @if ($profile[0]->gender == "F") checked @endif />
                                                                <label class="form-check-label" >
                                                                    Female
                                                                </label>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>  
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-4 col-lg-3">
                                                            <label>Age :</label>
                                                        </div>
                                                        <div class="col-12 col-sm-8 col-lg-9">
                                                            <input class="form-control" type="text" name="age" value="{{ old('age', $age) }}" placeholder="Please Enter your Age here" required>
                                                            @if($errors->has('age'))
                                                            <span class="c-red-error">*{{ $errors->first('age') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>  
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-4 col-lg-3">
                                                            <label>Phone Number :</label>
                                                        </div>
                                                        <div class="col-12 col-sm-8 col-lg-9">
                                                            <input class="form-control" type="text" name="phoneNumber" value="{{ old('phoneNumber', $profile[0]->mobile_number) }}" placeholder="Please Enter your phone number here" required>
                                                            @if($errors->has('phoneNumber'))
                                                            <span class="c-red-error">*{{ $errors->first('phoneNumber') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>  
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-4 col-lg-3">
                                                            <label>Email :</label>
                                                        </div>
                                                        <div class="col-12 col-sm-8 col-lg-9">
                                                            <input class="form-control" type="text" name="email" value="{{ old('email', $profile[0]->email) }}" placeholder="Please Enter your email here" required>
                                                            @if($errors->has('email'))
                                                            <span class="c-red-error">*{{ $errors->first('email') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>  
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                @endif
                                


                                <div id="edit_profile" class="row row-gap justify-content-center mt-1 mt-lg-2">
                                    <div class="col text-center">
                                        <input type="submit" class="edit-btn btn btn-lg btn-warning w-100" name="Edit Profile" value="Edit Profile" />
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>



                </div>

            </div>
        </div>

        @include('../base/dashboard/dashboard_script')

    </body>
    </html>
    
@else
    <script>
        window.location = "/";
    </script>
@endif
