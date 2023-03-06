<?php

    class Auth extends CI_Controller {


        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Authentication Page";
            // $this->load->model('Auth_model');
        }
        public function index(){ 
            $data = $this->data;
            $data['page_title'] = "Login Page";

            
        }


    }