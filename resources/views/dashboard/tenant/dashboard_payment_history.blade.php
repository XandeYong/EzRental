<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Current Renting Record List</title>
    
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
                        <h3 >There was no Payment found.</h3>
                    </div> --}}

                    {{-- For loop records --}}
                    @for ($i = 0; $i < 100; $i++)
                        
                        <a href="{{ route('dashboard.tenant.current_renting_record.payment_history.payment') }}" class="no-deco text-dark">
                            <div class="card mb-4">
                                <div class="d-flex bg-color-powderblue align-items-center py-4">
                                    <div class="row me-auto px-3 w-100 align-items-center" >
                                        <div class="col-12 col-sm">
                                            <h3 class="mb-0">
                                                May Monthly Payment
                                            </h3>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <h6 class="mb-0 text-sm-end pb-2">
                                                Date: 1/5/2022
                                            </h6>
                                            <h4 class="mb-0 text-sm-end">
                                                Paid
                                            </h4>
                                        </div>
                                    </div>
                
                                </div>
                            </div>
                        </a>
                    
                    @endfor

                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
