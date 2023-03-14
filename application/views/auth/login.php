<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $page_title ?> </title>
    <link rel="stylesheet" href=" <?= asset_url(); ?>css/login/style.css"> 
    <link href=" <?= asset_url(); ?>css/fontLato.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?= asset_url(); ?>images/logo.png"> 
    <!-- <link href="<?= asset_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="<?= asset_url(); ?>css/fontawesome.min.css">
    <link href="<?= asset_url(); ?>bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body style="background-color: <?= primary_color()?>; margin-bottom:3%;"> 
    <section class="" style="margin-top: 3%;">
        <div class="container">

            <div class="row justify-content-center">

                <div class=" col-md-12 col-lg-10">
                    <div class="wrap d-md-flex" style="padding-bottom: 7%; padding-top:10px">
                        <div class="img" style="background-image: url(<?= asset_url(); ?>images/logo.png); background-size:90%;">
                            <!-- <img src="" class="img"> -->

                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h2 class="mb-4" style="font-weight: bold;">Manajemen Komplain Antar Departemen</h2>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Login</h3>
                                </div>
                            </div>

                            <form action="" method="POST" class="signin-form"> 
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Nomor Induk</label>
                                    <input type="text" class="form-control" placeholder="01234513" name="nomor_induk" value="<?= set_value('nomor_induk') ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" value="<?= set_value('password') ?>" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="form-control btn rounded submit px-3"
                                    style="background-color: <?= primary_color()?>; color:white;">
                                        Login</button>
 
                                </div>

                               <!-- <div class="form-group d-md-flex" style="display:none;">
                                    <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">Ingat saya
                                            <input type="checkbox" name="remember">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 

    <div class="modal fade" id="popUpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                    
                    <?= $this->session->flashdata('header') ?>
                
                </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><?= $this->session->flashdata('message') ?></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button> 
                </div>
            </div>
        </div>
    </div>


    <script src="<?= asset_url(); ?>js/jquery.min.js"></script>
    <script src="<?= asset_url(); ?>js/popper.js"></script>
    <script src="<?= asset_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?= asset_url(); ?>js/main.js"></script>
    <script src="<?= asset_url(); ?>bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


    <script src="<?= asset_url(); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= asset_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= asset_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    
    <script src="<?= asset_url(); ?>js/template/sb-admin-2.min.js"></script>
    <script src="<?= asset_url(); ?>vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= asset_url(); ?>js/template/demo/chart-area-demo.js"></script>
    <script src="<?= asset_url(); ?>js/template/demo/chart-pie-demo.js"></script>



    <script type="text/javascript">
        setTimeout(() => {
            document.getElementById("msg1").style.visibility = "hidden";
        }, 4000);
 
    </script>
    <?php if ($this->session->flashdata('message')) : ?>
        <script type="text/javascript"> 
            $('#popUpModal').modal('show');
         </script>
         <?php
            //unset
            $this->session->unset_userdata('message');
         ?>
    <?php endif; ?>
</body>

</html>