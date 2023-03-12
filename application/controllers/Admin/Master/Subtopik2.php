<?php
//Master Subtopik 2 Admin 
class Subtopik2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Halaman Master Subtopik2 Admin";
        $this->data['navigation'] = "Master"; 

        $this->load->library("form_validation");

        //code ini digunakan untuk menjadi sebuah midlleware jika user mencoba akses halaman ini tanpa login
        if ($this->UsersModel->getLogin() == null) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
            redirect('Auth');
        }

        //jika tidak ada akses, maka redirect ke halaman dashboard berdasarkan hak aksesnya
        $hak_akses = $this->UsersModel->getLogin()['KODE_HAK_AKSES'];
        if ($hak_akses != 4) {
            if ($hak_akses == '1') {
                redirect('User/Dashboard'); //end user
            }
            if ($hak_akses == '2') {
                redirect('Manager'); //manager
            } else {
                redirect('GM'); //general manager
            }
        }
    }

    public function index()
    {
        //halaman ini digunakan untuk menampilkan daftar subtopik1 yang ada
        $data = $this->data;
        $data['page_title'] = "Master Subtopik 2";
        $data['login'] = $this->UsersModel->getLogin();

        $subtopics = $this->SubTopik2Model->fetch();
        $data['subtopics'] = $subtopics;  
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/subtopik2/index", $data);
        $this->load->view("templates/admin/footer", $data);
    } 
    public function Add()
    {
        $data = $this->data;
        $data['page_title'] = "Tambah Subtopik 2";
        // $data['list_topik'] = $this->TopikModel->fetch();
        $data['list_subtopik1'] = $this->SubTopik1Model->fetch();
        $data['login'] = $this->UsersModel->getLogin();
         
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/subtopik2/add", $data);
        $this->load->view("templates/admin/footer", $data);
    }
    public function AddProcess()
    { 
        $newkode = $this->SubTopik2Model->getNewKode(); 
        $kode_topik = strtoupper($this->input->post("inputKodeTopik")); 
        $subtopik1 = strtoupper($this->input->post("inputKodeSubtopik1"));  
        $deskripsi = $this->input->post("deskripsi");
         
        $newSubTopik2 = new SubTopik2Model();
        $newSubTopik2->KODE_TOPIK = $kode_topik;
        $newSubTopik2->SUB_TOPIK1 = $subtopik1;
        $newSubTopik2->SUB_TOPIK2 = $newkode;
        $newSubTopik2->DESKRIPSI = $deskripsi; 
        $newSubTopik2->insert();
        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Menambahkan Subtopik 2 ');
        redirect('Admin/Master/Subtopik2');
    }
    public function Detail($kode)
    {
        $data = $this->data;
        $data['page_title'] = "Detail Subtopik 2 Master";
        $data['list_subtopik1'] = $this->SubTopik1Model->fetch();
        $data['login'] = $this->UsersModel->getLogin();

        $subtopic = $this->SubTopik2Model->get($kode); 
        $data['subtopic'] = $subtopic;
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/Subtopik2/edit", $data);
        $this->load->view("templates/admin/footer", $data);
    }

    public function EditProcess($kode)
    { 
        $kode_topik = strtoupper($this->input->post("inputKodeTopik")); 
        $subtopik1 = strtoupper($this->input->post("inputKodeSubtopik1"));  
        $deskripsi = $this->input->post("deskripsi");
         

        $updateSubtopik2 = new SubTopik2Model();
        $updateSubtopik2->KODE_TOPIK = $kode_topik;
        $updateSubtopik2->SUB_TOPIK1 = $subtopik1;
        $updateSubtopik2->SUB_TOPIK2 = $kode;
        $updateSubtopik2->DESKRIPSI = $deskripsi;  
        $updateSubtopik2->update();

        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Mengubah Subtopik 2 ');
        redirect('Admin/Master/Subtopik2');
    }

    public function DeleteProcess($kode)
    {

        $subtopik2Delete = new SubTopik2Model();
        $subtopik2Delete->SUB_TOPIK2 = $kode; 

        $jumlahKomplain = sizeof($subtopik2Delete->fetchKomplain());
        if ($jumlahKomplain > 0) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Gagal Menghapus Subtopik2, Karena Subtopik ini memiliki komplain aktif');
            redirect('Admin/Master/Subtopik2/Detail/' . $kode);
        } else {

            $subtopik2Delete->delete();

            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil Menghapus Subtopik 2 ');
            redirect('Admin/Master/Subtopik2');
        }
    }
}
