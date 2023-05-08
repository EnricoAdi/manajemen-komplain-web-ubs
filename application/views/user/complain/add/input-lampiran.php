<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color:#F1F2F5;">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihDivisi">Pilih Divisi</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihTopik/<?= $divisi->KODE_DIVISI; ?>">Pilih Topik</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>User/Complain/Add/pilihSubTopik1/<?= $divisi->KODE_DIVISI; ?>/<?= $topik->KODE_TOPIK; ?>">Pilih Subtopik1</a></li>
        <li class="breadcrumb-item "><a href="<?= base_url() ?>User/Complain/Add/pilihSubTopik2/<?= $divisi->KODE_DIVISI; ?>/<?= $topik->KODE_TOPIK; ?>/<?= $subtopik1->SUB_TOPIK1; ?>/<?= $subtopik2->SUB_TOPIK2; ?>">Pilih Subtopik2</a></li>
        <li class="breadcrumb-item active">Pilih Lampiran</li> 
    </ol>
</nav>
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Komplain Baru</h1>


<form action="<?= base_url() ?>User/Complain/Add/addComplainProcess/<?= $divisi->KODE_DIVISI ?>/<?= $topik->KODE_TOPIK ?>/<?= $subtopik1->SUB_TOPIK1 ?>/<?= $subtopik2->SUB_TOPIK2 ?>" method="post" class="mt-4" style="color:black;" enctype="multipart/form-data">
    <!-- <input type="hidden" name="inputSubtopik2" id="inputSubtopik2" value="">
    <input type="hidden" name="inputSubtopik1" id="inputSubtopik1" value="">
    <input type="hidden" name="inputTopik" id="inputTopik" value=""> -->

    <div class="row">
        <div class="col">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="<?= $tanggalPreSended ?>" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col">

            <label class="form-label mt-2">Topik</label>
            <input type="text" class="form-control" id="topik" value="<?= $topik->KODE_TOPIK ?> - <?= $topik->DESKRIPSI; ?>" disabled>

            <label class="form-label mt-2">Sub Topik 1</label>
            <input type="text" class="form-control" id="subtopik1" value="<?= $subtopik1->SUB_TOPIK1 ?> - <?= $subtopik1->DESKRIPSI; ?>" disabled>
            
        </div>
        <div class="col">
            <label class="form-label mt-2">Divisi</label>
            <input type="text" class="form-control" id="divisi" value="<?= $divisi->KODE_DIVISI ?> - <?= $divisi->NAMA_DIVISI ?> " disabled>

            <label class="form-label mt-2">Sub Topik 2</label>
            <input type="text" class="form-control" id="subtopik2" value="<?= $subtopik2->SUB_TOPIK2 ?> - <?= $subtopik2->DESKRIPSI; ?>" disabled>

        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <label for="user" class="form-label">Feedback Sebelumnya</label>

            <select id="feedback" name="feedback" class="form-control">

            </select>
        </div>
        <div class="col">
            <label class="form-label">Unggah Lampiran (.jpg, .png, .pdf, .docx, .xlsx, .txt) Max 5MB</label>
            <input type="file" class="form-control" name="lampiran[]" id="lampiran" style="padding-top:30px; padding-left:20px; height:100px;" accept=".jpg,.png,.pdf,.docx,.xls,.xlsx,.txt" onchange="uploadFile()" size="500000" multiple/>
        </div>
    </div>

    <div class="row">
        <div class="col">

            <label class="form-label">Lampiran diunggah</label> <br>
            <div class="d-flex" id="display_files">

            </div>
            <!-- <img id="display_file" style="width:200px; height:200px; border:1px solid black;"></img> -->
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">

            <label class="form-label">Deskripsi Masalah</label>
            <textarea name="deskripsi" class="form-control" cols="30" rows="3" required></textarea>

        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <?= error_button("Sebelumnya", null, "", "", "User/Complain/Add/pilihSubTopik2/$divisi->KODE_DIVISI/$topik->KODE_TOPIK/$subtopik1->SUB_TOPIK1/$subtopik2->SUB_TOPIK2"); ?>
            <?= primary_submit_button("Kirim", "fas fa-fw fa-paper-plane mr-2", "btnNext", "") ?>
        </div>
    </div>
</form>
<script type="text/javascript">
    const fileInput = document.getElementById("lampiran");
    const imgPreviews = document.getElementById("display_files")
        
    const imgUrl = "<?= asset_url(); ?>images/file.png"

    console.log(imgUrl)
    function removeFile(index){
        alert(index)
    }
    function uploadFile(){
 
        imgPreviews.innerHTML = "" 
        let files = fileInput.files  

            for (let i = 0; i < files.length; i++) {
                const file = files[i]; 
                const size = file.size
                const typeFull = file.type 
                let type = typeFull.split("/")[0]
                //get extension from filename 
                const extension = file.name.split('.').pop().toLowerCase();

                // const reader = new FileReader();  
                newimg = `<div class="" style="width:125px; height:145px; display: flex; align-items: center; margin-left:12px; background-image: url('${imgUrl}');   background-size: cover;" > <p style="padding-left:20px; padding-top:5px; width:16px; font-size: smaller; ">${file.name} </p> <br/></div>`; 
                imgPreviews.innerHTML += newimg;
                
                // reader.addEventListener("load", function () { 
                //     let newimg = ""
                //     if(type=='image'){  
                //          newimg = `<img src="${reader.result}" style="width:200px; height:200px; border:1px solid black; margin-left:10px"></img>`;
                //     }else{  
                //     }

                // }, false);
                
                // if (file) {
                    
                //     reader.readAsDataURL(file);   
                //  }
 
            }  
    } 
        // const file = document.getElementById("lampiran");
        // var uploadedFile = ""; 
        
        // file.onchange = ()=>{ 
        //     
        //     reader.onload = (event)=>{
        //         uploadedFile = reader.result; 
        //         .style.backgroundImage = url  ({uploadedFile});
        //         reader.readDataURL(this.files[0]);
        //     } 
        //     reader.readAsArrayBuffer();
        // } 
 

</script>