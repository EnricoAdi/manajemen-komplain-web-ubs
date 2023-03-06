<?php

class HakAksesModel extends CI_Model
{ 
    public $KODE_HAK_AKSES;
    public $NAMA_HAK_AKSES;
    

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){
       return $this->db->get('HAK_AKSES')->result();
    }
    public function get($kode_hak_akses){
        $this->db->select('*');
        $this->db->from('HAK_AKSES');
        $this->db->where('KODE_HAK_AKSES',$kode_hak_akses);  
        $query = $this->db->get() 
            ->result_array();
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function insert(){
        $this->db->insert('HAK_AKSES', $this); 
    }
    public function update(){
        $this->db->where('KODE_HAK_AKSES', $this->KODE_HAK_AKSES);
        $this->db->update('HAK_AKSES', $this); 
    }
    public function delete(){
        $this->db->where('KODE_HAK_AKSES', $this->KODE_HAK_AKSES);
        $this->db->delete('HAK_AKSES'); 
    }
}