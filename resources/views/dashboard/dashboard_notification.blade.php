

    <!DOCTYPE html>
    <html lang="en">

<head>
    <title>EzRental | Notification</title>

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
                <div class="col col-sm-10 col-md-8 col-lg-10 pb-4">
                {{-- Check is the notification lists empty --}}
                @if ($notificationLists->isEmpty())
                    <div class="text-center">
                        <h3 >There was no notification.</h3>
                    </div>
                @else
                    @foreach ($notificationLists as $notificationList)
                        <div class="card mb-4">
                            <div class="d-flex bg-color-powderblue align-items-center py-4">
                                <div class="row me-auto px-3 w-100 align-items-center" >
                                    <div class="col-12 col-lg-9">
                                        <h4 class="mb-0">
                                            {{ $notificationList->title }}
                                        </h4>
                                        <hr>
                                        <p class="">{!! $notificationList->message !!}</p>
                                    </div>

                                    <div class="col-12 col-lg-3 text-sm-end">
                                        <h6 class="mb-0">
                                            Date: {{ date('Y-m-d, g:i A', strtotime($notificationList->created_at)) }}
                                        </h6>
                                        <h4 class="mb-0">
                                            @if ($notificationList->status == 'read')
                                                <i class="ico ico-check-lg ico-green-3" title="read"></i>
                                            @else
                                                <i class="ico ico-check-lg" title="unread"></i>
                                            @endif
                                        </h4>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    @endforeach
                @endif
                </div>

            </div>

        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>
</html>
