
<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Recommentation</title>
    
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

                    <div class="container-fluid">
                        <div class="row title text-center">
                            <h3><u>Selected Filter Criteria List</u></h3>
                        </div>

                        <ul class="border-1 rounded mt-3 mb-5 bg-light">
                            <div class="row mt-3 justify-content-center">

                                @for ($i = 0; $i < 100; $i++)
                                    <div class="col-12 col-md-4 col-lg-3 col-xl-3 px-3 py-2">
                                        <li>
                                            <h5>Big Medium Room</h5>
                                        </li>
                                    </div>    
                                @endfor
                            
                            </div>        
                        </ul>

                        <div class="d-flex justify-content-center">
                            <div class="fixed-bottom-button">
                                <a href="{{ route('dashboard.tenant.recommentation.select') }}">
                                    <button class="btn btn-lg btn-success px-3 px-sm-5">Select Criteria</button>
                                </a>
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