<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <ol class="breadcrumb" style="background-color:#F1F2F5;">
         <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihDivisi">Pilih Divisi</a></li>
         <li class="breadcrumb-item active">Pilih Topik</li>
         <li class="breadcrumb-item">...</li>
     </ol>
 </nav>
 <h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Komplain Baru</h1>
 
 <form action="<?= base_url() ?>User/Complain/Add/processPilihTopik/<?=$divisi->KODE_DIVISI;?>" method="post" class="mt-4" style="color:black;">
     <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
     <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
     <input type="hidden" name="inputTopik" id="inputTopik" value="">

     <div class="row">  
         <div class="col">
             <label for="" class="form-label">Silahkan pilih topik yang mau dikomplain</label>
             <input type="hidden" name="subtopik1">
             <input type="hidden" name="topik"> <br> 
             <label for="divisi" class="form-label" >Divisi</label>
             <input type="text" name="divisi" class="form-control mb-3" value="<?= $divisi->KODE_DIVISI; ?> - <?= $divisi->NAMA_DIVISI; ?> " disabled>
             
             <label for="topik" class="form-label" >Topik</label>
             <select class="form-control" name="topik">
                <?php
                    foreach($allTopik as $topik ){ 
                        echo "<option value='$topik->KODE_TOPIK'>
                        $topik->KODE_TOPIK - $topik->TOPIK</option>"; 
                    }
                ?>
             </select> 
         </div>
     </div>
     <div class="row mt-4">
         <div class="col">
            <?= error_button("Sebelumnya", "", "", "","User/Complain/Add/pilihDivisi") ?>
            <?= primary_submit_button("Berikutnya", "", "btnNext", "") ?>
             </div>
     </div>
 </form>

  