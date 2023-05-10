<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
   
class Success extends REST_Controller
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
        $komplain->USER_DONE = $user->NOMOR_INDUK;
        $komplain->TGL_DONE =  date('Y-m-d');
        $komplain->donePenyelesaianKomplain();

        $topik = $komplain->TOPIK;
        $subtopik1 = $komplain->SUB_TOPIK1;
        $subtopik2 = $komplain->SUB_TOPIK2;
        $header = "Berhasil done penyelesaian komplain";
        $s2des = $this->SubTopik2Model->get($topik, $subtopik1, $subtopik2)->DESKRIPSI;
        $template = templateEmail(
            $header,
            $user->NAMA,
            "Sistem mencatat anda menyelesaikan pemberian feedback terhadap komplain untuk subtopik $s2des . Terima kasih atas kerja sama anda"
        );
        $resultmail = send_mail(
            $user->EMAIL,
            $header,
            $template
        ); 
        if ($resultmail) {  
            $this->response([
                'message'=>'Berhasil done penyelesaian komplain, silahkan cek email anda',
                'status'=>200
            ], REST_Controller::HTTP_OK);
        } else { 
            $this->response([
                'message'=>'Berhasil done penyelesaian komplain, namun gagal mengirim email',
                'status'=>202
            ], REST_Controller::HTTP_ACCEPTED); 
        }
         
    }
}
