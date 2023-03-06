<?php

class KomplainAModel extends CI_Model
{ 
    public $NO_KOMPLAIN;
    public $TOPIK;
    public $SUB_TOPIK1;
    public $SUB_TOPIK2;
    public $TGL_KEJADIAN;
    public $TGL_TERBIT;
    public $TGL_VERIFIKASI;
    public $USER_VERIFIKASI;
    public $TGL_CANCEL;
    public $USER_CANCEL;
    public $TGL_BANDING;
    public $USER_BANDING;
    public $TGL_VALIDASI;
    public $USER_VALIDASI;
    public $PENUGASAN;
    public $STATUS;
    public $TGL_PENANGANAN;
    public $USER_PENANGANAN;
    public $TGL_DEADLINE;
    public $TGL_DONE;
    public $USER_DONE;
    public $USER_PENERBIT;
        

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){
       return $this->db->get('KOMPLAINA')->result();
    }
    public function get($no_komplain){
        $this->db->select('*');
        $this->db->from('KOMPLAINA');
        $this->db->where('NO_KOMPLAIN',$no_komplain);  
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
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->update('KOMPLAINA', $this); 
    }
    public function delete(){
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->delete('KOMPLAINA'); 
    }
}