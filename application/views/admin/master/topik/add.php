<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Input Topik</h1>
<a href="<?= base_url() ?>Admin/Master/Topik">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">
        
        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>

</a> 
<form action="<?= base_url() ?>Admin/Master/Topik/AddProcess" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col">
            <label for="topik" class="form-label">Topik</label>
            <input type="text" class="form-control" placeholder="Masukkan Topik" aria-label="First name" name="topik" required>

            <label for="inputPassword5" class="form-label mt-4">Nama</label>
            <input type="text" class="form-control" placeholder="Masukkan Nama" aria-label="First name" name="nama" required>
        </div>
        <div class="col">
            <label for="inputPassword5" class="form-label">Divisi Tujuan</label>
            <select name="divisi" class="form-control">
               
                <?php
                    foreach ($list_divisi as $divisi) { 
                        echo "<option value='$divisi->KODE_DIVISI'>$divisi->NAMA_DIVISI</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="deskripsi" class="form-label mt-5">Deskripsi</label>
            <textarea class="form-control" placeholder="" name="deskripsi" required></textarea>
        </div> 
    </div>
    <div class="row mt-4">
        <div class="col"> 
            <button type="submit" class="btn btn-warning" style="color:black;">Tambah</button>
        </div> 
    </div>
</form>