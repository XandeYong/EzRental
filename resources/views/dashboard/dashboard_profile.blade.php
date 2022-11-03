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

                            {{-- Check is the profile empty --}}
                            @if ($profile->isEmpty())
                                <tr>
                                    <th colspan="6">No Profile found</th>
                                </tr>
                            @else
                            <div class="row row-gap align-items-center">

                                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                    <img src="/image/condo.webp" class="img-fluid img-thumbnail rounded" alt="...">
                                </div>

                                <div class="col-12 col-lg-8">
                                    <div class="card">

                                        <div class="card-header">
                                            <h5>Information</h5>
                                        </div>

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>ID :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>{{ $profile[0]->account_id }}</label>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Name :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>{{ $profile[0]->name }}</label>
                                                    </div>
                                                </div>  
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Gender :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>{{ $profile[0]->gender }}</label>
                                                    </div>
                                                </div>  
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Age :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>{{ $age }}</label>
                                                    </div>
                                                </div>  
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Phone Number :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>{{ $profile[0]->mobile_number }}</label>
                                                    </div>
                                                </div>  
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Email :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>{{ $profile[0]->email }}</label>
                                                    </div>
                                                </div>  
                                            </li>
                                        </ul>

                                    </div>
                                </div>

                            @endif

                            </div>

                            <div id="edit_profile" class="row row-gap justify-content-center mt-1">
                                <div class="col text-center">
                                    <a href="{{ route('dashboard.profile.edit') }}">
                                        <button type="button" class="edit-btn btn btn-lg btn-light btn-outline-dark w-100">Edit Profile</button>
                                    </a>
                                </div>
                            </div>
                        </div>


                        {{-- Change Password --}}
                        <div id="change_password" class="container mt-4">
                            <form action="/profileControl/changePassword" method="post" onsubmit="return confirm('Are you sure you want to change password?');">
                            <div class="row">
                                <div class="col">

                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Change Password</h5>
                                        </div>

                                        <div class="card-body">
                                            <div class="row row-gap align-items-center">
                                                <div class="col-12 col-lg-3">
                                                    <label>New Password: </label>
                                                </div>
                                                <div class="col-12 col-lg-9">
                                                    <input type="password" name="newPassword" class="form-control w-100" required>
                                                </div>
                                            </div>

                                            <div class="row row-gap align-items-center">
                                                <div class="col-12 col-lg-3">
                                                    <label>Old Password: </label>
                                                </div>
                                                <div class="col-12 col-lg-9">
                                                    <input type="password" name="oldPassword" class="form-control w-100" required>
                                                    <input type="hidden" id="correctOldPassword" name="custId" value={{ $profile[0]->password }}>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <span class="c-red-error">*Error message</span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" name="Change Password" value="Change Password"
                                        class="card-footer btn btn-outline-danger w-100">
                                    </div>

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
