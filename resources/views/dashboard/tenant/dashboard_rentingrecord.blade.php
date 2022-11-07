<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Current Renting Record</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_rentingrecord.css') }}">
    <link rel="stylesheet" href="{{asset('css/sidenav.css')}}">
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
                        <div class="row">
                            <div class="col-12 col-lg-8">

                                <div class="container-fluid">
                                    <div class="row mb-2">

                                        <div id="carousel_post_image" class="carousel slide" data-bs-ride="true">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carousel_post_image" data-bs-slide-to="0" class="active"
                                                    aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#carousel_post_image" data-bs-slide-to="1"
                                                    aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#carousel_post_image" data-bs-slide-to="2"
                                                    aria-label="Slide 3"></button>
                                                <button type="button" data-bs-target="#carousel_post_image" data-bs-slide-to="3"
                                                    aria-label="Slide 4"></button>
                                            </div>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img class="card-img-top img-fluid img-thumbnail rounded" src="{{ asset('image/condo.webp') }}" alt="Card image cap">
                                                </div>
        
                                                <div class="carousel-item">
                                                    <img class="card-img-top img-fluid img-thumbnail rounded" src="{{ asset('image/renting_post/PI1.png') }}" " alt="Card image cap">
                                                </div>
        
                                                <div class="carousel-item">
                                                    <img class="card-img-top img-fluid img-thumbnail rounded" src="{{ asset('image/renting_post/PI2.png') }}" " alt="Card image cap">
                                                </div>

                                                <div class="carousel-item">
                                                    <img class="card-img-top img-fluid img-thumbnail rounded" src="{{ asset('image/renting_post/PI3.jpg') }}" " alt="Card image cap">
                                                </div>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_post_image"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel_post_image"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <h5><u>Description:</u></h5>
                                        <p>
                                            Quos ab facilis et explicabo consequatur. 
                                            Occaecati facere impedit tempore non at natus. 
                                            Laboriosam distinctio suscipit nulla amet nesciunt quo quis. 
                                            Dolor eum quia necessitatibus sequi officia nobis et saepe quo. 
                                            Dolores similique ut est. Qui architecto facilis cupiditate commodi. 
                                            Reprehenderit sit vel. Id sunt quia facilis mollitia dolore tempora vitae repellendus. 
                                            Soluta reiciendis necessitatibus corrupti. Ipsam labore magni ut omnis. 
                                            Est harum atque et magnam suscipit esse minus. 
                                            Et minima rerum praesentium quas temporibus optio placeat inventore ut. 
                                            Ad nisi nam id assumenda qui ea tenetur magni. 
                                            Exercitationem eius officia aut sint quae quod laborum voluptate.
                                        </p>
                                    </div>

                                    {{-- sidebar --}}
                                    <div class="row mb-2">
                                        
                                        <div>
                                            <table class="table table-bordered table-responsive-sm table-light">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th scope="col" colspan="3">
                                                            <h5><u>Rental Info:</u></h5>    
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" class="w-25">Deposit</th>
                                                        <td class="w-75">RM 1725</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Monthly Payment</th>
                                                        <td class="w-75">RM 690</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Condominium</th>
                                                        <td class="w-75">PV 12</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Floor</th>
                                                        <td class="w-75">13</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Unit</th>
                                                        <td class="w-75">2</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Address</th>
                                                        <td class="w-75">PV 12-13-2, Danua Kota</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>


                            <div class="col-12 col-lg-4">
                                
                                <div class="sidenav-section">
                                    <div id="control_panel" class="sidenav-item mb-3">
                                        <div class="item-header p-1 ps-3">
                                            <h4>Control Panel</h4>
                                        </div>
                                        <div class="item-body px-3 mb-2 mt-3">
                                            <div class="mb-2">
                                                <a href="{{ route('dashboard.tenant.current_renting_record.maintenance_request_history') }}">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Maintenance Request
                                                    </button>
                                                </a>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <a href="{{ route('dashboard.tenant.current_renting_record.payment_history') }}">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Payment History
                                                    </button>
                                                </a>
                                            </div>

                                            <div class="mb-2">
                                                <a href="">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Contract
                                                    </button>
                                                </a>
                                            </div>

                                            <div id="payment" class="card my-3">
                                                <form action="" method="POST" class="h-100">

                                                    <div class="container-fluid h-100">    
                                                        <div class="row align-content-between h-100">

                                                            <div id="payment_header" class="card-header text-center bg-danger">
                                                                <h5 class="mb-0 text-light">
                                                                    Due Payment
                                                                </h5>
                                                            </div>

                                                            <div id="payment_list" class="col-12">
                                                                <div class="border-1 rounded py-1 px-2 mx-3 my-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" name="payment[]" type="checkbox" value="">
                                                                        <label class="form-check-label">
                                                                            July Monthly Payment
                                                                        </label>
                                                                    </div>
                                                                </div>
            
                                                                <div class="border-1 rounded py-1 px-2 mx-3 my-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" name="payment[]" type="checkbox" value="">
                                                                        <label class="form-check-label">
                                                                            Jun Monthly Payment
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                            <div id="payment_button" class="col-12">
                                                                <input class="card-footer btn btn-outline-danger" type="submit" value="Make Payment">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </form>
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
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
