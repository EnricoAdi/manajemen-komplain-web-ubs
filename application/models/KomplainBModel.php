<?php

class KomplainBModel extends CI_Model
{ 
    public $NO_KOMPLAIN;
    public $DESKRIPSI_MASALAH;
    public $AKAR_MASALAH;
    public $T_KOREKTIF;
    public $T_PREVENTIF;
    public $KEBERATAN; 
        

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){
       return $this->db->get('KOMPLAINB')->result();
    }
    public function get($no_komplain){
        $this->db->select('*');
        $this->db->from('KOMPLAINB');
        $this->db->where('NO_KOMPLAIN',$no_komplain);  
        $query = $this->db->get() 
            ->result();
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function insert(){
        $this->db->insert('KOMPLAINB', $this); 
    }
    public function update(){
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->update('KOMPLAINB', $this); 
    }
    public function delete(){
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->delete('KOMPLAINB'); 
    }
}