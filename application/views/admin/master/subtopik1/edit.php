<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Edit Subtopik1</h1>

<?= error_button("Kembali","fas fa-fw fa-step-backward","","","Admin/Master/Subtopik1")?>

<form action="<?= base_url() ?>Admin/Master/Subtopik1/EditProcess/<?= $subtopic->KODE_TOPIK; ?>/<?= $subtopic->SUB_TOPIK1; ?>" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col"> 
            <label for="topik" class="form-label">Kode Subtopik 1</label>
            <input type="text" class="form-control" value="<?= $subtopic->SUB_TOPIK1;?>" disabled>
        </div>
        <div class="col">
            
            <label for="topik" class="form-label">Topik</label>
            <select name="topik" class="form-control" disabled>

                <?php
                foreach ($list_topik as $topik) {
                    $kodesubstr = substr($topik->KODE_TOPIK, 0, 3);
                    if ($topik->KODE_TOPIK == $subtopic->KODE_TOPIK) {
                        echo "<option value='$topik->KODE_TOPIK' selected >$kodesubstr - $topik->TOPIK - $topik->NAMA_DIVISI</option>";
                    } else {

                        echo "<option value='$topik->KODE_TOPIK' >$kodesubstr - $topik->TOPIK  - $topik->NAMA_DIVISI</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="deskripsi" class="form-label mt-5">Deskripsi</label>
            <textarea class="form-control" placeholder="" name="deskripsi" required><?= $subtopic->DESKRIPSI; ?></textarea>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">  
            <?= error_button("Hapus","fas fa-fw fa-trash","btnDelete")?>
            <?= primary_submit_button("Ubah","fas fa-fw fa-pen")?>
         </div>
    </div>
</form> 

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin ingin menghapus subtopik 1 ini?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-danger" href="<?= base_url() ?>Admin/Master/Subtopik1/DeleteProcess/<?= $subtopic->KODE_TOPIK; ?>/<?= $subtopic->SUB_TOPIK1; ?>">Ya</a>
            </div>
        </div>
    </div>
</div> 


<script src="<?= asset_url(); ?>js/template/confirmDeleteModalMasterTopik.js"></script>