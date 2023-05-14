<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat add complain pilih subtopik1
class PilihSubTopik1 extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    public function index_get($iget,$divisiParam, $topikParam)
    {
        //untuk dapat list divisi
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code > 299) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        // $user = $pass->data;  
         
         
        $divisi =  $this->DivisiModel->get($divisiParam);     
        $topik =  $this->TopikModel->get($topikParam);  
        $allSubTopik1 = $this->SubTopik1Model->fetchByTopik($topikParam); 
        
        $this->response([
            'data'=>$allSubTopik1,
            'divisi'=>$divisi,
            'topik'=>$topik,
            'status'=>200
        ], REST_Controller::HTTP_OK);

    }
}
