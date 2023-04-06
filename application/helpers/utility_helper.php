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

function die_dump($element){
  echo "<pre>";
  var_dump($element);
  echo "</pre>";
  die();
}
 