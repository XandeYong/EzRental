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

            <form class="x-form x-form-validation" action="{{ route('dashboard.owner.room_rental_post.edit_form.edit', ['postID' => Crypt::encrypt($post->post_id)]) }}" method="post"
                x-confirm="Confirm update this Room Rental Post?">
                @csrf 
                <div id="content" class="row justify-content-center">

                    <div class="col col-sm-10 col-md-8 col-lg-10 rounded border-3 border-black-t-1 p-3">

                        <div id="post_form">
                            <div class="text-center">
                                <h5><u>Room Rental Post Form</u></h5>
                            </div>

                            <hr class="mb-5">

                            <div id="title" class="mb-3">
                                <label for="input_title" class="form-label">Title <span class="c-red">*</span></label>
                                <input value="{{ old('title') ? old('title') : $post->title }}" type="text" class="form-control" name="title" id="input_title" maxlength="255" placeholder="eg. PV21 Master room for rent" required>
    
                                @if($errors->has('title'))
                                    <span class="x-form-error c-red-error">*{{ $errors->first('title') }}</span>
                                @endif
                            </div>
    
                            <div id="description" class="mb-3">
                                <label for="input_description" class="form-label">Description <span class="c-red">*</span></label>
                                <textarea class="form-control" name="description" id="input_description" cols="30" rows="5" maxlength="65535" placeholder="Describe your unit and room here..." required>{{ old('description') ? old('description') : $post->description }}</textarea>
                                
                                @if($errors->has('description'))
                                    <span class="x-form-error c-red-error">*{{ $errors->first('description') }}</span>
                                @endif
                            </div>
    
                            <div class="mb-3">
                                <label for="condominium" class="form-label">Condominium Name <span class="c-red">*</span></label>
                                <input value="{{ old('condominium') ? old('condominium') : $post->condominium_name }}" type="text" class="form-control" name="condominium" id="condominium" maxlength="255" placeholder="eg. PV21" required>
                                
                                @if($errors->has('condominium'))
                                    <span class="x-form-error c-red-error">*{{ $errors->first('condominium') }}</span>
                                @endif
                            </div>
    
                            <div class="mb-3 row g-3">
                                <div id="size" class="col-md-6">
                                    @php
                                        $options = ['small', 'small medium', 'big medium', 'master'];
                                    @endphp

                                    <label for="input_size" class="form-label">Room Size <span class="c-red">*</span></label>
                                    <select class="form-select x-form-required" name="size" id="input_size" aria-label="Select room size" required>
                                        @foreach ($options as $option)
                                            @php
                                                $checked = '';
                                                if (old('size') !== null) {
                                                    if (old('size') == $option) {
                                                        $checked = 'checked';
                                                    }
                                                } else {
                                                    if ($post->room_size == $option) {
                                                        $checked = 'checked';
                                                    } 
                                                }
                                            @endphp

                                            <option {{ $checked }} value="{{ $option }}">{{ Str::title($option) . ' Room' }}</option>
                                        @endforeach
                                    </select>         
                                                    
                                    @if($errors->has('size'))
                                        <span class="x-form-error c-red-error">*{{ $errors->first('size') }}</span>
                                    @endif
                                </div>
    
                                <div id="block" class="col-md-2">
                                    <label for="input_block" class="form-label">Block <span class="c-red">*</span></label>
                                    <input value="{{ old('block') ? old('block') : $post->block }}" type="text" class="form-control" name="block" id="input_block" placeholder="eg.A" required>
    
                                    @if($errors->has('block'))
                                        <span class="x-form-error c-red-error">*{{ $errors->first('block') }}</span>
                                    @endif
                                </div>
    
                                <div id="floor" class="col-md-2">
                                    <label for="input_floor" class="form-label">Floor <span class="c-red">*</span></label>
                                    <input value="{{ old('floor') ? old('floor') : $post->floor }}" type="text" class="form-control" name="floor" id="input_floor" placeholder="eg.3A" required>
                                    
                                    @if($errors->has('floor'))
                                        <span class="x-form-error c-red-error">*{{ $errors->first('floor') }}</span>
                                    @endif
                                </div>
    
                                <div id="unit" class="col-md-2">
                                    <label for="input_unit" class="form-label">Unit <span class="c-red">*</span></label>
                                    <input value="{{ old('unit') ? old('unit') : $post->unit }}" type="text" class="form-control" name="unit" id="input_unit" placeholder="eg.18" required>
    
                                    @if($errors->has('unit'))
                                        <span class="x-form-error c-red-error">*{{ $errors->first('unit') }}</span>
                                    @endif
                                </div>
    
                            </div>
    
                            <div class="mb-3">
                                <label for="address" class="form-label">Address <span class="c-red">*</span></label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="3" maxlength="255" placeholder="Enter the unit address here..." required>{{ old('address') ? old('address') : $post->address }}</textarea>
                                
                                @if($errors->has('address'))
                                    <span class="c-red-error">*{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-10">
                        <div class="text-center w-100 mt-5">
                            <input type="submit" class="btn btn-primary px-3 px-sm-5 me-3" value="Update" />
                            <a href="{{ route('dashboard.owner.room_rental_post', ['postID' => Crypt::encrypt($post->post_id)]) }}" x-confirm="Confirm exit modification?">
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
