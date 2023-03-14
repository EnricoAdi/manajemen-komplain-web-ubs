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