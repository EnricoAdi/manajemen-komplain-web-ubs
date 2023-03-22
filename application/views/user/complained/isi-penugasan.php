<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Isi Penugasan</h1>

<a href="<?= base_url() ?>User/Complained/Penugasan">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">


        <i class="fas fa-fw fa-step-backward mr-2"></i>
        Kembali
    </button>
</a>
<form action="<?= base_url() ?>User/Complained/Penugasan/addPenugasan/<?= $komplain->NO_KOMPLAIN ?>" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col">
            <label for="" class="form-label mt-4">Nomor Feedback : <?= $komplain->NO_KOMPLAIN; ?> </label>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <label for="topik" class="form-label">Topik</label>
            <input type="text" class="form-control" name="topik" value="<?= $komplain->TOPIK; ?> - <?= $komplain->TDESKRIPSI; ?>" disabled>

            <label for="subtopik1" class="form-label mt-4">Subtopik 1</label>
            <input type="text" class="form-control" name="subtopik1" value="<?= $komplain->SUB_TOPIK1; ?> - <?= $komplain->S1DESKRIPSI; ?>" disabled>

            <label for="subtopik2" class="form-label mt-4">Subtopik 2</label>
            <input type="text" class="form-control" name="subtopik2" value="<?= $komplain->SUB_TOPIK2; ?> - <?= $komplain->S2DESKRIPSI; ?>" disabled>

            <label for="user" class="form-label mt-4">User untuk ditugaskan</label>

            <?php
            if ($komplain->PENUGASAN != null) {
                echo "<select name='user' class='form-control' disabled>";
                foreach ($users as $user) {
                    if ($user->NOMOR_INDUK == $komplain->PENUGASAN) {
                        echo "<option value='$user->NOMOR_INDUK' selected>$user->NOMOR_INDUK - $user->NAMA </option>";
                    } else {
                        echo "<option value='$user->NOMOR_INDUK'>$user->NOMOR_INDUK - $user->NAMA </option>";
                    }
                }
            } else {
                echo "<select name='user' class='form-control'>";
                foreach ($users as $user) {
                    echo "<option value='$user->NOMOR_INDUK'>$user->NOMOR_INDUK - $user->NAMA </option>";
                }
            }
            echo "</select>";
            ?>
        </div>
        <div class="col">
            <label for="" class="form-label">Tanggal Komplain</label>
            <input type="text" class="form-control" name="tanggal" value="<?= $komplain->TGL_KEJADIAN; ?>" disabled>

            <label for="" class="form-label mt-4">Asal Divisi</label>
            <input type="text" class="form-control" name="asalDivisi" value="<?= $komplain->PENERBIT->NAMA_DIVISI; ?>" disabled>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <button id="btnDelete" class="btn btn-warning" style="color:black; background-color: <?= error_color(); ?>;">

                <i class="fas fa-fw fa-trash mr-2"></i>
                Hapus Penugasan
            </button>
            <button type="submit" id="btnNext" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>; width:220px; margin-left:15px;">

                <i class="fas fa-fw fa-save mr-2"></i>
                Simpan Penugasan</button>
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
            <div class="modal-body">Apakah anda yakin ingin menghapus penugasan?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-primary" href="<?= base_url() ?>User/Complained/Penugasan/hapusPenugasan/<?= $komplain->NO_KOMPLAIN ?>">Ya</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteTopik(event) {
        event.preventDefault();
        $('#confirmDeleteModal').modal('show');
    }
    let btnDelete = document.getElementById("btnDelete");
    btnDelete.addEventListener("click", deleteTopik);
</script>