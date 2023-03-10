<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Input Subtopik1</h1>
<a href="<?= base_url() ?>Admin/Master/Subtopik1">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>

</a>

<form action="<?= base_url() ?>Admin/Master/Subtopik1/AddProcess" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col">
            <label for="topik" class="form-label">Topik</label>
            <select name="topik" class="form-control">

                <?php
                foreach ($list_topik as $topik) {
                    echo "<option value='$topik->KODE_TOPIK'>$topik->KODE_TOPIK - $topik->TOPIK</option>";
                }
                ?>
            </select>
        </div>
        <div class="col"></div>
    </div>
    <div class="row">
        <div class="col">
            <label for="deskripsi" class="form-label mt-5">Deskripsi</label>
            <textarea class="form-control" placeholder="" name="deskripsi" required></textarea>
        </div> 
    </div>
    <div class="row mt-4">
        <div class="col">
            <button type="submit" class="btn btn-warning" style="color:black;">Tambah</button>
        </div>
    </div>
</form>