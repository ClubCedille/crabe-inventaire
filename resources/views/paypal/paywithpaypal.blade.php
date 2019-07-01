<html>

<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="app">
        <compte-component url="{{URL::to('/')}}"></compte-component>
    </div>
</body>
<script src="/js/app.js"></script>

</html>
