<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Kehadiran Guru</title>
<style>
/* =========================================================
   RESET & DASAR
========================================================= */
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:
        Inter,
        "Segoe UI",
        Arial,
        sans-serif;

    background:
        linear-gradient(
            135deg,
            #e9ecef,
            #ffffff,
            #dfe3e6
        );

    color:#30353a;
    min-height:100vh;

    transition:
        background .5s ease,
        color .4s ease;
}

/* Background gambar */
body::before{
    content:"";

    position:fixed;
    inset:0;

    background-image:var(--background-image, none);
    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    opacity:.18;

    z-index:-1;
}

/* =========================================================
   LOGIN
========================================================= */
.login-screen{
    min-height:100vh;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:20px;

    background:
        linear-gradient(
            135deg,
            rgba(225,228,231,.88),
            rgba(255,255,255,.82)
        );
}

.login-card{
    width:100%;
    max-width:430px;

    padding:35px;

    background:rgba(255,255,255,.72);

    border:
        1px solid
        rgba(255,255,255,.65);

    border-radius:25px;

    backdrop-filter:blur(20px);
    -webkit-backdrop-filter:blur(20px);

    box-shadow:
        0 25px 70px
        rgba(50,55,60,.15);

    animation:
        loginAnimation .6s ease;
}

@keyframes loginAnimation{

    from{
        opacity:0;
        transform:
            translateY(25px)
            scale(.97);
    }

    to{
        opacity:1;
        transform:none;
    }
}

.login-logo{
    width:90px;
    height:90px;

    margin:0 auto 18px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:50%;

    background:#fff;

    border:
        1px solid
        #ddd;

    overflow:hidden;
}

.login-logo img{
    width:100%;
    height:100%;

    object-fit:cover;
}

.login-title{
    text-align:center;

    font-size:24px;

    margin-bottom:8px;
}

.login-subtitle{
    text-align:center;

    color:#777;

    font-size:13px;

    margin-bottom:25px;
}

/* =========================================================
   INPUT
========================================================= */
.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;

    margin-bottom:7px;

    font-size:13px;

    font-weight:600;
}

.form-control,
select,
textarea{
    width:100%;

    border:
        1px solid
        #d4d8dc;

    border-radius:11px;

    padding:12px 13px;

    background:
        rgba(255,255,255,.78);

    color:#333;

    outline:none;

    transition:
        border .25s ease,
        box-shadow .25s ease,
        transform .25s ease;
}

.form-control:focus,
select:focus,
textarea:focus{

    border-color:#777;

    box-shadow:
        0 0 0 3px
        rgba(90,95,100,.10);
}

/* =========================================================
   BUTTON
========================================================= */
.btn{
    border:none;

    padding:
        11px
        15px;

    border-radius:10px;

    cursor:pointer;

    font-weight:600;

    transition:
        all .25s ease;
}

.btn:hover{
    transform:translateY(-2px);

    box-shadow:
        0 8px 20px
        rgba(0,0,0,.10);
}

.btn-primary{
    background:
        linear-gradient(
            135deg,
            #51575c,
            #737a80
        );

    color:white;
}

.btn-secondary{
    background:#e3e6e8;

    color:#34383c;
}

.btn-danger{
    background:#7c5656;

    color:white;
}

.btn-success{
    background:#596c60;

    color:white;
}

.btn-full{
    width:100%;
}

/* =========================================================
   APP
========================================================= */
.app{
    display:none;

    min-height:100vh;
}

/* =========================================================
   SIDEBAR
========================================================= */
.sidebar{
    position:fixed;

    top:0;
    left:0;
    bottom:0;

    width:250px;

    padding:20px;

    color:white;

    background:
        linear-gradient(
            180deg,
            rgba(57,62,67,.94),
            rgba(82,88,94,.90)
        );

    backdrop-filter:blur(20px);

    box-shadow:
        5px 0
        30px
        rgba(0,0,0,.10);

    z-index:100;
}

.sidebar-brand{
    text-align:center;

    padding:
        5px
        0
        25px;
}

.sidebar-logo{
    width:72px;
    height:72px;

    margin:auto;

    border-radius:50%;

    overflow:hidden;

    background:white;

    padding:4px;
}

.sidebar-logo img{
    width:100%;
    height:100%;

    object-fit:cover;

    border-radius:50%;
}

.sidebar-brand h2{
    font-size:17px;

    margin-top:12px;

    word-break:break-word;
}

.sidebar-brand small{
    opacity:.7;

    font-size:11px;
}

/* =========================================================
   MENU
========================================================= */
.menu{
    display:flex;

    flex-direction:column;

    gap:7px;
}

.menu button{

    width:100%;

    border:none;

    color:#f1f1f1;

    background:transparent;

    text-align:left;

    padding:
        12px
        14px;

    border-radius:11px;

    cursor:pointer;

    transition:
        all .25s ease;
}

.menu button:hover,
.menu button.active{

    background:
        rgba(255,255,255,.14);

    transform:
        translateX(3px);
}

