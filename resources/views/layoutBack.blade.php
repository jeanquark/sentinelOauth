<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <!--<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        body {
            height: 100%;
            background-color: #fff;
        }
        .navbar {
            border: 0;
        }
        .side-nav {
            top: 50px;
        }
    </style>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand pull-left" href="{{ route('home') }}">Back to site</a>
            </div><!-- /.navbar-header -->

            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li>
                    @if (Sentinel::check())
                        @if (Sentinel::getUser()->avatar)
                            <li>
                                <img src="{{ Sentinel::getUser()->avatar }}" width="50" >
                            </li>
                        @else
                            <li>
                                <img src="http://www.gravatar.com/avatar/?d=identicon" width="50">
                            </li>
                        @endif
                    @endif
                </li>
                <li class="dropdown">
                    @if (Sentinel::check())
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{ Sentinel::getUser()->email }} <b class="caret"></b></a>
                    @else
                        <a href="#">You are not logged in</a>
                    @endif
                    <ul class="dropdown-menu">

                        @if (Sentinel::check())
                            <li>
                                <a href="{{ route('logout') }}">Logout</a>
                            </li>
                        @endif

                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="{{ route('admin') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    @if (Sentinel::inRole('admin'))
                        <li>
                            <a href="{{ route('admin.user.index') }}"><i class="fa fa-fw fa-users"></i> Manage Users</a>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
                
                <!-- Notifications -->
                @include('sentinel.notifications')

                <!-- /.content -->
                @yield('content')

            </div><!-- /.container-fluid -->

        </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- jQuery -->
    <!--<script src="{{ asset('js/jquery.js') }}"></script>-->
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <!--<script src="{{ asset('js/bootstrap.min.js') }}"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>

</html>
