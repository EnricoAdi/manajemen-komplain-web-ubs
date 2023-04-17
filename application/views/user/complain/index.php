
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Daftar Komplain Diajukan</h1>
 
<a href="<?= base_url()?>User/Complain/Add/pilihDivisi">

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
                            $yellow = secondary_color();
                            $red = error_color();
                            $urlDetail = base_url()."User/Complain/Detail/index/$complain->NO_KOMPLAIN";
                            echo "<tr>";
                            echo "<td>".$complain->NO_KOMPLAIN."</td>";
                            echo "<td>".$complain->TGL_KEJADIAN."</td>";
                            echo "<td>$complain->NAMA_DIVISI</td>";
                            echo "<td>".$complain->SUB_TOPIK2."</td>";
                            echo "<td>".$complain->STATUS."</td>";
                            echo "<td>  
                               <a href='$urlDetail'>
                                <button class='btn btn-warning' style='background-color:$yellow'>
                                <i class='fas fa-fw fa-info-circle'></i> 
                                Detail
                                </button>
                                </a>   

                                <button class='btn btn-danger btnDelete' id='$complain->NO_KOMPLAIN' style='background-color:$red'>
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

<?php
    foreach($complains as $complain){
        $urlDelete = base_url()."User/Complain/ListComplain/DeleteComplain/$complain->NO_KOMPLAIN"; 
        echo "
        <div class='modal fade' id='confirmDeleteModal$complain->NO_KOMPLAIN' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
        aria-hidden='false'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Konfirmasi</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                    </button>
                </div>
                <div class='modal-body'>Apakah anda yakin ingin menghapus komplain $complain->NO_KOMPLAIN?</div>
                <div class='modal-footer'>
                    <button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>
                    <a class='btn btn-primary' href='$urlDelete'>Ya</a>
                    </div>
                </div>
            </div>
        </div> ";
} 
?>
 


<script type="text/javascript">
 
window.onload = function(){ 
    let btnDeletes = document.getElementsByClassName("btnDelete"); 
    for (let i = 0; i < btnDeletes.length; i++) {
    let element = btnDeletes[i];
    let id = element.id;
    
    element.onclick = function(){ 
        console.log( $('#confirmDeleteModal'+id).modal('show'))
        $('#confirmDeleteModal'+id).modal('show');
    }
}}

</script>