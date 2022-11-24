<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Payment History</title>
    
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

                    {{-- Check is the payment empty --}}
                    @if ($paidPayments->isEmpty())
                    <div class="text-center">
                        <h3 >There was no payment found.</h3>
                    </div>
                    @else

                    {{-- For loop records --}}
                    @for ($i = 0; $i < count($paidPayments); $i++)

                        @php
                            $color = 'text-success';
                            if ($paidPayments[$i]->status == 'unpaid') {
                                $color = 'text-danger';
                            }
                        @endphp
                        
                        <a href="{{ URL('/dashboard/payment/getPaymentDetails/'. Crypt::encrypt($paidPayments[$i]->payment_id)) }}" class="no-deco text-dark">
                            <div class="card container mb-4 bg-color-navajowhite py-4">
                                <div class="row px-2">

                                    <div class="col-12 col-sm-6 col-lg-8">
                                        <div class="row">
                                            <h6 class="mb-0 text-sm-start pb-0 pb-sm-2 opacity-50">
                                                {{ $paidPayments[$i]->payment_id }}
                                            </h6>

                                            <h3 class="mb-0">
                                                {{ $paidPaymentsName[$i] }}
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <div class="row h-100">
                                            <h6 class="mb-0 h-25 text-sm-end pb-2">
                                                Date: {{ date('Y-m-d', strtotime($paidPayments[$i]->created_at)) }}
                                            </h6>

                                            <div class="h-auto mt-2 mt-sm-0 mt-lg-2">
                                                <h4 class="my-sm-auto text-sm-end {{ $color }}">
                                                    {{ Str::ucfirst($paidPayments[$i]->status) }}
                                                </h4>
                                            </div>
                                            
                                        </div>
                                    </div>

                                </div>
                                <div class="row py-sm-2"></div>
                            </div>
                        </a>
                    
                    @endfor

                    @endif

                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
