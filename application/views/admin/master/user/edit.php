<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Ubah User</h1>

<?= error_button("Kembali", "fas fa-fw fa-step-backward", "", "", "Admin/Master/User") ?>
<form action="<?= base_url() ?>Admin/Master/User/EditProcess/<?=$user->NOMOR_INDUK;?>" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col">
            <label for="no_induk" class="form-label">No Induk : </label>
            <input type="text" name="nomor_induk" class="form-control" value="<?= $user->NOMOR_INDUK; ?>" disabled>

            <label for="nama" class="form-label mt-4">Nama :</label>
            <input type="text" class="form-control" name="nama" value="<?= $user->NAMA ?>" required>
        </div>
        <div class="col">
            <label for="divisi" class="form-label">Divisi : </label> 
             
            <select id="divisi" name="divisi" class="form-control">
                <?php
                foreach ($listDivisi as $divisi) {  
                    if($divisi->KODE_DIVISI == $user->KODEDIV){ 
                        echo "<option value='$divisi->KODE_DIVISI' selected>$divisi->KODE_DIVISI - $divisi->NAMA_DIVISI</option>";
                    }else{
                        echo "<option value='$divisi->KODE_DIVISI'>$divisi->KODE_DIVISI - $divisi->NAMA_DIVISI</option>"; 
                    }
                }
                ?>
            </select>
            <label for="" class="form-label mt-4">Hak Akses</label>
            <select class="form-control" name="hak_akses">
                <?php
                $hak_akses = [
                    1 => "End User",
                    2 => "Manager",
                    3 => "GM",
                    4 => "Admin"
                ];
                foreach ($hak_akses as $key => $value) {
                    if ($key == $user->KODE_HAK_AKSES) {
                        echo "<option value='$key' selected>$value</option>";
                    } else {
                        echo "<option value='$key'>$value</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <?= error_button("Hapus","fas fa-fw fa-trash","btnDelete")?>

            <?= primary_submit_button("Ubah","fas fa-fw fa-pen") ?>
        </div>
    </div>
</form>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin ingin menghapus data user ini?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" style=" padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;" data-dismiss="modal">Tidak</button> 
                <?= error_button("Ya","","","","Admin/Master/User/DeleteProcess/$user->NOMOR_INDUK")?>
            </div>
        </div>
    </div>
</div>


<script src="<?= asset_url(); ?>js/template/confirmDeleteModalMasterTopik.js"></script>