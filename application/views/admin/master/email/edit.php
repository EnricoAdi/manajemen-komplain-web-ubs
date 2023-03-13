<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Ubah Email</h1>
<a href="<?= base_url() ?>Admin/Master/Email">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>

</a>
<form action="<?= base_url() ?>Admin/Master/Email/EditProcess/<?= $user->NOMOR_INDUK; ?>" method="post" class="mt-4" style="color:black;">
    <input type="hidden" name="inputAtasan" id="inputAtasan">
    <div class="row">
        <div class="col">
            <label type="button" for="user" title="Pastikan divisi user dan atasan sesuai" class="form-label">User</label>
            <input type="text" class="form-control" value='<?= "$user->NAMA_DIVISI - $user->NOMOR_INDUK - $user->NAMA" ?>' disabled>
            <input type="hidden" name="user" values="<?= $user->NOMOR_INDUK; ?>">
            <label for="email_user" class="form-label mt-4">Email User</label>
            <input type="email" class="form-control" placeholder="@ubslinux.com" name="email_user" value="<?= $user->EMAIL; ?>" required>
        </div>
        <div class="col">
            <label for="" class="form-label">Atasan</label>
            <select id="atasan" class="form-control">

                <?php
                foreach ($managers as $manager) {
                    if ($manager->NOMOR_INDUK == $user->KODE_ATASAN) {
                        echo "<option value='$manager->EMAIL - $manager->NOMOR_INDUK' selected>$manager->NAMA_DIVISI - $manager->NOMOR_INDUK - $manager->NAMA</option>";
                    } else {
                        echo "<option value='$manager->EMAIL - $manager->NOMOR_INDUK'>$manager->NAMA_DIVISI - $manager->NOMOR_INDUK - $manager->NAMA</option>";
                    }
                }
                if ($user->KODE_ATASAN == '' || $user->KODE_ATASAN == null) {
                    echo "<option value='' selected>Belum ada atasan</option>";
                }
                ?>
            </select>
            <label for="" class="form-label mt-4">Email Atasan</label>
            <input type="text" class="form-control" placeholder="@ubslinux.com" id="emailAtasan" disabled>
        </div>
    </div>
    <div class="row mt-4">

        <div class="col">
            <button class="btn btn-danger" id="btnDelete" style="color:black;width:100px;">

                <i class="fas fa-fw fa-trash"></i> Hapus</button>
            <button type="submit" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;width:100px;">Ubah</button>
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
            <div class="modal-body">Apakah anda yakin ingin menghapus data email dan atasan user ini?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-primary" href="<?= base_url() ?>Admin/Master/Email/DeleteProcess/<?= $user->NOMOR_INDUK; ?>">Ya</a>
            </div>
        </div>
    </div>
</div>


<script src="<?= asset_url(); ?>js/template/confirmDeleteModalMasterTopik.js"></script>
<script>
    //script ini digunakan untuk membuat interaktif pengambilan data email dan nomor induk dari manager
    //sebagai atasan dari user yang akan ditambahkan emailnya
    let atasan = document.getElementById('atasan');
    let inputAtasan = document.getElementById('inputAtasan');
    let emailAtasan = document.getElementById('emailAtasan');
    let posisi = atasan.value.indexOf('-');
    emailAtasan.value = atasan.value.substring(0, posisi);
    inputAtasan.value = atasan.value.substring(posisi + 2);
    atasan.addEventListener('change', function() {
        let posisi = atasan.value.indexOf('-');
        emailAtasan.value = atasan.value.substring(0, posisi);
        inputAtasan.value = atasan.value.substring(posisi + 2);
    });
</script>