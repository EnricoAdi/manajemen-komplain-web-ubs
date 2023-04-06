<?php   
 function cekLogin($nomor_induk,$password){
    $ci = &get_instance();
    $userFound = $ci->UsersModel->get($nomor_induk); 
    if ($userFound == null) {  
        $res = new stdClass();
        $res->code = 404;
        $res->message = 'User tidak ditemukan';
        $res->data= null;
        return $res;
    }
    if ($password == $userFound->PASSWORD) {  
        $res = new stdClass();
        $res->code = 200;
        $res->message = 'Berhasil Login';
        $res->data= $userFound;
        return $res;
    }  
    $res = new stdClass();
    $res->code = 403; 
    $res->message = 'Password tidak sesuai';
    $res->data= $userFound;
    return $res;
 }