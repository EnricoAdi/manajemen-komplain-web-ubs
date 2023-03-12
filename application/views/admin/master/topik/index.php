 
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Master Topik</h1>
<a href="<?= base_url()?>Admin/Master/Topik/Menu">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px; 
        background-color:<?= error_color(); ?>">
        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>
<a href="<?= base_url()?>Admin/Master/Topik/Add">

    <button type="button" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">
        <i class="fas fa-fw fa-plus"></i>
        Tambah
    </button>
</a>
<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Topik</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Topik</th>
                        <th>Kode Topik</th>
                        <th>Divisi Tujuan</th>
                        <th>AU</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($topics as $topic) {
                        $url = base_url()."Admin/Master/Topik/Detail/$topic->KODE_TOPIK";
                        echo "<tr>";
                        echo "<td>" . $topic->TOPIK . "</td>";
                        echo "<td>" . $topic->KODE_TOPIK . "</td>";
                        echo "<td>" . $topic->NAMA_DIVISI . "</td>";
                        echo "<td>" . $topic->AU . "</td>";
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