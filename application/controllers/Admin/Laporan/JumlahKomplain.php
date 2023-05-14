<?php 
    class JumlahKomplain extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Laporan"; 
            $this->data['login'] = $this->UsersModel->getLogin();
               

            middleware_auth(4); //hak akses admin

        }
        public function index(){ 
            $data = $this->data; 
            
            //get
            $divisi = $this->input->get('divisi');
            $tahun = $this->input->get('tahun'); 
            $data['departemens'] = $this->DivisiModel->fetch();

            if($divisi==null || $tahun==null){
                $selectedDepartemen =  $data['departemens'][0];
                $yearnow = date("Y");
               
            }else{ 
                $yearnow = $tahun; 
                $selectedDepartemen =  $this->DivisiModel->get($divisi);
            }  
            $data['selectedDepartemen'] = $selectedDepartemen; 
            $data['yearnow'] = $yearnow; 
            $data['yearMax'] = date("Y"); 

            $data['page_title'] = "Laporan Jumlah Komplain"; 
            
            $data['bulanIni'] = date("F");  


            $monthNames = array(
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ); 
 
            
            $jumlahKomplains = $this->KomplainAModel->customFetch("SELECT RTRIM(TO_CHAR(TGL_TERBIT, 'Month'),' ') as bulan, COUNT(*) as total, TO_CHAR(TGL_TERBIT, 'MM') as angkaBulan FROM KOMPLAINA K JOIN TOPIK T ON T.KODE_TOPIK = K.TOPIK 
            WHERE TO_CHAR(TGL_TERBIT, 'YYYY') = '$yearnow' AND T.DIV_TUJUAN = '$selectedDepartemen->KODE_DIVISI'
            GROUP BY TO_CHAR(TGL_TERBIT, 'Month'),TO_CHAR(TGL_TERBIT, 'MM')  ORDER BY TO_CHAR(TGL_TERBIT, 'MM') ASC");
            
            //tanggal terbit + 3 < penanganan, atau belum ditangani
            $jumlahKomplainTerlambats = $this->KomplainAModel->customFetch("SELECT RTRIM(TO_CHAR(TGL_TERBIT, 'Month'),' ') as bulan, COUNT(*) as total, TO_CHAR(TGL_TERBIT, 'MM') as angkaBulan FROM KOMPLAINA K JOIN TOPIK T ON T.KODE_TOPIK = K.TOPIK 
            WHERE TO_CHAR(TGL_TERBIT, 'YYYY') = '$yearnow' AND T.DIV_TUJUAN = '$selectedDepartemen->KODE_DIVISI' AND
           ( K.TGL_TERBIT + 3 < K.TGL_PENANGANAN OR (K.TGL_PENANGANAN IS NULL AND K.TGL_TERBIT + 3 < SYSDATE))
            GROUP BY TO_CHAR(TGL_TERBIT, 'Month'),TO_CHAR(TGL_TERBIT, 'MM')  ORDER BY TO_CHAR(TGL_TERBIT, 'MM') ASC");

            $scorePencapaianKomplain = [];
            $komplainTerlambat = [];
            for($i=0;$i < sizeof($monthNames);$i++){
                if(($i < date("m") && $yearnow==date("Y")) ||$yearnow<date("Y") ){ 
                    //untuk ngisi bulan yang dia tidak dikomplain
                    $found = false;
                    for($j=0;$j < sizeof($jumlahKomplains);$j++){
                        if($monthNames[$i] == $jumlahKomplains[$j]->BULAN){
                            $found = true;
                            $scorePencapaianKomplain[$i] = $jumlahKomplains[$j];
                            break;
                        } 
                    }
                    if(!$found){
                        $scorePencapaianKomplain[$i] = (object) [
                            'BULAN' => $monthNames[$i],
                            'TOTAL' => 0,
                            'ANGKABULAN' => $i+1
                        ];
                    }
                    $foundTerlambat = false;
                    for($j=0;$j < sizeof($jumlahKomplainTerlambats);$j++){
                        if($monthNames[$i] == $jumlahKomplainTerlambats[$j]->BULAN){
                            $foundTerlambat = true;
                            $komplainTerlambat[$i] = $jumlahKomplainTerlambats[$j];
                            break;
                        } 
                    }
                    if(!$foundTerlambat){
                        $komplainTerlambat[$i] = (object) [
                            'BULAN' => $monthNames[$i],
                            'TOTAL' => 0,
                            'ANGKABULAN' => $i+1
                        ];
                    }
                }
                
            }   
            for($i=0;$i < sizeof($scorePencapaianKomplain);$i++){
                $poin =  100 -  (floor($scorePencapaianKomplain[$i]->TOTAL / 5) + 1) * 5; 
                 if($scorePencapaianKomplain[$i]->TOTAL==0){
                    $poin = 100;
                 }
                $scorePencapaianKomplain[$i]->POIN = $poin; 
                 if($scorePencapaianKomplain[$i]->TOTAL == null){
                    $scorePencapaianKomplain[$i]->TOTAL = 0;
                 }
                $poinPenanganan = 0;
                if($scorePencapaianKomplain[$i]->TOTAL > $komplainTerlambat[$i]->TOTAL){

                    $poinPenanganan = ($scorePencapaianKomplain[$i]->TOTAL - $komplainTerlambat[$i]->TOTAL) /( $scorePencapaianKomplain[$i]->TOTAL) ;
                }  
                $poinPenanganan = $poinPenanganan * 100;
                $komplainTerlambat[$i]->POIN = $poinPenanganan; 
            }   
            $data['scorePencapaianKomplain'] =  json_encode($scorePencapaianKomplain);  
            $data['komplainTerlambat'] =  json_encode($komplainTerlambat);  
            loadView_Admin("admin/laporan/jumlah-komplain", $data); 
        }
        public function fetchKecepatan($kodedivisi,$tahun){

            $kecepatan = $this->KomplainAModel->customFetch("SELECT RTRIM(TO_CHAR(TGL_TERBIT, 'Month'),' ') as bulan, COUNT(*) as total FROM KOMPLAINA K JOIN TOPIK T ON T.KODE_TOPIK = K.TOPIK 
            WHERE TO_CHAR(TGL_TERBIT, 'YYYY') = '$tahun' AND T.DIV_TUJUAN = '$kodedivisi'
            GROUP BY TO_CHAR(TGL_TERBIT, 'Month'),TO_CHAR(TGL_TERBIT, 'MM')  ORDER BY TO_CHAR(TGL_TERBIT, 'MM') ASC");
            
            for($i=0;$i < sizeof($kecepatan);$i++){
                $poin =  100 -  (floor($kecepatan[$i]->TOTAL / 5) + 1) * 5; 
                 
                $kecepatan[$i]->POIN = $poin; 
            } 
            echo json_encode($kecepatan);
        } 
    }
