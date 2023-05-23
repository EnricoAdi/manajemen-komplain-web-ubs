<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat dashboard admin
class Dashboard extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();  
    }
 
    public function index_get()
    {
        $authHeader = $this->input->request_headers()['Authorization'];
        $pass = verifyJWT($authHeader);
        if ($pass->code  > 299) {
            $this->response($pass, REST_Controller::HTTP_UNAUTHORIZED); 
            return;
        }  
        $user = $pass->data;  

        $bulanDalamAngka = date("m"); 
        $tahunDalamAngka = date("Y"); 


        $totalKomplainBulanIni = $this->KomplainAModel->getTotalKomplainByMonth($bulanDalamAngka, $tahunDalamAngka); 
        $divisiTerbanyak = $this->KomplainAModel->divisiKomplainTerbanyakByMonth($bulanDalamAngka, $tahunDalamAngka);


        if($divisiTerbanyak==null){
            $divisiTerbanyak = "Belum ada";
        }else{
            $divisiTerbanyak = $divisiTerbanyak->NAMA;
        } 

        $jumlahKomplainDivisiByMonth = $this->KomplainAModel->jumlahKomplainDivisiByMonth($bulanDalamAngka, $tahunDalamAngka);
        
        $randomColors = [];
        for($i=0; $i<count($jumlahKomplainDivisiByMonth); $i++){
            $randomColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        $data = new stdClass();
        
        $data->bulanIni = date("F");
        $data->tahunIni = date("Y");
        $data->randomColors = $randomColors;  
        $data->bulanDalamAngka = $bulanDalamAngka;
        $data->tahunDalamAngka = $tahunDalamAngka;
        $data->totalKomplainBulanIni = $totalKomplainBulanIni;
        $data->divisiTerbanyak = $divisiTerbanyak;
        $data->jumlahKomplainDivisiByMonth = getjumlahKomplainDivisiByMonth($bulanDalamAngka, $tahunDalamAngka); 
        $data->jumlahKomplainMasukByYear = getjumlahKomplainMasukByYear($tahunDalamAngka); 
        
         
        $this->response([
            'data'=>$data,
            'status'=>200
        ], REST_Controller::HTTP_OK);
    }
}
