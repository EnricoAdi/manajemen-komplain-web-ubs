<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

//buat delete lampiran penyelesaian komplain
class DeleteLampiran extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Alamat endpoint untuk menghapus sebuah data lampiran pada komplain adalah api/user/complained/penyelesaian/deleteLampiran/index_get/:nomor_komplain. Endpoint ini memiliki metode request GET. Endpoint ini digunakan untuk menghapus data lampiran pada sebuah komplain berdasarkan parameter nomor komplain dan kode lampiran yang dikirim oleh user. Autentikasi juga dibutuhkan dengan mengirimkan parameter token autentikasi di bagian header request. 
     */
    public function index_get($iget, $nomor_komplain, $kode_lampiran)
    {
        //untuk delete
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code != 200) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $user = $pass->data;

        $komplain = $this->KomplainAModel->get($nomor_komplain);
        if ($komplain == null) {
            $this->response([
                'message' => 'Komplain tidak ditemukan',
                'status' => 404
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }
        
        $lampiran = $this->LampiranModel->get($kode_lampiran);
        if ($lampiran == null) {
            
            $this->response([
                'message' => 'Lampiran tidak ditemukan',
                'status' => 404
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
            
        }
        if ($lampiran->TIPE == 0) {
            $this->response([
                'message' => 'Lampiran Komplain tidak dapat dihapus',
                'status' => 400
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
             
        }
        $lampiran->KODE_LAMPIRAN = $kode_lampiran;
        $lampiran->delete();
        
        $lampirans = $this->LampiranModel->fetchByKomplain($nomor_komplain);
        
        $this->response([
            'message' => 'Lampiran berhasil dihapus',
            'data' => $lampirans,
            'status' => 202
        ], REST_Controller::HTTP_ACCEPTED);
    }
    
}
