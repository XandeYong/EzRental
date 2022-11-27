<!DOCTYPE html>
<html>

<head>
    <title>EzRental | 404</title>
    @include('base.head')
    <link rel="stylesheet" href="{{ asset('css/errorpage.css') }}">
</head>

<body>
    @include('base.navbar')

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>4<span>0</span>4</h1>
            </div>
            <br />
            <br />
            <br />
            <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.
            </p>
            <a href="{{ url('/') }}">Home Page</a>
        </div>
    </div>
    
</body>
<html>