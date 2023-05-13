<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat add complain pilih topik
class PilihTopik extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    public function index_get($iget,$divisiParam)
    {
        //untuk dapat list topik berdasarkan divisi yang dipilih
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code > 299) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }     
        $divisi =  $this->DivisiModel->get($divisiParam);  
        $allTopik = $this->TopikModel->fetchByDivisi($divisiParam);

        $this->response([
            'data'=>$allTopik,
            'divisi'=>$divisi,
            'status'=>true
        ], REST_Controller::HTTP_OK);
    }
}
