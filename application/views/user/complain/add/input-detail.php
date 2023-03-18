<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color:#F1F2F5;">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/page/1">Tanggal</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
</nav>
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Komplain Baru</h1>
 

<form action="<?= base_url() ?>User/Complain/Add/addComplainProcess" method="post" class="mt-4" style="color:black;" enctype="multipart/form-data">
    <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value="">

    <div class="row">
        <div class="col">

            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="<?= $tanggalPreSended ?>" disabled>

            <label class="form-label mt-2">Topik</label>
            <input type="text" class="form-control" id="topik" value="<?= $topikShow ?>" disabled>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <label for="user" class="form-label">Feedback Sebelumnya</label>

            <select id="feedback" name="feedback" class="form-control">
                <?php
                ?>

            </select>
        </div>
        <div class="col">
            <label class="form-label">Unggah Lampiran</label>
            <input type="file" class="form-control" name="lampiran" style="padding-top:30px; padding-left:20px; height:100px;">
        </div>
    </div>

    <div class="row">
        <div class="col">

            <label class="form-label">Deskripsi Masalah</label>
            <textarea name="deskripsi" class="form-control" cols="30" rows="3" required></textarea>

        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <a href="<?= base_url() ?>User/Complain/Add/page/1" class="btn btn-warning" style="color:black; background-color: <?= error_color(); ?>;">Sebelumnya</a>
            <button type="submit" id="btnNext" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>; width:120px;">

                <i class="fas fa-fw fa-paper-plane mr-2"></i>
                Kirim</button>
        </div>
    </div>
</form>