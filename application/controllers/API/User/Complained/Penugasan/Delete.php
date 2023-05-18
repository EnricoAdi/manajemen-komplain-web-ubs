<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat delete penugasan
class Delete extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    /**
     * Alamat endpoint untuk menghapus data penugasan pada komplain adalah api/user/complained/penugasan/delete/index_get/:nomor_komplain. Endpoint ini memiliki metode request GET. Endpoint ini digunakan untuk menghapus data user yang ditugaskan untuk menangani komplain berdasarkan parameter nomor komplain yang dikirim oleh user. Autentikasi juga dibutuhkan dengan mengirimkan parameter token autentikasi di bagian header request.
     */
    public function index_get($iget,$nomor_komplain)
    {
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }   
        
        $komplain = $this->KomplainAModel->get($nomor_komplain);  
        if($komplain==null){ 
            $this->response([
                'message'=>'Komplain tidak ditemukan',
                'status'=> 404  
            ], REST_Controller::HTTP_NOT_FOUND); 
            return;
        }
        $komplain->updateHapusPenugasanKomplain();

        $this->response([
            'message'=>"Berhasil Menghapus Penugasan",
            'status'=>200
        ], REST_Controller::HTTP_OK);
    }
     
}
