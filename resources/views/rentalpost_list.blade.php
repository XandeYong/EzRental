<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Rental Post List</title>
    @include('base/head')
    <link rel="stylesheet" href="{{asset('css/rentalpost_list.css')}}">
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

                            @if ( count($roomRentalPostLists) == 0 )
                            <div class="text-center">
                                <h3>There was no room rental post.</h3><br>
                            </div>
                            @else

                                @for ($i = 0; $i < count($roomRentalPostLists); $i++)
                                <div class="row mb-3">
                                    <a class="item no-deco c-black" href="{{ route('rental_post_list.rental_post', ['post_id' => $roomRentalPostLists[$i]->post_id]) }}">
                                        <div class="container">

                                            <div class="row align-items-baseline">
                                                <div class="col-7 col-lg-8">
                                                    <div class="text-start">
                                                        <h2 class="x-text-overflow-ellipsis">{{ $roomRentalPostLists[$i]->title }}</h3>
                                                    </div>

                                                    <div class="text-start c-teal">
                                                        <h4 class="x-text-overflow-ellipsis">{{ $roomRentalPostLists[$i]->condominium_name }}-{{ $roomRentalPostLists[$i]->block }}-{{ $roomRentalPostLists[$i]->floor }}-{{ $roomRentalPostLists[$i]->unit }}</h4>
                                                    </div>

                                                    <div class="text-start c-teal">
                                                        <h4 class="x-text-overflow-ellipsis">{{ ucfirst(trans($roomRentalPostLists[$i]->room_size)) }} Room</h4>
                                                    </div>
                                                </div>

                                                <div class="col-5 col-lg-4">
                                                    <div class="text-end">
                                                        <h5>Monthly Payment:</h5>
                                                    </div>

                                                    <div class="text-end c-teal">
                                                        <h1>RM {{ number_format($roomRentalPostLists[$i]->monthly_price, 2) }}</h1>
                                                    </div>
                                                </div>

                                                <div id="criteria_list" class="col-12 mt-2">
                                                    <div class="container">
                                                        <div class="row border-1 p-1 rounded">
                                                            <div class="col-12 x-scrollbar-x text-dark p-1 rounded">
                                                                <div class="p-1">

                                                                    @for ($j = 0; $j < 50; $j++)
                                                                    <span class="text-capitalize border-1 py-1 px-2 me-2 rounded">test</span>
                                                                    @endfor

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                @endfor

                            @endif   

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('base/footer')
    @include('base/script')

    {{-- For validate is filter at least one checkbox checked  --}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#filter').click(function() {
                checked = $("input[type=checkbox]:checked").length;
        
                if(!checked) {
                    alert("You must check at least one filter checkbox.");
                    return false;
                }
                
            });

            $("#reset_filter").click(function (e) { 
                $("#post_filter input").removeAttr("checked");
            });
        });
        
    </script>

</body>
</html>