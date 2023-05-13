<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat delete complain 
class Delete extends REST_Controller
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
        if ($pass->code > 299) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        $user = $pass->data; 
         
        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        if($komplain==null){ 
            $this->response([
                'message'=>'Komplain tidak ditemukan',
                'data'=>'-1',
                'status'=>404  
            ], REST_Controller::HTTP_NOT_FOUND); 
            return;
        }
        $complainA = new KomplainAModel();

        $complainA->NO_KOMPLAIN = $nomor_komplain;

        $komplain = $this->KomplainAModel->get($nomor_komplain);
        $topik = $komplain->TOPIK; 
        $subtopik1 = $komplain->SUB_TOPIK1;
        $subtopik2 = $komplain->SUB_TOPIK2;   

        $s1 = $this->SubTopik1Model->get($topik,$subtopik1)->DESKRIPSI;
        $s2 = $this->SubTopik2Model->get($topik,$subtopik1,$subtopik2)->DESKRIPSI;

        $message = "Sistem mencatat anda telah menghapus sebuah komplain terkait $s1 - $s2";
        $template = templateEmail("Notifikasi Berhasil Hapus Komplain",$user->NAMA,$message);
        $resultmail = send_mail($user->EMAIL, 
        'Notifikasi Penghapusan Komplain', $template); 

        if($resultmail){ 
            $lampiran = new LampiranModel();
            $lampiran->NO_KOMPLAIN = $nomor_komplain;
            $lampiran->deleteByKomplain($nomor_komplain);
            
            $complainB = new KomplainBModel();
            $complainB->NO_KOMPLAIN = $nomor_komplain;
            $complainB->delete();

            $complainA->delete();

            $this->response([
                'message'=>'Komplain berhasil dihapus, silahkan cek email anda',
                'data'=>'1' 
            ], REST_Controller::HTTP_OK); 
        }else{  
            $this->response([
                'message'=>'Komplain berhasil dihapus, namun email tidak terkirim',
                'data'=>'0' 
            ], REST_Controller::HTTP_ACCEPTED);  
        }
    }
}
