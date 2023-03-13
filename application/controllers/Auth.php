<?php

class Auth extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Authentication Page"; 
        $this->load->library("form_validation"); 
    }
    public function index()
    {
        //middleware 
        if($this->UsersModel->getLogin() != null){ 
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Anda sudah login');

            //dibedakan berdasarkan hak akses 
            $hak_akses = $this->UsersModel->getLogin()->KODE_HAK_AKSES;
            if ($hak_akses == '1') {  
                redirect('User/Dashboard'); //end user
            }
            if ($hak_akses == '2') { 
                redirect('Manager'); //manager
            }
            if ($hak_akses == '3') { 
                redirect('GM'); //general manager
            } else { 
                redirect('Admin/Dashboard'); //admin
            } 
        }else{ 
            $data = $this->data;
            $data['page_title'] = "Login Page";

            $this->form_validation->set_rules('nomor_induk', 'nomor_induk', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run()) {

                $nomor_induk = $this->input->post("nomor_induk");
                $password = $this->input->post("password");
                //$remember = $this->input->post("remember") != null;

                $userFound = $this->UsersModel->get($nomor_induk); 
                if ($userFound == null) {
                    $this->session->set_flashdata('header', 'Pesan');
                    $this->session->set_flashdata('message', 'Nomor Induk tidak ditemukan');

                    $this->load->view("auth/login", $data);
                } else {  
                    if (password_verify($password, $userFound->PASSWORD)) {
                        $this->session->set_flashdata('success', 'Berhasil Login');
                        $this->UsersModel->login($userFound);
                        //TODO LOGIN   
                        $hak_akses = $userFound->KODE_HAK_AKSES;

                        if ($hak_akses == '1') { 
                            
                            $this->session->set_flashdata('message','');
                            $this->session->set_flashdata('confirmation','');
                            $this->session->set_flashdata('url','');
                            redirect('User/Dashboard'); //end user
                        }
                        if ($hak_akses == '2') {
                            $this->session->set_flashdata('message','');
                            $this->session->set_flashdata('confirmation','');
                            redirect('Manager'); //manager
                        }
                        if ($hak_akses == '3') {
                            $this->session->set_flashdata('message','');
                            $this->session->set_flashdata('confirmation','');
                            redirect('GM'); //general manager
                        } else {
                            $this->session->set_flashdata('message','');
                            $this->session->set_flashdata('confirmation','');
                            redirect('Admin/Dashboard'); //admin
                        }
                    } else {
                        $this->session->set_flashdata('header', 'Pesan');
                        $this->session->set_flashdata('message', 'Password Salah');
                        $this->load->view("auth/login", $data);
                    }
                }
            } else {
                $this->load->view("auth/login", $data);
            }
        }
    }
    public function logout()
    {
        $this->UsersModel->logout(); 
        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Logout Berhasil');
        redirect('Auth');
    }

    //note 
    //set confirmation
}
