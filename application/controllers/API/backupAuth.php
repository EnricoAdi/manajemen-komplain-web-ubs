<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }


    public function index_get()
    {
        // $this->output->set_status_header(200);
        // $this->output->setcontent_type('application/json', 'utf-8')
        // ->set_output(json_encode("hello"));
        // $this->response([
        //     'status' => true,
        //     'message' => 'Unauthorized',
        //     'data' =>  'helloa'
        // ], REST_Controller::HTTP_OK);
        return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'text' => 'Error 500',
                    'type' => 'danger'
                ]));
    }
    public function index_post()
    {
        $nomor_induk = $this->input->post('nomor_induk');
        $password = $this->input->post('password');

        $exp = time() + 3600;
        $userFound = $this->UsersModel->get($nomor_induk);
        if ($userFound == null) { 
            return json_encode(var_dump($this->input->post())); 
            // $this->response([
            //     'status' => false,
            //     'message' => 'Nomor Induk tidak ditemukan'
            // ], REST_Controller::HTTP_NOT_FOUND);
            // return $this->output
            // ->set_content_type('application/json')
            // ->set_status_header(200)
            // ->set_output(json_encode([
            //     'status' => false,
            //     'message' => "Nomor Induk tidak ditemukan $nomor_induk " 
            // ]));
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

                $jwt = JWT::encode(
                    $token,
                    configToken()['secretkey'],
                    'HS256'
                );

                // $this->response([
                //     'status' => true,
                //     'message' => 'Login Berhasil',
                //     'token' => $jwt,
                //     'exp' => $exp
                // ], 200);
                return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'token' => $jwt,
                     'exp' => $exp 
                ]));
            } else {
                // $this->response([
                //     'status' => false,
                //     'message' => 'Login Gagal'
                // ], REST_Controller::HTTP_UNAUTHORIZED);
                return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Login gagal' 
                ]));
            }
        }
    }
}
