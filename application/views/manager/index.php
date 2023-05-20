<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Komplain</h1>
<a href="<?= base_url() ?>manager/komplain"> 
    <?= error_button("Kembali","fas fa-fw fa-step-backward")?>  
</a>

<div class="mt-4 mb-4" style="color:black;">
    <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value="">
    <div class="row">
        <div class="col"> 
            <label for="user" class="form-label">Nomor Komplain : <?=$komplain->NO_KOMPLAIN;?></label> <br>            
        </div>
     </div>     
     <div class="row mt-2">
        <div class="col">
            <label for="" class="form-label">Status : <?= $komplain->STATUS; ?></label> 
        </div>
        <div class="col">
            <label for="" class="form-label">Deadline : <?= $komplain->TGL_DEADLINE; ?></label> 
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="user" class="form-label">Tanggal Kejadian</label>

            <input type="text" name="tanggal" id="tanggal" class="form-control" value="<?= $komplain->TGL_KEJADIAN; ?>" disabled>

            <label for="subtopik2" class="form-label mt-4">Subtopik 2</label>
            <input type="text" id="subtopik2" class="form-control" value="<?= $komplain->SUB_TOPIK2; ?> - <?= $komplain->S2DESKRIPSI; ?>" disabled>

        </div>
        <div class="col">
            <label for="" class="form-label">Topik</label>
            <input type="text" class="form-control" id="topik" value="<?= $komplain->TOPIK; ?> - <?= $komplain->TDESKRIPSI; ?>" disabled>

            <label for="" class="form-label mt-4">Subtopik 1</label>
            <input type="text" class="form-control" id="subtopik1" value="<?= $komplain->SUB_TOPIK1; ?> - <?= $komplain->S1DESKRIPSI; ?>" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="" class="form-label mt-4">Deskripsi</label>
            <textarea type="text" rows="5" class="form-control" disabled><?= $komplain->DESKRIPSI_MASALAH; ?></textarea>
        </div>
    </div>
    <?php 
        if ($komplain->STATUS == "CLOSE" || $komplain->STATUS == "CANCEL") {
            echo "<div class='row'>
                    <div class='col'>
                        <label for='' class='form-label mt-4'>AKAR MASALAH</label>
                        <textarea type='text' rows='5' class='form-control' disabled>".$komplain->FEEDBACK->AKAR_MASALAH."</textarea>
                    </div>
                </div>";
            echo "<div class='row'>
                <div class='col'>
                    <label for='' class='form-label mt-4'>TINDAKAN KOREKTIF</label>
                    <textarea type='text' rows='5' class='form-control' disabled>".$komplain->FEEDBACK->T_KOREKTIF."</textarea>
                </div>
            </div>";
            echo "<div class='row'>
                <div class='col'>
                    <label for='' class='form-label mt-4'>TINDAKAN PREVENTIF</label>
                    <textarea type='text' rows='5' class='form-control' disabled>".$komplain->FEEDBACK->T_PREVENTIF."</textarea>
                </div>
            </div>";
        }
    ?>
</div>