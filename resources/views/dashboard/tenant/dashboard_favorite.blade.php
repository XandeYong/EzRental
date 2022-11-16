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
                            <h3 >There was no favourite found.</h3>
                        </div>
                    @else
                            {{-- For loop records --}}
                            @foreach ($favoritePosts as $favoritePost)


                            <div class="card mb-4">
                                <div class="d-flex bg-warning align-items-center">
                                    <a class="w-100 me-auto no-deco text-dark" href="{{ route('rental_post_list.rental_post', ['post_id' => $favoritePost->post_id]) }}">
                                        <div class="row me-auto px-3 w-100 align-items-center">
                                            <div class="col-12 col-sm">
                                                <h3 class="mb-0">
                                                    {{ $favoritePost->title }}
                                                </h3>
                                            </div>
        
                                            <div class="col-12 col-sm">
                                                <h4 class="mb-0 text-sm-end">
                                                    {{ $favoritePost->status }}
                                                </h4>
                                            </div>
                                        </div>
                                    </a>
    
                                    <div class="bg-white h-100 py-4 px-3 px-sm-4">
                                        <button type="button" class="btn-close" aria-label="Close" onclick="window.location.href ='{{ URL('/dashboard/favorite/removeFavorite/' .  Crypt::encrypt($favoritePost->post_id)) }}';"></button> {{-- need edit to cover whole box --}}
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
