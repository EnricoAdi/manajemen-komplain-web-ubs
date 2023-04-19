<?php
function middleware_auth($hak_akses_target){
    $ci = &get_instance();  

    //code ini digunakan untuk menjadi sebuah midlleware jika user mencoba akses halaman ini tanpa login
     if($ci->UsersModel->getLogin() == null){ 
        $ci->session->set_flashdata('header', 'Pesan');
        $ci->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
        redirect('Auth');
    }

    //jika tidak ada akses, maka redirect ke halaman berdasarkan hak aksesnya
    $hak_akses = $ci->UsersModel->getLogin()->KODE_HAK_AKSES;

    if($hak_akses_target!=$hak_akses){

        if ($hak_akses == '1') {  
            redirect('User/Dashboard'); //end user
        }
        if ($hak_akses == '2') { 
            redirect('Manager/Dashboard'); //manager
        }
        if ($hak_akses == '3') { 
            redirect('GM/Dashboard'); //manager
        }
        else { 
            redirect('Admin'); //admin
        }
    }
}

function middleware_topik($kode_topik,$urlIfError){
    $ci = &get_instance();  

    $topik = $ci->TopikModel->get($kode_topik); 
    if($topik==null){
        $ci->session->set_flashdata('header', 'Pesan');
        $ci->session->set_flashdata('message', 'Topik tidak ditemukan');
        redirect($urlIfError);
    }   
}

function middleware_komplainA($nomor_komplain,$urlIfError){
    $ci = &get_instance();  

    $komplain = $ci->KomplainAModel->get($nomor_komplain); 
    
    if($komplain==null){
        $ci->session->set_flashdata('header', 'Pesan');
        $ci->session->set_flashdata('message', 'Komplain tidak ditemukan');
        redirect($urlIfError);
    }   
}
function middleware_komplainB($nomor_komplain,$urlIfError){
    $ci = &get_instance();  

    $komplain = $ci->KomplainBModel->get($nomor_komplain); 
    
    if($komplain==null){
        $ci->session->set_flashdata('header', 'Pesan');
        $ci->session->set_flashdata('message', 'Komplain tidak ditemukan');
        redirect($urlIfError);
    }   
}

function middleware_lampiran_komplain($nomor_komplain,$kode_lampiran,$urlIfError){
    $ci = &get_instance();  

    $lampiran = $ci->LampiranModel->get($kode_lampiran); 
    
    if($lampiran==null || $lampiran->NO_KOMPLAIN!=$nomor_komplain){
        $ci->session->set_flashdata('header', 'Pesan');
        $ci->session->set_flashdata('message', 'Lampiran tidak ditemukan');
        redirect($urlIfError);
    }   
}