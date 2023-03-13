<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Laporan Jumlah Komplain</h1>

<form action="<?= base_url() ?>Admin/Laporan/JumlahKomplain" method="get" class="mt-4 mb-4" style="color:black;">
    <div class="row">
        <div class="col">
            <label for="topik" class="form-label">Departemen</label>
            <select name="divisi" class="form-control">
                <?php
                foreach ($departemens as $departemen) {
                    echo "<option value='$departemen->KODE_DIVISI'>$departemen->NAMA_DIVISI</option>";
                }
                ?>
            </select>
            <label for="" class="form-label mt-4">Tahun Periode</label>
            <input type="number" class="form-control" name="tahun" max="<?= $yearnow ?>" min="1950" value="<?= $yearnow ?>" required>
        </div>
        <div class="col">
 

            <label for="topik" class="form-label"></label>
            <button class="btn btn-primary" style="margin-top: 102px; width: 100%;">

            <i class="fas fa-fw fa-file mr-2"></i>
                Buat Laporan</button>
        </div>
        <div class="col">
            <label for="topik" class="form-label"></label>
            <button class="btn btn-primary" style="margin-top: 102px; width:100%;">

                <i class="fas fa-fw fa-print mr-2" style="font-weight: bolder;"></i>
                Cetak Laporan</button>
        </div>
    </div>
</form>
<div>Hasil Laporan :</div>