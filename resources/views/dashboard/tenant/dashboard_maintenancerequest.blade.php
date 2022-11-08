<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Create Maintenance Request</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_index.css') }}">
</head>

<body>


    @include('../base/dashboard/dashboard_sidebar')

    <div id="wrapper">
        <div class="container-fluid">
            @include('../base/dashboard/dashboard_header')

            <div id="content" class="row justify-content-center">

                {{-- Code here --}}
                <div class="col col-sm-10 col-md-8 col-lg-10">

                    <div class="container-fluid mt-3 mb-5">
                            
                        <div class="row">
                            <div class="col-12 col-md-8 mb-2 mb-md-0">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h5><u>Title:</u></h5>
                                            <p>
                                                Toilet light bulb burn out
                                            </p>
                                        </div>

                                        <div class="card-text">
                                            <h5><u>Description:</u></h5>
                                            <p>
                                                Toilet light bulb burn out need replacement, Urgent!
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-4">
                                
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title pe-2"><u>Status:</u></h5>
                                        <h2>Pending</h3>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">

                                <h5><u>Proof:</u></h5>

                                <div class="row">
                                    @for ($i = 0; $i < 20; $i++)
                                        
                                    
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                        <img class="w-100 h-100 img-thumbnail img-fluid rounded x-image-modal" src="{{ asset('image/renting_post/PI1.png') }}" alt="">
                                    </div>

                                    @endfor
                                </div>

                            </div>
                        </div>
                        
                        <hr>
                    
                        
                    </div>

                </div>

            </div>
        </div>

    </div>

    <div id="x-image-modal">
        <span class="close">&times;</span>
        <img id="x-image" class="img-fluid">
    </div>


    @include('../base/dashboard/dashboard_script')
    <script src="{{ asset('vendor/xande/scripting.js') }}"></script>

</body>

</html>
