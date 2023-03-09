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
       return $this->db->query('SELECT T.*, D.NAMA_DIVISI FROM TOPIK T JOIN DIVISI D ON D.KODE_DIVISI=T.DIV_TUJUAN')->result();
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
    public function getNewKode($topik){
        $getFirstWord = substr($topik, 0, 1);
        $nowyear =  substr(date('Y'), 2);
        $this->db->select('count(*)+1 as newKode');
        $this->db->from('TOPIK');
        $this->db->where('KODE_TOPIK LIKE', $getFirstWord.$nowyear.'%');
        $this->db->order_by('KODE_TOPIK','DESC'); 

        $query = $this->db->get()->result(); 
        $urutan = $query[0]->NEWKODE;  
        $kode = $getFirstWord.$nowyear.str_pad($urutan, 2, "0", STR_PAD_LEFT);
        return $kode;  
    }
    public function insert(){
        $this->db->insert('TOPIK', $this); 
    }
    public function update(){
        $this->db->where('KODE_TOPIK', $this->KODE_TOPIK);
        $this->db->update('TOPIK', $this); 
    }
    public function delete(){
        $this->db->where('KODE_TOPIK', $this->KODE_TOPIK);
        $this->db->delete('TOPIK'); 
        // $this->db->query('DELETE FROM TOPIK WHERE KODE_TOPIK = '.$this->KODE_TOPIK.';');
    } 
}