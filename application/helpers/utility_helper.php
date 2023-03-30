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
function configToken()
{
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

//button
function generate_button($type, $class, $id, $text, $icon, $backgroundColor, $href = "")
{
  if ($type == "" || $type == null) {
    $type = "button";
  }
  if ($href != "") { 
   $url = base_url().$href;
    return "<a href='$url'> 
    <button type='$type' id='$id' class='btn $class' style='color:white; 
        padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
        background-color: $backgroundColor;'>  
        $icon
        $text
      </button>
  </a>";
  } else { 
    return "<button type='$type' id='$id' class='btn $class' style='color:white; 
      padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
      background-color: $backgroundColor;'>  
      $icon
      $text
    </button>";
  }
}
function error_button($text, $icon = "", $id = "", $class = "", $href = "")
{
  $error_color  = error_color();
  if ($icon != "") {
    $icon = "<i class='$icon'></i>";
  }
  return generate_button("button", "btn-danger $class", $id, $text, $icon, "$error_color",$href);
}
function primary_button($text, $icon = "", $id = "", $class = "", $href="")
{
  $primary_color  = primary_color();
  if ($icon != "") {
    $icon = "<i class='$icon'></i>";
  }
  return generate_button("button", "btn-primary $class", $id, $text, $icon, "$primary_color",$href);
}
function primary_submit_button($text, $icon = "", $id = "", $class = "")
{
  $primary_color  = primary_color();
  if ($icon != "") {
    $icon = "<i class='$icon'></i>";
  }
  return generate_button("submit", "btn-primary $class", $id, $text, $icon, "$primary_color","");
}

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
