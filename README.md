# Website Manajemen Komplain PT UBS
Note for production :

Sejauh yang saya tahu, codeigniter 3 tidak menyediakan file .env secara default (harus install package), sehingga saya menggunakan helper untuk menjadi alternatif.
Letak env ada di application > helpers > env_helper.php

Untuk progress bar komplain sedang diselesaikan dijabarkan sebagai berikut
- Apabila belum ada penyelesaian namun sudah ditugaskan, maka progress = 20
- Apabila sudah ada penyelesaian diisi, maka progress = 50
- Apabila sudah ada penyelesaian diisi dan sudah di done, maka progress = 75
- Apabila sudah divalidasi, maka progress = 100