/* =========================================================
   MAIN
========================================================= */
.main{
    margin-left:250px;

    padding:22px;

    min-height:100vh;
}

/* =========================================================
   TOPBAR
========================================================= */
.topbar{

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:15px;

    padding:
        15px
        20px;

    border-radius:18px;

    background:
        rgba(255,255,255,.72);

    border:
        1px solid
        rgba(255,255,255,.65);

    backdrop-filter:blur(18px);

    box-shadow:
        0 15px 40px
        rgba(40,45,50,.08);
}

.topbar h1{
    font-size:22px;
}

.topbar-user{
    font-size:13px;

    color:#777;
}

/* =========================================================
   PAGE
========================================================= */
.page{
    display:none;

    margin-top:20px;

    animation:
        pageAnimation .35s ease;
}

.page.active{
    display:block;
}

@keyframes pageAnimation{

    from{
        opacity:0;

        transform:
            translateY(10px);
    }

    to{
        opacity:1;

        transform:none;
    }
}

/* =========================================================
   CARD
========================================================= */
.card{

    background:
        rgba(255,255,255,.72);

    border:
        1px solid
        rgba(255,255,255,.65);

    border-radius:18px;

    padding:20px;

    backdrop-filter:blur(18px);

    box-shadow:
        0 15px 40px
        rgba(40,45,50,.08);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}

.card:hover{

    transform:
        translateY(-3px);

    box-shadow:
        0 20px 45px
        rgba(40,45,50,.12);
}

/* =========================================================
   STATISTIK
========================================================= */
.stats-grid{

    display:grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:16px;
}

.stat-title{

    color:#777;

    font-size:13px;
}

.stat-number{

    display:block;

    margin-top:8px;

    font-size:30px;

    font-weight:700;
}

/* =========================================================
   PANEL
========================================================= */
.panel{

    margin-top:18px;

    padding:20px;

    background:
        rgba(255,255,255,.72);

    border:
        1px solid
        rgba(255,255,255,.65);

    border-radius:18px;

    backdrop-filter:blur(18px);

    box-shadow:
        0 15px 40px
        rgba(40,45,50,.08);
}

.panel-title{

    font-size:18px;

    margin-bottom:15px;
}

/* =========================================================
   GRID FORM
========================================================= */
.form-grid{

    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:15px;
}

.full{
    grid-column:1/-1;
}

.actions{

    display:flex;

    flex-wrap:wrap;

    gap:8px;

    margin-top:15px;
}

/* =========================================================
   TABLE
========================================================= */
.table-container{

    width:100%;

    overflow-x:auto;

    border-radius:12px;

    border:
        1px solid
        #e0e3e5;
}

table{

    width:100%;

    border-collapse:collapse;

    min-width:750px;
}

th,
td{

    padding:
        11px
        12px;

    border-bottom:
        1px solid
        #e5e7e9;

    font-size:13px;

    text-align:left;
}

th{

    background:
        rgba(235,238,240,.85);

    font-weight:700;
}

tr:hover td{

    background:
        rgba(245,246,247,.7);
}

/* =========================================================
   BADGE
========================================================= */
.badge{

    display:inline-block;

    padding:
        5px
        9px;

    border-radius:50px;

    font-size:11px;

    font-weight:700;
}

.badge-hadir{
    background:#dce8df;
    color:#405848;
}

.badge-izin{
    background:#eee3d2;
    color:#715b3d;
}

.badge-sakit{
    background:#dfe5ee;
    color:#4f5d72;
}

.badge-dinas{
    background:#e4e0eb;
    color:#5d5570;
}

.badge-alpa{
    background:#eadcdc;
    color:#704c4c;
}

.badge-belum{
    background:#e5e5e5;
    color:#777;
}

/* =========================================================
   NOTICE
========================================================= */
.notice{

    padding:12px 14px;

    margin-bottom:15px;

    border-radius:11px;

    background:
        rgba(235,237,239,.70);

    color:#666;

    font-size:13px;
}

/* =========================================================
   EMPTY
========================================================= */
.empty{

    text-align:center;

    padding:35px;

    color:#888;

    font-size:14px;
}

/* =========================================================
   FILE
========================================================= */
.file-box{

    border:
        1px dashed
        #bbb;

    padding:14px;

    border-radius:12px;

    background:
        rgba(255,255,255,.40);
}

/* =========================================================
   MOBILE
========================================================= */
@media(max-width:1000px){

    .stats-grid{
        grid-template-columns:
            repeat(2,1fr);
    }
}

@media(max-width:750px){

    .sidebar{

        position:relative;

        width:100%;

        min-height:auto;
    }

    .main{

        margin-left:0;

        padding:14px;
    }

    .stats-grid{

        grid-template-columns:1fr;
    }

    .form-grid{

        grid-template-columns:1fr;
    }

    .full{

        grid-column:auto;
    }

    .topbar{

        flex-direction:column;

        align-items:flex-start;
    }
}

