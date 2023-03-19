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
        $this->db->select('*');
        $this->db->from('KOMPLAINA');
        $this->db->where('NO_KOMPLAIN', $no_komplain);
        $query = $this->db->get()
            ->result();
        if (sizeof($query) > 0) {
            return $query[0];
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
