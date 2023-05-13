<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat fetch solved list complain
class Solved extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    public function index_get()
    {
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code > 299) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        $user = $pass->data; 
        
        $complains = $this->KomplainAModel->fetchKomplainDone($user->NOMOR_INDUK,'all'); 
         
        $this->response([
            'data'=>$complains,
            'status'=>200
        ], REST_Controller::HTTP_OK);
    }
    public function index_post($ipost,$nomor_komplain){
        //SOLVE PROCESS
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

        $keputusan = $this->post('keputusan');
        $permintaanBanding = $this->post('keberatan');
        
        if($keputusan==''){
            $this->response([
                'message'=>'Harus memberikan keputusan',
                'status'=> 400  
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return; 
        }

        $today = date('Y-m-d'); 
        
        $resultmail = false;
        $resultmailRecepient = false;
 
        //isi apabila banding
        if($keputusan=='banding'){
            if($permintaanBanding==''){
                $this->response([
                    'message'=>'Permintaan banding harus diisi',
                    'status'=> 400  
                ], REST_Controller::HTTP_BAD_REQUEST); 
                return; 
            }
            $komplainB = new KomplainBModel(); 
            $komplainB->NO_KOMPLAIN = $nomor_komplain;
            $komplainB->KEBERATAN = $permintaanBanding;

            $komplainB->updateBandingKomplain();

            //update komplainA
            $komplain->TGL_BANDING = $today;
            $komplain->USER_BANDING = $user->NOMOR_INDUK;
            $komplain->updateBandingKomplain();
 
            $header = "Sukses melakukan banding penyelesaian komplain";
            $message = "Sistem telah mencatat anda melakukan banding atas komplain $nomor_komplain, dengan keluhan $permintaanBanding. Mohon ditunggu untuk tindakan lanjutan dari divisi bersangkutan. Terima kasih.";

            $template = templateEmail($header, $user->NAMA,
            $message);
   
            $resultmail = send_mail($user->EMAIL, 
            $header, $template);  
            
            $headerRecipient = "Sukses melakukan banding penyelesaian komplain";
            $messageRecipient = "Sistem telah mencatat anda mendapatkan banding atas komplain $nomor_komplain, dengan keluhan $permintaanBanding. Mohon menindaklanjuti permintaan divisi bersangkutan. Terima kasih.";

            $templateRecipient =  templateEmail($headerRecipient, $komplain->PENANGANAN->NAMAPENERBIT,
            $messageRecipient);

            $resultmailRecepient = send_mail($komplain->PENERBIT->EMAIL, 
            $headerRecipient, $templateRecipient); 

        }else if($keputusan=='cancel'){
            //update komplainA
            $komplain->TGL_CANCEL = $today;
            $komplain->USER_CANCEL = $user->NOMOR_INDUK;
            $komplain->updateCancelKomplain();

            
            $header = "Sukses membatalkan penyelesaian komplain";
            $message = "Sistem telah mencatat anda melakukan pembatalan (cancel) atas komplain $nomor_komplain, terima kasih.";
            $template = templateEmail($header, $user->NAMA,
            $message);
            
            $resultmail = send_mail($user->EMAIL, 
            $header, $template); 

            
            $headerRecipient = "Pembatalan penyelesaian komplain";
            $messageRecipient = "Sistem telah mencatat terdapat pembatalan penyelesaian komplain atas komplain dengan nomor $nomor_komplain.";

            $templateRecipient =  templateEmail($headerRecipient, $komplain->PENANGANAN->NAMAPENERBIT,
            $messageRecipient);

            $resultmailRecepient = send_mail($komplain->PENANGANAN->EMAIL, 
            $headerRecipient, $templateRecipient); 

        }else{
            //validasi
            //update komplainA
            $komplain->TGL_VALIDASI = $today;
            $komplain->USER_VALIDASI = $user->NOMOR_INDUK;
            $komplain->updateValidasiKomplain(); 
           
            $header = "Sukses memvalidasi penyelesaian komplain";
            $message = "Sistem telah mencatat anda telah melakukan validasi atas komplain $nomor_komplain, terima kasih atas kerja sama anda.";
            $template = templateEmail($header, $user->NAMA,
            $message);
   
            $resultmail = send_mail($user->EMAIL, 
            $header, $template); 

            
            $headerRecipient = "Validasi Penyelesaian Komplain";
            $messageRecipient = "Sistem telah mencatat terdapat validasi penyelesaian komplain atas komplain dengan nomor $nomor_komplain.";

            $templateRecipient =  templateEmail($headerRecipient, $komplain->PENANGANAN->NAMAPENERBIT,
            $messageRecipient);

            $resultmailRecepient = send_mail($komplain->PENANGANAN->EMAIL, 
            $headerRecipient, $templateRecipient); 
        }
        if($resultmail==true && $resultmailRecepient==true){  
            $this->response([
                'message'=>'Berhasil memberikan keputusan pada penyelesaian komplain, silahkan cek email anda',
                'status'=> 202  
            ], REST_Controller::HTTP_ACCEPTED); 
            return; 
        }else{ 
            $this->response([
                'message'=>'Berhasil memberikan keputusan pada penyelesaian komplain, namun gagal mengirim email',
                'status'=> 200
            ], REST_Controller::HTTP_OK); 
            return;  
        } 
    }
}
