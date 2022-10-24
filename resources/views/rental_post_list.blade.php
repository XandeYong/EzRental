<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Rental Post List</title>
    @include('base/head')
    <link rel="stylesheet" href="{{asset('css/rental_post.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidenav.css')}}">
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid">
            @include('base/navbar')

            <div id="content" class="pt-5 ">
                <div class="container mb-5">
                    <div class="row mt-lg-5">
                        @include('sidenav/rental_list_sidenav')

                        <div class="col col-lg-8">
                            <div class="container-fluid mt-5 mt-lg-0">

                                @for ($i = 0; $i < 5; $i++)
                                <div class="row mb-3">
                                    <button class="item">
                                        <div class="container">

                                            <div class="row align-items-baseline">
                                                <div class="col-8">
                                                    <div class="text-start">
                                                        <h2>PV21 small room for rent</h3>    
                                                    </div>

                                                    <div class="text-start c-blue-1">
                                                        <h4>PV21-13-2</h4>
                                                    </div>

                                                    <div class="text-start c-blue-1">
                                                        <h4>Small Room</h4>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="text-end">
                                                        <h5>Monthly Payment:</h5>
                                                    </div>

                                                    <div class="text-end c-teal">
                                                        <h1>RM 690</h1>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </button>
                                </div>
                                @endfor

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