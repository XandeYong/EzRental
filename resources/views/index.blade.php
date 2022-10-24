

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Home</title>
    @include('base/head')
    <link rel="stylesheet" href="{{asset('css/index.css')}}" />
    <link rel="stylesheet" href="{{asset('css/sidenav.css')}}" />
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid pt-5">
            @include('base/navbar')

            <div class="row background-image-1">
                <div class="container mt-3 mt-sm-5">

                    <div class="row">
                        <div class="col">
                            
                            <div class="welcome w-25 py-1 py-sm-2 py-md-3">
                                <h2 class="c-white text-center">Welcome to EzRental</h2>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>

    @include('base/footer')
    @include('base/script')

</body>
</html>
