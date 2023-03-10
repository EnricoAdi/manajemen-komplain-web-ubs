<?php
//Master Subtopik 1 Admin 
class Subtopik1 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Halaman Master Subtopik1 Admin";

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
        $data['page_title'] = "Master";
        $data['login'] = $this->UsersModel->getLogin();

        $subtopics = $this->SubTopik1Model->fetch();
        $data['subtopics'] = $subtopics;  
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/subtopik1/index", $data);
        $this->load->view("templates/admin/footer", $data);
    } 
    public function Add()
    {
        $data = $this->data;
        $data['page_title'] = "Master";
        $data['list_topik'] = $this->TopikModel->fetch();
        $data['login'] = $this->UsersModel->getLogin();
 
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/subtopik1/add", $data);
        $this->load->view("templates/admin/footer", $data);
    }
    public function AddProcess()
    { 
        $newkode = $this->SubTopik1Model->getNewKode(); 
        $topik = strtoupper($this->input->post("topik")); 
        $deskripsi = $this->input->post("deskripsi");
         
        $newSubTopik1 = new SubTopik1Model();
        $newSubTopik1->KODE_TOPIK = $topik;
        $newSubTopik1->SUB_TOPIK1 = $newkode;
        $newSubTopik1->DESKRIPSI = $deskripsi; 
        $newSubTopik1->insert();
        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Menambahkan Subtopik 1 ');
        redirect('Admin/Master/Subtopik1');
    }
    public function Detail($kode)
    {
        $data = $this->data;
        $data['page_title'] = "Master";
        $data['list_topik'] = $this->TopikModel->fetch();
        $data['login'] = $this->UsersModel->getLogin();

        $subtopic = $this->SubTopik1Model->get($kode);
        $data['subtopic'] = $subtopic; 
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/Subtopik1/edit", $data);
        $this->load->view("templates/admin/footer", $data);
    }

    public function EditProcess($kode)
    {
        $topik = strtoupper($this->input->post("topik")); 
        $deskripsi = $this->input->post("deskripsi");

        $updateSubtopik = new SubTopik1Model();
        $updateSubtopik->SUB_TOPIK1 = $kode;
        $updateSubtopik->KODE_TOPIK = $topik; 
        $updateSubtopik->DESKRIPSI = $deskripsi;
        $updateSubtopik->update();

        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Mengubah Subtopik 1 ');
        redirect('Admin/Master/Subtopik1');
    }

    public function DeleteProcess($kode)
    {

        $subtopik1Delete = new SubTopik1Model();
        $subtopik1Delete->SUB_TOPIK1 = $kode; 

        $jumlahSubtopik2 = sizeof($subtopik1Delete->fetchSubtopik2());
        if ($jumlahSubtopik2 > 0) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Gagal Menghapus Subtopik1, Karena Subtopik Ini Memiliki Subtopik 2 aktif');
            redirect('Admin/Master/Subtopik1/Detail/' . $kode);
        } else {

            $subtopik1Delete->delete();

            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil Menghapus Subtopik 1 ');
            redirect('Admin/Master/Subtopik1');
        }
    }
}
