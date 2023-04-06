<?php

class DivisiModel extends CI_Model
{ 
    public $KODE_DIVISI;
    public $NAMA;
    public $AKTIF;
    public $KEL_SAH;

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){
       return $this->db->query("SELECT KODEDIV AS KODE_DIVISI, NAMA AS NAMA_DIVISI FROM DIVISI ORDER BY NAMA")->result();
    }
    public function get($kode_divisi){ 

        $query = $this->db->query("SELECT KODEDIV AS KODE_DIVISI, NAMA AS NAMA_DIVISI FROM DIVISI WHERE KODEDIV = ?",array($kode_divisi))->result(); 
 
        if(sizeof($query)>0){
            return $query[0]; 
        }
        return null;
    } 
    public function insert(){ 
        $this->db->query('INSERT INTO DIVISI VALUES(?,?,?,?)',
        array($this->KODE_DIVISI,$this->NAMA,$this->AKTIF,$this->KEL_SAH));
    }
    public function update(){
        $this->db->where('KODEDIV', $this->KODE_DIVISI);
        $this->db->update('DIVISI', $this); 
    }
    public function delete(){
        $this->db->where('KODEDIV', $this->KODE_DIVISI);
        $this->db->delete('DIVISI'); 
    }
}