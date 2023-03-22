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
    public function fetch()
    {
        return $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA_DIVISI FROM USERS u left join USERS a 
        on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODE_DIVISI = u.KODE_DIVISI")->result();
    }
    public function fetchWithoutEmail()
    {
        return $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA_DIVISI FROM USERS u left join USERS a 
        on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODE_DIVISI = u.KODE_DIVISI where u.EMAIL is null")->result();
    }
    public function fetchAtasan()
    {
        return $this->db->query("SELECT U.*,D.NAMA_DIVISI FROM USERS U join DIVISI D on D.KODE_DIVISI = U.KODE_DIVISI
        WHERE KODE_HAK_AKSES='2'")->result();
    }
    public function get($nomor_induk)
    {
        $query = $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA_DIVISI FROM USERS u left join USERS a 
        on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODE_DIVISI = u.KODE_DIVISI where u.NOMOR_INDUK = ?",
        array($nomor_induk))->result();
 
        if (sizeof($query) > 0) {
            return $query[0];
        }
        return null;
    }
    public function fetchUsersByDivisi($kode_divisi, $kode_hak_akses){
        if($kode_hak_akses=='all'){ 
            return $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA_DIVISI FROM USERS u left join USERS a 
            on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODE_DIVISI = u.KODE_DIVISI where u.KODE_DIVISI = ?",
            array($kode_divisi))->result();
        }else{ 
            return $this->db->query("SELECT u.*, a.NAMA as NAMA_ATASAN, a.EMAIL as EMAIL_ATASAN, d.NAMA_DIVISI FROM USERS u left join USERS a 
            on a.NOMOR_INDUK = u.KODE_ATASAN left join DIVISI d on d.KODE_DIVISI = u.KODE_DIVISI where u.KODE_DIVISI = ? and u.KODE_HAK_AKSES = ?",
            array($kode_divisi,$kode_hak_akses))->result();
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
        return $this->DivisiModel->get($this->KODE_DIVISI);
    }
    public function hak_akses()
    {
        $this->load->model('HakAksesModel');
        return $this->HakAksesModel->get($this->KODE_HAK_AKSES);
    }
    public function update()
    {
        $this->db->where('NOMOR_INDUK', $this->NOMOR_INDUK);
        $this->db->update('USERS', $this);
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
