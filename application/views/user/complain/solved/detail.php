<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Penyelesaian Komplain Diterima</h1>

<a href="<?= base_url() ?>User/Complain/Solved">

    <button type="button" class="btn btn-warning" style="color:white; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>

<form action="<?= base_url() ?>User/Complain/Solved/solveProcess/<?= $komplain->NO_KOMPLAIN; ?>" method="post" class="mt-4" style="color:black;" id="formProcess">

    <div class="row">
        <div class="col">
            <label class="form-label mt-2">Nomor Komplain : <?= $komplain->NO_KOMPLAIN; ?></label> <br>
            <label class="form-label mt-2">Status : <?= $komplain->STATUS; ?></label>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label class="form-label mt-2">Masalah Komplain</label>
            <textarea class="form-control" disabled><?= $komplain->DESKRIPSI_MASALAH; ?></textarea>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <label for="user" class="form-label">Akar Masalah</label>
            <textarea class="form-control" name="akar-masalah" disabled><?= $komplain->FEEDBACK->AKAR_MASALAH; ?></textarea>
        </div>
        <div class="col">
            <label for="user" class="form-label">Tindakan Preventif</label>
            <textarea class="form-control" name="preventif" disabled><?= $komplain->FEEDBACK->T_PREVENTIF; ?></textarea>
        </div>
        <div class="col">
            <label for="user" class="form-label">Tindakan Korektif</label>
            <textarea class="form-control" name="korektif" disabled><?= $komplain->FEEDBACK->T_KOREKTIF; ?></textarea>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <label class="form-label">Tanggal Deadline</label>
            <?php
            echo "<pre>";
            $parseDate = date_parse($komplain->TGL_DEADLINE);
            $newFormatDate = $parseDate["year"] . "-" . str_pad($parseDate["month"], 2, '0', STR_PAD_LEFT) . "-" . str_pad($parseDate["day"], 2, '0', STR_PAD_LEFT);

            echo "</pre>";
            ?>
            <input type="date" name="tanggal" class="form-control" value="<?= $newFormatDate; ?>" disabled>

        </div>
        <div class="col">
            <label class="form-label">Daftar Lampiran</label>
            <table class="table">
                <tbody>
                    <?php
                    $counter = 1;
                    foreach ($komplain->LAMPIRAN as $lampiran) {
                        echo "<tr>";
                        echo "<td>";
                        echo '<a href="' . base_url() . 'uploads/' . $lampiran->KODE_LAMPIRAN . '" target="_blank">Lampiran ' . $counter . '</a>';
                        echo "</td>";
                        // echo "<td><a href=''><button class='btn btn-danger' style='color:white;'>
                        // <i class='fas fa-fw fa-trash'></i>
                        // Hapus</button> </a></td>"; 

                        echo "</tr>";
                        $counter = $counter + 1;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col"></div>
    </div>
    <?php if($komplain->STATUS != 'CLOSE'): ?>
    
        <div class="row mt-4">
            <div class="col">
        
            <div class="form-control" style="height:fit-content; padding-bottom:20px;">
                    <p style="margin-top:10px; font-weight:bold;">Keputusan :</p>
                    <div class="row">
                        <div class="col"><input type="radio" name="keputusan" value="cancel" class="mr-2">Cancel</div>
                        <div class="col"><input type="radio" name="keputusan" value="validasi" class="mr-2">Validasi</div>
                        <div class="col"><input type="radio" name="keputusan" value="banding" class="mr-2">Banding</div>
                    </div>
                    <div class="row mt-4" id="banding-section" style="display:none;">
                        <div class="col">
                            <label class="form-label">Permintaan Banding</label>
                            <input type="text" name="permintaanBanding" id="permintaanBanding" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div> 

    <div class="row mt-4">
        <div class="col"> 
                <?= primary_submit_button("Selesai","","btnDone")?>
        </div>
    </div>

    <?php endif; ?> 
</form>
<div class="modal fade" id="confirmDoneModal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="message">Apakah anda setuju memvalidasi penyelesaian komplain?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <div class="btn btn-primary" id="btnSubmitForm">Ya</div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pesanModal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="messagePesan">Silahkan untuk mengisi keputusan terlebih dahulu</div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const btnDone = document.getElementById("btnDone");
    const btnSubmitForm = document.getElementById("btnSubmitForm");
    const formProcess = document.getElementById("formProcess");

    const rbKeputusan = document.querySelectorAll('[name="keputusan"]');

    const bandingSection = document.getElementById("banding-section");
    const txtPermintaanBanding = document.getElementById("permintaanBanding");
    const messageBody = document.getElementById("message");
    const messagePesan = document.getElementById("messagePesan");
 
    let stateKeputusan = '';

    const doneFeedback = (event) => {
        event.preventDefault();
        if(stateKeputusan==''){
            messagePesan.innerText = "Silahkan untuk mengisi keputusan terlebih dahulu";
            $('#pesanModal').modal('show');
        }else{
            $('#confirmDoneModal').modal('show');
        }
    };

    const submitForm = () => {
        if(stateKeputusan=='banding' && txtPermintaanBanding.value==''){
            messagePesan.innerText = "Silahkan untuk mengisi permintaan banding terlebih dahulu";
            $('#pesanModal').modal('show');
        }else{
            formProcess.submit();
        }
         
    };

    const changeState = (state) => {
        stateKeputusan = state;
        if (state == "banding") {
            messageBody.innerText = "Apakah anda setuju untuk mengajukan banding terkait penyelesaian komplain ini?"
            bandingSection.style.display = "block";
        } else {
            bandingSection.style.display = "none";
            if(state=="cancel"){ 
                messageBody.innerText = "Apakah anda setuju untuk membatalkan (cancel) penyelesaian komplain ini?"
            }else{
                //state validasi
            messageBody.innerText = "Apakah anda setuju untuk memvalidasi penyelesaian komplain ini?"
            }
        }
    }
    btnDone.addEventListener("click", doneFeedback);
    btnSubmitForm.addEventListener("click", submitForm);


    rbKeputusan.forEach(rb => {
        rb.addEventListener('click', function() {
            changeState(rb.value);
        });
    });
</script>