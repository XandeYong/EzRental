
<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Favorite</title>
    
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

                    @for ($i = 0; $i < 100; $i++)
                        <div class="card mb-4">
                            <div class="d-flex bg-warning align-items-center">
                                <div class="row me-auto px-3 w-100 align-items-center">
                                    <div class="col-12 col-sm">
                                        <h3 class="mb-0">
                                            PV13-A-21-1
                                        </h3>
                                    </div>

                                    <div class="col-12 col-sm">
                                        <h4 class="mb-0 text-sm-end">
                                            Reserved
                                        </h4>
                                    </div>
                                </div>
                                
                                <div class="bg-white h-100 py-4 px-3 px-sm-4">
                                    <button type="button" class="btn-close" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endfor

                </div>

            </div>
            
        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>
</html>