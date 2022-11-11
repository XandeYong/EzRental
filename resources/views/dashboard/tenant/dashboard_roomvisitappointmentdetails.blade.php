
<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Payment</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset("/css/dashboard/dashboard_index.css")}}">
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

                        {{-- For loop records --}}
                        @for ($i = 0; $i < count($roomVisitAppointmentDetails); $i++)
                            
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-responsive table-light">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="w-25">Room Visit Appointment ID</th>
                                            <td class="bg-white">{{ $roomVisitAppointmentDetails[$i]->appointment_id }}</td> 

                                            <th scope="row" class="w-25">Request Appointment date</th>
                                            <td class="bg-white w-25">{{ date('Y-m-d', strtotime($roomVisitAppointmentDetails[$i]->created_at)) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="">Post Title</th>
                                            <td class="bg-white">{{ $roomVisitAppointmentDetails[$i]->title }}</td>

                                            <th scope="row">Status</th>
                                            <td class="bg-white">{{ Str::ucfirst($roomVisitAppointmentDetails[$i]->status) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Appointment Date</th>
                                            <td colspan="3" class="bg-white">{{ date('Y-m-d', strtotime($roomVisitAppointmentDetails[$i]->datetime)) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Appointment Time</th>
                                            <td colspan="3" class="bg-white">{{ date('g:i A', strtotime($roomVisitAppointmentDetails[$i]->datetime)) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Note</th>
                                            <td colspan="3" class="bg-white">{{ $roomVisitAppointmentDetails[$i]->note }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        @endfor

                        
                    </div>

                </div>

            </div>
            
        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>
</html>