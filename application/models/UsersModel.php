<?php

class UsersModel extends CI_Model
{ 
    public $NOMOR_INDUK;
    public $PASSWORD;
    public $NAMA;
    public $KODE_HAK_AKSES;
    public $EMAIL;
    public $KODE_DIVISI;
    public $KODE_ATASAN; 

    public function __construct()
    {
        parent::__construct(); 
        $this->load->library('session'); 
    }
    public function fetch(){
       return $this->db->get('USERS')->result();
    }
    public function get($nomor_induk){
        $this->db->select('*');
        $this->db->from('USERS');
        $this->db->where('NOMOR_INDUK',$nomor_induk);  
        $query = $this->db->get() 
            ->result_array();
        if(sizeof($query)>0){
            return $query[0];
        }
        return null;
    } 
    public function login($user){
        $this->session->set_userdata('user_login', $user); 
    }
    public function logout(){
        $this->session->unset_userdata('user_login');
    }
    public function getLogin(){ 
        return $this->session->userdata('user_login');
    }
    public function divisi(){
        $this->load->model('DivisiModel');
        return $this->DivisiModel->get($this->KODE_DIVISI);
    }
    public function hak_akses(){
        $this->load->model('HakAksesModel');
        return $this->HakAksesModel->get($this->KODE_HAK_AKSES);
    }
}