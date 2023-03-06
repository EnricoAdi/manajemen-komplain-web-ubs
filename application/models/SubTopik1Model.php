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
       return $this->db->get('SUB_TOPIK1')->result();
    }
    public function get($subtopik1){
        $this->db->select('*');
        $this->db->from('SUB_TOPIK1');
        $this->db->where('SUB_TOPIK1',$subtopik1);  
        $query = $this->db->get() 
            ->result_array();
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function insert(){
        $this->db->insert('SUB_TOPIK1', $this); 
    }
    public function update(){
        $this->db->where('SUB_TOPIK1', $this->SUB_TOPIK1);
        $this->db->update('SUB_TOPIK1', $this); 
    }
    public function delete(){
        $this->db->where('SUB_TOPIK1', $this->KODE_TOPIK);
        $this->db->delete('SUB_TOPIK1'); 
    }
}