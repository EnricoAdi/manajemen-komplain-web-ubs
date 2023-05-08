<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Transfer Komplain</h1>

<a href="<?= base_url() ?>User/Complained/ListComplained">

    <button type="button" class="btn btn-danger" style="color:white; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px; background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward mr-2"></i>
        Kembali
    </button>
</a>
<form action="<?= base_url() ?>User/Complained/Transfer/processTransfer/<?= $komplain->NO_KOMPLAIN ?>" method="post" class="mt-4" id="formProcess">
    <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value="">
    <div class="row">
        <div class="col">
            <label for="" class="form-label mt-4">Nomor Feedback : <?= $komplain->NO_KOMPLAIN; ?> </label>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <label for="topik" class="form-label">Subtopik 2</label>
            <select id="subtopik2" class="form-control">
                <?php
                foreach ($subtopics as $subtopik) {
                    if ($subtopik->SUB_TOPIK2 == $subtopik2) {
                        echo "<option value='$subtopik->KODE_TOPIK&&$subtopik->TDESKRIPSI@@$subtopik->SUB_TOPIK1##$subtopik->S1DESKRIPSI^^$subtopik->SUB_TOPIK2$#$subtopik->S2DESKRIPSI#@$subtopik->NAMA_DIVISI' selected>
                        $subtopik->NAMA_DIVISI - $subtopik->TOPIK - $subtopik->S1DESKRIPSI - $subtopik->S2DESKRIPSI</option>";
                    } else {
                        echo "<option value='$subtopik->KODE_TOPIK&&$subtopik->TDESKRIPSI@@$subtopik->SUB_TOPIK1##$subtopik->S1DESKRIPSI^^$subtopik->SUB_TOPIK2$#$subtopik->S2DESKRIPSI#@$subtopik->NAMA_DIVISI'>
                        $subtopik->NAMA_DIVISI - $subtopik->TOPIK - $subtopik->S1DESKRIPSI - $subtopik->S2DESKRIPSI</option>";
                    }
                }
                ?>

            </select>

            <label for="subtopik2" class="form-label mt-4">Topik</label>
            <input type="text" class="form-control" id="topik" disabled>


            <label for="subtopik1" class="form-label mt-4">Subtopik 1</label>
            <input type="text" class="form-control" id="subtopik1" disabled>

        </div>
        <div class="col">
            <label for="" class="form-label">Divisi Tujuan</label>
            <input type="text" class="form-control" name="asalDivisi" value="" id="divisi" disabled>

            <label for="" class="form-label mt-4">Detail Transfer</label>
            <textarea class="form-control" name="detail"></textarea>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col"> 
            <?= error_button("Transfer","","btnTransfer") ?>
        </div>
    </div>
</form>
<div class="modal fade" id="confirmTransferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin mau mentransfer komplain?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <button class="btn btn-primary" id='btnTransferProcess'>Ya</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //init component
    const subTopik2Element = document.getElementById('subtopik2');
    const subTopik1Element = document.getElementById('subtopik1');
    const topikElement = document.getElementById('topik');
    const divisiElement = document.getElementById('divisi');
    const inputSubtopik2 = document.getElementById('inputSubtopik2');
    const inputSubtopik1 = document.getElementById('inputSubtopik1');
    const inputTopik = document.getElementById('inputTopik');
    const formProcess = document.getElementById("formProcess");
    const btnTransferProcess = document.getElementById("btnTransferProcess");
    const setChange = (originalValue) => {

        let indexStartKodeTopik = 0;
        let indexStartDeskripsiTopik = originalValue.indexOf("&&") + 2;

        let indexStartKodeSubtopik1 = originalValue.indexOf("@@") + 2;
        let indexStartDeskripsiSubtopik1 = originalValue.indexOf("##") + 2;

        let indexStartKodeSubtopik2 = originalValue.indexOf("^^") + 2;
        let indexStartDeskripsiSubtopik2 = originalValue.indexOf("$#") + 2;
        let indexDivisi = originalValue.indexOf("#@") + 2;

        let kodeTopik = originalValue.substring(indexStartKodeTopik, indexStartDeskripsiTopik - 2);
        let descTopik = originalValue.substring(indexStartDeskripsiTopik, indexStartKodeSubtopik1 - 2);

        let kodeSubTopik1 = originalValue.substring(indexStartKodeSubtopik1, indexStartDeskripsiSubtopik1 - 2);
        let descSubTopik1 = originalValue.substring(indexStartDeskripsiSubtopik1, indexStartKodeSubtopik2 - 2);

        let kodeSubTopik2 = originalValue.substring(indexStartKodeSubtopik2, indexStartDeskripsiSubtopik2 - 2);

        // //set showed values 
        let topikShowed = kodeTopik.substring(0, 3) + " - " + descTopik;
        topikElement.value = topikShowed;

        let subTopik1 = kodeSubTopik1 + " - " + descSubTopik1;
        subTopik1Element.value = subTopik1;

        let divisi = originalValue.substring(indexDivisi);
        divisiElement.value = divisi;
        //  set hidden values
        inputTopik.value = kodeTopik;
        inputSubtopik1.value = kodeSubTopik1;
        inputSubtopik2.value = kodeSubTopik2;
    }
    window.onload = function() {
        let originalValue = subTopik2Element.value;
        setChange(originalValue)

        subTopik2Element.addEventListener('change', function() {
            let originalValue = subTopik2Element.value;
            setChange(originalValue)
        }); 
    }
    const transferKomplain = (event) => {
        event.preventDefault();
        $('#confirmTransferModal').modal('show');
    }

    const submitForm = () => {
        formProcess.submit();
    };
    btnTransferProcess.addEventListener("click", submitForm);
    let btnTransfer = document.getElementById("btnTransfer");
    btnTransfer.addEventListener("click", transferKomplain);
</script>