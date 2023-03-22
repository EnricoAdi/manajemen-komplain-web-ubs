<?php

class KomplainAModel extends CI_Model
{
    public $NO_KOMPLAIN;
    public $TOPIK;
    public $SUB_TOPIK1;
    public $SUB_TOPIK2;
    public $TGL_KEJADIAN;
    public $TGL_TERBIT;
    public $TGL_VERIFIKASI;
    public $USER_VERIFIKASI;
    public $TGL_CANCEL;
    public $USER_CANCEL;
    public $TGL_BANDING;
    public $USER_BANDING;
    public $TGL_VALIDASI;
    public $USER_VALIDASI;
    public $PENUGASAN;
    public $STATUS;
    public $TGL_PENANGANAN;
    public $USER_PENANGANAN;
    public $TGL_DEADLINE;
    public $TGL_DONE;
    public $USER_DONE;
    public $USER_PENERBIT;


    public function __construct()
    {
        parent::__construct();
    }
    public function fetch()
    {
        return $this->db->query('SELECT KA.*, KB.*,D.* FROM KOMPLAINA KA 
       JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
       JOIN DIVISI D ON D.KODE_DIVISI = T.DIV_TUJUAN')->result();
    }
    public function get($no_komplain)
    {  
        $query = $this->db->query('SELECT KA.*, KB.*,D.*, ST1.DESKRIPSI AS S1DESKRIPSI, 
        ST2.DESKRIPSI AS S2DESKRIPSI, T.TOPIK AS TDESKRIPSI FROM KOMPLAINA KA
        JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
        JOIN DIVISI D ON D.KODE_DIVISI = T.DIV_TUJUAN 
        JOIN SUB_TOPIK1 ST1 ON ST1.SUB_TOPIK1 = KA.SUB_TOPIK1
        JOIN SUB_TOPIK2 ST2 ON ST2.SUB_TOPIK2 = KA.SUB_TOPIK2
        JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK
        WHERE KB.NO_KOMPLAIN = ?',array($no_komplain))->result();

        if (sizeof($query) > 0) {
            $resultQuery = $query[0]; 
            $queryLampiran = $this->db->query('SELECT * FROM LAMPIRAN WHERE NO_KOMPLAIN = ?',array($no_komplain))->result();
            if(sizeof($queryLampiran)>0){ 
                $resultQuery->LAMPIRAN = $queryLampiran;
            }else{
                $resultQuery->LAMPIRAN = array();
            }
            $komplainA = new KomplainAModel();
            $komplainA->NO_KOMPLAIN = $resultQuery->NO_KOMPLAIN;
            $komplainA->TOPIK = $resultQuery->TOPIK;
            $komplainA->SUB_TOPIK1 = $resultQuery->SUB_TOPIK1;
            $komplainA->SUB_TOPIK2 = $resultQuery->SUB_TOPIK2;
            $komplainA->TGL_KEJADIAN = $resultQuery->TGL_KEJADIAN;
            $komplainA->TGL_TERBIT = $resultQuery->TGL_TERBIT;
            $komplainA->TGL_VERIFIKASI = $resultQuery->TGL_VERIFIKASI;
            $komplainA->USER_VERIFIKASI = $resultQuery->USER_VERIFIKASI;
            $komplainA->TGL_CANCEL = $resultQuery->TGL_CANCEL;
            $komplainA->USER_CANCEL = $resultQuery->USER_CANCEL;
            $komplainA->TGL_BANDING = $resultQuery->TGL_BANDING;
            $komplainA->USER_BANDING = $resultQuery->USER_BANDING;
            $komplainA->TGL_VALIDASI = $resultQuery->TGL_VALIDASI;
            $komplainA->USER_VALIDASI = $resultQuery->USER_VALIDASI;
            $komplainA->PENUGASAN = $resultQuery->PENUGASAN;
            $komplainA->STATUS = $resultQuery->STATUS;
            $komplainA->TGL_PENANGANAN = $resultQuery->TGL_PENANGANAN;
            $komplainA->USER_PENANGANAN = $resultQuery->USER_PENANGANAN;
            $komplainA->TGL_DEADLINE = $resultQuery->TGL_DEADLINE;
            $komplainA->TGL_DONE = $resultQuery->TGL_DONE;
            $komplainA->USER_DONE = $resultQuery->USER_DONE;
            $komplainA->USER_PENERBIT = $resultQuery->USER_PENERBIT;
            $komplainA->LAMPIRAN = $resultQuery->LAMPIRAN; 
            $komplainA->S1DESKRIPSI = $resultQuery->S1DESKRIPSI;
            $komplainA->S2DESKRIPSI = $resultQuery->S2DESKRIPSI;
            $komplainA->TDESKRIPSI = $resultQuery->TDESKRIPSI;
            $komplainA->KODE_DIVISI = $resultQuery->KODE_DIVISI;
            $komplainA->NAMA_DIVISI = $resultQuery->NAMA_DIVISI;  
            $komplainA->DESKRIPSI_MASALAH= $resultQuery->DESKRIPSI_MASALAH; 

            $penerbit = $this->db->query('SELECT U.*, D.* 
            FROM USERS U JOIN DIVISI D ON U.KODE_DIVISI = D.KODE_DIVISI 
            WHERE U.NOMOR_INDUK = ?',array($resultQuery->USER_PENERBIT))->result();

            $komplainA->PENERBIT = $penerbit[0];

            return $komplainA;
        }
        return null;
    }
    public function getNewKode()
    {
        $this->db->select("nvl(NO_KOMPLAIN,'0000000000') as OLDKODE from KOMPLAINA where rownum<=1 order by NO_KOMPLAIN desc ");

        $query = $this->db->get()->result();
        $oldkode = '0000000000';
        if (sizeof($query) > 0) {
            $oldkode = $query[0]->OLDKODE;
        }
        $newkode = "0";
        $urutan = (int)$oldkode;
        $urutan = $urutan + 1;

        $newkode  = str_pad($urutan, 10, "0", STR_PAD_LEFT);
        return $newkode;
    }

    public function fetchFromUser($nomor_induk, $status)
    {
        if ($status == 'all') {
            return $this->db->query("SELECT KA.*, KB.*,D.* FROM KOMPLAINA KA 
            JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
            JOIN DIVISI D ON D.KODE_DIVISI = T.DIV_TUJUAN WHERE KA.USER_PENERBIT = $nomor_induk")->result();
        } else {
            return $this->db->query("SELECT KA.*, KB.*,D.* FROM KOMPLAINA KA 
            JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
            JOIN DIVISI D ON D.KODE_DIVISI = T.DIV_TUJUAN WHERE KA.USER_PENERBIT = $nomor_induk AND KA.STATUS = '$status'")->result();
        }
    }
    public function fetchForDivisi($kode_divisi,$status){ 
        if ($status == 'all') {
            return $this->db->query("SELECT KA.*, KB.*,D.*, 
            DU.NAMA_DIVISI AS DIVISI_PENGIRIM,T.DESKRIPSI AS TDESKRIPSI, 
            S1.DESKRIPSI AS S1DESKRIPSI,
            S2.DESKRIPSI AS S2DESKRIPSI
            FROM KOMPLAINA KA 
            JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
            JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
            JOIN DIVISI D ON D.KODE_DIVISI = T.DIV_TUJUAN 
            JOIN USERS U ON U.NOMOR_INDUK = KA.USER_PENERBIT
            JOIN DIVISI DU ON DU.KODE_DIVISI = U.KODE_DIVISI
            JOIN SUB_TOPIK1 S1 ON S1.SUB_TOPIK1 = KA.SUB_TOPIK1
            JOIN SUB_TOPIK2 S2 ON S2.SUB_TOPIK2 = KA.SUB_TOPIK2
            WHERE T.DIV_TUJUAN = $kode_divisi")->result();
        } else {
            return $this->db->query("SELECT KA.*, KB.*,D.*, 
            DU.NAMA_DIVISI AS DIVISI_PENGIRIM, T.DESKRIPSI AS TDESKRIPSI,
            S1.DESKRIPSI AS S1DESKRIPSI,
            S2.DESKRIPSI AS S2DESKRIPSI
            FROM KOMPLAINA KA 
            JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
            JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
            JOIN DIVISI D ON D.KODE_DIVISI = T.DIV_TUJUAN 
            JOIN USERS U ON U.NOMOR_INDUK = KA.USER_PENERBIT
            JOIN DIVISI DU ON DU.KODE_DIVISI = U.KODE_DIVISI
            JOIN SUB_TOPIK1 S1 ON S1.SUB_TOPIK1 = KA.SUB_TOPIK1
            JOIN SUB_TOPIK2 S2 ON S2.SUB_TOPIK2 = KA.SUB_TOPIK2
            WHERE T.DIV_TUJUAN = $kode_divisi AND KA.STATUS = '$status'")->result();
        }
    }
    public function insert()
    {
        // $this->db->insert('KOMPLAINA', $this); 
        $this->db->query("INSERT INTO KOMPLAINA VALUES ('$this->NO_KOMPLAIN', '$this->TOPIK', '$this->SUB_TOPIK1', '$this->SUB_TOPIK2', TO_DATE('$this->TGL_KEJADIAN', 'YYYY-MM-DD'), NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$this->STATUS', NULL, NULL, NULL, NULL, NULL, '$this->USER_PENERBIT')");
    }
    public function update()
    {   
        $this->db->query("UPDATE KOMPLAINA SET TOPIK = $this->TOPIK,
        SUB_TOPIK1 = $this->SUB_TOPIK1, 
        SUB_TOPIK2 = $this->SUB_TOPIK2, 
        TGL_KEJADIAN = $this->TGL_KEJADIAN, 
        TGL_TERBIT = $this->TGL_TERBIT, 
        TGL_VERIFIKASI = $this->TGL_VERIFIKASI, 
        USER_VERIFIKASI = $this->USER_VERIFIKASI, 
        TGL_CANCEL = $this->TGL_CANCEL, 
        USER_CANCEL = $this->USER_CANCEL, 
        TGL_BANDING = $this->TGL_BANDING, 
        USER_BANDING = $this->USER_BANDING, 
        TGL_VALIDASI = $this->TGL_VALIDASI, 
        USER_VALIDASI = $this->USER_VALIDASI, 
        PENUGASAN = $this->PENUGASAN, 
        STATUS = $this->STATUS, 
        TGL_PENANGANAN = $this->TGL_PENANGANAN, 
        USER_PENANGANAN = $this->USER_PENANGANAN, 
        TGL_DEADLINE = $this->TGL_DEADLINE, 
        TGL_DONE = $this->TGL_DONE, 
        USER_DONE = $this->USER_DONE, 
        USER_PENERBIT = $this->USER_PENERBIT, 
        where NO_KOMPLAIN = $this->NO_KOMPLAIN");
        // $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        // $this->db->update('KOMPLAINA', $this); 
    }
    public function updateKomplain(){
        
        $this->db->query("UPDATE KOMPLAINA SET 
        TOPIK ='$this->TOPIK',
        SUB_TOPIK1 = '$this->SUB_TOPIK1', 
        SUB_TOPIK2 = '$this->SUB_TOPIK2', 
        TGL_KEJADIAN = TO_DATE('$this->TGL_KEJADIAN', 'YYYY-MM-DD')
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateVerifikasi(){ 
        $this->db->query("UPDATE KOMPLAINA SET 
        STATUS = 'PEND',
        USER_VERIFIKASI ='$this->USER_VERIFIKASI', 
        TGL_VERIFIKASI = TO_DATE('$this->TGL_VERIFIKASI', 'YYYY-MM-DD')
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateTransferKomplain(){  
        $this->db->query("UPDATE KOMPLAINA SET 
        TOPIK ='$this->TOPIK',
        SUB_TOPIK1 = '$this->SUB_TOPIK1', 
        SUB_TOPIK2 = '$this->SUB_TOPIK2'  
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updatePenugasanKomplain(){  
        $this->db->query("UPDATE KOMPLAINA SET 
        PENUGASAN ='$this->PENUGASAN' 
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateHapusPenugasanKomplain(){  
        $this->db->query("UPDATE KOMPLAINA SET 
        PENUGASAN = null 
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateDeadlinePenyelesaianKomplain(){  
        $this->db->query("UPDATE KOMPLAINA SET 
        TGL_DEADLINE = TO_DATE('$this->TGL_DEADLINE', 'YYYY-MM-DD')
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'"); 
    }
    public function delete()
    { 
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->delete('KOMPLAINA');
    }
}
