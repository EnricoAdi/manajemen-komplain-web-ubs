<?php
function asset_url(){
   return base_url().'assets/';
}
function error_color(){
   return "#ff5447";
}
function primary_color(){
   return "#004882";
}
function configToken(){
   $cnf['exp'] = 3600; //milisecond
   $cnf['secretkey'] = 'manajemenkomplain15032023';
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
 

 
function send_mail($recipientEmail, $subject, $message){
   $ci =& get_instance();
   $ci->email->from('trialmkomplainubs@gmail.com', 'UBS');
   $ci->email->to($recipientEmail);
   $ci->email->subject($subject);
   $ci->email->message($message);
   $ci->load->library('email');

   if ($ci->email->send()) {
         return true;
   } else {
         return false;
         // return $this->email->print_debugger();
   }
}