/* =========================================================
   PRINT
========================================================= */
@media print{

    body{
        background:white!important;
    }

    body::before{
        display:none;
    }

    .sidebar,
    .topbar,
    .no-print{
        display:none!important;
    }

    .main{

        margin:0;

        padding:0;
    }

    .panel{

        background:white!important;

        border:none!important;

        box-shadow:none!important;
    }

    table{

        min-width:100%;
    }
}
</style>
</head>
<body>


<!-- ======================================================
     LOGIN
====================================================== -->

<div id="loginScreen" class="login-screen">

    <div class="login-card">

        <div class="login-logo">

            <img
                id="loginLogo"
                alt="Logo"
                src=""
                style="display:none;"
            >

            <span id="loginLogoText"
                style="font-size:30px;">
                🏫
            </span>

        </div>

        <h1
            class="login-title"
            id="loginSchoolName"
        >
            Sistem Kehadiran Guru
        </h1>

        <p class="login-subtitle">
            Silakan masuk untuk menggunakan sistem
        </p>

        <div class="notice">

            Gunakan akun yang diberikan administrator. Data tersimpan di database server.

        </div>

        <div class="form-group">

            <label>
                Nama Pengguna
            </label>

            <input
                type="text"
                id="loginName"
                class="form-control"
                placeholder="Username / NIP"
            >

        </div>

        <div class="form-group">
            <label>Password</label>
            <input
                type="password"
                id="loginPassword"
                class="form-control"
                placeholder="Masukkan password"
                autocomplete="current-password"
            >
        </div>

        <div class="form-group">

            <label>
                Peran
            </label>

            <select
                id="loginRole"
                class="form-control"
            >

                <option value="admin">
                    Admin
                </option>

                <option value="guru">
                    Guru
                </option>

                <option value="kepala">
                    Kepala Sekolah
                </option>

            </select>

        </div>

        <button
            class="btn btn-primary btn-full"
            onclick="login()"
        >
            🔐 Masuk
        </button>

    </div>

</div>


<!-- ======================================================
     APP
====================================================== -->

<div
    id="app"
    class="app"
>

<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="sidebar-brand">

        <div class="sidebar-logo">

            <img
                id="sidebarLogo"
                alt="Logo"
                style="display:none;"
            >

            <span
                id="sidebarLogoText"
                style="font-size:25px;"
            >
                🏫
            </span>

        </div>

        <h2 id="sidebarSchool">
            Nama Sekolah
        </h2>

        <small id="sidebarYear">
            Tahun Pelajaran
        </small>

    </div>


    <div class="menu">

        <button
            class="active"
            onclick="showPage('dashboard',this)"
        >
            🏠 Dashboard
        </button>

        <button
            onclick="showPage('absensi',this)"
        >
            🕘 Input Kehadiran
        </button>

        <button
            onclick="showPage('rekap',this)"
        >
            📊 Rekap Kehadiran
        </button>

        <button
            onclick="showPage('izin',this)"
        >
            📎 Pengajuan Izin
        </button>

        <button
            id="menuGuru"
            onclick="showPage('guru',this)"
        >
            👥 Data Guru
        </button>

        <button
            id="menuPengaturan"
            onclick="showPage('pengaturan',this)"
        >
            ⚙️ Pengaturan Admin
        </button>

        <button onclick="logout()">
            🚪 Keluar
        </button>

    </div>

</aside>


<!-- MAIN -->

<main class="main">

<header class="topbar">

    <h1 id="pageTitle">
        Dashboard
    </h1>

    <div class="topbar-user">

        Login:
        <b id="currentUser">
            -
        </b>

        ·

        <span id="currentRole">
            -
        </span>

    </div>

</header>


<!-- ======================================================
     DASHBOARD
====================================================== -->

<section
    id="dashboard"
    class="page active"
>

    <div class="stats-grid">

        <div class="card">

            <span class="stat-title">
                Total Guru
            </span>

            <strong
                class="stat-number"
                id="totalGuru"
            >
                0
            </strong>

        </div>


        <div class="card">

            <span class="stat-title">
                Hadir Hari Ini
            </span>

            <strong
                class="stat-number"
                id="totalHadir"
            >
                0
            </strong>

        </div>


        <div class="card">

            <span class="stat-title">
                Izin Hari Ini
            </span>

            <strong
                class="stat-number"
                id="totalIzin"
            >
                0
            </strong>

        </div>


        <div class="card">

            <span class="stat-title">
                Belum Absen
            </span>

            <strong
                class="stat-number"
                id="totalBelum"
            >
                0
            </strong>

        </div>

    </div>


    <div class="panel">

        <h3 class="panel-title">
            👨‍🏫 Guru yang Hadir Hari Ini
        </h3>

        <div id="dashboardHadir">

            <div class="empty">
                Belum ada guru yang hadir.
            </div>

        </div>

    </div>

</section>


<!-- ======================================================
     INPUT ABSENSI
====================================================== -->

