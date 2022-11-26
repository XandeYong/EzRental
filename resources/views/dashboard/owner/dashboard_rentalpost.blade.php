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
                                                    <img class="x-image-modal card-img-top img-fluid img-thumbnail rounded" src="{{ asset('image/post/'. $images[$i]->image) }}" alt="{{ $images[$i]->image }}">
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
                                        <div class="col-12">
                                            <h5><u>Criterias:</u></h5>

                                            @if (!$criterias->isEmpty())
                                                <div>
                                                    @foreach ($criterias as $criteria)
                                                        <span class="btn bg-light border-dark m-1 cursor-default">
                                                            {{ $criteria->name }} 
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else 
                                                <div>
                                                    <span class="btn bg-light border-dark cursor-default w-100 text-start">
                                                        There is no criteria being selected.
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    <div id="description" class="row mb-3">
                                        <div class="col-12">
                                            <h5><u>Description:</u></h5>
                                            <p class="bg-light rounded border-black-t-1 border-1 p-2">
                                                {!! nl2br(e($post->description)) !!}
                                            </p>
                                        </div>
                                        
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
                                                        <th scope="row" class="w-25">Room Size</th>
                                                        <td class="w-75">{{ ucfirst(trans($post->room_size)) }}</td>
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
                                                                        <p>{!! nl2br(e($comment->message)) !!}</p>
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
                                    <div class="sidenav-container">

                                        <div id="control_panel" class="sidenav-item mb-4">
                                            <div class="item-header p-1 ps-3">
                                                <h4>Control Panel</h4>
                                            </div>
    
                                            <div class="item-body px-3 pb-2 pt-3">
                                                <div class="mb-2">
                                                    <a href="{{ URL('/dashboard/room_rental_post/maintenance_request/' . Crypt::encrypt($post->post_id)) }}">
                                                        <button class="btn btn-outline-dark w-100">
                                                            Maintenance Request
                                                        </button>
                                                    </a>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <a href="{{ URL('/dashboard/rentalpost/payment/indexForOwner/' . Crypt::encrypt($post->post_id)) }}">
                                                        <button class="btn btn-outline-dark w-100">
                                                            Payment History
                                                        </button>
                                                    </a>
                                                </div>
    
                                                <div class="mb-2">
                                                    <a href="{{ route('dashboard.owner.room_rental_post.contract.list', ['postID' => Crypt::encrypt($post->post_id)]) }}">
                                                        <button class="btn btn-outline-dark w-100">
                                                            Contract
                                                        </button>
                                                    </a>
                                                </div>

                                                @if (!empty($renting))
                                                    @php
                                                        $color = 'btn-primary';
                                                        $title = 'The tenant of this post has agree to renew the contract.';
                                                        if ($renting->renew_contract == 'yes') {
                                                            $color = 'btn-success';
                                                            $title = 'The contract will now renew after its expired.';
                                                        } elseif ($renting->renew_contract == 'no') {
                                                            $color = 'btn-secondary';
                                                            $title = 'Click to agree renew contract';
                                                        } elseif ($renting->renew_contract == 'o_agree') {
                                                            $title = 'The owner of this post has agree to renew the contract.';
                                                        }
                                                    @endphp

                                                    <div class="mb-2">
                                                        <button class="btn w-100 {{ $color }}" title="{{ $title }}" data-bs-toggle="modal" data-bs-target="#renew_contract_modal">
                                                            Renew Contract
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div id="setting" class="sidenav-item mb-3">
                                            <div class="item-header p-1 ps-3">
                                                <h4>Setting</h4>
                                            </div>

                                            @php
                                                if ($post->status == 'available') {
                                                    $param = ['postID' => Crypt::encrypt($post->post_id)];

                                                    $criteriaRoute = 'href=' . route('dashboard.owner.room_rental_post.criteria', $param);
                                                    $editRoute = 'href=' . route('dashboard.owner.room_rental_post.edit_form', $param);
                                                    $deleteRoute = 'href=' . route('dashboard.owner.room_rental_post.delete', $param);
                                                        
                                                    $criteriaTitle = "Edit this post's criteria.";
                                                    $editTitle = 'Edit this post.';
                                                    $deleteTitle = 'Delete this post.';
                                                    
                                                } else {
                                                    $status = 'disabled';
                                                }
                                            @endphp
    
                                            <div class="item-body px-3 pb-2 pt-3">
                                                
                                                <div class="mb-2">
                                                    <a {{ $criteriaRoute ?? '' }} title="{{ $criteriaTitle ?? 'Only post with "available" status can edit its criteria.' }}">
                                                        <button class="btn btn-outline-info w-100" {{ $status ?? '' }}>
                                                            Criteria
                                                        </button>
                                                    </a>
                                                </div>

                                                <div class="mb-2">
                                                    <a {{ $editRoute ?? '' }} title="{{ $editTitle ?? 'Only post with "available" status can be edit.' }}">
                                                        <button class="btn btn-outline-primary w-100" {{ $status ?? '' }}>
                                                            Edit Post
                                                        </button>
                                                    </a>
                                                </div>
    
                                                <div class="mb-2">
                                                    <a {{ $deleteRoute ?? ''}} title="{{ $deleteTitle ?? 'Only post with "available" status can be delete.' }}" x-confirm="Are you sure you want to delete this room rental post?">
                                                        <button class="btn btn-outline-danger w-100" {{ $status ?? '' }}>
                                                            Delete Post
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
    </div>

    @if (!empty($renting))
        @php
            $buttonText = "Agree";
            $confirm = "Are you sure you want to agree on renewing the contract?";
            $message = "
                Click to agree renew the contract after its expired date.
            ";

            if ($renting->renew_contract == 'yes') {
                $buttonText = "Cancel";
                $confirm = "Are you sure you want to cancel on renewing the contract?";
                $message = "This contract will now auto renew after its expired date.";

            } elseif ($renting->renew_contract == 'no') {
                $message = "Click to agree renew the current contract after its expired date.";

            } elseif ($renting->renew_contract == 'o_agree' && session()->get('account')['role'] == 'O') {
                $buttonText = "Cancel";
                $confirm = "Are you sure you want to cancel on renewing the contract?";
                $message = "
                    You have already agree on renewing the contract after the contract reach its expired date,
                    now wait for the tenant to agree on it, or politely contact the tenant to agree on it.
                ";

            } elseif ($renting->renew_contract == 't_agree' && session()->get('account')['role'] == 'T') {
                $buttonText = "Cancel";
                $confirm = "Are you sure you want to cancel on renewing the contract?";
                $message = "
                    You have already agree on renewing the contract after the contract reach its expired date,
                    now wait for the owner to agree on it, or politely contact the owner to agree on it.
                ";

            } elseif ($renting->renew_contract == 'o_agree') {
                $message = "
                    The owner of this post has already agree to renew the contract, 
                    you can agree to renew the contract by clicking the agree button below. 

                    After the contract been agree by both parties,
                    the contract will auto renew after the expired date of the contract.
                ";

            } elseif ($renting->renew_contract == 't_agree') {
                $message = "
                    The tenant of this post has already agree to renew the contract,
                    you can agree to renew the contract by clicking the agree button below.

                    After the contract been agree by both parties,
                    the contract will auto renew after the expired date of the contract.
                ";
            }
        @endphp
        <!--  Renew Contract Modal -->
        <div class="modal modal-lg fade" id="renew_contract_modal" tabindex="-1" aria-labelledby="renew contract modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                    <form class="x-form" action="{{ route('renting.contract.renew_contract', ['rentingID' => Crypt::encrypt($renting->renting_id)]) }}" method="GET" 
                        x-confirm="{{ $confirm }}">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Renew Contract</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div>
                                <p class="text-center">{!! nl2br(e($message)) !!}</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button id="visit_appointment_submit" type="submit" class="btn btn-primary">{{ $buttonText }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

    <div id="x-image-modal">
        <span class="close">&times;</span>
        <img id="x-image" class="img-fluid bg-color-white-t-20">
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
