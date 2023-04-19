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
 
        middleware_auth(4); //hak akses admin
    }
    public function fetch(){ 
        $subtopics = $this->SubTopik2Model->fetch();
        $res = new stdClass();
        $res->data = $subtopics; 
        echo json_encode($res);
    }
    public function index()
    {
        //halaman ini digunakan untuk menampilkan daftar subtopik1 yang ada
        $data = $this->data;
        $data['page_title'] = "Master Subtopik 2";
        $data['login'] = $this->UsersModel->getLogin();

        $subtopics = $this->SubTopik2Model->fetch();
        $data['subtopics'] = $subtopics;  
        loadView_Admin("admin/master/subtopik2/index", $data); 
    } 
    public function Add()
    {
        $data = $this->data;
        $data['page_title'] = "Tambah Subtopik 2";
        // $data['list_topik'] = $this->TopikModel->fetch();
        $data['list_subtopik1'] = $this->SubTopik1Model->fetch();
        $data['login'] = $this->UsersModel->getLogin();
          
        loadView_Admin("admin/master/subtopik2/add", $data);
    }
    public function AddProcess()
    { 
        $kode_topik = strtoupper($this->input->post("inputKodeTopik")); 
        $subtopik1 = strtoupper($this->input->post("inputKodeSubtopik1"));  
        $newkode = $this->SubTopik2Model->getNewKode($kode_topik,$subtopik1); 
        $deskripsi = $this->input->post("deskripsi");
            
        $newSubTopik2 = new SubTopik2Model();
        $newSubTopik2->KODE_TOPIK = $kode_topik;
        $newSubTopik2->SUB_TOPIK1 = $subtopik1;
        $newSubTopik2->SUB_TOPIK2 = $newkode;
        $newSubTopik2->DESKRIPSI = $deskripsi; 
        $newSubTopik2->AKTIF = '1'; 
        $newSubTopik2->insert();
        
        redirectWith('Admin/Master/Subtopik2', 'Berhasil Menambahkan Subtopik 2');
    }
    public function Detail($kode_topik,$kode_subtopik1,$kode_subtopik2)
    {
        $data = $this->data;
        $data['page_title'] = "Detail Subtopik 2 Master";
        $data['list_subtopik1'] = $this->SubTopik1Model->fetch();
        $data['login'] = $this->UsersModel->getLogin();

        $subtopic = $this->SubTopik2Model->get($kode_topik,$kode_subtopik1,$kode_subtopik2); 
        $data['subtopic'] = $subtopic;

        loadView_Admin("admin/master/Subtopik2/edit", $data); 
    }

    public function EditProcess($kode_topik,$kode_subtopik1,$kode_subtopik2)
    { 
        // $kode_topik = strtoupper($this->input->post("inputKodeTopik")); 
        // $subtopik1 = strtoupper($this->input->post("inputKodeSubtopik1"));  
        $deskripsi = $this->input->post("deskripsi");
          
        $updateSubtopik2 = new SubTopik2Model();
        $updateSubtopik2->KODE_TOPIK = $kode_topik;
        $updateSubtopik2->SUB_TOPIK1 = $kode_subtopik1;
        $updateSubtopik2->SUB_TOPIK2 = $kode_subtopik2;
        $updateSubtopik2->DESKRIPSI = $deskripsi;  
        $updateSubtopik2->update();
 
        redirectWith('Admin/Master/Subtopik2', 'Berhasil Mengubah Subtopik 2');
    }

    public function DeleteProcess($kode_topik,$kode_subtopik1,$kode_subtopik2)
    {

        $subtopik2Delete = new SubTopik2Model();
        $subtopik2Delete->KODE_TOPIK = $kode_topik;
        $subtopik2Delete->SUB_TOPIK1 = $kode_subtopik1;
        $subtopik2Delete->SUB_TOPIK2 = $kode_subtopik2;

        $jumlahKomplain = sizeof($subtopik2Delete->fetchKomplain());
        if ($jumlahKomplain > 0) {
            redirectWith("Admin/Master/Subtopik2/Detail/$kode_topik/$kode_subtopik1/$kode_subtopik2", 'Gagal Menghapus Subtopik2, Karena Subtopik ini memiliki komplain aktif');  
        } else { 
            $subtopik2Delete->delete(); 
            redirectWith('Admin/Master/Subtopik2', 'Berhasil Menghapus Subtopik 2');
        }
    }
}
