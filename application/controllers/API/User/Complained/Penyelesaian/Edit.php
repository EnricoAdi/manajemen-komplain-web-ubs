<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

//buat lihat update dan delete complain penyelesaian
class Edit extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Alamat endpoint untuk menghapus data penyelesaian pada komplain adalah api/user/complained/penyelesaian/edit/index_get/:nomor_komplain. Endpoint ini memiliki metode request GET. Endpoint ini digunakan untuk menghapus data penyelesaian komplain (feedback terhadap komplain) berdasarkan parameter nomor komplain yang dikirim oleh user. Autentikasi juga dibutuhkan dengan mengirimkan parameter token autentikasi di bagian header request
     * 
     * Endpoint ini akan memberikan kode 404 apabila komplain yang dituju tidak ditemukan, dan kode 202 bila berhasil menghapus data penyelesaian komplain.
     */
    public function index_get($iget, $nomor_komplain)
    {
        //untuk delete
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $user = $pass->data;

        $komplainB = $this->KomplainBModel->get($nomor_komplain);
        if ($komplainB == null) {
            $this->response([
                'message' => 'Komplain tidak ditemukan',
                'status' => 404
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        $komplainB->deletePenyelesaianKomplain();
        $lampiran = new LampiranModel();
        $lampiran->NO_KOMPLAIN = $nomor_komplain;
        $lampiran->deleteByKomplainForFeedback();

        $this->response([
            'message' => 'Berhasil hapus penyelesaian komplain',
            'status' => 202
        ], REST_Controller::HTTP_ACCEPTED);
    }

    /**
     * Alamat endpoint untuk mengubah data penyelesaian pada komplain adalah api/user/complained/penyelesaian/edit/index_post/:nomor_komplain. Endpoint ini memiliki metode request POST. Endpoint ini digunakan untuk mengubah data penyelesaian komplain (feedback terhadap komplain) berdasarkan parameter nomor komplain yang dikirim oleh user. Request ini membutuhkan beberapa parameter, yaitu data akar masalah, tindakan preventif, tindakan korektif, dan tanggal deadline bagi sebuah komplain untuk diselesaikan. Lalu untuk pengubahan data penyelesaian komplain juga bisa digunakan untuk menambah lampiran apabila user terkait ingin memberikan lampiran dalam bentuk file. Autentikasi juga dibutuhkan dengan mengirimkan parameter token autentikasi di bagian header request. 
     * 
     * Endpoint ini akan memberikan kode 404 apabila komplain tidak ditemukan, kode 400 apabila terdapat pelanggaran dalam validasi input user, dan kode 200 bila gagal mengirimkan email.
     */
    public function index_post($ipost, $nomor_komplain)
    {
        //untuk update

        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $user = $pass->data;

        $komplainA = $this->KomplainAModel->get($nomor_komplain);
        $komplainB = $this->KomplainBModel->get($nomor_komplain);

        if ($komplainA == null) {
            $this->response([
                'message' => 'Komplain tidak ditemukan',
                'status' => 404
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        $akar = $this->post('akar');
        $preventif  = $this->post('preventif');
        $korektif = $this->post('korektif');
        $tanggalDeadline = $this->post('deadline');

        if ($akar == null || $preventif == null || $korektif == null || $tanggalDeadline == null) {
            $this->response([
                'message' => 'Input tidak lengkap',
                'status' => 400
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $komplainA->TGL_DEADLINE = $tanggalDeadline;
        $komplainA->updateDeadlinePenyelesaianKomplain();

        $komplainB->AKAR_MASALAH = $akar;
        $komplainB->T_PREVENTIF = $preventif;
        $komplainB->T_KOREKTIF = $korektif;
        $komplainB->updatePenyelesaianKomplain();

        $today = date('Y-m-d');

        $isError = false;
        if ($_FILES != null) {
            $lampirans = $_FILES["lampiran"];
            if ($lampirans['name'][0] != "") {
                if (!file_exists('./uploads/')) {
                    mkdir('./uploads/', 0777, true);
                }
                for ($i = 0; $i < count($lampirans['name']); $i++) {
                    $getNewFileName = 'F_MOB' . generateUID(19) . substr($nomor_komplain, -3, 3);

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
                'message' => 'Terdapat error dalam upload lampiran, pastikan ukuran maksimal 5MB dan format file sesuai ketentuan',
                'status' => 400
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        } else {
            $topik = $komplainA->TOPIK;
            $subtopik1 = $komplainA->SUB_TOPIK1;
            $subtopik2 = $komplainA->SUB_TOPIK2;
            $s2des = $this->SubTopik2Model->get($topik, $subtopik1, $subtopik2)->DESKRIPSI;
            $header = "Sukses mengubah penyelesaian komplain";
            $message = "Sistem mencatat anda mengubah penyelesaian komplain untuk komplain nomor $nomor_komplain . Terima kasih atas kerja sama anda.";
            $template = templateEmail(
                $header,
                $user->NAMA,
                $message
            );

            $resultmail = send_mail(
                $user->EMAIL,
                $header,
                $template
            );

            if ($resultmail) {
                $this->response([
                    'message' => 'Berhasil mengubah penyelesaian komplain, silahkan cek email anda',
                    'status' => 202
                ], REST_Controller::HTTP_ACCEPTED);
                return;
            } else {
                
                $this->response([
                    'message' => 'Berhasil mengubah penyelesaian komplain, namun gagal mengirim email',
                    'status' => 200
                ], REST_Controller::HTTP_OK); 
                return;
            }
        }
    }
}
