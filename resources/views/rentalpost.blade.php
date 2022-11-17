<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Rental Post List</title>
    @include('base/head')
    <link rel="stylesheet" href="{{ asset('css/rentalpost.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div id="wrapper">
        <div class="container-fluid">
            @include('base/navbar')

            <div id="content" class="pt-5 ">
                <div class="container mb-5">
                    <div class="row mt-lg-5 justify-content-center">

                        <div class="col-12 col-lg-10">

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-lg-8 mt-5 mt-lg-0">

                                        <div class="container-fluid">
                                            <div class="row mb-3">
                                                <h1><u>{{ $post[0]->title }}</u></h1>
                                            </div>

                                            {{-- Images --}}
                                            <div id="image" class="row mb-2">

                                                @if ($images->isEmpty())
                                                    <div id="no_image" class="text-center">
                                                        <img class="h-100 img-fluid img-thumbnail rounded"
                                                            src="{{ asset('image/image_not_found.png') }}"
                                                            alt="No image available">
                                                    </div>
                                                @else
                                                    <div id="carousel_post_image" class="carousel slide"
                                                        data-bs-ride="true">
                                                        <div class="carousel-indicators">

                                                            @if (count($images) > 1)
                                                                @for ($i = 0; $i < count($images); $i++)
                                                                    <button type="button"
                                                                        data-bs-target="#carousel_post_image"
                                                                        data-bs-slide-to={{ $i }}
                                                                        @if ($i == 0) class="active" @endif
                                                                        aria-current="true"
                                                                        aria-label="Slide {{ $i + 1 }}"></button>
                                                                @endfor
                                                            @endif

                                                        </div>

                                                        <div class="carousel-inner">

                                                            @for ($i = 0; $i < count($images); $i++)
                                                                <div
                                                                    @if ($i == 0) class="carousel-item active" @else class="carousel-item" @endif>
                                                                    <img class="card-img-top img-fluid img-thumbnail rounded"
                                                                        src="{{ asset('image/renting_post/' . $images[$i]->image) }}"
                                                                        alt="{{ $images[$i]->image }}">
                                                                </div>
                                                            @endfor

                                                        </div>

                                                        @if (count($images) > 1)
                                                            <button class="carousel-control-prev" type="button"
                                                                data-bs-target="#carousel_post_image"
                                                                data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button"
                                                                data-bs-target="#carousel_post_image"
                                                                data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="visually-hidden">Next</span>
                                                            </button>
                                                        @endif

                                                    </div>
                                                @endif
                                                <p><small class="text-secondary">POST ID:
                                                        {{ $post[0]->post_id }}</small></p>

                                            </div>

                                            {{-- Criterias --}}
                                            <div id="criteria" class="row mb-3">
                                                <h5><u>Criterias:</u></h5>

                                                @if (!$criterias->isEmpty())
                                                    <div>
                                                        @foreach ($criterias as $criteria)
                                                            <span class="btn bg-light border-dark m-1 cursor-default">
                                                                {{ $criteria->name }} </span>
                                                        @endforeach
                                                    </div>
                                                @endif

                                            </div>

                                            {{-- Description --}}
                                            <div id="description" class="row mb-3">
                                                <h5><u>Description:</u></h5>
                                                <p> {{ $post[0]->description }} </p>
                                            </div>

                                            <div id="rental_info" class="row mb-2">

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
                                                                <th scope="row" class="w-25">Post Title</th>
                                                                <td class="w-75">{{ $post[0]->title }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="w-25">Deposit</th>
                                                                <td class="w-75">RM
                                                                    {{ number_format($post[0]->deposit_price, 2) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="w-25">Monthly Payment</th>
                                                                <td class="w-75">RM
                                                                    {{ number_format($post[0]->monthly_price, 2) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="w-25">Condominium</th>
                                                                <td class="w-75">{{ $post[0]->condominium_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="w-25">Floor</th>
                                                                <td class="w-75">{{ $post[0]->floor }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="w-25">Unit</th>
                                                                <td class="w-75">{{ $post[0]->unit }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="w-25">Address</th>
                                                                <td class="w-75">{{ $post[0]->address }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="w-25">Post Owner</th>
                                                                <td class="w-75">{{ $post[0]->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="w-25">Post Status</th>
                                                                <td class="w-75 text-capitalize">{{ $post[0]->status }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>




                                            <div id="comment_section" class="row my-5">
                                                <div class="col-12">

                                                    <div id="comment_container">

                                                        <div id="comment_header" class="p-2">
                                                            <h5>Leave a Comment</h5>
                                                        </div>

                                                        <div id="comment_body">

                                                            <div id="post_comment" class="col-12 mb-3">
                                                                @php
                                                                    $route = '';
                                                                    $form = 'd-none';
                                                                    $button = '';
                                                                    $comment_guide = 'Please login to leave a comment.';
                                                                    if (session()->has('account')) {
                                                                        $comment_guide = 'You can only leave a comment if you rented this post once before.';
                                                                    }
                                                                    
                                                                    $cid = '';
                                                                    $rating = '';
                                                                    $comment = '';
                                                                    
                                                                    if ($access['comment'] == 'allow') {
                                                                        $route = 'rental_post_list.rental_post.create_comment';
                                                                        $form = '';
                                                                        $button = 'Rate & Comment';
                                                                    } elseif ($access['comment'] instanceof \Illuminate\Support\Collection && !$access['comment']->isEmpty()) {
                                                                        $route = 'rental_post_list.rental_post.update_comment';
                                                                        $form = '';
                                                                        $button = 'Update';
                                                                    
                                                                        $cid = $access['comment'][0]->comment_id;
                                                                        $rating = $access['comment'][0]->rating;
                                                                        $comment = $access['comment'][0]->message;
                                                                    }
                                                                @endphp

                                                                @if ($access['comment'] != 'forbidden')
                                                                    <form action="{{ route($route) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div id="post_comment_body" class="p-3">
                                                                            <div class="rating-error d-none">
                                                                                <div class="alert alert-danger fade show"
                                                                                    role="alert">
                                                                                    You must give a
                                                                                    <strong>Rating</strong> if you want
                                                                                    to comment.
                                                                                </div>
                                                                            </div>

                                                                            <input type="hidden" name="id"
                                                                                value="{{ $post[0]->post_id }}">
                                                                            <input type="hidden" name="cid"
                                                                                value="{{ $cid }}">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Rating<span
                                                                                        class="c-crimson">*</span></label>

                                                                                <div>
                                                                                    <div class="rating-group">
                                                                                        <label aria-label="1 star"
                                                                                            class="rating__label"
                                                                                            for="rating3-1">
                                                                                            <i
                                                                                                class="rating__icon rating__icon--star rating__icon--star-initial fa fa-star"></i>
                                                                                        </label>
                                                                                        <input class="rating__input"
                                                                                            name="rating"
                                                                                            id="rating3-1"
                                                                                            value="1"
                                                                                            type="radio"
                                                                                            @if ($rating == 1) checked @endif>

                                                                                        <label aria-label="2 stars"
                                                                                            class="rating__label"
                                                                                            for="rating3-2">
                                                                                            <i
                                                                                                class="rating__icon rating__icon--star rating__icon--star-initial fa fa-star"></i>
                                                                                        </label>
                                                                                        <input class="rating__input"
                                                                                            name="rating"
                                                                                            id="rating3-2"
                                                                                            value="2"
                                                                                            type="radio"
                                                                                            @if ($rating == 2) checked @endif>

                                                                                        <label aria-label="3 stars"
                                                                                            class="rating__label"
                                                                                            for="rating3-3">
                                                                                            <i
                                                                                                class="rating__icon rating__icon--star rating__icon--star-initial fa fa-star"></i>
                                                                                        </label>
                                                                                        <input class="rating__input"
                                                                                            name="rating"
                                                                                            id="rating3-3"
                                                                                            value="3"
                                                                                            type="radio"
                                                                                            @if ($rating == 3) checked @endif>

                                                                                        <label aria-label="4 stars"
                                                                                            class="rating__label"
                                                                                            for="rating3-4">
                                                                                            <i
                                                                                                class="rating__icon rating__icon--star rating__icon--star-initial fa fa-star"></i>
                                                                                        </label>
                                                                                        <input class="rating__input"
                                                                                            name="rating"
                                                                                            id="rating3-4"
                                                                                            value="4"
                                                                                            type="radio"
                                                                                            @if ($rating == 4) checked @endif>

                                                                                        <label aria-label="5 stars"
                                                                                            class="rating__label"
                                                                                            for="rating3-5">
                                                                                            <i
                                                                                                class="rating__icon rating__icon--star rating__icon--star-initial fa fa-star"></i>
                                                                                        </label>
                                                                                        <input class="rating__input"
                                                                                            name="rating"
                                                                                            id="rating3-5"
                                                                                            value="5"
                                                                                            type="radio" required
                                                                                            @if ($rating == 5) checked @endif>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="comment"
                                                                                    class="form-label">Comment<span
                                                                                        class="c-crimson">*</span></label>
                                                                                <textarea class="form-control" id="comment" name="message" placeholder="Leave a comment..." rows="3"
                                                                                    maxlength="255" required>{{ $comment }}</textarea>
                                                                            </div>
                                                                            <div class="mb-3 text-end">
                                                                                @if ($access['comment'] instanceof \Illuminate\Support\Collection)
                                                                                    <a class="btn btn-danger"
                                                                                        href="{{ route('rental_post_list.rental_post.delete_comment', ['comment_id' => $cid]) }}">Delete</a>
                                                                                @endif

                                                                                <input id="comment_submit_input"
                                                                                    type="submit" name="submit"
                                                                                    value="{{ $button }}"
                                                                                    class="btn btn-primary">
                                                                            </div>

                                                                        </div>
                                                                    </form>
                                                                @else
                                                                    <div class="post-comment-body p-3">
                                                                        <h5
                                                                            class="text-center border-1 rounded py-3 bg-danger text-white">
                                                                            {{ $comment_guide }}
                                                                        </h5>
                                                                    </div>
                                                                @endif

                                                            </div>

                                                            <div id="comments" class="px-3 p-4">
                                                                @if (!empty($comments))

                                                                    @foreach ($comments as $comment)
                                                                        @php
                                                                            $createdDate = explode(' ', $comment->created_at);
                                                                            $updatedDate = explode(' ', $comment->updated_at);
                                                                        @endphp

                                                                        <div class="post-user-comment mb-4">
                                                                            <div class="p-3">
                                                                                <div
                                                                                    class="p-u-c-header d-flex justify-content-between">
                                                                                    <div class="name">
                                                                                        <h5>{{ $comment->name }}</h5>
                                                                                    </div>
                                                                                    <div class="datetime">
                                                                                        <small><b>Created Date:</b>
                                                                                            {{ $createdDate[0] . ', ' . $createdDate[1] }}</small>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <h6>

                                                                                        <div class="rating-group-d">
                                                                                            @for ($i = 0; $i < 5; $i++)
                                                                                                @if ($i < $comment->rating)
                                                                                                    <label
                                                                                                        aria-label="1 star"
                                                                                                        class="rating__label-sm-d">
                                                                                                        <i
                                                                                                            class="rating__icon-d rating-orange fa fa-star"></i>
                                                                                                    </label>
                                                                                                @else
                                                                                                    <label
                                                                                                        aria-label="5 stars"
                                                                                                        class="rating__label-sm-d">
                                                                                                        <i
                                                                                                            class="rating__icon-d rating-grey fa fa-star"></i>
                                                                                                    </label>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </div>

                                                                                    </h6>
                                                                                </div>
                                                                                <hr />
                                                                                <div class="p-u-c-body">
                                                                                    <div class="comment">
                                                                                        <p>{{ $comment->message }}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="post-user-comment-updated-at text-end px-3 bg-light">
                                                                                <small><b>Updated:</b>
                                                                                    {{ $updatedDate[0] . ', ' . $updatedDate[1] }}</small>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach

                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    {{-- sidebar --}}
                                    <div class="sidenav-section col-12 col-lg-4">
                                        <div class="mt-0 mt-lg-3">

                                            <div id="Navigation" class="sidenav-item mb-3">
                                                <div class="item-header p-1 ps-3">
                                                    <h4>Navigation</h4>
                                                </div>

                                                <div class="item-body px-3 mb-2 mt-3">

                                                    <div class="mb-2">
                                                        <a href="#image">
                                                            <button class="btn btn-outline-primary w-100">
                                                                Image
                                                            </button>
                                                        </a>
                                                    </div>

                                                    <div class="mb-2">
                                                        <a href="#criteria">
                                                            <button class="btn btn-outline-primary w-100">
                                                                Criteria
                                                            </button>
                                                        </a>
                                                    </div>

                                                    <div class="mb-2">
                                                        <a href="#description">
                                                            <button class="btn btn-outline-primary w-100">
                                                                Description
                                                            </button>
                                                        </a>
                                                    </div>

                                                    <div class="mb-2">
                                                        <a href="#rental_info">
                                                            <button class="btn btn-outline-primary w-100">
                                                                Rental Info
                                                            </button>
                                                        </a>
                                                    </div>

                                                    <div class="mb-2">
                                                        <a href="#comment_section">
                                                            <button class="btn btn-outline-primary w-100">
                                                                Comment
                                                            </button>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>

                                            <div id="control_panel" class="sidenav-item mb-3">

                                                <div class="item-header p-1 ps-3">
                                                    <h4>Control Panel</h4>
                                                </div>

                                                <div class="item-body px-3 mb-2 mt-3">

                                                    <div class="mb-2">
                                                        <button type="button" id="contract_button"
                                                            class="btn btn-outline-dark w-100" data-bs-toggle="modal"
                                                            data-bs-target="#contract_modal">
                                                            Contract
                                                        </button>
                                                    </div>

                                                    @if (session()->has('account'))
                                                        <div class="mb-2">
                                                            <button type="button" id="visit_appointment_button"
                                                                class="btn btn-outline-dark w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#visit_appointment_modal">
                                                                Visit Appointment
                                                            </button>
                                                        </div>

                                                        <div class="mb-2">
                                                            <button type="button" id="negotiate_button"
                                                                class="btn btn-outline-dark w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#negotiate_modal">
                                                                Negotiate
                                                            </button>
                                                        </div>

                                                        <div class="mb-2">
                                                            <button type="button" id="rent_button"
                                                                class="btn btn-outline-dark w-100"
                                                                data-bs-toggle="modal" data-bs-target="#rent_modal">
                                                                Rent
                                                            </button>
                                                        </div>

                                                        @if (Session::has('account'))
                                                            @if (session()->get('account')->role == 'T')
                                                                <div class="mb-2">
                                                                    @if ($favorite->isEmpty())
                                                                        <button type="button" id="favorite_button"
                                                                            class="btn btn-outline-dark w-100"
                                                                            onclick="window.location.href ='{{ URL('/rental_post_list/rental_post/addOrRemoveFavorite/' . Crypt::encrypt($post[0]->post_id) . '/' . Crypt::encrypt('add')) }}';">
                                                                            Favorite
                                                                        </button>
                                                                    @else
                                                                        <button type="button" id="favorite_button"
                                                                            class="btn btn-outline-dark w-100"
                                                                            onclick="window.location.href ='{{ URL('/rental_post_list/rental_post/addOrRemoveFavorite/' . Crypt::encrypt($post[0]->post_id) . '/' . Crypt::encrypt('remove')) }}';">
                                                                            Unfavorite
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif

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

    <!-- Contract Modal -->
    <div class="modal modal-lg fade" id="contract_modal" tabindex="-1" aria-labelledby="contract modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Contract</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-text pt-3 pb-5">
                        <h6><u>Content:</u></h6>
                        <p class="mb-5">
                            {{ $contract[0]->content }}
                        </p>

                        <table class="table table-bordered table-responsive table-light mb-5">
                            <thead class="table-info">
                                <tr>
                                    <th scope="col" colspan="2">
                                        <h6><u>Contract Information</u></h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" class="w-25">Expired date</th>
                                    <td class="bg-white">-</td>
                                </tr>
                                <tr>
                                    <th scope="row">Deposit Payment</th>
                                    <td class="bg-white">RM {{ number_format($contract[0]->deposit_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Monthly Payment</th>
                                    <td class="bg-white">RM {{ number_format($contract[0]->monthly_price, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="container-fluid pt-5">
                            <div class="row justify-content-between">
                                <div class="col-12 col-md-6 col-lg-5 mb-5 mb-lg-0">
                                    <h6 class="pb-5"><u>Owner Signature:</u></h6>
                                    <hr class="mt-5">
                                </div>

                                <div class="col-12 col-md-6 col-lg-5">
                                    <h6 class="pb-5"><u>Tenant Signature:</u></h6>
                                    <hr class="mt-5">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('account'))

        @if ($access['appointment'] != 'forbidden')
            <!-- Visit Appointment Modal -->
            <div class="modal modal-lg fade" id="visit_appointment_modal" tabindex="-1"
                aria-labelledby="visit appointment modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <form action="{{ route('rental_post_list.rental_post.create_visit_appointment') }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to create room visit appointment?');">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Visit Appointment</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <input type="hidden" name="id" value="{{ $post[0]->post_id }}">
                                <div class="mb-3">
                                    <label for="visit_appointment_datetime" class="form-label">Date & Time</label>
                                    <input type="datetime-local" class="form-control" name="datetime"
                                        id="visit_appointment_datetime" required>
                                    @if ($errors->has('datetime'))
                                        <span class="c-red-error">*{{ $errors->first('datetime') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="visit_appointment_note" class="form-label">Note</label>
                                    <textarea class="form-control" name="note" id="visit_appointment_note" placeholder="Leave a message..."
                                        rows="3" maxlength="255"></textarea>
                                    @if ($errors->has('note'))
                                        <span class="c-red-error">*{{ $errors->first('note') }}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create Appointment</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        @endif

        @if ($access['negotiate'] != 'forbidden')
            <!-- Negotiate Modal -->
            <div class="modal modal-lg fade" id="negotiate_modal" tabindex="-1" aria-labelledby="negotiate modal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <form action="{{ route('rental_post_list.rental_post.create_negotiation') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Negotiate</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <input type="hidden" name="id" value="{{ $post[0]->post_id }}">
                                <div class="mb-3">
                                    <label for="negotiate_monthly_payment" class="form-label">Monthly Payment</label>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text">RM</span>
                                        <input type="number" class="form-control hideArrow" name="price"
                                            id="negotiate_monthly_payment"
                                            aria-label="Amount (to the nearest Ringgit)" value="0"
                                            min="1">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="negotiate_message" class="form-label">Message</label>
                                    <textarea class="form-control" name="message" id="negotiate_message" placeholder="Leave a message..."
                                        rows="3" maxlength="255"></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create Negotiation</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        @endif

        @if ($access['rent'] != 'forbidden')
            <!-- Rent Modal -->
            <div class="modal modal-lg fade" id="rent_modal" tabindex="-1" aria-labelledby="rent modal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">

                        <form action="{{ route('rental_post_list.rental_post.create_rent_request') }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to create renting request?');">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Rent</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <input type="hidden" name="id" value="{{ $post[0]->post_id }}">
                                <div class="mb-3">
                                    <label class="form-label">Monthly Payment</label>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text">RM</span>
                                        <input type="number" class="form-control disabled hideArrow"
                                            value="{{ number_format($contract[0]->monthly_price, 2) }}" readonly
                                            disabled>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="rent_start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date"
                                        id="rent_start_date" required>
                                    @if ($errors->has('start_date'))
                                        <span class="c-red-error">*{{ $errors->first('start_date') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="rent_end_date"
                                        required>
                                    @if ($errors->has('end_date'))
                                        <span class="c-red-error">*{{ $errors->first('end_date') }}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create Rent Request</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        @endif
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        <?php
            if ($errors->has('datetime') || $errors->has('note')){
             ?>
        $(document).ready(function() {
            $('#visit_appointment_modal').modal('show')
        });
        <?php
             }
             ?>

        <?php
            if ($errors->has('start_date') || $errors->has('end_date')){
             ?>
        $(document).ready(function() {
            $('#rent_modal').modal('show')
        });
        <?php
             }
             ?>
    </script>


    <script>
        var access = {!! json_encode($access) !!};
    </script>

    @include('base/footer')
    @include('base/script')
    <script src="{{ asset('js/rentalpost.js') }}"></script>

</body>

</html>
