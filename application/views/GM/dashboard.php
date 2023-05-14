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
                        echo "<div class='col'>";
                            echo "<div class='card shadow mb-4 mt-4'>";
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
                        echo "</div>";
                    }
                }
                else {
                    echo "<div class='col'>";
                        echo "<div class='card-body'>";
                            echo "<h6 class='m-0 font-weight-normal text-primary'>"."Komplain urgent untuk ".$divisi." tidak tersedia"."</h6>";
                        echo "</div>";
                    echo "</div>";
                }
            ?>

        </div>
        
    </div>
</div>

<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Komplain Terkirim dari divisi <?php echo " ". $komplainDiterima[0]->DIVISI ?> selama 90 hari terakhir</h6>
    </div>
    <div class="card-body">
        <?php
            if ($komplainTerkirim != null && $komplainTerkirim != "Belum ada") {
                echo "Komplain terkirim sebanyak ".$komplainTerkirim[0]->JUMLAH;
            }
            else {
                echo "<H1>" . "Belum ada komplain terkirim" . "</H1>";
            }
        ?>
    </div>
</div>

<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Komplain Diterima untuk divisi <?php echo " ". $komplainDiterima[0]->DIVISI ?> selama 90 hari terakhir</h6>
    </div>
    <div class="card-body">
    <?php
            if ($komplainDiterima != null && $komplainDiterima != "Belum ada") {
                echo "Komplain diterima sebanyak ".$komplainDiterima[0]->JUMLAH;
            }
            else {
                echo "<H1>" . "Belum ada komplain diterima" . "</H1>";
            }
        ?>
    </div>
</div>