<section
    id="absensi"
    class="page"
>

    <div class="panel">

        <h3 class="panel-title">
            🕘 Input Kehadiran Guru
        </h3>

        <div class="notice">

            Pilih guru dari Data Guru.
            Data guru harus dimasukkan terlebih dahulu.

        </div>

        <div class="form-grid">

            <div class="form-group">

                <label>
                    Guru
                </label>

                <select
                    id="absGuru"
                    class="form-control"
                ></select>

            </div>


            <div class="form-group">

                <label>
                    Tanggal
                </label>

                <input
                    type="date"
                    id="absTanggal"
                    class="form-control"
                >

            </div>


            <div class="form-group">

                <label>
                    Jam Masuk
                </label>

                <input
                    type="time"
                    id="absMasuk"
                    class="form-control"
                >

            </div>


            <div class="form-group">

                <label>
                    Jam Pulang
                </label>

                <input
                    type="time"
                    id="absPulang"
                    class="form-control"
                >

            </div>


            <div class="form-group">

                <label>
                    Status
                </label>

                <select
                    id="absStatus"
                    class="form-control"
                >

                    <option value="HADIR">
                        HADIR
                    </option>

                    <option value="IZIN">
                        IZIN
                    </option>

                    <option value="SAKIT">
                        SAKIT
                    </option>

                    <option value="DINAS">
                        DINAS
                    </option>

                    <option value="ALPA">
                        ALPA
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Keterangan
                </label>

                <input
                    type="text"
                    id="absKeterangan"
                    class="form-control"
                    placeholder="Keterangan"
                >

            </div>

        </div>


        <div class="actions">

            <button
                class="btn btn-primary"
                onclick="simpanAbsensi()"
            >
                💾 Simpan Kehadiran
            </button>

        </div>

    </div>

</section>


<!-- ======================================================
     REKAP
====================================================== -->

<section
    id="rekap"
    class="page"
>

    <div class="panel">

        <h3 class="panel-title">
            📊 Rekap Kehadiran Seluruh Guru
        </h3>

        <div class="notice">

            Semua guru yang sudah dimasukkan
            ke Data Guru akan tampil di sini.
            Guru yang belum mengisi absensi akan
            tetap ditampilkan dengan status
            <b>BELUM ABSEN</b>.

        </div>


        <div class="form-grid">

            <div class="form-group">

                <label>
                    Tanggal
                </label>

                <input
                    type="date"
                    id="rekapTanggal"
                    class="form-control"
                    onchange="renderRekap()"
                >

            </div>


            <div class="form-group">

                <label>
                    Status
                </label>

                <select
                    id="rekapStatus"
                    class="form-control"
                    onchange="renderRekap()"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option value="HADIR">
                        HADIR
                    </option>

                    <option value="IZIN">
                        IZIN
                    </option>

                    <option value="SAKIT">
                        SAKIT
                    </option>

                    <option value="DINAS">
                        DINAS
                    </option>

                    <option value="ALPA">
                        ALPA
                    </option>

                    <option value="BELUM ABSEN">
                        BELUM ABSEN
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Cari Nama
                </label>

                <input
                    type="text"
                    id="rekapCari"
                    class="form-control"
                    placeholder="Cari guru..."
                    oninput="renderRekap()"
                >

            </div>


            <div class="form-group">

                <label>
                    Aksi
                </label>

                <div class="actions">

                    <button
                        class="btn btn-primary no-print"
                        onclick="cetakRekap()"
                    >
                        🖨️ Cetak
                    </button>

                    <button
                        class="btn btn-success no-print"
                        onclick="exportCSV()"
                    >
                        📥 Export CSV
                    </button>

                </div>

            </div>

        </div>


        <div
            id="rekapContainer"
            class="table-container"
        ></div>

    </div>

</section>


<!-- ======================================================
     IZIN
====================================================== -->

<section
    id="izin"
    class="page"
>

    <div class="panel">

        <h3 class="panel-title">
            📎 Pengajuan Izin / Surat Pendukung
        </h3>

        <div class="form-grid">

            <div class="form-group">

                <label>
                    Guru
                </label>

                <select
                    id="izinGuru"
                    class="form-control"
                ></select>

            </div>


            <div class="form-group">

                <label>
                    Tanggal
                </label>

                <input
                    type="date"
                    id="izinTanggal"
                    class="form-control"
                >

            </div>


            <div class="form-group">

                <label>
                    Jenis
                </label>

                <select
                    id="izinJenis"
                    class="form-control"
                >

                    <option value="IZIN">
                        IZIN
                    </option>

                    <option value="SAKIT">
                        SAKIT
                    </option>

                    <option value="DINAS">
                        DINAS
                    </option>

                </select>

            </div>


            <div class="form-group file-box">

                <label>
                    Surat / Berkas
                </label>

                <input
                    type="file"
                    id="izinFile"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png"
                >

                <small>
                    PDF/JPG/JPEG/PNG maksimal 5 MB.
                </small>

            </div>


            <div class="form-group full">

                <label>
                    Keterangan
                </label>

                <textarea
                    id="izinKeterangan"
                    placeholder="Masukkan keterangan izin..."
                ></textarea>

            </div>

        </div>


        <div class="actions">

            <button
                class="btn btn-primary"
                onclick="simpanIzin()"
            >
                📤 Kirim Pengajuan
            </button>

        </div>

    </div>


    <div class="panel">

        <h3 class="panel-title">
            Riwayat Pengajuan
        </h3>

        <div
            id="izinContainer"
            class="table-container"
        ></div>

    </div>

