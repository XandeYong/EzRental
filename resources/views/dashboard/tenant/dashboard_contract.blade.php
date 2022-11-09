<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Contract</title>
    
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

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Contract</h5>
                            <hr>

                            <div class="card-text pt-3 pb-5">
                                <h6><u>Content:</u></h6>
                                <p class="mb-5">
                                    {{ $contractDetails[0]->content }}
                                </p>

                                <table class="table table-bordered table-responsive table-light mb-5">
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
                                            <td class="bg-white">{{ $contractDetails[0]->expired_date }}</td> 
                                        </tr>
                                        <tr>
                                            <th scope="row">Deposit Payment</th>
                                            <td class="bg-white">RM {{ number_format($contractDetails[0]->deposit_price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Monthly Payment</th>
                                            <td class="bg-white">RM {{ number_format($contractDetails[0]->monthly_price, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
    
                                <div class="container-fluid pt-5">
                                    <div class="row justify-content-between">
                                        <div class="col-12 col-md-6 col-lg-5 mb-5 mb-lg-0">
                                            <h6><u>Owner Signature:</u></h6>
                                            <img class="img-fluid border-bottom-3" src="{{ asset('image/contract/'. $contractDetails[0]->owner_signature) }}" alt="">
                                        </div>
    
                                        <div class="col-12 col-md-6 col-lg-5">
                                            <h6><u>Tenant Signature:</u></h6>
                                            <img class="img-fluid border-bottom-3" src="{{ asset('image/contract/'. $contractDetails[0]->tenant_signature) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
