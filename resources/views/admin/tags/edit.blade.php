@extends('adminlte::page')

@section('title', __('admin.edit_tag'))

@section('content_header')
    <h1>{{ __('admin.edit_tag') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-primary card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title">{{ __('admin.edit_tag') }}</h3>
                </div>
                <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('admin.tag_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $tag->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Slug: <code>{{ $tag->slug }}</code></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">{{ __('admin.description') }}</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ old('description', $tag->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="card-footer text-right border-0 bg-transparent mb-3">
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-default px-4 mr-2">{{ __('admin.cancel') }}</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-1"></i> {{ __('admin.save_tag') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
