<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat lihat detail complain 
class Index extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

    public function index_get($iget,$nomor_komplain)
    { 
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
        $penugasan = null;
        if($komplain->PENUGASAN!=null){
            $penugasan = $this->UsersModel->get($komplain->PENUGASAN);
        } 
        $this->response([
            'data'=>$komplain,
            'penugasan'=> $penugasan,
            'url'=> base_url(),
            'status'=>200
        ], REST_Controller::HTTP_OK);
    }
    public function index_post($ipost,$nomor_komplain){
        //update komplain
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
        $tanggal =  $this->post("tanggal");

        $tanggalMin = date('Y-m-d', strtotime('-14 days'));
        if($tanggal < $tanggalMin){ 
            $this->response([
                'message'=>'Tanggal tidak boleh lebih dari 14 hari', 
                'status'=>400
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return;
        }

        
        $deskripsi = $this->post("deskripsi"); 
        if($deskripsi=="" || $deskripsi==null){
            $this->response([
                'message'=>'Deskripsi harus diisi', 
                'status'=>400
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return;
        }
        
        $today = date('Y-m-d');  
          
        $komplain->TGL_KEJADIAN = $tanggal;
         
        $komplain->updateKomplain();  
         
        //update komplainB
        
        $komplainB = $this->KomplainBModel->get($nomor_komplain); 
        $komplainB->DESKRIPSI_MASALAH = $deskripsi;
        $komplainB->updateKomplain(); 
        
        $isError = false;
        
        if ($_FILES != null) {
            $lampirans = $_FILES["lampiran"];
            if($lampirans['name'][0]!=""){ 
                if (!file_exists('./uploads/')) {
                    mkdir('./uploads/', 0777, true);
                } 
                for($i=0;$i < count($lampirans['name']);$i++){ 
                    $getNewFileName = 'K_MOB'. generateUID(19).  substr($nomor_komplain,-3,3);
                    
                    if($i < count($lampirans)){ 
                        $_FILES['lampiran']['name'] = $lampirans['name'][$i];
                        $_FILES['lampiran']['type'] = $lampirans['type'][$i];
                        $_FILES['lampiran']['tmp_name'] = $lampirans['tmp_name'][$i];
                        $_FILES['lampiran']['error'] = $lampirans['error'][$i];
                        $_FILES['lampiran']['size'] = $lampirans['size'][$i];

                        $ext = pathinfo($lampirans['name'][$i], PATHINFO_EXTENSION);

                        $config['upload_path'] = './uploads/';
                        $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|txt';
                        $config['max_size'] = 5000; // in Kilobytes
                        $config['file_name'] = $getNewFileName;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if (!$this->upload->do_upload('lampiran')) {
                            // Handle upload error
                            $error = $this->upload->display_errors();
                            // echo $error;
                            // echo FCPATH.'uploads/';
                            $isError = true;
                        } else {
                            // Upload success
                            $upload_data = $this->upload->data();
                            $file_name = $upload_data['file_name']; 
                            $newLampiran = new LampiranModel();
                            $newLampiran->KODE_LAMPIRAN = $getNewFileName.".".$ext;
                            $newLampiran->NO_KOMPLAIN = $nomor_komplain;
                            $newLampiran->TANGGAL = $today;
                            $newLampiran->TIPE = 0; //komplain
                            $newLampiran->insert();
                        }
                    }
            } 
        }  
    }
        if($isError){ 
            redirectWith('User/Complain/Detail/edit_page/'.$nomor_komplain,'Terdapat error dalam upload lampiran'); 
            $this->response([
                'message'=>'Terdapat error dalam upload lampiran', 
                'status'=>400
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return;
        }else{  
            $this->response([
                'message'=>'Berhasil mengubah data komplain', 
                'status'=>202
            ], REST_Controller::HTTP_ACCEPTED); 
            return; 
        }
    }
}
