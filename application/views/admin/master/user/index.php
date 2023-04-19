 
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Master User</h1>
  
 <?= primary_button("Tambah","fas fa-fw fa-plus","","","Admin/Master/User/Add")?>
 
 <div class="card shadow mb-4 mt-4">
     <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                     <tr>
                         <th>Nomor Induk</th>
                         <th>Nama</th> 
                         <th>Divisi</th> 
                         <th>Hak Akses</th> 
                         <th>Aksi</th> 
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                     foreach ($users as $user) { 
                        $url =  base_url()."Admin/Master/User/Detail/$user->NOMOR_INDUK";

                        $hak_akses = "";
                        if($user->KODE_HAK_AKSES == 1){
                            $hak_akses = "End User";
                        }else if($user->KODE_HAK_AKSES == 2){
                            $hak_akses = "Manager";
                        }else if($user->KODE_HAK_AKSES == 3){
                            $hak_akses = "GM";
                        }else if($user->KODE_HAK_AKSES == 4){
                            $hak_akses = "Admin";
                        } 

                        echo "<tr>";
                        echo "<td>".$user->NOMOR_INDUK."</td>";
                        echo "<td>".$user->NAMA."</td>";
                        echo "<td>".$user->NAMA_DIVISI."</td>"; 
                        echo "<td>".$hak_akses."</td>";
                        echo "<td>
                            <a href='$url'>
                            
                            <button class='btn btn-warning' style='color:black'>
                            <i class='fas fa-fw fa-info-circle'></i> 
                            Detail
                            </button>
                            </a></td>
                        ";
                        echo "</tr>";

                      }
                     ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>