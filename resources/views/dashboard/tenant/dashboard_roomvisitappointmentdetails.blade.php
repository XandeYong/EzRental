<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Room Visit Appointment Detail</title>

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

                    <div class="container-fluid mt-3 mb-5">


                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-responsive table-light">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="w-25">Room Visit Appointment ID</th>
                                            <td class="bg-white">{{ $roomVisitAppointmentDetails[0]->appointment_id }}
                                            </td>

                                            <th scope="row" class="w-25">Request Appointment date</th>
                                            <td class="bg-white w-25">
                                                {{ date('Y-m-d', strtotime($roomVisitAppointmentDetails[0]->created_at)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="">Post Title</th>
                                            <td class="bg-white">{{ $roomVisitAppointmentDetails[0]->title }}</td>

                                            <th scope="row">Status</th>
                                            <td class="bg-white">
                                                {{ Str::ucfirst($roomVisitAppointmentDetails[0]->status) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Appointment Date</th>
                                            <td colspan="3" class="bg-white">
                                                {{ date('Y-m-d', strtotime($roomVisitAppointmentDetails[0]->datetime)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Appointment Time</th>
                                            <td colspan="3" class="bg-white">
                                                {{ date('g:i A', strtotime($roomVisitAppointmentDetails[0]->datetime)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Note</th>
                                            <td colspan="3" class="bg-white">
                                                {{ $roomVisitAppointmentDetails[0]->note }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-5 justify-content-center">

                            @if (($roomVisitAppointmentDetails[0]->status == 'rescheduled' && session()->get('account')->role == 'T') ||
                                ($roomVisitAppointmentDetails[0]->status == 'pending' && session()->get('account')->role == 'O'))

                                <div class="col-12 col-lg-4">
                                    <a href="{{ url('/dashboard/roomvisitappointment/approveAppointment/' . Crypt::encrypt($roomVisitAppointmentDetails[0]->appointment_id)) }}" class="btn btn-lg btn-primary w-100" onclick="return confirm('Are you sure you want to approve appointment?');">Appove</a>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <a href="{{ url('/dashboard/roomvisitappointment/rejectAppointment/' . Crypt::encrypt($roomVisitAppointmentDetails[0]->appointment_id)) }}"
                                        class="btn btn-lg btn-warning w-100" onclick="return confirm('Are you sure you want to reject appointment?');">Reject</a>
                                </div>

                                @if ($roomVisitAppointmentDetails[0]->status == 'pending' && session()->get('account')->role == 'O')
                                    <div class="col-12 col-lg-4">
                                        <a href="#" class="btn btn-lg btn-warning w-100">Edit</a>
                                    </div>
                                @endif
                            @elseif ($roomVisitAppointmentDetails[0]->status == 'approved')
                                <div class="col-12 col-lg-4">
                                    <a href="{{ url('/dashboard/roomvisitappointment/cancelAppointment/' . Crypt::encrypt($roomVisitAppointmentDetails[0]->appointment_id)) }}"
                                        class="btn btn-lg btn-warning w-100" onclick="return confirm('Are you sure you want to cancel appointment?');">Cancel</a>
                                </div>

                            @endif
                        </div>


                    </div>

                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
