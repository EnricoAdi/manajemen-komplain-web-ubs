<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat lihat detail complain penyelesaian
class Detail extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    public function index_get($iget,$nomor_komplain)
    {
        //untuk dapat list divisi
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        $user = $pass->data; 
         
        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        $penugasan = null;
        if($komplain->PENUGASAN!=null){
            $penugasan = $this->UsersModel->get($komplain->PENUGASAN);
        } 
         
        $penerbit = $this->UsersModel->get($komplain->USER_PENERBIT);
        $komplain->DATA_PENERBIT = $penerbit;
        $this->response([
            'data'=>$komplain,
            'penugasan'=> $penugasan, 
            'url'=> base_url(),
            'status'=>true
        ], REST_Controller::HTTP_OK);
    }
}
