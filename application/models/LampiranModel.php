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
    public function fetchByKomplain($no_komplain){
        return $this->db->query("SELECT * FROM LAMPIRAN WHERE NO_KOMPLAIN = '$no_komplain'")->result();
    }
    public function get($kode_lampiran){
        $this->db->select('*');
        $this->db->from('LAMPIRAN');
        $this->db->where('KODE_LAMPIRAN',$kode_lampiran);  
        $query = $this->db->get() 
            ->result();
        if(sizeof($query)>0){
            $lampiran = new LampiranModel();
            $lampiran->KODE_LAMPIRAN = $query[0]->KODE_LAMPIRAN;
            $lampiran->NO_KOMPLAIN = $query[0]->NO_KOMPLAIN;
            $lampiran->TANGGAL = $query[0]->TANGGAL;
            $lampiran->TIPE = $query[0]->TIPE;
            return $lampiran; 
        }
        return null;
    } 
    public function insert(){
        // $this->db->insert('LAMPIRAN', $this); 
        $this->db->query("INSERT INTO LAMPIRAN VALUES('$this->KODE_LAMPIRAN','$this->NO_KOMPLAIN',TO_DATE('$this->TANGGAL','yyyy-mm-dd'),'$this->TIPE')");
    }
    public function update(){
        $this->db->where('KODE_LAMPIRAN', $this->KODE_LAMPIRAN);
        $this->db->update('LAMPIRAN', $this); 
    }
    public function delete(){
        $this->db->where('KODE_LAMPIRAN', $this->KODE_LAMPIRAN);
        $this->db->delete('LAMPIRAN'); 
    }
    public function deleteByKomplain(){ 
        $this->db->query('DELETE FROM LAMPIRAN WHERE NO_KOMPLAIN = '.$this->NO_KOMPLAIN);
    }
    public function deleteByKomplainForFeedback(){ 
        $this->db->query('DELETE FROM LAMPIRAN WHERE NO_KOMPLAIN = ? and TIPE=1'
        ,array($this->NO_KOMPLAIN));
    }
}