@inject('carbon', 'Carbon\Carbon')

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Messages</title>
    @include('base/head')
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body id="message">

    <div id="message_content_container" class="container-fluid">

        @if (!empty($user) && session()->get('account')['account_id'] != $user->account_id);
            <span id="username" hidden>{{ $user->name }}</span>        
        @endif

        @if (!empty($messages))

            @php
                $accountID = session()->get('account')['account_id'];
                $messageDate = "";
            @endphp
                
            @foreach ($messages as $message)

                @php
                    $type = 'receive';
                    $pos = 'justify-content-start';
                    if ($message->sender_id == $accountID) {
                        $type = 'send';
                        $pos = 'justify-content-end';
                    }

                    $date = $carbon->parse($message->created_at)->format('Y-m-d');
                    $time = $carbon->parse($message->created_at)->format('h:i A');
                @endphp

                @if ($date != $messageDate)
                    @php
                        $messageDate = $date;
                    @endphp

                    <hr>
                    <div class="row mt-3 mb-5">
                        <div class="message-container d-flex justify-content-center">
                            
                            <div class="message-info">
                                <div class="message text-center text-dark">
                                    <h6 class="mb-0"><small>{{ $date }}</small></h6>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                @endif

                <div class="row mt-3 mb-3">
                    <div class="message-container {{ $type }} d-flex {{ $pos }}">
                        
                        <div class="message-item">
                            <div class="message text-start text-dark">
                                <h6>{{ $message->message }}</h6>
                            </div>
                            <div class="date text-end">
                                <h6 class="text-secondary mb-0">
                                    <small>
                                        {{ $time }}
                                    </small>    
                                </h6>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endforeach
        @endif

    </div>

    @include('base/script')
    <script src="{{ asset('js/message.js') }}"></script>
    
    @if (!empty($user) && session()->get('account')['account_id'] == $user->account_id);
        <script>
            window.alert('You are not allow to chat with yourself.');
        </script>
    @endif

</body>
</html>