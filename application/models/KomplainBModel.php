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
            $obj = $query[0];
            $komplainb = new KomplainBModel();
            $komplainb->NO_KOMPLAIN = $obj->NO_KOMPLAIN;
            $komplainb->DESKRIPSI_MASALAH = $obj->DESKRIPSI_MASALAH;
            $komplainb->AKAR_MASALAH = $obj->AKAR_MASALAH;
            $komplainb->T_KOREKTIF = $obj->T_KOREKTIF;
            $komplainb->T_PREVENTIF = $obj->T_PREVENTIF;
            $komplainb->KEBERATAN = $obj->KEBERATAN;
 
            return $komplainb;
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
    public function updateKomplain(){
        $this->db->query("UPDATE KOMPLAINB SET DESKRIPSI_MASALAH = '$this->DESKRIPSI_MASALAH' WHERE NO_KOMPLAIN = '$this->NO_KOMPLAIN' ");
    }
    
    public function updatePenyelesaianKomplain(){  
        $this->db->query("UPDATE KOMPLAINB SET 
        AKAR_MASALAH = '$this->AKAR_MASALAH',
        T_KOREKTIF = '$this->T_KOREKTIF',
        T_PREVENTIF = '$this->T_PREVENTIF'
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'"); 
    }
    
    public function updateBandingKomplain(){  
        $this->db->query("UPDATE KOMPLAINB SET 
        KEBERATAN = '$this->KEBERATAN' 
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'"); 
    }
    public function delete(){
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->delete('KOMPLAINB'); 
    }
}