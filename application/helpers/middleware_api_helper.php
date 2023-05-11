<?php 

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

function verifyJWT($authHeader){
    $ci = &get_instance();  
    $secretKey = configToken()['secretkey']; 
    $arr = explode(" ", $authHeader); 
    $token = $arr[1]; 
    try { 
        $decoded = JWT::decode($token,new Key($secretKey, 'HS256'));
        $data = $decoded->data;

        $nomor_induk = $data->nomor_induk;
        $password = $data->password; 

        $userFound = $ci->UsersModel->get($nomor_induk);
        if ($userFound == null) {  
            $res = new stdClass();
            $res->status = 404;
            $res->code = 404; 
            $res->message = 'Nomor Induk tidak ditemukan';
            return $res;

        } else {
            // $passCheck = password_verify($password, $userFound->PASSWORD);
            $passCheck = $password == $userFound->PASSWORD; 
            if ($passCheck) { 
                $res = new stdClass();
                $res->status = 200;
                $res->code = 200; 
                $res->data= $userFound;
                $res->message = 'Verifikasi Berhasil';
                return $res; 
            }else{ 
                $res = new stdClass();
                $res->status = 401;
                $res->code = 401; 
                $res->message = 'Verifikasi Gagal';
                return $res; 
            }
        } 
    } catch (\Throwable $th) { 
        $res = new stdClass();
        $res->status = 401;
        $res->code = 401; 
        $res->message = 'Verifikasi Gagal';
        return $res;    
    }
}

function middleware_api_auth($hak_akses_target, $user){ 

    //code ini digunakan untuk menjadi sebuah midlleware api jika user mencoba akses endpoint tanpa verifikasi
     if($user == null){   
        $res = new stdClass();
        $res->status = 404;
        $res->code = 404;  
        $res->message = 'User Not found';
        return $res; 
    }

    //jika tidak ada akses, maka user tidak bisa mengakses endpoint
    $hak_akses = $user->KODE_HAK_AKSES;

    if($hak_akses_target!=$hak_akses){
        $res = new stdClass();
        $res->status = 401;
        $res->code = 401;  
        $res->message = 'Unauthorized';
        return $res;
    }
}
function middleware_api_topik($kode_topik){
    $ci = &get_instance();  

    $topik = $ci->TopikModel->get($kode_topik); 
    if($topik==null){ 
        $res = new stdClass();
        $res->status = 404;
        $res->code = 404;  
        $res->message = 'Topic tidak ditemukan';
        return $res;
    }   
}
function middleware_api_komplainA($nomor_komplain,$user,$strictmodeCreator=false,$strictmodeDivisiComplained=false,$strictModeSolverComplain=false){
    $ci = &get_instance();  

    $komplain = $ci->KomplainAModel->get($nomor_komplain); 
    
    if($komplain==null){ 
        $res = new stdClass();
        $res->status = 404;
        $res->code = 404;  
        $res->message = 'Komplain tidak ditemukan';
        return $res;
    }   
    $allowByDivisi = policy_api_unauthorized_komplain_byDivisi($komplain,$user);
    if(!$allowByDivisi){  
        
        $res = new stdClass();
        $res->status = 401;
        $res->code = 401;  
        $res->message = 'Anda tidak mempunyai akses melihat data komplain ini';
        return $res; 
    }
    if($strictmodeCreator){
        $allow =  policy_api_author_komplain_strict($komplain,$user);
        if(!$allow){ 
            $res = new stdClass();
            $res->status = 401;
            $res->code = 401;  
            $res->message = 'Anda tidak mempunyai akses untuk mengakses data komplain ini';
            return $res;   
        }
    }
    if($strictmodeDivisiComplained){
        $allow =  policy_api_divisi_solver_komplain_strict($komplain,$user);
        if(!$allow){ 
            $res = new stdClass();
            $res->status = 401;
            $res->code = 401;  
            $res->message = 'Anda tidak mempunyai akses untuk mengakses data komplain ini';
            return $res;
        }
    }
    if($strictModeSolverComplain){
        $allow =  policy_api_solver_komplain_strict($komplain,$user);
        if(!$allow){ 
            $res = new stdClass();
            $res->status = 401;
            $res->code = 401;  
            $res->message = 'Anda tidak mempunyai akses untuk mengakses data komplain ini';
            return $res;
        }
    }

    $res = new stdClass();
    $res->status = 200;
    $res->code = 200;  
    $res->message = 'Komplain bisa diakses';
    return $res;
}
function middleware_api_komplainB($nomor_komplain){
    $ci = &get_instance();  

    $komplain = $ci->KomplainBModel->get($nomor_komplain); 
    
    if($komplain==null){ 
        $res = new stdClass();
        $res->status = 404;
        $res->code = 404;  
        $res->message = 'Komplain tidak ditemukan';
        return $res;
    }   
    $res = new stdClass();
    $res->status = 200;
    $res->code = 200;  
    $res->message = 'Komplain ditemukan';
    return $res;
}

function middleware_api_lampiran_komplain($nomor_komplain,$kode_lampiran){
    $ci = &get_instance();  

    $lampiran = $ci->LampiranModel->get($kode_lampiran); 
    
    if($lampiran==null || $lampiran->NO_KOMPLAIN!=$nomor_komplain){ 
        $res = new stdClass();
        $res->status = 404;
        $res->code = 404;  
        $res->message = 'Lampiran tidak ditemukan';
        return $res;
    }   
    $res = new stdClass();
    $res->status = 200;
    $res->code = 200;  
    $res->message = 'Lampiran ditemukan';
    return $res;
}

function policy_api_unauthorized_komplain_byDivisi($komplain,$user){
    $ci = &get_instance();  
 
    $kode_divisi_user = $user->KODEDIV; 

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
function policy_api_author_komplain_strict($komplain,$user){ 
    $nomor_induk = $user->NOMOR_INDUK;  
    return ($komplain->USER_PENERBIT == $nomor_induk); 
}
function policy_api_divisi_solver_komplain_strict($komplain,$user){  
    $ci = &get_instance();  
    $kode_divisi_user = $user->KODEDIV; 
    $topik_penerima = $ci->TopikModel->get($komplain->TOPIK);  

    return $kode_divisi_user == $topik_penerima->DIV_TUJUAN; 
}

/**
 * Middleware ini digunakan pada api untuk diberikan pada hak akses penyelesaian komplain dari user yang diberi akses penugasan
 */
function policy_api_solver_komplain_strict($komplain,$user){   
    return ($komplain->PENUGASAN == $user->NOMOR_INDUK ); 
}