<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Current Renting Record List</title>
    
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

                    {{-- Check is the renting record empty --}}
                    @if ($rentingRecords->isEmpty())
                    <div class="text-center">
                        <h3 >There was no renting record found.</h3>
                    </div>
                    @else
     

                    {{-- For loop records --}}
                    @foreach ($rentingRecords as $rentingRecord)

                    <a href="{{ URL('/dashboard/rentingrecord/getrecordDetails/' . Crypt::encrypt($rentingRecord->renting_id)) }}" class="no-deco text-dark">
                        <div class="card mb-4">
                            <div class="d-flex bg-warning align-items-center">
                                
                                <div class="row me-auto px-3 w-100 align-items-center">
                                    <div class="col-12 col-sm py-4">
                                        <h3 class="mb-0 text-dark">
                                            {{ $rentingRecord->title }}
                                        </h3>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    </a>

                    @endforeach


                    @endif

                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>

</html>
