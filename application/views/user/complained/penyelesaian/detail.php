<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Komplain Ditugaskan</h1>

<a href="<?= base_url() ?>User/Complained/Penyelesaian">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
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
        <input type="text" class="form-control" name="asalDivisi" value="<?= $komplain->PENERBIT->NAMA_DIVISI; ?>" disabled>

    </div>
</div>
<div class="row mt-4">
    <div class="col">
        <?php 
            $primaryColor = primary_color();
            $urlAdd = base_url()."User/Complained/Penyelesaian/addPage/$komplain->NO_KOMPLAIN";
            $urlEdit = base_url()."User/Complained/Penyelesaian/editPage/$komplain->NO_KOMPLAIN";
            if($komplain->FEEDBACK->T_KOREKTIF=="" || $komplain->FEEDBACK->T_KOREKTIF==null ){
                //jika belum ada penyelesaian
                echo " 
                <a href='$urlAdd'> 
                    <button type='submit' class='btn btn-warning' style='color:white; background-color: $primaryColor; width:220px;'>
                        <i class='fas fa-fw fa-plus mr-2'></i>
                        Tambah Penyelesaian
                    </button>
                </a>";
            }else{
                 //jika sudah ada penyelesaian 
                echo "
                <a href='$urlEdit'>
                    <button type='submit' class='btn btn-warning' style='color:black; width:220px; margin-left:10px;'>

                        <i class='fas fa-fw fa-pen mr-2'></i>
                        Ubah Penyelesaian
                    </button> 
                </a>";
            }
        ?>
       
         
    </div>
</div>