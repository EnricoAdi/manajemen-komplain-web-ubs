<style>
    @media print{
       
        #areaprint{
            visibility: visible;
            background-color: white;
        }
        #accordionSidebar, #titlePage, #formPrompt{
            display: none;
            background-color: white;
            
        }
    }
</style>

<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold" id="titlePage">Laporan Per Topik</h1>


<form action="<?= base_url() ?>Admin/Laporan/PerTopik" method="get" class="mt-4 mb-4"  id="formPrompt">

    <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value="">
    
    <input type="hidden" value="" id="divisi" disabled>

    <div class="row">
        <div class="col mt-2">
            <label for="topik" class="form-label">Periode Mulai :</label>
            <input type="date" name="periodeMulai" class="form-control" value="<?= $dateStart; ?>">

            <label class="form-label mt-4">Topik</label>
            <!-- <input type="text" id="topik" class="form-control" disabled> --> 
            <select class="form-control" id="topik" required>
                <?php 
                   foreach ($topics as $topik) {
                    if ($topik->KODE_TOPIK == $selectedTopic->KODE_TOPIK) {
                        echo "<option value='$topik->KODE_TOPIK' selected>
                        $topik->NAMA_DIVISI - $topik->TOPIK </option>";
                    } else { 
                        echo "<option value='$topik->KODE_TOPIK'>
                        $topik->NAMA_DIVISI - $topik->TOPIK </option>"; 
                    }
                }
                ?>
            </select>
            </input>
        </div>
        <div class="col mt-2">
            <label for="topik" class="form-label">Periode Selesai :</label>
            <input type="date" name="periodeSelesai" class="form-control" value="<?= $dateEnd; ?>">
            <!-- <label for="" class="form-label mt-4">Subtopik 1</label>
            <input type="text" id="subtopik1" class="form-control" disabled>
            </input> -->
        </div>
        <div class="col"> 
            <!-- <label class="form-label" style="margin-top: 102px;">Subtopik 2</label> -->
            <!-- <select class="form-control" id="subtopik2" required>
                <?php
                //    foreach ($subtopics as $subtopik) {
                //     if ($subtopik->SUB_TOPIK2 == $subtopik2) {
                //         echo "<option value='$subtopik->KODE_TOPIK&&$subtopik->TDESKRIPSI@@$subtopik->SUB_TOPIK1##$subtopik->S1DESKRIPSI^^$subtopik->SUB_TOPIK2$#$subtopik->S2DESKRIPSI#@$subtopik->NAMA_DIVISI' selected>
                //         $subtopik->NAMA_DIVISI - $subtopik->TOPIK - $subtopik->S1DESKRIPSI - $subtopik->S2DESKRIPSI</option>";
                //     } else {
                //         echo "<option value='$subtopik->KODE_TOPIK&&$subtopik->TDESKRIPSI@@$subtopik->SUB_TOPIK1##$subtopik->S1DESKRIPSI^^$subtopik->SUB_TOPIK2$#$subtopik->S2DESKRIPSI#@$subtopik->NAMA_DIVISI'>
                //         $subtopik->NAMA_DIVISI - $subtopik->TOPIK - $subtopik->S1DESKRIPSI - $subtopik->S2DESKRIPSI</option>";
                //     }
                // }
                ?>
            </select> -->
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <button class="btn btn-primary" style=" width:100%;background-color: <?= primary_color(); ?>;">
                <i class="fas fa-fw fa-file mr-2" style="font-weight: bolder;"></i>
                Buat Laporan
            </button>
        </div>
        <div class="col">
            <div class="btn btn-primary" style=" width:100%;background-color: <?= primary_color(); ?>;" onclick="cetak()">
                <i class="fas fa-fw fa-print mr-2" style="font-weight: bolder;"></i>
                Cetak Laporan
            </div>
        </div>
        <div class="col">

        </div>
    </div>
    <div class="mt-4">Hasil Laporan :</div>
</form>
<div style="background-color: white;" id="areaprint">
    
