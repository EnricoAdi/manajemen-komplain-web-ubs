<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Komplain</h1>
<a href="<?= base_url() ?>manager/dashboard"> 
    <?= error_button("Kembali","fas fa-fw fa-step-backward")?>  
</a>

<div class="mt-4" style="color:black;">
    <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value="">
    <div class="row">
        <div class="col"> 
            <label for="user" class="form-label">Nomor Komplain : <?=$komplainUrgent->NO_KOMPLAIN;?></label> <br>            
        </div>
     </div>     
    <div class="row mt-2">
        <div class="col">
            <label for="" class="form-label">Status : <?= $komplainUrgent->STATUS; ?></label> 
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="user" class="form-label">Topik</label>

            <input type="text" name="tanggal" id="tanggal" class="form-control" value="<?= $komplainUrgent->JUDUL; ?>" disabled>

            <label for="subtopik2" class="form-label mt-4">Deadline</label>
            <input type="text" id="subtopik2" class="form-control" value="<?= $komplainUrgent->DEADLINE; ?>" disabled>

        </div>
        <div class="col">
            <label for="" class="form-label">Sisa Waktu</label>
            <input type="text" class="form-control" id="topik" value="<?= $komplainUrgent->SISAWAKTU; ?>" disabled>
        </div>
    </div>
</div>