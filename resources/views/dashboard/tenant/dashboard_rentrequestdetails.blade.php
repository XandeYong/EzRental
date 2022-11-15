
<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Rent Request Detail</title>
    
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
                        @for ($i = 0; $i < count($rentRequestDetails); $i++)
                            
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-responsive table-light">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="w-25">Request ID</th>
                                            <td class="bg-white">{{ $rentRequestDetails[$i]->rent_request_id }}</td> 

                                            <th scope="row" class="w-25">Request Date</th>
                                            <td class="bg-white w-25">{{ date('Y-m-d', strtotime($rentRequestDetails[$i]->created_at)) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="">Post Title</th>
                                            <td class="bg-white">{{ $rentRequestDetails[$i]->title }}</td>

                                            <th scope="row">Status</th>
                                            <td class="bg-white">{{ Str::ucfirst($rentRequestDetails[$i]->status) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Price</th>
                                            <td colspan="3" class="bg-white">RM {{ number_format($rentRequestDetails[$i]->price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Start Date</th>
                                            <td colspan="3" class="bg-white">{{ $rentRequestDetails[$i]->rent_date_start }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">End Date</th>
                                            <td colspan="3" class="bg-white">{{ $rentRequestDetails[$i]->rent_date_end }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        @endfor

                        @if ($rentRequestDetails[0]->status == "approved")
                        <div class="row mt-5">
                            <form class="col-12" action="" method="post">

                                <input hidden type="hidden" name="id" value="{{ $rentRequestDetails[0]->rent_request_id }}">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-lg-4">
                                        <button type="button" class="btn btn-lg btn-primary w-100" data-bs-toggle="modal" data-bs-target="#contract_modal">
                                            Sign Contract
                                        </button>
                                    </div>
                                    
                                    <div class="col-12 col-lg-4">
                                        <input class="btn btn-lg btn-warning w-100" type="submit" name="reject" value="Cancel Request">
                                    </div>
                                </div>

                            </form>
                        </div>
                        @endif

                        
                    </div>

                </div>

            </div>
            
        </div>
    </div>


    <!-- Contract Modal -->
    <form action="" method="POST">
        <div class="modal modal-lg fade" id="contract_modal" tabindex="-1" aria-labelledby="contract modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Contract</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="card-text pt-3 pb-5">
                            <h6><u>Content:</u></h6>
                            <p class="mb-5">
                                {{ $contract[0]->content }}
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
                                        <td class="bg-white">-</td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Deposit Payment</th>
                                        <td class="bg-white">RM {{ number_format($contract[0]->deposit_price, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Monthly Payment</th>
                                        <td class="bg-white">RM {{ number_format($contract[0]->monthly_price, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="container-fluid pt-5">
                                <div class="row justify-content-between">
                                    <div class="col-12 col-md-6 col-lg-5 mb-5 mb-lg-0">
                                        <h6 class="pb-5"><u>Owner Signature:</u></h6>
                                        <img class="img-fluid" src="{{ asset('image/contract/'. $contract[0]->owner_signature) }}" alt="">
                                        <hr class="mt-5">
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-5">
                                        <h6 class="pb-5"><u>Tenant Signature:</u></h6>
                                        <img class="img-fluid x-upload-image" src="" alt="">
                                        <hr class="mt-5">
                                        <input class="form-control x-input-image" type="file" src="" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer hstack">
                        <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">Sign</button>
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @include('../base/dashboard/dashboard_script')
    <script src="{{ asset('vendor/xande/scripting.js') }}"></script>

</body>
</html>