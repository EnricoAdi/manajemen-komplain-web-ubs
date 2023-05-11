<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/key.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';
 
//buat dashboard data
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
        
        $bulanIni = date("F"); 
        $tahunIni = date("Y"); 

        $bulanDalamAngka = date("m"); 
        $tahunDalamAngka = date("Y"); 
        
        $jumlahKomplainTerkirim = $this->KomplainAModel->getTotalKomplainTerkirimByUser($user->NOMOR_INDUK);  
        $jumlahKomplainDiterimaByUser= $this->KomplainAModel->getTotalKomplainDiterimaByUser($user->NOMOR_INDUK);  
        $jumlahKomplainDikerjakanByUser= $this->KomplainAModel->getTotalKomplainSedangDitanganiByUser($user->NOMOR_INDUK);   

        $listKomplainDikirimBulanIniByUser =  $this->KomplainAModel->fetchKomplainBulanIniByUser($user->NOMOR_INDUK,$bulanDalamAngka,$tahunDalamAngka);   

        $listKomplainOnGoingByUser =  $this->KomplainAModel->fetchKomplainPenugasanByUser($user->NOMOR_INDUK);   
     
    
        $data = new stdClass();
        $data->bulanIni = $bulanIni;
        $data->tahunIni = $tahunIni;
        $data->bulanDalamAngka = $bulanDalamAngka;
        $data->tahunDalamAngka = $tahunDalamAngka;
        $data->jumlahKomplainTerkirim = $jumlahKomplainTerkirim;
        $data->jumlahKomplainDiterimaByUser = $jumlahKomplainDiterimaByUser;
        $data->jumlahKomplainDikerjakanByUser = $jumlahKomplainDikerjakanByUser;
        $data->listKomplainDikirimBulanIniByUser = $listKomplainDikirimBulanIniByUser;
        $data->listKomplainOnGoingByUser = $listKomplainOnGoingByUser; 
         
        $this->response([
            'data'=>$data,
            'status'=>200
        ], REST_Controller::HTTP_OK);
    }
}
