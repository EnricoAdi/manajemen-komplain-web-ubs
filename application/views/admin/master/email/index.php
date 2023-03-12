 
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Master Email</h1>
 
<a href="<?= base_url()?>Admin/Master/Email/Add">

    <button type="button" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">
        <i class="fas fa-fw fa-plus"></i>
        Tambah
    </button>
</a>
<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Email</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Divisi</th>
                        <th>User</th>
                        <th>Nama</th>
                        <th>Email User</th>
                        <th>Atasan</th>
                        <th>Nama Atasan</th>
                        <th>Email Atasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                        $url = base_url()."Admin/Master/Email/Detail/$user->NOMOR_INDUK";
                        echo "<tr>";
                        echo "<td>" . $user->NAMA_DIVISI . "</td>";
                        echo "<td>" . $user->NOMOR_INDUK . "</td>";
                        echo "<td>" . $user->NAMA . "</td>";
                        echo "<td>" . $user->EMAIL . "</td>";
                        echo "<td>" . $user->KODE_ATASAN . "</td>";
                        echo "<td>" . $user->NAMA_ATASAN. "</td>";
                        echo "<td>" . $user->EMAIL_ATASAN. "</td>";
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