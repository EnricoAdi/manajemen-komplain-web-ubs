<?php

class SubTopik1Model extends CI_Model
{  
    public $KODE_TOPIK;
    public $SUB_TOPIK1;
    public $DESKRIPSI;  

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){ 
       return $this->db->query('SELECT S.*, T.TOPIK, D.NAMA_DIVISI FROM SUB_TOPIK1 S 
       JOIN TOPIK T ON S.KODE_TOPIK = T.KODE_TOPIK
       JOIN DIVISI D ON D.KODE_DIVISI = T.DIV_TUJUAN')->result();
    }
    public function get($subtopik1){
        $query = $this->db->query('SELECT S.*, T.TOPIK, D.NAMA_DIVISI 
        FROM SUB_TOPIK1 S JOIN TOPIK T ON S.KODE_TOPIK = T.KODE_TOPIK 
        JOIN DIVISI D ON D.KODE_DIVISI = T.DIV_TUJUAN
        WHERE S.SUB_TOPIK1 = '.$subtopik1)->result(); 
 
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function getNewKode(){
        $this->db->select("nvl(SUB_TOPIK1,'0000') as OLDKODE from SUB_TOPIK1 where rownum<=1 order by SUB_TOPIK1 desc "); 
        
        $query = $this->db->get()->result(); 
        $oldkode = $query[0]->OLDKODE;
        $newkode = "0";
        $urutan = (int)$oldkode;
        $urutan = $urutan + 1; 
        
        $newkode  = str_pad($urutan, 4, "0", STR_PAD_LEFT);
        return $newkode;
    }
    public function insert(){
        $this->db->insert('SUB_TOPIK1', $this); 
    }
    public function update(){
        $this->db->where('SUB_TOPIK1', $this->SUB_TOPIK1);
        $this->db->update('SUB_TOPIK1', $this); 
    }
    public function delete(){
        $this->db->where('SUB_TOPIK1', $this->SUB_TOPIK1);
        $this->db->delete('SUB_TOPIK1'); 
    }
    public function fetchSubtopik2(){ 
       return $this->db->query('SELECT S.* FROM SUB_TOPIK2 S  where S.SUB_TOPIK1 = ?',
       array($this->SUB_TOPIK1)
       )->result();
    }
}