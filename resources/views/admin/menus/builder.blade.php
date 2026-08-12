@extends('adminlte::page')

@section('title', 'Menu Builder: ' . $menu->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-sitemap me-2"></i>Menu Builder: <span class="text-primary">{{ $menu->name }}</span></h1>
        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Add New Item Panel -->
        <div class="col-md-4">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus-circle me-1"></i> Tambah Menu Item</h3>
                </div>
                <div class="card-body">
                    <form id="add-item-form">
                        <div class="form-group">
                            <label>Pilih dari Halaman Dinamis <small class="text-info">(Modul Sistem)</small></label>
                            <select id="add-dynamic" class="form-control select2">
                                <option value="">-- Pilih Modul --</option>
                                @if(isset($dynamicPages))
                                    @foreach($dynamicPages as $dp)
                                        <option value="{{ $dp['url'] }}" data-title="{{ $dp['title'] }}">{{ $dp['title'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-muted">Gunakan ini untuk menghubungkan menu ke halaman sistem (Kurikulum, SDM, dll).</small>
                        </div>
                        <div class="form-group">
                            <label>Pilih dari Halaman Statis</label>
                            <select id="add-page" class="form-control select2">
                                <option value="">-- Pilih Halaman --</option>
                                @if(isset($pages))
                                    @foreach($pages as $page)
                                        <option value="/{{ $page->slug }}" data-title="{{ $page->title }}">{{ $page->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-muted">Gunakan ini untuk halaman teks statis yang dibuat di menu "Pages".</small>
                        </div>
                        <div class="form-group">
                            <label>Label Menu <span class="text-danger">*</span></label>
                            <input type="text" id="add-label" class="form-control" placeholder="Contoh: Beranda" required>
                        </div>
                        <div class="form-group">
                            <label>URL / Link</label>
                            <input type="text" id="add-url" class="form-control" placeholder="Contoh: /about-us">
                            <small class="text-muted">Isi '#' jika ini adalah menu dropdown parent tanpa link utama.</small>
                        </div>
                        <div class="form-group">
                            <label>Icon Class (FontAwesome)</label>
                            <select id="add-icon" class="form-control select2">
                                <option value="">-- Tanpa Icon --</option>
                                <optgroup label="Umum">
                                    <option value="fas fa-home">Beranda / Home</option>
                                    <option value="fas fa-info-circle">Informasi / Info</option>
                                    <option value="fas fa-envelope">Kontak / Pesan</option>
                                    <option value="fas fa-phone">Telepon / Hubungi</option>
                                    <option value="fas fa-map-marker-alt">Lokasi / Peta</option>
                                    <option value="fas fa-search">Cari</option>
                                    <option value="fas fa-link">Tautan / Link</option>
                                    <option value="fas fa-globe">Web / Internet</option>
                                </optgroup>
                                <optgroup label="Akademik & Pendidikan">
                                    <option value="fas fa-graduation-cap">Pendidikan / Akademik</option>
                                    <option value="fas fa-book">Buku / Jurnal</option>
                                    <option value="fas fa-book-open">Membaca / Materi</option>
                                    <option value="fas fa-university">Kampus / Universitas</option>
                                    <option value="fas fa-chalkboard-teacher">Dosen / Pengajar</option>
                                    <option value="fas fa-user-graduate">Mahasiswa / Lulusan</option>
                                    <option value="fas fa-microscope">Penelitian / Riset</option>
                                </optgroup>
                                <optgroup label="Pengguna & Grup">
                                    <option value="fas fa-user">Pengguna / User</option>
                                    <option value="fas fa-users">Pengguna Banyak / Grup</option>
                                    <option value="fas fa-id-card">Kartu Identitas / Anggota</option>
                                </optgroup>
                                <optgroup label="Konten & Dokumen">
                                    <option value="fas fa-file">Dokumen / File</option>
                                    <option value="fas fa-file-alt">Teks / Artikel</option>
                                    <option value="fas fa-file-pdf">Dokumen PDF</option>
                                    <option value="fas fa-folder">Folder</option>
                                    <option value="fas fa-folder-open">Folder Terbuka</option>
                                    <option value="fas fa-image">Gambar / Foto</option>
                                    <option value="fas fa-images">Galeri</option>
                                    <option value="fas fa-video">Video</option>
                                    <option value="fas fa-newspaper">Berita / Pengumuman</option>
                                    <option value="fas fa-calendar-alt">Kalender / Acara</option>
                                    <option value="fas fa-bullhorn">Pengumuman / Kampanye</option>
                                </optgroup>
                                <optgroup label="Lain-lain">
                                    <option value="fas fa-cog">Pengaturan / Konfigurasi</option>
                                    <option value="fas fa-cogs">Pengaturan Lanjut</option>
                                    <option value="fas fa-chart-bar">Grafik / Statistik</option>
                                    <option value="fas fa-download">Unduh / Download</option>
                                    <option value="fas fa-upload">Unggah / Upload</option>
                                    <option value="fas fa-briefcase">Pekerjaan / Karir</option>
                                    <option value="fas fa-star">Bintang / Favorit</option>
                                    <option value="fas fa-heart">Hati / Suka</option>
                                    <option value="fas fa-check-circle">Selesai / Sukses</option>
                                    <option value="fas fa-exclamation-triangle">Peringatan / Warning</option>
                                </optgroup>
                            </select>
                            <small class="text-muted">Pilih ikon dari daftar jika diperlukan.</small>
                        </div>
                        <div class="form-group">
                            <label>Target Buka Link</label>
                            <select id="add-target" class="form-control">
                                <option value="_self">Tab Saat Ini (_self)</option>
                                <option value="_blank">Tab Baru (_blank)</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-success btn-block" id="btn-add-item">
                            <i class="fas fa-plus"></i> Tambahkan ke Struktur
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle me-1"></i> Petunjuk</h3>
                </div>
                <div class="card-body text-muted small">
                    <ul class="pl-3 mb-0">
                        <li>Gunakan form di atas untuk menambah item baru.</li>
                        <li>Tarik (drag) dan letakkan (drop) item di sebelah kanan untuk mengubah urutan.</li>
                        <li>Geser ke kanan sedikit di bawah item lain untuk menjadikannya Sub-Menu (Dropdown).</li>
                        <li>Jangan lupa klik tombol <b>Simpan Susunan Menu</b> berwarna biru setelah selesai!</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Nestable Builder Panel -->
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list me-1"></i> Struktur Menu</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-save-menu">
                            <i class="fas fa-save me-1"></i> Simpan Susunan Menu
                        </button>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <!-- Nestable List -->
                    <div class="dd" id="nestable-menu">
                        @if($menu->items->count() > 0)
                            <ol class="dd-list">
                                @include('admin.menus.partials.builder-item', ['items' => $menu->items])
                            </ol>
                        @else
                            <div class="dd-empty text-center py-5 text-muted h5" id="empty-state">
                                Belum ada item di menu ini.<br>Tambahkan melalui panel di sebelah kiri.
                            </div>
                            <ol class="dd-list d-none"></ol> <!-- Hidden list to hold dropped items initially -->
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template for new items via JS -->
<template id="item-template">
    <li class="dd-item dd3-item" data-label="" data-url="" data-icon="" data-target="">
        <div class="dd-handle dd3-handle"><i class="fas fa-arrows-alt"></i></div>
        <div class="dd3-content">
            <span class="item-icon-preview mr-2"></span>
            <span class="item-label-preview font-weight-bold"></span>
            <span class="item-url-preview text-muted small ml-2 float-right mt-1"></span>
            
            <div class="float-right mr-3 item-actions mt-1">
                <a href="javascript:void(0)" class="text-primary btn-edit-item mr-2" title="Edit Item">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript:void(0)" class="text-danger btn-delete-item" title="Hapus Item">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>
    </li>
</template>
<!-- Modal Edit Item -->
<div class="modal fade" id="modal-edit-item" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Edit Menu Item</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="edit-item-form">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase">Pilih dari Halaman Dinamis</label>
                        <select id="edit-dynamic" class="form-control select2-modal">
                            <option value="">-- Pilih Modul --</option>
                            @if(isset($dynamicPages))
                                @foreach($dynamicPages as $dp)
                                    <option value="{{ $dp['url'] }}" data-title="{{ $dp['title'] }}">{{ $dp['title'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small text-uppercase">Pilih dari Halaman Statis</label>
                        <select id="edit-page" class="form-control select2-modal">
                            <option value="">-- Pilih Halaman --</option>
                            @if(isset($pages))
                                @foreach($pages as $page)
                                    <option value="/{{ $page->slug }}" data-title="{{ $page->title }}">{{ $page->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Label Menu <span class="text-danger">*</span></label>
                        <input type="text" id="edit-label" class="form-control border-primary-soft" required placeholder="Contoh: Tentang Kami">
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">URL / Link</label>
                        <input type="text" id="edit-url" class="form-control" placeholder="Contoh: /profile">
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Icon Class (FontAwesome)</label>
                        <select id="edit-icon" class="form-control select2-modal">
                            <option value="">-- Tanpa Icon --</option>
                            <optgroup label="Umum">
                                <option value="fas fa-home">Beranda / Home</option>
                                <option value="fas fa-info-circle">Informasi / Info</option>
                                <option value="fas fa-envelope">Kontak / Pesan</option>
                                <option value="fas fa-phone">Telepon / Hubungi</option>
                                <option value="fas fa-map-marker-alt">Lokasi / Peta</option>
                                <option value="fas fa-search">Cari</option>
                                <option value="fas fa-link">Tautan / Link</option>
                                <option value="fas fa-globe">Web / Internet</option>
                            </optgroup>
                            <optgroup label="Akademik & Pendidikan">
                                <option value="fas fa-graduation-cap">Pendidikan / Akademik</option>
                                <option value="fas fa-book">Buku / Jurnal</option>
                                <option value="fas fa-book-open">Membaca / Materi</option>
                                <option value="fas fa-university">Kampus / Universitas</option>
                                <option value="fas fa-chalkboard-teacher">Dosen / Pengajar</option>
                                <option value="fas fa-user-graduate">Mahasiswa / Lulusan</option>
                                <option value="fas fa-microscope">Penelitian / Riset</option>
                            </optgroup>
                            <optgroup label="Pengguna & Grup">
                                <option value="fas fa-user">Pengguna / User</option>
                                <option value="fas fa-users">Pengguna Banyak / Grup</option>
                                <option value="fas fa-id-card">Kartu Identitas / Anggota</option>
                            </optgroup>
                            <optgroup label="Konten & Dokumen">
                                <option value="fas fa-file">Dokumen / File</option>
                                <option value="fas fa-file-alt">Teks / Artikel</option>
                                <option value="fas fa-file-pdf">Dokumen PDF</option>
                                <option value="fas fa-folder">Folder</option>
                                <option value="fas fa-folder-open">Folder Terbuka</option>
                                <option value="fas fa-image">Gambar / Foto</option>
                                <option value="fas fa-images">Galeri</option>
                                <option value="fas fa-video">Video</option>
                                <option value="fas fa-newspaper">Berita / Pengumuman</option>
                                <option value="fas fa-calendar-alt">Kalender / Acara</option>
                                <option value="fas fa-bullhorn">Pengumuman / Kampanye</option>
                            </optgroup>
                            <optgroup label="Lain-lain">
                                <option value="fas fa-cog">Pengaturan / Konfigurasi</option>
                                <option value="fas fa-cogs">Pengaturan Lanjut</option>
                                <option value="fas fa-chart-bar">Grafik / Statistik</option>
                                <option value="fas fa-download">Unduh / Download</option>
                                <option value="fas fa-upload">Unggah / Upload</option>
                                <option value="fas fa-briefcase">Pekerjaan / Karir</option>
                                <option value="fas fa-star">Bintang / Favorit</option>
                                <option value="fas fa-heart">Hati / Suka</option>
                                <option value="fas fa-check-circle">Selesai / Sukses</option>
                                <option value="fas fa-exclamation-triangle">Peringatan / Warning</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Target Buka Link</label>
                        <select id="edit-target" class="form-control">
                            <option value="_self">Tab Saat Ini (_self)</option>
                            <option value="_blank">Tab Baru (_blank)</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 px-4 py-3">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary px-4 font-weight-bold shadow-sm" id="btn-update-item">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
 @stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
<style>
    .dd { max-width: 100%; }
    .dd3-content { 
        display: block; height: 40px; margin: 5px 0; padding: 10px 10px 10px 50px; 
        color: #333; text-decoration: none; font-weight: normal; 
        border: 1px solid #ccc; background: #fafafa; 
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%); 
        border-radius: 3px; box-sizing: border-box; font-size: 14px;
    }
    .dd3-content:hover { color: #2ea8e5; background: #fff; }
    .dd-dragel > .dd3-item > .dd3-content { margin: 0; }
    .dd3-item > button { margin-left: 40px; height: 26px; width: 26px; margin-top: 7px;}
    .dd3-handle { 
        position: absolute; margin: 0; left: 0; top: 0; cursor: move; width: 40px; 
        text-indent: 100%; white-space: nowrap; overflow: hidden; border: 1px solid #aaa; 
        background: #ddd; background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%); 
        border-top-right-radius: 0; border-bottom-right-radius: 0; border-radius: 3px;
        height: 100%; display: flex; align-items: center; justify-content: center;
        text-indent: 0; border-right-color: #ccc;
    }
    .dd3-handle:before { display: none; }
    .dd3-handle:hover { background: #ddd; }
    .dd-empty { border: 2px dashed #ccc; background-color: transparent; }
    .border-primary-soft { border-color: rgba(0, 123, 255, 0.25) !important; }
    .select2-container--default .select2-selection--single { height: 38px !important; line-height: 38px !important; border-color: #dee2e6 !important; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 35px !important; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 35px !important; }
</style>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
<script>
    $(document).ready(function() {
        
        // Initialize Nestable
        $('#nestable-menu').nestable({
            maxDepth: 3
        });

        // Initialize Select2 in Modal
        $('.select2-modal').select2({
            dropdownParent: $('#modal-edit-item'),
            width: '100%'
        });

        // Auto-fill form from Static Page dropdown
        $('#add-page').change(function() {
            let selectedOption = $(this).find('option:selected');
            let url = selectedOption.val();
            let title = selectedOption.data('title');
            
            if (url) {
                $('#add-url').val(url);
                $('#add-label').val(title);
                $('#add-dynamic').val('').trigger('change.select2'); // Reset the other one
            }
        });

        // Auto-fill form from Dynamic Page dropdown
        $('#add-dynamic').change(function() {
            let selectedOption = $(this).find('option:selected');
            let url = selectedOption.val();
            let title = selectedOption.data('title');
            
            if (url) {
                $('#add-url').val(url);
                $('#add-label').val(title);
                $('#add-page').val('').trigger('change.select2'); // Reset the other one
            }
        });

        // EDIT MODAL: Auto-fill form from Static Page dropdown
        $('#edit-page').change(function() {
            let selectedOption = $(this).find('option:selected');
            let url = selectedOption.val();
            let title = selectedOption.data('title');
            
            if (url) {
                $('#edit-url').val(url);
                $('#edit-label').val(title);
                $('#edit-dynamic').val('').trigger('change.select2');
            }
        });

        // EDIT MODAL: Auto-fill form from Dynamic Page dropdown
        $('#edit-dynamic').change(function() {
            let selectedOption = $(this).find('option:selected');
            let url = selectedOption.val();
            let title = selectedOption.data('title');
            
            if (url) {
                $('#edit-url').val(url);
                $('#edit-label').val(title);
                $('#edit-page').val('').trigger('change.select2');
            }
        });

        // Add new item to list
        $('#btn-add-item').click(function() {
            let label = $('#add-label').val();
            let url = $('#add-url').val();
            let icon = $('#add-icon').val();
            let target = $('#add-target').val();

            if (!label) {
                alert('Label Menu wajib diisi!');
                return;
            }

            // Hide empty state if visible
            $('#empty-state').remove();
            
            // Show list if it was hidden
            if($('.dd-list').hasClass('d-none')) {
                $('.dd-list').removeClass('d-none');
            }

            // Create new node from template
            let template = $('#item-template').html();
            let $node = $(template);
            
            // Set data attributes for Nestable parsing
            $node.attr('data-label', label);
            $node.attr('data-url', url);
            $node.attr('data-icon', icon);
            $node.attr('data-target', target);

            // Set visual content
            $node.find('.item-label-preview').text(label);
            $node.find('.item-url-preview').text(url);
            if (icon) {
                $node.find('.item-icon-preview').html('<i class="' + icon + '"></i>');
            }

            // Append to root list
            if ($('#nestable-menu > .dd-list').length === 0) {
                $('#nestable-menu').append('<ol class="dd-list"></ol>');
            }
            $('#nestable-menu > .dd-list').append($node);

            // Reset form
            $('#add-item-form')[0].reset();
            $('#add-page, #add-dynamic, #add-icon').val('').trigger('change.select2');
        });

        // Remove item
        $(document).on('click', '.btn-delete-item', function(e) {
            e.preventDefault();
            if (confirm('Hapus item menu ini? Semua sub-item (jika ada) juga akan terhapus.')) {
                $(this).closest('.dd-item').remove();
            }
        });

        // Edit Item Modal - Open
        let currentEditingItemNode = null;
        $(document).on('click', '.btn-edit-item', function(e) {
            e.preventDefault();
            currentEditingItemNode = $(this).closest('.dd-item');
            
            // Populate modal
            let label = currentEditingItemNode.attr('data-label') || '';
            let url = currentEditingItemNode.attr('data-url') || '';
            let icon = currentEditingItemNode.attr('data-icon') || '';
            let target = currentEditingItemNode.attr('data-target') || '_self';
            
            $('#edit-label').val(label);
            $('#edit-url').val(url);
            $('#edit-icon').val(icon).trigger('change.select2');
            $('#edit-target').val(target);
            
            // Try to match URL in dropdowns
            $('#edit-page').val(url).trigger('change.select2');
            if (!$('#edit-page').val()) {
                $('#edit-dynamic').val(url).trigger('change.select2');
            } else {
                $('#edit-dynamic').val('').trigger('change.select2');
            }
            
            $('#modal-edit-item').modal('show');
        });

        // Real-time icon preview in modal (was for text input, now handled by Select2 icon mapping if needed, 
        // but we'll keep it simple by just letting the user see the selected icon name in select)
        $('#edit-icon').on('keyup change', function() {
            let iconClass = $(this).val();
            if (iconClass) {
                $('#edit-icon-preview').html('<i class="' + iconClass + '"></i>');
            } else {
                $('#edit-icon-preview').html('<i class="fas fa-question text-muted"></i>');
            }
        });

        // Update item button
        $('#btn-update-item').click(function() {
            if (!currentEditingItemNode) return;

            let label = $('#edit-label').val();
            let url = $('#edit-url').val();
            let icon = $('#edit-icon').val();
            let target = $('#edit-target').val();

            if (!label) {
                alert('Label Menu wajib diisi!');
                return;
            }

            // Update attributes
            currentEditingItemNode.attr('data-label', label);
            currentEditingItemNode.attr('data-url', url);
            currentEditingItemNode.attr('data-icon', icon);
            currentEditingItemNode.attr('data-target', target);

            // Update previews
            currentEditingItemNode.find('.item-label-preview').first().text(label);
            
            // Update URL preview (handle Route case)
            let routeName = currentEditingItemNode.attr('data-route_name');
            if (routeName) {
                currentEditingItemNode.find('.item-url-preview').first().text('Route: ' + routeName);
            } else {
                currentEditingItemNode.find('.item-url-preview').first().text(url);
            }

            // Update Icon preview
            if (icon) {
                currentEditingItemNode.find('.item-icon-preview').first().html('<i class="' + icon + '"></i>');
            } else {
                currentEditingItemNode.find('.item-icon-preview').first().html('');
            }

            $('#modal-edit-item').modal('hide');
        });

        // Save structure
        // .off() first: guarantees only ONE handler is ever attached to this
        // button, even if this script block somehow gets executed more than
        // once on the page (double render, cached partial reload, etc).
        // isSaving flag: extra guard so an in-flight request can never be
        // fired twice, regardless of how many click events land on the button.
        let isSaving = false;

        $('#btn-save-menu').off('click.saveMenu').on('click.saveMenu', function() {
            if (isSaving) {
                return; // a save is already in progress, ignore this trigger
            }
            isSaving = true;

            let menuData = $('#nestable-menu').nestable('serialize');

            let btn = $(this);
            let originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            btn.prop('disabled', true);

            $.ajax({
                url: '{{ route("admin.menus.save-items", $menu) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    items: menuData
                },
                success: function(response) {
                    // Show standard AdminLTE toast if available, otherwise alert
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Berhasil',
                        subtitle: 'Tersimpan',
                        body: response.message
                    });
                },
                error: function(xhr) {
                    alert('Gagal menyimpan menu. Silakan coba lagi.');
                    console.error(xhr);
                },
                complete: function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                    isSaving = false;
                }
            });
        });
    });
</script>
@stop