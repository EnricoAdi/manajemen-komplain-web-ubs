<?php

class DivisiModel extends CI_Model
{ 
    public $KODE_DIVISI;
    public $NAMA_DIVISI;

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){
       return $this->db->get('DIVISI')->result();
    }
    public function get($kode_divisi){
        $this->db->select('*');
        $this->db->from('DIVISI');
        $this->db->where('KODE_DIVISI',$kode_divisi);  
        $query = $this->db->get() 
            ->result();
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function insert(){
        $this->db->insert('DIVISI', $this); 
    }
    public function update(){
        $this->db->where('KODE_DIVISI', $this->KODE_DIVISI);
        $this->db->update('DIVISI', $this); 
    }
    public function delete(){
        $this->db->where('KODE_DIVISI', $this->KODE_DIVISI);
        $this->db->delete('DIVISI'); 
    }
}