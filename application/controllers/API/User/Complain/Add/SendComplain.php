<?php
 

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
  
class SendComplain extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
        $this->load->library('upload');
    }

    public function index_post($ipost,$divisiParam, $topikParam, $subTopik1Param, $subTopik2Param, $tanggalParam)
    {
        //untuk dapat list divisi
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }    
        $user = $pass->data; 

        $divisi =  $this->DivisiModel->get($divisiParam);     
        $topik =  $this->TopikModel->get($topikParam);   
        $subtopik1 =  $this->SubTopik1Model->get($topikParam,$subTopik1Param); 
        $subtopik2 = $this->SubTopik2Model->get($topikParam,$subTopik1Param,$subTopik2Param);
        
        
        $deskripsi = $this->post('deskripsi');
        $this->response([  
            'message' => $this->post() ,
            'message2' => $_POST ,
            'status'=>true
        ], REST_Controller::HTTP_OK);
        return;
        $lampirans = $_FILES['lampiran']; 
        if($deskripsi==""){ 
            $this->response([  
                'message' => "Input harus lengkap" ,
                'status'=>false
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        //payload lampiran harus berupa lampiran[]
        $newkode = $this->KomplainAModel->getNewKode(); 
        $today = date('Y-m-d'); 

        $newkomplain = new KomplainAModel();
        $newkomplain->NO_KOMPLAIN = $newkode;
        $newkomplain->TOPIK = $topikParam;
        $newkomplain->SUB_TOPIK1 = $subTopik1Param;
        $newkomplain->SUB_TOPIK2 = $subTopik2Param; 
        $newkomplain->TGL_KEJADIAN = $tanggalParam;
        

        $newkomplain->TGL_TERBIT = $today;
        $newkomplain->TGL_VERIFIKASI = null;
        $newkomplain->USER_VERIFIKASI = null;
        $newkomplain->TGL_CANCEL = null;
        $newkomplain->USER_CANCEL = null;
        $newkomplain->TGL_BANDING = null;
        $newkomplain->USER_BANDING = null;
        $newkomplain->TGL_VALIDASI = null;
        $newkomplain->USER_VALIDASI = null;
        $newkomplain->PENUGASAN = null;
        $newkomplain->STATUS = 'OPEN';
        $newkomplain->TGL_PENANGANAN = null;
        $newkomplain->USER_PENANGANAN = null;
        $newkomplain->USER_PENANGANAN = null;
        $newkomplain->TGL_DEADLINE = null;
        $newkomplain->TGL_DONE = null;
        $newkomplain->USER_DONE = null;
        $newkomplain->USER_PENERBIT = $user->NOMOR_INDUK;

        $newkomplain->insert();  

        //insert komplainb
        $newkomplainb = new KomplainBModel();
        $newkomplainb->NO_KOMPLAIN = $newkode;
        $newkomplainb->DESKRIPSI_MASALAH = $deskripsi;
        $newkomplainb->AKAR_MASALAH = '';
        $newkomplainb->T_KOREKTIF = '';
        $newkomplainb->T_PREVENTIF = '';
        $newkomplainb->KEBERATAN = ''; 
        $newkomplainb->insert();

        $isError = false;
        if($lampirans['name'][0]!=""){ 
            if (!file_exists('./uploads/')) {
                mkdir('./uploads/', 0777, true);
            } 
            for($i=0;$i < count($lampirans['name']);$i++){
                $getNewFileName = 'K_MOB'. generateUID(19).  substr($newkode,-3,3);
                
                if($i < count($lampirans)){ 
                    $_FILES['lampiran']['name'] = $lampirans['name'][$i];
                    $_FILES['lampiran']['type'] = $lampirans['type'][$i];
                    $_FILES['lampiran']['tmp_name'] = $lampirans['tmp_name'][$i];
                    $_FILES['lampiran']['error'] = $lampirans['error'][$i];
                    $_FILES['lampiran']['size'] = $lampirans['size'][$i];

                    $ext = pathinfo($lampirans['name'][$i], PATHINFO_EXTENSION);

                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|txt|docx|xlsx|csv';
                    $config['max_size'] = 5000; // in Kilobytes
                    $config['file_name'] = $getNewFileName;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('lampiran')) {
                        // Handle upload error
                        $error = $this->upload->display_errors(); 
                        $isError = true;
                    } else {
                        // Upload success
                        $upload_data = $this->upload->data();
                        $file_name = $upload_data['file_name']; 
                        $newLampiran = new LampiranModel();
                        $newLampiran->KODE_LAMPIRAN = $getNewFileName.".".$ext;
                        $newLampiran->NO_KOMPLAIN = $newkode;
                        $newLampiran->TANGGAL = $today;
                        $newLampiran->TIPE = 0; //komplain
                        // $newLampiran->insert();
                    }
                }
            } 
        } 
        if($isError){  
            $this->response([  
                'message' => "Terdapat error dalam upload lampiran" ,
                'status'=>false
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{ 
            $topikDes = $topik->DESKRIPSI;
            $subtopik1Des = $subtopik1->DESKRIPSI;
            $subtopik2Des = $subtopik2->DESKRIPSI;

            $template = templateEmail("Notifikasi Penambahan Komplain Baru",$user->NAMA, 
            "Sistem mencatat anda telah mengirimkan sebuah komplain baru terkait topik $topikDes - $subtopik1Des - $subtopik2Des. Komplain anda akan diteruskan ke divisi $divisi->NAMA_DIVISI, dengan keterangan '$deskripsi'"
            );
            $resultmail = send_mail($user->EMAIL, 
            'Notifikasi Penambahan Komplain Baru', $template);  
 
            if($resultmail){   
                $this->response([  
                    'data' => $newkode,
                    'message' => 'Berhasil menambahkan komplain baru, silahkan cek email anda',   
                    'status'=>true
                ], REST_Controller::HTTP_CREATED);
            }else{  
                $this->response([  
                    'data' => $newkode,  
                    'message' => 'Berhasil menambahkan komplain baru, namun gagal mengirim email',  
                    'status'=>true
                ], REST_Controller::HTTP_OK);
            }

            //TODO email manajer 
            
        }

    }
}
