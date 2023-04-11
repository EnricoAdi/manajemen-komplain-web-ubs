<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); 
    } 

    public function index_get()
    {
        $this->response([
            'status' => true,
            'message' => 'Unauthorized',
            'data' =>  'hello'
        ], REST_Controller::HTTP_OK);
    }
    public function index_post()
    {
        $nomor_induk = $this->post('nomor_induk');
        $password = $this->post('password');

        $exp = time() + 36000;
        // $userFound = $this->UsersModel->get($nomor_induk);
        $userFound = cekLogin($nomor_induk, $password);
        if ($userFound->code == 404) { 
            $this->response([
                'status' => false,
                'message' => 'Nomor Induk tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        } else { 
            if ($userFound->code == 200) {
                // $this->UsersModel->login($userFound);

                $token = array(
                    "iss" => 'apprestservice',
                    "aud" => 'pengguna', 
                    "iat" => time(),
                    "nbf" => time() + 10,
                    "exp" => $exp,
                    "data" => array(
                        "nomor_induk" => $nomor_induk,
                        "password" => $password
                    )
                );

                $jwt = JWT::encode(
                    $token,
                    configToken()['secretkey'],
                    'HS256'
                );

                $this->response([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'hak_akses'=> $userFound->data->KODE_HAK_AKSES,
                    'divisi'=> $userFound->data->NAMA_DIVISI,
                    'nama'=> $userFound->data->NAMA,
                    'nomor_induk'=> $userFound->data->NOMOR_INDUK,
                    'token' => $jwt,
                    'exp' => $exp
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Login Gagal'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }
}
