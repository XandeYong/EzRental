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
                                            
                                        <h5 class="card-title pe-2 mt-2"><u>Updated Time:</u></h5>
                                        <h5> {{ $maintenanceRequestDetails[0]->updated_at }}</h5>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">

                                @if (($maintenanceRequestDetails[0]->status == "approved" && session()->get("account")["role"] == "O") || $maintenanceRequestDetails[0]->status == "success")

                                    <h5><u>Proof:</u></h5>

                                    <div id="proof_image" class="container-fluid mt-3">

                                        @if ($maintenanceRequestDetails[0]->status == "approved" && session()->get("account")['role'] == "O")

                                            <form id="proof_form" class="x-form row" action="{{ url('/test/maintenance/upload') }}" method="post" enctype="multipart/form-data"
                                                x-confirm="Are you sure you want to upload the proof?">
                                                @csrf
                                                <div class="container-fluid overflow-hidden">
                                                    <div class="upload-image-container row gx-3 gy-4">

                                                        <div class="upload-image-item col-12 col-lg-2">
                                                            <div class="upload border-1 rounded p-2 text-center">
                                                                <div class="image-delete text-end">
                                                                    <button type="button" class="opacity-0 btn-close" disabled aria-label="Close"></button>
                                                                </div>
                                                                <div class="image-container x-min-height-150 align-items-center d-flex mb-2">
                                                                    <img class="upload-image img-thumbnail img-fluid rounded x-image-modal x-max-height-150 mx-auto" src="{{ asset('image/image_display.jpg') }}" alt="Image display here" title="your upload image display here.">
                                                                </div>
                                                                
                                                                <input type="file" name="images[]" id="input_image" class="upload-input form-control form-control-sm" required>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row justify-content-center mt-5 mb-3">
                                                        <div class="col-10">
                                                            <input class="btn btn-primary w-100" type="submit" value="Upload">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        @elseif ($maintenanceRequestDetails[0]->status == "success")
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
                                                            <img class=" w-100 img-thumbnail img-fluid rounded x-image-modal x-max-height-300"
                                                                src="{{ asset('image/maintenance/' . $maintenanceRequestImages[$i]->image) }}"
                                                                alt="{{ $maintenanceRequestImages[$i]->image }}">
                                                        </div>
                                                    @endfor
                                                @endif
                                                
                                            </div>
                                        @endif
                                    </div>

                                @elseif ($maintenanceRequestDetails[0]->status != "pending")
                                @php
                                    $statusMessage = "Wait for owner reply";

                                    if ($maintenanceRequestDetails[0]->status == "rejected") {
                                        $statusMessage = "The owner has rejected your request";
                                    }

                                @endphp
                                
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-10 text-center">
                                            {{ $statusMessage }}
                                        </div>
                                    </div>
                                </div>
                                    
                                @endif

                            </div>
                        </div>

                        @if (($maintenanceRequestDetails[0]->status == "pending" && session()->get('account')->role == "O"))

                        {{-- buttons --}}
                        <div class="row g-3 mt-5 justify-content-center">
                    
                            <div class="col-12 col-lg-4">
                                <a href="{{ url('/dashboard/rentingrecord/maintenancerequest/approveMaintenanceRequest/' . Crypt::encrypt($maintenanceRequestDetails[0]->maintenance_id)) }}" class="btn btn-lg btn-primary w-100" 
                                    x-confirm="Are you sure you want to approve the maintenance request?">
                                    Appove
                                </a>
                            </div>
                            
                            <div class="col-12 col-lg-4">
                                <a href="{{ url('/dashboard/rentingrecord/maintenancerequest/rejectMaintenanceRequest/' . Crypt::encrypt($maintenanceRequestDetails[0]->maintenance_id)) }}" class="btn btn-lg btn-warning w-100" 
                                    x-confirm="Are you sure you want to reject the maintenance request?">
                                    Reject
                                </a>
                            </div>

                        </div>

                        @else
                            <hr>
                        @endif


                    </div>

                </div>

            </div>
        </div>

    </div>

    <div id="x-image-modal">
        <span class="close">&times;</span>
        <img id="x-image" class="img-fluid bg-color-white-t-20">
    </div>


    @include('../base/dashboard/dashboard_script')
    <script src="{{ asset('vendor/xande/scripting.js') }}"></script>
    <script src="{{ asset('js/dashboard/tenant/dashboard_maintenance.js') }}"></script>
    <script src="{{ asset('vendor/xande/form.js') }}"></script>

</body>

</html>
