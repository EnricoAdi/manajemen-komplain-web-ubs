<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <ol class="breadcrumb" style="background-color:#F1F2F5;">
         <a href=""><li class="breadcrumb-item ">Detail</li></a> 
         <li class="breadcrumb-item active">Lampiran</li>
     </ol>
 </nav>
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Input Penyelesaian Komplain</h1>

<a href="<?= base_url() ?>User/Complained/Penyelesaian/detail/<?= $komplain->NO_KOMPLAIN; ?>">

    <button type="button" class="btn btn-warning" style="color:black; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color:<?= error_color(); ?>">

        <i class="fas fa-fw fa-step-backward"></i>
        Kembali
    </button>
</a>
