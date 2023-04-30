<?php

class KomplainAModel extends CI_Model
{
    public $NO_KOMPLAIN;
    public $TOPIK;
    public $SUB_TOPIK1;
    public $SUB_TOPIK2;
    public $TGL_KEJADIAN;
    public $TGL_TERBIT;
    public $TGL_VERIFIKASI;
    public $USER_VERIFIKASI;
    public $TGL_CANCEL;
    public $USER_CANCEL;
    public $TGL_BANDING;
    public $USER_BANDING;
    public $TGL_VALIDASI;
    public $USER_VALIDASI;
    public $PENUGASAN;
    public $STATUS;
    public $TGL_PENANGANAN;
    public $USER_PENANGANAN;
    public $TGL_DEADLINE;
    public $TGL_DONE;
    public $USER_DONE;
    public $USER_PENERBIT;


    public function __construct()
    {
        parent::__construct();
    }
    public function fetch()
    {
        return $this->db->query('SELECT KA.*, KB.*,D.* FROM KOMPLAINA KA 
       JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
       JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN')->result();
    }
    public function get($no_komplain)
    {
        $query = $this->db->query('SELECT KA.*, KB.*, D.* , ST1.DESKRIPSI AS S1DESKRIPSI, 
        ST2.DESKRIPSI AS S2DESKRIPSI, T.TOPIK AS TDESKRIPSI, D.NAMA AS NAMA_DIVISI 
        FROM KOMPLAINA KA JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
        JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
        JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN 
        JOIN SUB_TOPIK1 ST1 
        ON ST1.SUB_TOPIK1 = KA.SUB_TOPIK1 and ST1.KODE_TOPIK = KA.TOPIK
        JOIN SUB_TOPIK2 ST2 
        ON ST2.SUB_TOPIK2 = KA.SUB_TOPIK2 and ST2.SUB_TOPIK1 = KA.SUB_TOPIK1 and ST2.KODE_TOPIK = KA.TOPIK
        JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
        WHERE KB.NO_KOMPLAIN = ?', array($no_komplain))->result();

        if (sizeof($query) > 0) {
            $resultQuery = $query[0];
            $queryLampiran = $this->db->query('SELECT * FROM LAMPIRAN WHERE NO_KOMPLAIN = ?', array($no_komplain))->result();
            if (sizeof($queryLampiran) > 0) {
                $resultQuery->LAMPIRAN = $queryLampiran;
            } else {
                $resultQuery->LAMPIRAN = array();
            }
            $komplainA = new KomplainAModel();
            $komplainA->NO_KOMPLAIN = $resultQuery->NO_KOMPLAIN;
            $komplainA->TOPIK = $resultQuery->TOPIK;
            $komplainA->SUB_TOPIK1 = $resultQuery->SUB_TOPIK1;
            $komplainA->SUB_TOPIK2 = $resultQuery->SUB_TOPIK2;
            $komplainA->TGL_KEJADIAN = $resultQuery->TGL_KEJADIAN;
            $komplainA->TGL_TERBIT = $resultQuery->TGL_TERBIT;
            $komplainA->TGL_VERIFIKASI = $resultQuery->TGL_VERIFIKASI;
            $komplainA->USER_VERIFIKASI = $resultQuery->USER_VERIFIKASI;
            $komplainA->TGL_CANCEL = $resultQuery->TGL_CANCEL;
            $komplainA->USER_CANCEL = $resultQuery->USER_CANCEL;
            $komplainA->TGL_BANDING = $resultQuery->TGL_BANDING;
            $komplainA->USER_BANDING = $resultQuery->USER_BANDING;
            $komplainA->TGL_VALIDASI = $resultQuery->TGL_VALIDASI;
            $komplainA->USER_VALIDASI = $resultQuery->USER_VALIDASI;
            $komplainA->PENUGASAN = $resultQuery->PENUGASAN;
            $komplainA->STATUS = $resultQuery->STATUS;
            $komplainA->TGL_PENANGANAN = $resultQuery->TGL_PENANGANAN;
            $komplainA->USER_PENANGANAN = $resultQuery->USER_PENANGANAN;
            $komplainA->TGL_DEADLINE = $resultQuery->TGL_DEADLINE;
            $komplainA->TGL_DONE = $resultQuery->TGL_DONE;
            $komplainA->USER_DONE = $resultQuery->USER_DONE;
            $komplainA->USER_PENERBIT = $resultQuery->USER_PENERBIT;
            $komplainA->LAMPIRAN = $resultQuery->LAMPIRAN;
            $komplainA->S1DESKRIPSI = $resultQuery->S1DESKRIPSI;
            $komplainA->S2DESKRIPSI = $resultQuery->S2DESKRIPSI;
            $komplainA->TDESKRIPSI = $resultQuery->TDESKRIPSI;
            $komplainA->KODEDIV = $resultQuery->KODEDIV;
            $komplainA->NAMA_DIVISI = $resultQuery->NAMA_DIVISI;
            $komplainA->DESKRIPSI_MASALAH = $resultQuery->DESKRIPSI_MASALAH;


            $penerbit = $this->db->query('SELECT U.*, D.* 
            FROM USERS U JOIN DIVISI D ON U.KODEDIV = D.KODEDIV 
            WHERE U.NOMOR_INDUK = ?', array($resultQuery->USER_PENERBIT))->result();

            $komplainA->PENERBIT = $penerbit[0];

            $feedback = $this->db->query('SELECT *
            FROM KOMPLAINB WHERE NO_KOMPLAIN = ?', array($resultQuery->NO_KOMPLAIN))->result();

            $komplainA->FEEDBACK = $feedback[0];

            return $komplainA;
        }
        return null;
    }
    public function getNewKode()
    {
        $this->db->select("nvl(NO_KOMPLAIN,'0000000000') as OLDKODE from KOMPLAINA where rownum<=1 order by NO_KOMPLAIN desc ");

        $query = $this->db->get()->result();
        $oldkode = '0000000000';
        if (sizeof($query) > 0) {
            $oldkode = $query[0]->OLDKODE;
        }
        $newkode = "0";
        $urutan = (int)$oldkode;
        $urutan = $urutan + 1;

        $newkode  = str_pad($urutan, 10, "0", STR_PAD_LEFT);
        return $newkode;
    }

    public function fetchFromUser($nomor_induk, $status)
    {
        if ($status == 'all') {
            return $this->db->query("SELECT KA.*, KB.*,D.*, D.NAMA AS NAMA_DIVISI FROM KOMPLAINA KA 
            JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
            JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
            JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN WHERE KA.USER_PENERBIT = '$nomor_induk'")->result();
        } else {
            return $this->db->query("SELECT KA.*, KB.*,D.*, D.NAMA AS NAMA_DIVISI FROM KOMPLAINA KA 
            JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
            JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN WHERE KA.USER_PENERBIT = '$nomor_induk' AND KA.STATUS = '$status'")->result();
        }
    }
    public function fetchForDivisi($KODEDIV, $status)
    {
        if ($status == 'all') {
            return $this->db->query("SELECT KA.*, KB.*,D.*, D.KODEDIV AS KODE_DIVISI,
            DU.NAMA AS DIVISI_PENGIRIM,T.DESKRIPSI AS TDESKRIPSI, 
            S1.DESKRIPSI AS S1DESKRIPSI,
            S2.DESKRIPSI AS S2DESKRIPSI
            FROM KOMPLAINA KA 
            JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
            JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
            JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN 
            JOIN USERS U ON U.NOMOR_INDUK = KA.USER_PENERBIT
            JOIN DIVISI DU ON DU.KODEDIV = U.KODEDIV
            JOIN SUB_TOPIK1 S1 S1.SUB_TOPIK1 = KA.SUB_TOPIK1 and S1.KODE_TOPIK = KA.TOPIK
            JOIN SUB_TOPIK2 S2 ON S2.SUB_TOPIK2 = KA.SUB_TOPIK2 and 
            S2.SUB_TOPIK1 = KA.SUB_TOPIK1 and S2.KODE_TOPIK = KA.TOPIK
            WHERE T.DIV_TUJUAN = '$KODEDIV'")->result();
        } else {
            return $this->db->query("SELECT KA.*, KB.*,D.*, D.KODEDIV AS KODE_DIVISI,
            DU.NAMA AS DIVISI_PENGIRIM, T.DESKRIPSI AS TDESKRIPSI,
            S1.DESKRIPSI AS S1DESKRIPSI,
            S2.DESKRIPSI AS S2DESKRIPSI
            FROM KOMPLAINA KA 
            JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
            JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
            JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN 
            JOIN USERS U ON U.NOMOR_INDUK = KA.USER_PENERBIT
            JOIN DIVISI DU ON DU.KODEDIV = U.KODEDIV
            JOIN SUB_TOPIK1 S1 ON S1.SUB_TOPIK1 = KA.SUB_TOPIK1 and S1.KODE_TOPIK = KA.TOPIK
            JOIN SUB_TOPIK2 S2 ON S2.SUB_TOPIK2 = KA.SUB_TOPIK2 and 
            S2.SUB_TOPIK1 = KA.SUB_TOPIK1 and S2.KODE_TOPIK = KA.TOPIK
            WHERE T.DIV_TUJUAN = '$KODEDIV' AND KA.STATUS = '$status'")->result();
        }
    }

    public function fetchByUserDitugaskan($nomor_induk)
    {
        return $this->db->query("SELECT KA.*, KB.*,D.*, 
        DU.NAMA AS DIVISI_PENGIRIM,T.DESKRIPSI AS TDESKRIPSI, 
        S1.DESKRIPSI AS S1DESKRIPSI,
        S2.DESKRIPSI AS S2DESKRIPSI
        FROM KOMPLAINA KA 
        JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
        JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
        JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN 
        JOIN USERS U ON U.NOMOR_INDUK = KA.USER_PENERBIT
        JOIN DIVISI DU ON DU.KODEDIV = U.KODEDIV
        JOIN SUB_TOPIK1 S1 ON S1.SUB_TOPIK1 = KA.SUB_TOPIK1 and S1.KODE_TOPIK = KA.TOPIK
        JOIN SUB_TOPIK2 S2 ON S2.SUB_TOPIK2 = KA.SUB_TOPIK2 and 
            S2.SUB_TOPIK1 = KA.SUB_TOPIK1 and S2.KODE_TOPIK = KA.TOPIK
        WHERE KA.PENUGASAN = '$nomor_induk'")->result();
    }
    public function fetchComplainSudahDiisi($KODEDIV)
    {
        return $this->db->query("SELECT KA.*, KB.*,D.*, 
        DU.NAMA AS DIVISI_PENGIRIM, T.DESKRIPSI AS TDESKRIPSI,
        S1.DESKRIPSI AS S1DESKRIPSI, S2.DESKRIPSI AS S2DESKRIPSI
        FROM KOMPLAINA KA 
        JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
        JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
        JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN 
        JOIN USERS U ON U.NOMOR_INDUK = KA.USER_PENERBIT
        JOIN DIVISI DU ON DU.KODEDIV = U.KODEDIV
        JOIN SUB_TOPIK1 S1 ON S1.SUB_TOPIK1 = KA.SUB_TOPIK1 and S1.KODE_TOPIK = KA.TOPIK
        JOIN SUB_TOPIK2 S2  ON S2.SUB_TOPIK2 = KA.SUB_TOPIK2 and S2.SUB_TOPIK1 = KA.SUB_TOPIK1 and S2.KODE_TOPIK = KA.TOPIK
        WHERE T.DIV_TUJUAN = ? AND KA.STATUS = 'PEND' 
        AND KB.T_KOREKTIF is not null AND KA.TGL_DONE is null", array($KODEDIV))->result();
    }
    public function fetchKomplainDone($nomor_induk)
    {
        return $this->db->query("SELECT KA.*, KB.*,D.*, 
        DU.NAMA AS DIVISI_PENGIRIM,T.DESKRIPSI AS TDESKRIPSI, 
        S1.DESKRIPSI AS S1DESKRIPSI,
        S2.DESKRIPSI AS S2DESKRIPSI
        FROM KOMPLAINA KA 
        JOIN KOMPLAINB KB ON KA.NO_KOMPLAIN = KB.NO_KOMPLAIN 
        JOIN TOPIK T ON T.KODE_TOPIK = KA.TOPIK 
        JOIN DIVISI D ON D.KODEDIV = T.DIV_TUJUAN 
        JOIN USERS U ON U.NOMOR_INDUK = KA.USER_PENERBIT
        JOIN DIVISI DU ON DU.KODEDIV = U.KODEDIV
        JOIN SUB_TOPIK1 S1 ON S1.SUB_TOPIK1 = KA.SUB_TOPIK1 and S1.KODE_TOPIK = KA.TOPIK
        JOIN SUB_TOPIK2 S2 ON S2.SUB_TOPIK2 = KA.SUB_TOPIK2 and 
            S2.SUB_TOPIK1 = KA.SUB_TOPIK1 and S2.KODE_TOPIK = KA.TOPIK
        WHERE KA.USER_PENERBIT = '$nomor_induk' and KA.TGL_DONE is not null")->result();
    }
    public function insert()
    {
        // $this->db->insert('KOMPLAINA', $this); 
        $this->db->query("INSERT INTO KOMPLAINA VALUES ('$this->NO_KOMPLAIN', '$this->TOPIK', '$this->SUB_TOPIK1', '$this->SUB_TOPIK2', TO_DATE('$this->TGL_KEJADIAN', 'YYYY-MM-DD'), TO_DATE('$this->TGL_TERBIT', 'YYYY-MM-DD'), NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$this->STATUS', NULL, NULL, NULL, NULL, NULL, '$this->USER_PENERBIT')");
    }
    public function update()
    {
        $this->db->query("UPDATE KOMPLAINA SET TOPIK = $this->TOPIK,
        SUB_TOPIK1 = $this->SUB_TOPIK1, 
        SUB_TOPIK2 = $this->SUB_TOPIK2, 
        TGL_KEJADIAN = $this->TGL_KEJADIAN, 
        TGL_TERBIT = $this->TGL_TERBIT, 
        TGL_VERIFIKASI = $this->TGL_VERIFIKASI, 
        USER_VERIFIKASI = $this->USER_VERIFIKASI, 
        TGL_CANCEL = $this->TGL_CANCEL, 
        USER_CANCEL = $this->USER_CANCEL, 
        TGL_BANDING = $this->TGL_BANDING, 
        USER_BANDING = $this->USER_BANDING, 
        TGL_VALIDASI = $this->TGL_VALIDASI, 
        USER_VALIDASI = $this->USER_VALIDASI, 
        PENUGASAN = $this->PENUGASAN, 
        STATUS = $this->STATUS, 
        TGL_PENANGANAN = $this->TGL_PENANGANAN, 
        USER_PENANGANAN = $this->USER_PENANGANAN, 
        TGL_DEADLINE = $this->TGL_DEADLINE, 
        TGL_DONE = $this->TGL_DONE, 
        USER_DONE = $this->USER_DONE, 
        USER_PENERBIT = $this->USER_PENERBIT, 
        where NO_KOMPLAIN = $this->NO_KOMPLAIN");
        // $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        // $this->db->update('KOMPLAINA', $this); 
    }
    public function updateKomplain()
    {

        $this->db->query("UPDATE KOMPLAINA SET 
        TOPIK ='$this->TOPIK',
        SUB_TOPIK1 = '$this->SUB_TOPIK1', 
        SUB_TOPIK2 = '$this->SUB_TOPIK2', 
        TGL_KEJADIAN = TO_DATE('$this->TGL_KEJADIAN', 'YYYY-MM-DD')
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateVerifikasi()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        STATUS = 'PEND',
        USER_VERIFIKASI ='$this->USER_VERIFIKASI', 
        TGL_VERIFIKASI = TO_DATE('$this->TGL_VERIFIKASI', 'YYYY-MM-DD')
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateTransferKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        TOPIK ='$this->TOPIK',
        SUB_TOPIK1 = '$this->SUB_TOPIK1', 
        SUB_TOPIK2 = '$this->SUB_TOPIK2'  
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updatePenugasanKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        PENUGASAN ='$this->PENUGASAN' 
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateHapusPenugasanKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        PENUGASAN = null 
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateDeadlinePenyelesaianKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        TGL_DEADLINE = TO_DATE('$this->TGL_DEADLINE', 'YYYY-MM-DD')
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updatePenyelesaianKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        TGL_PENANGANAN = TO_DATE('$this->TGL_PENANGANAN', 'YYYY-MM-DD'),
        USER_PENANGANAN = '$this->USER_PENANGANAN'
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function deleteDeadlinePenyelesaianKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        TGL_DEADLINE = null
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function donePenyelesaianKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        TGL_DONE = TO_DATE('$this->TGL_DONE', 'YYYY-MM-DD'),
        USER_DONE = '$this->USER_DONE'
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }

    public function updateBandingKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        TGL_BANDING = TO_DATE('$this->TGL_BANDING', 'YYYY-MM-DD'),
        USER_BANDING = '$this->USER_BANDING',
        STATUS = 'CLOSE'
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateCancelKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        TGL_CANCEL = TO_DATE('$this->TGL_CANCEL', 'YYYY-MM-DD'),
        USER_CANCEL = '$this->USER_CANCEL',
        STATUS = 'CANCEL'
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function updateValidasiKomplain()
    {
        $this->db->query("UPDATE KOMPLAINA SET 
        TGL_VALIDASI = TO_DATE('$this->TGL_VALIDASI', 'YYYY-MM-DD'),
        USER_VALIDASI = '$this->USER_VALIDASI',
        STATUS = 'CLOSE'
        where NO_KOMPLAIN = '$this->NO_KOMPLAIN'");
    }
    public function delete()
    {
        $this->db->where('NO_KOMPLAIN', $this->NO_KOMPLAIN);
        $this->db->delete('KOMPLAINA');
    }

    //dashboard admin
    public function getTotalKomplainByMonth($bulan, $tahun)
    {
        $query = $this->db->query("SELECT COUNT(*) as total FROM KOMPLAINA WHERE TO_CHAR(TGL_TERBIT, 'MM') = '$bulan' and TO_CHAR(TGL_TERBIT, 'YYYY') = '$tahun' order by TGL_TERBIT ASC")->result();
        if ($query[0]->TOTAL == null)
            return 0;
        else
            return $query[0]->TOTAL;
    }
    public function divisiKomplainTerbanyakByMonth($bulan, $tahun)
    {
        $query = $this->db->query("SELECT COUNT(*) as total, D.NAMA  FROM KOMPLAINA K
         JOIN TOPIK T ON K.TOPIK = T.KODE_TOPIK JOIN DIVISI D ON T.DIV_TUJUAN = D.KODEDIV
         WHERE TO_CHAR(TGL_TERBIT, 'MM') = '$bulan' and TO_CHAR(TGL_TERBIT, 'YYYY') = '$tahun' GROUP BY D.NAMA ORDER BY total DESC")->result();
        if ($query == null)
             return null;
        if ($query[0] == null)
            return null;
        else
            return $query[0];
    }
    public function jumlahKomplainDivisiByMonth($bulan, $tahun)
    {
        $query = $this->db->query("SELECT COUNT(*) as total, D.NAMA  FROM KOMPLAINA K
         JOIN TOPIK T ON K.TOPIK = T.KODE_TOPIK JOIN DIVISI D ON T.DIV_TUJUAN = D.KODEDIV
         WHERE TO_CHAR(TGL_TERBIT, 'MM') = '$bulan' and TO_CHAR(TGL_TERBIT, 'YYYY') = '$tahun' GROUP BY D.NAMA ORDER BY total DESC")->result();
        return $query;
    }
    public function fetchKomplainPerBulanByYear($tahun)
    {
        $query = $this->db->query("SELECT RTRIM(TO_CHAR(TGL_TERBIT, 'Month'),' ') as bulan, COUNT(*) as total FROM KOMPLAINA WHERE TO_CHAR(TGL_TERBIT, 'YYYY') = '$tahun' GROUP BY TO_CHAR(TGL_TERBIT, 'Month'),TO_CHAR(TGL_TERBIT, 'MM')  ORDER BY TO_CHAR(TGL_TERBIT, 'MM') ASC")->result();
        return $query;
    }

    //dashboard user
    public function getTotalKomplainTerkirimByUser($nomor_induk)
    {
        $query = $this->db->query("SELECT COUNT(*) as total FROM KOMPLAINA WHERE USER_PENERBIT = '$nomor_induk'")->result();
        if ($query[0]->TOTAL == null)
            return 0;
        else
            return $query[0]->TOTAL;
    }
    public function getTotalKomplainDiterimaByUser($nomor_induk)
    {
        $query = $this->db->query("SELECT COUNT(*) as total FROM KOMPLAINA WHERE PENUGASAN = '$nomor_induk'")->result();
        if ($query[0]->TOTAL == null)
            return 0;
        else
            return $query[0]->TOTAL;
    }
    public function getTotalKomplainSedangDitanganiByUser($nomor_induk)
    {
        $query = $this->db->query("SELECT COUNT(*) as total FROM KOMPLAINA WHERE PENUGASAN = '$nomor_induk' and STATUS<>'CLOSE'")->result();
        if ($query[0]->TOTAL == null)
            return 0;
        else
            return $query[0]->TOTAL;
    }

    public function fetchKomplainBulanIniByUser($nomor_induk, $bulan, $tahun)
    {
        $query = $this->db->query("SELECT KOMPLAINA.*, TOPIK.TOPIK AS NAMATOPIK, DIVISI.NAMA AS NAMADIVISI FROM KOMPLAINA 
        JOIN TOPIK ON TOPIK.KODE_TOPIK = KOMPLAINA.TOPIK JOIN DIVISI ON DIVISI.KODEDIV = TOPIK.DIV_TUJUAN
        WHERE USER_PENERBIT = '$nomor_induk' 
        and TO_CHAR(TGL_TERBIT, 'MM') = '$bulan' and TO_CHAR(TGL_TERBIT, 'YYYY') = '$tahun'")->result();
        return $query;
    }
    public function fetchKomplainPenugasanByUser($nomor_induk)
    {
        $query = $this->db->query("SELECT KOMPLAINA.*, KOMPLAINB.*, TOPIK.TOPIK AS NAMATOPIK, DIVISI.NAMA AS NAMADIVISI FROM KOMPLAINA 
        JOIN TOPIK ON TOPIK.KODE_TOPIK = KOMPLAINA.TOPIK 
        JOIN DIVISI ON DIVISI.KODEDIV = TOPIK.DIV_TUJUAN
        JOIN KOMPLAINB ON KOMPLAINA.NO_KOMPLAIN = KOMPLAINB.NO_KOMPLAIN
        WHERE KOMPLAINA.PENUGASAN = '$nomor_induk' AND KOMPLAINA.STATUS<>'CLOSE'")->result();
        return $query;
    }


    public function customFetch($query)
    {
        return $this->db->query($query)->result();
    }
}
