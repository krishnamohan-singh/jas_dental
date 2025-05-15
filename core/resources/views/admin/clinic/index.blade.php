@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Photo')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Phone')</th>
                                    <th>@lang('Address')</th>
                                    <th>@lang('Location')</th>
                                    <th>@lang('Map')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clinics as $clinic)
                                    <tr>
                                        <td>{{ $clinics->firstItem() + $loop->index }}</td>
                                        <td>
                                            @if($clinic->photo)
                                                <div class="avatar avatar--md">
                                                    <img src="{{ getImage(getFilePath('clinic') . '/' . $clinic->photo, getFileSize('clinic')) }}"
                                                         alt="@lang('Photo')">
                                                </div>
                                            @else
                                                <span class="text-muted">@lang('No Image')</span>
                                            @endif
                                        </td>
                                        <td>{{ __($clinic->name) }}</td>
                                        <td>{{ $clinic->email ?? '-' }}</td>
                                        <td>{{ $clinic->phone ?? '-' }}</td>
                                        <td>{{ $clinic->address ?? '-' }}</td>
                                        <td>{{ optional($clinic->location)->name ?? '-' }}</td>
                                        <td style="max-width: 250px; overflow-x: auto; white-space: nowrap; display: inline-block; scrollbar-width: thin; scrollbar-color: #ccc transparent;"> <span style=" display: inline-block; min-width: 100%; -webkit-overflow-scrolling: touch; "> {{ $clinic->map_location ?? '-' }} </span> </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline--primary editBtn cuModalBtn"
                                                    data-resource="{{ $clinic }}"
                                                    data-modal_title="@lang('Edit Clinic')"
                                                    data-action="{{ route('admin.clinic.update', $clinic->id) }}"
                                                    data-has_status="1">
                                                <i class="la la-pencil-alt"></i> @lang('Edit')
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($clinics->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($clinics) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.clinic.store') }}" method="POST" enctype="multipart/form-data" id="clinicForm">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="PUT">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <x-image-uploader name="image" :imagePath="getImage(getFilePath('clinic'), getFileSize('clinic')) .
                                        '?' .
                                        time()" :size="getFileSize('clinic')" class="w-100"
                                        id="image" :required="false" />
                                    
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Clinic Name')</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Phone')</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input type="text" name="address" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>@lang('Location')</label>
                                    <select name="location_id" class="form-control" required>
                                        <option value="">@lang('Select Location')</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Map Location (iframe embed code)')</label>
                                    <textarea name="map_location" class="form-control" rows="4" placeholder="Paste iframe embed code here..."></textarea>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <x-search-form />
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Clinic')">
        <i class="las la-plus"></i> @lang('Add New')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($){
            "use strict";

            $('.editBtn').on('click', function () {
        var data = $(this).data('resource');
        var imageUrl = data.photo
            ? '{{ getImage(getFilePath('clinic')) }}/' + data.photo
            : '{{ asset('assets/images/default.png') }}';

        $('#cuModal').find('.image-upload-preview').css({
            'background-image': `url(${imageUrl})`
        });
    });

            $('#cuModal').on('hidden.bs.modal', function () {
                $('#cuModal').find('.image-upload-preview').css({
                    'background-image': `url(${placeholderImage})`
                });
                $('#cuModal').find('[name=photo]').attr('required', 'required');
                $('#cuModal').find('[name=photo]').closest('.form-group').find('label').first().addClass('required');
            });

        })(jQuery);
    </script>
@endpush
