CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','guru','kepala') NOT NULL DEFAULT 'guru',
  guru_id INT UNSIGNED NULL,
  nama VARCHAR(150) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX(guru_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE guru (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nip VARCHAR(100) NOT NULL UNIQUE,
  nama VARCHAR(150) NOT NULL,
  jabatan VARCHAR(150) DEFAULT '',
  hp VARCHAR(50) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE absensi (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  guru_id INT UNSIGNED NOT NULL,
  tanggal DATE NOT NULL,
  masuk TIME NULL,
  pulang TIME NULL,
  status ENUM('HADIR','IZIN','SAKIT','DINAS','ALPA') NOT NULL DEFAULT 'HADIR',
  keterangan VARCHAR(500) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_guru_tanggal (guru_id,tanggal),
  CONSTRAINT fk_abs_guru FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE izin (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  guru_id INT UNSIGNED NOT NULL,
  tanggal DATE NOT NULL,
  jenis ENUM('IZIN','SAKIT','DINAS') NOT NULL DEFAULT 'IZIN',
  keterangan VARCHAR(500) NOT NULL,
  berkas VARCHAR(255) DEFAULT NULL,
  status ENUM('Menunggu','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_izin_guru FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE settings (
  id TINYINT UNSIGNED PRIMARY KEY,
  nama_sekolah VARCHAR(200) DEFAULT 'Sistem Kehadiran Guru',
  tahun_pelajaran VARCHAR(50) DEFAULT '',
  alamat TEXT,
  logo VARCHAR(255) DEFAULT NULL,
  background VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO settings (id,nama_sekolah,tahun_pelajaran,alamat) VALUES
(1,'Sistem Kehadiran Guru','','');

-- Akun awal:
-- admin / admin123
-- kepala / kepala123
-- Password di-hash oleh setup.php saat pertama kali dijalankan.
