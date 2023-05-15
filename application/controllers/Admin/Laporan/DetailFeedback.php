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
            // $data['selectedTopic'] = $topics[0];

            $divisiParam = $this->input->get('divisi');
            $topikParam = $this->input->get('topik');
            $periodeMulai = $this->input->get('periodeMulai'); 
            $periodeSelesai = $this->input->get('periodeSelesai'); 

            $divisis = $this->DivisiModel->fetch(); 
            $data['divisis'] = $divisis;    
            $data['dateNow'] = $dateNow;
            $data['dateStart'] = $dateNow;
            $data['dateEnd'] = $dateNow;

            $selectedDivisi = null;
            $selectedTopic = null;

            // if($divisiParam == null || $periodeMulai==null || $periodeSelesai==null){
            if($topikParam == null || $periodeMulai==null || $periodeSelesai==null){
                $selectedDivisi =  $divisis[0]; 
                $data['dateStart'] = $dateNow;
                $data['dateEnd'] = $dateNow; 
                $selectedTopic =  $topics[0]; 
            }else{  
                $selectedDivisi = $this->DivisiModel->get($divisiParam);
                $data['dateStart'] = $periodeMulai;
                $data['dateEnd'] = $periodeSelesai;
                $selectedTopic = $this->TopikModel->get($topikParam);
            }  
            $data['selectedTopic'] = $selectedTopic;
            $data['selectedDivisi'] = $selectedDivisi;
            $data['formattedDateEnd'] = formatDateIndo($data['dateEnd']);
            $data['formattedDateStart'] =  formatDateIndo($data['dateStart']);

            $allData = [];

            // $allData = $this->KomplainAModel->customFetch("SELECT k.TGL_TERBIT AS tanggal, u.KODEDIV AS pengirim, t.TOPIK as aspek,t.DESKRIPSI as topik, st.DESKRIPSI AS subtopik,st2.DESKRIPSI AS masalah, k2.DESKRIPSI_MASALAH AS deskripsi, k2.AKAR_MASALAH AS akar
            // FROM KOMPLAINA k ,KOMPLAINB k2, USERS u, TOPIK t,SUB_TOPIK1 st ,SUB_TOPIK2 st2 
            // WHERE k.NO_KOMPLAIN =k2.NO_KOMPLAIN AND u.NOMOR_INDUK =k.USER_PENERBIT AND k.TOPIK =t.KODE_TOPIK AND ST.KODE_TOPIK = t.KODE_TOPIK AND ST.KODE_TOPIK = k.TOPIK AND ST2.KODE_TOPIK = t.KODE_TOPIK AND ST2.KODE_TOPIK = k.TOPIK AND ST.SUB_TOPIK1 = ST2.SUB_TOPIK1 
            // AND st.KODE_TOPIK = ST2.KODE_TOPIK and T.DIV_TUJUAN='$selectedDivisi->KODE_DIVISI' and k.TGL_TERBIT<=TO_DATE('$data[dateEnd]', 'YYYY-MM-DD') and TGL_TERBIT>=TO_DATE('$data[dateStart]', 'YYYY-MM-DD')"); 
            $allData = $this->KomplainAModel->customFetch("SELECT k.TGL_TERBIT AS tanggal, u.KODEDIV AS pengirim, t.TOPIK as aspek,t.DESKRIPSI as topik, st.DESKRIPSI AS subtopik,st2.DESKRIPSI AS masalah, k2.DESKRIPSI_MASALAH AS deskripsi, k2.AKAR_MASALAH AS akar, k2.T_KOREKTIF
            FROM KOMPLAINA k ,KOMPLAINB k2, USERS u, TOPIK t,SUB_TOPIK1 st ,SUB_TOPIK2 st2 
            WHERE k.NO_KOMPLAIN =k2.NO_KOMPLAIN AND u.NOMOR_INDUK =k.USER_PENERBIT AND 
            k.TOPIK = t.KODE_TOPIK AND 
            ST.KODE_TOPIK = t.KODE_TOPIK AND ST.KODE_TOPIK = k.TOPIK AND ST.SUB_TOPIK1 = k.SUB_TOPIK1
            AND ST2.KODE_TOPIK = t.KODE_TOPIK 
            AND ST2.KODE_TOPIK = k.TOPIK AND ST.SUB_TOPIK1 = ST2.SUB_TOPIK1  
            AND ST2.SUB_TOPIK2 = k.SUB_TOPIK2 and ST2.SUB_TOPIK1 = k.SUB_TOPIK1  
            AND ST.SUB_TOPIK1 = ST2.SUB_TOPIK1 
            AND st.KODE_TOPIK = ST2.KODE_TOPIK and k.TOPIK='$selectedTopic->KODE_TOPIK' and k.TGL_TERBIT<=TO_DATE('$data[dateEnd]', 'YYYY-MM-DD') and TGL_TERBIT>=TO_DATE('$data[dateStart]', 'YYYY-MM-DD')"); 
            
            $data['allData'] = $allData; 

            // die_dump($data['selectedTopic']);
            loadView_Admin("admin/laporan/detail-feedback", $data); 
        }
    }
