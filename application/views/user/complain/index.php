
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Daftar Komplain Diajukan</h1>
 
<a href="<?= base_url()?>User/Complain/Add/page/1">

    <button type="button" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">
        
        <i class="fas fa-fw fa-paper-plane mr-2"></i>
        Ajukan Komplain Baru
    </button>
</a>
<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Komplain Diajukan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Komplain</th>
                        <th>Tgl Kejadian</th>
                        <th>Div Tujuan</th>
                        <th>Subtopik 2</th>
                        <th>Status</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($complains as $complain) {
                           echo "<tr>";
                            echo "<td>".$complain->NO_KOMPLAIN."</td>";
                            echo "<td>".$complain->TGL_KEJADIAN."</td>";
                            echo "<td>$complain->NAMA_DIVISI</td>";
                            echo "<td>".$complain->SUB_TOPIK2."</td>";
                            echo "<td>".$complain->STATUS."</td>";
                            echo "<td>  
                                <button class='btn btn-warning' style='color:black'>
                                <i class='fas fa-fw fa-info-circle'></i> 
                                Detail
                                </button>   
                                <button class='btn btn-danger' style='color:black'>
                                <i class='fas fa-fw fa-trash'></i> 
                                Hapus
                                </button>   
                            </td>";
                           echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>