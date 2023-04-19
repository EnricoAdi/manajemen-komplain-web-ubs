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
    public function exportTopik()
    {
        $this->load->model('TopikModel');
        $topics = $this->TopikModel->fetch();
        foreach ($topics as $topic) {
            echo "INSERT INTO TOPIK VALUES ('" . $topic->TOPIK . "','" . $topic->KODE_TOPIK . "','" . $topic->DESKRIPSI . "','" . $topic->AU . "','" . $topic->DIV_TUJUAN . "','" . $topic->NAMA . "');<br>";
        }
    }
    public function exportSubTopik1()
    {
        $this->load->model('SubTopik1Model');
        $subtopics = $this->SubTopik1Model->fetch();
        foreach ($subtopics as $subtopic) {
            echo "INSERT INTO SUB_TOPIK1 VALUES ('" . $subtopic->KODE_TOPIK . "','" . $subtopic->SUB_TOPIK1 . "','" . $subtopic->DESKRIPSI . "');<br>";
        }
    }
    public function exportSubTopik2()
    {
        $this->load->model('SubTopik2Model');
        $subtopics = $this->SubTopik2Model->fetch();
        foreach ($subtopics as $subtopic) {
            echo "INSERT INTO SUB_TOPIK2 VALUES ('" . $subtopic->KODE_TOPIK . "','" . $subtopic->SUB_TOPIK1 . "','" . $subtopic->SUB_TOPIK2 . "','" . $subtopic->DESKRIPSI . "','1');<br>";
        }
    }
    public function exportKomplain()
    {
        $this->load->model('KomplainAModel');
        $this->load->model('KomplainBModel');
        $komplainAs = $this->KomplainAModel->fetch();
        $komplainBs = $this->KomplainBModel->fetch();
        foreach ($komplainAs as $key => $komplainA) {

            echo "INSERT INTO KOMPLAINA VALUES('$komplainA->NO_KOMPLAIN','$komplainA->TOPIK','$komplainA->SUB_TOPIK1','$komplainA->SUB_TOPIK2','$komplainA->TGL_KEJADIAN','$komplainA->TGL_TERBIT','$komplainA->TGL_VERIFIKASI','$komplainA->USER_VERIFIKASI','$komplainA->TGL_CANCEL','$komplainA->USER_CANCEL','$komplainA->TGL_BANDING','$komplainA->USER_BANDING','$komplainA->TGL_VALIDASI','$komplainA->USER_VALIDASI','$komplainA->PENUGASAN','$komplainA->STATUS','$komplainA->TGL_PENANGANAN','$komplainA->USER_PENANGANAN','$komplainA->TGL_DEADLINE','$komplainA->TGL_DONE','$komplainA->USER_DONE','$komplainA->USER_PENERBIT');";
            echo "<br>";
        }
        echo "<br><br>";
        foreach ($komplainBs as $key => $komplainB) {
            echo "INSERT INTO KOMPLAINB VALUES('$komplainB->NO_KOMPLAIN','$komplainB->DESKRIPSI_MASALAH','$komplainB->AKAR_MASALAH','$komplainB->T_KOREKTIF','$komplainB->T_PREVENTIF','$komplainB->KEBERATAN');";
            echo "<br>";
        }
    }

    public function exportFakerUser()
    {
        $this->load->model('UsersModel');
        $users = $this->UsersModel->fetch();
        $randomFirstMaleName = [
            "malik", "kevin", "jason", "michael", "mikhael", "adi", "christian", "david", "sakti", "saputra", "william", "vino", "ian", "nicolas", "clift", "raymond", "jonathan", "andi", "budi", "galih", "rama", "jack", "timothy", "maverick", "chris", "dion", "calvin", "daniel", "matthew", "brandon", "alex", "andre", "dwi", "sean", "devon", "robby", "julio", "nuel", "iwan"
        ];

        $randomLastMaleName = [
            "suhartono", "nugroho", "wijaya", "susanto", "setiawan", "setiono", "santoso", "nugraha", "wibowo", "candra", "ardiansyah", "utomo", "kusuma", "irawan", "hartato", "prasetya", "nugraha", "pratama",
            "thamrin", "cahyadi", "haryanto", "ardian"
        ];

        $randomFirstFemaleName = [
            "davina", "maria", "gaby", "karin", "kania", "lili", "shania", "martha", "yolanda", "yulianti", "diana", "ika", "faizah", "denise", "rini", "pertiwi", "vivi", "michel", "suci", "grace", "jessica", "ratih", "ina", "tiffany", "ratna", "sheilla", "arista", "yessy", "jane", "ira", "salsa", "angeline", "joyce"
        ];

        $randomLastFemaleName = [
            "suhartini", "astuti", "wijaya", "susanto", "fitri", "setiawan", "mulia", "santoso", "pratiwi", "wibowo", "candra", "pertiwi", "utami", "kusuma", "irawan", "hartati", "prasetya", "nugraha", "pratama",
            "thamrin", "cahyadi", "haryanto", "ardian"
        ];

        foreach ($users as $key => $user) {
            $gender = rand(0,20);
            $name = "";
            $firstName = "";
            $lastName = ""; 
            $angka = rand(1012341,92012341);
            $angka2 = rand(4012341,92092341);
            if($gender%2==0){ 
                $firstName = $randomFirstMaleName[rand(0, count($randomFirstMaleName)-1)];
                $lastName = $randomLastMaleName[rand(0, count($randomLastMaleName)-1)];
                
            }else{
                $firstName = $randomFirstFemaleName[rand(0, count($randomFirstFemaleName)-1)];
                $lastName = $randomLastFemaleName[rand(0, count($randomLastFemaleName)-1)];
            }
            $name = $firstName." ".$lastName;
            $email = $firstName.$lastName."$angka$angka2@gmail.com";
            echo "Insert into USERS";
            echo "<br>";
            echo "    (NOMOR_INDUK, PASSWORD, KODE_HAK_AKSES, KODEDIV, NAMA, EMAIL, KODE_ATASAN)";
            echo "<br>";
            echo "VALUES";
            echo "<br>";
            echo "    ('$user->NOMOR_INDUK', '$user->PASSWORD', '$user->KODE_HAK_AKSES', '$user->KODEDIV', '$name', '$email', '$user->KODE_ATASAN');";
            echo "<br>";
        }


    }
    public function exportUser(){
        
        $this->load->model('UsersModel');
        $users = $this->UsersModel->fetch();
        foreach ($users as $key => $user) { 
            echo "Insert into USERS";
            echo "<br>";
            echo "    (NOMOR_INDUK, PASSWORD, KODE_HAK_AKSES, KODEDIV, NAMA, EMAIL, KODE_ATASAN)";
            echo "<br>";
            echo "VALUES";
            echo "<br>";
            echo "    ('$user->NOMOR_INDUK', '$user->PASSWORD', '$user->KODE_HAK_AKSES', '$user->KODEDIV', '$user->NAMA', '$user->EMAIL', '$user->KODE_ATASAN');";
            echo "<br>";
        }
    }
}
