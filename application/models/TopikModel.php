<?php

class TopikModel extends CI_Model
{ 
    public $TOPIK;
    public $KODE_TOPIK;
    public $DESKRIPSI;
    public $AU;
    public $DIV_TUJUAN;
    public $NAMA;
    

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){
       return $this->db->get('TOPIK')->result();
    }
    public function get($kode_topik){
        $this->db->select('*');
        $this->db->from('TOPIK');
        $this->db->where('KODE_TOPIK',$kode_topik);  
        $query = $this->db->get() 
            ->result_array();
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function insert(){
        $this->db->insert('KODE_TOPIK', $this); 
    }
    public function update(){
        $this->db->where('KODE_TOPIK', $this->KODE_TOPIK);
        $this->db->update('TOPIK', $this); 
    }
    public function delete(){
        $this->db->where('KODE_TOPIK', $this->KODE_TOPIK);
        $this->db->delete('TOPIK'); 
    }
}