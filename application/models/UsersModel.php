<?php

class UsersModel extends CI_Model
{
    public $NOMOR_INDUK;
    public $PASSWORD;
    public $NAMA;
    public $KODE_HAK_AKSES;
    public $EMAIL;
    public $KODEDIV;
    public $KODE_ATASAN;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    public function fetch()
    {
        return $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA AS NAMA_DIVISI FROM USERS u left join USERS a 
        on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODEDIV = u.KODEDIV")->result();
    }
    public function fetchWithoutEmail()
    {
        return $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA AS NAMA_DIVISI FROM USERS u left join USERS a 
        on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODEDIV = u.KODEDIV where u.EMAIL is null")->result();
    }
    public function fetchAtasan()
    {
        return $this->db->query("SELECT U.*,D.NAMA AS NAMA_DIVISI FROM USERS U join DIVISI D on D.KODEDIV = U.KODEDIV
        WHERE KODE_HAK_AKSES='2'")->result();
    }
    public function get($nomor_induk)
    {
        $query = $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA AS NAMA_DIVISI FROM USERS u left join USERS a 
        on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODEDIV = u.KODEDIV where u.NOMOR_INDUK = ?",
        array($nomor_induk))->result();
 
        if (sizeof($query) > 0) {
            // $user = new UsersModel();
            // $user->NOMOR_INDUK = $query[0]->NOMOR_INDUK;
            // $user->NAMA = $query[0]->NAMA;
            // $user->KODE_HAK_AKSES = $query[0]->KODE_HAK_AKSES;
            // $user->EMAIL = $query[0]->EMAIL;
            // $user->KODEDIV = $query[0]->KODEDIV;
            // $user->KODE_ATASAN = $query[0]->KODE_ATASAN;
            // $user->NAMA_ATASAN = $query[0]->NAMA_ATASAN;
            // $user->EMAIL_ATASAN = $query[0]->EMAIL_ATASAN; 
            return $query[0];
        }
        return null;
    }
    public function fetchUsersByDivisi($KODEDIV, $kode_hak_akses){
        if($kode_hak_akses=='all'){ 
            return $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA AS NAMA_DIVISI FROM USERS u left join USERS a 
            on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODEDIV = u.KODEDIV where u.KODEDIV = ?",
            array($KODEDIV))->result();
        }else{ 
            return $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA AS NAMA_DIVISI FROM USERS u left join USERS a 
            on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODEDIV = u.KODEDIV where u.KODEDIV = ? and u.KODE_HAK_AKSES = ?",
            array($KODEDIV,$kode_hak_akses))->result();
        }
    }
    public function login($user)
    {
        $this->session->set_userdata('user_login', $user);
    }
    public function logout()
    {
        $this->session->unset_userdata('user_login');
    }
    public function getLogin()
    {
        return $this->session->userdata('user_login');
    }
    public function divisi()
    {
        $this->load->model('DivisiModel');
        return $this->DivisiModel->get($this->KODEDIV);
    }
    public function hak_akses()
    {
        $this->load->model('HakAksesModel');
        return $this->HakAksesModel->get($this->KODE_HAK_AKSES);
    }
    
    public function insert(){
        $this->db->insert('USERS', $this); 
    }

    public function update()
    {
        $this->db->where('NOMOR_INDUK', $this->NOMOR_INDUK);
        $this->db->update('USERS', $this);
    } 

    public function delete(){
        $this->db->where('NOMOR_INDUK', $this->NOMOR_INDUK);
        $this->db->delete('USERS');  
    } 
    public function addEmail()
    {
        $this->db->query(
            "UPDATE USERS SET EMAIL= ?, KODE_ATASAN = ? WHERE NOMOR_INDUK = ?",
            array($this->EMAIL, $this->KODE_ATASAN, $this->NOMOR_INDUK)
        );
    }
    public function resetEmail(){ 
        $this->db->query(
            "UPDATE USERS SET EMAIL= null, KODE_ATASAN = null WHERE NOMOR_INDUK = ?",
            array($this->NOMOR_INDUK)
        );
    } 
    public function checkEmailExist($email)
    {
        $this->db->select('*');
        $this->db->from('USERS');
        $this->db->where('EMAIL', $email);
        $query = $this->db->get()
            ->result_array();
        if (sizeof($query) > 0) {
            return true;
        }
        return false;
    }
}
