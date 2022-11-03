
@if (isset($user))

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Profile</title>
    
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
                    

                </div>

                
            </div>
            
        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>
</html>

@else
    <script>window.location = "/";</script>
@endif