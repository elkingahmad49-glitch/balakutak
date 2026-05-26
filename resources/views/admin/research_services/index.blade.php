@extends('adminlte::page')

@section('title', __('admin.research_services'))

@section('content_header')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-dark font-weight-bold">{{ __('admin.research_services') }}</h1>
        <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0 text-capitalize">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ __('admin.research_services') }}</li>
        </ol>
    </div>
@stop

@section('content')
<div class="container-fluid pt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-0">
            <div class="row align-items-center">
                <div class="col-12 mb-3">
                    <form method="GET" class="row align-items-center mt-3 mt-md-0">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" name="search" class="form-control bg-light border-left-0" placeholder="{{ __('admin.search_research_services') }}" value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-2 mb-md-0">
                            <select name="type" class="form-control form-control-sm bg-light" onchange="this.form.submit()">
                                <option value="">Semua Tipe</option>
                                <option value="research" {{ request('type') == 'research' ? 'selected' : '' }}>{{ __('admin.type_research') }}</option>
                                <option value="community_service" {{ request('type') == 'community_service' ? 'selected' : '' }}>{{ __('admin.type_community_service') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2 mb-md-0">
                             <button type="submit" class="btn btn-primary btn-sm btn-block shadow-sm">Filter</button>
                        </div>
                        <div class="col-md-2">
                             <a href="{{ route('admin.research-services.index') }}" class="btn btn-secondary btn-sm btn-block shadow-sm">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="col-12 mt-2">
                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                        <a href="{{ route('admin.research-services.template') }}" class="btn btn-outline-success shadow-sm rounded-pill btn-sm px-3 mr-2 mb-2">
                            <i class="fas fa-file-excel mr-1"></i> Format Import
                        </a>
                        <button type="button" class="btn btn-success shadow-sm rounded-pill btn-sm px-3 mr-2 mb-2" data-toggle="modal" data-target="#importModal">
                            <i class="fas fa-file-import mr-1"></i> Import Excel
                        </button>
                        <a href="{{ route('admin.research-services.export') }}" class="btn btn-outline-primary shadow-sm rounded-pill btn-sm px-3 mr-2 mb-2">
                            <i class="fas fa-file-excel mr-1"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.research-services.create') }}" class="btn btn-primary shadow-sm rounded-pill btn-sm px-4 mb-2">
                            <i class="fas fa-plus mr-2"></i> {{ __('admin.add_research_service') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3" style="width: 35%;">{{ __('admin.research_title') }}</th>
                            <th class="py-3">{{ __('admin.research_author') }}</th>
                            <th class="py-3">{{ __('admin.research_type') }}</th>
                            <th class="py-3 text-center">{{ __('admin.research_year') }}</th>
                            <th class="py-3 text-center" style="width: 100px;">{{ __('admin.status') }}</th>
                            <th class="px-4 py-3 text-right" style="width: 150px;">{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-weight-bold text-dark">{{ $item->title }}</div>
                            </td>
                            <td class="py-3">
                                <span class="text-muted small">{{ $item->author ?? '-' }}</span>
                            </td>
                            <td class="py-3">
                                @if($item->type === 'research')
                                    <span class="badge badge-info rounded-pill px-3 py-1">{{ __('admin.type_research') }}</span>
                                @else
                                    <span class="badge badge-success rounded-pill px-3 py-1">{{ __('admin.type_community_service') }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge badge-light border">{{ $item->year ?? '-' }}</span>
                            </td>
                            <td class="py-3 text-center">
                                @if($item->is_active)
                                    <span class="badge badge-soft-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>{{ __('admin.active') }}</span>
                                @else
                                    <span class="badge badge-soft-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i>{{ __('admin.inactive') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="btn-group btn-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <a href="{{ route('admin.research-services.edit', $item) }}" class="btn btn-white" title="{{ __('admin.edit') }}"><i class="fas fa-edit text-primary"></i></a>
                                    <form action="{{ route('admin.research-services.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-white" title="{{ __('admin.delete') }}"><i class="fas fa-trash text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-book-reader fa-3x text-light mb-3"></i>
                                <p class="text-muted">{{ __('admin.no_research_services') }}</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $data->links() }}
        </div>
    </div>
</div>

<style>
    .badge-soft-success { background-color: rgba(40, 167, 69, 0.1); color: #28a745; }
    .badge-soft-danger { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .btn-white { background: #fff; border: 1px solid #f1f1f1; }
    .btn-white:hover { background: #f9f9f9; }
</style>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold" id="importModalLabel"><i class="fas fa-file-import mr-2"></i>Import Data Penelitian & Pengabdian</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.research-services.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">File Excel (.xlsx, .xls, .csv)</label>
                        <div class="custom-file mb-3">
                            <input type="file" name="file" class="custom-file-input" id="importFile" accept=".xlsx, .xls, .csv" required>
                            <label class="custom-file-label" for="importFile">Pilih file...</label>
                        </div>
                        <div class="alert alert-info border-0 shadow-sm p-3 mb-0" style="border-radius: 8px;">
                            <i class="fas fa-info-circle mr-2"></i> <strong>Petunjuk:</strong>
                            <ul class="pl-3 mb-0 mt-2 small">
                                <li>Gunakan format template yang telah disediakan.</li>
                                <li>Kolom tipe harus diisi dengan "penelitian" atau "pengabdian".</li>
                                <li>Data dengan judul dan tipe yang sama akan diperbarui secara otomatis.</li>
                                <li>Maksimal ukuran file adalah 5MB.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 btn-sm shadow-sm">Mulai Import</button>
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
