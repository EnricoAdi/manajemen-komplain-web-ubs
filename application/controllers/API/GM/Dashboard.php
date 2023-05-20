<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat dashboard data
class Dashboard extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }
 
    public function index_get()
    {
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code  > 299) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        $user = $pass->data; 

        $divisi = $user->KODEDIV;
        $komplainUrgent = $this->KomplainAModel->loadGManagerKomplainUrgent(); 
        $komplainTerkirim = $this->KomplainAModel->loadGManagerKomplainTerkirim();
        $komplainDiterima = $this->KomplainAModel->loadGManagerKomplainDiterima();

        if($komplainUrgent==null){
            $komplainUrgent = "Belum ada";
        }else if($komplainTerkirim==null)
        {
            $komplainTerkirim = "Belum ada";
        }else if($komplainDiterima==null)
        {
            $komplainDiterima = "Belum ada";
        }
     
    
        $data = new stdClass();
        
        $data->divisi = $divisi;
        $data->komplainUrgent = $komplainUrgent;
        $data->komplainTerkirim = $komplainTerkirim;
        $data->komplainDiterima = $komplainDiterima; 
         
        $this->response([
            'data'=>$data,
            'status'=>200
        ], REST_Controller::HTTP_OK);
    }
}
