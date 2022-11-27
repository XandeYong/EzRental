<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Favorite</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_index.css') }}">
</head>

<body>


    @include('../base/dashboard/dashboard_sidebar')

    <div id="wrapper">
        <div class="container-fluid">
            @include('../base/dashboard/dashboard_header')

            <div id="content" class="row justify-content-center">

                {{-- Code here --}}
                <div class="col col-sm-10 col-md-8 col-lg-10">

                    {{-- Check is the favorite empty --}}
                    @if ($favoritePosts->isEmpty())
                        <div class="text-center">
                            <h3 >There was no favorite found.</h3>
                        </div>
                    @else

                        {{-- For loop records --}}
                        @foreach ($favoritePosts as $favoritePost)

                        @php
                            $color = 'text-primary';
                            if ($favoritePost->status == 'renting' || $favoritePost->status == 'reserve') {
                                $color = 'text-danger';
                            }
                        @endphp

                        <div class="card mb-4 bg-warning">
                            <div class="container-fluid">
                                <div class="row">

                                    <a href="{{ route('rental_post_list.rental_post', ['post_id' => $favoritePost->post_id]) }}" class="col-9 col-sm-10 col-lg-11 text-dark no-deco">
                                        <div class="row pt-2 pb-1">
                                            <h6 class="mb-0 text-sm-start pb-0 pb-sm-2 opacity-50">
                                                {{ $favoritePost->post_id }}
                                            </h6>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm">
                                                <h3 class="mb-0">
                                                    {{ $favoritePost->title }}
                                                </h3>
                                            </div>

                                            <div class="col-12 col-sm">
                                                <h4 class="mb-0 text-sm-end {{ $color }}">
                                                    {{ ucfirst(trans($favoritePost->status)) }}
                                                </h4>
                                            </div>
                                        </div>
                                        
                                        <div class="row py-3"></div>
                                    </a>

                                    <a href="{{ URL('/dashboard/favorite/removeFavorite/' .  Crypt::encrypt($favoritePost->post_id)) }}" class="col-3 col-sm-2 col-lg-1 text-center text-dark no-deco btn btn-outline-danger border-radius-left-0 bg-light">
                                        <div class="d-flex justify-content-center align-items-center h-100 w-100">
                                            <h3 class="m-0">
                                                &#10005;
                                            </h3>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>

                        @endforeach

                    @endif


                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
