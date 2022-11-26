<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Rent Request Detail</title>

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

                        {{-- For loop records --}}
                        @for ($i = 0; $i < count($rentRequestDetails); $i++)
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered table-light">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="w-25">Request ID</th>
                                                <td class="bg-white">{{ $rentRequestDetails[$i]->rent_request_id }}</td>

                                                <th scope="row" class="w-25">Request Date</th>
                                                <td class="bg-white w-25">
                                                    {{ date('Y-m-d', strtotime($rentRequestDetails[$i]->created_at)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="">Post Title</th>
                                                <td class="bg-white">{{ $rentRequestDetails[$i]->title }}</td>

                                                <th scope="row">Status</th>
                                                <td class="bg-white">{{ Str::ucfirst($rentRequestDetails[$i]->status) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Price</th>
                                                <td colspan="3" class="bg-white">RM
                                                    {{ number_format($rentRequestDetails[$i]->price, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Start Date</th>
                                                <td colspan="3" class="bg-white">
                                                    {{ $rentRequestDetails[$i]->rent_date_start }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">End Date</th>
                                                <td colspan="3" class="bg-white">
                                                    {{ $rentRequestDetails[$i]->rent_date_end }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endfor


                        {{-- buttons --}}
                        <div class="row mt-5 justify-content-center">

                            @if ($rentRequestDetails[0]->status == 'pending' && session()->get('account')->role == 'O')
                                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                    <button type="button" class="btn btn-lg btn-primary w-100"
                                        data-bs-toggle="modal" data-bs-target="#contract_modal">
                                        Sign Contract
                                    </button>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <a href="{{ url('/dashboard/rentrequest/rejectRentRequest/' . Crypt::encrypt($rentRequestDetails[0]->rent_request_id)) }}"
                                        class="btn btn-lg btn-warning w-100"
                                        onclick="return confirm('Are you sure you want to reject the rent request?');">Reject</a>
                                </div>
                            @elseif ($rentRequestDetails[0]->status == 'approved' && session()->get('account')->role == 'T')
                                <div class="row mt-5">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                            <button type="button" class="btn btn-lg btn-primary w-100"
                                                data-bs-toggle="modal" data-bs-target="#contract_modal">
                                                Sign Contract
                                            </button>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <a href="{{ url('/dashboard/rentrequest/cancelRentRequest/' . Crypt::encrypt($rentRequestDetails[0]->rent_request_id)) }}" class="btn btn-lg btn-warning w-100"
                                                onclick="return confirm('Are you sure you want to cancel the rent request?');">Cancel</a>
                                        </div>
                                    </div>

                                </div>
                            @elseif ($rentRequestDetails[0]->status == 'approved' && session()->get('account')->role == 'O' || $rentRequestDetails[0]->status == 'signed' && session()->get('account')->role == 'T')

                                <div class="row justify-content-center">
                                    <div class="col-12 col-lg-4">
                                        <a href="{{ url('/dashboard/rentrequest/cancelRentRequest/' . Crypt::encrypt($rentRequestDetails[0]->rent_request_id)) }}" class="btn btn-lg btn-warning w-100"
                                            onclick="return confirm('Are you sure you want to cancel the rent request?');">Cancel</a>
                                    </div>
                                </div>

                            @elseif ($rentRequestDetails[0]->status == 'signed' && session()->get('account')->role == 'O')
                                {{-- do process after tenant signed --}}

                                    <div class="row justify-content-center">
                                        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                            <a >
                                                <button type="button" class="btn btn-lg btn-primary w-100"
                                                data-bs-toggle="modal" data-bs-target="#contract_modal">
                                                Confirm Contract
                                            </button>
                                            </a>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <a href="{{ url('/dashboard/rentrequest/cancelRentRequest/' . Crypt::encrypt($rentRequestDetails[0]->rent_request_id)) }}" class="btn btn-lg btn-warning w-100"
                                                onclick="return confirm('Are you sure you want to cancel the rent request?');">Cancel</a>
                                        </div>
                                    </div>
                            @endif
                        </div>


                        {{-- Guidance --}}
                        @if ($rentRequestDetails[0]->status == 'expired')
                            <div class="row mt-5">
                                <div class="row justify-content-center">
                                    <div class="alert alert-secondary" role="alert">
                                        Guidance: This rent request is expired because the request didn't complete in
                                        time.
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>

                </div>

            </div>

        </div>
    </div>


    @if ($rentRequestDetails[0]->status == 'pending' || $rentRequestDetails[0]->status == 'approved' || $rentRequestDetails[0]->status == 'signed')
    @php 
        $url = "";
        $user = "";
        $confirm = "";
        $t_sign = "";
        $o_sign = "";
        $method = "POST";
        $action = "Sign";

        if (session()->get('account')['role'] == 'O' && $rentRequestDetails[0]->status == 'signed') {
            $url = url('/dashboard/rentrequest/confirmRentRequest/' . Crypt::encrypt($rentRequestDetails[0]->rent_request_id));
            $confirm = "Are you sure you want to confirm the rent request?";
            $method = "GET";
            $action = "Confirm";
        } else if (session()->get('account')['role'] == "T") {
            $url = URL("/dashboard/rentingrequest/tenantSignContract");
            $user = "T";
            $confirm = "Are you sure you want to sign the contract?";
            $t_sign = "x-upload-image";
        } else if (session()->get('account')['role'] == 'O') {
            $url = URL("/dashboard/rentingrequest/ownerSignContract");
            $user = "O";
            $confirm = "Are you sure you want to approve the rent request by sign the contract?";
            $o_sign = "x-upload-image";
        }

    @endphp

    <!-- Contract Modal -->
    <form action="{{ $url }}" method="{{ $method }}"  
        onsubmit="return confirm('{{ $confirm }}');" enctype="multipart/form-data"> 
        @csrf
        <div class="modal modal-lg fade" id="contract_modal" tabindex="-1" aria-labelledby="contract modal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Contract</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="card-text pt-3 pb-5">
                            <h6><u>Content:</u></h6>
                            <p class="mb-5">
                                {{ $contract[0]->content }}
                            </p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-light mb-5">
                                    <thead class="table-info">
                                        <tr>
                                            <th scope="col" colspan="2">
                                                <h6><u>Contract Information</u></h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="w-25">Expired date</th>
                                            <td class="bg-white">-</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Deposit Payment</th>
                                            <td class="bg-white">RM {{ number_format($contract[0]->deposit_price, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Monthly Payment</th>
                                            <td class="bg-white">RM {{ number_format($contract[0]->monthly_price, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="container-fluid pt-5">
                                <div class="row justify-content-between">
                                    
                                    <input type="hidden" name="contractID" value="{{ $contract[0]->contract_id }}">
                                    <input type="hidden" name="rentRequestID" value="{{ $rentRequestDetails[0]->rent_request_id }}">
                                        
                                    <div class="col-12 col-md-6 col-lg-5 mb-5 mb-lg-0">
                                        <h6 class="pb-5"><u>Owner Signature:</u> @if(session()->get('account')->role == 'O')<span class="c-red">*</span> @endif</h6>
                                        <img class="img-fluid {{ $o_sign }}" src="{{ asset('image/contract/' . $contract[0]->owner_signature) }}" alt="">
                                        <hr class="mt-5">

                                        @if ($user == "O")
                                            <input class="x-input-image form-control text-center" type="file" name="sign">
                                            @if ($errors->has('sign'))
                                                <span class="c-red-error">*{{ $errors->first('sign') }}</span>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-5">
                                        <h6 class="pb-5"><u>Tenant Signature:</u> @if(session()->get('account')->role == 'T')<span class="c-red">*</span> @endif</h6>
                                        <img class="img-fluid {{ $t_sign }}" src="{{ asset('image/contract/' . $contract[0]->tenant_signature) }}" alt="">
                                        <hr class="mt-5">

                                        @if ($user == "T")
                                            <input class="x-input-image form-control text-center" type="file" name="sign">
                                            @if ($errors->has('sign'))
                                                <span class="c-red-error">*{{ $errors->first('sign') }}</span>
                                            @endif
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer hstack">
                        <button type="submit" class="btn btn-success w-100" data-bs-dismiss="modal">{{ $action }}</button>
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        <?php
            if ($errors->has('sign')){
             ?>
        $(document).ready(function() {
            $('#contract_modal').modal('show')
        });
        <?php
             }
             ?>
    </script>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
