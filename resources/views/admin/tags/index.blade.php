@extends('adminlte::page')

@section('title', __('admin.tags'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ __('admin.tags') }}</h1>
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('admin.add_tag') }}
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header border-0 pb-0">
                    <form action="{{ route('admin.tags.index') }}" method="GET" class="form-inline">
                        <div class="input-group input-group-sm w-100" style="max-width: 300px;">
                            <input type="text" name="search" class="form-control" placeholder="{{ __('admin.search_tags') }}" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.tag_name') }}</th>
                                <th>{{ __('admin.slug') }}</th>
                                <th>{{ __('admin.description') }}</th>
                                <th>{{ __('admin.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tags as $tag)
                                <tr>
                                    <td>{{ $loop->iteration + $tags->firstItem() - 1 }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td><code>{{ $tag->slug }}</code></td>
                                    <td>{{ Str::limit($tag->description, 50) ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-info" title="{{ __('admin.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ __('admin.delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle mb-2" style="font-size: 24px;"></i><br>
                                        {{ __('admin.no_tags') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($tags->hasPages())
                    <div class="card-footer border-0">
                        {{ $tags->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