<div class="mb-4 mt-4"style="background-color: white;">
     <div class="card-header py-3 d-flex" style="background-color: white;">
        <img src="<?= asset_url(); ?>images/logo.png" style="width:206px; height:92px; margin-top: 12px;">
        <div class="ml-4">
            <h4 class="font-weight-bold">Laporan Per Topik</h4>
            <p>Manajemen Komplain</p>
            <p>Topik : <?= $selectedTopic->TOPIK; ?> Divisi <?= $selectedTopic->NAMA_DIVISI; ?></p>
            <p>Periode : <?= $formattedDateStart; ?> - <?= $formattedDateEnd; ?></p>
        </div>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" width="100%" cellspacing="0">
                 <thead>
                    <tr> 
                         <th rowspan="2" style="vertical-align: middle; text-align: center;">No</th>
                         <th rowspan="2" style="vertical-align: middle; text-align: center;">Departemen</th> 
                         <th rowspan="2" style="vertical-align: middle; text-align: center;">Topik</th> 
                        <th colspan="2" style="vertical-align: middle; text-align: center;">Jumlah Komplain Per Subtopik Berulang</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Jumlah</th> 
                    </tr>
                     <tr> 
                         <th style="text-align: center;">Subtopik 1</th>
                         <th style="text-align: center;">Subtopik 2</th> 
                     </tr>
                 </thead>
                 <tbody>
                     <?php 
                     ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>
</div>
 <script> 
    //init component
    // const subTopik2Element = document.getElementById('subtopik2');
    // const subTopik1Element = document.getElementById('subtopik1');
    // const topikElement = document.getElementById('topik');
    // const divisiElement = document.getElementById('divisi');
    // const inputSubtopik2 = document.getElementById('inputSubtopik2');
    // const inputSubtopik1 = document.getElementById('inputSubtopik1');
    // const inputTopik = document.getElementById('inputTopik');
    // const formProcess = document.getElementById("formProcess");
    // const btnTransferProcess = document.getElementById("btnTransferProcess");
    // const setChange = (originalValue) => {

    //     let indexStartKodeTopik = 0;
    //     let indexStartDeskripsiTopik = originalValue.indexOf("&&") + 2;

    //     let indexStartKodeSubtopik1 = originalValue.indexOf("@@") + 2;
    //     let indexStartDeskripsiSubtopik1 = originalValue.indexOf("##") + 2;

    //     let indexStartKodeSubtopik2 = originalValue.indexOf("^^") + 2;
    //     let indexStartDeskripsiSubtopik2 = originalValue.indexOf("$#") + 2;
    //     let indexDivisi = originalValue.indexOf("#@") + 2;

    //     let kodeTopik = originalValue.substring(indexStartKodeTopik, indexStartDeskripsiTopik - 2);
    //     let descTopik = originalValue.substring(indexStartDeskripsiTopik, indexStartKodeSubtopik1 - 2);

    //     let kodeSubTopik1 = originalValue.substring(indexStartKodeSubtopik1, indexStartDeskripsiSubtopik1 - 2);
    //     let descSubTopik1 = originalValue.substring(indexStartDeskripsiSubtopik1, indexStartKodeSubtopik2 - 2);

    //     let kodeSubTopik2 = originalValue.substring(indexStartKodeSubtopik2, indexStartDeskripsiSubtopik2 - 2);

    //     // //set showed values 
    //     let topikShowed = kodeTopik.substring(0, 3) + " - " + descTopik;
    //     topikElement.value = topikShowed;

    //     let subTopik1 = kodeSubTopik1 + " - " + descSubTopik1;
    //     subTopik1Element.value = subTopik1;

    //     let divisi = originalValue.substring(indexDivisi);
    //     divisiElement.value = divisi;
    //     //  set hidden values
    //     inputTopik.value = kodeTopik;
    //     inputSubtopik1.value = kodeSubTopik1;
    //     inputSubtopik2.value = kodeSubTopik2;
    // }
    // window.onload = function() {
    //     let originalValue = subTopik2Element.value;
    //     setChange(originalValue)

    //     subTopik2Element.addEventListener('change', function() {
    //         let originalValue = subTopik2Element.value;
    //         setChange(originalValue)
    //     }); 
    // }
    
    function cetak(){ 
        window.print()
    } 
 </script>