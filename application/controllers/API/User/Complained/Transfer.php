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
        if ($pass->code > 299) {
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
         
        $subtopics = $this->SubTopik2Model->fetchOrder(); 
        $subtopik2 = $komplain->SUB_TOPIK2;
 
        $this->response([
            'message'=>'Fetch data berhasil',
            'data' => [
                'komplain' => $komplain,
                'subtopics' => $subtopics,
                'subtopik2' => $subtopik2
            ],
            'status'=> 202  
        ], REST_Controller::HTTP_ACCEPTED); 
        return;
    }
    
    /**
     * Alamat endpoint yang digunakan untuk melakukan transfer pada komplain adalah api/user/complained/transfer/index_post/:nomor_komplain. Endpoint ini memiliki metode request POST. Endpoint ini digunakan untuk melakukan transfer komplain berdasarkan parameter nomor komplain yang dikirim oleh user. Karena tujuan dari transfer adalah mengalihkan komplain ke data topik lain, sehingga dibutuhkan parameter topik, subtopik 1, dan subtopik 2. Autentikasi juga dibutuhkan dengan mengirimkan parameter token autentikasi di bagian header request. 
     */
    public function index_post($ipost,$nomor_komplain)
    {
        try { 
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
          //process transfer komplain
          $topik = $this->post('inputTopik');
          $subTopik1 = $this->post('inputSubtopik1');
          $subTopik2 = $this->post('inputSubtopik2'); 

          $komplain->TOPIK = $topik;
          $komplain->SUB_TOPIK1 = $subTopik1;
          $komplain->SUB_TOPIK2 = $subTopik2;
          $komplain->updateTransferKomplain(); 
          
            //langsung auto verifikasi
            //dapatkan divisi tujuan
            $kodeDivisi = $this->TopikModel->get($topik)->DIV_TUJUAN;
            
            //dapatkan random
            $users = $this->UsersModel->fetchUsersByDivisi($kodeDivisi,'1');

            $userRandom = $users[rand(0, count($users)-1)]; 
            
            $komplain->USER_VERIFIKASI = $userRandom->NOMOR_INDUK; 
            $komplain->TGL_VERIFIKASI = date('Y-m-d');
            $komplain->updateVerifikasi();

          $header = "Sukses melakukan transfer komplain";
          $message = "Sistem telah mencatat anda melakukan transfer atas komplain $nomor_komplain, terima kasih.";

          $template = templateEmail($header, $user->NAMA,
          $message);
          
          $resultmail = send_mail($user->EMAIL, 
          $header, $template); 
          if($resultmail==false){ 
              $this->response([
                  'message'=>'Berhasil transfer komplain, namun gagal mengirim email', 
                  'status'=> 202  
              ], REST_Controller::HTTP_ACCEPTED); 
              return;
          }else{  
              $this->response([
                  'message'=>'Berhasil transfer komplain, silahkan cek email', 
                  'status'=> 201
              ], REST_Controller::HTTP_CREATED); 
          } 
        } catch (Exception) { 
            $this->response([
                'message'=>'Terdapat kesalahan', 
                'status'=> 500
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR); 
        }

    }
}