</section>


<!-- ======================================================
     DATA GURU
====================================================== -->

<section
    id="guru"
    class="page"
>

    <div class="panel">

        <h3 class="panel-title">
            👥 Data Guru
        </h3>

        <div class="notice">

            <b>Data awal kosong.</b>

            Tambahkan guru satu per satu
            atau upload file CSV.

        </div>


        <div class="form-grid">

            <div class="form-group">

                <label>
                    NIP / ID
                </label>

                <input
                    id="guruNip"
                    class="form-control"
                    placeholder="NIP / ID guru"
                >

            </div>


            <div class="form-group">

                <label>
                    Nama Lengkap
                </label>

                <input
                    id="guruNama"
                    class="form-control"
                    placeholder="Nama lengkap guru"
                >

            </div>


            <div class="form-group">

                <label>
                    Jabatan
                </label>

                <input
                    id="guruJabatan"
                    class="form-control"
                    placeholder="Guru / Wakasek / dll"
                >

            </div>


            <div class="form-group">

                <label>
                    Nomor HP
                </label>

                <input
                    id="guruHp"
                    class="form-control"
                    placeholder="Nomor HP"
                >

            </div>

        </div>


        <div class="actions">

            <button
                class="btn btn-primary"
                onclick="tambahGuru()"
            >
                ➕ Tambah Guru
            </button>


            <button
                class="btn btn-secondary"
                onclick="document.getElementById('fileCSV').click()"
            >
                📥 Upload CSV
            </button>


            <input
                type="file"
                id="fileCSV"
                accept=".csv"
                style="display:none"
                onchange="uploadCSV(this.files[0])"
            >


            <button
                class="btn btn-secondary"
                onclick="downloadTemplateCSV()"
            >
                📄 Download Template CSV
            </button>

        </div>


        <div class="notice" style="margin-top:15px">

            Format CSV:

            <b>
                nip,nama,jabatan,hp
            </b>

        </div>

    </div>


    <div class="panel">

        <h3 class="panel-title">
            Daftar Seluruh Guru
        </h3>

        <div
            id="guruContainer"
            class="table-container"
        ></div>

    </div>

</section>


<!-- ======================================================
     PENGATURAN
====================================================== -->

<section
    id="pengaturan"
    class="page"
>

    <div class="panel">

        <h3 class="panel-title">
            ⚙️ Pengaturan Admin
        </h3>


        <div class="form-grid">

            <div class="form-group">

                <label>
                    Nama Sekolah
                </label>

                <input
                    id="namaSekolah"
                    class="form-control"
                    placeholder="Isi nama sekolah"
                >

            </div>


            <div class="form-group">

                <label>
                    Tahun Pelajaran
                </label>

                <input
                    id="tahunPelajaran"
                    class="form-control"
                    placeholder="Contoh: 2026/2027"
                >

            </div>


            <div class="form-group full">

                <label>
                    Alamat Sekolah
                </label>

                <textarea
                    id="alamatSekolah"
                    placeholder="Isi alamat sekolah"
                ></textarea>

            </div>


            <div class="form-group file-box">

                <label>
                    🖼️ Upload Logo
                </label>

                <input
                    type="file"
                    id="logoUpload"
                    class="form-control"
                    accept=".png,.jpg,.jpeg"
                >

                <small>
                    PNG/JPG/JPEG maksimal 2 MB.
                </small>

            </div>


            <div class="form-group file-box">

                <label>
                    🌄 Upload Background
                </label>

                <input
                    type="file"
                    id="backgroundUpload"
                    class="form-control"
                    accept=".png,.jpg,.jpeg"
                >

                <small>
                    PNG/JPG/JPEG maksimal 5 MB.
                </small>

            </div>

        </div>


        <div class="actions">

            <button
                class="btn btn-primary"
                onclick="simpanPengaturan()"
            >
                💾 Simpan Pengaturan
            </button>


            <button
                class="btn btn-danger"
                onclick="hapusSemuaData()"
            >
                🗑️ Hapus Semua Data
            </button>

        </div>

    </div>

</section>


</main>

</div>


<script>
const API='api.php';
let ME=null, SETTINGS={};

