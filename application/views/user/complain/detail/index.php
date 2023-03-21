<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Komplain</h1>
<a href="<?= base_url() ?>User/Complain/ListComplain">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>

</a>

<form action="<?= base_url() ?>User/Complain/Add/pageProcess1" method="post" class="mt-4" style="color:black;">
    <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value="">

    <div class="row">
        <div class="col">
            <label for="user" class="form-label">Tanggal Kejadian</label>

            <input type="text" name="tanggal" id="tanggal" class="form-control" value="<?= $komplain->TGL_KEJADIAN; ?>" disabled>

            <label for="subtopik2" class="form-label mt-4">Subtopik 2</label>
            <input type="text" id="subtopik2" class="form-control" value="<?= $komplain->SUB_TOPIK2; ?> - <?= $komplain->S2DESKRIPSI; ?>" disabled>

        </div>
        <div class="col">
            <label for="inputPassword5" class="form-label">Topik</label>
            <input type="text" class="form-control" id="topik" value="<?= $komplain->TOPIK; ?> - <?= $komplain->TDESKRIPSI; ?>" disabled>

            <label for="" class="form-label mt-4">Subtopik 1</label>
            <input type="text" class="form-control" id="subtopik1" value="<?= $komplain->SUB_TOPIK1; ?> - <?= $komplain->S1DESKRIPSI; ?>" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="" class="form-label mt-4">Deskripsi</label>
            <textarea type="text" class="form-control" disabled><?= $komplain->DESKRIPSI_MASALAH; ?></textarea>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <button type="submit" id="btnNext" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>; padding-right:40px;padding-left:40px; margin:auto">

                <i class="fas fa-fw fa-pen" style="padding-right:30px;"></i>
                Edit
            </button>
        </div>
    </div>
</form>