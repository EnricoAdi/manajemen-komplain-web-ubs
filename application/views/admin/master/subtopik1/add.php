<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Subtopik1</h1>
 
<?= error_button("Kembali","fas fa-fw fa-step-backward","","","Admin/Master/Subtopik1")?>

<form action="<?= base_url() ?>Admin/Master/Subtopik1/AddProcess" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col">
            <label for="topik" class="form-label">Topik</label>
            <select name="topik" class="form-control">

                <?php
                foreach ($list_topik as $topik) {
                    $kodesubstr = substr($topik->KODE_TOPIK, 0, 3);
                    echo "<option value='$topik->KODE_TOPIK'>$kodesubstr - $topik->TOPIK - $topik->NAMA_DIVISI</option>";
                }
                ?>
            </select>
        </div>
        <div class="col"> 
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="deskripsi" class="form-label mt-5">Deskripsi</label>
            <textarea class="form-control" placeholder="" name="deskripsi" required></textarea>
        </div> 
    </div>
    <div class="row mt-4">
        <div class="col"> 
            <?= primary_submit_button("Tambah")?>
        </div>
    </div>
</form>
