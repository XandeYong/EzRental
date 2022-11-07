
<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | recommendation</title>
    
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

                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-responsive table-light">
                                    <thead class="table-info">
                                        <tr>
                                            <th scope="col" colspan="4">
                                                <h5><u>Payment:</u></h5>    
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="w-25">Deposit</th>
                                            <td class="bg-white">RM 1725</td>

                                            <th scope="row" class="w-25">Payment date</th>
                                            <td class="bg-white">1/5/2022</td>
                                            
                                        </tr>
                                        <tr>
                                            <th scope="row" class="">Monthly Payment</th>
                                            <td class="bg-white">RM 690</td>

                                            <th scope="row">Status</th>
                                            <td class="bg-white">Paid</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Condominium</th>
                                            <td colspan="3" class="bg-white">PV 12</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Floor</th>
                                            <td colspan="3" class="bg-white">13</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Unit</th>
                                            <td colspan="3" class="bg-white">2</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td colspan="3" class="bg-white">PV 12-13-2, Danua Kota</td>
                                        </tr>
                                    </tbody>
                                </table>
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