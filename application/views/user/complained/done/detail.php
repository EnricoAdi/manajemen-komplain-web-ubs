<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Penyelesaian Komplain Untuk Diselesaikan</h1>
 
<a href="<?= base_url() ?>User/Complained/Done">

    <button type="button" class="btn btn-warning" style="color:white; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>

<form action="<?= base_url() ?>User/Complained/Penyelesaian/editPenyelesaianProcess/<?= $komplain->NO_KOMPLAIN; ?>" 
    method="post" class="mt-4" style="color:black;">
 
    <div class="row">
        <div class="col"> 
            <label class="form-label mt-2">Nomor Komplain : <?= $komplain->NO_KOMPLAIN;?></label>
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
                $newFormatDate = $parseDate["year"]."-".str_pad($parseDate["month"],2,'0',STR_PAD_LEFT)."-".str_pad( $parseDate["day"],2,'0',STR_PAD_LEFT);
                 
                echo "</pre>";
            ?>
            <input type="date" name="tanggal" class="form-control" value="<?= $newFormatDate; ?>" disabled>

        </div>
        <div class="col">
            <label class="form-label">Daftar Lampiran</label>
            <table  class="table"> 
                <tbody> 
                    <?php
                        $counter = 1;
                        foreach($komplain->LAMPIRAN as $lampiran){
                            echo "<tr>";
                            echo "<td>";
                            echo '<a href="'.base_url().'uploads/'.$lampiran->KODE_LAMPIRAN.'" target="_blank">Lampiran '.$counter.'</a>';
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
     
    <div class="row mt-4">
        <div class="col">   
            <?= error_submit_button("Hapus","fas fa-fw fa-trash mr-2","btnDelete") ?> 
            <?= primary_submit_button("Selesai","","btnDone")?>
        </div>
    </div>
</form>
<div class="modal fade" id="confirmDoneModal" tabindex="-1" role="dialog"
        aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda setuju menyelesaikan penyelesaian komplain?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-primary" href="<?= base_url() ?>User/Complained/Done/successProcess/<?= $komplain->NO_KOMPLAIN; ?>">Ya</a>
            </div>
        </div>
    </div>
</div> 
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
        aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda ingin menghapus penyelesaian komplain?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-danger" href="<?= base_url() ?>User/Complained/Done/deleteProcess/<?= $komplain->NO_KOMPLAIN; ?>">Ya</a>
            </div>
        </div>
    </div>
</div> 

<script type="text/javascript">
function doneFeedback(event) {
    event.preventDefault(); 
    $('#confirmDoneModal').modal('show');
}
function deleteFeedback(event) {
    event.preventDefault(); 
    $('#confirmDeleteModal').modal('show');
}
let btnDone = document.getElementById("btnDone");
btnDone.addEventListener("click", doneFeedback);
let btnDelete = document.getElementById("btnDelete");
btnDelete.addEventListener("click", deleteFeedback);
</script>

