
<!DOCTYPE html>
<html lang="es" style="">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Innova Dent</title>
    <meta content="jcsoftia" name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="./assets/img/icon.png">
    <link rel="stylesheet" href="./assets/css/plantilla.css">
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script> --}}
    <script src="./js/Chart.bundle.js"></script>
    <script src="./js/plantillahead.js"></script>
    <style>
        .logo span img{
            border-radius: 0.5rem;
        }
        *{
            color: #111 !important;
        }
        body{
            /* font-family: 'Oswald', sans-serif !important; */
            font-family: 'Source Sans Pro', sans-serif !important;
            font-weight: 600 !important;
        }
        *::-webkit-scrollbar {
            width: .75em;     /* Tamaño del scroll en vertical */
            height: .75em;    /* Tamaño del scroll en horizontal */
            /* display: none;  Ocultar scroll */
        }
        /* Ponemos un color de fondo y redondeamos las esquinas del thumb */
        *::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        /* Cambiamos el fondo y agregamos una sombra cuando esté en hover */
        *::-webkit-scrollbar-thumb:hover {
            background: #444;
            box-shadow: 0 0 2px 1px rgba(0,0,0,0.8);
            cursor: pointer;
        }

        /* Cambiamos el fondo cuando esté en active */
        *::-webkit-scrollbar-thumb:active {
            background-color: #333;
        }
         *::-webkit-scrollbar-track {
            background: #bbb;
            border-radius: 4px;
        }

        /* Cambiamos el fondo cuando esté en active o hover */
        *::-webkit-scrollbar-track:hover,
        *::-webkit-scrollbar-track:active {
        background: #bbb;
        cursor: pointer;
        }
         *::placeholder { color: #000000d !important; }
         .form-control{
             font-weight: 600;
             color: black !important;
         }
         .btn{
             color: #000 !important;
             font-weight: 600;
         }
    </style>
</head>

<body class="p-0 m-0">

    <div id="app">
        <v-app id="inspire"  style="background-image: linear-gradient(to top, #0c3483 0%, #a2b6df 100%, #6b8cce 100%, #a2b6df 100%);">
        <div class="header-bg pb-5 mb-5">
            <!-- Navigation Bar-->
            <header id="topnav">
                @include('templates.topnav')
                @if (Auth::check())
                    @if (Auth::user()->id_rol == 1)
                        @include('templates.headerAdministrador')
                    @elseif (Auth::user()->id_rol == 2)
                        @include('templates.headerVendedor')
                    @elseif (Auth::user()->id_rol == 3)
                        @include('templates.headerAlmacenero')
                    @else
                    @endif
                @endif
                <!-- end topbar-main -->
                {{-- @include('templates.header') --}}
            </header>
            <!-- End Navigation Bar-->
            <div class="wrapper">

                <div class="container-fluid">

                    @yield('contenido')
                </div>
            </div>
        </div>
        </v-app>



        @include('templates.footer')
    </div>

    <!-- App js -->
    <script src="./js/app.js"></script>
    <!-- plantilla  -->
        {{-- <script>$().DataTable();</script> --}}
    <script src="./js/plantilla.js"></script>
</body>

</html>
