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
                        
                        <a href="{{ URL('/dashboard/payment/getPaymentDetails/'. Crypt::encrypt($paidPayments[$i]->payment_id)) }}" class="no-deco text-dark">
                            <div class="card mb-4">
                                <div class="d-flex bg-color-powderblue align-items-center py-4">
                                    <div class="row me-auto px-3 w-100 align-items-center" >
                                        <div class="col-12 col-sm">
                                            <h3 class="mb-0">
                                                {{ $paidPaymentsName[$i] }}
                                            </h3>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <h6 class="mb-0 text-sm-end pb-2">
                                                Date: {{ $paidPayments[$i]->paid_date }} 
                                            </h6>
                                            <h4 class="mb-0 text-sm-end">
                                                {{ Str::ucfirst($paidPayments[$i]->status) }}
                                            </h4>
                                        </div>
                                    </div>
                
                                </div>
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