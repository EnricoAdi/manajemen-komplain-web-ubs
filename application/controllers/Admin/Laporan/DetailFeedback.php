<?php 
    class DetailFeedback extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Laporan"; 
            
            $this->load->library("form_validation");   

            middleware_auth(4); //hak akses admin
 

        }
        public function index(){
            
            $data = $this->data;
            $data['page_title'] = "Laporan Detail Feedback";
            $data['login'] = $this->UsersModel->getLogin();
            $dateNow = date("Y-m-d");

            //get
            $topics = $this->TopikModel->fetch();
            $data['topics'] = $topics;   
            $data['selectedTopic'] = $topics[0];

            $divisiParam = $this->input->get('divisi');
            $periodeMulai = $this->input->get('periodeMulai'); 
            $periodeSelesai = $this->input->get('periodeSelesai'); 

            $divisis = $this->DivisiModel->fetch();
            $data['divisis'] = $divisis;    
            $data['dateNow'] = $dateNow;
            $data['dateStart'] = $dateNow;
            $data['dateEnd'] = $dateNow;
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

            $allData = $this->KomplainAModel->customFetch("SELECT k.TGL_TERBIT AS tanggal, u.KODEDIV AS pengirim, t.TOPIK as aspek,t.DESKRIPSI as topik, st.DESKRIPSI AS subtopik,st2.DESKRIPSI AS masalah, k2.DESKRIPSI_MASALAH AS deskripsi, k2.AKAR_MASALAH AS akar
            FROM KOMPLAINA k ,KOMPLAINB k2, USERS u, TOPIK t,SUB_TOPIK1 st ,SUB_TOPIK2 st2 
            WHERE k.NO_KOMPLAIN =k2.NO_KOMPLAIN AND u.NOMOR_INDUK =k.USER_PENERBIT AND k.TOPIK =t.KODE_TOPIK AND ST.KODE_TOPIK = t.KODE_TOPIK AND ST.KODE_TOPIK = k.TOPIK AND ST2.KODE_TOPIK = t.KODE_TOPIK AND ST2.KODE_TOPIK = k.TOPIK AND ST.SUB_TOPIK1 = ST2.SUB_TOPIK1 
            AND st.KODE_TOPIK = ST2.KODE_TOPIK and T.DIV_TUJUAN='$selectedDivisi->KODE_DIVISI'"); 
            
            $data['allData'] = $allData;
            loadView_Admin("admin/laporan/detail-feedback", $data); 
        }
    }
