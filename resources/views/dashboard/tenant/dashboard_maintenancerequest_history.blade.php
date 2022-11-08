<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Maintenance Request History</title>
    
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

                    {{-- Check is the renting record empty --}}
                    {{-- <div class="text-center">
                        <h3 >There was no Maintenance Request found.</h3>
                    </div> --}}
                    {{-- Check is the maintenance request empty --}}
                    @if ($maintenanceRequests->isEmpty())
                    <div class="text-center">
                        <h3 >There was no maintenance request found.</h3>
                    </div>
                    @else

                    {{-- For loop records --}}
                    @foreach ($maintenanceRequests as $maintenanceRequest)
                        
                        <a href="{{ URL('/dashboard/rentingrecord/maintenancerequest/getMaintenanceRequestDetails/'. Crypt::encrypt($maintenanceRequest->maintenance_id)) }}" class="no-deco text-dark">
                            <div class="card mb-4">
                                <div class="d-flex bg-color-burlywood align-items-center py-4">
                                    <div class="row me-auto px-3 w-100 align-items-center" >
                                        <div class="col-12 col-sm">
                                            <h3 class="mb-0">
                                                {{ $maintenanceRequest->title }}
                                            </h3>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <h6 class="mb-0 text-sm-end pb-2">
                                                Date: {{ date('Y-m-d', strtotime($maintenanceRequest->created_at)) }}
                                            </h6>
                                            <h4 class="mb-0 text-sm-end">
                                                {{ Str::ucfirst($maintenanceRequest->status) }}
                                            </h4>
                                        </div>
                                    </div>
                
                                </div>
                            </div>
                        </a>
                    
                    @endforeach

                    @endif

                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
