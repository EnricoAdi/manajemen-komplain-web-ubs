<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Dashboard GM</h1>
<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Komplain Belum Diselesaikan Seluruh Divisi </h6>
    </div>
    
    <div class="card-body">
        <div class="row">
            <?php
                    $ctr = 0;
                    if ($komplainUrgent != null && $komplainUrgent != "Belum ada") {
                        foreach ($komplainUrgent as $komplainUrgent) {
                            $ctr+=1;
                            $url = base_url()."GM/detail/index/$komplainUrgent->NO_KOMPLAIN";
                            echo "<a href='$url'><div class='col' style='width:200px'>";
                                echo "<div class='card mb-4 mt-4'>";
                                    echo "<div class='card-header py-3'>";
                                        echo "<h6 class='m-0 font-weight-bold text-primary'>No. Komplain : ".$komplainUrgent->NOMORKOMPLAIN."</h6>";
                                    echo "</div>";

                                    echo "<div class='card-body'>";
                                        echo "<h6 class='m-0 font-weight-normal text-primary'>Status : ".$komplainUrgent->STATUS."</h6>";
                                        echo "<h6 class='m-0 font-weight-normal text-primary'>Topik : ".$komplainUrgent->JUDUL."</h6>";
                                        echo "<h6 class='m-0 font-weight-normal text-primary'>Deadline : ".$komplainUrgent->DEADLINE."</h6>";
                                        echo "<h6 class='m-0 font-weight-normal text-primary'>Sisa Waktu : ".$komplainUrgent->SISAWAKTU."</h6>";
                                    echo "</div>";

                                echo "</div>";
                            echo "<a href='$url'></div>";
                        }
                    }
                    else {
                        echo "<div class='col'>";
                            echo "<div class='card-body'>";
                                echo "<h6 class='m-0 font-weight-normal text-primary'>"."Komplain urgent untuk tidak tersedia"."</h6>";
                            echo "</div>";
                        echo "</div>";
                    }
                ?>

        </div>
        
    </div>
</div>

<?php
    if ($komplainTerkirim != null && $komplainTerkirim != "Belum ada") {
        $jumlahKomplainTerkirim = $komplainTerkirim[0]->JUMLAH;
    }
    else {
        $jumlahKomplainTerkirim = "<H1>" . "Belum ada komplain terkirim" . "</H1>";
    }

    if ($komplainDiterima != null && $komplainDiterima != "Belum ada") {
        $komplainDiterima2 = $komplainDiterima[0]->JUMLAH;
    }
    else {
        $komplainDiterima2 = "<H1>" . "Belum ada komplain diterima" . "</H1>";  
    }
?>

<div class="row mt-2">
    <div class="col mt-2" style="height:100px;">
        <?= card_type_1("Daftar Komplain Terkirim dari semua divisi selama 90 hari terakhir", $jumlahKomplainTerkirim, "fa-paper-plane", "primary") ?>
    </div>
    <div class="col mt-2" style="height:100px;">
        <?= card_type_1("Daftar Komplain Diterima untuk semua divisi selama 90 hari terakhir", $komplainDiterima2, "fa-check", "primary") ?>
    </div>
</div>