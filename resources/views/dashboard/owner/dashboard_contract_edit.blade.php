<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | Edit Contract</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_index.css') }}">
</head>

<body>


    @include('../base/dashboard/dashboard_sidebar')

    <div id="wrapper">
        <div class="container-fluid">
            @include('../base/dashboard/dashboard_header')

            @php
                if(empty($postID)) {
                    $param = ['contractID' => Crypt::encrypt($contract->contract_id)];
                    $routePost = route('dashboard.owner.contract.edit_form.edit', $param);
                    $routeCancel = route('dashboard.owner.contract', $param);
                } else {
                    $param = ['postID' => Crypt::encrypt($contract->post_id), 'contractID' => Crypt::encrypt($contract->contract_id)];
                    $routePost = route('dashboard.owner.room_rental_post.contract.edit_form.edit', $param);
                    $routeCancel = route('dashboard.owner.room_rental_post.contract', $param);
                    
                }
            @endphp

            <form class="x-form x-form-validation" action="{{ $routePost }}" method="post"
                x-confirm="Confirm update the contract?">
                @csrf 
                <div id="content" class="row justify-content-center">

                    <div class="col col-sm-10 col-md-8 col-lg-10 rounded border-3 border-black-t-1 p-3">

                        <div id="contract_form">
                            <div class="text-center">
                                <h5><u>Contract Form</u></h5>
                            </div>

                            <hr class="mb-5">

                            <div id="contract_content" class="mb-3">
                                <label for="input_content" class="form-label">Content <span class="c-red">*</span></label>
                                <textarea class="form-control" name="content" id="input_content" cols="30" rows="5" maxlength="65535" placeholder="Write your contract content here..." required>{{ $contract->content }}</textarea>
                                
                                @if($errors->has('content'))
                                    <span class="x-form-error c-red-error">*{{ $errors->first('content') }}</span>
                                @endif
                            </div>

                            <div id="deposit" class="mb-3">
                                <label for="input_deposit" class="form-label">Deposit Payment Amount <span class="c-red">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">RM</span>
                                    <input value="{{ $contract->deposit_price }}" type="number" class="form-control" name="deposit" id="input_deposit" placeholder="eg. 1250" required>
                                    <span class="input-group-text">.00</span>
                                </div>
                                
                                @if($errors->has('deposit'))
                                    <span class="x-form-error c-red-error">*{{ $errors->first('deposit') }}</span>
                                @endif
                            </div>

                            <div id="monthly" class="mb-3">
                                <label for="input_monthly" class="form-label">Monthly Payment Amount <span class="c-red">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">RM</span>
                                    <input value="{{ $contract->monthly_price }}" type="number" class="form-control" name="monthly" id="input_monthly" placeholder="eg. 500" required>
                                    <span class="input-group-text">.00</span>
                                </div>
                                
                                @if($errors->has('monthly'))
                                    <span class="x-form-error c-red-error">*{{ $errors->first('monthly') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-10">
                        <div class="text-center w-100 mt-5">
                            <input type="submit" class="btn btn-primary px-3 px-sm-5 me-3" value="Update" />
                            <a href="{{ $routeCancel }}" x-confirm="Confirm cancel the modification?">
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
