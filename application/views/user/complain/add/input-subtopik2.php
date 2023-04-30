<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <ol class="breadcrumb" style="background-color:#F1F2F5;">
         <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihDivisi">Pilih Divisi</a></li>
         <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihTopik/<?= $divisi->KODE_DIVISI; ?>">Pilih Topik</a></li>
         <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihSubTopik1/<?= $divisi->KODE_DIVISI; ?>/<?= $topik->KODE_TOPIK; ?>">Pilih Subtopik1</a></li>
         <li class="breadcrumb-item active">Pilih Subtopik2</li>
         <li class="breadcrumb-item">...</li>
     </ol>
 </nav>
 <h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Komplain Baru</h1>
 
 <form action="<?= base_url() ?>User/Complain/Add/processPilihSubtopik2/<?=$divisi->KODE_DIVISI;?>/<?=$topik->KODE_TOPIK;?>/<?= $subtopik1->SUB_TOPIK1; ?>" method="post" class="mt-4" style="color:black;">
     <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
     <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
     <input type="hidden" name="inputTopik" id="inputTopik" value="">

     <div class="row">
        <div class="col">
             <label class="form-label">Silahkan pilih subtopik2 yang mau dikomplain</label>
             <input type="hidden" name="subtopik1">
             <input type="hidden" name="topik"> <br> 
             
             <input type="hidden" id="minDate" value="<?= $minDate; ?>">
             <label for="divisi" class="form-label" >Divisi</label>
             <input type="text" name="divisi" class="form-control mb-3" value="<?= $divisi->KODE_DIVISI; ?> - <?= $divisi->NAMA_DIVISI; ?> " disabled>
             
             <label for="topik" class="form-label" >Topik</label> 
             <input type="text" name="topik" class="form-control mb-3" value="<?= $topik->KODE_TOPIK; ?> - <?= $topik->TOPIK; ?> " disabled>
             
        </div>
     </div>
     <div class="row">  
         <div class="col">
             <label for="subtopik1" class="form-label" >Subtopik 1</label>
             <input type="text" name="subtopik1" class="form-control mb-3" value="<?= $subtopik1->SUB_TOPIK1; ?> - <?= $subtopik1->DESKRIPSI; ?> " disabled>

             <label for="tanggal" class="form-label" >Tanggal</label>
             <input type="date" name="tanggal" id="tanggal" class="form-control mb-3">
         </div>
         <div class="col"> 
             <label for="subtopik2" class="form-label" >Subtopik 2</label>
             <select class="form-control mb-2" name="subtopik2">
                <?php
                    foreach($allSubTopik2 as $subtopik2 ){ 
                        echo "<option value='$subtopik2->SUB_TOPIK2'>
                        $subtopik2->SUB_TOPIK2 - $subtopik2->S2DESKRIPSI</option>"; 
                    }
                ?>
             </select> 
         </div>
     </div>
     <div class="row mt-4">
         <div class="col">
            <?= error_button("Sebelumnya", "", "", "",
            "User/Complain/Add/pilihSubTopik1/$divisi->KODE_DIVISI/$topik->KODE_TOPIK") ?>
            <?= primary_submit_button("Berikutnya", "", "btnNext", "") ?>
             </div>
     </div>
 </form>

<script>
    window.onload = ()=>{ 
        const minDate = document.getElementById("minDate").value; 
        document.getElementById('tanggal').setAttribute("min", minDate);
    }
</script>