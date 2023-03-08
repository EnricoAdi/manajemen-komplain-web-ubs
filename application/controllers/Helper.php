<?php
class Helper extends CI_Controller
{
    public function encrypt($word)
    {
        $passwordHash = password_hash($word, PASSWORD_DEFAULT);
        echo $passwordHash;
    }
    public function randomChar($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        echo $randomString;
    }
}
