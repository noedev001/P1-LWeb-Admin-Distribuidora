<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>Distribuidora E&E - @yield('title')</title>

    <!-- Favicons -->
    <link href="img/apple-touch-icon1.png" rel="icon">
    <link href="img/apple-touch-icon1.png" rel="apple-touch-icon">

    <!-- Bootstrap core CSS -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--external css-->
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-daterangepicker/daterangepicker.css" />

    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="lib/advanced-datatable/css/DT_bootstrap.css" />

    <link href="lib/fancybox/jquery.fancybox.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet">
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/chart-master/Chart.js"></script>




    <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />

    <link href="css/mystyle.css" rel="stylesheet">

    <link rel="stylesheet" href="css/to-do.css">

    <link href="css/style-responsive.css" rel="stylesheet">




</head>

<body>
    <section id="container">

        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>DIST<span>E&E</span></b></a>
            <!--logo end-->
            <div id="noti">
                @yield('contenidonoti')
            </div>
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li>

                        <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            {{ __('Cerrar sesión') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </li>
                </ul>
            </div>
        </header>
        <!--header end-->
        <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">
                    <p class="centered">
                        @yield('foto')
                    </p>
                    <h5 class="centered"> {{ Auth::user()->name }} </h5>

                    @yield('menu')




                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper site-min-height" style="background-color: #dce0e1 ;">
                <div class="col-lg-12 main-chart">

                    <div id="app">
                        @yield('contenido')

                    </div>
                </div>
                <!-- /row -->
            </section>
        </section>
        <!--main content end-->
        <!--footer start-->
        <footer class="site-footer">
            <div class="text-center">
                <p>
                    &copy; Copyrights <strong>Distribuidora E&E</strong>. Derechos Reservados
                </p>
                <div class="credits">
                </div>
                <a href="index.html#" class="go-top">
                    <i class="fa fa-angle-up"></i>
                </a>
            </div>
        </footer>
        <!--footer end-->
    </section>

    <!--Laravel - vue-->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="lib/jquery/jquery.min.js"></script>

    <script src="lib/bootstrap/js/bootstrap.min.js"></script>

    <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>


    <!--common script for all pages-->

    <script type="text/javascript" src="lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript" src="lib/bootstrap-daterangepicker/date.js"></script>
    <script type="text/javascript" src="lib/bootstrap-daterangepicker/daterangepicker.js"></script>

    <script type="text/javascript" src="lib/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>



    <script type="text/javascript" language="javascript" src="lib/advanced-datatable/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="lib/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="lib/advanced-datatable/js/DT_bootstrap.js"></script>



    <script src="lib/fancybox/jquery.fancybox.js"></script>
    <!--common script for all pages-->


    <script src="lib/jquery.scrollTo.min.js"></script>
    <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
    <!--common script for all pages-->
    <script src="lib/common-scripts.js"></script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="lib/jquery.sparkline.js"></script>

    <script src="lib/sparkline-chart.js"></script>




    <script src="lib/zabuto_calendar.js"></script>
    <script type="text/javascript" src="lib/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="lib/gritter-conf.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var unique_id = $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: '{{ Auth::user()->name }}',
                // (string | mandatory) the text inside the notification
                text: 'DISTRIBUIDORA E&E',
                // (string | optional) the image to display on the left
                image: 'img/lauch.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: 8000,
                // (string | optional) the class name you want to apply to that specific message
                class_name: 'my-sticky-class'
            });


            return false;
        });
    </script>
    <script type="application/javascript">
        $(document).ready(function() {



            $("#my-calendar").zabuto_calendar({
                action: function() {
                    return myDateFunction(this.id, false);
                },
                action_nav: function() {
                    return myNavFunction(this.id);
                },



            });
        });

        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>

</body>

</html>