async function api(action, data={}, files=null){
  let opt={method:'POST'};
  if(files){ const fd=new FormData(); fd.append('action',action); Object.entries(data).forEach(([k,v])=>fd.append(k,v??'')); Object.entries(files).forEach(([k,v])=>{if(v)fd.append(k,v)}); opt.body=fd; }
  else { const fd=new FormData(); fd.append('action',action); Object.entries(data).forEach(([k,v])=>fd.append(k,v??'')); opt.body=fd; }
  const r=await fetch(API,opt); let j={}; try{j=await r.json()}catch(e){j={ok:false,message:'Server mengembalikan respons tidak valid.'}};
  if(r.status===401){logout(false); throw new Error(j.message||'Sesi login berakhir.');}
  if(!j.ok) throw new Error(j.message||'Permintaan gagal.');
  return j;
}
function escapeHTML(value){return String(value??'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;')}
function today(){return new Date().toISOString().split('T')[0]}
function formatTanggal(d){if(!d)return '-';let p=d.split('-');return p.length===3?`${p[2]}-${p[1]}-${p[0]}`:d}
function statusBadge(s){let cls={HADIR:'badge-hadir',IZIN:'badge-izin',SAKIT:'badge-sakit',DINAS:'badge-dinas',ALPA:'badge-alpa','BELUM ABSEN':'badge-belum'}[s]||'badge-belum';return `<span class="badge ${cls}">${escapeHTML(s)}</span>`}

function showError(e){alert(e.message||e)}
async function login(){
  const username=document.getElementById('loginName').value.trim(), password=document.getElementById('loginPassword').value;
  if(!username||!password){alert('Username dan password wajib diisi.');return}
  try{const j=await api('login',{username,password});ME=j.user; masukAplikasi()}catch(e){showError(e)}
}
async function masukAplikasi(){
  if(!ME)return;
  document.getElementById('loginScreen').style.display='none'; document.getElementById('app').style.display='block';
  document.getElementById('currentUser').textContent=ME.nama; document.getElementById('currentRole').textContent=ME.role;
  document.getElementById('menuGuru').style.display=ME.role==='admin'?'block':'none';
  document.getElementById('menuPengaturan').style.display=ME.role==='admin'?'block':'none';
  document.getElementById('absGuru').disabled=ME.role==='guru';
  await loadSettings(); await refreshAll();
}
async function logout(reload=true){try{await api('logout')}catch(e){} ME=null; if(reload)location.reload()}
function showPage(page,button){
  if(page==='guru'&&ME.role!=='admin'){alert('Menu Data Guru hanya untuk Admin.');return}
  if(page==='pengaturan'&&ME.role!=='admin'){alert('Pengaturan hanya untuk Admin.');return}
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active')); document.getElementById(page)?.classList.add('active');
  document.querySelectorAll('.menu button').forEach(b=>b.classList.remove('active')); button?.classList.add('active');
  const titles={dashboard:'Dashboard',absensi:'Input Kehadiran',rekap:'Rekap Kehadiran',izin:'Pengajuan Izin',guru:'Data Guru',pengaturan:'Pengaturan Admin'};
  document.getElementById('pageTitle').textContent=titles[page]||'Dashboard';
  if(page==='rekap')renderRekap();
  if(page==='izin')renderIzin();
  if(page==='guru')renderGuru();
}

