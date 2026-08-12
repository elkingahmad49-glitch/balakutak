@extends('adminlte::page')

@section('title', 'Kelola Kurikulum')

@section('content')
<div class="container-fluid pt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">{{ session('success') }}<button class="close" data-dismiss="alert">&times;</button></div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">{{ session('error') }}<button class="close" data-dismiss="alert">&times;</button></div>
    @endif

    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kode atau nama matkul..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="semester" class="form-control form-control-sm">
                        <option value="">Semua Semester</option>
                        @foreach($semesters as $sem)
                            <option value="{{ $sem }}" {{ request('semester')==$sem?'selected':'' }}>Semester {{ $sem }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-control form-control-sm">
                        <option value="">Semua Wajib/Pilihan</option>
                        <option value="wajib" {{ request('type')=='wajib'?'selected':'' }}>Mata Kuliah Wajib</option>
                        <option value="pilihan" {{ request('type')=='pilihan'?'selected':'' }}>Mata Kuliah Pilihan</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                    <a href="{{ route('admin.curriculums.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold"><i class="fas fa-book-open me-2"></i>Kurikulum & Mata Kuliah</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.curriculums.template') }}" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-file-excel me-1"></i> Format Import
                </a>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import me-1"></i> Import Excel
                </button>
                <a href="{{ route('admin.curriculums.export') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
                <a href="{{ route('admin.curriculums.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Mata Kuliah
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-sm mb-0 text-sm">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-3" width="100">Kode</th>
                        <th>Mata Kuliah</th>
                        <th class="text-center" width="80">Semester</th>
                        <th class="text-center" width="60">SKS</th>
                        <th>Sifat / Jenis</th>
                        <th>Konsentrasi</th>
                        <th class="text-center" width="70">RPS</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php $totalSks = 0; @endphp
                @forelse($curriculums as $curriculum)
                    @php $totalSks += $curriculum->credits; @endphp
                    <tr>
                        <td class="pl-3 align-middle font-weight-bold">{{ $curriculum->code }}</td>
                        <td class="align-middle">
                            {{ $curriculum->name }}
                            @if(!$curriculum->is_active)
                                <span class="badge badge-secondary ml-1">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">{{ $curriculum->semester }}</td>
                        <td class="text-center align-middle">{{ $curriculum->credits }}</td>
                        <td class="align-middle">
                            @if($curriculum->type === 'wajib')
                                <span class="badge badge-success text-uppercase">Wajib</span>
                            @else
                                <span class="badge badge-info text-uppercase">Pilihan</span>
                            @endif
                        </td>
                        <td class="align-middle"><small>{{ $curriculum->concentration ?? '-' }}</small></td>
                        <td class="text-center align-middle">
                            @if($curriculum->rps_file)
                                <a href="{{ asset('storage/' . $curriculum->rps_file) }}" class="text-primary" target="_blank" title="Unduh RPS"><i class="fas fa-file-pdf fa-lg"></i></a>
                            @else
                                <span class="text-muted"><i class="fas fa-minus"></i></span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.curriculums.edit', $curriculum) }}" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.curriculums.destroy', $curriculum) }}" method="POST" onsubmit="return confirm('Hapus mata kuliah ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada mata kuliah yang ditambahkan.</td></tr>
                @endforelse
                </tbody>
                @if(count($curriculums) > 0)
                <tfoot class="bg-light">
                    <tr>
                        <th colspan="3" class="text-right">Total SKS ditampilkan:</th>
                        <th class="text-center">{{ $totalSks }}</th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Menampilkan {{ $curriculums->firstItem() }}-{{ $curriculums->lastItem() }} dari {{ $curriculums->total() }} mata kuliah</small>
                {{ $curriculums->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Kurikulum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.curriculums.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>File Excel (.xlsx, .xls, .csv)</label>
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="importFile" accept=".xlsx, .xls, .csv" required>
                            <label class="custom-file-label" for="importFile">Pilih file...</label>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            Gunakan format yang telah disediakan untuk memastikan data terimpor dengan benar.
                            Maksimal ukuran file 5MB.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Mulai Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#importFile').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@stop
