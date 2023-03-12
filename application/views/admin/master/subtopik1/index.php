<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Master Subtopik 1</h1>
<a href="<?= base_url()?>Admin/Master/Topik/Menu">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px; 
        background-color:<?= error_color(); ?>">
        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>
<a href="<?= base_url()?>Admin/Master/Subtopik1/Add"> 
    <button type="button" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">
        <i class="fas fa-fw fa-plus"></i>
        Tambah
    </button>
</a>


<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Subtopik 1</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Topik</th>
                        <th>Subtopik 1  </th>
                        <th>Deskripsi</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($subtopics as $subtopic) {

                        $url = base_url()."Admin/Master/Subtopik1/Detail/$subtopic->SUB_TOPIK1";
                        echo "<tr>";
                        echo "<td>" . $subtopic->TOPIK . "</td>";
                        echo "<td>" . $subtopic->SUB_TOPIK1 . "</td>";
                        echo "<td>" . $subtopic->DESKRIPSI . "</td>"; 
                        echo "<td>
                                <a href='$url'>
                                  
                                 <button class='btn btn-warning' style='color:black'>
                                 <i class='fas fa-fw fa-info-circle'></i> 
                                 Detail
                                 </button></td>
                                </a>
                               ";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>