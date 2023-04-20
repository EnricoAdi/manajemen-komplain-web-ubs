<?php
/**
 * Middleware ini digunakan untuk mengecek hak akses user
 * apabila user tidak memiliki hak akses, maka akan diredirect sesuai dengan hak aksesnya
 */
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

/**
 * Middleware ini digunakan untuk mengecek apakah topik ada atau tidak
 */
function middleware_topik($kode_topik,$urlIfError){
    $ci = &get_instance();  

    $topik = $ci->TopikModel->get($kode_topik); 
    if($topik==null){
        $ci->session->set_flashdata('header', 'Pesan');
        $ci->session->set_flashdata('message', 'Topik tidak ditemukan');
        redirect($urlIfError);
    }   
}

/**
 * ini adalah middleware untuk komplain A, 
 * Ada beberapa pengecekkan yang bisa dilakukan, strict mode creator digunakan untuk memberi pengecekkan jika user yang login adalah creator komplain, 
 * strict mode divisi complained digunakan untuk memberi pengecekkan jika user yang login adalah divisi yang di complain / divisi yang memberi komplain, strict mode solver complain digunakan untuk memberi pengecekkan jika user yang login adalah yang menangani komplain
 * 
 */
function middleware_komplainA($nomor_komplain,$urlIfError,$strictmodeCreator=false,$strictmodeDivisiComplained=false,$strictModeSolverComplain=false){
    $ci = &get_instance();  

    $komplain = $ci->KomplainAModel->get($nomor_komplain); 
    
    if($komplain==null){
        $ci->session->set_flashdata('header', 'Pesan');
        $ci->session->set_flashdata('message', 'Komplain tidak ditemukan');
        redirect($urlIfError);
    }   
    $allowByDivisi = policy_unauthorized_komplain_byDivisi($komplain);
    if(!$allowByDivisi){  
        redirectWith($urlIfError,'Anda tidak mempunyai akses melihat data komplain ini');
    }
    if($strictmodeCreator){
        $allow =  middleware_author_komplain_strict($komplain);
        if(!$allow){
            redirectWith($urlIfError,'Anda tidak mempunyai akses melihat data komplain ini');
        }
    }
    if($strictmodeDivisiComplained){
        $allow =  policy_divisi_solver_komplain_strict($komplain);
        if(!$allow){
            redirectWith($urlIfError,'Anda tidak mempunyai akses untuk mengakses data komplain ini');
        }
    }
    if($strictModeSolverComplain){
        $allow =  policy_solver_komplain_strict($komplain);
        if(!$allow){
            redirectWith($urlIfError,'Anda tidak mempunyai akses untuk mengakses data komplain ini');
        }
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

function policy_unauthorized_komplain_byDivisi($komplain){
    $ci = &get_instance();  
 
    $kode_divisi_user = $ci->UsersModel->getLogin()->KODEDIV;
  

    //divisi yang boleh mengakses hanya 2, yaitu divisi pengirim dan penerima komplain

    $user_penerbit = $ci->UsersModel->get($komplain->USER_PENERBIT);
    $topik_penerima = $ci->TopikModel->get($komplain->TOPIK);

    $divisi_user_penerbit = $user_penerbit->KODEDIV;
    $divisi_user_penerima = $topik_penerima->DIV_TUJUAN;

    if($kode_divisi_user == $divisi_user_penerbit || $kode_divisi_user == $divisi_user_penerima){
        return true;
    }
    return false; 
    
}
function middleware_author_komplain_strict($komplain){
    $ci = &get_instance();  
    $nomor_induk = $ci->UsersModel->getLogin()->NOMOR_INDUK;  
    return ($komplain->USER_PENERBIT == $nomor_induk ); 
}
function policy_divisi_solver_komplain_strict($komplain){  
    $ci = &get_instance();  
    $kode_divisi_user = $ci->UsersModel->getLogin()->KODEDIV; 
    $topik_penerima = $ci->TopikModel->get($komplain->TOPIK);  

    return $kode_divisi_user == $topik_penerima->DIV_TUJUAN; 
}

/**
 * Middleware ini digunakan untuk diberikan pada hak akses penyelesaian komplain dari user yang diberi akses penugasan
 */
function policy_solver_komplain_strict($komplain){  
    $ci = &get_instance();  
    $nomor_induk = $ci->UsersModel->getLogin()->NOMOR_INDUK;  
    return ($komplain->PENUGASAN == $nomor_induk ); 
}
