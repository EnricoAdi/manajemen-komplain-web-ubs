 <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <ol class="breadcrumb" style="background-color:#F1F2F5;">
         <li class="breadcrumb-item active">Tanggal</li>
         <li class="breadcrumb-item">...</li>
     </ol>
 </nav>
 <h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Komplain Baru</h1>

 <form action="<?= base_url() ?>User/Complain/Add/pageProcess1" method="post" class="mt-4" style="color:black;">
     <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
     <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
     <input type="hidden" name="inputTopik" id="inputTopik" value="">

     <div class="row">
         <div class="col">
             <label for="user" class="form-label">Tanggal Kejadian</label>
             <?php  
                $subtopik2 = "";
                if($tanggalPreSended!=null){
                    $tanggalSekarang = $tanggalPreSended; 
                }
                if($subtopik2PreSended!=null){
                    $subtopik2 = $subtopik2PreSended;
                }
             ?>
             <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $tanggalSekarang; ?>" required>

             <label for="subtopik2" class="form-label mt-4">Subtopik 2</label>
             <select id="subtopik2" class="form-control">
                 <?php
                    foreach ($subtopics as $subtopik) { 
                        if($subtopik->SUB_TOPIK2==$subtopik2){ 
                            echo "<option value='$subtopik->KODE_TOPIK&&$subtopik->TDESKRIPSI@@$subtopik->SUB_TOPIK1##$subtopik->S1DESKRIPSI^^$subtopik->SUB_TOPIK2$#$subtopik->S2DESKRIPSI' selected>
                            $subtopik->SUB_TOPIK2 - $subtopik->S2DESKRIPSI</option>";
                        }else{
                            echo "<option value='$subtopik->KODE_TOPIK&&$subtopik->TDESKRIPSI@@$subtopik->SUB_TOPIK1##$subtopik->S1DESKRIPSI^^$subtopik->SUB_TOPIK2$#$subtopik->S2DESKRIPSI'>
                            $subtopik->SUB_TOPIK2 - $subtopik->S2DESKRIPSI</option>"; 
                        }
                    }
                    ?>

             </select>
         </div>
         <div class="col">
             <label for="inputPassword5" class="form-label">Topik</label>
             <input type="text" class="form-control" id="topik" disabled>

             <label for="" class="form-label mt-4">Subtopik 1</label>
             <input type="text" class="form-control" id="subtopik1" disabled>
         </div>
     </div>
     <div class="row mt-4">
         <div class="col">
             <button type="submit" id="btnNext" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;">Berikutnya</button>
         </div>
     </div>
 </form>

 <script>
     window.onload = function() {
         //init component
         const subTopik2Element = document.getElementById('subtopik2');
         const subTopik1Element = document.getElementById('subtopik1');
         const topikElement = document.getElementById('topik');
         const inputSubtopik2 = document.getElementById('inputSubtopik2');
         const inputSubtopik1 = document.getElementById('inputSubtopik1');
         const inputTopik = document.getElementById('inputTopik');


         let originalValue = subTopik2Element.value;
        setChange(originalValue)  

         subTopik2Element.addEventListener('change', function() {
            let originalValue = subTopik2Element.value;
            setChange(originalValue)  
         });

     function setChange(originalValue){

        let indexStartKodeTopik = 0;
             let indexStartDeskripsiTopik = originalValue.indexOf("&&") + 2;

             let indexStartKodeSubtopik1 = originalValue.indexOf("@@") + 2;
             let indexStartDeskripsiSubtopik1 = originalValue.indexOf("##") + 2;

             let indexStartKodeSubtopik2 = originalValue.indexOf("^^") + 2;
             let indexStartDeskripsiSubtopik2 = originalValue.indexOf("$#") + 2;

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

             //  set hidden values
             inputTopik.value = kodeTopik;
             inputSubtopik1.value = kodeSubTopik1;
             inputSubtopik2.value = kodeSubTopik2;
     }
     }
 </script> 