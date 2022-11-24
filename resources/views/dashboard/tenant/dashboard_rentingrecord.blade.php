<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Renting Record</title>
    
    @include('../base/dashboard/dashboard_head')
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
                            <div class="col-12 col-lg-8">

                                <div class="container-fluid">
                                    <div class="row mb-2">

                                        {{-- Check is the rentingRecordImages empty --}}
                                        @if ($rentingRecordImages->isEmpty())
                                             <div id="no_image" class="text-center">  
                                                <img class="h-100 img-fluid img-thumbnail rounded" src="{{ asset('image/image_not_found.png') }}" alt="No image available">
                                             </div>
                                        @else

                                        {{-- image --}}
                                        <div id="carousel_post_image" class="carousel slide" data-bs-ride="true">
                                            <div class="carousel-indicators">
                                                {{-- For loop records --}}
                                                @if (count($rentingRecordImages) > 1)
                                                    @for ($i = 0; $i < count($rentingRecordImages); $i++)
                                                    <button type="button" data-bs-target="#carousel_post_image" data-bs-slide-to={{ $i }}  @if ($i==0) class="active" @endif
                                                        aria-current="true" aria-label="Slide " . {{ $i+1 }}></button>
                                                    @endfor
                                                @endif
                                            </div>

                                            <div class="carousel-inner">
                                                {{-- For loop records --}}
                                                @for ($i = 0; $i < count($rentingRecordImages); $i++)
                                                <div @if ($i==0) class="carousel-item active" @else class="carousel-item" @endif >
                                                    <img class="x-image-modal card-img-top img-fluid img-thumbnail rounded" src="{{ asset('image/post/'. $rentingRecordImages[$i]->image) }}" alt="{{ $rentingRecordImages[$i]->image }}">
                                                </div>
                                                @endfor

                                            </div>
                                            @if (count($rentingRecordImages) > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_post_image"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel_post_image"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                            @endif
                                        </div>
                                        @endif
                                        <p><small class="text-secondary">POST ID: {{ $rentingRecordDetails[0]->post_id }}</small></p>

                                    </div>

                                    {{-- Criterias --}}
                                    <div id="criteria" class="row mb-3">
                                        <div class="col-12">
                                            <h5><u>Criterias:</u></h5>

                                            @if (!$rentingRecordCriterias->isEmpty())
                                                <div>
                                                    @foreach ($rentingRecordCriterias as $criteria)
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
                                    <div class="row mb-3">
                                        <h5><u>Description:</u></h5>
                                        <p> {{ $rentingRecordDetails[0]->description }} </p>
                                    </div>

                                    {{-- sidebar --}}
                                    <div class="row mb-2">
                                        
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
                                                        <td class="w-75">{{ $rentingRecordDetails[0]->title }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Deposit</th>
                                                        <td class="w-75">RM {{ number_format($rentingRecordDetails[0]->deposit_price, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Monthly Payment</th>
                                                        <td class="w-75">RM {{ number_format($rentingRecordDetails[0]->monthly_price, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Room Size</th>
                                                        <td class="w-75">{{ ucfirst(trans($rentingRecordDetails[0]->room_size)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Condominium</th>
                                                        <td class="w-75">{{ $rentingRecordDetails[0]->condominium_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Floor</th>
                                                        <td class="w-75">{{ $rentingRecordDetails[0]->floor }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Unit</th>
                                                        <td class="w-75">{{ $rentingRecordDetails[0]->unit }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Address</th>
                                                        <td class="w-75">{{ $rentingRecordDetails[0]->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Post Owner</th>
                                                        <td class="w-75">{{ $rentingRecordDetails[0]->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="w-25">Renting Status</th>
                                                        <td class="w-75">{{ $rentingRecordDetails[0]->status }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>


                            <div class="col-12 col-lg-4">
                                
                                <div class="sidenav-section">
                                    <div id="control_panel" class="sidenav-item mb-3">
                                        <div class="item-header p-1 ps-3">
                                            <h4>Control Panel</h4>
                                        </div>
                                        <div class="item-body px-3 mb-2 mt-3">
                                            <div class="mb-2">
                                                <a href="{{ route('dashboard.tenant.maintenancerequest', ['rentingID' => Crypt::encrypt($rentingRecordDetails[0]->renting_id)]) }}">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Maintenance Request
                                                    </button>
                                                </a>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <a href="{{ route('dashboard.tenant.payment', ['rentingID' => Crypt::encrypt($rentingRecordDetails[0]->renting_id)]) }}">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Payment History
                                                    </button>
                                                </a>
                                            </div>

                                            <div class="mb-2">
                                                <a href="{{ route('dashboard.tenant.contract', ['rentingID' => Crypt::encrypt($rentingRecordDetails[0]->renting_id)]) }}">
                                                    <button class="btn btn-outline-dark w-100">
                                                        Contract
                                                    </button>
                                                </a>
                                            </div>

                                            {{-- Payment --}}
                                            <div id="payment" class="card my-3">
                                                <form action="/dashboard/payment/makePayment" method="post" class="h-100" onsubmit="return confirm('Are you sure you want to make payment?');">
                                                    @csrf
                                                    <div class="container-fluid h-100">
                                                        <div class="row align-content-between h-100">

                                                            <div id="payment_header" class="card-header text-center bg-danger">
                                                                <h5 class="mb-0 text-light">
                                                                    Due Payment
                                                                </h5>
                                                            </div>

                                                            <div id="payment_list" class="col-12">
                                                                        {{-- Check is the unpaidPayments empty --}}
                                                                        @if ($unpaidPaymentsID->isEmpty())
                                                                        <div class="border-1 rounded py-1 px-2 mx-3 my-2">
                                                                        <div class="text-center">
                                                                            <label class="form-check-label">
                                                                                No Unpaid Payment
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                        @else
                                                                   {{-- For loop records --}}
                                                                   @for ($i = 0; $i < count($unpaidPaymentsID); $i++)
                                                                <div class="border-1 rounded py-1 px-2 mx-3 my-2">
                                                                    <div class="form-check">
                                                                            <input class="form-check-input" name="payment[]" type="checkbox" value="{{ $unpaidPaymentsID[$i]->payment_id }}" >
                                                                            <label class="form-check-label">
                                                                                {{ $unpaidPaymentsName[$i] }}
                                                                            </label>
                                                                    </div>
                                                                </div>
                                                                @endfor
                                                                @endif

                                                            </div>
                                                        
                                                            <div id="payment_button" class="col-12">
                                                                <input class="card-footer btn btn-outline-danger" type="submit" id="makePayment" name="makePayment" value="Make Payment" @if ($unpaidPaymentsID->isEmpty()) disabled @endif>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </form>
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

    <div id="x-image-modal">
        <span class="close">&times;</span>
        <img id="x-image" class="img-fluid bg-color-white-t-20">
    </div>

    @include('../base/dashboard/dashboard_script')

    {{-- For validate is at least one checkbox checked  --}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#makePayment').click(function() {
                checked = $("input[type=checkbox]:checked").length;
        
                if(!checked) {
                    alert("You must check at least one payment checkbox.");
                    return false;
                }
                
            });
        });
        
    </script>

</body>

</html>
