<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Daftar Penyelesaian Komplain Diterima</h1>
 
<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Penyelesaian Komplain Diterima</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Komplain</th>
                        <th>Tgl Komplain</th>
                        <th>Topik</th> 
                        <th>Subtopik 2</th>
                        <th>Deskripsi Masalah</th> 
                        <th>Divisi Pengirim</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody> 
                    
                <?php  
                        foreach ($complains as $complain) {
                            
                            $urlDetail = base_url()."User/Complain/Solved/detail/$complain->NO_KOMPLAIN";
                            echo "<tr>";
                            echo "<td>$complain->NO_KOMPLAIN</td>";
                            echo "<td>$complain->TGL_TERBIT</td>";
                            echo "<td>$complain->TOPIK</td>";
                            echo "<td>$complain->SUB_TOPIK2</td>";
                            echo "<td>$complain->DESKRIPSI_MASALAH</td>";
                            echo "<td>$complain->DIVISI_PENGIRIM</td>";
                            echo "<td>  
                                    <a href='$urlDetail'> 
                                        <button class='btn btn-warning' style='color:black'>
                                        <i class='fas fa-fw fa-info-circle'></i> 
                                           Detail
                                        </button>  
                                    </a> 
                            </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div> 
</div> 