
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

                        
                    </div>

                </div>

            </div>
            
        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>
</html>