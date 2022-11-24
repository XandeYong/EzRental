<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Create Maintenance Request</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_index.css') }}">
</head>

<body>


    @include('../base/dashboard/dashboard_sidebar')

    <div id="wrapper">
        <div class="container-fluid">
            @include('../base/dashboard/dashboard_header')

            <form class="x-form x-form-validation" action="{{ route('dashboard.owner.room_rental_post.criteria.update', ['postID' => $postID]) }}" method="post"
                x-confirm="Confirm update this post's criteria?">
                @csrf 
                <div id="content" class="row justify-content-center">

                    <div class="col col-sm-10 col-md-8 col-lg-10 rounded border-3 border-black-t-1 p-3">

                        <div id="contract_form">

                            <div class="text-center">
                                <h5><u>Criteria List</u></h5>
                            </div>

                            <hr class="mb-5">

                            <div class="container">
                                <div class="row g-2">

                                    @foreach ($criterias as $criteria)
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="criterias[]" value="{{ $criteria->criteria_id }}" id="input_{{ $criteria->name }}" {{ $criteria->check ?? '' }}>
                                            <label class="form-check-label" for="input_{{ $criteria->name }}">
                                                {{ $criteria->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                        
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-lg-10">
                        <div class="text-center w-100 mt-5">
                            <input type="submit" class="btn btn-primary px-3 px-sm-5 me-3" value="Update" />
                            <a href="{{ $back }}" x-confirm="Confirm cancel the modification?">
                                <button type="button" class="btn btn-warning px-3 px-sm-5 ms-3">Cancel</button>
                            </a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
