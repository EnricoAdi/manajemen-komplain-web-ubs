<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <ol class="breadcrumb" style="background-color:#F1F2F5;">
         <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihDivisi">Pilih Divisi</a></li>
         <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihTopik/<?= $divisi->KODE_DIVISI; ?>">Pilih Topik</a></li>
         <li class="breadcrumb-item active">Pilih Subtopik1</li>
         <li class="breadcrumb-item">...</li>
     </ol>
 </nav>
 <h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Komplain Baru</h1>
 
 <form action="<?= base_url() ?>User/Complain/Add/processPilihSubTopik1/<?=$divisi->KODE_DIVISI;?>/<?=$topik->KODE_TOPIK;?>" method="post" class="mt-4" style="color:black;">
     <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
     <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
     <input type="hidden" name="inputTopik" id="inputTopik" value="">

     <div class="row">  
         <div class="col">
             <label for="" class="form-label">Silahkan pilih subtopik1 yang mau dikomplain</label>
             <input type="hidden" name="subtopik1">
             <input type="hidden" name="topik"> <br> 
             <label for="divisi" class="form-label" >Divisi</label>
             <input type="text" name="divisi" class="form-control mb-3" value="<?= $divisi->KODE_DIVISI; ?> - <?= $divisi->NAMA_DIVISI; ?> " disabled>
             
             <label for="topik" class="form-label" >Topik</label> 
             <input type="text" name="topik" class="form-control mb-3" value="<?= $topik->KODE_TOPIK; ?> - <?= $topik->TOPIK; ?> " disabled>
             
         </div>
     </div>
     <div class="row">
        <div class="col"> 
             <label for="subtopik1" class="form-label" >Subtopik 1</label>
             <select class="form-control" name="subtopik1">
                <?php
                    foreach($allSubTopik1 as $subtopik1 ){ 
                        echo "<option value='$subtopik1->SUB_TOPIK1'>
                        $subtopik1->SUB_TOPIK1 - $subtopik1->DESKRIPSI</option>"; 
                    }
                ?>
             </select> 
        </div>
        <div class="col"></div>
     </div>
     <div class="row mt-4">
         <div class="col">
            <?= error_button("Sebelumnya", "", "", "",
            "User/Complain/Add/pilihTopik/$divisi->KODE_DIVISI") ?>
            <?= primary_submit_button("Berikutnya", "", "btnNext", "") ?>
             </div>
     </div>
 </form>

  