SISTEM KEHADIRAN GURU - VERSI INFINITYFREE
============================================

Isi paket:
- index.php       : halaman aplikasi
- api.php         : backend PHP + API
- config.php      : konfigurasi MySQL
- database.sql    : struktur database
- setup.php       : membuat akun admin/kepala awal
- uploads/        : penyimpanan berkas izin dan gambar

CARA PASANG DI INFINITYFREE
1. Buat hosting dan database MySQL di panel InfinityFree.
2. Buka database manager/phpMyAdmin lalu import database.sql.
3. Edit config.php:
   $db_host = '...';
   $db_name = '...';
   $db_user = '...';
   $db_pass = '...';
   Gunakan nilai persis dari MySQL Databases di panel hosting.
4. Upload seluruh isi paket ke folder htdocs.
5. Pastikan folder uploads/izin dan uploads/settings dapat ditulisi server.
6. Buka:
   https://DOMAIN-ANDA/setup.php
7. Setelah setup berhasil, hapus setup.php dari hosting.
8. Login:
   Admin: admin / admin123
   Kepala: kepala / kepala123
9. Ganti password akun awal melalui pengelolaan akun jika nanti fitur password admin ditambahkan.
   Untuk guru, saat Admin menambah guru, akun otomatis:
   Username = NIP/ID guru
   Password awal = 123456

CATATAN
- Versi file asli memakai localStorage, sehingga data hanya tersimpan di browser. Versi ini sudah dipindahkan ke PHP + MySQL agar data tersimpan di server dan dapat dipakai bersama.
- Berkas izin tidak disimpan sebagai base64 di browser. File disimpan di server dan aksesnya melalui api.php setelah login.
- Untuk keamanan, segera ganti password akun awal setelah sistem aktif.
