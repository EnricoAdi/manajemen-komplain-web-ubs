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
