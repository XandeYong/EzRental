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

                    <form>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="email" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10" required></textarea>
                        </div>

                        <div class="text-center w-100">
                            <input type="submit" class="btn btn-success w-50" value="Create" />
                        </div>
                        
                    </form>

                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
