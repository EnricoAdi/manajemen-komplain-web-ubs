<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah User</h1>

<?= error_button("Kembali", "fas fa-fw fa-step-backward", "", "", "Admin/Master/User") ?>


<form action="<?= base_url() ?>Admin/Master/User/AddProcess" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col">
            <label for="no_induk" class="form-label">No Induk : </label>
            <input type="text" name="nomor_induk" class="form-control" required>

            <label for="nama" class="form-label mt-4">Nama :</label>
            <input type="text" class="form-control"  name="nama" required>
        </div>
        <div class="col">
            <label for="divisi" class="form-label">Divisi : </label>
            <select id="divisi" name="divisi" class="form-control">
                <?php
                foreach ($listDivisi as $divisi) {
                    echo "<option value='$divisi->KODE_DIVISI'>$divisi->KODE_DIVISI - $divisi->NAMA_DIVISI</option>";
                }
                ?>
            </select>
            <label for="" class="form-label mt-4">Hak Akses</label>
            <select class="form-control" name="hak_akses">
                <option value="1">End User</option>
                <option value="2">Manager</option>
                <option value="3">GM</option>
                <option value="4">Admin</option>
            </select>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <?= primary_submit_button("Tambah") ?>
        </div>
    </div>
</form>