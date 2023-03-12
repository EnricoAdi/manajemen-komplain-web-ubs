<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Tambah Email</h1>
<a href="<?= base_url() ?>Admin/Master/Email">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>

</a>
<form action="<?= base_url() ?>Admin/Master/Email/AddProcess" method="post" class="mt-4" style="color:black;">
    <input type="hidden" name="inputAtasan" id="inputAtasan">
    <div class="row">
        <div class="col">
            <label type="button" for="user" title="Pastikan divisi user dan atasan sesuai" class="form-label">User</label>
            <select name="user" class="form-control"> 
                <?php
                foreach ($users_no_email as $user) {
                    echo "<option value='$user->NOMOR_INDUK'>$user->NAMA_DIVISI - $user->NOMOR_INDUK - $user->NAMA</option>";
                }
                ?>
            </select>

            <label for="email_user" class="form-label mt-4">Email User</label>
            <input type="email" class="form-control" placeholder="@ubslinux.com" name="email_user" required>
        </div>
        <div class="col">
            <label for="inputPassword5" class="form-label">Atasan</label>
            <select id="atasan" class="form-control">

                <?php
                foreach ($managers as $manager) {
                    echo "<option value='$manager->EMAIL - $manager->NOMOR_INDUK'>$manager->NAMA_DIVISI - $manager->NOMOR_INDUK - $manager->NAMA</option>";
                }
                ?>
            </select>
            <label for="" class="form-label mt-4">Email Atasan</label>
            <input type="text" class="form-control" placeholder="@ubslinux.com" id="emailAtasan" disabled>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <button type="submit" class="btn btn-warning" style="color:white; background-color: <?= primary_color(); ?>;">Tambah</button>
        </div>
    </div>
</form>

<script>
    //script ini digunakan untuk membuat interaktif pengambilan data email dan nomor induk dari manager
    //sebagai atasan dari user yang akan ditambahkan emailnya
    let atasan = document.getElementById('atasan');
    let inputAtasan = document.getElementById('inputAtasan');
    let emailAtasan = document.getElementById('emailAtasan');
    let posisi = atasan.value.indexOf('-');
    emailAtasan.value = atasan.value.substring(0, posisi);
    inputAtasan.value = atasan.value.substring(posisi + 2);
    atasan.addEventListener('change', function() {
        let posisi = atasan.value.indexOf('-');
        emailAtasan.value = atasan.value.substring(0, posisi);
        inputAtasan.value = atasan.value.substring(posisi + 2);
    });
</script>