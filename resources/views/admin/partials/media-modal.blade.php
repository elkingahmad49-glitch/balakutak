<!-- WordPress-Style Media Picker Modal -->
<div class="modal fade" id="mediaPickerModal" tabindex="-1" role="dialog" aria-labelledby="mediaPickerModalLabel" aria-hidden="true" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg border-0" style="height: 90vh;">
            <div class="modal-header bg-white border-bottom py-2 px-3 d-flex align-items-center">
                <h6 class="modal-title font-weight-bold text-dark text-uppercase" id="mediaPickerModalLabel" style="font-size: 0.8rem; letter-spacing: 1px;">
                    Pilih Media
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body p-0 d-flex flex-column" style="overflow: hidden;">
                <!-- Internal Tabs -->
                <ul class="nav nav-tabs px-3 border-bottom bg-light" id="mediaTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold text-uppercase border-0 py-3" id="library-tab" data-toggle="tab" href="#pustaka-media" role="tab" style="font-size: 0.75rem; letter-spacing: 0.5px;">Pustaka Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-uppercase border-0 py-3" id="upload-tab" data-toggle="tab" href="#unggah-berkas" role="tab" style="font-size: 0.75rem; letter-spacing: 0.5px;">Unggah Berkas</a>
                    </li>
                </ul>

                <div class="tab-content flex-grow-1" id="mediaTabsContent" style="overflow: hidden;">
                    <!-- Media Library Tab -->
                    <div class="tab-pane fade show active h-100" id="pustaka-media" role="tabpanel">
                        <div class="row no-gutters h-100">
                            <!-- Left: Grid -->
                            <div class="col-md-9 border-right d-flex flex-column h-100">
                                <!-- Filter Bar -->
                                <div class="bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
                                    <div class="input-group input-group-sm" style="max-width: 300px;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-left-0" id="picker-search" placeholder="Cari media...">
                                    </div>
                                    <div class="text-muted small" id="media-count-info">Memuat...</div>
                                </div>
                                
                                <!-- Grid Area -->
                                <div id="media-picker-content" class="p-4 flex-grow-1" style="overflow-y: auto; background-color: #f0f0f1;">
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem; border-width: 0.3em;"></div>
                                        <p class="mt-3 text-muted font-italic">Memuat Pustaka Media Anda...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Attachment Details Sidebar -->
                            <div class="col-md-3 bg-white h-100 d-flex flex-column shadow-sm" style="overflow-y: auto;">
                                <div id="attachment-details" class="p-3">
                                    <div class="empty-selection text-center py-5">
                                        <i class="fas fa-image fa-4x text-light mb-3" style="opacity: 0.4;"></i>
                                        <h6 class="text-muted font-weight-bold">Detail Lampiran</h6>
                                        <p class="small text-muted px-2">Pilih media dari daftar di samping untuk melihat atau mengedit detailnya.</p>
                                    </div>
                                    
                                    <div class="selection-info d-none">
                                        <h6 class="text-uppercase font-weight-bold mb-3" style="font-size: 0.7rem; color: #50575e; border-bottom: 1px solid #eee; padding-bottom: 8px;">Detail Lampiran</h6>
                                        <div class="d-flex mb-3 align-items-start border-bottom pb-3">
                                            <div class="preview-mini rounded mr-2 bg-light border shadow-sm" style="width: 80px; height: 80px; overflow: hidden; background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSIjZjBmMGYxIi8+PHJlY3Qgd2lkdGg9IjEwIiBoZWlnaHQ9IjEwIiBmaWxsPSIjZWNlY2VjIi8+PHJlY3QgeD0iMTAiIHk9IjEwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9IiNlY2VjZWMiLz48L3N2Zz4=');">
                                                <img src="" id="side-preview-img" class="img-fluid h-100 w-100" style="object-fit: contain;">
                                            </div>
                                            <div class="info-text overflow-hidden" style="font-size: 0.7rem; line-height: 1.5;">
                                                <div class="font-weight-bold text-dark text-truncate" id="side-filename" style="font-size: 0.75rem;"></div>
                                                <div class="text-muted" id="side-date"></div>
                                                <div class="text-muted" id="side-size"></div>
                                                <div class="text-muted font-italic" id="side-dimensions"></div>
                                                <a href="javascript:void(0)" class="text-danger font-weight-bold mt-2 delete-media-btn d-inline-block">Hapus permanen</a>
                                            </div>
                                        </div>
                                        
                                        <div class="detail-inputs mt-3">
                                            <div class="form-group mb-3">
                                                <label class="small text-muted font-weight-bold mb-1 text-uppercase" style="font-size: 0.65rem;">Alamat URL</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm bg-light" id="side-url" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="copyPickerUrl()"><i class="fas fa-copy"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="small text-muted font-weight-bold mb-1 text-uppercase" style="font-size: 0.65rem;">Teks Alternatif (Alt)</label>
                                                <textarea class="form-control form-control-sm" rows="2" id="side-alt" placeholder="Deskripsikan gambar ini"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-auto p-3 border-top bg-light selection-info d-none">
                                    <button type="button" class="btn btn-primary btn-block font-weight-bold text-uppercase shadow-sm" id="btn-confirm-picker" style="border-radius: 3px; font-size: 0.8rem; padding: 10px 0;">Pilih Media Ini</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Tab -->
                    <div class="tab-pane fade h-100" id="unggah-berkas" role="tabpanel">
                        <div class="h-100 d-flex flex-column align-items-center justify-content-center p-5" style="background-color: #f0f0f1; border: 3px dashed #c3c4c7; margin: 30px; border-radius: 8px;">
                            <div id="drop-area-icon" class="mb-4">
                                <i class="fas fa-cloud-upload-alt fa-5x text-muted" style="opacity: 0.5;"></i>
                            </div>
                            <h4 class="text-dark font-weight-bold mb-2">Tarik berkas untuk diunggah</h4>
                            <p class="text-muted mb-4">atau</p>
                            <label class="btn btn-primary px-5 py-2 font-weight-bold shadow-sm" style="border-radius: 4px; font-size: 0.9rem;">
                                Pilih Berkas dari Komputer
                                <input type="file" id="picker-direct-upload" class="d-none" multiple>
                            </label>
                            <p class="small text-muted mt-4">Ukuran berkas unggahan maksimal: 10 MB.</p>
                            <div id="upload-progress-container" class="w-50 d-none mt-3">
                                <div class="progress" style="height: 10px; border-radius: 5px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                </div>
                                <p class="small text-center mt-2 text-primary font-weight-bold">Mengunggah berkas...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
