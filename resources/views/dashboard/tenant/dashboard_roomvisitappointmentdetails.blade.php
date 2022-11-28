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
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered table-light">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="w-25">Room Visit Appointment ID</th>
                                            <td class="bg-white">{{ $roomVisitAppointmentDetails[0]->appointment_id }}
                                            </td>

                                            <th scope="row" class="w-25">Date Created</th>
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

                        <div class="row gy-4 mt-3 justify-content-center">

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
                                    <div class="col-12 col-lg-8">
                                        <button class="btn btn-lg btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</button>
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

    @if ($roomVisitAppointmentDetails[0]->status == 'pending')
        <!-- Edit Modal -->
        <div class="modal modal-lg fade" id="edit_modal" tabindex="-1"
            aria-labelledby="visit appointment modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <form action="/dashboard/roomvisitappointment/editVisitAppointment" method="POST" class="x-form"
                        x-confirm="Are you sure you want to update this visit appointment?">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Visit Appointment</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="roomVisitAppointmentID" value="{{ $roomVisitAppointmentDetails[0]->appointment_id }}">

                            @php
                                $datetime = substr($roomVisitAppointmentDetails[0]->datetime, 0, 16);
                            @endphp

                            <div class="mb-3">
                                <label for="visit_appointment_datetime" class="form-label">Date & Time <span class="c-red">*</span></label>
                                <input type="datetime-local" class="form-control" name="datetime" value="@if(old('datetime') != null && (!$errors->has('datetime'))){{ old('datetime') }}@else{{ $datetime }}@endif"
                                    id="visit_appointment_datetime" required>
                                @if ($errors->has('datetime'))
                                    <span class="c-red-error">*{{ $errors->first('datetime') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="visit_appointment_note" class="form-label">Note <span class="c-red">*</span></label>
                                <textarea class="form-control" name="note" id="visit_appointment_note" placeholder="Leave a message..."
                                    rows="3" maxlength="255" required>@if(old('note') != null && (!$errors->has('note'))){{ old('note') }}@else{{ $roomVisitAppointmentDetails[0]->note }}@endif</textarea>
                                @if ($errors->has('note'))
                                    <span class="c-red-error">*{{ $errors->first('note') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button id="visit_appointment_button" type="submit" class="btn btn-primary">Edit Appointment</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

    @include('../base/dashboard/dashboard_script')
    <script src="{{ asset('js/dashboard/dashboard_visitappointment.js') }}"></script>

    <script>
        <?php
          if ($errors->has('datetime') || $errors->has('note')){
                 ?>
        $(document).ready(function() {
            $('#edit_modal').modal('show')
        });
        <?php
                 }
                 ?>
    </script>

</body>

</html>
