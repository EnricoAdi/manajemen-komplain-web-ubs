<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Master Subtopik 1</h1>
 
<?= error_button("Kembali","fas fa-fw fa-step-backward","","","Admin/Master/Topik/Menu")?>
<?= primary_button("Tambah","fas fa-fw fa-plus","","","Admin/Master/Subtopik1/Add")?>
 
<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Subtopik 1</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Divisi</th>
                        <th>Topik</th>
                        <th>Subtopik 1  </th>
                        <th>Deskripsi</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($subtopics as $subtopic) {

                        $url = base_url()."Admin/Master/Subtopik1/Detail/$subtopic->KODE_TOPIK/$subtopic->SUB_TOPIK1";
                        echo "<tr>";
                        echo "<td>" . $subtopic->NAMA_DIVISI . "</td>";
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