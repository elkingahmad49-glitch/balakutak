@extends('adminlte::page')

@section('title', __('admin.pages'))

@section('content')
<div class="container-fluid pt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">{{ session('success') }}<button class="close" data-dismiss="alert">&times;</button></div>
    @endif

    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('admin.search_pages') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control form-control-sm">
                        <option value="">{{ __('admin.status') }}</option>
                        <option value="published" {{ request('status')=='published'?'selected':'' }}>{{ __('admin.post_published') }}</option>
                        <option value="draft" {{ request('status')=='draft'?'selected':'' }}>{{ __('admin.post_draft') }}</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold"><i class="fas fa-file-alt me-2"></i>{{ __('admin.pages') }}</h3>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> {{ __('admin.add_page') }}
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-sm mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-3" width="30%">{{ __('admin.page_title') }}</th>
                        <th>{{ __('admin.slug') }}</th>
                        <th>{{ __('admin.post_author') }}</th>
                        <th>{{ __('admin.post_date') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th width="120">{{ __('admin.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td class="pl-3">
                            <strong>{{ $page->title }}</strong>
                            @if($page->is_builder)
                                <span class="badge badge-info ml-1" style="font-size: 0.75rem;"><i class="fas fa-tools mr-1 text-xs"></i> Page Builder</span>
                            @endif
                        </td>
                        <td>
                            <code class="text-muted">{{ $page->slug }}</code>
                            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="ml-1 text-primary"><i class="fas fa-external-link-alt text-xs"></i></a>
                        </td>
                        <td><small>{{ $page->user->name ?? 'Admin' }}</small></td>
                        <td><small>{{ $page->created_at->format('d/m/Y H:i') }}</small></td>
                        <td>
                            @if($page->is_published)
                                <span class="badge badge-success">{{ __('admin.post_published') }}</span>
                            @else
                                <span class="badge badge-secondary">{{ __('admin.post_draft') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-outline-info" title="{{ __('admin.view_all') }}"><i class="fas fa-eye"></i></a>
                                @if($page->is_builder)
                                    <a href="{{ route('admin.pages.builder', $page) }}" class="btn btn-outline-success" title="Page Builder"><i class="fas fa-tools"></i></a>
                                @endif
                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline-primary" title="{{ __('admin.edit') }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="{{ __('admin.delete') }}"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">{{ __('admin.no_pages') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ __('admin.showing') }} {{ $pages->firstItem() }}-{{ $pages->lastItem() }} {{ __('admin.of') }} {{ $pages->total() }}</small>
                {{ $pages->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@stop
