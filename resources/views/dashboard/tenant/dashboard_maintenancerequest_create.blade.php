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

            <div id="content" class="row justify-content-center">

                {{-- Code here --}}
                <div class="col col-sm-10 col-md-8 col-lg-10">

                    <form action="/dashboard/rentingrecord/maintenancerequest/createMaintenanceRequestToDB" method="post"
                                    onsubmit="return confirm('Are you sure you want to create maintenance request?');" >
                        @csrf 
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                            @if($errors->has('title'))
                            <span class="c-red-error">*{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10" required></textarea>
                            @if($errors->has('description'))
                            <span class="c-red-error">*{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <input type="hidden" name="rentingID" value={{ $rentingID }} >

                        <div class="text-center w-100">
                            <input type="submit" class="btn btn-success w-50" value="Create" />
                            <a href="{{ URL('/dashboard/rentingrecord/maintenancerequest/index/'. Crypt::encrypt($rentingID)) }}">
                                <button type="button" class="btn btn-lg btn-danger px-3 px-sm-5">Cancel</button>
                            </a>
                        </div>
                        
                    </form>

                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
