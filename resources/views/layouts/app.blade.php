<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    

    <title>Distribuidora E&E - Login </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="log/css/normalize.css">
  	<link rel="stylesheet" href="log/css/sweetalert2.css">
  	<link rel="stylesheet" href="log/css/material.min.css">
  	<link rel="stylesheet" href="log/css/material-design-iconic-font.min.css">
  	<link rel="stylesheet" href="log/css/jquery.mCustomScrollbar.css">
  	<link rel="stylesheet" href="log/css/main.css">

   
    <link href="img/lauch.png" rel="icon">

    <script src="log/js/material.min.js" ></script>
</head>
<body background="img/fontLogin.jpg" style=" background-repeat: no-repeat; background-size: 100% 100%; background-attachment: fixed;">

      <div id="app">
        
        <div class="login-wrap cover">
          @yield('content')
        </div>
      </div>


</body>
</html>
