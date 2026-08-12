@extends('adminlte::page')

@section('title', 'Panduan Sistem BalaKutaK CMS')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-book-open mr-2 text-primary"></i>Panduan Penggunaan Sistem</h1>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="fas fa-print mr-1"></i> Cetak Panduan</button>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline sticky-top" style="top: 20px; z-index: 1000;">
            <div class="card-header">
                <h3 class="card-title">Navigasi Panduan</h3>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column guide-nav">
                    <li class="nav-item">
                        <a href="#intro" class="nav-link active" data-toggle="tab">
                            <i class="fas fa-info-circle mr-2"></i> Pendahuluan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#dashboard" class="nav-link" data-toggle="tab">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard & Stat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#konten" class="nav-link" data-toggle="tab">
                            <i class="fas fa-newspaper mr-2"></i> Konten Website
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#halaman" class="nav-link" data-toggle="tab">
                            <i class="fas fa-file-alt mr-2"></i> Modul Halaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sistem" class="nav-link" data-toggle="tab">
                            <i class="fas fa-cogs mr-2"></i> Sistem & Pengaturan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#builder" class="nav-link" data-toggle="tab">
                            <i class="fas fa-tools mr-2"></i> Page & Menu Builder
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="tab-content">
            <!-- Introduction -->
            <div class="tab-pane active" id="intro">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <img src="{{ asset('storage/'.\App\Models\Setting::get('site_logo')) }}" alt="Logo" class="mb-4" style="max-height: 80px;">
                            <h2 class="font-weight-bold mb-1">Selamat Datang di BalaKutaK CMS</h2>
                            <div class="mb-3">
                                <span class="badge badge-primary px-3 py-2">Versi 2.0.1 Stable</span>
                            </div>
                            <p class="text-muted lead mx-auto" style="max-width: 800px;">
                                Sistem Manajemen Konten Premium yang fleksibel dan powerful untuk pengelolaan informasi digital secara profesional.
                            </p>
                            <div class="mt-4 p-3 bg-light rounded shadow-sm d-inline-block border">
                                <p class="mb-2 text-sm font-weight-bold text-uppercase letter-spacing-1 text-primary">Multi-Purpose Application</p>
                                <p class="mb-0 text-secondary">
                                    Dirancang tidak hanya untuk <strong>Institusi Akademik & Program Studi</strong>, namun juga sangat ideal digunakan untuk:
                                    <br>
                                    <span class="text-dark font-weight-500">
                                        Sekolah • Lembaga Pendidikan • Perusahaan • Organisasi • Komunitas • Instansi Pemerintahan
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="row mb-5">
                            <div class="col-md-4 text-center mb-4">
                                <div class="icon-circle bg-light-primary mb-3">
                                    <i class="fas fa-rocket fa-2x text-primary"></i>
                                </div>
                                <h5>Cepat & Responsif</h5>
                                <p class="text-sm text-secondary">Akses cepat ke semua fitur manajemen konten harian.</p>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                <div class="icon-circle bg-light-success mb-3">
                                    <i class="fas fa-shield-alt fa-2x text-success"></i>
                                </div>
                                <h5>Keamanan Terjamin</h5>
                                <p class="text-sm text-secondary">Sistem hak akses bertingkat untuk menjaga integritas data.</p>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                <div class="icon-circle bg-light-warning mb-3">
                                    <i class="fas fa-magic fa-2x text-warning"></i>
                                </div>
                                <h5>Mudah Digunakan</h5>
                                <p class="text-sm text-secondary">Antarmuka intuitif yang dirancang untuk pengguna non-teknis.</p>
                            </div>
                        </div>

                        <div class="callout callout-info mb-0">
                            <h5><i class="fas fa-lightbulb mr-2"></i> Tips Cepat</h5>
                            <p>Gunakan tombol pencarian di atas setiap tabel untuk menemukan data dengan cepat. Hampir semua modul mendukung ekspor data dan manajemen multi-bahasa.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard -->
            <div class="tab-pane" id="dashboard">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="mb-0 font-weight-bold">Dashboard & Statistik</h4>
                    </div>
                    <div class="card-body p-4">
                        <p class="lead">Dashboard adalah pusat informasi ringkas mengenai performa website Anda.</p>
                        
                        <div class="timeline mt-4">
                            <div>
                                <i class="fas fa-chart-line bg-primary"></i>
                                <div class="timeline-item shadow-none border">
                                    <h3 class="timeline-header font-weight-bold">Statistik Pengunjung</h3>
                                    <div class="timeline-body">
                                        Grafik ini menunjukkan jumlah kunjungan harian. Anda dapat memantau kapan website paling ramai dikunjungi oleh mahasiswa atau publik.
                                    </div>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-th bg-info"></i>
                                <div class="timeline-item shadow-none border">
                                    <h3 class="timeline-header font-weight-bold">Info Box (Ringkasan Data)</h3>
                                    <div class="timeline-body">
                                        Kotak berwarna di bagian atas menampilkan jumlah total Artikel, Pengumuman, Agenda, dan Pesan Masuk yang belum dibaca.
                                    </div>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-history bg-warning"></i>
                                <div class="timeline-item shadow-none border">
                                    <h3 class="timeline-header font-weight-bold">Log Aktivitas Terbaru</h3>
                                    <div class="timeline-body">
                                        Daftar di bagian bawah menunjukkan perubahan terakhir yang dilakukan oleh tim admin lainnya. Memudahkan koordinasi antar tim.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Website Content -->
            <div class="tab-pane" id="konten">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="mb-0 font-weight-bold">Manajemen Konten Website</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="accordion shadow-sm" id="accordionKonten">
                            <!-- Berita & Artikel -->
                            <div class="card mb-2 border-0">
                                <div class="card-header bg-light py-2" id="headingBerita">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left font-weight-bold text-dark" type="button" data-toggle="collapse" data-target="#collapseBerita">
                                            <i class="fas fa-newspaper mr-2 text-primary"></i> 1. Berita & Artikel
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseBerita" class="collapse show" data-parent="#accordionKonten">
                                    <div class="card-body bg-white border">
                                        <p>Gunakan modul ini untuk konten yang bersifat kronologis atau berita terbaru.</p>
                                        <ul class="pl-4">
                                            <li><strong>Draft vs Publish:</strong> Anda dapat menyimpan artikel sebagai draft sebelum dipublikasikan.</li>
                                            <li><strong>Kategori:</strong> Kelompokkan berita (misal: Prestasi, Kegiatan, Akademik).</li>
                                            <li><strong>SEO:</strong> Pastikan judul dan meta description menarik agar mudah terindeks Google.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pengumuman -->
                            <div class="card mb-2 border-0">
                                <div class="card-header bg-light py-2" id="headingPengumuman">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapsePengumuman">
                                            <i class="fas fa-bullhorn mr-2 text-danger"></i> 2. Pengumuman
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapsePengumuman" class="collapse" data-parent="#accordionKonten">
                                    <div class="card-body bg-white border">
                                        <p>Modul untuk informasi penting yang harus segera diketahui oleh audiens.</p>
                                        <ul class="pl-4">
                                            <li><strong>Prioritas:</strong> Pengumuman biasanya muncul di bagian atas atau pada widget khusus (Marquee).</li>
                                            <li><strong>Lampiran:</strong> Hubungkan pengumuman dengan file PDF jika perlu.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Halaman Statis -->
                            <div class="card mb-2 border-0">
                                <div class="card-header bg-light py-2" id="headingHalaman">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseHalaman">
                                            <i class="fas fa-file-alt mr-2 text-info"></i> 3. Halaman Statis
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseHalaman" class="collapse" data-parent="#accordionKonten">
                                    <div class="card-body bg-white border">
                                        <p>Untuk konten yang isinya jarang berubah dan bersifat informatif tetap.</p>
                                        <ul class="pl-4">
                                            <li>Contoh: Visi & Misi, Sejarah, Struktur Organisasi.</li>
                                            <li>Halaman ini bisa dikaitkan ke Menu Utama melalui <strong>Menu Builder</strong>.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Agenda & Event -->
                            <div class="card mb-2 border-0">
                                <div class="card-header bg-light py-2" id="headingAgenda">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseAgenda">
                                            <i class="fas fa-calendar-alt mr-2 text-success"></i> 4. Agenda & Event
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseAgenda" class="collapse" data-parent="#accordionKonten">
                                    <div class="card-body bg-white border">
                                        <p>Menampilkan jadwal kegiatan mendatang (seminar, workshop, rapat, dll).</p>
                                        <ul class="pl-4">
                                            <li><strong>Waktu & Lokasi:</strong> Pastikan menginput tanggal mulai dan berakhir serta lokasi kegiatan dengan jelas.</li>
                                            <li><strong>Keterangan:</strong> Berikan deskripsi detail mengenai kegiatan tersebut.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Slider / Banner -->
                            <div class="card mb-2 border-0">
                                <div class="card-header bg-light py-2" id="headingSlider">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseSlider">
                                            <i class="fas fa-sliders-h mr-2 text-warning"></i> 5. Slider / Banner Utama
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseSlider" class="collapse" data-parent="#accordionKonten">
                                    <div class="card-body bg-white border">
                                        <p>Visual utama yang dilihat pertama kali oleh pengunjung website.</p>
                                        <ul class="pl-4">
                                            <li><strong>Resolusi:</strong> Gunakan minimal 1920x800px untuk tampilan tajam.</li>
                                            <li><strong>Overlay & Text:</strong> Hindari gambar yang terlalu cerah agar teks judul tetap terbaca.</li>
                                            <li><strong>Link:</strong> Gunakan kolom link untuk mengarahkan pengunjung ke halaman tertentu saat gambar diklik.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Galeri & Media -->
                            <div class="card mb-2 border-0">
                                <div class="card-header bg-light py-2" id="headingMedia">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseMedia">
                                            <i class="fas fa-images mr-2 text-maroon"></i> 6. Galeri Foto & Media
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseMedia" class="collapse" data-parent="#accordionKonten">
                                    <div class="card-body bg-white border">
                                        <p>Dokumentasi visual kegiatan.</p>
                                        <ul class="pl-4">
                                            <li><strong>Album:</strong> Kelompokkan foto berdasarkan kegiatan agar rapi.</li>
                                            <li><strong>Keterangan:</strong> Berikan deskripsi pada setiap album foto.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Testimoni & Mitra -->
                            <div class="card mb-0 border-0">
                                <div class="card-header bg-light py-2" id="headingLainnya">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseLainnya">
                                            <i class="fas fa-handshake mr-2 text-indigo"></i> 7. Testimoni & Mitra
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseLainnya" class="collapse" data-parent="#accordionKonten">
                                    <div class="card-body bg-white border">
                                        <div class="row">
                                            <div class="col-md-6 border-right">
                                                <h6><strong>Testimoni Alumni</strong></h6>
                                                <p class="text-xs">Unggah foto alumni, nama, tahun lulus, dan kutipan pengalaman mereka. Berguna untuk <em>branding</em> ke calon mahasiswa.</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6><strong>Mitra Kerjasama</strong></h6>
                                                <p class="text-xs">Daftar logo institusi atau perusahaan mitra. Pastikan menggunakan format PNG transparan untuk tampilan logo yang bersih.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modul Halaman -->
            <div class="tab-pane" id="halaman">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="mb-0 font-weight-bold">Modul Halaman Spesifik</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light border shadow-none h-100">
                                    <span class="info-box-icon text-primary"><i class="fas fa-university"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text font-weight-bold">Manajemen Profil</span>
                                        <span class="info-box-number text-xs font-weight-normal text-secondary">
                                            Update Informasi tentang institusi, Sejarah Singkat, Visi & Misi, serta sambutan pimpinan/dekan secara terstruktur.
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light border shadow-none h-100">
                                    <span class="info-box-icon text-success"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text font-weight-bold">Dosen & SDM</span>
                                        <span class="info-box-number text-xs font-weight-normal text-secondary">
                                            Kelola data dosen, foto, kepakaran, dan NIDN. Gunakan fitur <strong>Import Excel</strong> untuk memasukkan data massal.
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light border shadow-none h-100">
                                    <span class="info-box-icon text-warning"><i class="fas fa-book"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text font-weight-bold">Kurikulum</span>
                                        <span class="info-box-number text-xs font-weight-normal text-secondary">
                                            Atur daftar mata kuliah per semester. Pastikan kode MK dan SKS sudah benar sebelum dipublikasikan.
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light border shadow-none h-100">
                                    <span class="info-box-icon text-danger"><i class="fas fa-calendar-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text font-weight-bold">Kalender & Layanan</span>
                                        <span class="info-box-number text-xs font-weight-normal text-secondary">
                                            Update jadwal penting dan buat modul layanan akademik (beasiswa, magang, KRS) agar mahasiswa dapat mengakses link yang diperlukan.
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="card p-3 bg-light border-0">
                                    <h6><i class="fas fa-microscope mr-2 text-indigo"></i><strong>Penelitian & Pengabdian</strong></h6>
                                    <p class="mb-0 text-sm text-secondary">Modul ini digunakan untuk menampilkan daftar hasil riset dosen dan kegiatan pengabdian masyarakat. Anda dapat menyertakan link publikasi eksternal atau file abstrak.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System & Settings -->
            <div class="tab-pane" id="sistem">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-navy py-3">
                        <h4 class="mb-0 font-weight-bold"><i class="fas fa-cogs mr-2 text-warning"></i> 5. SISTEM & PENGATURAN</h4>
                    </div>
                    <div class="card-body p-4 bg-light">
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 shadow-sm border-left-primary">
                                    <div class="card-header bg-white font-weight-bold text-primary">
                                        <i class="fas fa-wrench mr-2"></i> PENGATURAN UMUM
                                    </div>
                                    <div class="card-body text-sm py-3">
                                        <p class="mb-2"><strong>Umum:</strong> Logo, Favicon, Nama Website, & Mode Maintenance.</p>
                                        <p class="mb-2"><strong>Kontak:</strong> Alamat, Map, Email, & No. Telepon resmi.</p>
                                        <p class="mb-0"><strong>Media Sosial:</strong> Link resmi FB, IG, YouTube, & X/Twitter.</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0 pt-0">
                                        <span class="badge badge-info"><i class="fas fa-user-tag mr-1"></i> Admin Prodi & Super Admin</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 shadow-sm border-left-success">
                                    <div class="card-header bg-white font-weight-bold text-success">
                                        <i class="fas fa-user-shield mr-2"></i> USER & ROLE
                                    </div>
                                    <div class="card-body text-sm py-3">
                                        <p class="mb-2"><strong>Kelola User:</strong> Tambah admin baru atau staf prodi.</p>
                                        <p class="mb-3"><strong>Role:</strong> Super Admin (Full), Admin Prodi (Content), Editor (Hanya Tulis).</p>
                                        
                                        <div class="bg-navy p-3 rounded mb-0 text-white">
                                            <p class="font-weight-bold mb-2 text-warning"><i class="fas fa-key mr-1"></i> AKUN DEFAULT (SEEDER):</p>
                                            <table class="table table-sm table-borderless mb-0 text-white" style="font-size: 11px;">
                                                <tr class="border-bottom border-secondary">
                                                    <td class="py-1">Super Admin</td>
                                                    <td class="py-1">superadmin@prodi.ac.id</td>
                                                </tr>
                                                <tr class="border-bottom border-secondary">
                                                    <td class="py-1">Admin Prodi</td>
                                                    <td class="py-1">admin@prodi.ac.id</td>
                                                </tr>
                                                <tr class="border-bottom border-secondary">
                                                    <td class="py-1">Editor Konten</td>
                                                    <td class="py-1">editor@prodi.ac.id</td>
                                                </tr>
                                                <tr class="border-bottom border-secondary">
                                                    <td class="py-1">Dosen</td>
                                                    <td class="py-1">dosen@prodi.ac.id</td>
                                                </tr>
                                                <tr class="border-bottom border-secondary">
                                                    <td class="py-1">Operator</td>
                                                    <td class="py-1">operator@prodi.ac.id</td>
                                                </tr>
                                                <tr>
                                                    <td class="pt-2 font-weight-bold text-warning">PASSWORD</td>
                                                    <td class="pt-2"><strong>password</strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-top-0 pt-0">
                                        <span class="badge badge-success"><i class="fas fa-lock mr-1"></i> Super Admin Only</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 shadow-sm border-left-warning">
                                    <div class="card-header bg-white font-weight-bold text-warning">
                                        <i class="fas fa-photo-video mr-2 text-warning"></i> MEDIA & PESAN
                                    </div>
                                    <div class="card-body text-sm py-3">
                                        <p class="mb-2"><strong>Media Library:</strong> Pusat semua file gambar dan dokumen website.</p>
                                        <p class="mb-0"><strong>Pesan Kontak:</strong> Inbox pesan dari pengunjung melalui form kontak.</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0 pt-0">
                                        <span class="badge badge-info"><i class="fas fa-user-tag mr-1"></i> Staf & Admin</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 shadow-sm border-left-danger">
                                    <div class="card-header bg-white font-weight-bold text-danger">
                                        <i class="fas fa-database mr-2"></i> BACKUP SISTEM
                                    </div>
                                    <div class="card-body text-sm py-3">
                                        <p class="mb-2"><strong>Database Backup:</strong> Amankan seluruh data konten website secara berkala.</p>
                                        <p class="mb-0 text-danger font-weight-bold">Penting: Lakukan backup seminggu sekali.</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0 pt-0">
                                        <span class="badge badge-danger"><i class="fas fa-lock mr-1"></i> Super Admin Only</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i> <strong>Catatan:</strong> Jika Anda tidak menemukan menu <strong>"Kelola User"</strong> atau <strong>"Backup"</strong> di sidebar, hal itu dikarenakan akun Anda tidak memiliki hak akses <strong>Super Admin</strong>.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Builders -->
            <div class="tab-pane" id="builder">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="mb-0 font-weight-bold">Advanced: Page & Menu Builder</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-5">
                            <h5 class="font-weight-bold"><i class="fas fa-bars mr-2 text-primary"></i> Menu Builder</h5>
                            <p>Fitur seret-dan-lepas (drag-and-drop) untuk menyusun navigasi website.</p>
                            <ul class="list-unstyled pl-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> <strong>Pilih Modul:</strong> Gunakan "Pilih dari Halaman Dinamis" untuk menambahkan link otomatis ke Berita, Agenda, Dokumen, dll.</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> <strong>Halaman Builder:</strong> Jika Anda membuat halaman spesial dengan Page Builder, pilih "Builder Page" di dropdown.</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> <strong>Hierarki:</strong> Geser item menu ke kanan untuk menjadikannya "Sub-menu" (Dropdown).</li>
                            </ul>
                        </div>

                        <hr>

                        <div class="mt-5">
                            <h5 class="font-weight-bold"><i class="fas fa-tools mr-2 text-warning"></i> Page Builder</h5>
                            <p>Gunakan ini untuk membuat halaman Landing Page yang dinamis tanpa coding.</p>
                            <div class="p-4 bg-light border rounded">
                                <p class="font-italic">"Blok demi Blok: Anda dapat menyusun halaman dengan memilih komponen seperti Slider, Hero Section, Daftar Artikel, Kontak, hingga Custom HTML secara berkelompok."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .icon-circle { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; }
    .bg-light-primary { background-color: rgba(0, 123, 255, 0.1); }
    .bg-light-success { background-color: rgba(40, 167, 69, 0.1); }
    .bg-light-warning { background-color: rgba(255, 193, 7, 0.1); }
    .nav-pills .nav-link.active { background-color: #007bff; }
    .guide-nav .nav-link { border-radius: 0; border-left: 3px solid transparent; padding: 12px 20px; font-weight: 500; color: #4b5563; }
    .guide-nav .nav-link.active { border-left-color: #0056b3; color: #0056b3 !important; background: #ebf5ff !important; }
    .timeline::before { left: 31px; background: #e9ecef; }
    .timeline > div > .timeline-item { margin-left: 60px; }
    .timeline > div > i { left: 18px; width: 30px; height: 30px; font-size: 15px; line-height: 30px; }
    .border-dashed { border: 2px dashed #dee2e6 !important; }
    @media print {
        .col-md-3, .btn, .main-header, .main-footer { display: none !important; }
        .col-md-9 { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
        .tab-pane { display: block !important; opacity: 1 !important; visibility: visible !important; margin-bottom: 50px; page-break-after: always; }
        .card { border: none !important; box-shadow: none !important; }
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Smooth scroll integration if needed
        $('.guide-nav a').on('shown.bs.tab', function (e) {
            window.scrollTo(0, 0);
        });
    });
</script>
@stop
