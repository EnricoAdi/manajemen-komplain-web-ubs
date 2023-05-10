<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
  
class SendFeedback extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }

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
        $akar = $this->post('akar');
        $preventif  = $this->post('preventif');
        $korektif = $this->post('korektif');
        $tanggalDeadline = $this->post('deadline');


        $today = date('Y-m-d');

        if ($akar == null || $preventif == null || $korektif == null || $tanggalDeadline == null) { 
            $this->response([
                'message'=>'Input tidak lengkap', 
                'status'=>400
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        } else {
            //update deadline
            $komplain->TGL_DEADLINE = $tanggalDeadline;
            $komplain->TGL_PENANGANAN = $today;
            $komplain->USER_PENANGANAN = $user->NOMOR_INDUK;
            $komplain->updateDeadlinePenyelesaianKomplain();
            $komplain->updatePenyelesaianKomplain();

            //update komplainB
            $komplainB = new KomplainBModel();
            $komplainB->NO_KOMPLAIN = $nomor_komplain;
            $komplainB->AKAR_MASALAH = $akar;
            $komplainB->T_PREVENTIF = $preventif;
            $komplainB->T_KOREKTIF = $korektif;
            $komplainB->updatePenyelesaianKomplain();

            //insert lampiran

            $lampirans = $_FILES["lampiran"];
            $isError = false;

            if($_FILES !=null){ 
                if ($lampirans['name'][0] != "") {
                    if (!file_exists('./uploads/')) {
                        mkdir('./uploads/', 0777, true);
                    }
                    for ($i = 0; $i < count($lampirans['name']); $i++) {
                        $getNewFileName = 'F_MOB' . generateUID(19).substr($nomor_komplain,-3,3);

                        if ($i < count($lampirans)) {
                            $_FILES['lampiran']['name'] = $lampirans['name'][$i];
                            $_FILES['lampiran']['type'] = $lampirans['type'][$i];
                            $_FILES['lampiran']['tmp_name'] = $lampirans['tmp_name'][$i];
                            $_FILES['lampiran']['error'] = $lampirans['error'][$i];
                            $_FILES['lampiran']['size'] = $lampirans['size'][$i];

                            $ext = pathinfo($lampirans['name'][$i], PATHINFO_EXTENSION);

                            $config['upload_path'] = './uploads/';
                            $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|txt|xlsx|docx|csv';
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
                                $newLampiran->KODE_LAMPIRAN = $getNewFileName . "." . $ext;
                                $newLampiran->NO_KOMPLAIN = $nomor_komplain;
                                $newLampiran->TANGGAL = $today;
                                $newLampiran->TIPE = 1; //feedback
                                $newLampiran->insert();
                            }
                        }
                    }
                }
            }
            if ($isError) { 
                $this->response([
                    'message'=>'Terdapat error dalam upload lampiran, pastikan ukuran tidak melebihi 5 MB', 
                    'status'=>400
                ], REST_Controller::HTTP_BAD_REQUEST);
                return;
            } else { 
                $topik = $komplain->TOPIK;
                $subtopik1 = $komplain->SUB_TOPIK1;
                $subtopik2 = $komplain->SUB_TOPIK2;
                $header = "Sukses menambahkan penyelesaian komplain";
                $s2message = $this->SubTopik2Model->get($topik, $subtopik1, $subtopik2)->DESKRIPSI;
                $body = "Sistem mencatat anda berhasil menambahkan penyelesaian komplain untuk subtopik $s2message. Terima kasih atas kerja sama anda.";
                $template =templateEmail(
                    $header,
                    $this->UsersModel->getLogin()->NAMA,
                    $body
                );

                $resultmail = send_mail(
                    $user->EMAIL,
                    $header,
                    $template
                ); 

                if ($resultmail) { 
                    $this->response([
                        'message'=>'Berhasil menyelesaikan komplain, silahkan cek email anda', 
                        'status'=>202
                    ], REST_Controller::HTTP_ACCEPTED);
                    return;
                } else {
                    $this->response([
                        'message'=>'Berhasil menyelesaikan komplain, namun gagal mengirim email', 
                        'status'=>200
                    ], REST_Controller::HTTP_OK);
                    return; 
                }
            }
        } 
    }
}
