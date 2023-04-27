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
            $res->status = false;
            $res->code = 404; 
            $res->message = 'Nomor Induk tidak ditemukan';
            return $res;

        } else {
            // $passCheck = password_verify($password, $userFound->PASSWORD);
            $passCheck = $password == $userFound->PASSWORD; 
            if ($passCheck) { 
                $res = new stdClass();
                $res->status = true;
                $res->code = 200; 
                $res->data= $userFound;
                $res->message = 'Verifikasi Berhasil';
                return $res; 
            }else{ 
                $res = new stdClass();
                $res->status = false;
                $res->code = 401; 
                $res->message = 'Verifikasi Gagal';
                return $res; 
            }
        } 
    } catch (\Throwable $th) { 
        $res = new stdClass();
        $res->status = false;
        $res->code = 401; 
        $res->message = 'Verifikasi Gagal';
        return $res;    
    }
}

function middleware_api_auth($hak_akses_target, $user){
    $ci = &get_instance();  

    //code ini digunakan untuk menjadi sebuah midlleware api jika user mencoba akses endpoint tanpa verifikasi
     if($user == null){   
        $res = new stdClass();
        $res->status = false;
        $res->code = 404;  
        $res->message = 'User Not found';
        return $res; 
    }

    //jika tidak ada akses, maka user tidak bisa mengakses endpoint
    $hak_akses = $user->KODE_HAK_AKSES;

    if($hak_akses_target!=$hak_akses){
        $res = new stdClass();
        $res->status = false;
        $res->code = 401;  
        $res->message = 'Unauthorized';
        return $res;
    }
}