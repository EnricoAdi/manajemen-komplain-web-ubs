<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <ol class="breadcrumb" style="background-color:#F1F2F5;">
         <li class="breadcrumb-item active">Detail</li>
         <li class="breadcrumb-item">...</li>
     </ol>
 </nav>
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Input Penyelesaian Komplain</h1>
 
<a href="<?= base_url() ?>User/Complained/Penyelesaian/detail/<?= $komplain->NO_KOMPLAIN; ?>">

    <button type="button" class="btn btn-warning" style="color:white; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>

<form action="<?= base_url() ?>User/Complained/Penyelesaian/addPenyelesaianPage1Process/<?= $komplain->NO_KOMPLAIN; ?>" 
    method="post" class="mt-4" style="color:black;">
 
    <input type="hidden" id="minDate" value="<?= $minDate; ?>">
    <div class="row">
        <div class="col"> 
            <label class="form-label mt-2">Masalah Komplain</label>
            <textarea class="form-control" disabled><?= $komplain->DESKRIPSI_MASALAH; ?></textarea>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <label for="user" class="form-label">Akar Masalah</label> 
            <textarea class="form-control" name="akar-masalah" required><?= $akar; ?></textarea>
        </div> 
        <div class="col">
            <label for="user" class="form-label">Tindakan Preventif</label> 
            <textarea class="form-control" name="preventif" required><?= $preventif; ?></textarea>
        </div> 
        <div class="col">
            <label for="user" class="form-label">Tindakan Korektif</label> 
            <textarea class="form-control" name="korektif" required><?= $korektif; ?></textarea>
        </div> 
    </div>

    <div class="row mt-4">
        <div class="col"> 
            <label class="form-label">Tanggal Deadline</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $tanggalDeadline; ?>" required>

        </div>
        <div class="col"></div>
        <div class="col"></div>
    </div>
    <div class="row mt-4">
        <div class="col">   
            <?= primary_submit_button("Berikutnya","","btnNext") ?>
        </div>
    </div>
</form>

<script>
    window.onload = ()=>{  
        const minDate = document.getElementById("minDate").value;  
        document.getElementById('tanggal').setAttribute("min", minDate);
    }

</script>