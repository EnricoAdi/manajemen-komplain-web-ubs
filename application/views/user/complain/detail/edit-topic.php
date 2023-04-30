<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Ubah Komplain</h1>
<a href="<?= base_url() ?>User/Complain/Detail/index/<?= $komplain->NO_KOMPLAIN; ?>">

    <button type="button" class="btn btn-warning" style="color:white; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>

    <form action="<?= base_url() ?>User/Complain/Detail/EditKomplain/<?= $komplain->NO_KOMPLAIN; ?>" method="post" class="mt-4" style="color:black;" enctype="multipart/form-data">
     <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
     <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
     <input type="hidden" name="inputTopik" id="inputTopik" value="">
     <input type="hidden" id="minDate" value="<?= $minDate; ?>">
     <div class="row">
        <div class="col"> 
            <label for="user" class="form-label">Nomor Komplain : <?=$komplain->NO_KOMPLAIN;?></label>
        </div>
     </div>
     <div class="row">
         <div class="col"> 
             <label for="user" class="form-label">Tanggal Kejadian</label>
             <?php
                $tgl = $komplain->TGL_KEJADIAN;
                $tgl = date('Y-m-d', strtotime($tgl));  
                
             ?>
             <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $tgl; ?>" required>

             <label for="subtopik2" class="form-label mt-4">Subtopik 2</label>
             <input type="text" id="subtopik2" class="form-control" value="<?= $komplain->SUB_TOPIK2; ?> - <?= $komplain->S2DESKRIPSI; ?>" disabled/>
                 <?php
                    // foreach ($subtopics as $subtopik) { 
                    //     if($subtopik->SUB_TOPIK2==$komplain->SUB_TOPIK2){ 
                    //         echo "<option value='$subtopik->KODE_TOPIK&&$subtopik->TDESKRIPSI@@$subtopik->SUB_TOPIK1##$subtopik->S1DESKRIPSI^^$subtopik->SUB_TOPIK2$#$subtopik->S2DESKRIPSI' selected>
                    //         $subtopik->SUB_TOPIK2 - $subtopik->S2DESKRIPSI</option>";
                    //     }else{
                    //         echo "<option value='$subtopik->KODE_TOPIK&&$subtopik->TDESKRIPSI@@$subtopik->SUB_TOPIK1##$subtopik->S1DESKRIPSI^^$subtopik->SUB_TOPIK2$#$subtopik->S2DESKRIPSI'>
                    //         $subtopik->SUB_TOPIK2 - $subtopik->S2DESKRIPSI</option>"; 
                    //     }
                    // }
                    ?>

             <!-- </input> -->
         </div>
         <div class="col">
             <label for="" class="form-label">Topik</label>
             <input type="text" class="form-control" id="topik" value="<?= $komplain->TOPIK; ?> - <?= $komplain->TDESKRIPSI; ?>" disabled>

             <label for="" class="form-label mt-4">Subtopik 1</label>
             <input type="text" class="form-control" id="subtopik1" value="<?= $komplain->SUB_TOPIK1; ?> - <?= $komplain->S1DESKRIPSI; ?>" disabled>
         </div>
     </div>
     
    <div class="row mt-4">
        <div class="col">
            <label for="user" class="form-label">Feedback Sebelumnya</label>

            <select id="feedback" name="feedback" class="form-control">
                <?php
                ?>

            </select>
        </div>
        <div class="col">
            <label class="form-label">Tambah Lampiran</label>
            <input type="file" class="form-control" name="lampiran[]" style="padding-top:30px; padding-left:20px; height:100px;" multiple>
        </div>
    </div>
    
    <div class="row">
        <div class="col">

            <label class="form-label">Deskripsi Masalah</label>
            <textarea name="deskripsi" class="form-control" cols="30" rows="3" required><?= $komplain->DESKRIPSI_MASALAH;?></textarea>

        </div>
    </div>
    <div class="row mt-4">
        <div class="col"> 
            <label class="form-label">Lampiran Tersimpan</label>
            <br/>
            <table  class="table">
                <thead> 
                    <tr>
                        <th scope="col">Nomor Lampiran</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
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
                            echo "<td><button class='btn btn-danger btnDelete' id='$counter' style='color:white;'>
                            <i class='fas fa-fw fa-trash'></i>
                            Hapus</button> </td>"; 
                            echo "</tr>";
                            $counter = $counter + 1;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
     
     <div class="row mt-4">
         <div class="col"> 
              <?= primary_submit_button("Ubah", "fas fa-fw fa-pen", "btnNext", "") ?>
      
         </div>
     </div>
 </form> 
  
 <?php
    $counter = 1;
    foreach($komplain->LAMPIRAN as $lampiran){
        $urlDelete = base_url()."User/Complain/Detail/DeleteLampiran/$lampiran->KODE_LAMPIRAN/$lampiran->NO_KOMPLAIN"; 
        //confirmDeleteModal1_$lampiran->KODE_LAMPIRAN
        echo " <div class='modal fade' id='confirmDeleteModal$counter' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
        aria-hidden='false'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Konfirmasi</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                    </button>
                </div>
                <div class='modal-body'>Apakah anda yakin ingin menghapus lampiran ini?</div>
                <div class='modal-footer'>
                    <button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>
                    <a class='btn btn-primary' href='$urlDelete'>Ya</a>
                    </div>
                </div>
            </div>
        </div> ";
        $counter = $counter + 1;
    }
 
 ?>
 <script type="text/javascript">
     window.onload = function() {
        const minDate = document.getElementById("minDate").value; 
        document.getElementById('tanggal').setAttribute("min", minDate);

        let btnDeletes = document.getElementsByClassName("btnDelete"); 
        for (let i = 0; i < btnDeletes.length; i++) {
        let element = btnDeletes[i];
        let id = element.id;  
        element.onclick = function(event){  
            event.preventDefault();   
            $('#confirmDeleteModal'+id).modal('show'); 
            
        }
        }
         //init component
         const subTopik2Element = document.getElementById('subtopik2');
         const subTopik1Element = document.getElementById('subtopik1');
         const topikElement = document.getElementById('topik');
         const inputSubtopik2 = document.getElementById('inputSubtopik2');
         const inputSubtopik1 = document.getElementById('inputSubtopik1');
         const inputTopik = document.getElementById('inputTopik');


        // let originalValue = subTopik2Element.value;
        // setChange(originalValue)  
        
        // subTopik2Element.addEventListener('change', function() {
        //     let originalValue = subTopik2Element.value;
        //     setChange(originalValue)  
        // });

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
  