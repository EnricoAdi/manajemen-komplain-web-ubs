<?php

class TopikModel extends CI_Model
{ 
    public $TOPIK;
    public $KODE_TOPIK;
    public $DESKRIPSI;
    public $AU;
    public $DIV_TUJUAN;
    public $NAMA;
    // public $NAMA_DIVISI;
    

    public function __construct()
    {
        parent::__construct(); 
    }
    public function fetch(){ 
       return $this->db->query('SELECT T.*, D.NAMA_DIVISI FROM TOPIK T JOIN DIVISI D ON 
       D.KODE_DIVISI=T.DIV_TUJUAN')->result();
    }
    public function get($kode_topik){
        $this->db->select('*');
        $this->db->from('TOPIK');
        $this->db->where('KODE_TOPIK',$kode_topik);  
        $query = $this->db->get() 
            ->result_array();
        if(sizeof($query)>0){
            return $query[0];
        //     $result = $query[0];
        //    $newtopik =  new TopikModel();
           
        //    $newtopik->KODE_TOPIK = $result['KODE_TOPIK'];
        //    $newtopik->TOPIK = $result['TOPIK'];
        //    $newtopik->DESKRIPSI = $result['DESKRIPSI'];
        //    $newtopik->AU = $result['AU'];
        //    $newtopik->DIV_TUJUAN = $result['DIV_TUJUAN'];
        //    $newtopik->NAMA= $result['NAMA'];
        //    $newtopik->NAMA_DIVISI = $result['NAMA_DIVISI'];
        //    return $newtopik;
           
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
    } 
    public function fetchSubtopik1(){ 
       return $this->db->query('SELECT S.* FROM SUB_TOPIK1 S  where S.KODE_TOPIK = ?',
       array($this->KODE_TOPIK)
       )->result();
    }
}