<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color:#F1F2F5;">
        <li class="breadcrumb-item "> <a href="<?= base_url() ?>User/Complained/Penyelesaian/addPage/<?= $komplain->NO_KOMPLAIN; ?>">Detail</a> </li>
        <li class="breadcrumb-item active">Lampiran</li>
    </ol>
</nav>
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Input Penyelesaian Komplain</h1>

<a href="<?= base_url() ?>User/Complained/Penyelesaian/addPage/<?= $komplain->NO_KOMPLAIN; ?>">

    <button type="button" class="btn btn-warning" style="color:white; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>


<form action="<?= base_url() ?>User/Complained/Penyelesaian/addProcess/<?= $komplain->NO_KOMPLAIN; ?>" method="post" class="mt-4" style="color:black;" enctype="multipart/form-data">

    <div class="row mt-4">
        <div class="col">
            <label for="user" class="form-label">Input Lampiran (tidak wajib)</label>
            <input type="file" class="form-control" name="lampiran[]" style="padding-top:30px; padding-left:20px; height:100px;" multiple>

        </div>
        <div class="col">
            <label for="user" class="form-label">Rangkuman Input Penyelesaian Komplain</label>
            <div class="form-control" style="height:fit-content;padding-bottom: 20px;">
                Deskripsi Masalah : <?= $komplain->DESKRIPSI_MASALAH; ?> <br><br>
                Akar Masalah : <?= $akar; ?> <br><br>
                Tindakan Preventif : <?= $preventif; ?> <br><br>
                Tindakan Korektif : <?= $korektif; ?> <br><br>
                Tanggal Deadline : <?= $tanggalDeadline; ?> <br><br> <br><br>

                <div class="row">

                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col">
                        <button type="submit" id="btnNext" class="btn btn-success" style="color:white; 
            background-color: <?= primary_color(); ?>; width:120px;">
                            Kirimkan
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>

</form>