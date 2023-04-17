<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color:#F1F2F5;">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihDivisi">Pilih Divisi</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihTopik/<?= $divisi->KODE_DIVISI; ?>">Pilih Topik</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihSubTopik1/<?= $divisi->KODE_DIVISI; ?>/<?= $topik->KODE_TOPIK; ?>">Pilih Subtopik1</a></li>
        <li class="breadcrumb-item "><a href="<?= base_url() ?>User/Complain/Add/pilihSubTopik2/<?= $divisi->KODE_DIVISI; ?>/<?= $topik->KODE_TOPIK; ?>/<?= $subtopik1->SUB_TOPIK1; ?>/<?= $subtopik2->SUB_TOPIK2; ?>">Pilih Subtopik2</a></li>
        <li class="breadcrumb-item active">Pilih Lampiran</li> 
    </ol>
</nav>
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Komplain Baru</h1>


<form action="<?= base_url() ?>User/Complain/Add/addComplainProcess/<?= $divisi->KODE_DIVISI ?>/<?= $topik->KODE_TOPIK ?>/<?= $subtopik1->SUB_TOPIK1 ?>/<?= $subtopik2->SUB_TOPIK2 ?>" method="post" class="mt-4" style="color:black;" enctype="multipart/form-data">
    <!-- <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value=""> -->

    <div class="row">
        <div class="col">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="<?= $tanggalPreSended ?>" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col">

            <label class="form-label mt-2">Topik</label>
            <input type="text" class="form-control" id="topik" value="<?= $topik->KODE_TOPIK ?> - <?= $topik->DESKRIPSI; ?>" disabled>

            <label class="form-label mt-2">Sub Topik 1</label>
            <input type="text" class="form-control" id="subtopik1" value="<?= $subtopik1->SUB_TOPIK1 ?> - <?= $subtopik1->DESKRIPSI; ?>" disabled>
            
        </div>
        <div class="col">
            <label class="form-label mt-2">Divisi</label>
            <input type="text" class="form-control" id="divisi" value="<?= $divisi->KODE_DIVISI ?> - <?= $divisi->NAMA_DIVISI ?> " disabled>

            <label class="form-label mt-2">Sub Topik 2</label>
            <input type="text" class="form-control" id="subtopik2" value="<?= $subtopik2->SUB_TOPIK2 ?> - <?= $subtopik2->DESKRIPSI; ?>" disabled>

        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <label for="user" class="form-label">Feedback Sebelumnya</label>

            <select id="feedback" name="feedback" class="form-control">

            </select>
        </div>
        <div class="col">
            <label class="form-label">Unggah Lampiran (.jpg, .png, .pdf, .docx, .xlsx, .txt)</label>
            <input type="file" class="form-control" name="lampiran[]" style="padding-top:30px; padding-left:20px; height:100px;" multiple>
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
            <?= error_button("Sebelumnya", null, "", "", "User/Complain/Add/pilihSubTopik2/$divisi->KODE_DIVISI/$topik->KODE_TOPIK/$subtopik1->SUB_TOPIK1/$subtopik2->SUB_TOPIK2"); ?>
            <?= primary_submit_button("Kirim", "fas fa-fw fa-paper-plane mr-2", "btnNext", "") ?>
        </div>
    </div>
</form>