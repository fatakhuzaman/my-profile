<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fatakhuzaman - Portfolio">
    <meta name="keywords" content="personal, portfolio new, html, one page, bootstrap, new html template, design, creative, onepage, clean, modern">
    <meta name="author" content="Fatakhuzaman">
    <!-- PAGE TITLE -->
    <title>Fatakhuzaman - Home</title>
    <!-- FAV ICON -->
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <!-- ALL GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- FONT AWESOME CSS -->
    <link rel="stylesheet" href="{{ asset('fonts/remixicon.css') }}">
    <!-- MAGNIFIC CSS -->
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <!-- NICE SELECT CSS -->
    <link rel="stylesheet" href="{{ asset('css/nice-select.min.css') }}">
    <!-- ANIMATE CSS -->
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <!-- SLICK CSS -->
    <link rel="stylesheet" href="{{ asset('css/slick.min.css') }}">
    <!-- SPACING CSS -->
    <link rel="stylesheet" href="{{ asset('css/spacing.css') }}">
    <!-- MAIN STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- RESPONSIVE CSS -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- START PRELOADER AREA-->
    <div class="preloader">
        <svg viewbox="0 0 1000 1000" preserveaspectratio="none">
            <path id="preloaderSvg" d="M0,1005S175,995,500,995s500,5,500,5V0H0Z"></path>
        </svg>
        <div class="preloader-heading">
            <div class="load-text">
                <span>f</span>
                <span>a</span>
                <span>t</span>
                <span>a</span>
                <span>k</span>
                <span>h</span>
                <span>u</span>
                <span>z</span>
                <span>a</span>
                <span>m</span>
                <span>a</span>
                <span>n</span>
            </div>
        </div>
    </div>
    <!-- END PRELOADER AREA -->
    <!-- START MENU DESIGN AREA -->
    <header class="main-header">
        <div class="header-upper">
            <div class="container">
                <div class="header-inner d-flex align-items-center">
                    <!-- START LOGO DESIGN AREA -->
                    <div class="logo-outer">
                        <div class="logo">
                            <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" title="Logo" /></a>
                        </div>
                    </div>
                    <!-- / END LOGO DESIGN AREA -->
                    <!-- START NAV DESIGN AREA -->
                    <div class="nav-outer clearfix mx-auto">
                        <!-- Main Menu -->
                        <nav class="main-menu navbar-expand-lg">
                            <div class="navbar-header">
                                <div class="mobile-logo">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('images/logo.png') }}" alt="Logo" title="Logo" />
                                    </a>
                                </div>
                                <!-- Toggle Button -->
                                <button type="button" class="navbar-toggle" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="navbar-collapse collapse">
                                <ul class="navigation onepage clearfix">
                                    <li><a class="nav-link-click" href="about">about</a></li>
                                    <li><a class="nav-link-click" href="services">services</a></li>
                                    <li><a class="nav-link-click" href="works">works</a></li>   
                                    <li><a class="nav-link-click" href="contact">Contact</a></li>
                                    <li><a class="nav-link-click" href="blog">Blog</a></li>
                                </ul>
                            </div>
                        </nav>
                        <!-- / END NAV DESIGN AREA -->
                    </div>
                    <div class="menu-btns">
                        <a href="/contact" class="theme-btn">Hire Me<i class="ri-shake-hands-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- / END MENU DESIGN AREA -->