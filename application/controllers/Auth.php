<?php

    class Auth extends CI_Controller {


        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Authentication Page";
            $this->load->model('UsersModel');
            $this->load->library("form_validation");
        }
        public function index(){ 
            $data = $this->data;
            $data['page_title'] = "Login Page"; 
            
        $this->form_validation->set_rules('nomor_induk', 'nomor_induk', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        if ($this->form_validation->run()) {

            $nomor_induk = $this->input->post("nomor_induk");
            $password = $this->input->post("password"); 
            $userFound = $this->UsersModel->get($nomor_induk);
            if ($userFound == null) { 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Username tidak ditemukan');

                $this->load->view("home/login", $data);
            } else {
                if (password_verify($password, $userFound['PASSWORD'])) { 
                    $this->session->set_flashdata('success', 'Berhasil Login');
                    $this->UsersModel->login($userFound);
 
                    //TODO LOGIN
                    // redirect(base_url("home/temp"));
                } else { 
                    $this->session->set_flashdata('header', 'Pesan');
                    $this->session->set_flashdata('message', 'Password Salah');
                    $this->load->view("home/login", $data);
                }
            }
        } else {
            $this->load->view("home/login", $data);
        }
        }


    }