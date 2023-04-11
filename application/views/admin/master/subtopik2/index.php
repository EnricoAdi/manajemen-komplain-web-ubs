<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Master Subtopik 2</h1>

<?= error_button("Kembali", "fas fa-fw fa-step-backward", "", "", "Admin/Master/Topik/Menu") ?>

<?= primary_button("Tambah", "fas fa-fw fa-plus", "", "", "Admin/Master/Subtopik2/Add") ?>
 

<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Subtopik 2</h6>
    </div>
    <input type="hidden" id="url" value="<?= base_url();?>">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Divisi</th>
                        <th>Topik</th>
                        <th>Subtopik 1  </th>
                        <th>Subtopik 2  </th>
                        <th>Deskripsi</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableSubtopik2">
                    <?php
                    foreach ($subtopics as $subtopic) {

                        $url = base_url()."Admin/Master/Subtopik2/Detail/$subtopic->KODE_TOPIK/$subtopic->SUB_TOPIK1/$subtopic->SUB_TOPIK2";
                        echo "<tr>";
                        echo "<td>" . $subtopic->NAMA_DIVISI . "</td>";
                        echo "<td>" . $subtopic->TOPIK . "</td>";
                        echo "<td>" . $subtopic->DESKRIPSI_SUBTOPIK1 . "</td>";
                        echo "<td>" . $subtopic->SUB_TOPIK2 . "</td>";
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
<!-- <script>
    window.onload = ()=>{
        const url = document.getElementById("url").value;
        const urlFetch = url+"Admin/Master/Subtopik2/fetch"; 
        let isiTabel = ``;
        const table = document.getElementById("tableSubtopik2");
        fetch(urlFetch).then((data)=>data.json()).then((data)=>
        // data.data.length
            {for (let i = 0; i < 10; i++) {
                 const d = data.data[i]
                 let urlD = url + `Admin/Master/Subtopik2/Detail/${d.SUB_TOPIK2}`
                 
                // table.innerHTML = isiTabel;
                table.innerHTML+= `
                    <tr>
                          <td> ${d.NAMA_DIVISI}</td>
                          <td> ${d.TOPIK}</td>
                          <td> ${d.DESKRIPSI_SUBTOPIK1}</td> 
                          <td> ${d.SUB_TOPIK2}</td>  
                          <td> ${d.DESKRIPSI}</td> 
                          <td>
                          <a href='${urlD}'>
                                  
                                 <button class='btn btn-warning' style='color:black'>
                                  <i class='fas fa-fw fa-info-circle'></i> 
                                 Detail
                                  </button></td>
                                 </a>  
                          </td>
                    </tr>
                 `
            } 
        
            }
        )
 
    }
</script> -->