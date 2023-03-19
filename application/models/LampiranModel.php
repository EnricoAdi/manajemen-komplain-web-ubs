<?php

class LampiranModel extends CI_Model
{ 
    public $KODE_LAMPIRAN;
    public $NO_KOMPLAIN; 
    public $TANGGAL;
    public $TIPE; 
        

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){
       return $this->db->get('LAMPIRAN')->result();
    }
    public function get($kode_lampiran){
        $this->db->select('*');
        $this->db->from('LAMPIRAN');
        $this->db->where('KODE_LAMPIRAN',$kode_lampiran);  
        $query = $this->db->get() 
            ->result_array();
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function insert(){
        // $this->db->insert('LAMPIRAN', $this); 
        $this->db->query("INSERT INTO LAMPIRAN VALUES('$this->KODE_LAMPIRAN','$this->NO_KOMPLAIN',TO_DATE('$this->TANGGAL','yyyy-mm-dd'),'$this->TIPE')");
    }
    public function update(){
        $this->db->where('KODE_LAMPIRAN', $this->NO_KOMPLAIN);
        $this->db->update('LAMPIRAN', $this); 
    }
    public function delete(){
        $this->db->where('KODE_LAMPIRAN', $this->NO_KOMPLAIN);
        $this->db->delete('LAMPIRAN'); 
    }
}