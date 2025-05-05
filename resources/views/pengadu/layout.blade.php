<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Mal Pelayanan Publik</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="assets/pengadu/assets/mpp-icon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/pengadu/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/pengadu/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/pengadu/assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/pengadu/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="assets/pengadu/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/pengadu/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="assets/pengadu/assets/css/main.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: Medicio
  * Template URL: https://bootstrapmade.com/medicio-free-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
    <header id="header" class="header sticky-top">
        <div class="branding d-flex align-items-center">
            <div class="container position-relative d-flex align-items-center justify-content-end">
                <a href="index.html" class="logo d-flex align-items-center me-auto">
                    <img src="assets/mpp-logo.png" alt="" />
                    <!-- Uncomment the line below if you also wish to use a text logo -->
                    <!-- <h1 class="sitename">Medicio</h1>  -->
                </a>

                <nav id="navmenu" class="navmenu">
                    @php
                        $isLandingPage = request()->routeIs('beranda');
                    @endphp
                    <ul>
                        <li><a href="{{ $isLandingPage ? '#hero' : route('beranda') . '#hero' }}"
                                class="{{ request()->is('/beranda') ?? request()->is('/') ? 'active' : '' }}  ">Beranda</a>
                        </li>
                        <li><a href="{{ $isLandingPage ? '#about' : route('beranda') . '#about' }}">Tentang</a></li>
                        <li class="dropdown">
                            <a href="#"  class="{{ (request()->is('pengaduan') || request()->is('lihat-pengaduan')) ? 'active' : '' }}  "><span>Layanan</span>
                                <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="pengaduan">Pengaduan</a></li>
                                <li><a href="#">Lihat Pengaduan</a></li>
                            </ul>
                        </li>
                        <li class=""><a
                                href="{{ $isLandingPage ? '#contact' : route('beranda') . '#contact' }}">Kontak</a></li>
                        @guest
                            @if (Route::has('login'))
                                <li class="p-0">
                                    <a class=" p-3" href="{{ route('login') }}">
                                        <div class="cta-btn">Login</div>
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="p-0">
                                    <a class="p-3 pe-0 pt-2 pb-2 ps-0" href="{{ route('register') }}">
                                        <div class="cta-btn bg-secondary">Daftar</div>
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer id="footer" class="footer light-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">MAL PELAYANAN PUBLIK KOTA PADANG</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Plaza Andalas lantai 4, Jl. Belakang Lintas No.2f, Olo, Kec. Padang Bar., Kota Padang</p>
                        <p class="mt-3">
                            <strong>Call Center:</strong> <span>0811 1550 0555</span>
                        </p>
                        <p><strong>Email:</strong> <span>mpp@padang.go.id</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#about">Tentang Kami</a></li>
                        <li><a href="#">Layanan</a></li>
                        <li><a href="#contact">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>
                © <span>Copyright</span>
                <strong class="px-1 sitename">MAL PELAYANAN PUBLIK KOTA PADANG</strong>
                <span>2025</span>
            </p>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/pengadu/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/pengadu/assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/pengadu/assets/vendor/aos/aos.js"></script>
    <script src="assets/pengadu/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/pengadu/assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/pengadu/assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/pengadu/assets/js/main.js"></script>
</body>

</html>
