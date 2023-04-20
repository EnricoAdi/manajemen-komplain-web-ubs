<?php 

//button
function generate_button($type, $class, $id, $text, $icon, $backgroundColor, $href = "")
{
  if ($type == "" || $type == null) {
    $type = "button";
  }
  if ($href != "") { 
   $url = base_url().$href;
    return "<a href='$url'> 
      <button type='$type' id='$id' class='btn $class animated' style='color:white; 
          padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px;
          background-color: $backgroundColor;'>  
          $icon
          $text
        </button>
  </a>";
  } else { 
    return "<button type='$type' id='$id' class='btn $class animated' style='color:white; 
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
function secondary_button($text, $icon = "", $id = "", $class = "", $href=""){
  $secondary_color  = secondary_color();
  if ($icon != "") {
    $icon = "<i class='$icon'></i>";
  }
  return generate_button("button", "btn-warning $class", $id, $text, $icon, "$secondary_color",$href);
}
function primary_submit_button($text, $icon = "", $id = "", $class = "")
{
  $primary_color  = primary_color();
  if ($icon != "") {
    $icon = "<i class='$icon'></i>";
  }
  return generate_button("submit", "btn-primary $class", $id, $text, $icon, "$primary_color","");
}

function error_submit_button($text, $icon = "", $id = "", $class = "")
{
  $error_color  = error_color();
  if ($icon != "") {
    $icon = "<i class='$icon'></i>";
  }
  return generate_button("submit", "btn-danger $class", $id, $text, $icon, "$error_color","");
}


function card_type_1($judul,$isi,$icon,$warna="primary"){
   
  return "
  <div class='card border-left-$warna shadow h-100 py-2'>
    <div class='card-body'>
      <div class='row no-gutters align-items-center'>
        <div class='col mr-2'>
          <div class='text-xs font-weight-bold text-$warna text-uppercase mb-1'>
            $judul</div>
          <div class='h5 mb-0 font-weight-bold text-gray-800'>$isi</div>
        </div>
        <div class='col-auto'>
          <i class='fas $icon fa-2x text-gray-300'></i>
        </div>
      </div>
    </div>
  </div>";
}