async function loadSettings(){
  try{const j=await api('settings_get'); SETTINGS=j.data||{};}catch(e){SETTINGS={}}
  const nama=SETTINGS.nama_sekolah||'Sistem Kehadiran Guru', tahun=SETTINGS.tahun_pelajaran||'Tahun Pelajaran';
  document.getElementById('sidebarSchool').textContent=nama; document.getElementById('sidebarYear').textContent=tahun; document.getElementById('loginSchoolName').textContent=nama;
  const base='uploads/settings/';
  if(SETTINGS.logo){document.getElementById('loginLogo').src=base+SETTINGS.logo;document.getElementById('loginLogo').style.display='block';document.getElementById('loginLogoText').style.display='none';document.getElementById('sidebarLogo').src=base+SETTINGS.logo;document.getElementById('sidebarLogo').style.display='block';document.getElementById('sidebarLogoText').style.display='none'}
  if(SETTINGS.background)document.documentElement.style.setProperty('--background-image',`url("${base+SETTINGS.background}")`);
  if(ME?.role==='admin'){document.getElementById('namaSekolah').value=SETTINGS.nama_sekolah||'';document.getElementById('tahunPelajaran').value=SETTINGS.tahun_pelajaran||'';document.getElementById('alamatSekolah').value=SETTINGS.alamat||''}
}
async function refreshGuruSelect(){
  try{
    const j=await api('guru_list'), gs=j.data||[]; window.GURU=gs;
    [document.getElementById('absGuru'),document.getElementById('izinGuru')].forEach(s=>{if(!s)return;s.innerHTML=gs.length?gs.map(g=>`<option value="${g.id}">${escapeHTML(g.nama)} - ${escapeHTML(g.nip)}</option>`).join(''):'<option value="">Belum ada data guru</option>'; if(ME.role==='guru'&&gs[0])s.value=gs[0].id});
  }catch(e){showError(e)}
}
async function renderGuru(){
  if(ME.role!=='admin')return;
  try{const j=await api('guru_list'),gs=j.data||[],c=document.getElementById('guruContainer');
  c.innerHTML=gs.length?`<table><thead><tr><th>No</th><th>NIP/ID</th><th>Nama Guru</th><th>Jabatan</th><th>Nomor HP</th><th>Aksi</th></tr></thead><tbody>${gs.map((g,i)=>`<tr><td>${i+1}</td><td>${escapeHTML(g.nip)}</td><td><b>${escapeHTML(g.nama)}</b></td><td>${escapeHTML(g.jabatan)}</td><td>${escapeHTML(g.hp)}</td><td><button class="btn btn-danger" onclick="hapusGuru(${g.id})">Hapus</button></td></tr>`).join('')}</tbody></table>`:'<div class="empty">Belum ada data guru.</div>'}catch(e){showError(e)}
}
async function tambahGuru(){
  if(ME.role!=='admin')return;
  const d={nip:document.getElementById('guruNip').value.trim(),nama:document.getElementById('guruNama').value.trim(),jabatan:document.getElementById('guruJabatan').value.trim(),hp:document.getElementById('guruHp').value.trim()};
  if(!d.nip||!d.nama){alert('NIP/ID dan nama wajib diisi.');return}
  try{const j=await api('guru_add',d);['guruNip','guruNama','guruJabatan','guruHp'].forEach(id=>document.getElementById(id).value='');await refreshAll();alert(j.message)}catch(e){showError(e)}
}
async function hapusGuru(id){if(!confirm('Yakin ingin menghapus guru ini?'))return;try{await api('guru_delete',{id});await refreshAll()}catch(e){showError(e)}}
function downloadTemplateCSV(){const a=document.createElement('a');a.href=URL.createObjectURL(new Blob(['nip,nama,jabatan,hp\n'],{type:'text/csv'}));a.download='template-data-guru.csv';a.click()}
function uploadCSV(file){
  if(!file)return; const reader=new FileReader(); reader.onload=async e=>{
    const lines=e.target.result.replace(/\r/g,'').split('\n').filter(x=>x.trim()), h=lines.shift().split(',').map(x=>x.trim().toLowerCase()), ni=h.indexOf('nip'),na=h.indexOf('nama'),ja=h.indexOf('jabatan'),hp=h.indexOf('hp');
    if(ni<0||na<0){alert('Header CSV harus memiliki kolom nip dan nama.');return}
    let n=0; for(const line of lines){const c=line.split(',').map(x=>x.trim().replace(/^"|"$/g,''));const d={nip:c[ni]||'',nama:c[na]||'',jabatan:ja>=0?(c[ja]||''):'',hp:hp>=0?(c[hp]||''):''};if(d.nip&&d.nama){try{await api('guru_add',d);n++}catch(e){}}}
    await refreshAll();alert(n+' data guru berhasil diupload. Password awal setiap guru: 123456.');
  };reader.readAsText(file,'UTF-8')
}

async function simpanAbsensi(){
  const d={guru_id:document.getElementById('absGuru').value,tanggal:document.getElementById('absTanggal').value,masuk:document.getElementById('absMasuk').value,pulang:document.getElementById('absPulang').value,status:document.getElementById('absStatus').value,keterangan:document.getElementById('absKeterangan').value.trim()};
  try{const j=await api('absensi_save',d);await refreshAll();alert(j.message)}catch(e){showError(e)}
}
async function renderRekap(){
  const d={tanggal:document.getElementById('rekapTanggal').value||today(),status:document.getElementById('rekapStatus').value,cari:document.getElementById('rekapCari').value.trim()};
  try{const j=await api('rekap',d),rows=j.data||[],c=document.getElementById('rekapContainer');
  c.innerHTML=`<table id="tabelRekap"><thead><tr><th>No</th><th>NIP/ID</th><th>Nama Guru</th><th>Jabatan</th><th>Tanggal</th><th>Jam Masuk</th><th>Jam Pulang</th><th>Status</th><th>Keterangan</th></tr></thead><tbody>${rows.map((x,i)=>`<tr><td>${i+1}</td><td>${escapeHTML(x.nip)}</td><td>${escapeHTML(x.nama)}</td><td>${escapeHTML(x.jabatan||'-')}</td><td>${formatTanggal(x.tanggal||d.tanggal)}</td><td>${escapeHTML(x.masuk||'-')}</td><td>${escapeHTML(x.pulang||'-')}</td><td>${statusBadge(x.status)}</td><td>${escapeHTML(x.keterangan||'-')}</td></tr>`).join('')}</tbody></table>`}catch(e){showError(e)}
}
function exportCSV(){const table=document.getElementById('tabelRekap');if(!table){alert('Tidak ada data.');return}const rows=[...table.querySelectorAll('tr')].map(tr=>[...tr.querySelectorAll('th,td')].map(td=>`"${td.innerText.replace(/"/g,'""')}"`).join(','));const a=document.createElement('a');a.href=URL.createObjectURL(new Blob(['\uFEFF'+rows.join('\r\n')],{type:'text/csv;charset=utf-8'}));a.download='rekap-kehadiran-guru.csv';a.click()}
function cetakRekap(){window.print()}

