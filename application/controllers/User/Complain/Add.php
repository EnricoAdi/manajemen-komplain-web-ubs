<?php 
    //input komplain baru diajukan user 
    class Add extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "User Page";
            $this->data['navigation'] = "Complain";  

            $this->load->model('UsersModel');
            $this->load->library("form_validation");  
            $this->load->library('session'); 
            $this->load->library('upload');

            //middleware
            if($this->UsersModel->getLogin() == null){ 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
                redirect('Auth');
            }

            //jika tidak ada akses, maka redirect ke halaman dashboard berdasarkan hak aksesnya
            $hak_akses = $this->UsersModel->getLogin()->KODE_HAK_AKSES;
            if($hak_akses!=1){
                if ($hak_akses == '4') {  
                    redirect('Admin/Dashboard'); //admin
                }
                if ($hak_akses == '2') { 
                    redirect('Manager'); //manager
                }
                else { 
                    redirect('GM'); //general manager
                }
            }

        }
        
        public function page($page){
            $data = $this->data;
            $data['page_title'] = "Tambah Komplain Baru";
            $data['login'] = $this->UsersModel->getLogin();

            //todo fetch complain user tersebut
            
            if($page==1){ 
                //dapatkan input lama kalau ada
                $data['subtopik2PreSended'] = $this->session->userdata('subtopik2PreSended');
                $data['tanggalPreSended'] = $this->session->userdata('tanggalPreSended');

                //dapetkan 14 hari yg lalu

                $data['tanggalMin'] = date('Y-m-d', strtotime('-14 days'));
                $data['tanggalSekarang'] = date('Y-m-d');

                //ambil data subtopik 2, subtopik 1, dan complain selain divisi tersebut
                $subtopics = $this->SubTopik2Model->fetchSubtopikAll($data['login']->KODE_DIVISI,false); 
                $data['subtopics'] = $subtopics;
                // echo "<pre>";
                // var_dump($subtopics);
                // echo "</pre>";
                $this->load->view("templates/user/header", $data);
                $this->load->view("user/complain/add/input-topic", $data);
                $this->load->view("templates/user/footer", $data);
            }else{
                $subtopik2 =  $this->session->userdata('subtopik2PreSended');
                if($subtopik2==null){
                    redirect('User/Complain/Add/page/1');
                }
                $data['subtopik2PreSended'] = $subtopik2;
                $data['topikShow'] = $subtopik2;
                $data['tanggalPreSended'] = $this->session->userdata('tanggalPreSended');
             
                $subtopics = $this->SubTopik2Model->fetchSubtopikAll($data['login']->KODE_DIVISI,false); 
                foreach ($subtopics as $subtopik) {
                    if($subtopik->SUB_TOPIK2==$subtopik2){  
                        $data['topikShow'] = "$subtopik->KODE_TOPIK - $subtopik->SUB_TOPIK1 - $subtopik->S2DESKRIPSI";
                    }
                }
                $this->load->view("templates/user/header", $data);
                $this->load->view("user/complain/add/input-detail", $data);
                $this->load->view("templates/user/footer", $data);
            }
 
        } 

        public function pageProcess1(){
            $topik =  $this->input->post("inputTopik");
            $subtopik1 =  $this->input->post("inputSubtopik1");
            $subtopik2 =  $this->input->post("inputSubtopik2");
            $tanggal =  $this->input->post("tanggal");

            //cek date
            
            $tanggalMin = date('Y-m-d', strtotime('-14 days'));
            if($tanggal < $tanggalMin){
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Tanggal tidak boleh lebih dari 14 hari');
                redirect('User/Complain/Add/page/1');
            }
            //untuk menampung data sebelum dikirim
            $this->session->set_userdata('tanggalPreSended', $tanggal);
            $this->session->set_userdata('subtopik2PreSended', $subtopik2);
            $this->session->set_userdata('subtopik1PreSended', $subtopik1);
            $this->session->set_userdata('topikPreSended', $topik);
            redirect('User/Complain/Add/page/2');
        }

        public function addComplainProcess(){ 
            $topik =  $this->session->userdata('topikPreSended');
            $subtopik1 = $this->session->userdata('subtopik1PreSended');
            $subtopik2 =  $this->session->userdata('subtopik2PreSended');
            $tanggal = $this->session->userdata('tanggalPreSended');

            $lampiran = $_FILES["lampiran"];
            $deskripsi = $this->input->post("deskripsi");
            $feedback = $this->input->post("feedback"); 
            
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $getNewFileName = 'L';
            for ($i = 0; $i < 25; $i++) {
                $getNewFileName .= $characters[rand(0, $charactersLength - 1)];
            }  
            if($lampiran['name']!=''){ 
                if (!file_exists('./uploads/')) {
                    mkdir('./uploads/', 0777, true);
                }
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|txt';
                $config['max_size'] = 5000; // in Kilobytes
                $config['file_name'] = $getNewFileName;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('lampiran')) {
                    // Handle upload error
                    $error = $this->upload->display_errors();
                    echo $error;
                    // echo FCPATH.'uploads/';
                } else {
                    // Upload success
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];
                    echo "File $file_name has been uploaded successfully!";
                }
            }
        }
    }
?>

