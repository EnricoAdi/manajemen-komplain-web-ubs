<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Laporan Per Topik</h1>


<form action="<?= base_url() ?>Admin/Laporan/PerTopik" method="get" class="mt-4 mb-4" style="color:black;">
    <div class="row">
        <div class="col mt-2">
            <label for="topik" class="form-label">Periode Mulai :</label>
            <input type="date" name="periodeMulai" class="form-control" value="<?= $dateNow; ?>">

            <label class="form-label mt-4">Topik</label>
            <select class="form-control" required>
            </select>
        </div>
        <div class="col mt-2">
            <label for="topik" class="form-label">Periode Selesai :</label>
            <input type="date" name="periodeSelesai" class="form-control" value="<?= $dateNow; ?>">
            <label for="" class="form-label mt-4">Subtopik 1</label>
            <select class="form-control" required>
            </select>
        </div>
        <div class="col"> 
            <label class="form-label" style="margin-top: 102px;">Subtopik 2</label>
            <select class="form-control" required>
            </select>
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
            <button class="btn btn-primary" style=" width:100%;background-color: <?= primary_color(); ?>;">
                <i class="fas fa-fw fa-print mr-2" style="font-weight: bolder;"></i>
                Cetak Laporan
            </button>
        </div>
        <div class="col">

        </div>
    </div>
</form>
<div>Hasil Laporan :</div>
<div class="card shadow mb-4 mt-4">
     <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Laporan Detail Feedback</h6>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered"   width="100%" cellspacing="0">
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