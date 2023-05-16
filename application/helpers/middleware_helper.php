<?php
/**
 * Middleware authentication adalah function yang digunakan untuk melakukan pengecekkan apakah user yang akan mengakses sebuah halaman memiliki otorisasi dan autentikasi ke dalam sistem. Function ini dipasangkan di semua controller kecuali controller login. Terdapat dua buah pengecekkan di middleware ini, yaitu jika user belum login mencoba untuk mengakses halaman, maka user akan dikembalikan ke halaman login, dan jika user sudah login namun hak akses yang dimiliki tidak sesuai dengan hak akses halaman yang dicoba untuk dituju, maka user akan diarahkan ke halaman sesuai hak aksesnya.
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
            redirect('GM/Dashboard'); //GM
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
 * Function middleware komplain adalah sebuah function yang digunakan untuk melakukan pengecekkan apakah sebuah user boleh mengakses data komplain yang ingin dituju, dengan pengecekkan dikombinasikan dengan policy sesuai kebutuhan hak akses pada sebuah halaman. Terdapat 5 parameter yang dibutuhkan oleh function ini, yaitu nomor komplain, url yang akan dituju jika pengecekkan gagal, variabel boolean yang memberitahu apakah sebuah halaman menggunakan policy pembuat komplain, atau policy divisi yang dikomplain, atau policy user yang menyelesaikan komplain.
 * 
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

/**
 * Function policy unauthorized akses komplain berdasarkan divisi adalah sebuah function yang digunakan untuk melakukan pengecekkan apakah sebuah user boleh mengakses data komplain yang ingin dituju berdasarkan divisi user tersebut. Secara umum, sebuah komplain hanya boleh diakses dua divisi saja, yaitu divisi user yang memberikan komplain, dan divisi yang menerima komplain.
 */
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

/**
 * Function policy pembuat komplain adalah sebuah function yang digunakan untuk melakukan pengecekkan apakah sebuah user boleh mengakses data komplain yang ingin dituju, dengan pengecekkan apakah user tersebut merupakan user yang membuat komplain tersebut atau tidak. 
 */
function middleware_author_komplain_strict($komplain){
    $ci = &get_instance();  
    $nomor_induk = $ci->UsersModel->getLogin()->NOMOR_INDUK;  
    return ($komplain->USER_PENERBIT == $nomor_induk ); 
}

/**
 * Function policy divisi penerima komplain adalah sebuah function yang digunakan untuk melakukan pengecekkan apakah sebuah user boleh mengakses data komplain yang ingin dituju, dengan pengecekkan apakah user tersebut termasuk divisi yang dikomplain atau tidak.  */
function policy_divisi_solver_komplain_strict($komplain){  
    $ci = &get_instance();  
    $kode_divisi_user = $ci->UsersModel->getLogin()->KODEDIV; 
    $topik_penerima = $ci->TopikModel->get($komplain->TOPIK);  

    return $kode_divisi_user == $topik_penerima->DIV_TUJUAN; 
}

/**
 * Function policy user penugasan komplain adalah sebuah function yang digunakan untuk melakukan pengecekkan apakah sebuah user boleh mengakses data komplain yang ingin dituju, dengan pengecekkan apakah user tersebut merupakan user yang ditugaskan untuk menyelesaikan komplain atau bukan (berdasarkan akses penugasan dari sebuah komplain). 
 */
function policy_solver_komplain_strict($komplain){  
    $ci = &get_instance();  
    $nomor_induk = $ci->UsersModel->getLogin()->NOMOR_INDUK;  
    return ($komplain->PENUGASAN == $nomor_induk ); 
}
