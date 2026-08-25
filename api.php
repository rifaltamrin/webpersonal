<?php
session_start();
require __DIR__.'/config.php';
header('Content-Type: application/json; charset=utf-8');

function out($data,$code=200){ http_response_code($code); echo json_encode($data,JSON_UNESCAPED_UNICODE); exit; }
function req($k,$d=null){ return $_POST[$k] ?? $d; }
function auth(){ if(empty($_SESSION['user'])) out(['ok'=>false,'message'=>'Sesi login berakhir.'],401); return $_SESSION['user']; }
function adminOnly(){ $u=auth(); if($u['role']!=='admin') out(['ok'=>false,'message'=>'Akses admin diperlukan.'],403); return $u; }
function canSeeGuru($guruId,$u){ return $u['role']==='admin' || $u['role']==='kepala' || ($u['role']==='guru' && (int)$u['guru_id']===(int)$guruId); }

$action=req('action',$_GET['action']??'');
try {
 switch($action){
  case 'login':
    $username=trim(req('username','')); $password=(string)req('password','');
    $s=$pdo->prepare("SELECT u.*, g.nip, g.nama AS guru_nama FROM users u LEFT JOIN guru g ON g.id=u.guru_id WHERE u.username=? LIMIT 1");
    $s->execute([$username]); $u=$s->fetch();
    if(!$u || !password_verify($password,$u['password_hash'])) out(['ok'=>false,'message'=>'Username atau password salah.'],401);
    $_SESSION['user']=['id'=>(int)$u['id'],'username'=>$u['username'],'role'=>$u['role'],'guru_id'=>$u['guru_id']?(int)$u['guru_id']:null,'nama'=>$u['nama']];
    out(['ok'=>true,'user'=>$_SESSION['user']]);
  case 'me':
    out(['ok'=>true,'user'=>$_SESSION['user']??null]);
  case 'logout':
    session_destroy(); out(['ok'=>true]);

  case 'guru_list':
    $u=auth();
    if($u['role']==='guru'){
      $s=$pdo->prepare("SELECT * FROM guru WHERE id=?"); $s->execute([$u['guru_id']]);
    } else $s=$pdo->query("SELECT * FROM guru ORDER BY nama");
    out(['ok'=>true,'data'=>$s->fetchAll()]);
  case 'guru_add':
    adminOnly();
    $nip=trim(req('nip')); $nama=trim(req('nama')); $jabatan=trim(req('jabatan','')); $hp=trim(req('hp',''));
    if(!$nip||!$nama) out(['ok'=>false,'message'=>'NIP/ID dan nama wajib diisi.'],422);
    $s=$pdo->prepare("INSERT INTO guru(nip,nama,jabatan,hp) VALUES(?,?,?,?)"); $s->execute([$nip,$nama,$jabatan,$hp]);
    $gid=(int)$pdo->lastInsertId();
    // Akun guru otomatis: username=NIP, password=123456
    $s=$pdo->prepare("INSERT INTO users(username,password_hash,role,guru_id,nama) VALUES(?,?,?,?,?)");
    $s->execute([$nip,password_hash('123456',PASSWORD_DEFAULT),'guru',$gid,$nama]);
    out(['ok'=>true,'message'=>'Guru ditambahkan. Akun: '.$nip.' / 123456']);
  case 'guru_delete':
    adminOnly(); $id=(int)req('id');
    $pdo->prepare("DELETE FROM users WHERE guru_id=?")->execute([$id]);
    $pdo->prepare("DELETE FROM guru WHERE id=?")->execute([$id]);
    out(['ok'=>true]);

  case 'absensi_save':
    $u=auth(); $guruId=(int)req('guru_id'); if($u['role']==='guru') $guruId=(int)$u['guru_id'];
    if(!$guruId || !canSeeGuru($guruId,$u)) out(['ok'=>false,'message'=>'Tidak berhak mengisi guru ini.'],403);
    $tanggal=req('tanggal'); $masuk=req('masuk')?:null; $pulang=req('pulang')?:null; $status=req('status','HADIR'); $ket=trim(req('keterangan',''));
    if(!$tanggal) out(['ok'=>false,'message'=>'Tanggal wajib diisi.'],422);
    $sql="INSERT INTO absensi(guru_id,tanggal,masuk,pulang,status,keterangan) VALUES(?,?,?,?,?,?) ON DUPLICATE KEY UPDATE masuk=VALUES(masuk),pulang=VALUES(pulang),status=VALUES(status),keterangan=VALUES(keterangan)";
    $pdo->prepare($sql)->execute([$guruId,$tanggal,$masuk,$pulang,$status,$ket]);
    out(['ok'=>true,'message'=>'Data kehadiran tersimpan.']);

  case 'absensi_list':
    $u=auth(); $tanggal=req('tanggal',date('Y-m-d'));
    if($u['role']==='guru'){
      $s=$pdo->prepare("SELECT a.*,g.nip,g.nama,g.jabatan FROM absensi a JOIN guru g ON g.id=a.guru_id WHERE a.tanggal=? AND a.guru_id=? ORDER BY g.nama");
      $s->execute([$tanggal,$u['guru_id']]);
    } else {
      $s=$pdo->prepare("SELECT a.*,g.nip,g.nama,g.jabatan FROM absensi a JOIN guru g ON g.id=a.guru_id WHERE a.tanggal=? ORDER BY g.nama");
      $s->execute([$tanggal]);
    }
    out(['ok'=>true,'data'=>$s->fetchAll()]);

  case 'rekap':
    $u=auth(); $tanggal=req('tanggal',date('Y-m-d')); $status=trim(req('status','')); $cari=trim(req('cari',''));
    $params=[]; $where=[];
    if($u['role']==='guru'){ $where[]='g.id=?'; $params[]=$u['guru_id']; }
    if($cari!==''){ $where[]='(g.nama LIKE ? OR g.nip LIKE ?)'; $params[]="%$cari%"; $params[]="%$cari%"; }
    $w=$where?'WHERE '.implode(' AND ',$where):'';
    $sql="SELECT g.id,g.nip,g.nama,g.jabatan,a.tanggal,a.masuk,a.pulang,a.status,a.keterangan FROM guru g LEFT JOIN absensi a ON a.guru_id=g.id AND a.tanggal=? $w ORDER BY g.nama";
    array_unshift($params,$tanggal);
    $s=$pdo->prepare($sql); $s->execute($params); $rows=$s->fetchAll();
    foreach($rows as &$r){ $r['status']=$r['status']?:'BELUM ABSEN'; if($status!=='' && $r['status']!==$status) $r['_hide']=1; }
    $rows=array_values(array_filter($rows,fn($r)=>empty($r['_hide'])));
    out(['ok'=>true,'data'=>$rows]);

  case 'izin_add':
    $u=auth(); $guruId=(int)req('guru_id'); if($u['role']==='guru') $guruId=(int)$u['guru_id'];
    if(!$guruId || !canSeeGuru($guruId,$u)) out(['ok'=>false,'message'=>'Tidak berhak mengajukan untuk guru ini.'],403);
    $tanggal=req('tanggal'); $jenis=req('jenis','IZIN'); $ket=trim(req('keterangan',''));
    if(!$tanggal||!$ket) out(['ok'=>false,'message'=>'Tanggal dan keterangan wajib diisi.'],422);
    $filePath=null;
    if(isset($_FILES['berkas']) && $_FILES['berkas']['error']!==UPLOAD_ERR_NO_FILE){
      $f=$_FILES['berkas']; if($f['error']!==UPLOAD_ERR_OK) out(['ok'=>false,'message'=>'Upload berkas gagal.'],422);
      if($f['size']>5*1024*1024) out(['ok'=>false,'message'=>'Berkas maksimal 5 MB.'],422);
      $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION)); $allowed=['pdf','jpg','jpeg','png'];
      if(!in_array($ext,$allowed,true)) out(['ok'=>false,'message'=>'Format berkas harus PDF/JPG/JPEG/PNG.'],422);
      $name=bin2hex(random_bytes(16)).'.'.$ext; $dir=__DIR__.'/uploads/izin'; if(!is_dir($dir)) mkdir($dir,0755,true);
      if(!move_uploaded_file($f['tmp_name'],$dir.'/'.$name)) out(['ok'=>false,'message'=>'Berkas tidak dapat disimpan.'],500);
      $filePath=$name;
    }
    $pdo->prepare("INSERT INTO izin(guru_id,tanggal,jenis,keterangan,berkas) VALUES(?,?,?,?,?)")->execute([$guruId,$tanggal,$jenis,$ket,$filePath]);
    out(['ok'=>true,'message'=>'Pengajuan berhasil disimpan.']);

  case 'izin_list':
    $u=auth(); $params=[]; $where=[];
    if($u['role']==='guru'){ $where[]='i.guru_id=?'; $params[]=$u['guru_id']; }
    $sql="SELECT i.*,g.nip,g.nama FROM izin i JOIN guru g ON g.id=i.guru_id ".($where?'WHERE '.implode(' AND ',$where):'')." ORDER BY i.created_at DESC";
    $s=$pdo->prepare($sql); $s->execute($params); out(['ok'=>true,'data'=>$s->fetchAll()]);
  case 'izin_status':
    adminOnly(); $id=(int)req('id'); $status=req('status'); if(!in_array($status,['Menunggu','Disetujui','Ditolak'],true)) out(['ok'=>false,'message'=>'Status tidak valid.'],422);
    $pdo->prepare("UPDATE izin SET status=? WHERE id=?")->execute([$status,$id]); out(['ok'=>true]);
  case 'file':
    $u=auth(); $id=(int)($_GET['id']??0);
    $s=$pdo->prepare("SELECT i.*,g.id AS gid FROM izin i JOIN guru g ON g.id=i.guru_id WHERE i.id=?"); $s->execute([$id]); $r=$s->fetch();
    if(!$r || !$r['berkas'] || !canSeeGuru($r['gid'],$u)) { http_response_code(404); exit('Berkas tidak ditemukan'); }
    $path=__DIR__.'/uploads/izin/'.$r['berkas']; if(!is_file($path)){http_response_code(404);exit('File tidak ditemukan');}
    $ext=strtolower(pathinfo($path,PATHINFO_EXTENSION)); $mime=['pdf'=>'application/pdf','jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png'][$ext]??'application/octet-stream';
    header('Content-Type: '.$mime); header('Content-Disposition: inline; filename="berkas-'.$id.'.'.$ext.'"'); readfile($path); exit;

  case 'settings_get':
    auth(); $r=$pdo->query("SELECT * FROM settings WHERE id=1")->fetch(); out(['ok'=>true,'data'=>$r?:[]]);
  case 'settings_save':
    adminOnly(); $nama=trim(req('nama')); $tahun=trim(req('tahun')); $alamat=trim(req('alamat'));
    $r=$pdo->query("SELECT * FROM settings WHERE id=1")->fetch(); $logo=$r['logo']??null; $bg=$r['background']??null;
    foreach([['logo','logo',2],['background','background',5]] as $x){
      [$field,$post,$max]=$x;
      if(isset($_FILES[$field]) && $_FILES[$field]['error']!==UPLOAD_ERR_NO_FILE){
        $f=$_FILES[$field]; if($f['size']>$max*1024*1024) out(['ok'=>false,'message'=>strtoupper($field).' terlalu besar.'],422);
        $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION)); if(!in_array($ext,['png','jpg','jpeg'],true)) out(['ok'=>false,'message'=>'Format gambar tidak valid.'],422);
        $name=$field.'_'.bin2hex(random_bytes(10)).'.'.$ext; $dir=__DIR__.'/uploads/settings'; if(!is_dir($dir)) mkdir($dir,0755,true);
        if(!move_uploaded_file($f['tmp_name'],$dir.'/'.$name)) out(['ok'=>false,'message'=>'Gambar gagal disimpan.'],500);
        if($field==='logo') $logo=$name; else $bg=$name;
      }
    }
    $pdo->prepare("INSERT INTO settings(id,nama_sekolah,tahun_pelajaran,alamat,logo,background) VALUES(1,?,?,?,?,?) ON DUPLICATE KEY UPDATE nama_sekolah=VALUES(nama_sekolah),tahun_pelajaran=VALUES(tahun_pelajaran),alamat=VALUES(alamat),logo=VALUES(logo),background=VALUES(background)")->execute([$nama,$tahun,$alamat,$logo,$bg]);
    out(['ok'=>true,'message'=>'Pengaturan tersimpan.']);

  case 'dashboard':
    $u=auth(); $today=date('Y-m-d'); $params=[]; $where='';
    if($u['role']==='guru'){ $where=' WHERE g.id=?'; $params[]=$u['guru_id']; }
    $total=(int)$pdo->query("SELECT COUNT(*) c FROM guru")->fetch()['c'];
    if($u['role']==='guru') $total=1;
    $sql="SELECT a.*,g.nama,g.jabatan FROM absensi a JOIN guru g ON g.id=a.guru_id WHERE a.tanggal=?".($u['role']==='guru'?' AND g.id=?':'');
    $p=[$today]; if($u['role']==='guru') $p[]=$u['guru_id']; $s=$pdo->prepare($sql); $s->execute($p); $rows=$s->fetchAll();
    $hadir=count(array_filter($rows,fn($r)=>$r['status']==='HADIR')); $izin=count(array_filter($rows,fn($r)=>$r['status']==='IZIN'));
    $belum=max(0,$total-count($rows));
    out(['ok'=>true,'total'=>$total,'hadir'=>$hadir,'izin'=>$izin,'belum'=>$belum,'rows'=>$rows]);
  default: out(['ok'=>false,'message'=>'Aksi tidak dikenal.'],400);
 }
} catch(Throwable $e){ out(['ok'=>false,'message'=>'Terjadi kesalahan server.'],500); }
