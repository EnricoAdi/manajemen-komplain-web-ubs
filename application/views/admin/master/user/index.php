 
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Master User</h1>
 
 <a href="<?= base_url()?>Admin/Master/User/Add">
 
     <button type="button" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;
         padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">
         <i class="fas fa-fw fa-plus"></i>
         Tambah
     </button>
 </a>
 <div class="card shadow mb-4 mt-4">
     <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                     <tr>
                         <th>Divisi</th>
                         <th>User</th>
                         <th>Nama</th> 
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                     foreach ($users as $user) { 
                      }
                     ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>