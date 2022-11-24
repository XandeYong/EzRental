<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Rent Request List</title>
    
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

                    {{-- Check is the Room Visit Appointment Lists empty --}}
                    @if ($roomVisitAppointmentLists->isEmpty())
                        <div class="text-center">
                            <h3 >There was no room visit appointment found.</h3>
                        </div>
                    @else

                        {{-- For loop records --}}
                        @foreach ($roomVisitAppointmentLists as $roomVisitAppointmentList)
                            
                            @php
                                $color = 'text-primary';
                                if ($roomVisitAppointmentList->status == 'canceled' || $roomVisitAppointmentList->status == 'rejected') {
                                    $color = 'text-danger';
                                } else if ($roomVisitAppointmentList->status == 'success') {
                                    $color = 'text-success';
                                }
                            @endphp
                            
                            <a href="{{ URL('/dashboard/roomvisitappointment/getRoomVisitAppoitmentDetails/'. Crypt::encrypt($roomVisitAppointmentList->appointment_id)) }}" class="no-deco text-dark">
                                <div class="card container mb-4 bg-color-burlywood py-4">
                                    <div class="row px-2">
        
                                        <div class="col-12 col-sm-6 col-lg-8">
                                            <div class="row">
                                                <h6 class="mb-0 text-sm-start pb-0 pb-sm-2 opacity-50">
                                                    {{ $roomVisitAppointmentList->appointment_id }}
                                                </h6>
        
                                                <h3 class="mb-0">
                                                    {{ $roomVisitAppointmentList->title }}
                                                </h3>
                                            </div>
                                        </div>
        
                                        <div class="col-12 col-sm-6 col-lg-4">
                                            <div class="row h-100">
                                                <h6 class="mb-0 h-25 text-sm-end pb-2">
                                                    Date: {{ date('Y-m-d', strtotime($roomVisitAppointmentList->created_at)) }}
                                                </h6>
        
                                                <div class="h-auto mt-2 mt-sm-0 mt-lg-2">
                                                    <h4 class="my-sm-auto text-sm-end {{ $color }}">
                                                        {{ Str::ucfirst($roomVisitAppointmentList->status) }}
                                                    </h4>
                                                </div>
                                                
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="row py-sm-2"></div>
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