async function simpanIzin(){
  const file=document.getElementById('izinFile').files[0], d={guru_id:document.getElementById('izinGuru').value,tanggal:document.getElementById('izinTanggal').value,jenis:document.getElementById('izinJenis').value,keterangan:document.getElementById('izinKeterangan').value.trim()};
  if(file&&file.size>5*1024*1024){alert('Berkas maksimal 5 MB.');return}
  try{const j=await api('izin_add',d,file?{berkas:file}:null);document.getElementById('izinKeterangan').value='';document.getElementById('izinFile').value='';await renderIzin();alert(j.message)}catch(e){showError(e)}
}
async function renderIzin(){
  try{const j=await api('izin_list'),rows=j.data||[],c=document.getElementById('izinContainer');
  c.innerHTML=rows.length?`<table><thead><tr><th>No</th><th>Tanggal</th><th>Nama Guru</th><th>Jenis</th><th>Keterangan</th><th>Berkas</th><th>Status</th>${ME.role==='admin'?'<th>Aksi</th>':''}</tr></thead><tbody>${rows.map((x,i)=>`<tr><td>${i+1}</td><td>${formatTanggal(x.tanggal)}</td><td>${escapeHTML(x.nama)}</td><td>${escapeHTML(x.jenis)}</td><td>${escapeHTML(x.keterangan)}</td><td>${x.berkas?`<button class="btn btn-secondary" onclick="window.open('api.php?action=file&id=${x.id}','_blank')">📎 Lihat</button>`:'-'}</td><td>${escapeHTML(x.status)}</td>${ME.role==='admin'?`<td><button class="btn btn-success" onclick="ubahIzin(${x.id},'Disetujui')">Setujui</button> <button class="btn btn-danger" onclick="ubahIzin(${x.id},'Ditolak')">Tolak</button></td>`:''}</tr>`).join('')}</tbody></table>`:'<div class="empty">Belum ada pengajuan izin.</div>'}catch(e){showError(e)}
}
async function ubahIzin(id,status){try{await api('izin_status',{id,status});await renderIzin()}catch(e){showError(e)}}

async function simpanPengaturan(){
  if(ME.role!=='admin')return;
  const data={nama:document.getElementById('namaSekolah').value.trim(),tahun:document.getElementById('tahunPelajaran').value.trim(),alamat:document.getElementById('alamatSekolah').value.trim()};
  const files={logo:document.getElementById('logoUpload').files[0],background:document.getElementById('backgroundUpload').files[0]};
  if(files.logo&&files.logo.size>2*1024*1024){alert('Logo maksimal 2 MB.');return}
  if(files.background&&files.background.size>5*1024*1024){alert('Background maksimal 5 MB.');return}
  try{const j=await api('settings_save',data,files);await loadSettings();alert(j.message)}catch(e){showError(e)}
}
async function hapusSemuaData(){alert('Pada versi hosting, penghapusan seluruh database dilakukan melalui administrator/database hosting agar tidak terhapus tanpa sengaja.');}

async function updateDashboard(){
  try{const j=await api('dashboard');document.getElementById('totalGuru').textContent=j.total;document.getElementById('totalHadir').textContent=j.hadir;document.getElementById('totalIzin').textContent=j.izin;document.getElementById('totalBelum').textContent=j.belum;
  document.getElementById('dashboardHadir').innerHTML=j.rows.filter(x=>x.status==='HADIR').length?`<div class="table-container"><table><thead><tr><th>No</th><th>NIP/ID</th><th>Nama Guru</th><th>Jabatan</th><th>Jam Masuk</th><th>Jam Pulang</th><th>Status</th></tr></thead><tbody>${j.rows.filter(x=>x.status==='HADIR').map((x,i)=>`<tr><td>${i+1}</td><td>${escapeHTML(x.nip||'')}</td><td><b>${escapeHTML(x.nama)}</b></td><td>${escapeHTML(x.jabatan||'-')}</td><td>${escapeHTML(x.masuk||'-')}</td><td>${escapeHTML(x.pulang||'-')}</td><td>${statusBadge('HADIR')}</td></tr>`).join('')}</tbody></table></div>`:'<div class="empty">Belum ada guru yang hadir.</div>'}catch(e){}
}
async function refreshAll(){await refreshGuruSelect();await renderGuru();await renderRekap();await renderIzin();await updateDashboard()}

document.addEventListener('DOMContentLoaded',async()=>{
  ['absTanggal','rekapTanggal','izinTanggal'].forEach(id=>document.getElementById(id).value=today());
  try{const j=await api('me');if(j.user){ME=j.user;await masukAplikasi()}}catch(e){}
});
</script>
</body>
</html>
