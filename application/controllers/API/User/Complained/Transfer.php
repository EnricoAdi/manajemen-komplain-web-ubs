<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat transfer complain 
class Transfer extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    public function index_get($iget,$nomor_komplain)
    {
        //untuk dapat data
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        $user = $pass->data; 
         
        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        if($komplain==null){ 
            $this->response([
                'message'=>'Komplain tidak ditemukan',
                'status'=> 404  
            ], REST_Controller::HTTP_NOT_FOUND); 
            return;
        }
         
        $subtopics = $this->SubTopik2Model->fetch(); 
        $subtopik2 = $komplain->SUB_TOPIK2;
    }
    
    public function index_post($ipost,$nomor_komplain)
    {
        //untuk transfer komplain
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        $user = $pass->data; 
         
        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        if($komplain==null){ 
            $this->response([
                'message'=>'Komplain tidak ditemukan',
                'status'=> 404  
            ], REST_Controller::HTTP_NOT_FOUND); 
            return;
        }
         

    }
}
