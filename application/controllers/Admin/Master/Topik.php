<?php
//Master Topik Admin 
class Topik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Halaman Master Topik Admin";
        $this->data['navigation'] = "Master"; 

        $this->load->library("form_validation");
 
        middleware_auth(4); //hak akses admin
    }

    public function index()
    {
        //halaman ini digunakan untuk menampilkan daftar topik yang ada
        $data = $this->data;
        $data['page_title'] = "Master Topik";
        $data['login'] = $this->UsersModel->getLogin();

        $topics = $this->TopikModel->fetch();
        $data['topics'] = $topics;

        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/topik/index", $data);
        $this->load->view("templates/admin/footer", $data);
    }
    public function Menu()
    {
        //controller ini digunakan untuk menampilkan menu master topik, nantinya 
        //dari menu ini akan diarahkan ke halaman lain sesuai dengan menu yang dipilih
        $data = $this->data;
        $data['page_title'] = "Menu Master Topik";
        $data['login'] = $this->UsersModel->getLogin();

        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/topik/menu", $data);
        $this->load->view("templates/admin/footer", $data);
    }
    public function Add()
    {
        //controller ini digunakan untuk menampilkan halaman input topik
        $data = $this->data;
        $data['page_title'] = "Input Topik";
        $data['list_divisi'] = $this->DivisiModel->fetch();
        $data['login'] = $this->UsersModel->getLogin();
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/topik/add", $data);
        $this->load->view("templates/admin/footer", $data);
    }
    public function AddProcess()
    {
        //controller ini digunakan untuk memproses form tambahan topik
        $topik = strtoupper($this->input->post("topik"));
        $divisi = $this->input->post("divisi");
        $nama = $this->input->post("nama");
        $deskripsi = $this->input->post("deskripsi");

        $kode = $this->TopikModel->getNewKode($topik, $divisi);
        $newTopik = new TopikModel();
        $newTopik->KODE_TOPIK = $kode;
        $newTopik->AU = 'T';
        $newTopik->NAMA = $nama;
        $newTopik->DIV_TUJUAN = $divisi;
        $newTopik->DESKRIPSI = $deskripsi;
        $newTopik->TOPIK = $topik;

        $newTopik->insert();
        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Menambahkan Topik ');
        redirect('Admin/Master/Topik');
    }
    public function Detail($kode)
    {
        //controller ini digunakan untuk menampilkan halaman detail topik
        $data = $this->data;
        $data['page_title'] = "Detail Topik";
        $data['list_divisi'] = $this->DivisiModel->fetch();
        $data['login'] = $this->UsersModel->getLogin();

        $topik = $this->TopikModel->get($kode);
        $data['topic'] = $topik;

        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/topik/edit", $data);
        $this->load->view("templates/admin/footer", $data);
    }

    public function EditProcess($kode)
    {
        //controller ini digunakan untuk memproses edit topik
        $topik =  $this->input->post("topik");
        $divisi = $this->input->post("divisi");
        $nama = $this->input->post("nama");
        $deskripsi = $this->input->post("deskripsi");

        $updateTopik = new TopikModel();
        $updateTopik->KODE_TOPIK = $kode;
        $updateTopik->AU = 'T';
        $updateTopik->NAMA = $nama;
        $updateTopik->DIV_TUJUAN = $divisi;
        $updateTopik->DESKRIPSI = $deskripsi;
        $updateTopik->TOPIK = $topik;
        $updateTopik->update();

        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Mengubah Topik ');
        redirect('Admin/Master/Topik');
    }

    public function DeleteProcess($kode)
    {
        //controller ini digunakan untuk menghapus topik
        $topikDelete = new TopikModel();
        $topikDelete->KODE_TOPIK = $kode;


        $jumlahSubtopik1 = sizeof($topikDelete->fetchSubtopik1());
        if ($jumlahSubtopik1 > 0) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Gagal Menghapus Topik, Karena Topik Ini Memiliki Subtopik');
            redirect('Admin/Master/Topik/Detail/' . $kode);
        } else {

            $topikDelete->delete();

            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil Menghapus Topik ');
            redirect('Admin/Master/Topik');
        }
    }
}
