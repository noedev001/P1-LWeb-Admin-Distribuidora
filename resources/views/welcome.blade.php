<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Distribuidora E&E </title>

    <link rel="stylesheet" href="log/css/normalize.css">

    <link rel="stylesheet" href="log/css/material.min.css">
    <link rel="stylesheet" href="log/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="log/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="log/css/main.css">
    <link rel="stylesheet" href="css/main.css">



    <script src="log/js/material.min.js"></script>

    <link href="img/lauch.png" rel="icon">



</head>

<body>

    <header class="header content">
        <div class="header-video">
            <video src="videos/file.mp4" autoplay loop poster="img/fontLogin.jpg"></video>
        </div>
        <div class="header-overlay"></div>

        <div class="header-content">
            <div class="content">


                <h1>Distribuidora
                    <br /> E&E
                </h1>
                <br />
                <div class="links">
                    <p>

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" style="color: #4ecdc4 ; ">Home</a>
                            @else
                                <a href="{{ route('login') }}" style="color: #4ecdc4 ; ">Login</a>
                                {{-- <a href="{{ url('/pagecliente') }}" style="color: #4ecdc4 ; ">Catalogo</a> --}}
                            @endauth
                        @endif


                    </p>
                </div>
            </div>
        </div>
    </header>

</body>

</html>
