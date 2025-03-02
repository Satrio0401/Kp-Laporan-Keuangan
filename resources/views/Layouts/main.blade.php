<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Keuangan Kafe </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('focus-2/images/favicon.png') }}">
    <link href="{{ asset('focus-2/vendor/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('focus-2/vendor/chartist/css/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('focus-2/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link rel="stylesheet" href="{{ asset('focus-2/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('focus-2/vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('focus-2/vendor/jqvmap/css/jqvmap.min.css') }}">




</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="/Dashboard" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('images/koin2.png') }}" alt="">
                <h1 class="brand-title">CafeCash</h1>
            </a>

            {{-- <div class="nav-header">
                <a href="/Dashboard" class="brand-logo">
                    <h1 class="brand-title">CafeCash</h1>
                </a> --}}

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                {{-- <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span> --}}
                                {{-- <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    </form>
                                </div> --}}
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            {{-- <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-user"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Martin</strong> has added a <strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="primary"><i class="ti-shopping-cart"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="danger"><i class="ti-bookmark"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Robin</strong> marked a <strong>ticket</strong> as unsolved.
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="primary"><i class="ti-heart"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>David</strong> purchased Light Dashboard 1.0.</p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-image"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong> James.</strong> has added a<strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                    </ul>
                                    <a class="all-notification" href="#">See all notifications <i
                                            class="ti-arrow-right"></i></a>
                                </div>
                            </li> --}}
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="./app-profile.html" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="./page-login.html" class="dropdown-item">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
           
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">
                    <li><a href="/Dashboard" aria-expanded="false"><i class="fa-solid fa-gauge"></i><span class="nav-text">Dashboard</span></a></li>
                    <li><a href="/LaporanPembelian" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Laporan Pembelian</span></a></li>
                    <li><a href="/LaporanReturPembelian" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Laporan Retur Pembelian</span></a></li>
                    <li><a href="/LaporanPenjualanPerBarang" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Laporan Penjualan Per-Barang</span></a></li>
                    <li><a href="/LaporanTransaksiPenjualan" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Laporan Transaksi Penjualan</span></a></li>
                    <li><a href="/LaporanReturPemesanan"aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Laporan Retur Pemesanan</span></a></li>
                    <li><a href="/LaporanStok" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Laporan Stok</span></a></li>
                    <li><a href="/LaporanPengeluaran" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Laporan Pengeluaran</span></a></li>
                    <li><a href="/LaporanBarangED" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Laporan Barang ED</span></a></li>
                    {{-- <li><a class="has-arrow" aria-expanded="false"><i class="fa-regular fa-folder-open"></i><span class="nav-text">Laporan</span></a>
                        <ul aria-expanded="False" style="list-style-type: none; padding: 0; margin: 0;">
                            {{-- <li style="float: left; margin-right: 10px;"><a href="/LaporanLabaRugi" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Laba-Rugi</span></a></li> --}}
                            {{-- <li style="float: left; margin-right: 10px;"><a href="/LaporanPembelian" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Pembelian</span></a></li>
                            <li style="float: left; margin-right: 10px;"><a href="/LaporanReturPembelian" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Retur Pembelian</span></a></li>
                            <li style="float: left; margin-right: 10px;"><a href="/LaporanPenjualanPerBarang" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Penjualan Per-Barang</span></a></li>
                            <li style="float: left; margin-right: 10px;"><a href="/LaporanTransaksiPenjualan" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Transaksi Penjualan</span></a></li>
                            <li style="float: left; margin-right: 10px;"><a href="/LaporanReturPenjualan" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Retur Penjualan</span></a></li>
                            <li style="float: left; margin-right: 10px;"><a href="/LaporanStok" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Stok</span></a></li>
                            <li style="float: left; margin-right: 10px;"><a href="/LaporanPengeluaran" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Pengeluaran</span></a></li>
                            <li style="float: left;"><a href="/LaporanBarangED" aria-expanded="false"><i class="fa-solid fa-file"></i><span class="nav-text">Lap.Barang ED</span></a></li>
                        </ul> --}}
                    {{-- </li> --}} 
                    <li><a href="/DaftarSupplier" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Daftar Supplier</span></a></li>
                    <li><a href="/DaftarMenu" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Daftar Menu</span></a></li>
                    {{-- <li><a href="/DaftarPengguna" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Daftar Pengguna</span></a></li> --}}
                    <li><a href="/" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Log Out</span></a></li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                @yield('Content')
            </div>
        </div>

    <!--**********************************
    Footer start
***********************************-->
<footer class="text-center p-3" style="background-color: #f8f9fa;">
    <p class="mb-0">Created by Your Name | © 2025 All Rights Reserved</p>
</footer>
<!--**********************************
    Footer end
***********************************-->

        
    <script src="{{ asset('focus-2/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('focus-2/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('focus-2/js/custom.min.js') }}"></script>

    <script src="{{ asset('focus-2/vendor/chartist/js/chartist.min.js') }}"></script>

    <script src="{{ asset('focus-2/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('focus-2/vendor/pg-calendar/js/pignose.calendar.min.js') }}"></script>

    <script src="{{ asset('focus-2/js/dashboard/dashboard-2.js') }}"></script>

    <!-- Circle progress -->


</body>

</html>

