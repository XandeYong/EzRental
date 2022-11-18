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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php session()->forget('successMessage'); ?>
                    @endif

                    {{-- Display fail message --}}
                    @if (Session::has('failMessage'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> {{ session('failMessage') }}</strong> 
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php session()->forget('failMessage'); ?>
                    @endif

                            
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-4 col-lg-2">
                                <a href="{{ route('dashboard.admin.userlist') }}" class="btn btn-success w-100">All</a>
                            </div>
                            <div class="col-4 col-lg-2">
                                <a href="{{ url('/dashboard/userlist/filterUserList/' . Crypt::encrypt('banned')) }}" class="btn btn-danger w-100">Ban</a>
                            </div>
                            <div class="col-4 col-lg-2">
                                <a href="{{ url('/dashboard/userlist/filterUserList/' . Crypt::encrypt('not banned')) }}" class="btn btn-warning w-100">Unban</a>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">

                                <form action="/dashboard/userlist/searchUser" method="post">
                                    @csrf
                                    <div class="input-group mb-3 border-1 bg-warning rounded px-2 py-2">
                                        <input type="text" class="form-control" name="accountId" value="" placeholder="Search by account id" aria-describedby="search input field" required>
                                        <button class="btn btn-light btn-outline-danger" type="submit">Search</button>
                                    </div>
                                    <?php if(Session::has('errorMessage')){ 
                                        $errorMessage=session()->get('errorMessage');
                                        $errorMessage=explode(",", $errorMessage); 
                                        for($i=0; $i<count($errorMessage); $i++){
                                        ?>
                                    <span
                                        class="c-red-error">{{ $errorMessage[$i] }}</span><br>
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
                                                    <th colspan="5" class="text-center"><h3>There was no user found.</h3></th>
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
                                                                <button class="btn" title="unban">
                                                                    <i class="ico-sm ico-unlock-solid ico-golden m-0"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn" title="ban">
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
                            <div class="form-popup" id="banForm">
                                <form action="/dashboard/userlist/banuser" class="form-container">
                                    <h1>Ban Form</h1>
                                    <label for="email"><b>Duration: </b></label>
                                    <input type="text" placeholder="Enter Days" name="duration" required>
                                    @if($errors->has('duration'))
                                    <span class="c-red-error">*{{ $errors->first('duration') }}</span>
                                    @endif

                                    <br>

                                    <label for="email"><b>Reason: </b></label>
                                    <input type="text" placeholder="Enter Reason for ban the user" name="reason" required>
                                    
                                    @if($errors->has('reason'))
                                    <span class="c-red-error">*{{ $errors->first('reason') }}</span>
                                    @endif

                                    <input type="hidden" id="accountID" name="accountID" value="A4"> {{-- need remove value --}}
                                
                                    <button type="submit" class="btn">Submit</button>
                                    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                                </form>
                                </div>

                    </div>

                </div>


            </div>

        </div>
    </div>

    


    {{-- pop out form for fill banned reasons --}}
    {{-- <script>
        $(function openForm() {
            // document.getElementById("banForm").innerHTML.getElementById('accountID').value = accountID;
            document.getElementById("banForm").style.display = "block";
            
        });
        
        $(function closeForm() {
            document.getElementById("banForm").style.display = "none";
        });
    </script> --}}

    @include('../base/dashboard/dashboard_script')
    <script src="{{ asset('js/dashboard/dashboard_list.js') }}"></script>

</body>

</html>