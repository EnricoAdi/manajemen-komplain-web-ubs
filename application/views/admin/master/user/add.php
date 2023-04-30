<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Input User</h1>
<a href="<?= base_url() ?>Admin/Master/User">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;">
        
        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>

</a> 
<form action="<?= base_url() ?>Admin/Master/User/AddProcess" method="post" class="mt-4" style="color:black;">
    <div class="row">
        <div class="col">
            <label for="" class="form-label">Nomor Induk</label>
            <input type="text" class="form-control" placeholder="Masukkan Nomor Induk" aria-label="Nomor Induk" name="induk" required>

            <label for="" class="form-label mt-4">Nama</label>
            <input type="text" class="form-control" placeholder="Masukkan Nama" aria-label="First name" name="nama" required>
        </div>
        <div class="col">
            <label for="" class="form-label">Hak Akses</label>
            <select name="akses" class="form-control">
               
                <?php
                    foreach ($hak_akses as $hak_akses) { 
                        echo "<option value='$hak_akses->KODE_HAK_AKSES'>$hak_akses->NAMA_HAK_AKSES</option>";
                    }
                ?>
            </select>
            <label for="" class="form-label">Divisi</label>
            <select name="akses" class="form-control">
               
                <?php
                    foreach ($divisi as $divisi) { 
                        echo "<option value='$divisi->KODE_DIVISI'>$divisi->NAMA_DIVISI</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="" class="form-label">Email User</label>
            <input type="email" class="form-control" placeholder="Masukkan Email User" aria-label="Email User" name="email" required>

            <label for="" class="form-label mt-4">Password User</label>
            <input type="password" class="form-control" placeholder="Masukkan Password User" aria-label="Password User" name="pass" required>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col"> 
            <button type="submit" class="btn btn-warning" style="color:black;">Tambah</button>
        </div> 
    </div>
</form>