<?php 
    class PerTopik extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Laporan"; 
            
            $this->load->library("form_validation");   


            middleware_auth(4); //hak akses admin

        }
        
        public function index(){
            
            $data = $this->data;
            $data['page_title'] = "Laporan Per Topik";
            $data['login'] = $this->UsersModel->getLogin();
            
            $dateNow = date("Y-m-d");
            
            //get
            $divisiParam = $this->input->get('divisi');
            $periodeMulai = $this->input->get('periodeMulai'); 
            $periodeSelesai = $this->input->get('periodeSelesai'); 
            
            $divisis = $this->DivisiModel->fetch();
            $data['divisis'] = $divisis;    
            $data['dateNow'] = $dateNow;
            $selectedDivisi = null;
            if($divisiParam == null || $periodeMulai==null || $periodeSelesai==null){
                $selectedDivisi =  $divisis[0]; 
                $data['dateStart'] = $dateNow;
                $data['dateEnd'] = $dateNow; 
            }else{  
                $selectedDivisi = $this->DivisiModel->get($divisiParam);
                $data['dateStart'] = $periodeMulai;
                $data['dateEnd'] = $periodeSelesai;
            }  
            $data['selectedDivisi'] = $selectedDivisi;
            $data['formattedDateEnd'] = formatDateIndo($data['dateEnd']);
            $data['formattedDateStart'] =  formatDateIndo($data['dateStart']);
   
            $allData = [];
            //get list topik
            $allData = $this->KomplainAModel->customFetch("SELECT distinct S2.SUB_TOPIK1, S2.KODE_TOPIK, S2.SUB_TOPIK2, S2.DESKRIPSI AS SUBTOPIK2, 
            S1.DESKRIPSI AS SUBTOPIK1, T.TOPIK AS TDESKRIPSI,
             D.NAMA AS NAMA_DIVISI FROM 
            SUB_TOPIK2 S2 JOIN SUB_TOPIK1 S1 
            ON S2.SUB_TOPIK1 = S1.SUB_TOPIK1 AND S2.KODE_TOPIK = S1.KODE_TOPIK
            JOIN TOPIK T 
            ON T.KODE_TOPIK = S2.KODE_TOPIK 
            JOIN DIVISI D ON T.DIV_TUJUAN = D.KODEDIV  
            WHERE T.DIV_TUJUAN='$selectedDivisi->KODE_DIVISI' order by D.NAMA ASC, TDESKRIPSI ASC "); 
           foreach ($allData as $key => $value) {
                $top = $value->KODE_TOPIK;
                $sub1 = $value->SUB_TOPIK1;
                $sub2 = $value->SUB_TOPIK2;  
                $jumlahKomplain = $this->KomplainAModel->customFetch("SELECT COUNT(*) as jumlah FROM KOMPLAINA WHERE TOPIK='$top' AND SUB_TOPIK1='$sub1' AND SUB_TOPIK2='$sub2' and TGL_TERBIT<=TO_DATE('$data[dateEnd]', 'YYYY-MM-DD') and TGL_TERBIT>=TO_DATE('$data[dateStart]', 'YYYY-MM-DD')");
                $allData[$key]->jumlah = $jumlahKomplain[0]->JUMLAH;
           } 

            
           $data['allData'] = $allData;
            loadView_Admin( "admin/laporan/per-topik",$data); 
        }
    }
