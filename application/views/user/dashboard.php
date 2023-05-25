<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800 font-weight-bold">Dashboard User</h1>
<?= primary_button("Ajukan Komplain", "fas fa-fw fa-paper-plane mr-2", "", "mr-2 mb-2 ", "User/Complain/Add") ?>

<div class="row mt-2">
    <div class="col mt-2">
        <?= card_type_1("Komplain Terkirim", $jumlahKomplainTerkirim, "fa-paper-plane", "primary") ?>
    </div>
    <div class="col mt-2">
        <?= card_type_1("Komplain Diterima", $jumlahKomplainDiterimaByUser, "fa-check", "primary") ?>
    </div>
    <div class="col mt-2">
        <?= card_type_1("Komplain Sedang Ditangani", $jumlahKomplainDikerjakanByUser, "fa-clock", "primary") ?>
    </div>
</div>
<?php
  $jumlahKomplainDikirimBulanIni = sizeof($listKomplainDikirimBulanIniByUser);
  $jumlahKomplainOnGoingByUser = sizeof($listKomplainOnGoingByUser);
?>
<div class="row mt-4">
    <div class="col"><h4 class="h4 text-gray-800" style="font-weight:bold">Komplain Dikirim Bulan Ini</h4></div>

    <?php if($jumlahKomplainDikirimBulanIni>4): ?>
    <div class="col flex"><p class="text-right" style="text-align:end;"><a href="<?=base_url();?>User/Complain/ListComplain">Lihat lainnya...</a></u></div> 
    <?php endif; ?>
</div>

<div class="d-flex flex-wrap align-items-start ">
    <?php
    $counterDikirim = 0;
    foreach ($listKomplainDikirimBulanIniByUser as $komplain) { 
        if($counterDikirim<4){ 
            $color = "primary";
            if ($komplain->STATUS == "OPEN") {
                $color = "success";
            } else if ($komplain->STATUS == "CLOSE") {
                $color = "danger";
            }
            $url = base_url()."User/Complain/Detail/index/$komplain->NO_KOMPLAIN";
            echo " 
                    <a href='$url'> 
                        <div class='card shadow h-100 py-2 mr-3 mt-3' style='width:200px;'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center'>
                                    <div class='col mr-2'>
                                        <div class='text-xs font-weight-bold text-uppercase mb-1'>
                                            Nomor : $komplain->NO_KOMPLAIN</div>
                                            <div class='text-xs font-weight-bold text-uppercase mb-1'>
                                                Status : <span class='text-$color'>$komplain->STATUS</span> </div> 
                                        <div class='h6 mt-3 font-weight-bold text-gray-800'>Topik : <br>$komplain->NAMATOPIK DIVISI $komplain->NAMADIVISI</div>
                                        <div class='text-xs font-weight-bold text-uppercase mt-4'>
                                            Terbit : $komplain->TGL_TERBIT</div>
                                    </div> 
                                </div>
                            </div>
                        </div> 
                    </a> ";
                    
            $counterDikirim+=1;
        }
    }
    if (sizeof($listKomplainDikirimBulanIniByUser) == 0)
        echo card_type_1("Belum Ada Komplain", "", "", "primary");
    ?>

</div>
<div class="row mt-4">
    <div class="col"><h4 class="h4 text-gray-800" style="font-weight:bold">Komplain Sedang Diselesaikan</h4></div>
    <?php if($jumlahKomplainOnGoingByUser>4): ?>
    <div class="col flex"><p class="text-right" style="text-align:end;"><a href="<?=base_url();?>User/Complained/Penyelesaian">Lihat lainnya...</a></u></div> 
    <?php endif; ?>
</div>

<div class="d-flex flex-wrap align-items-start mb-4">
    <?php
    $counterDikerjakan = 0;
    foreach ($listKomplainOnGoingByUser as $komplain) {
        $color = "primary";
        if ($komplain->STATUS == "OPEN") {
            $color = "success";
        } else if ($komplain->STATUS == "CLOSE") {
            $color = "danger";
        }
        $progress = 20;
        if ($komplain->T_KOREKTIF != null) {
            $progress = 50;
            if ($komplain->USER_DONE != null) {
                $progress = 75;
                if ($komplain->USER_VALIDASI != null) {
                    $progress = 100;
                }
                if ($komplain->USER_CANCEL != null) {
                    $progress = 100;
                }
                if ($komplain->USER_BANDING != null) {
                    $progress = 100;
                }
            }
        }
        //apabila belum ada penyelesaian namun sudah ditugaskan, maka progress = 20
        //apabila sudah ada penyelesaian diisi, maka progress = 50
        //apabila sudah ada penyelesaian diisi dan sudah di done, maka progress = 75
        //apabila sudah divalidasi, maka progress = 100
        if($counterDikerjakan<4){
                
            $url = base_url()."User/Complained/Penyelesaian/detail/$komplain->NO_KOMPLAIN";
            echo " 
                    <a href='$url'>
                    <div class='card shadow h-100 py-2 mr-3 mt-3' style='width:200px'>
                        <div class='card-body'>
                            <div class='row no-gutters align-items-center'>
                                <div class='col mr-2'>
                                    <div class='text-xs font-weight-bold text-uppercase mb-2 text-black'>
                                        No : $komplain->NO_KOMPLAIN</div>

                                        <div class='text-xs font-weight-bold text-uppercase mb-1'>
                                        Proses Penyelesaian</div>
                                        <div class='progress progress-md mb-2 mt-3'>
                                            <div class='progress-bar' role='progressbar' style='width: $progress%'
                                                aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100'>
                                                $progress%</div>
                                        </div>  
                                    <div class='h6 mt-3 font-weight-bold text-gray-800'>Topik : <br>$komplain->NAMATOPIK DIVISI $komplain->NAMADIVISI</div>
                                    <div class='text-xs font-weight-bold text-uppercase mt-4'>
                                        DITERBITKAN : $komplain->TGL_TERBIT</div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    </a>";
                    $counterDikerjakan +=1;
        }
    }

    if (sizeof($listKomplainOnGoingByUser) == 0)
        echo card_type_1("Belum Ada Komplain Dalam Proses", "", "", "primary");
    ?>

</div>