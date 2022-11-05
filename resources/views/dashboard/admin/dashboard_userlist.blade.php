@if (isset($user))

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>EzRental | User List</title>

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
                        {{-- Display success message --}}
                        @if (Session::has('successMessage'))
                            <div class="alert alert-success">
                                <strong> {{ session('successMessage') }} </strong>
                            </div>
                            <?php session()->forget('successMessage'); ?>
                        @endif

                        {{-- Display fail message --}}
                        @if (Session::has('failMessage'))
                            <div class="alert alert-danger">
                                <strong> {{ session('failMessage') }} </strong>
                            </div>
                            <?php session()->forget('failMessage'); ?>
                        @endif

                        {{-- Check is the userList empty --}}
                        @if ($userList->isEmpty())
                            <label>
                                <h3>There was no user list found.</h3>
                            </label>
                        @else
                            @for ($i = 0; $i < count($userList); $i++)
                                <div> {{ $i + 1 }} <br>
                                    {{ $userList[$i]->account_id }} <br>
                                    {{ $userList[$i]->email }} <br>
                                    {{ $userList[$i]->status }} <br>


                                    @if ($userList[$i]->status == 'banned')
                                        <div class="bg-white h-100 py-4 px-3 px-sm-4">
                                            <button type="button" class="btn-close" aria-label="Close"
                                                onclick="window.location.href ='{{ URL('/dashboard/userlist/unbanuser/' . Crypt::encrypt($userList[$i]->account_id)) }}';"></button>
                                        </div>
                                    @else
                                        <div class="bg-white h-100 py-4 px-3 px-sm-4">
                                            <button type="button" class="btn-close" aria-label="Close"
                                                onclick="window.location.href ='{{ URL('/dashboard/userlist/banuser/' . Crypt::encrypt($userList[$i]->account_id) . '/' . Crypt::encrypt($userList[$i]->status)) }}';"></button>
                                            {{-- need edit to cover whole box --}}
                                        </div>
                                    @endif



                                </div>
                            @endfor
                        @endif



                    </div>


                </div>

            </div>
        </div>

        @include('../base/dashboard/dashboard_script')

    </body>

    </html>
@else
    <script>
        window.location = "/";
    </script>
@endif
