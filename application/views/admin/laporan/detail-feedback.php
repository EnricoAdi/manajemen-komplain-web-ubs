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
    }
</style>
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold" id="titlePage">Laporan Detail Feedback</h1>


 <form action="<?= base_url() ?>Admin/Laporan/DetailFeedback" method="get" class="mt-4 mb-4" id="formPrompt">
     <div class="row">
         <div class="col mt-2">
             <label for="topik" class="form-label">Periode Mulai :</label>
             <input type="date" name="periodeMulai" class="form-control" value="<?= $dateStart; ?>">

             <label for="" class="form-label mt-4">Topik</label>
             <select class="form-control" name="topik" id="topik" required>
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
         </div>
         <div class="col mt-2">
             <label for="topik" class="form-label">Periode Selesai :</label>
             <input type="date" name="periodeSelesai" class="form-control" value="<?= $dateEnd; ?>">
 
         </div>
         <div class="col">

         </div>
     </div>
     <div class="row mt-4">
         <div class="col"> 
             <button class="btn btn-primary" style=" width:100%; background-color: <?= primary_color(); ?>;">
                 <i class="fas fa-fw fa-file mr-2" style="font-weight: bolder;"></i>
                 Buat Laporan
             </button>
         </div>
         <div class="col">
             <div class="btn btn-primary" style=" width:100%; background-color: <?= primary_color(); ?>;" onclick="cetak()">
                 <i class="fas fa-fw fa-print mr-2" style="font-weight: bolder;"></i>
                 Cetak Laporan
             </div>
            </div>
         <div class="col">

         </div>
     </div>
    <div class="mt-4">Hasil Laporan :</div>
 </form> 
 
<div class=" mb-4 mt-4" style="background-color: white;" id="areaprint">
<div class="card-header py-3 d-flex" style="background-color: white;">
        <img src="<?= asset_url(); ?>images/logo.png" style="width:206px; height:92px; margin-top: 12px;">
        <div class="ml-4">
            <h4 class="font-weight-bold">Laporan Detail Feedback</h4>
            <p>Manajemen Komplain</p>
            <p>Topik : <?= $selectedTopic->TOPIK; ?> Divisi <?= $selectedTopic->NAMA_DIVISI; ?></p>
            <p>Periode : <?= $formattedDateStart; ?> - <?= $formattedDateEnd; ?></p>
        </div>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered"  width="100%" cellspacing="0">
                 <thead> 
                     <tr>
                         <th>Tanggal</th>
                         <th>Pengirim</th>
                         <th>Aspek</th>
                         <th>Topik</th>
                         <th>Subtopik</th>
                         <th>Masalah</th>
                         <th>Deskripsi</th>
                         <th>Akar Masalah</th>
                         <th>PIC</th> 
                         <th>SubDepartemen</th> 
                         <th>PIC Perbaikan</th> 
                         <th>Tindakan Perbaikan</th> 
                     </tr>
                 </thead>
                 <tbody>
                     <?php 
                        if(sizeof($allData) > 0){ 
                            foreach ($allData as $key => $value) { 
                                
                                if($key % 17 == 0 && $key > 1){
                                    //dipecah untuk 17 data per halaman
                                    echo "<tr class='nextpage'>";
                                }else{
                                    echo "<tr>";    
                                }
                                echo " 
                                        <td>$value->TANGGAL</td>
                                        <td>$value->PENGIRIM</td>
                                        <td>$value->ASPEK</td>
                                        <td>$value->TOPIK</td> 
                                        <td>$value->SUBTOPIK</td>
                                        <td>$value->MASALAH</td>
                                        <td>$value->DESKRIPSI</td>
                                        <td>$value->AKAR</td> 
                                        <td>PIC</td>
                                        <td>SubDepartemen</td>
                                        <td>PIC Perbaikan</td>
                                        <td>Tindakan Perbaikan</td>
                                    </tr>"; 
                            } 
                        }else{
                            echo "<tr><td colspan='12' class='text-center'>Tidak ada data</td></tr>";  
                        }
                     ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>
 <script>
    
    function cetak(){ 
        window.print()
    } 
 </script>