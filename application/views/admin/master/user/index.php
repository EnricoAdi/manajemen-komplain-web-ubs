 <h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Master User</h1>
<a href="<?= base_url()?>Admin/Master/User/Menu">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px; 
        background-color:<?= error_color(); ?>">
        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>
<a href="<?= base_url()?>Admin/Master/User/Add">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">
        <i class="fas fa-fw fa-plus"></i>
        Input
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
                        <th>Nomer Induk</th>
                        <th>Nama User</th>
                        <th>Hak Akses</th>
                        <th>Email</th>
                        <th>Divisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                        $url = base_url()."Admin/Master/User/Detail/$user->NOMOR_INDUK";
                        echo "<tr>";
                        echo "<td>" . $user->NOMOR_INDUK . "</td>";
                        echo "<td>" . $user->NAMA . "</td>";
                        echo "<td>" . $user->KODE_HAK_AKSES . "</td>";
                        echo "<td>" . $user->EMAIL . "</td>";
                        echo "<td>" . $user->KODE_DIVISI . "</td>";
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