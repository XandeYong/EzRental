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
                                                        <label>A1</label>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Name :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>Genji</label>
                                                    </div>
                                                </div>  
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Gender :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>Male</label>
                                                    </div>
                                                </div>  
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Age :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>28</label>
                                                    </div>
                                                </div>  
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Phone Number :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>0137897232</label>
                                                    </div>
                                                </div>  
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col col-lg-3">
                                                        <label>Email :</label>
                                                    </div>
                                                    <div class="col col-lg-9">
                                                        <label>genji@battle.net</label>
                                                    </div>
                                                </div>  
                                            </li>
                                        </ul>

                                    </div>
                                </div>

                            </div>

                            <div id="edit_profile" class="row row-gap justify-content-center mt-1">
                                <div class="col text-center">
                                    <button type="button" class="btn btn-lg btn-light btn-outline-dark w-100">Edit Profile</button>
                                </div>
                            </div>
                        </div>


                        {{-- Change Password --}}
                        <div id="change_password" class="container mt-4">
                            <div class="row">
                                <div class="col">

                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Change Password</h5>
                                        </div>

                                        <div class="card-body">
                                            <div class="row row-gap">
                                                <div class="col-12 col-lg-3">
                                                    <label>New Password: </label>
                                                </div>
                                                <div class="col-12 col-lg-9">
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>

                                            <div class="row row-gap">
                                                <div class="col-12 col-lg-3">
                                                    <label>Old Password: </label>
                                                </div>
                                                <div class="col-12 col-lg-9">
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <button class="card-footer btn btn-outline-danger w-100">Change Password</button>
                                    </div>

                                </div>
                            </div>
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
