<?php
//define sidebar admin
$routes = [
    [
        "name" => "Dashboard",
        "icon" => "fas fa-fw fa-tachometer-alt",
        "url" => "index.html",
        "type" => "single" //ada single, section, dropdown
    ],
    [
        "name" => "Komplain Diajukan",
        "icon" => "",
        "url" => "",
        "type" => "section",
        "child" => [
            [
                "name" => "Ajukan Komplain",
                "icon" => "fas fa-fw fa-paper-plane",
                "url" => "index.html",
                "type" => "single"
            ],
            [
                "name" => "Penyelesaian Komplain Diterima",
                "icon" => "fas fa-fw fa-envelope-open",
                "url" => "index.html",
                "type" => "single"
            ],
        ]
    ],
    [
        "name" => "Komplain Diterima",
        "icon" => "",
        "url" => "",
        "type" => "section",
        "child" => [
            [
                "name" => "Komplain Ditugaskan",
                "icon" => "fas fa-fw fa-list",
                "url" => "index.html",
                "type" => "single"
            ],
            [
                "name" => "Penyelesaian Komplain Diajukan",
                "icon" => "fas fa-fw fa-wrench",
                "url" => "index.html",
                "type" => "single"
            ],
        ]
    ]
];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $page_title ?> </title>
    <link rel="icon" type="image/x-icon" href="<?= asset_url(); ?>images/logo.png">
    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= asset_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="<?= asset_url(); ?>css/template/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <img src="<?= asset_url(); ?>images/logo.png" alt="ubs" style="width:100%;">
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php 
                if($page_title=="Dashboard Admin"){
                    echo "active";
                }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>Admin/Dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item  <?php 
                if($page_title=="Master"){
                    echo "active";
                }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>Admin/Dashboard" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">

                    <i class="fas fa-fw fa-book"></i>
                    <span>Master</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">

                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Master :</h6>
                        <a class="collapse-item" href="<?= base_url(); ?>Admin/Master/Topik">Master Topik</a> 
                        <a class="collapse-item" href="<?= base_url(); ?>Admin/Master/User">Master User</a> 
                        <a class="collapse-item" href="<?= base_url(); ?>Admin/Master/Email">Master Email</a> 
                    </div>
                </div>
            </li> 
            <li class="nav-item  <?php 
                if($page_title=="Master"){
                    echo "active";
                }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>Admin/Dashboard" data-toggle="collapse" data-target="#collapsePagesLaporan" aria-expanded="true" aria-controls="collapsePagesLaporan">

                    <i class="fas fa-fw fa-file"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapsePagesLaporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">

                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Laporan :</h6>
                        <a class="collapse-item" href="<?= base_url(); ?>Admin/Laporan/JumlahKomplain">Laporan Jumlah Komplain</a> 
                        <a class="collapse-item" href="<?= base_url(); ?>Admin/Laporan/DetailFeedback">Laporan Detail Feedback</a> 
                        <a class="collapse-item" href="<?= base_url(); ?>Admin/Laporan/PerTopik">Laporan Per Topik</a> 
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->




                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= $login['NAMA'] ?></span>
                                <img class="img-profile rounded-circle" src="<?= asset_url(); ?>images/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <?= $login['NAMA']; ?>
                                </a>
                                <!--   <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" style="color: #ff2121;">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">