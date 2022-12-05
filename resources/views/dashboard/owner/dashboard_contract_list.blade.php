<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Contract List</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_index.css') }}">
</head>

<body>

    @include('../base/dashboard/dashboard_sidebar')

    <div id="wrapper">
        <div class="container-fluid">
            @include('../base/dashboard/dashboard_header')

            <div id="content" class="row justify-content-center">
                <div class="col col-sm-10 col-md-8 col-lg-10 pb-4">
                    
                    @if (!empty($contract))

                        @php
                            $color = 'text-primary';
                            if ($contract->status == 'expired') {
                                $color = 'text-secondary';
                            } else if ($contract->status == 'active') {
                                $color = 'text-success';
                            }
                        @endphp
                        
                        <div id="current_contract">
                            <h5 class="text-secondary">Current Contract</h5>
                        </div>

                        <a href="{{ route('dashboard.owner.room_rental_post.contract', ['postID' => Crypt::encrypt($contract->post_id), 'contractID' => Crypt::encrypt($contract->contract_id)]) }}" class="no-deco text-dark">
                            <div class="card mb-4">
                                <div class="d-flex bg-color-powderblue rounded align-items-center py-4">
                                    <div class="row me-auto px-3 w-100 align-items-center" >
                                        <div class="col-12 col-sm">
                                            <h3 class="mb-0">
                                                {{ $contract->contract_id }}
                                            </h3>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <h6 class="mb-0 text-sm-end pb-2">
                                                Date: {{ date('Y-m-d', strtotime($contract->created_at)) }}
                                            </h6>
                                            <h4 class="mb-0 text-sm-end {{ $color }}">
                                                {{ Str::ucfirst($contract->status) }}
                                            </h4>
                                        </div>
                                    </div>
                
                                </div>
                            </div>
                        </a>

                        <div id="expired_contract">
                            <h5 class="text-secondary">Expired Contract</h5>
                        </div>
                    
                    @endif

                    

                    @if ($expiredContracts->isEmpty())

                        <div class="text-center mt-5">
                            <h3 >There was no expired contract found.</h3>
                        </div>

                    @else
                        @foreach ($expiredContracts as $contract)
                        @php
                            if(empty($postID)) {
                                $param = ['contractID' => Crypt::encrypt($contract->contract_id)];
                                $route = route('dashboard.owner.contract', $param);
                            } else {
                                $param = ['postID' => Crypt::encrypt($contract->post_id), 'contractID' => Crypt::encrypt($contract->contract_id)];
                                $route = route('dashboard.owner.room_rental_post.contract', $param);
                            }

                            $color = 'text-primary';
                            if ($contract->status == 'expired') {
                                $color = 'text-secondary';
                            } else if ($contract->status == 'active') {
                                $color = 'text-success';
                            }
                        @endphp
                            
                            <a href="{{ $route }}" class="no-deco text-dark">
                                <div class="card mb-4">
                                    <div class="d-flex bg-color-powderblue rounded align-items-center py-4">
                                        <div class="row me-auto px-3 w-100 align-items-center" >
                                            <div class="col-12 col-sm">
                                                <h3 class="mb-0">
                                                    {{ $contract->contract_id }}
                                                </h3>
                                            </div>
        
                                            <div class="col-12 col-sm">
                                                <h6 class="mb-0 text-sm-end pb-2">
                                                    Date: {{ date('Y-m-d', strtotime($contract->created_at)) }}
                                                </h6>
                                                <h4 class="mb-0 text-sm-end {{ $color }}">
                                                    {{ Str::ucfirst($contract->status) }}
                                                </h4>
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
