@extends('adminlte::page')

@section('title', __('admin.lecturers'))

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
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('admin.search_lecturers') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control form-control-sm">
                        <option value="">{{ __('admin.status') }}</option>
                        <option value="active" {{ request('status')=='active'?'selected':'' }}>{{ __('admin.active') }}</option>
                        <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>{{ __('admin.inactive') }}</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                    <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold"><i class="fas fa-user-tie me-2"></i>{{ __('admin.lecturers') }}</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.lecturers.template') }}" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-file-excel me-1"></i> Format Import
                </a>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import me-1"></i> Import Excel
                </button>
                <a href="{{ route('admin.lecturers.export') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
                <a href="{{ route('admin.lecturers.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> {{ __('admin.add_lecturer') }}
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-sm mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-3" width="70">{{ __('admin.lecturer_photo') }}</th>
                        <th width="30%">{{ __('admin.lecturer_name') }}</th>
                        <th>{{ __('admin.lecturer_nidn') }}</th>
                        <th>{{ __('admin.lecturer_position') }}</th>
                        <th>{{ __('admin.lecturer_email') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th width="100">{{ __('admin.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($lecturers as $lecturer)
                    <tr>
                        <td class="pl-3 align-middle">
                            <img src="{{ $lecturer->photo_url }}" class="img-thumbnail" style="width: 50px; height: 60px; object-fit: cover;">
                        </td>
                        <td class="align-middle">
                            <strong>{{ $lecturer->name }}</strong>
                            <br>
                            <small class="text-muted">
                                @if($lecturer->nip) NIP: {{ $lecturer->nip }} @endif
                                @if($lecturer->nidn) | NIDN: {{ $lecturer->nidn }} @endif
                            </small>
                        </td>
                        <td class="align-middle">
                            @if($lecturer->type === 'dosen')
                                <span class="badge badge-info text-uppercase">Dosen</span>
                            @else
                                <span class="badge badge-warning text-uppercase">Tendik</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <small>
                                @if($lecturer->functional_position)
                                    <span class="font-weight-bold">{{ $lecturer->functional_position }}</span><br>
                                @endif
                                {{ $lecturer->position ?? $lecturer->expertise ?? '-' }}
                            </small>
                        </td>
                        <td class="align-middle text-sm text-secondary">
                            @if($lecturer->email)<a href="mailto:{{ $lecturer->email }}" title="Email" class="text-secondary"><i class="far fa-envelope"></i></a>@endif
                            @if($lecturer->google_scholar_url)<a href="{{ $lecturer->google_scholar_url }}" target="_blank" title="Scholar" class="text-secondary ml-1"><i class="fab fa-google"></i></a>@endif
                            @if($lecturer->sinta_url)<a href="{{ $lecturer->sinta_url }}" target="_blank" title="SINTA" class="text-secondary ml-1"><i class="fas fa-book-reader"></i></a>@endif
                            @if($lecturer->linkedin_url)<a href="{{ $lecturer->linkedin_url }}" target="_blank" title="LinkedIn" class="text-secondary ml-1"><i class="fab fa-linkedin"></i></a>@endif
                        </td>
                        <td class="align-middle">
                            @if($lecturer->is_active)
                                <span class="badge badge-success">{{ __('admin.active') }}</span>
                            @else
                                <span class="badge badge-secondary">{{ __('admin.inactive') }}</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.lecturers.edit', $lecturer) }}" class="btn btn-outline-primary" title="{{ __('admin.edit') }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.lecturers.destroy', $lecturer) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="{{ __('admin.delete') }}"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">{{ __('admin.no_lecturers') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ __('admin.showing') }} {{ $lecturers->firstItem() }}-{{ $lecturers->lastItem() }} {{ __('admin.of') }} {{ $lecturers->total() }}</small>
                {{ $lecturers->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Dosen & Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.lecturers.import') }}" method="POST" enctype="multipart/form-data">
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
