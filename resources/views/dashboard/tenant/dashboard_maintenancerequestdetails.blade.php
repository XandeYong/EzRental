<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Maintenance Request Details</title>

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
                        {{-- Display success message --}}
                        @if (Session::has('successMessage'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong> {{ session('successMessage') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php session()->forget('successMessage'); ?>
                        @endif

                        {{-- Display fail message --}}
                        @if (Session::has('failMessage'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong> {{ session('failMessage') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php session()->forget('failMessage'); ?>
                        @endif

                        <div class="row">
                            <div class="col-12 col-md-8 mb-2 mb-md-0">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h5><u>Title:</u></h5>
                                            <p>
                                                {{ $maintenanceRequestDetails[0]->title }}
                                            </p>
                                        </div>

                                        <div class="card-text">
                                            <h5><u>Description:</u></h5>
                                            <p>
                                                {{ $maintenanceRequestDetails[0]->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-4">

                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title pe-2"><u>Status:</u></h5>
                                        <h2> {{ Str::ucfirst($maintenanceRequestDetails[0]->status) }}</h3>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">

                                <h5><u>Proof:</u></h5>

                                <div class="row">

                                    {{-- Check is the roomRentalPostLists empty --}}
                                    @if (count($maintenanceRequestImages) == 0)
                                        <div class="text-center">
                                            <h3>There was no any image proof yet.</h3><br>
                                        </div>
                                    @else
                                        {{-- For loop records --}}
                                        @for ($i = 0; $i < count($maintenanceRequestImages); $i++)
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                                <img class="w-100 img-thumbnail img-fluid rounded x-image-modal x-m-height-300"
                                                    src="{{ asset('image/maintenance/' . $maintenanceRequestImages[$i]->image) }}"
                                                    alt="{{ $maintenanceRequestImages[$i]->image }}">
                                            </div>
                                        @endfor
                                    @endif
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
