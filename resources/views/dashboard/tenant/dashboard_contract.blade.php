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

                <div class="col col-sm-10 col-md-8 col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Contract</h5>
                            <hr>

                            <div class="card-text pt-3 pb-5">
                                <h6><u>Content:</u></h6>
                                <p class="mb-5">
                                    {!! nl2br(e($contractDetails[0]->content)) !!}
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
                                            @if (!empty($contractor))
                                                <tr>
                                                    <th scope="row" class="w-25">Owner ID</th>
                                                    <td class="bg-white">{{ $contractor->ownerID }}</td> 
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="w-25">Tenant ID</th>
                                                    <td class="bg-white">{{ $contractor->tenantID }}</td> 
                                                </tr>
                                            @endif
                                            <tr>
                                                <th scope="row" class="w-25">Started date</th>
                                                <td class="bg-white">{{ $startDate ?? '-' }}</td> 
                                            </tr>
                                            <tr>
                                                <th scope="row" class="w-25">Expired date</th>
                                                <td class="bg-white">{{ $expiredDate ?? '-' }}</td> 
                                            </tr>
                                            <tr>
                                                <th scope="row">Deposit Payment</th>
                                                <td class="bg-white">RM {{ number_format($contractDetails[0]->deposit_price, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Monthly Payment</th>
                                                <td class="bg-white">RM {{ number_format($contractDetails[0]->monthly_price, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Contract Status</th>
                                                <td class="bg-white">{{ Str::ucfirst($contractDetails[0]->status) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                                <div class="container-fluid pt-5">
                                    <div class="row justify-content-between">
                                        <div class="col-12 col-md-6 col-lg-5 mb-5 mb-lg-0">
                                            <h6><u>Owner Signature:</u></h6>
                                            <img class="img-fluid border-bottom-3" src="{{ asset('image/contract/'. $contractDetails[0]->owner_signature) }}" alt="">
                                            <hr class="mt-5">
                                        </div>
    
                                        <div class="col-12 col-md-6 col-lg-5">
                                            <h6><u>Tenant Signature:</u></h6>
                                            <img class="img-fluid border-bottom-3" src="{{ asset('image/contract/'. $contractDetails[0]->tenant_signature) }}" alt="">
                                            <hr class="mt-5">
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
