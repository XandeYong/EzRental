<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Room Rental Post List</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_index.css') }}">
</head>

<body>

    @include('../base/dashboard/dashboard_sidebar')

    <div id="wrapper">
        <div class="container-fluid">
            @include('../base/dashboard/dashboard_header')

            <div id="content" class="row justify-content-center">
                <div class="col col-sm-10 col-md-8 col-lg-10 pb-4">

                    @if ($posts->isEmpty())

                        <div class="text-center">
                            <h3 >There was no room rental post found.</h3>
                        </div>

                    @else
                        @foreach ($posts as $post)
                            
                            <a href="{{ route('dashboard.owner.room_rental_post', ['post_id' => $post->post_id]) }}" class="no-deco text-dark">
                                <div class="card mb-4">
                                    <div class="d-flex bg-color-powderblue rounded align-items-center py-4">
                                        <div class="row me-auto px-3 w-100 align-items-center" >
                                            <div class="col-12 col-sm">
                                                <h3 class="mb-0">
                                                    {{ $post->title }}
                                                </h3>
                                            </div>

                                            <div class="col-12 col-sm">
                                                <h6 class="mb-0 text-sm-end pb-2">
                                                    Date: {{ date('Y-m-d', strtotime($post->created_at)) }}
                                                </h6>
                                                <h4 class="mb-0 text-sm-end">
                                                    {{ Str::ucfirst($post->status) }}
                                                </h4>
                                            </div>
                                        </div>
                    
                                    </div>
                                </div>
                            </a>
                        
                        @endforeach
                    @endif

                    @if (isset($button))

                        <div class="d-flex justify-content-center d-block d-lg-none">
                            <div class="fixed-bottom-button">
                                <a href="{{ $button['link'] }}">
                                    <button class="btn btn-lg btn-success px-3 px-sm-5">{{ $button['name'] }}</button>
                                </a>
                            </div>
                        </div>
                        
                    @endif

                </div>
            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
