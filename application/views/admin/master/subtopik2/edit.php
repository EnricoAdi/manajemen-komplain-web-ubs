<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Ubah Subtopik2 </h1>
<a href="<?= base_url() ?>Admin/Master/Subtopik2">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>

</a>
<form action="<?= base_url() ?>Admin/Master/Subtopik2/EditProcess/<?= $subtopic->SUB_TOPIK2; ?>" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col">

            <label class="form-label" id='labelTopik'>Topik : </label>
            <input type="hidden" name="inputKodeTopik" id="inputKodeTopik">
            <input type="hidden" name="inputKodeSubtopik1" id="inputKodeSubtopik1">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="subtopik1" class="form-label">Subtopik 1 : </label>
            <select id="subtopik1" class="form-control">

                <?php
                foreach ($list_subtopik1 as $subtopik) {
                    // echo "<option value='$subtopik->SUB_TOPIK1'>$subtopik->SUB_TOPIK1 - $subtopik->DESKRIPSI</option>";
                    if ($subtopic->SUB_TOPIK1 == $subtopik->SUB_TOPIK1) {
                        echo "<option value='$subtopik->KODE_TOPIK - $subtopik->TOPIK @$subtopik->SUB_TOPIK1' selected>$subtopik->SUB_TOPIK1 - $subtopik->DESKRIPSI</option>";
                    } else {
                        echo "<option value='$subtopik->KODE_TOPIK - $subtopik->TOPIK @$subtopik->SUB_TOPIK1'>$subtopik->SUB_TOPIK1 - $subtopik->DESKRIPSI</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col"></div>
    </div>
    <div class="row">
        <div class="col">
            <label for="deskripsi" class="form-label mt-5">Deskripsi</label>
            <textarea class="form-control" placeholder="" name="deskripsi" required><?= $subtopic->DESKRIPSI; ?></textarea>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <button class="btn btn-danger" id="btnDelete" style="color:black;width:100px;">

                <i class="fas fa-fw fa-trash"></i> Hapus</button>
            <button type="submit" class="btn btn-warning" style="color:black;width:100px;">Ubah</button>
        </div>
    </div>
</form>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah anda yakin ingin menghapus subtopik 2 ini?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                    <a class="btn btn-primary" href="<?= base_url() ?>Admin/Master/Subtopik2/DeleteProcess/<?= $subtopic->SUB_TOPIK2; ?>">Ya</a>
                </div>
            </div>
        </div>
    </div> 
 
<script type="text/javascript">
    //Script ini digunakan untuk mengubah label topik sesuai dengan subtopik 1 yang dipilih
    //dan juga mendapatkan kode topik dan subtopik 1 yang dipilih yang dimasukkan ke input hidden
    //gunanya untuk memudahkan proses insert data ke database, namun tetap memudahkan user untuk memilih topik dan subtopik 1 dari tampilan yang diberikan
    window.onload = function() {
        // let x = document.getElementById('subtopics1').childNodes[3].value;
        // console.log(x);
        let labelTopik = document.getElementById('labelTopik');
        let subTopik1 = document.getElementById('subtopik1');
        let inputKodeSubtopik1 = document.getElementById('inputKodeSubtopik1');
        let inputKodeTopik = document.getElementById('inputKodeTopik');

        //cari string @ di subtopik1.value
        let indexSubtopik1 = subTopik1.value.indexOf("@");
        let indexTopik = subTopik1.value.indexOf("-");

        let kodeTopikShow = subTopik1.value.substring(0, 3) + " - ";
        let topikShow = subTopik1.value.substring(indexTopik + 1, indexSubtopik1 - 1);
        labelTopik.innerText = "Topik : " + kodeTopikShow + topikShow;

        inputKodeSubtopik1.value = subTopik1.value.substring(indexSubtopik1 + 1);
        inputKodeTopik.value = subTopik1.value.substring(0, 5);

        subTopik1.addEventListener('change', function() {
            let indexSubtopik1 = subTopik1.value.indexOf("@");
            let indexTopik = subTopik1.value.indexOf("-");

            let kodeTopikShow = subTopik1.value.substring(0, 3) + " - ";
            let topikShow = subTopik1.value.substring(indexTopik + 1, indexSubtopik1 - 1);
            labelTopik.innerText = "Topik : " + kodeTopikShow + topikShow;

            inputKodeSubtopik1.value = subTopik1.value.substring(indexSubtopik1 + 1);
            inputKodeTopik.value = subTopik1.value.substring(0, 5);
        });
    }
</script> 
<script src="<?= asset_url(); ?>js/template/confirmDeleteModalMasterTopik.js"></script>