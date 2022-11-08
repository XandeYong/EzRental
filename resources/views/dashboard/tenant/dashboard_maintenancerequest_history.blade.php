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
                <div class="col col-sm-10 col-md-8 col-lg-10 pb-4">

                    {{-- Check is the renting record empty --}}
                    {{-- <div class="text-center">
                        <h3 >There was no Maintenance Request found.</h3>
                    </div> --}}

                    {{-- For loop records --}}
                    @for ($i = 0; $i < 30; $i++)
                        
                        <a href="{{ route('dashboard.tenant.current_renting_record.maintenance_request_history.maintenance_detail') }}" class="no-deco text-dark">
                            <div class="card mb-4">
                                <div class="d-flex bg-color-burlywood align-items-center py-4">
                                    <div class="row me-auto px-3 w-100 align-items-center" >
                                        <div class="col-12 col-sm">
                                            <h3 class="mb-0">
                                                Toilet bulb burn out
                                            </h3>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <h6 class="mb-0 text-sm-end pb-2">
                                                Date: 3/5/2022
                                            </h6>
                                            <h4 class="mb-0 text-sm-end">
                                                Pending
                                            </h4>
                                        </div>
                                    </div>
                
                                </div>
                            </div>
                        </a>
                    
                    @endfor

                    @if ($button)

                    <div class="d-flex justify-content-center d-block d-lg-none">
                        <div class="fixed-bottom-button">
                            <a href="{{ $button }}">
                                <button class="btn btn-lg btn-success px-3 px-sm-5">Create Maintenance Request</button>
                            </a>
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
