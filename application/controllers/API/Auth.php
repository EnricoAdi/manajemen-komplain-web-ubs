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
        $this->load->model('UsersModel');
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
                  
        $exp = time() + 3600;
        $userFound = $this->UsersModel->get($nomor_induk); 
        if ($userFound == null) {

            $this->response([
                'status' => false,
                'message' => 'Nomor Induk tidak ditemukan' 
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            if (password_verify($password, $userFound->PASSWORD)) {
                $this->UsersModel->login($userFound); 

                $token = array(
                    "iss" => 'apprestservice',
                    "aud" => 'pengguna',
                    "iat" => time(),
                    "nbf" => time() + 10,
                    "exp" => $exp,
                    "data" => array(
                        "nomor_induk" => $this->input->post('nomor_induk'),
                        "password" => $this->input->post('password')
                    )
                );       
            
            $jwt = JWT::encode($token,
             configToken()['secretkey'], 'HS256');

                $this->response([
                    'status' => true,
                    'message' => 'Login Berhasil', 
                    'token' => $jwt,
                    'exp' => $exp
                ], REST_Controller::HTTP_OK);

            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Login Gagal' 
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }
}
