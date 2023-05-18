<?php
//list komplain yang ditujukan kepada user 
class ListComplained extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->data['page_title'] = "User Page";
    $this->data['navigation'] = "ComplainedList";

    middleware_auth(1); //hak akses user 
    $this->data['login'] = $this->UsersModel->getLogin();

    $this->load->library("form_validation");
    $this->load->library('session');
  }

  /**Daftar komplain diterima adalah fitur yang digunakan untuk mendapatkan semua komplain yang diterima oleh sebuah divisi, yang statusnya open. Function ini dapat dijalankan di controller ListComplained pada direktori Complained. */
  public function index()
  {
    $data = $this->data;
    $data['page_title'] = "Daftar Komplain Diterima";

    //fetch complain user tersebut

    $complains = $this->KomplainAModel->fetchForDivisi($data['login']->KODEDIV, 'OPEN');
    
    $data['complains'] = $complains;

    loadView_User("user/complained/index", $data);
  }
  
  /**Verifikasi komplain diterima adalah fitur yang digunakan untuk memverifikasi sebuah komplain yang diterima oleh sebuah divisi, secara khusus yang statusnya open. Function ini dapat dijalankan di controller ListComplained pada direktori Complained. Setelah komplain di verifikasi, sebuah divisi dapat menentukan user yang bertugas untuk memberikan penyelesaian komplain. */
  public function VerifikasiComplain($nomor_komplain)
  {

    $komplain = $this->KomplainAModel->get($nomor_komplain);
    $user_penerbit = $this->UsersModel->get($komplain->USER_PENERBIT);
    $divisi = $user_penerbit->NAMA_DIVISI;

    middleware_komplainA($nomor_komplain, 'User/Complained/ListComplained', false, true, false);

    $komplain->USER_VERIFIKASI = $this->UsersModel->getLogin()->NOMOR_INDUK;
    $komplain->TGL_VERIFIKASI = date('Y-m-d');
    $komplain->updateVerifikasi();


    $message = "Sistem mencatat anda telah memverifikasi komplain dari divisi $divisi terkait $komplain->DESKRIPSI_MASALAH. Silahkan melengkapi penugasan untuk penyelesaian komplain ini";

    $template = templateEmail("Notifikasi Berhasil Verifikasi Komplain", $this->UsersModel->getLogin()->NAMA, $message);

    $resultmail = send_mail(
      $this->UsersModel->getLogin()->EMAIL,
      'Notifikasi Berhasil Verifikasi Komplain',
      $template
    );

    if ($resultmail) {
      redirectWith('User/Complained/ListComplained', 'Berhasil Verifikasi komplain, silakan cek email anda');
    } else {
      redirectWith('User/Complained/ListComplained', 'Berhasil Verifikasi komplain, namun gagal mengirim email');
    }
  }
}
