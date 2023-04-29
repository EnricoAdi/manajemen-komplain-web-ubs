<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat add complain pilih divisi
class PilihDivisi extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    public function index_get()
    {
        //untuk dapat list divisi
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        // $user = $pass->data; 
         
        $allDivisi = $this->DivisiModel->fetch();
        $this->response([
            'data'=>$allDivisi,
            'status'=>true
        ], REST_Controller::HTTP_OK);
    }
}
