<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

class Tes extends REST_Controller
{

    public function __construct()
    {
        parent::__construct(); 
    } 

    public function index_get()
    {
        $secretKey = configToken()['secretkey'];
        
        $authHeader = $this->input->request_headers()['Authorization'];  
        $arr = explode(" ", $authHeader); 
        $token = $arr[1]; 
        $decoded = JWT::decode($token,new Key($secretKey, 'HS256'));
        $data = $decoded->data;

        $nomor_induk = $data->nomor_induk;
        $password = $data->password; 

        
        $userFound = $this->UsersModel->get($nomor_induk);
        if ($userFound == null) { 
            $this->response([
                'status' => false,
                'message' => "Nomor Induk tidak ditemukan"
            ], REST_Controller::HTTP_UNAUTHORIZED);

        } else {
            $passCheck = password_verify($password, $userFound->PASSWORD);
           
            if ($passCheck) { 
                $this->response([
                    'status' => true,
                    'message' => 'Verifikasi Berhasil' 
                ], 200);
            }else{ 
                $this->response([
                    'status' => false,
                    'message' => "Verifikasi Gagal"
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    }

}