@extends('adminlte::page')

@section('title', __('admin.sliders'))

@section('content')
<div class="container-fluid pt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">{{ session('success') }}<button class="close" data-dismiss="alert">&times;</button></div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold"><i class="fas fa-images me-2"></i>{{ __('admin.sliders') }}</h3>
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> {{ __('admin.add_slider') }}
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th width="150" class="pl-3">{{ __('admin.image') }}</th>
                        <th>{{ __('admin.slider_title') }}</th>
                        <th>{{ __('admin.slider_button_text') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th width="120">{{ __('admin.action') }}</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                @forelse($sliders as $slider)
                    <tr data-id="{{ $slider->id }}">
                        <td class="text-center align-middle cursor-move text-muted">
                            <i class="fas fa-grip-vertical"></i>
                        </td>
                        <td class="pl-3 align-middle">
                            <img src="{{ asset('storage/' . $slider->image) }}" class="img-thumbnail" style="width: 120px; height: 60px; object-fit: cover;">
                        </td>
                        <td class="align-middle">
                            <strong>{{ $slider->title }}</strong>
                            <br>
                            <span class="text-muted">{{ \Illuminate\Support\Str::limit($slider->subtitle, 80) }}</span>
                        </td>
                        <td class="align-middle">
                            @if($slider->button_text)
                                <a href="{{ $slider->button_url ?? '#' }}" class="badge badge-info" target="_blank">{{ $slider->button_text }}</a>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td class="align-middle">
                            <form action="{{ route('admin.sliders.toggleStatus', $slider) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $slider->is_active ? 'btn-success' : 'btn-secondary' }}" title="Klik untuk {{ $slider->is_active ? 'nonaktifkan' : 'aktifkan' }}">
                                    <i class="fas {{ $slider->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} me-1"></i>
                                    {{ $slider->is_active ? __('admin.active') : __('admin.inactive') }}
                                </button>
                            </form>
                        </td>
                        <td class="align-middle">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-outline-primary" title="{{ __('admin.edit') }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="{{ __('admin.delete') }}"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">{{ __('admin.no_sliders') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted text-sm">
            <i class="fas fa-info-circle"></i> Drag and drop rows to reorder sliders.
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $("#sortable").sortable({
            handle: ".cursor-move",
            update: function(event, ui) {
                let orders = [];
                $(this).children('tr').each(function(index) {
                    orders.push({
                        id: $(this).data('id'),
                        order: index + 1
                    });
                });

                $.ajax({
                    url: '{{ route("admin.sliders.reorder") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        orders: orders
                    },
                    success: function(response) {
                        toastr.success('Order updated!');
                    }
                });
            }
        });
    });
</script>
<style>
    .cursor-move { cursor: move; }
    .ui-sortable-helper { display: table; background: #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
</style>
@stop
