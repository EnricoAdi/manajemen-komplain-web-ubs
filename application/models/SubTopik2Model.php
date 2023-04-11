<?php

class SubTopik2Model extends CI_Model
{  
    public $KODE_TOPIK;
    public $SUB_TOPIK1;
    public $SUB_TOPIK2;
    public $DESKRIPSI;  
    public $AKTIF;  

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){ 
       $showed = 1000;
       return $this->db->query("SELECT S2.*, S2.DESKRIPSI AS S2DESKRIPSI, 
       S1.DESKRIPSI AS DESKRIPSI_SUBTOPIK1, S1.DESKRIPSI AS S1DESKRIPSI,T.TOPIK AS TDESKRIPSI,
       T.TOPIK, D.NAMA AS NAMA_DIVISI FROM SUB_TOPIK2 S2 JOIN SUB_TOPIK1 S1 
       ON S2.SUB_TOPIK1 = S1.SUB_TOPIK1 JOIN TOPIK T ON T.KODE_TOPIK = S2.KODE_TOPIK
       JOIN DIVISI D ON T.DIV_TUJUAN = D.KODEDIV where rownum<=$showed")
       ->result();
    }
    public function get($topik,$subtopik1,$subtopik2){
       
        $query = $this->db->query("SELECT S2.*, 
        S1.DESKRIPSI AS DESKRIPSI_SUBTOPIK1,
        T.TOPIK FROM SUB_TOPIK2 S2 JOIN SUB_TOPIK1 S1 
        ON S2.SUB_TOPIK1 = S1.SUB_TOPIK1 JOIN TOPIK T ON T.KODE_TOPIK = S2.KODE_TOPIK 
        WHERE S2.SUB_TOPIK2 = $subtopik2 AND S2.SUB_TOPIK1 = $subtopik1 AND S2.KODE_TOPIK = '$topik'")->result(); 
 
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
     
    public function getNewKode($topik,$subtopik1){
        $this->db->select("nvl(SUB_TOPIK2,'0000') as OLDKODE from SUB_TOPIK2 where KODE_TOPIK = '$topik'
            and SUB_TOPIK1 ='$subtopik1' and rownum<=1 order by SUB_TOPIK2 desc "); 
        
        $query = $this->db->get()->result(); 
        $oldkode = $query[0]->OLDKODE;
        $newkode = "0";
        $urutan = (int)$oldkode;
        $urutan = $urutan+1; 
        
        $newkode  = str_pad($urutan, 4, "0", STR_PAD_LEFT);
        return $newkode;
    }
    public function insert(){
        $this->db->insert('SUB_TOPIK2', $this); 
    }
    public function update(){
        $this->db->where('SUB_TOPIK2', $this->SUB_TOPIK2);
        $this->db->where('SUB_TOPIK1', $this->SUB_TOPIK1);
        $this->db->where('KODE_TOPIK', $this->KODE_TOPIK);
        $this->db->update('SUB_TOPIK2', $this); 
    }
    public function delete(){
        $this->db->where('SUB_TOPIK2', $this->SUB_TOPIK2);
        $this->db->where('SUB_TOPIK1', $this->SUB_TOPIK1);
        $this->db->where('KODE_TOPIK', $this->KODE_TOPIK);
        $this->db->delete('SUB_TOPIK2'); 
    }
    
    public function fetchKomplain(){ 
        return $this->db->query('SELECT * FROM KOMPLAINA where SUB_TOPIK2 = ? and SUB_TOPIK1 = ? and TOPIK = ?',
        array($this->SUB_TOPIK2,$this->SUB_TOPIK1,$this->KODE_TOPIK)
        )->result();
     }
    public function fetchSubtopikAll($divisi, $in){ 
        if($in){ 
            return $this->db->query('SELECT S2.SUB_TOPIK2, S2.DESKRIPSI AS S2DESKRIPSI, 
            S2.SUB_TOPIK1, S1.DESKRIPSI AS S1DESKRIPSI, S2.KODE_TOPIK, T.TOPIK AS TDESKRIPSI,
            D.NAMA AS NAMA_DIVISI 
            FROM SUB_TOPIK2 S2 JOIN SUB_TOPIK1 S1 ON S1.SUB_TOPIK1=S2.SUB_TOPIK1 
            JOIN TOPIK T ON S2.KODE_TOPIK=T.KODE_TOPIK 
            JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN WHERE T.DIV_TUJUAN='.$divisi)->result();
        }else{ 
            return $this->db->query('SELECT S2.SUB_TOPIK2, S2.DESKRIPSI AS S2DESKRIPSI, 
            S2.SUB_TOPIK1, S1.DESKRIPSI AS S1DESKRIPSI, S2.KODE_TOPIK, T.TOPIK AS TDESKRIPSI,
            D.NAMA AS NAMA_DIVISI 
            FROM SUB_TOPIK2 S2 JOIN SUB_TOPIK1 S1 ON S1.SUB_TOPIK1=S2.SUB_TOPIK1 
            JOIN TOPIK T ON S2.KODE_TOPIK=T.KODE_TOPIK 
            JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN WHERE T.DIV_TUJUAN<>'.$divisi)->result();
        }
     }
}