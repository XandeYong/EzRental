<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Create Maintenance Request</title>
    
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
                                    Et vel et et nisi voluptates minus dignissimos tempora aut. 
                                    Magnam dolorem aut tempora. Occaecati minus enim repellat et excepturi in. 
                                    Cum necessitatibus error consectetur eveniet eum. 
                                    Quaerat quia fugiat placeat adipisci accusantium voluptatem sit voluptate. 
                                    Aut corrupti commodi culpa consequatur in vitae explicabo. Quia laborum sit quam ad.
                                    Ducimus expedita et voluptatum et omnis minus et reprehenderit dicta. 
                                    Voluptatem ipsam fugiat odio aut a dolore. Debitis quia voluptatibus enim.
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
                                            <td class="bg-white">2023-04-28</td> 
                                        </tr>
                                        <tr>
                                            <th scope="row">Deposit Payment</th>
                                            <td class="bg-white">RM 2250</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Monthly Payment</th>
                                            <td class="bg-white">RM 900</td>
                                        </tr>
                                    </tbody>
                                </table>
    
                                <div class="container-fluid pt-5">
                                    <div class="row justify-content-between">
                                        <div class="col-12 col-md-6 col-lg-5 mb-5 mb-lg-0">
                                            <h6><u>Owner Signature:</u></h6>
                                            <img class="img-fluid border-bottom-3" src="{{ asset('image/contract/CT1_O_sign.png') }}" alt="">
                                        </div>
    
                                        <div class="col-12 col-md-6 col-lg-5">
                                            <h6><u>Tenant Signature:</u></h6>
                                            <img class="img-fluid border-bottom-3" src="{{ asset('image/contract/CT1_T_sign.png') }}" alt="">
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
