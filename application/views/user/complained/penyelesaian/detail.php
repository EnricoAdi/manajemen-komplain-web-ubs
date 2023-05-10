<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Komplain Ditugaskan</h1>

<a href="<?= base_url() ?>User/Complained/Penyelesaian">
    <?= error_button("Kembali", "fas fa-fw fa-step-backward") ?>
</a>
<div class="row mt-4" style="color:black;">
    <div class="col">
        <div>Nomor Komplain : <?= $komplain->NO_KOMPLAIN; ?> </div>   
     
        <div class="mt-2">Pemberi Komplain : <?= $penerbit->NOMOR_INDUK; ?> - <?= ucfirst($penerbit->NAMA); ?> </div>
        <div class="mt-2">Status : <?= $komplain->STATUS; ?> </div>

    </div>
</div>
<div class="row mt-2" style="color:black;">
    <div class="col">
        <label for="topik" class="form-label">Topik</label>
        <input type="text" class="form-control" name="topik" value="<?= $komplain->TOPIK; ?> - <?= $komplain->TDESKRIPSI; ?>" disabled>

        <label for="subtopik1" class="form-label mt-4">Subtopik 1</label>
        <input type="text" class="form-control" name="subtopik1" value="<?= $komplain->SUB_TOPIK1; ?> - <?= $komplain->S1DESKRIPSI; ?>" disabled>

        <label for="subtopik2" class="form-label mt-4">Subtopik 2</label>
        <input type="text" class="form-control" name="subtopik2" value="<?= $komplain->SUB_TOPIK2; ?> - <?= $komplain->S2DESKRIPSI; ?>" disabled>

    </div>
    <div class="col">
        <label for="" class="form-label">Tanggal Komplain</label>
        <input type="text" class="form-control" name="tanggal" value="<?= $komplain->TGL_KEJADIAN; ?>" disabled>

        <label for="" class="form-label mt-4">Asal Divisi</label>
        <input type="text" class="form-control" name="asalDivisi" value="<?= $komplain->PENERBIT->NAMA; ?>" disabled>

    </div>
</div>
<br> 
<div class="row">
    <div class="col">
        <label class="form-label">Daftar Lampiran Komplain</label>
        <table class="table">
            <tbody>
                <?php
                $counter = 1;
                foreach ($komplain->LAMPIRAN as $lampiran) {
                    if ($lampiran->TIPE == 0) {
                        echo "<tr>";
                        echo "<td>";
                        echo '<a href="' . base_url() . 'uploads/' . $lampiran->KODE_LAMPIRAN . '" target="_blank">Lampiran ' . $counter . '</a>';
                        echo "</td>"; 
                        echo "</tr>";
                        $counter = $counter + 1;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col"></div>
</div>
<div class="row mt-4 mb-4">
    <div class="col">
        <?php
        $primaryColor = primary_color();
        $urlAdd = "User/Complained/Penyelesaian/addPage/$komplain->NO_KOMPLAIN";
        $urlEdit = "User/Complained/Penyelesaian/editPage/$komplain->NO_KOMPLAIN";
        if ($komplain->FEEDBACK->T_KOREKTIF == "" || $komplain->FEEDBACK->T_KOREKTIF == null) {
            //jika belum ada penyelesaian 
            echo primary_button("Tambah Penyelesaian", "fas fa-fw fa-plus mr-2", "", "", "$urlAdd");
        } else {
            //jika sudah ada penyelesaian   
            if ($komplain->STATUS != 'CLOSE') {

                echo secondary_button("Ubah Penyelesaian", "fas fa-fw fa-pen mr-2", "", "", "$urlEdit");
            }
        }
        ?>


    </div>
</div>