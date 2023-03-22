<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Daftar Komplain Mendatang dari Divisi Lain</h1>
 
<a href="<?= base_url()?>User/Complained/Penugasan">

    <button type="button" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">
        
        <i class="fas fa-fw fa-wrench mr-2"></i>
        Ke Halaman Penugasan
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
                        <th>Div Pengirim</th>
                        <th>Subtopik 2</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody> 
                    
                <?php 
                        foreach ($complains as $complain) {
                            
                            $urlDetail = base_url()."User/Complain/Detail/index/$complain->NO_KOMPLAIN";
                            echo "<tr>";
                            echo "<td>".$complain->NO_KOMPLAIN."</td>";
                            echo "<td>".$complain->TGL_KEJADIAN."</td>";
                            echo "<td>$complain->DIVISI_PENGIRIM</td>";
                            echo "<td>".$complain->SUB_TOPIK2."</td>"; 
                            echo "<td>   
                                    <button class='btn btn-success btnVerifikasi' id='$complain->NO_KOMPLAIN' style='color:black'>
                                    <i class='fas fa-fw fa-check'></i> 
                                        Verifikasi
                                    </button> 

                                    <button class='btn btn-danger' id='$complain->NO_KOMPLAIN' style='color:black'>
                                    <i class='fas fa-fw fa-stop'></i> 
                                        Transfer
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
        $url = base_url()."User/Complained/ListComplained/VerifikasiComplain/$complain->NO_KOMPLAIN"; 
        echo "
        <div class='modal fade' id='confirmVerifikasiModal$complain->NO_KOMPLAIN' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
        aria-hidden='false'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel' style='font-weight:bold;'>Verifikasi Komplain</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                    </button>
                </div>
                <form action='$url' method='post'>
                 
                <div class='modal-body'>
                    $complain->NO_KOMPLAIN / $complain->TGL_KEJADIAN <br/><br/>
                    Topik : $complain->TOPIK - $complain->TDESKRIPSI <br/>
                    Subtopik 1 : $complain->SUB_TOPIK1 - $complain->S1DESKRIPSI <br/>
                    Subtopik 2 : $complain->SUB_TOPIK2 - $complain->S2DESKRIPSI <br/><br/>
                    Deskripsi Masalah <br/>
                    $complain->DESKRIPSI_MASALAH <br/><br/>

                    <input type='checkbox' name='' required/> Saya Menyetujui Verifikasi 
                </div>
                <div class='modal-footer'> 
                    <button class='btn btn-secondary' type='button' style='color:black;' data-dismiss='modal'>TUTUP</button>
                    <button class='btn btn-success'style='color:black;' type='submit'>VERIFIKASI</button>
                    </div>
                </div>
                
                </form>
            </div>
        </div> ";
} 
?>

<script type="text/javascript">
 
window.onload = function(){ 
    let btnVerifikasis = document.getElementsByClassName("btnVerifikasi"); 
    for (let i = 0; i < btnVerifikasis.length; i++) {
    let element = btnVerifikasis[i];
    let id = element.id;
    
    element.onclick = function(){ 
        console.log( $('#confirmVerifikasiModal'+id).modal('show'))
        $('#confirmVerifikasiModal'+id).modal('show');
    }
}}

</script>