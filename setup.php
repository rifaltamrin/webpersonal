<?php
require __DIR__.'/config.php';
header('Content-Type: text/html; charset=utf-8');

function hashpw($p){ return password_hash($p, PASSWORD_DEFAULT); }

$messages=[];
try {
  $pdo->beginTransaction();

  $stmt=$pdo->prepare("SELECT id FROM users WHERE username=?");
  $stmt->execute(['admin']);
  if(!$stmt->fetch()){
    $s=$pdo->prepare("INSERT INTO users(username,password_hash,role,nama) VALUES(?,?,?,?)");
    $s->execute(['admin',hashpw('admin123'),'admin','Administrator']);
    $messages[]='Akun admin dibuat: admin / admin123';
  } else $messages[]='Akun admin sudah ada.';

  $stmt=$pdo->prepare("SELECT id FROM users WHERE username=?");
  $stmt->execute(['kepala']);
  if(!$stmt->fetch()){
    $s=$pdo->prepare("INSERT INTO users(username,password_hash,role,nama) VALUES(?,?,?,?)");
    $s->execute(['kepala',hashpw('kepala123'),'kepala','Kepala Sekolah']);
    $messages[]='Akun kepala dibuat: kepala / kepala123';
  } else $messages[]='Akun kepala sudah ada.';

  $pdo->commit();
} catch(Throwable $e) {
  if($pdo->inTransaction()) $pdo->rollBack();
  die('Setup gagal: '.htmlspecialchars($e->getMessage()));
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Setup</title>
<style>body{font-family:Arial;background:#f2f4f6;padding:40px}.box{max-width:700px;margin:auto;background:#fff;padding:30px;border-radius:15px;box-shadow:0 10px 30px #0001}li{margin:10px 0}.warn{background:#fff3cd;padding:12px;border-radius:8px}</style></head>
<body><div class="box"><h2>Setup Sistem Kehadiran Guru</h2><ul><?php foreach($messages as $m) echo '<li>'.htmlspecialchars($m).'</li>'; ?></ul>
<div class="warn"><b>PENTING:</b> setelah berhasil, hapus file <code>setup.php</code> dari hosting.</div>
<p><a href="index.php">Buka aplikasi</a></p></div></body></html>
