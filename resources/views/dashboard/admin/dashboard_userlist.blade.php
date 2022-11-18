<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzRental | User List</title>

    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_index.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_userlist.css') }}">
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
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong> {{ session('successMessage') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        <?php session()->forget('successMessage'); ?>
                    @endif

                    {{-- Display fail message --}}
                    @if (Session::has('failMessage'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> {{ session('failMessage') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        <?php session()->forget('failMessage'); ?>
                    @endif


                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-4 col-lg-2">
                                <a href="{{ route('dashboard.admin.userlist') }}" class="btn btn-success w-100">All</a>
                            </div>
                            <div class="col-4 col-lg-2">
                                <a href="{{ url('/dashboard/userlist/filterUserList/' . Crypt::encrypt('banned')) }}"
                                    class="btn btn-danger w-100">Ban</a>
                            </div>
                            <div class="col-4 col-lg-2">
                                <a href="{{ url('/dashboard/userlist/filterUserList/' . Crypt::encrypt('not banned')) }}"
                                    class="btn btn-warning w-100">Unban</a>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">

                                <form action="/dashboard/userlist/searchUser" method="post">
                                    @csrf
                                    <div class="input-group mb-3 border-1 bg-warning rounded px-2 py-2">
                                        <input type="text" class="form-control" name="accountId" value=""
                                            placeholder="Search by account id" aria-describedby="search input field"
                                            required>
                                        <button class="btn btn-light btn-outline-danger" type="submit">Search</button>
                                    </div>
                                    <?php if(Session::has('errorMessage')){ 
                                            $errorMessage=session()->get('errorMessage');
                                            $errorMessage=explode(",", $errorMessage); 
                                            for($i=0; $i<count($errorMessage); $i++){
                                            ?>
                                    <span class="c-red-error">{{ $errorMessage[$i] }}</span><br>
                                    <?php }
                                        session()->forget('errorMessage');      
                                            }         
                                            ?>
                                </form>

                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="table-responsive">

                                    <table class="table table-bordered border-1 table-light">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Email</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Ban</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($userList->isEmpty())
                                                <tr>
                                                    <th colspan="5" class="text-center">
                                                        <h3>There was no user found.</h3>
                                                    </th>
                                                </tr>
                                            @else
                                                @for ($i = 0; $i < count($userList); $i++)
                                                    <tr>
                                                        <td>
                                                            {{ $i + 1 }}
                                                        </td>
                                                        <td>
                                                            {{ $userList[$i]->account_id }}
                                                        </td>
                                                        <td>
                                                            {{ $userList[$i]->email }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $userList[$i]->status }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($userList[$i]->status == 'banned')
                                                                <a href="{{ URL('/dashboard/userlist/unbanuser/' . Crypt::encrypt($userList[$i]->account_id)) }}"
                                                                    class="btn"
                                                                    onclick="return confirm('Are you sure you want to unban this user?');"><i
                                                                        class="ico-sm ico-unlock-solid ico-golden m-0"></i></a>
                                                            @else
                                                                <button class="btn" title="ban"
                                                                    data-bs-toggle="modal" data-bs-target="#ban_modal">
                                                                    <i class="ico-sm ico-lock-solid ico-red-2 m-0"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>


                        {{-- pop out form for fill banned reasons --}}
                        <div class="modal modal-lg fade" id="ban_modal" tabindex="-1" aria-labelledby="ban modal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="/dashboard/userlist/banuser" class="form-container"
                                        onsubmit="return confirm('Are you sure you want to ban this user?');">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Ban Form</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Duration:</label>
                                                <input type="text" placeholder="Enter Days" name="duration"
                                                    class="form-control" required>
                                                @if ($errors->has('duration'))
                                                    <span class="c-red-error">*{{ $errors->first('duration') }}</span>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Reason:</label>
                                                <textarea class="form-control" name="reason" id="negotiate_message" placeholder="Enter Reason for ban the user"
                                                    rows="3" maxlength="255" required></textarea>
                                                @if ($errors->has('reason'))
                                                    <span class="c-red-error">*{{ $errors->first('reason') }}</span>
                                                @endif
                                            </div>
                                            <input type="hidden" id="accountID" name="accountID" value="A4">
                                            {{-- need remove value --}}

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>

            </div>
        </div>



        @include('../base/dashboard/dashboard_script')
        <script src="{{ asset('js/dashboard/dashboard_list.js') }}"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            <?php
                    if ($errors->has('duration') || $errors->has('reason')){
                     ?>
            $(document).ready(function() {
                $('#ban_modal').modal('show')
            });
            <?php
                     }
                     ?>
        </script>


</body>

</html>
