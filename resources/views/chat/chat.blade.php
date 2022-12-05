<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Chat</title>
    @include('base/head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('/css/login.css')}}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body>
    
    <div id="wrapper">
        <div class="container-fluid">
            @include('base/navbar')

            <div id="content" class="">
                <div id="chat_container" class="container border-2 rounded">

                    <div id="chat_header" class="row py-3">
                        <h3 class="text-center text-white mb-0">Chat</h3>
                    </div>

                    <div id="chat_body" class="row border-2 rounded">
                        <div class="col-4 chat-item-container">

                            <div id="user_util" class="container">
                                <div class="row chat-item-util py-2">
                                    
                                    <div id="user_util_search">
                                        <div class="d-flex justify-content-around">
                                            <input id="search_input" type="text" class="form-control form-control-sm" name="message" targetID="" maxlength="255" required placeholder="Search User ID...">
                                            <button id="search_button" class="btn btn-sm btn-outline-success">Search</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div id="user_list" class="container-fluid">

                                <div id="chat" class="row chat-item mb-2">
                                    <div class="chat-item-title">
                                        <a href="#" class="unselectable">
                                            <h5>Chat</h5>
                                            <i class="ico-sm ico-white ico-chevron ico-chevron-right rotate"></i>
                                        </a>
                                    </div>
                                                                
                                    <div class="chattype container x-scrollbar-x">
                                        @foreach ($accounts as $account)
                                            
                                            @if (!$loop->first)
                                                <hr>
                                            @endif
                                        
                                            <div class="ct-item row">
                                                <a href="#{{ $account->account_id }}" class="unselectable">
                                                    <h6>
                                                        {{ $account->name }} 
                                                        <span class="text-bold-c">({{ $account->account_id }})</span>
                                                    </h6>
                                                </a>
                                            </div>

                                        @endforeach
                                    </div>

                                    <div class="chat-item-footer"></div>
                                </div>


                                <div id="group_chat" class="row chat-item">
                                    <div class="chat-item-title">
                                        <a href="#" class="unselectable">
                                            <h5>Group Chat</h5>
                                            <i class="ico-sm ico-white ico-chevron ico-chevron-right rotate"></i>
                                        </a>
                                    </div>
                                                                
                                    <div class="chattype container x-scrollbar-x">
                                        <div class="ct-item row">
                                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#create_group_modal">
                                                Create Group Chat
                                            </button>
                                        </div>

                                        @foreach ($gChats as $gChat)
                                            
                                            <hr>
                                        
                                            <div class="ct-item row">
                                                <a href="#{{ $gChat->group_id }}" class="unselectable" role="{{ $gChat->role }}">
                                                    <h6>
                                                        {{ $gChat->name }}
                                                        <span class="text-bold-c">({{ $gChat->group_id }})</span>
                                                    </h6>
                                                </a>
                                            </div>

                                        @endforeach
                                    </div>

                                    <div class="chat-item-footer"></div>
                                </div>

                            </div>

                        </div>


                        <div id="message" class="col-8 p-0">

                            <div id="title" class="container-fluid">
                                <div class="row text-center">
                                    <div class="col-3"></div>
                                    <div class="col-6">
                                        <div class="h-100 x-scrollbar-x">
                                            <h4 class="text-center w-100"></h4>
                                        </div>
                                        
                                    </div>
                                    <div id="chat_options" class="col-3 text-end" groupID=''>

                                        <div class="dropdown" hidden>
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Options
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a id="dd_show_group_user" class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                    data-bs-target="#display_user_modal">
                                                        Show Group User
                                                    </a>
                                                </li>
                                                <li class="admin" hidden>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                    data-bs-target="#add_user_modal">
                                                        Add User
                                                    </a>
                                                </li>
                                                <li class="admin" hidden>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                    data-bs-target="#remove_user_modal">
                                                        Remove User
                                                    </a>
                                                </li>
                                                <li class="master" hidden>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                    data-bs-target="#transfer_ownership_modal">
                                                        Transfer Ownership
                                                    </a>
                                                </li>
                                                <li class="master" hidden>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                    data-bs-target="#promote_user_modal">
                                                        Promote User
                                                    </a>
                                                </li>
                                                <li class="master" hidden>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                    data-bs-target="#demote_user_modal">
                                                        Demote User
                                                    </a>
                                                </li>
                                                <li class="master" hidden>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                    data-bs-target="#delete_group_modal">
                                                        Delete Group
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>

                            <div id="message_content" class="x-scrollbar-x">
                                <iframe 
                                    id="message_iframe" 
                                    class="w-100" 
                                    src="{{ route('chat.user') }}" 
                                    frameborder="0"
                                    chatType=""
                                    >
                                </iframe>
                            </div>

                            <div id="message_footer">
                                <div class="d-flex p-2 justify-content-around">
                                    <input id="message_send" type="text" class="form-control" name="message" targetID="" maxlength="255" disabled required>
                                    <button id="send" class="btn btn-outline-success" disabled>Send</button>    
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <template id="message_template">
        <div class="row mt-3 mb-3">
            <div class="message-container d-flex">
                
                <div class="message-item">
                    <div class="message text-start text-dark">
                        <h6>message</h6>
                    </div>
                    <div class="date text-end">
                        <h6 class="text-secondary mb-0">
                            <small>date</small>    
                        </h6>
                    </div>
                </div>
                
            </div>
        </div>
    </template>

    {{-- Create Group Modal --}}
    <div class="modal modal-lg fade" id="create_group_modal" tabindex="-1" aria-labelledby="create group modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <form action="{{ route('chat.group.create') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Create Group</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="group_name" class="form-label">Group Name <span class="c-red">*</span></label>
                            <input type="text" class="form-control" name="name" value="" minlength="5" maxlength="255" id="group_name" required placeholder="Group Name...">
                            @if ($errors->has('name'))
                                <span class="c-red-error">*{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button id="visit_appointment_submit" type="submit" class="btn btn-primary">Create Group</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @include('chat/modal/add_user_modal')
    @include('chat/modal/remove_user_modal')
    @include('chat/modal/promote_user_modal')
    @include('chat/modal/demote_user_modal')
    @include('chat/modal/transfer_ownership_modal')
    @include('chat/modal/delete_group_modal')
    @include('chat/modal/display_user_modal')


    {{-- access message --}}
    @if(session()->has('access_message'))
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <div class="message-popup">
                        <div class="alert {{ session()->get('access_message_status') ?? 'alert-danger' }} alert-dismissible mx-auto" role="alert">
                            {{ session()->get('access_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php session()->forget(['access_message', 'access_message_status']); @endphp
    @endif

    @include('base/footer')
    @include('base/script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="{{ asset('js/chat.js') }}"></script>


</body>
</html>