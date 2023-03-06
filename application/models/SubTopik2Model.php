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
       return $this->db->get('SUB_TOPIK2')->result();
    }
    public function get($subtopik2){
        $this->db->select('*');
        $this->db->from('SUB_TOPIK2');
        $this->db->where('SUB_TOPIK2',$subtopik2);  
        $query = $this->db->get() 
            ->result_array();
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function insert(){
        $this->db->insert('SUB_TOPIK2', $this); 
    }
    public function update(){
        $this->db->where('SUB_TOPIK2', $this->SUB_TOPIK2);
        $this->db->update('SUB_TOPIK2', $this); 
    }
    public function delete(){
        $this->db->where('SUB_TOPIK2', $this->SUB_TOPIK2);
        $this->db->delete('SUB_TOPIK2'); 
    }
}