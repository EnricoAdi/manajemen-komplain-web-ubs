<?php
//email
function send_mail($recipientEmail, $subject, $message)
{
  $ci = &get_instance();
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
function templateEmail($header, $nama, $message)
{
  return "<!DOCTYPE html>
   <html>
     <head>
       <meta charset='utf-8'>
       <title>$header</title>
       <style> 
         * {
           margin: 0;
           padding: 0;
           box-sizing: border-box;
         }
          
         body {
           font-family: Arial, sans-serif;
           color: #333;
         } 
         header {
           background-color: #f5f5f5;
           padding: 20px;
           text-align: center;
         }
         
         header h1 {
           font-size: 32px;
           margin-bottom: 20px;
         }
          
         .content {
           padding: 20px;
         }
          
         .cta-button {
           display: inline-block;
           background-color: #337ab7;
           color: #fff;
           border-radius: 4px;
           padding: 10px 20px;
           text-decoration: none;
           margin-top: 20px;
         }
         
         .cta-button:hover {
           background-color: #23527c;
         }
          
         footer {
           background-color: #f5f5f5;
           padding: 20px;
           text-align: center;
           font-size: 14px;
         }
       </style>
     </head>
     <body>
       <header>
         <h1>$header</h1>
       </header>
       <div class='content'>
         <p>Halo, $nama!</p>
         <br>
         <p>$message</p> 
       </div>
       <footer>
         <p>&copy; PT UBS - SIB ISTTS</p>
       </footer>
     </body>
   </html>";
}

function emailToManager($subject,$message){
  
  $ci = &get_instance();
  $getLogin = $ci->UsersModel->getLogin(); 
  $emailAtasan = $getLogin->EMAIL_ATASAN;
  $res = false;
  if($emailAtasan!=null){
    $res = send_mail("",$subject,$message);
  }
  return $res;
}