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
       return $this->db->query('SELECT S.*, T.TOPIK, D.NAMA AS NAMA_DIVISI FROM SUB_TOPIK1 S 
       JOIN TOPIK T ON S.KODE_TOPIK = T.KODE_TOPIK
       JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN')->result();
    }
    public function fetchByTopik($kode_topik){ 
       return $this->db->query("SELECT S.*, T.TOPIK, D.NAMA AS NAMA_DIVISI FROM SUB_TOPIK1 S 
       JOIN TOPIK T ON S.KODE_TOPIK = T.KODE_TOPIK
       JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN WHERE S.KODE_TOPIK='$kode_topik'")->result();
    }
    public function get($topik,$subtopik1){
        $query = $this->db->query("SELECT S.*, T.TOPIK, D.NAMA AS NAMA_DIVISI 
        FROM SUB_TOPIK1 S JOIN TOPIK T ON S.KODE_TOPIK = T.KODE_TOPIK 
        JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN
        WHERE S.SUB_TOPIK1 = '$subtopik1' and S.KODE_TOPIK = '$topik'")->result(); 
 
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function getNewKode($topik){
        $this->db->select("nvl(SUB_TOPIK1,'0000') as OLDKODE from SUB_TOPIK1 where KODE_TOPIK = '$topik' and rownum<=1 order by SUB_TOPIK1 desc "); 
        
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
        $this->db->where('KODE_TOPIK', $this->KODE_TOPIK);
        $this->db->update('SUB_TOPIK1', $this); 
    }
    public function delete(){
        $this->db->where('SUB_TOPIK1', $this->SUB_TOPIK1);
        $this->db->where('KODE_TOPIK', $this->KODE_TOPIK);
        $this->db->delete('SUB_TOPIK1');  
    }
    public function fetchSubtopik2(){ 
       return $this->db->query('SELECT S.* FROM SUB_TOPIK2 S  where S.SUB_TOPIK1 = ? and S.KODE_TOPIK = ?',
       array($this->SUB_TOPIK1, $this->KODE_TOPIK)
       )->result();
    }
}