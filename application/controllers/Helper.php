<?php
class Helper extends CI_Controller
{
    public function encrypt($word)
    {
        $passwordHash = password_hash($word, PASSWORD_DEFAULT);
        echo $passwordHash;
    }
    public static function randomChar($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function exportTopik(){
        $this->load->model('TopikModel');
        $topics = $this->TopikModel->fetch();  
       foreach ($topics as $topic) { 
         echo "INSERT INTO TOPIK VALUES ('".$topic->TOPIK."','".$topic->KODE_TOPIK."','".$topic->DESKRIPSI."','".$topic->AU."','".$topic->DIV_TUJUAN."','".$topic->NAMA."');<br>";
       }
    }
    public function exportSubTopik1(){
        $this->load->model('SubTopik1Model');
        $subtopics = $this->SubTopik1Model->fetch();  
       foreach ($subtopics as $subtopic) { 
            echo "INSERT INTO SUB_TOPIK1 VALUES ('".$subtopic->KODE_TOPIK."','".$subtopic->SUB_TOPIK1."','".$subtopic->DESKRIPSI."');<br>";
       }
    }
    public function exportSubTopik2(){
        $this->load->model('SubTopik2Model');
        $subtopics = $this->SubTopik2Model->fetch();  
       foreach ($subtopics as $subtopic) { 
            // echo "INSERT INTO SUB_TOPIK2 VALUES ('".$subtopic->KODE_TOPIK."','".$subtopic->SUB_TOPIK1."','".$subtopic->SUB_TOPIK2."','".$subtopic->DESKRIPSI."','".$subtopic->AKTIF."');<br>";
            echo "INSERT INTO SUB_TOPIK2 VALUES ('".$subtopic->KODE_TOPIK."','".$subtopic->SUB_TOPIK1."','".$subtopic->SUB_TOPIK2."','".$subtopic->DESKRIPSI."','1');<br>";
       }
    }
}
