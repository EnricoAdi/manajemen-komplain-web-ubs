<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat add penugasan
class Add extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    public function index_get($iget,$nomor_komplain)
    {
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
        //fetch list user sedivisi 
        $users = $this->UsersModel->fetchUsersByDivisi($user->KODEDIV,'1');
        $this->response([
            'data'=>[
                "komplain" => $komplain,
                "users" => $users, 
            ],
            'status'=>200
        ], REST_Controller::HTTP_OK);
    }
    /**
     * Alamat endpoint untuk menambah penugasan pada komplain adalah api/user/complained/penugasan/add/index_post/:nomor_komplain. Endpoint ini memiliki metode request POST. Endpoint ini digunakan untuk mengisi data user yang ditugaskan untuk menangani komplain berdasarkan parameter nomor komplain yang dikirim oleh user. Karena tujuan dari penugasan adalah menyimpan data user yang bertanggung jawab, sehingga dibutuhkan parameter nomor induk user dalam request body. Autentikasi juga dibutuhkan dengan mengirimkan parameter token autentikasi di bagian header request
     */
    public function index_post($ipost,$nomor_komplain)
    {
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
        $userUpd =  $this->post("user");
        if($userUpd==null){ 
            $this->response([
                'message'=>"Input harus lengkap",
                'status'=>400
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        $komplain->PENUGASAN = $userUpd;
        $komplain->updatePenugasanKomplain();

        $this->response([
            'message'=>"Berhasil Menyimpan Penugasan",
            'status'=>200
        ], REST_Controller::HTTP_OK);
    }
}
