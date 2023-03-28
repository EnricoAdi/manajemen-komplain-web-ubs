 <h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Laporan Detail Feedback</h1>


 <form action="<?= base_url() ?>Admin/Laporan/DetailFeedback" method="get" class="mt-4 mb-4" style="color:black;">
     <div class="row">
         <div class="col mt-2">
             <label for="topik" class="form-label">Periode Mulai :</label>
             <input type="date" name="periodeMulai" class="form-control" value="<?= $dateNow; ?>">

             <label for="" class="form-label mt-4">Topik</label>
             <input type="text" class="form-control" required>
         </div>
         <div class="col mt-2">
             <label for="topik" class="form-label">Periode Selesai :</label>
             <input type="date" name="periodeSelesai" class="form-control" value="<?= $dateNow; ?>">
 
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
             <button class="btn btn-primary" style=" width:100%; background-color: <?= primary_color(); ?>;">
                 <i class="fas fa-fw fa-print mr-2" style="font-weight: bolder;"></i>
                 Cetak Laporan
             </button></div>
         <div class="col">

         </div>
     </div>
 </form>
 <div>Hasil Laporan :</div>