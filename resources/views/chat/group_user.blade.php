@inject('carbon', 'Carbon\Carbon')

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Messages</title>
    @include('base/head')
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body id="group_user_list" class="bg-white">

    @if (!empty($groupUsers))
        
        <table class="table table-light rounded">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                </tr>
            </thead>
            <tbody id="group_user_list">

                @foreach ($groupUsers as $i => $user)
                    <tr>
                        <th scope="row">{{ $i + 1 }}</th>
                        <td>{{ $user->account_id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    @endif
    

    @include('base/script')
    <script src="{{ asset('js/message.js') }}"></script>

</body>
</html>