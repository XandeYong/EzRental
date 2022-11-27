<!DOCTYPE html>
<html>

<head>
    <title>EzRental | 401</title>
    @include('base.head')
    <link rel="stylesheet" href="{{ asset('css/errorpage.css') }}">
</head>

<body>
    @include('base.navbar')

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>4<span>0</span>1</h1>
            </div>
            <br />
            <br />
            <br />
            <p>Your authorization failed.</p>
            <p>Please try refreshing the page and fill in the correct login details.</p>
            <a href="{{ url('/') }}">Home Page</a>
        </div>
    </div>
    
</body>
<html>