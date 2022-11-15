
<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Select Recommendation</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset("/css/dashboard/dashboard_index.css")}}">
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
                        <div class="row title text-center">
                            <h3><u>Select Filter Criteria List</u></h3>
                        </div>

                        <form action="/dashboard/recommendation/updateSelectionCriteriaToDB" method="post" onsubmit="return confirm('Are you sure you want to submit the selection?');">
                            @csrf
                                    
                           {{-- Check is the selectedCriterias empty --}}
                            @if ($criterias->isEmpty())
                            <div class="text-center">
                                <h3>There was no post criteria.</h3><br>
                            </div>
                            @else

                            <div class="border-1 rounded mt-3 mb-5 bg-light">
                                <div class="row mt-3">
    

                                {{-- For loop records --}}
                                @foreach ($criterias as $criteria)
                                
                                <div class="col-12 col-md-4 col-lg-3 col-xl-3 px-3 py-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="{{ $criteria->name }}" type="checkbox" name="criteria[]" value="{{ $criteria->criteria_id }}" @if ($selectedCriterias->contains('criteria_id', $criteria->criteria_id)) checked @endif>
                                        <label class="form-check-label" for="{{ $criteria->name }}">
                                            {{ $criteria->name }}
                                        </label>
                                      </div>
                                </div>

                                @endforeach

                                
                                </div>        
                            </div>


                        <div class="d-flex justify-content-center">
                            <div class="fixed-bottom-button">
                                <input class="btn btn-lg btn-success me-sm-2 px-3 px-sm-5" type="submit" value="Submit">
                                <a href="{{ route('dashboard.tenant.recommendation') }}">
                                    <button type="button" class="btn btn-lg btn-danger px-3 px-sm-5">Cancel</button>
                                </a>
                            </div>
                        </div>

                        @endif
                    </form>

                        
                    </div>

                </div>

            </div>
            
        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>
</html>