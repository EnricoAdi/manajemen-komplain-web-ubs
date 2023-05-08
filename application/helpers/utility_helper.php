<?php
function asset_url()
{
  return base_url() . 'assets/';
}
function error_color()
{
  return "#A3180D";
}
function primary_color()
{
  return "#004882";
}
function secondary_color()
{
  return "#DCA71F";
}
function random_color()
{
  return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
function configToken()
{
  $cnf['exp'] = 3600; //milisecond
  $cnf['secretkey'] = 'manajemenkomplain20042023';
  return $cnf;
}
function encrypt($word)
{
  $passwordHash = password_hash($word, PASSWORD_DEFAULT);
  echo $passwordHash;
}
function generateUID($length)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $UID = '';
  for ($i = 0; $i < $length; $i++) {
    $UID .= $characters[rand(0, $charactersLength - 1)];
  }
  return $UID;
}

function die_dump($element)
{
  echo "<pre>";
  var_dump($element);
  echo "</pre>";
  die();
}

/**
 * Function ini untuk melakukan redirect ke url tujuan dengan memberikan pesan lewat modal
 */
function redirectWith($url, $message)
{
  $ci = &get_instance();

  $ci->session->set_flashdata('header', 'Pesan');
  $ci->session->set_flashdata('message', $message);
  redirect($url);
}

/**
 * Function ini untuk melakukan load view dengan template admin
 */
function loadView_Admin($view, $data)
{
  $ci = &get_instance();

  $ci->load->view("templates/admin/header", $data);
  $ci->load->view($view, $data);
  $ci->load->view("templates/admin/footer", $data);
}

/**
 * Function ini untuk melakukan load view dengan template user
 */
function loadView_User($view, $data)
{
  $ci = &get_instance();

  $ci->load->view("templates/user/header", $data);
  $ci->load->view($view, $data);
  $ci->load->view("templates/user/footer", $data);
}
function loadView_Manager($view, $data)
{
  $ci = &get_instance();

  $ci->load->view("templates/manager/header", $data);
  $ci->load->view($view, $data);
  $ci->load->view("templates/manager/footer", $data);
}
function loadView_GM($view, $data)
{
  $ci = &get_instance();

  $ci->load->view("templates/GM/header", $data);
  $ci->load->view($view, $data);
  $ci->load->view("templates/GM/footer", $data);
}

function formatDateIndo($dateString){
  $monthNames = array(
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
); 
  $parts = explode('-', $dateString);
  $formattedDate = ltrim($parts[2], '0') . ' ' . $monthNames[date('F', strtotime($dateString))] . ' ' . $parts[0];
  return $formattedDate; // contoh output: "8 Mei 2023"
}
