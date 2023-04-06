<?php
//define sidebar
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
    <link href="<?= asset_url(); ?>css/fontNunito.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= asset_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="<?= asset_url(); ?>css/template/sb-admin-2.min.css" rel="stylesheet">
    <!-- Data table -->
    <link href="<?= asset_url(); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <img src="<?= asset_url(); ?>images/logo.png" alt="ubs" style="width:100%; margin-top:30px; border-radius:10px;">
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-2">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item  
            <?php
                    if ($navigation == "Dashboard") {
                        echo "active";
                    }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>User/Dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Komplain Diajukan
            </div>
            <li class="nav-item  
            <?php
                if ($navigation == "Complain") {
                    echo "active";
                }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>User/Complain/List" data-toggle="collapse" data-target="#collapsePagesLaporan" aria-expanded="true" aria-controls="collapsePagesLaporan">

                    <i class="fas fa-fw fa-paper-plane"></i>
                    <span>Ajukan Komplain</span>
                </a>
                <div id="collapsePagesLaporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">

                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Pengajuan Komplain</h6>
                        <a class="collapse-item" href="<?= base_url(); ?>User/Complain/ListComplain">Daftar Komplain</a>
                        <a class="collapse-item" href="<?= base_url()?>User/Complain/Add/page/1">Tambah Komplain</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?php
                if ($navigation == "Solved") {
                    echo "active";
                }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>User/Complain/Solved">
                    <i class="fas fa-fw fa-envelope-open"></i>
                    <span>Penyelesaian Komplain <span style="margin-left:15%;">Diterima</span></span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Komplain Diterima
            </div>

            <li class="nav-item <?php
                if ($navigation == "ComplainedList") {
                    echo "active";
                }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>User/Complained/ListComplained">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Daftar Komplain</span>
                </a>
            </li>

            <li class="nav-item 
             <?php
            if ($navigation == "Complained") {
                echo "active";
            }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>User/Complained" data-toggle="collapse" data-target="#collapsePagesPenyelesaianKomplain" aria-expanded="true" aria-controls="collapsePagesPenyelesaianKomplain">

                    <i class="fas fa-fw fa-inbox"></i>
                    <span>Penyelesaian Komplain <span style="margin-left:15%;">Diajukan</span></span>
                </a>
                <div id="collapsePagesPenyelesaianKomplain" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">

                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Penyelesaian Komplain</h6>
                        <a class="collapse-item" href="<?= base_url(); ?>User/Complained/Penugasan">Penugasan</a>
                        <a class="collapse-item" href="<?= base_url(); ?>User/Complained/Done">Done</a>
                    </div>
                </div>
            </li>
            <li class="nav-item 
                <?php
                if ($navigation == "Feedback") {
                    echo "active";
                }
            ?>">
                <a class="nav-link" href="<?= base_url(); ?>User/Complained/Penyelesaian">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Komplain Ditugaskan</span></a>
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
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= $login->NAMA; ?></span>
                                <img class="img-profile rounded-circle" src="<?= asset_url(); ?>images/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <?= $login->NOMOR_INDUK; ?> - <?= $login->NAMA; ?> 
                                </a>
                                <a class="dropdown-item" href="#">
                                    <?= "DIVISI ".$login->NAMA_DIVISI; ?>
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">