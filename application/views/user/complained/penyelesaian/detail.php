<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Komplain Ditugaskan</h1>

<a href="<?= base_url() ?>User/Complained/Penyelesaian"> 
        <?= error_button("Kembali","fas fa-fw fa-step-backward")?> 
</a>
<div class="row mt-4" style="color:black;">
    <div class="col">
        <div>Status : <?= $komplain->STATUS; ?> </div>

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
<div class="row mt-4">
    <div class="col">
        <?php 
            $primaryColor = primary_color();
            $urlAdd = "User/Complained/Penyelesaian/addPage/$komplain->NO_KOMPLAIN";
            $urlEdit = "User/Complained/Penyelesaian/editPage/$komplain->NO_KOMPLAIN";
            if($komplain->FEEDBACK->T_KOREKTIF=="" || $komplain->FEEDBACK->T_KOREKTIF==null ){
                //jika belum ada penyelesaian 
                echo primary_button("Tambah Penyelesaian","fas fa-fw fa-plus mr-2","","","$urlAdd");
            }else{
                 //jika sudah ada penyelesaian  
                echo secondary_button("Ubah Penyelesaian","fas fa-fw fa-pen mr-2","","","$urlEdit");
            }
        ?>
       
         
    </div>
</div>