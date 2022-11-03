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

                <div id="content" class="row">

                    {{-- Code here --}}
                    <div class="col justify-content-center">

                        {{-- Profile Details --}}
                        <div class="container">
                            
                            {{-- Check is the profile empty --}}
                            @if ($profile->isEmpty())
                                <tr>
                                    <th colspan="6">No Profile found</th>
                                    <label>{{ $age }}</label>
                                </tr>
                            @else
                                <div class="row row-gap">
                                    <img src="/image/condo.webp" class="img-fluid img-thumbnail rounded float-left"
                                        alt="...">

                                    <div class="row row-gap">
                                        <div class="col-md-2">
                                            <label>ID :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ $profile[0]->account_id }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-gap">
                                        <div class="col-md-2">
                                            <label>Name :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ $profile[0]->name }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-gap">
                                        <div class="col-md-2">
                                            <label>Gender :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ $profile[0]->gender }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-gap">
                                        <div class="col-md-2">
                                            <label>Age :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ $age }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-gap">
                                        <div class="col-md-2">
                                            <label>Phone Number :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ $profile[0]->mobile_number }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-gap">
                                        <div class="col-md-2">
                                            <label>Email :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ $profile[0]->email }}</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Button to Edit Profile --}}
                                <br>
                                <div class="row">
                                    <button type="button" class="edit-profile-button">Edit Profile</button>
                                </div>
                        </div>

                        <br>
                        {{-- Change Password Form --}}
                        <div class="container change-password-container">
                            <form action="./profileControl/editPassword" method="post" onsubmit="return confirm('Are you sure you want to change password?');">
                                <div class="row change-password-title">
                                    <h2>Change Password</h2>
                                </div>

                                <div class="row row-gap">
                                    <div class="col-md-2">
                                        <label>New Password :</label>
                                    </div>
                                    <div class="col-md">
                                        <input type="password" name="newPassword" class="w-100">
                                    </div>
                                </div>
                                <div class="row row-gap">
                                    <div class="col-md-2">
                                        <label>Old Password :</label>
                                    </div>
                                    <div class="col-md">
                                        <input type="password" name="oldPassword" class="w-100">
                                        <input type="hidden" id="correctOldPassword" name="custId" value={{ $profile[0]->password }}>
                                    </div>
                                </div>
                                <div class="row">
                                    <div style="text-align: center;">
                                        <input type="submit" name="Change Password" value="Change Password"
                                            class="col-md-4 change-password-button">
                                    </div>
                                </div>

                            </form>
                        </div>

                        @endif

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
