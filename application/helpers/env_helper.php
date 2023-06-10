<?php

/**
 * Mode production akan membuat 
 * 1. controller helper tidak bisa diakses 
 * 2. F12 tidak bisa diakses
 * 3. ctrl+u (view page source) tidak bisa diakses
 */
function env_mode(){
    // $mode = "development";
    $mode = "production";
    return $mode;
} 