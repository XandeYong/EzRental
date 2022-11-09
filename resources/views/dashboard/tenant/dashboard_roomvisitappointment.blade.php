
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
                        @for ($i = 0; $i < count($paymentDetails); $i++)
                            
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-responsive table-light">
                                    <thead class="table-info">
                                        <tr>
                                            <th scope="col" colspan="4">
                                                <h5><u>{{ $paymentDetailsName[$i] }}</u></h5>    
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="w-25">Request ID</th>
                                            <td class="bg-white">{{ $paymentDetails[$i]->payment_id }}</td> 

                                            <th scope="row" class="w-25">Request date</th>
                                            <td class="bg-white w-25">{{ $paymentDetails[$i]->paid_date }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="">Post ID</th>
                                            <td class="bg-white">{{ $paymentDetails[$i]->renting_id }}</td>

                                            <th scope="row">Status</th>
                                            <td class="bg-white">{{ $paymentDetails[$i]->status }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Price</th>
                                            <td colspan="3" class="bg-white">{{ $paymentDetails[$i]->payment_method }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Start date</th>
                                            <td colspan="3" class="bg-white">{{ $paymentDetails[$i]->payment_type }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">End date</th>
                                            <td colspan="3" class="bg-white">RM {{ number_format($paymentDetails[$i]->amount, 2) }}</td>
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