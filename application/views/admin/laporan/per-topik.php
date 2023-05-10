<style>
    @media print{
       
        #areaprint{
            visibility: visible;
            background-color: white;
        }
        #accordionSidebar, #titlePage, #formPrompt, #scrollToTop{
            display: none;
            background-color: white;  
        }
        .nextpage{
            page-break-after: always;
        }
    }
</style>

<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold" id="titlePage">Laporan Per Topik</h1>


<form action="<?= base_url() ?>Admin/Laporan/PerTopik" method="get" class="mt-4 mb-4"  id="formPrompt">

    <!-- <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value=""> -->
    
    <input type="hidden" value="" id="divisi" disabled>

    <div class="row">
        <div class="col mt-2">
            <label for="topik" class="form-label">Periode Mulai :</label>
            <input type="date" name="periodeMulai" class="form-control" value="<?= $dateStart; ?>">

            <label class="form-label mt-4">Divisi</label>
            <!-- <input type="text" id="topik" class="form-control" disabled> --> 
            <select class="form-control" name="divisi" id="divisi" required>
                <?php 
                   foreach ($divisis as $divisi) {
                    if ($divisi->KODE_DIVISI == $selectedDivisi->KODE_DIVISI) {
                        echo "<option value='$divisi->KODE_DIVISI' selected>
                        $divisi->NAMA_DIVISI </option>";
                    } else { 
                        echo "<option value='$divisi->KODE_DIVISI'>
                        $divisi->NAMA_DIVISI </option>"; 
                    }
                }
                ?>
            </select> 
        </div>
        <div class="col mt-2">
            <label for="topik" class="form-label">Periode Selesai :</label>
            <input type="date" name="periodeSelesai" class="form-control" value="<?= $dateEnd; ?>">
            
        </div>
        <div class="col">   </div>
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
            <p>Divisi :  <?= $selectedDivisi->NAMA_DIVISI; ?></p>
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
                        $topikNow = "";
                        if(sizeof($allData) > 0){   
                            echo "
                            <tr>
                                <td rowspan='".(sizeof($allData)+1)."'>1</td>
                                <td rowspan='".(sizeof($allData)+1)."'>$selectedDivisi->NAMA_DIVISI</td>  
                            </tr>";
                            $topikNow = $allData[0]->KODE_TOPIK; 
                        }else{
                            echo "<tr><td colspan='6' class='text-center'>Tidak ada data</td></tr>";  
                        }
                     foreach ($allData as $key => $value) { 
                            if($key % 17 == 0 && $key > 1){
                                echo "<tr class='nextpage'>";
                            }else{
                                echo "<tr>";    
                            }
                            echo " 
                                    <td>$value->TDESKRIPSI</td>
                                    <td>$value->SUBTOPIK1</td>
                                    <td>$value->SUBTOPIK2</td>
                                    <td>$value->jumlah</td> 
                                </tr>"; 
                     } 
                     ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>
</div>
 <script>  
    function cetak(){ 
        window.print()
    } 
 </script>