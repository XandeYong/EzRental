<div class="sidenav-section col-12 col-lg-3">
    <div class="sidenav-item mb-3">
        <div class="item-header p-1 ps-3">
            <h4>Search</h4>
        </div>
        <div class="item-body">
            <form action="/rental_post_list/search" method="POST">
                @csrf
                <div class="search d-flex p-3">
                    <input class="form-control shadow-none" type="text" name="search" placeholder="Search" required>
                    <button class="btn btn-secondary shadow-none" type="submit">Go</button>

                </div>
                <?php if(Session::has('errorMessage')){ 
                    $errorMessage=session()->get('errorMessage');
                    ?>
                <span class="c-red-error"> {{ $errorMessage }}</span><br>
                <?php 
                session()->forget('errorMessage');      
                    }         
                    ?>
            </form>
        </div>
    </div>

    <div class="sidenav-item mb-3">
        <div class="item-header p-1 ps-3">
            <h4>Sort</h4>
        </div>

        <div class="item-body container">
            <div class="row px-3 py-2">

                <div class="col mt-2">
                    <button class="w-100 btn btn-sm btn-outline-dark" type="button"
                        onclick="window.location.href ='{{ route('rental_post_list.sort', ['sort' => Crypt::encrypt('latest')]) }}';">
                        <i>Latest</i>
                    </button>
                </div>

                <div class="col mt-2">
                    <button class="w-100 btn btn-sm btn-outline-dark" type="button"
                        onclick="window.location.href ='{{ route('rental_post_list.sort', ['sort' => Crypt::encrypt('oldest')]) }}';">
                        <i>Oldest</i>
                    </button>
                </div>

                <div class="col mt-2">
                    <button class="w-100 btn btn-sm btn-outline-dark" type="button"
                        onclick="window.location.href ='{{ route('rental_post_list.sort', ['sort' => Crypt::encrypt('high price')]) }}';">
                        <i>High Price</i>
                    </button>
                </div>

                <div class="col mt-2">
                    <button class="w-100 btn btn-sm btn-outline-dark" type="button"
                        onclick="window.location.href ='{{ route('rental_post_list.sort', ['sort' => Crypt::encrypt('low price')]) }}';">
                        <i>Low Price</i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="sidenav-item mb-3">
        <form action="/rental_post_list/filter" method="post">
            @csrf
            <div class="item-header p-1 ps-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h4>Filter</h4>
                    </div>

                    <div class="">
                        <input class="btn btn-sm btn-outline-success" type="submit" value="Filter" id="filter"
                            name="filter">
                        <input class="btn btn-sm btn-outline-danger" type="reset" value="reset">
                    </div>
                </div>
            </div>

            <div class="item-body container">
                <div class="row px-3 py-2">

                    @if (count($criteriaLists) == 0)
                        <div class="text-center">
                            <h5>No criteria.</h5><br>
                        </div>
                    @else
                    @php
                        if (isset($_POST['sector'])) $filters = $_POST['sector'];
                        else {
                            $filters = array();
                        }
                    @endphp

                        @for ($i = 0; $i < count($criteriaLists); $i++)
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" name="filter[]" value="{{ $criteriaLists[$i]->criteria_id }}" />
                                    <span class="ms-1">{{ $criteriaLists[$i]->name }}</span>
                                </div>
                            </div>
                        @endfor
                    @endif


                </div>
            </div>

        </form>
    </div>

</div>
