@if (isset($user))

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

                        {{-- filter user list function --}}
                        <button class="btn btn-lg btn-danger px-3 px-sm-5" type="button"
                            onclick="window.location.href ='{{ route('dashboard.admin.userlist') }}';">All</button>
                        <button class="btn btn-lg btn-danger px-3 px-sm-5" type="button"
                            onclick="window.location.href ='{{ URL('/dashboard/userlist/filterUserList/' . Crypt::encrypt('banned')) }}';">Ban</button>
                        <button class="btn btn-lg btn-danger px-3 px-sm-5" type="button"
                            onclick="window.location.href ='{{ URL('/dashboard/userlist/filterUserList/' . Crypt::encrypt('not banned')) }}';">Unban</button>


                        {{-- search function --}}
                        <div>
                            <form action="/dashboard/userlist/searchUser" method="post">
                                @csrf
                                <input type="text" name="accountId" 
                                    placeholder="Search by account id" required>
                                    <button type="submit" value="Search">Search</button>
                                    @if($errors->has('accountId'))
                                    <span class="c-red-error">*{{ $errors->first('accountId') }}</span>
                                    @endif
                            </form>

                        </div>


                        <br><br>
                        {{-- Check is the userList empty --}}
                        @if ($userList->isEmpty())
                            <label>
                                <h3>There was no user found.</h3>
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
                                            onclick="openForm({{ $userList[$i]->account_id }})"></button> {{-- need edit to cover whole box --}}
                                        </div>
                                    @endif



                                </div>
                            @endfor

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
                              


                        @endif



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
@else
    <script>
        window.location = "/";
    </script>
@endif