// WordPress Style State
let selectedItem = null;
let currentInput = null;
let currentPreview = null;
window.tinyMceCallback = null;

// Global Load Media function
window.loadMedia = function(page = 1, search = '') {
    const $container = $('#media-picker-content');
    $container.html('<div class="text-center py-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div><p class="mt-3 text-muted font-italic">Menghubungkan ke Pustaka Media...</p></div>');
    $('.selection-info').addClass('d-none');
    $('.empty-selection').removeClass('d-none');
    $('#btn-confirm-picker').prop('disabled', true);
    
    $.ajax({
        url: "{{ route('admin.media.picker') }}",
        data: { page: page, search: search },
        cache: false,
        success: function(html) {
            $container.html(html);
            $('#media-count-info').text(($('.media-picker-item').length > 0) ? $('.media-picker-item').length + ' item ditemukan' : '0 item');
        },
        error: function(xhr) {
            $container.html('<div class="alert alert-danger mx-3 my-4 shadow-sm"><i class="fas fa-exclamation-circle mr-2"></i> Gagal memuat Pustaka Media. Pastikan Anda masih terhubung ke server.</div>');
        }
    });
}

// Copy URL Helper
function copyPickerUrl() {
    var copyText = document.getElementById("side-url");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("URL berhasil disalin!");
}

