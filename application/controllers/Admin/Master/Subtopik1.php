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

        middleware_auth(4); //hak akses admin
    }

    public function index()
    {
        //halaman ini digunakan untuk menampilkan daftar subtopik1 yang ada
        $data = $this->data;
        $data['page_title'] = "Master Subtopik 1";
        $data['login'] = $this->UsersModel->getLogin();

        $subtopics = $this->SubTopik1Model->fetch();
        $data['subtopics'] = $subtopics;  
        loadView_Admin("admin/master/subtopik1/index", $data); 
    } 
    public function Add()
    {
        $data = $this->data;
        $data['page_title'] = "Insert Subtopik 1";
        $data['list_topik'] = $this->TopikModel->fetch();
        $data['login'] = $this->UsersModel->getLogin();
 
        loadView_Admin("admin/master/subtopik1/add", $data);  
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
        
        redirectWith('Admin/Master/Subtopik1','Berhasil Menambahkan Subtopik 1');
    }
    public function Detail($kodetopik,$kodesubtopik1)
    {
        $data = $this->data;
        $data['page_title'] = "Detail Subtopik 1 Master";
        $data['list_topik'] = $this->TopikModel->fetch();
        $data['login'] = $this->UsersModel->getLogin();

        $subtopic = $this->SubTopik1Model->get($kodetopik,$kodesubtopik1);
        if($subtopic==null){
            redirectWith('Admin/Master/Subtopik1','Subtopik 1 Tidak Ditemukan');
        }

        $data['subtopic'] = $subtopic; 
        
        loadView_Admin("admin/master/Subtopik1/edit", $data);  
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
 
        redirectWith("Admin/Master/Subtopik1","Berhasil Mengubah Subtopik 1");
    }

    public function DeleteProcess($kodetopik,$kodesubtopik1)
    { 
        $subtopik1Delete = new SubTopik1Model();
        $subtopik1Delete->SUB_TOPIK1 = $kodesubtopik1; 
        $subtopik1Delete->KODE_TOPIK = $kodetopik; 

        $jumlahSubtopik2 = sizeof($subtopik1Delete->fetchSubtopik2());
        if ($jumlahSubtopik2 > 0) {
            redirectWith("Admin/Master/Subtopik1/Detail/$kodetopik/$kodesubtopik1", 'Gagal Menghapus Subtopik1, Karena Subtopik Ini Memiliki Subtopik 2 aktif');  
        } else { 
            $subtopik1Delete->delete();
 
            redirectWith("Admin/Master/Subtopik1", 'Berhasil Menghapus Subtopik 1');
        }
    }
}
