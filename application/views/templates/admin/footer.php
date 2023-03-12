</div>
                <!-- /.container-fluid -->
				
            </div>
            <!-- End of Main Content -->
 

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah anda yakin untuk melakukan logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                    <a class="btn btn-primary" href="<?= base_url() ?>Auth/logout">Ya</a>
                </div>
            </div>
        </div>
    </div>

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

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><?= $this->session->flashdata('confirmation') ?></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                    <a class="btn btn-primary" href="<?= base_url() ?><?= $this->session->flashdata('url') ?>">Ya</a>
                </div>
            </div>
        </div>
    </div> 
    <script src="<?= asset_url(); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= asset_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
    <script src="<?= asset_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    
    <script src="<?= asset_url(); ?>js/template/sb-admin-2.min.js"></script>
 
    <!-- Chart JS -->
    <script src="<?= asset_url(); ?>vendor/chart.js/Chart.min.js"></script>
    <script src="<?= asset_url(); ?>js/template/demo/chart-area-demo.js"></script>
    <script src="<?= asset_url(); ?>js/template/demo/chart-pie-demo.js"></script>
    <script src="<?= asset_url(); ?>js/template/demo/chart-bar-demo.js"></script>

    
    <!-- Datatable -->
    <script src="<?= asset_url(); ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= asset_url(); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script> 
    <script src="<?= asset_url(); ?>js/demo/datatables-demo.js"></script>
    
    <?php if ($this->session->flashdata('message') && $this->session->flashdata('message')!='')   : ?>
        <script type="text/javascript"> 
            $('#popUpModal').modal('show');
         </script> 
         <?php
            //unset
            $this->session->unset_userdata('message');
         ?>
    <?php endif; ?>
    <?php if ($this->session->flashdata('confirmation') && $this->session->flashdata('confirmation')!='')   : ?>
        <script type="text/javascript"> 
            $('#confirmModal').modal('show');
         </script> 
         <?php
            //unset
            $this->session->unset_userdata('confirmation');
         ?>
    <?php endif; ?>
</body>

</html>