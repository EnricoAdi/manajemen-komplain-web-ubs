<?php
//done penyelesaian komplain yang ditujukan kepada departemen user 
class Done extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Halaman Done Penyelesaian Komplain";
        $this->data['navigation'] = "Complained";

        middleware_auth(1); //hak akses user 
        $this->data['login'] = $this->UsersModel->getLogin();

        $this->load->library("form_validation");
        $this->load->library('session');
    }
    public function index()
    {

        $data = $this->data;
        $data['page_title'] = "Halaman Done Penyelesaian Komplain";


        //fetch complain user tersebut yang statusnya PEND dan sudah ada PENUGASAN, sudah ada tindakan korektif dkk, dan belum ada TGL_DONE dan USER_DONE
        $complains = $this->KomplainAModel->fetchComplainSudahDiisi($data['login']->KODEDIV);
        $data['complains'] = $complains;

        loadView_User("user/complained/done/list", $data);
        
    }
    public function detail($nomor_komplain)
    {
        $data = $this->data;
        $data['page_title'] = "Detail Penyelesaian Komplain";

        $komplain = $this->KomplainAModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain, 'User/Complained/Done',false,true,false);

        $data['komplain'] = $komplain;

        loadView_User("user/complained/done/detail", $data); 
    }
    public function successProcess($nomor_komplain)
    { 
        $komplain = $this->KomplainAModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain, 'User/Complained/Done',false,true,false);

        $komplain->USER_DONE = $this->UsersModel->getLogin()->NOMOR_INDUK;
        $komplain->TGL_DONE =  date('Y-m-d');
        $komplain->donePenyelesaianKomplain();

        $topik = $komplain->TOPIK;
        $subtopik1 = $komplain->SUB_TOPIK1;
        $subtopik2 = $komplain->SUB_TOPIK2;
        $header = "Berhasil done penyelesaian komplain";
        $s2des = $this->SubTopik2Model->get($topik, $subtopik1, $subtopik2)->DESKRIPSI;
        $template = templateEmail(
            $header,
            $this->UsersModel->getLogin()->NAMA,
            "Sistem mencatat anda menyelesaikan pemberian feedback terhadap komplain untuk subtopik $s2des . Terima kasih atas kerja sama anda"
        );
        $resultmail = send_mail(
            $this->UsersModel->getLogin()->EMAIL,
            $header,
            $template
        );
        // $resultmail = true;

        if ($resultmail) { 
            redirectWith('User/Complained/Done', 'Berhasil done penyelesaian komplain, silahkan cek email anda');
        } else { 
            redirectWith('User/Complained/Penyelesaian', 'Berhasil done penyelesaian komplain, namun gagal mengirim email');
        }
    }
    public function deleteProcess($nomor_komplain)
    { 
        $komplain = $this->KomplainAModel->get($nomor_komplain);
        middleware_komplainA($nomor_komplain, 'User/Complained/Done',false,true,true);
 
        $komplain->deleteDeadlinePenyelesaianKomplain();
        $komplainB = new KomplainBModel();
        $komplainB->NO_KOMPLAIN = $nomor_komplain;
        $komplainB->deletePenyelesaianKomplain();

        //delete lampiran 
        $lampiran = new LampiranModel();
        $lampiran->NO_KOMPLAIN = $nomor_komplain;
        $lampiran->deleteByKomplainForFeedback();

        //todo email

        $topik = $komplain->TOPIK;
        $subtopik1 = $komplain->SUB_TOPIK1;
        $subtopik2 = $komplain->SUB_TOPIK2;
        $s2des =  $this->SubTopik2Model->get($topik, $subtopik1, $subtopik2)->DESKRIPSI;
        $header = "Berhasil delete penyelesaian komplain";
        $template = templateEmail(
            $header,
            $this->UsersModel->getLogin()->NAMA,
            "Sistem mencatat anda menghapus pemberian feedback terhadap komplain untuk subtopik $s2des"
        );
        $resultmail = send_mail(
            $this->UsersModel->getLogin()->EMAIL,
            $header,
            $template
        );
        // $resultmail = true;

        if ($resultmail) { 
            redirectWith('User/Complained/Done', 'Berhasil delete penyelesaian komplain, silahkan cek email anda');
        } else {
            redirectWith('User/Complained/Penyelesaian', 'Berhasil delete penyelesaian komplain, namun gagal mengirim email');
            
        }
    }
}
