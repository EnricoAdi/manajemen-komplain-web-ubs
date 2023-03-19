<?php
class Helper extends CI_Controller
{
    public function encrypt_web($word)
    { 
        echo encrypt($word);
    }
    public static function randomChar($length)
    {
        echo generateUID($length);
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
