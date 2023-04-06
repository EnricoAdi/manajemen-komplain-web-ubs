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

 
