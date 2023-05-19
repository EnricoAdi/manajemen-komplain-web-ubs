<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold" id="titlePage">List Komplain Semua Divisi</h1>
<div class=" mb-4 mt-4" style="background-color: white;" id="areaprint">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
                <thead> 
                    <tr>
                        <th>Nomor Komplain</th>
                        <th>Status Komplain</th>
                        <th>Judul Komplain</th>
                        <th>Deadline Komplain</th>
                        <th>Divisi Tujuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(sizeof($listKomplain) > 0){ 
                            foreach ($listKomplain as $key => $value) { 
                                $url = base_url()."GM/detail/index/$value->NOMORKOMPLAIN";
                                if($key % 17 == 0 && $key > 1){
                                    //dipecah untuk 17 data per halaman
                                    echo "<tr class='nextpage'>";
                                }else{
                                    echo "<tr>";    
                                }
                                echo " 
                                        <td>$value->NOMORKOMPLAIN</td>
                                        <td>$value->STATUS</td>
                                        <td>$value->JUDUL</td>
                                        <td>$value->DEADLINE</td> 
                                        <td>$value->DIVISITUJUAN</td>
                                        <td><a href='$url'>DETAIL</a></td>
                                    </tr>"; 
                            } 
                        }else{
                            echo "<tr><td colspan='12' class='text-center'>Tidak ada data</td></tr>";  
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    
    function cetak(){ 
        window.print()
    } 
</script>