$(document).ready(function() {
    // Remove media handler
    $(document).on('click', '.btn-remove-media', function(e) {
        e.preventDefault();
        const $wrapper = $(this).closest('.media-input-wrapper');
        $wrapper.find('.media-target').val('');
        $wrapper.find('.preview-container').html('<div class="text-muted small italic">Belum ada gambar dipilih.</div>');
    });

    // Open from buttons
    $(document).on('click', '.btn-browse-media', function() {
        currentInput = $($(this).data('input'));
        currentPreview = $($(this).data('preview'));
        window.tinyMceCallback = null;
        $('#mediaPickerModal').modal('show');
        $('#library-tab').tab('show');
        window.loadMedia();
    });

    // Selecting an item (Grid Interaction)
    $(document).on('click', '.media-picker-item', function() {
        $('.media-picker-item .card').removeClass('border-primary').css('box-shadow', 'none');
        $('.media-picker-item .check-overlay').remove();
        
        const $card = $(this).find('.card');
        $card.addClass('border-primary').css('box-shadow', '0 0 0 3px #007bff inset');
        $card.append('<div class="check-overlay position-absolute bg-primary text-white shadow" style="top: -10px; right: -10px; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; z-index: 10; border: 2px solid white;"><i class="fas fa-check" style="font-size: 11px;"></i></div>');
        
        selectedItem = {
            url: $(this).data('url'),
            id: $(this).data('id'),
            path: $(this).data('path')
        };

        // Fetch details via JSON
        let detailUrl = "{{ route('admin.media.json', ['id' => ':id']) }}".replace(':id', selectedItem.id);
        $.getJSON(detailUrl, function(data) {
            $('.empty-selection').addClass('d-none');
            $('.selection-info').removeClass('d-none');
            
            $('#side-preview-img').attr('src', data.url);
            $('#side-filename').text(data.filename).attr('title', data.filename);
            $('#side-date').text(data.created_at);
            $('#side-size').text(data.size);
            $('#side-dimensions').text(data.dimensions);
            $('#side-url').val(data.url);
            $('#side-alt').val(data.filename.split('.')[0]); // Default alt
            $('.delete-media-btn').attr('onclick', `deleteMediaFromPicker(${data.id})`);
            
            selectedItem.filename = data.filename;
            $('#btn-confirm-picker').prop('disabled', false);
        });
    });

    // Confirm selection logic
    $('#btn-confirm-picker').click(function() {
        if (!selectedItem) return;

        if (currentInput && currentInput.length) {
            currentInput.val(selectedItem.path);
            if (currentPreview && currentPreview.length) {
                currentPreview.html(`
                    <div class="position-relative d-inline-block shadow-sm">
                        <img src="${selectedItem.url}" class="img-thumbnail" style="max-height: 150px;">
                        <button type="button" class="btn btn-danger btn-xs position-absolute btn-remove-media shadow" style="top:-10px; right:-10px; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times" style="font-size: 10px;"></i>
                        </button>
                    </div>
                `);
            }
            $('#mediaPickerModal').modal('hide');
        } else if (typeof window.tinyMceCallback === 'function') {
            window.tinyMceCallback(selectedItem);
            $('#mediaPickerModal').modal('hide');
        }
    });

    // Handle Search with Debounce
    let searchTimeout;
    $('#picker-search').on('input', function() {
        clearTimeout(searchTimeout);
        let val = $(this).val();
        searchTimeout = setTimeout(() => {
            window.loadMedia(1, val);
        }, 400);
    });

    // Advanced Direct Upload Logic
    $('#picker-direct-upload').on('change', function() {
        if (!this.files.length) return;
        
        let formData = new FormData();
        Array.from(this.files).forEach(file => formData.append('files[]', file));
        formData.append('_token', '{{ csrf_token() }}');

        $('#upload-progress-container').removeClass('d-none');
        $('#unggah-berkas .btn').addClass('disabled').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.media.upload') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        $('.progress-bar').css('width', (percentComplete * 100) + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(resp) {
                $('#upload-progress-container').addClass('d-none');
                $('#unggah-berkas .btn').removeClass('disabled').prop('disabled', false);
                $('.progress-bar').css('width', '0%');
                
                $('#library-tab').tab('show');
                window.loadMedia();
                // Optionally highlight the newest item if resp.files[0].id is used
            },
            error: function(xhr) {
                alert('Peringatan: Gagal mengunggah beberapa berkas. Pastikan format dan ukuran file sesuai (Maks 10MB).');
                $('#upload-progress-container').addClass('d-none');
                $('#unggah-berkas .btn').removeClass('disabled').prop('disabled', false);
            }
        });
    });

    // Handle Modal Pagination
    $(document).on('click', '#picker-pagination .page-link', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        window.loadMedia(page, $('#picker-search').val());
    });
});

// Helper for deletion from within picker
function deleteMediaFromPicker(id) {
    if(!id) return;
    
    if(confirm('PERINGATAN: Gambar ini akan dihapus secara permanen dari server dan tidak dapat ditampilkan lagi di situs. Lanjutkan?')) {
        let deleteUrl = "{{ route('admin.media.destroy', ['media' => ':id']) }}".replace(':id', id);
        
        // Disable the button to prevent multiple clicks
        const $btn = $('.delete-media-btn');
        const originalText = $btn.text();
        $btn.text('Menghapus...').addClass('disabled').css('pointer-events', 'none');
        
        $.ajax({
            url: deleteUrl,
            type: 'POST', // Use POST with _method DELETE for better compatibility
            data: { 
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(resp.message || 'Media berhasil dihapus.');
                    } else {
                        alert(resp.message || 'Media berhasil dihapus.');
                    }
                    window.loadMedia();
                } else {
                    alert('Gagal: ' + (resp.message || 'Terjadi kesalahan.'));
                    $btn.text(originalText).removeClass('disabled').css('pointer-events', 'auto');
                }
            },
            error: function(xhr) {
                let msg = 'Terjadi kesalahan saat menghapus media.';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                alert(msg);
                $btn.text(originalText).removeClass('disabled').css('pointer-events', 'auto');
            }
        });
    }
}
</script>

<style>
    #mediaPickerModal { z-index: 999999 !important; }
    #mediaPickerModal .nav-tabs .nav-link { color: #50575e; border-bottom: 2px solid transparent; transition: all 0.25s; padding-bottom: 15px !important; }
    #mediaPickerModal .nav-tabs .nav-link.active { background: transparent; border-bottom-color: #2271b1; color: #2271b1 !important; }
    #mediaPickerModal .nav-tabs .nav-link:hover { color: #2271b1; }
    .media-picker-item .card { transition: all 0.15s ease-in-out; background: #fff; overflow: visible !important; border-radius: 2px; border: 1px solid #dcdcde; }
    .media-picker-item .card:hover { transform: scale(1.02); z-index: 5; border-color: #2271b1; }
    #attachment-details { background-color: #fff; border-left: 1px solid #dcdcde; height: 100%; border-top: 1px solid #eee; }
    .preview-mini img { background-color: #f0f0f1; }
</style>
@endpush
