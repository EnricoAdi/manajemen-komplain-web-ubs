<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <ol class="breadcrumb" style="background-color:#F1F2F5;">
         <li class="breadcrumb-item active">Pilih Divisi</li>
         <li class="breadcrumb-item">...</li>
     </ol>
 </nav>
 <h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Komplain Baru</h1>
 
 <form action="<?= base_url() ?>User/Complain/Add/processPilihDivisi" method="post" class="mt-4" style="color:black;">
     <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
     <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
     <input type="hidden" name="inputTopik" id="inputTopik" value="">

     <div class="row">  
         <div class="col">
             <label for="" class="form-label">Silahkan pilih divisi yang mau dikomplain</label>
             <select class="form-control" name="divisi" id="divisi">
                <?php
                    foreach($allDivisi as $divisi ){ 
                        echo "<option value='$divisi->KODE_DIVISI'>
                        $divisi->KODE_DIVISI - $divisi->NAMA_DIVISI</option>"; 
                    }
                ?>
             </select> 
             
             <label for="topik" class="form-label mt-4" >Topik</label>
             <select class="form-control" disabled> 
             </select> 
         </div>
     </div>
     
     <div class="row mt-4">
        <div class="col"> 
             <label for="subtopik1" class="form-label" >Subtopik 1</label>
             <select class="form-control" name="subtopik1" disabled> 
             </select> 
             
             <label for="tanggal" class="form-label mt-4" >Tanggal</label>
             <input type="text" name="tanggal" disabled class="form-control mb-3">
        </div>
        <div class="col">
            
        <label for="subtopik2" class="form-label" >Subtopik 2</label>
             <select class="form-control mb-2" name="subtopik2" disabled> 
             </select> 
        </div>
     </div>
     <div class="row mt-4">
         <div class="col">
            <?= primary_submit_button("Berikutnya", "", "btnNext", "") ?>
             </div>
     </div>
 </form>

  