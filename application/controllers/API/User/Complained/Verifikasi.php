<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat verifikasi complain 
class Verifikasi extends REST_Controller
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
                'status'=> 404  
            ], REST_Controller::HTTP_NOT_FOUND); 
            return;
        }
        $user_penerbit = $this->UsersModel->get($komplain->USER_PENERBIT);
        $divisi = $user_penerbit->NAMA_DIVISI;

        $komplain->USER_VERIFIKASI = $user->NOMOR_INDUK;
        $komplain->TGL_VERIFIKASI = date('Y-m-d');
        $komplain->updateVerifikasi();


        $message = "Sistem mencatat anda telah memverifikasi komplain dari divisi $divisi terkait $komplain->DESKRIPSI_MASALAH. Silahkan melengkapi penugasan untuk penyelesaian komplain ini";

        $template = templateEmail("Notifikasi Berhasil Verifikasi Komplain", $this->UsersModel->getLogin()->NAMA, $message);

        $resultmail = send_mail(
        $this->UsersModel->getLogin()->EMAIL,
        'Notifikasi Berhasil Verifikasi Komplain',
        $template
        );

        if ($resultmail) {
            $this->response([
                'status'=>200,
                'message'=> 'Berhasil Verifikasi komplain, silakan cek email anda', 
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status'=>202,
                'message'=> 'Berhasil Verifikasi komplain, namun gagal mengirim email',  
            ], REST_Controller::HTTP_ACCEPTED);  
        } 
    }
}
