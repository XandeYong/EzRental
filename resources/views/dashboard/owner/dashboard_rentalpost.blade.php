<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Room Rental Post</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/rentalpost.css') }}">
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
                            <div class="col-12 col-lg-8 mt-5 mt-lg-0">

                                <div class="container-fluid">
                                    <div class="row mb-3">
                                        <h1><u>{{ $post->title }}</u></h1>
                                    </div>

                                    {{-- Images --}}
                                    <div id="image" class="row mb-2">

                                        @if ($images->isEmpty())
                                             <div id="no_image" class="text-center">  
                                                <img class="h-100 img-fluid img-thumbnail rounded" src="{{ asset('image/image_not_found.png') }}" alt="No image available">
                                             </div>
                                        @else

                                        <div id="carousel_post_image" class="carousel slide" data-bs-ride="true">
                                            <div class="carousel-indicators">

                                                @if (count($images) > 1)
                                                    @for ($i = 0; $i < count($images); $i++)
                                                    <button type="button" data-bs-target="#carousel_post_image" data-bs-slide-to={{ $i }}  @if ($i==0) class="active" @endif
                                                        aria-current="true" aria-label="Slide {{ $i + 1 }}"></button>
                                                    @endfor
                                                @endif

                                            </div>

                                            <div class="carousel-inner">

                                                @for ($i = 0; $i < count($images); $i++)
                                                <div @if ($i==0) class="carousel-item active" @else class="carousel-item" @endif >
                                                    <img class="card-img-top img-fluid img-thumbnail rounded" src="{{ asset('image/renting_post/'. $images[$i]->image) }}" alt="{{ $images[$i]->image }}">
                                                </div>
                                                @endfor

                                            </div>

                                            @if (count($images) > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_post_image" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel_post_image" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                            @endif

                                        </div>
                                        @endif
                                        <p><small class="text-secondary">POST ID: {{ $post->post_id }}</small></p>

                                    </div>

                                    {{-- Criterias --}}
                                    <div id="criteria" class="row mb-3">
                                        <h5><u>Criterias:</u></h5>

                                        @if (!$criterias->isEmpty())
                                            <div>
                                            @foreach ($criterias as $criteria)
                                                <span class="btn bg-light border-dark m-1 cursor-default"> {{ $criteria->name }} </span>
                                            @endforeach
                                            </div>        
                                        @endif

                                    </div>

                                    {{-- Description --}}
                                    <div id="description" class="row mb-3">
                                        <h5><u>Description:</u></h5>
                                        <p> {{ $post->description }} </p>
                                    </div>

                                    <div id="rental_info" class="row mb-2">
                                        
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-light">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th scope="col" colspan="3">
                                                            <h5><u>Rental Info:</u></h5>    
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" class="w-25">Post Title</th>
                                                        <td class="w-75">{{ $post->title }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Deposit</th>
                                                        <td class="w-75">RM {{ number_format($post->deposit_price, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Monthly Payment</th>
                                                        <td class="w-75">RM {{ number_format($post->monthly_price, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Condominium</th>
                                                        <td class="w-75">{{ $post->condominium_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Floor</th>
                                                        <td class="w-75">{{ $post->floor }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Unit</th>
                                                        <td class="w-75">{{ $post->unit }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Address</th>
                                                        <td class="w-75">{{ $post->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Post Owner</th>
                                                        <td class="w-75">{{ $post->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Post Status</th>
                                                        <td class="w-75 text-capitalize">{{ $post->status }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>

                                    
                                    <div id="comment_section" class="row my-5">
                                        <div class="col-12">

                                            <div id="comment_container">

                                                <div id="comment_header" class="p-2">
                                                    <h5>Comment</h5>
                                                </div>

                                                <div id="comment_body">
                                                    
                                                    <div id="comments" class="px-3 p-4">
                                                    @if (!empty($comments[0]))
    
                                                        @foreach ($comments as $comment)
                                                        @php
                                                            $createdDate = explode(' ', $comment->created_at);
                                                            $updatedDate = explode(' ', $comment->updated_at);
                                                        @endphp
                                                        
                                                        <div class="post-user-comment mb-4">
                                                            <div class="p-3">
                                                                <div class="p-u-c-header d-flex justify-content-between">
                                                                    <div class="name">
                                                                        <h5>{{ $comment->name }}</h5>
                                                                    </div>
                                                                    <div class="datetime">
                                                                        <small><b>Created Date:</b> {{ $createdDate[0] . ', ' . $createdDate[1] }}</small>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <h6>

                                                                        <div class="rating-group-d">
                                                                        @for ($i = 0; $i < 5; $i++)

                                                                            @if ($i < $comment->rating)
                                                                            <label aria-label="1 star" class="rating__label-sm-d">
                                                                                <i class="rating__icon-d rating-orange fa fa-star"></i>
                                                                            </label> 
                                                                            @else
                                                                            <label aria-label="5 stars" class="rating__label-sm-d">
                                                                                <i class="rating__icon-d rating-grey fa fa-star"></i>
                                                                            </label>
                                                                            @endif

                                                                        @endfor
                                                                        </div>

                                                                    </h6>
                                                                </div>
                                                                <hr/>
                                                                <div class="p-u-c-body">
                                                                    <div class="comment">
                                                                        <p>{{ $comment->message }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <div class="post-user-comment-updated-at text-end px-3 bg-light">
                                                                <small><b>Updated:</b> {{ $updatedDate[0] . ', ' . $updatedDate[1] }}</small>
                                                            </div>
                                                        </div>
                                                        
                                                        @endforeach

                                                    @else
    
                                                        <div class="text-center fs-20px">There is no comment at the moment</div>

                                                    @endif
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>


                            {{-- sidebar --}}
                            <div class="col-12 col-lg-4">
                                
                                <div class="sidenav-section">
                                    <div id="control_panel" class="sidenav-item mb-3">
                                        <div class="item-header p-1 ps-3">
                                            <h4>Control Panel</h4>
                                        </div>
                                        <div class="item-body px-3 mb-2 mt-3">
                                            <div class="mb-2">
                                                <a href="{{ URL('/dashboard/rentingrecord/maintenancerequest/indexForOwner/' . Crypt::encrypt($post->post_id)) }}">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Maintenance Request
                                                    </button>
                                                </a>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <a href="{{ URL('/dashboard/rentingrecord/payment/indexForOwner/' . Crypt::encrypt($post->post_id)) }}">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Payment History
                                                    </button>
                                                </a>
                                            </div>

                                            <div class="mb-2">
                                                <a href="{{ "" }}">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Contract
                                                    </button>
                                                </a>
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
