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

            return $resultQuery;
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
    public function insert()
    {
        // $this->db->insert('KOMPLAINA', $this); 
        $this->db->query("INSERT INTO KOMPLAINA VALUES ('$this->NO_KOMPLAIN', '$this->TOPIK', '$this->SUB_TOPIK1', '$this->SUB_TOPIK2', TO_DATE('$this->TGL_KEJADIAN', 'YYYY-MM-DD'), NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$this->STATUS', NULL, NULL, NULL, NULL, NULL, '$this->USER_PENERBIT')");
    }
    public function update()
    {
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->update('KOMPLAINA', $this);
    }
    public function delete()
    {
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->delete('KOMPLAINA');
    }
}
