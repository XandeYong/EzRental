<!DOCTYPE html>
<html>

<head>
    <title>EzRental | 500</title>
    @include('base.head')
    <link rel="stylesheet" href="{{ asset('css/errorpage.css') }}">
</head>

<body>
    @include('base.navbar')

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>5<span>0</span>0</h1>
            </div>
            <br />
            <br />
            <br />
            <p>The server encountered an internal error or misconfiguration and was unable to complete your request.</p>
            <a href="{{ url('/') }}">Home Page</a>
        </div>
    </div>
    
</body>
<html>