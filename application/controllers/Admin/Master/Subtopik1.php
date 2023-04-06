<?php
//Master Subtopik 1 Admin 
class Subtopik1 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Halaman Master Subtopik1 Admin";
        $this->data['navigation'] = "Master"; 

        $this->load->library("form_validation");

        //code ini digunakan untuk menjadi sebuah midlleware jika user mencoba akses halaman ini tanpa login
        if ($this->UsersModel->getLogin() == null) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
            redirect('Auth');
        }

        //jika tidak ada akses, maka redirect ke halaman dashboard berdasarkan hak aksesnya
        $hak_akses = $this->UsersModel->getLogin()->KODE_HAK_AKSES;
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
        $data['page_title'] = "Master Subtopik 1";
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
        $data['page_title'] = "Insert Subtopik 1";
        $data['list_topik'] = $this->TopikModel->fetch();
        $data['login'] = $this->UsersModel->getLogin();
 
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/subtopik1/add", $data);
        $this->load->view("templates/admin/footer", $data);
    }
    public function AddProcess()
    { 
        $topik = strtoupper($this->input->post("topik")); 
        $newkode = $this->SubTopik1Model->getNewKode($topik); 
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
    public function Detail($kodetopik,$kodesubtopik1)
    {
        $data = $this->data;
        $data['page_title'] = "Detail Subtopik 1 Master";
        $data['list_topik'] = $this->TopikModel->fetch();
        $data['login'] = $this->UsersModel->getLogin();

        $subtopic = $this->SubTopik1Model->get($kodesubtopik1,$kodetopik);
        if($subtopic==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Subtopik 1 Tidak Ditemukan');
            redirect('Admin/Master/Subtopik1');
        }

        $data['subtopic'] = $subtopic; 
        $this->load->view("templates/admin/header", $data);
        $this->load->view("admin/master/Subtopik1/edit", $data);
        $this->load->view("templates/admin/footer", $data);
    }

    public function EditProcess($kodetopik,$kodesubtopik1)
    {
        // $topik = strtoupper($this->input->post("topik")); 
        $deskripsi = $this->input->post("deskripsi");

        $updateSubtopik = new SubTopik1Model();
        $updateSubtopik->SUB_TOPIK1 = $kodesubtopik1;
        $updateSubtopik->KODE_TOPIK = $kodetopik; 
        $updateSubtopik->DESKRIPSI = $deskripsi;
        $updateSubtopik->update();

        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Mengubah Subtopik 1 ');
        redirect('Admin/Master/Subtopik1');
    }

    public function DeleteProcess($kodetopik,$kodesubtopik1)
    { 
        $subtopik1Delete = new SubTopik1Model();
        $subtopik1Delete->SUB_TOPIK1 = $kodesubtopik1; 
        $subtopik1Delete->KODE_TOPIK = $kodetopik; 

        $jumlahSubtopik2 = sizeof($subtopik1Delete->fetchSubtopik2());
        if ($jumlahSubtopik2 > 0) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Gagal Menghapus Subtopik1, Karena Subtopik Ini Memiliki Subtopik 2 aktif');
            redirect("Admin/Master/Subtopik1/Detail/$kodetopik/$kodesubtopik1");
        } else {

            $subtopik1Delete->delete();

            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil Menghapus Subtopik 1 ');
            redirect('Admin/Master/Subtopik1');
        }
    }
}
