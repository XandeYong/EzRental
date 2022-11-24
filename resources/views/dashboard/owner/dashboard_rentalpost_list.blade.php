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

                            @php
                                $color = 'text-primary';
                                if ($post->status == 'archived' || $post->status == 'expired' || $post->status == 'rejected') {
                                    $color = 'text-secondary';
                                } else if ($post->status == 'renting') {
                                    $color = 'text-success';
                                }
                            @endphp
                            
                            <a href="{{ route('dashboard.owner.room_rental_post', ['postID' => Crypt::encrypt($post->post_id)]) }}" class="no-deco text-dark">
                                <div class="card container mb-4 bg-color-powderblue py-4">
                                    <div class="row px-2">
        
                                        <div class="col-12 col-sm-6 col-lg-8">
                                            <div class="row">
                                                <h6 class="mb-0 text-sm-start pb-0 pb-sm-2 opacity-50">
                                                    {{ $post->post_id }}
                                                </h6>
        
                                                <h3 class="mb-0">
                                                    {{ $post->title }}
                                                </h3>
                                            </div>
                                        </div>
        
                                        <div class="col-12 col-sm-6 col-lg-4">
                                            <div class="row h-100">
                                                <h6 class="mb-0 h-25 text-sm-end pb-2">
                                                    Date: {{ date('Y-m-d', strtotime($post->created_at)) }}
                                                </h6>
        
                                                <div class="h-auto mt-2 mt-sm-0 mt-lg-2">
                                                    <h4 class="my-sm-auto text-sm-end {{ $color }}">
                                                        {{ Str::ucfirst($post->status) }}
                                                    </h4>
                                                </div>
                                                
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="row py-sm-2"></div>
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
