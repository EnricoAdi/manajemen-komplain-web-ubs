<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Detail Penyelesaian Komplain</h1>

<a href="<?= base_url() ?>User/Complained/Penyelesaian/detail/<?= $komplain->NO_KOMPLAIN; ?>">

    <button type="button" class="btn btn-danger" style="color:white; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>

<form action="<?= base_url() ?>User/Complained/Penyelesaian/editPenyelesaianProcess/<?= $komplain->NO_KOMPLAIN; ?>" method="post" class="mt-4" style="color:black;">

    <input type="hidden" id="minDate" value="<?= $minDate; ?>">
    <div class="row">
        <div class="col">
            <label class="form-label mt-2">Masalah Komplain</label>
            <textarea class="form-control" disabled><?= $komplain->DESKRIPSI_MASALAH; ?></textarea>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <label for="user" class="form-label">Akar Masalah</label>
            <textarea class="form-control" name="akar-masalah" required><?= $komplain->FEEDBACK->AKAR_MASALAH; ?></textarea>
        </div>
        <div class="col">
            <label for="user" class="form-label">Tindakan Preventif</label>
            <textarea class="form-control" name="preventif" required><?= $komplain->FEEDBACK->T_PREVENTIF; ?></textarea>
        </div>
        <div class="col">
            <label for="user" class="form-label">Tindakan Korektif</label>
            <textarea class="form-control" name="korektif" required><?= $komplain->FEEDBACK->T_KOREKTIF; ?></textarea>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <label class="form-label">Tanggal Deadline</label>
            <?php
            echo "<pre>";
            $parseDate = date_parse($komplain->TGL_DEADLINE);
            $newFormatDate = $parseDate["year"] . "-" . str_pad($parseDate["month"], 2, '0', STR_PAD_LEFT) . "-" . str_pad($parseDate["day"], 2, '0', STR_PAD_LEFT);

            echo "</pre>";
            ?>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $newFormatDate; ?>" required>

        </div>

        <div class="col">
            <label class="form-label">Daftar Lampiran Komplain</label>
            <table class="table">
                <tbody>
                    <?php
                    $counter = 1;
                    foreach ($komplain->LAMPIRAN as $lampiran) {
                        if ($lampiran->TIPE == 0) {
                            echo "<tr>";
                            echo "<td>";
                            echo '<a href="' . base_url() . 'uploads/' . $lampiran->KODE_LAMPIRAN . '" target="_blank">Lampiran ' . $counter . '</a>';
                            echo "</td>";
                            // echo "<td><a href=''><button class='btn btn-danger' style='color:white;'>
                            // <i class='fas fa-fw fa-trash'></i>
                            // Hapus</button> </a></td>"; 
                            echo "<td><button class='btn btn-danger btnDelete' id='$counter' style='color:white;'>
                                <i class='fas fa-fw fa-trash'></i>
                                Hapus</button> </td>";
                            echo "</tr>";
                            $counter = $counter + 1;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="col">
            <label class="form-label">Daftar Lampiran Penyelesaian</label>
            <table class="table">
                <tbody>
                    <?php
                    $counter = 1;
                    foreach ($komplain->LAMPIRAN as $lampiran) {
                        if ($lampiran->TIPE == 1) {
                            echo "<tr>";
                            echo "<td>";
                            echo '<a href="' . base_url() . 'uploads/' . $lampiran->KODE_LAMPIRAN . '" target="_blank">Lampiran ' . $counter . '</a>';
                            echo "</td>";
                            // echo "<td><a href=''><button class='btn btn-danger' style='color:white;'>
                            // <i class='fas fa-fw fa-trash'></i>
                            // Hapus</button> </a></td>"; 
                            echo "<td><button class='btn btn-danger btnDelete' id='$counter' style='color:white;'>
                                <i class='fas fa-fw fa-trash'></i>
                                Hapus</button> </td>";
                            echo "</tr>";
                            $counter = $counter + 1;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="row">
        
        <div class="col">

            <label class="form-label">Tambah Lampiran Penyelesaian</label>
            <input type="file" class="form-control" name="lampiran[]" style="padding-top:30px; padding-left:20px; height:100px;" multiple>

        </div>
        <div class="col"></div>
    </div>
    <!-- <div class="row mt-4">
        <div class="col">  

        </div>
        <div class="col"></div>
        <div class="col"></div>
    </div> -->
    <div class="row mt-4">
        <div class="col">
            <?= error_button("Hapus", "fas fa-fw fa-trash", "btnDelete") ?>
            <?= primary_submit_button("Edit") ?>
        </div>
    </div>
</form>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin ingin menghapus data penyelesaian komplain ini?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-danger" href="<?= base_url() ?>User/Complained/Penyelesaian/deleteFeedback/<?= $komplain->NO_KOMPLAIN; ?>">Ya</a>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = () => {
        const minDate = document.getElementById("minDate").value;
        document.getElementById('tanggal').setAttribute("min", minDate);

        const btnDelete = document.getElementById("btnDelete");
        const askDelete = () => {
            $('#confirmDeleteModal').modal('show');
        };
        btnDelete.addEventListener("click", askDelete);
    }
</script>