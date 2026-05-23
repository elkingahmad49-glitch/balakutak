@extends('adminlte::page')

@section('title', __('admin.posts'))

@section('content')
<div class="container-fluid pt-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible">{{ session('success') }}<button class="close" data-dismiss="alert">&times;</button></div>
    @endif

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('admin.search_posts') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control form-control-sm">
                        <option value="">{{ __('admin.status') }}</option>
                        <option value="draft" {{ request('status')=='draft'?'selected':'' }}>{{ __('admin.post_draft') }}</option>
                        <option value="published" {{ request('status')=='published'?'selected':'' }}>{{ __('admin.post_published') }}</option>
                        <option value="archived" {{ request('status')=='archived'?'selected':'' }}>Archived</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-control form-control-sm">
                        <option value="">{{ __('admin.filter_category') }}</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="month" class="form-control form-control-sm">
                        <option value="">Filter Bulan</option>
                        @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ request('month')==$num?'selected':'' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="year" class="form-control form-control-sm">
                        <option value="">Filter Tahun</option>
                        @foreach($years as $yr)
                        <option value="{{ $yr }}" {{ request('year')==$yr?'selected':'' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h3 class="card-title font-weight-bold mr-3"><i class="fas fa-newspaper me-2"></i>{{ __('admin.posts') }}</h3>
                
                {{-- Bulk Delete Button (Super Admin & Admin Only) --}}
                @if(auth()->user()->hasRole(['Super Admin', 'Admin Prodi']))
                <form id="bulk-delete-form" action="{{ route('admin.posts.mass-destroy') }}" method="POST" style="display: none;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel yang dipilih?')">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                    </button>
                </form>
                @endif
            </div>
            
            <div class="d-flex gap-2">
                @can('create posts')
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importXmlModal">
                    <i class="fas fa-file-import me-1"></i> Import XML
                </button>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> {{ __('admin.add_post') }}
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-sm mb-0">
                <thead class="bg-light">
                    <tr>
                        @if(auth()->user()->hasRole(['Super Admin', 'Admin Prodi']))
                        <th class="pl-3" width="40">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="select-all">
                                <label class="custom-control-label" for="select-all"></label>
                            </div>
                        </th>
                        @endif
                        <th class="{{ auth()->user()->hasRole(['Super Admin', 'Admin Prodi']) ? '' : 'pl-3' }}" width="40%">{{ __('admin.title') }}</th>
                        <th>{{ __('admin.post_category') }}</th>
                        <th>Type</th>
                        <th>{{ __('admin.status') }}</th>
                        <th>{{ __('admin.post_views') }}</th>
                        <th>{{ __('admin.post_date') }}</th>
                        <th width="120">{{ __('admin.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($posts as $post)
                    <tr>
                        @if(auth()->user()->hasRole(['Super Admin', 'Admin Prodi']))
                        <td class="pl-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="ids[]" value="{{ $post->id }}" form="bulk-delete-form" class="custom-control-input post-checkbox" id="check-{{ $post->id }}">
                                <label class="custom-control-label" for="check-{{ $post->id }}"></label>
                            </div>
                        </td>
                        @endif
                        <td class="{{ auth()->user()->hasRole(['Super Admin', 'Admin Prodi']) ? '' : 'pl-3' }}">
                            <div class="d-flex align-items-center gap-2">
                                @if($post->featured_image)
                                    <img src="{{ $post->featured_image_url }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px" alt="">
                                @endif
                                <div>
                                    <strong>{{ Str::limit($post->title, 50) }}</strong>
                                    @if($post->is_featured)<span class="badge badge-warning badge-sm ml-1">Featured</span>@endif
                                    <br>
                                    <small class="text-muted">{{ $post->user->name }}</small>
                                </div>
                            </div>
                        </td>
                        <td><small>{{ $post->category?->name ?? '-' }}</small></td>
                        <td>
                            <span class="badge badge-{{ ['post'=>'secondary','news'=>'info','research'=>'primary','community'=>'success'][$post->type] ?? 'secondary' }}">
                                {{ Str::ucfirst($post->type) }}
                            </span>
                        </td>
                        <td>
                            @can('publish posts')
                            <form action="{{ route('admin.posts.toggle-status', $post) }}" method="POST" style="display:inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="badge badge-{{ $post->status==='published'?'success':'secondary' }} border-0 cursor-pointer">
                                    {{ Str::ucfirst($post->status) }}
                                </button>
                            </form>
                            @else
                            <span class="badge badge-{{ $post->status==='published'?'success':'secondary' }}">{{ Str::ucfirst($post->status) }}</span>
                            @endcan
                        </td>
                        <td><small>{{ number_format($post->views) }}</small></td>
                        <td><small>{{ $post->published_at?->format('d/m/Y') ?? $post->created_at->format('d/m/Y') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="btn btn-outline-info" title="{{ __('admin.view_all') }}"><i class="fas fa-eye"></i></a>
                                @can('edit posts')
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-primary" title="{{ __('admin.edit') }}"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('delete posts')
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="{{ __('admin.delete') }}"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ auth()->user()->hasRole(['Super Admin', 'Admin Prodi']) ? '8' : '7' }}" class="text-center text-muted py-4">{{ __('admin.no_posts') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ __('admin.showing') }} {{ $posts->firstItem() }}-{{ $posts->lastItem() }} {{ __('admin.of') }} {{ $posts->total() }}</small>
                {{ $posts->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>

{{-- Import XML Modal --}}
<div class="modal fade" id="importXmlModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.posts.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-import me-2"></i> {{ __('admin.import_posts') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="xml_file">{{ __('admin.file_type') }} XML WordPress</label>
                        <input type="file" name="xml_file" id="xml_file" class="form-control-file @error('xml_file') is-invalid @enderror" accept=".xml" required>
                        @error('xml_file')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.cancel') }}</button>
                    <button type="submit" class="btn btn-success" id="btnImportXml">
                        <i class="fas fa-upload me-1"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        const selectAll = $('#select-all');
        const checkboxes = $('.post-checkbox');
        const bulkDeleteForm = $('#bulk-delete-form');
        const selectedCount = $('#selected-count');

        function updateBulkButton() {
            const checkedCount = $('.post-checkbox:checked').length;
            selectedCount.text(checkedCount);
            if (checkedCount > 0) {
                bulkDeleteForm.show();
            } else {
                bulkDeleteForm.hide();
            }
        }

        selectAll.on('change', function() {
            checkboxes.prop('checked', $(this).prop('checked'));
            updateBulkButton();
        });

        checkboxes.on('change', function() {
            if (!$(this).prop('checked')) {
                selectAll.prop('checked', false);
            }
            if ($('.post-checkbox:checked').length === checkboxes.length) {
                selectAll.prop('checked', true);
            }
            updateBulkButton();
        });
    });
</script>
@endpush
