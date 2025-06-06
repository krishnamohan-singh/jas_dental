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

                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clinics as $clinic)
                                    <tr>
                                        <td>{{ $clinics->firstItem() + $loop->index }}</td>
                                        <td>
                                            @if ($clinic->photo)
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
                                        <td
                                            style="max-width: 250px; overflow-x: auto; white-space: nowrap; display: inline-block; scrollbar-width: thin; scrollbar-color: #ccc transparent;">
                                            <span
                                                style=" display: inline-block; min-width: 100%; -webkit-overflow-scrolling: touch; ">
                                                {{ $clinic->map_location ?? '-' }} </span>
                                        </td>
                                        <td>
                                            <span
                                                style="background-color: {{ $clinic->status ? '#d4edda' : '#f8d7da' }}; color: {{ $clinic->status ? '#155724' : '#721c24' }}; padding: 4px 8px; border-radius: 4px;">
                                                {{ $clinic->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline--primary editBtn cuModalBtn"
                                                data-resource='@json($clinic->toArray() + ['consultation_fee' => $clinic->fees])'
                                                data-modal_title="@lang('Edit Clinic')"
                                                data-action="{{ route('admin.clinic.update', $clinic->id) }}"
                                                data-has_status="1">
                                                <i class="la la-pencil-alt"></i> @lang('Edit')
                                            </button>

                                            {{-- <button type="button"
                                                class="btn btn-sm btn-outline--primary editBtn cuModalBtn"
                                                data-resource="{{ $clinic }}" data-modal_title="@lang('Edit Clinic')"
                                                data-action="{{ route('admin.clinic.update', $clinic->id) }}"
                                                data-has_status="1">
                                                <i class="la la-pencil-alt"></i> @lang('Edit')
                                            </button> --}}
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
                <form action="{{ route('admin.clinic.store') }}" method="POST" enctype="multipart/form-data"
                    id="clinicForm">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="PUT">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <x-image-uploader name="image" :imagePath="getImage(getFilePath('clinic'), getFileSize('clinic')) . '?' . time()" :size="getFileSize('clinic')" class="w-100"
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
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">@lang('Select Status')</option>
                                        <option value="1" {{ old('status', $clinic->status ?? '') == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status', $clinic->status ?? '') == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group flex-fill ms-2">
                                <label for="consultation_fee">@lang('Basic Consultation Fee')</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" value="{{ $clinic->fees }}" name="consultation_fee"
                                        id="consultation_fee" class="form-control" placeholder="Enter amount" min="0"
                                        step="1">
                                </div>
                            </div>

                            
                                <div class="form-group">
                                    <label>@lang('Heading')</label>
                                    <input type="text" name="heading" class="form-control">
                                </div>
                            
                            <div class="form-group">
                                    <label>@lang('Discription')</label>
                                    <textarea name="discription" class="form-control" rows="4"
                                    placeholder="Enter here your discription...."></textarea>
                            </div>

                            <div class="form-group">
                                <label>@lang('Map Location (iframe embed code)')</label>
                                <textarea name="map_location" class="form-control" rows="4"
                                    placeholder="Paste iframe embed code here..."></textarea>
                            </div>

                        </div>



                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-lg-6">
                                            <div class="form-group">
                                                <label>@lang('Slot Type')</label>
                                                <select name="slot_type" id="slot-type" class="form-control select2"
                                                    data-minimum-results-for-search="-1" required>
                                                    <option value="" selected disabled>@lang('Select One')</option>

                                                    <option value="2" @selected($clinic->slot_type == 2)>@lang('Time')
                                                    </option>
                                                </select>
                                                <small class="text-success" style="font-size: smaller">Note:
                                                    Schedule it as per serial or token
                                                    time
                                                    slot.</small>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-lg-6">
                                            <div class="form-group">
                                                <label>@lang('For How Many Days')
                                                    <i class="fa fa-info-circle text--primary"
                                                        title="@lang('This will define that your appointment booking will be taken for the next how many days including today. That means with everyday it will add your given value.')">
                                                    </i>
                                                </label>
                                                <div class="input-group">
                                                    <input class="form-control" type="number" name="serial_day"
                                                        value="{{ $clinic->serial_day }}" required>
                                                    <span class="input-group-text">@lang('Days')</span>
                                                </div>
                                            </div>
                                        </div>

                                        @php
                                            $formattedStartTime = $clinic->start_time
                                                ? date('H:i', strtotime($clinic->start_time ?? ''))
                                                : null;
                                            $formattedEndTime = $clinic->end_time
                                                ? date('H:i', strtotime($clinic->end_time ?? ''))
                                                : null;

                                            $formattedStartTime1 = $clinic->start_time1
                                                ? date('H:i', strtotime($clinic->start_time1 ?? ''))
                                                : null;
                                            $formattedEndTime1 = $clinic->end_time1
                                                ? date('H:i', strtotime($clinic->end_time1 ?? ''))
                                                : null;

                                            $formattedStartTime2 = $clinic->start_time2
                                                ? date('H:i', strtotime($clinic->start_time2 ?? ''))
                                                : null;
                                            $formattedEndTime2 = $clinic->end_time2
                                                ? date('H:i', strtotime($clinic->end_time2 ?? ''))
                                                : null;
                                        @endphp

                                        <div class="col-sm-12 duration d-none">
                                            <div class="form-group">
                                                <label> @lang('Time Duration')</label>
                                                <div class="input-group">
                                                    <input type="text" name="duration" class="form-control"
                                                        value="{{ old('duration', $clinic->duration) }}">
                                                    <span class="input-group-text">@lang('Minutes')</span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ///////////////////////////Morning Time//////////////////////////// --}}
                                        <div class="col-md-3 mt-2 col-lg-6 start d-none">
                                            <div class="form-group">
                                                <div>&nbsp;</div>
                                                <small class="text-success medium">Note: Add Time In 24-hour
                                                    format</small>
                                                <div>Morning Time:</div>

                                                <label>@lang('Start Time')</label>
                                                <input type="time" name="start_time"
                                                    value="{{ old('start_time', $formattedStartTime) }}"
                                                    class="form-control time-picker" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-6 end d-none">
                                            <div class="form-group">
                                                <div>&nbsp;</div>
                                                <div>&nbsp;</div>
                                                <div>&nbsp;</div>


                                                <label>@lang('End Time')</label>
                                                <input type="time" name="end_time"
                                                    value="{{ old('end_time', $formattedEndTime) }}"
                                                    class="form-control time-picker" autocomplete="off">
                                            </div>
                                        </div>
                                        {{-- ////////////////////////////////////////////////////////////////////// --}}
                                        {{-- ///////////////////////////Aternoon Time//////////////////////////// --}}
                                        <div class="col-md-3 col-lg-6 start d-none">
                                            <div class="form-group">
                                                <div>&nbsp;</div>
                                                <div>Aternoon Time:</div>

                                                <label>@lang('Start Time')</label>
                                                <input type="time" name="start_time1"
                                                    value="{{ old('start_time1', $formattedStartTime1) }}"
                                                    class="form-control time-picker" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-6 end d-none">
                                            <div class="form-group">
                                                <div>&nbsp;</div>
                                                <div>&nbsp;</div>

                                                <label>@lang('End Time1')</label>
                                                <input type="time" name="end_time1"
                                                    value="{{ old('end_time1', $formattedEndTime1) }}"
                                                    class="form-control time-picker" autocomplete="off">
                                            </div>
                                        </div>
                                        {{-- ////////////////////////////////////////////////////////////////////// --}}
                                        {{-- ///////////////////////////Evening Time//////////////////////////// --}}
                                        <div class="col-md-3 col-lg-6 start d-none">
                                            <div class="form-group">
                                                <div>&nbsp;</div>
                                                <div>Evening Time:</div>

                                                <label>@lang('Start Time')</label>
                                                <input type="time" name="start_time2"
                                                    value="{{ old('start_time2', $formattedStartTime2) }}"
                                                    class="form-control time-picker" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-6 end d-none">
                                            <div class="form-group">
                                                <div>&nbsp;</div>
                                                <div>&nbsp;</div>

                                                <label>@lang('End Time')</label>
                                                <input type="time" name="end_time2"
                                                    value="{{ old('end_time2', $formattedEndTime2) }}"
                                                    class="form-control time-picker" autocomplete="off">
                                            </div>
                                        </div>
                                        {{-- ////////////////////////////////////////////////////////////////////// --}}


                                        <div class="col-sm-6 col-lg-12 serial d-none">
                                            <div class="form-group">
                                                <label> @lang('Maximum Serial')</label>
                                                <input type="text" class="form-control" name="max_serial"
                                                    value="{{ old('max_serial', $clinic->max_serial) }}">
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row mb-none-30 mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>@lang('System of Current Schedule')</h4>
                                        @if ($clinic->slot_type && $clinic->serial_or_slot)
                                            <hr>
                                            <div>Morning Time Slotes:</div>

                                            <div class="mt-4">
                                                @foreach ($clinic->serial_or_slot as $item)
                                                    <button type="button" class="btn btn--primary mr-2 mb-2">{{ $item }}</button>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if ($clinic->slot_type && $clinic->serial_or_slot1)
                                            <hr>
                                            <div>Afternoon Time Slotes:</div>

                                            <div class="mt-4">
                                                @foreach ($clinic->serial_or_slot1 as $item)
                                                    <button type="button" class="btn btn--primary mr-2 mb-2">{{ $item }}</button>
                                                @endforeach
                                            </div>
                                        Q @endif
                                        @if ($clinic->slot_type && $clinic->serial_or_slot2)
                                            <hr>
                                            <div>Evening Time Slotes:</div>

                                            <div class="mt-4">
                                                @foreach ($clinic->serial_or_slot2 as $item)
                                                    <button type="button" class="btn btn--primary mr-2 mb-2">{{ $item }}</button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--success h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
        410az
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
        (function ($) {
            "use strict";

            $('.editBtn').on('click', function () {
                var data = $(this).data('resource');
                console.log(data);
                var imageUrl = data.photo ?
                    '{{ getImage(getFilePath('clinic')) }}/' + data.photo :
                    '{{ asset('assets/images/default.png') }}';

                $('#cuModal').find('.image-upload-preview').css({
                    'background-image': `url(${imageUrl})`
                });
            });

            $('#cuModal').on('hidden.bs.modal', function () {
                $('#cuModal').find('.image-upload-preview').css({
                    'background-image': `url(${placeholderImage})`
                });
                $('#cuModal').find('[name=photo]').attr('required', 'required');
                $('#cuModal').find('[name=photo]').closest('.form-group').find('label').first().addClass(
                    'required');
            });

        })(jQuery);
    </script>
@endpush

@push('script')
    <script>
        (function ($) {
            'use strict';

            $('select[name=slot_type]').on('change', function () {
                var type = $(this).val();
                schedule(type);
            })

            var type = $('select[name=slot_type]').val();
            if (type) {
                schedule(type);
            }

            function schedule(type) {
                if (type == 1) {
                    $('.duration').addClass('d-none');
                    $('.serial').removeClass('d-none');
                    $('.start').addClass('d-none');
                    $('.end').addClass('d-none');
                } else {
                    $('.start').removeClass('d-none');
                    $('.end').removeClass('d-none');
                    $('.serial').addClass('d-none');
                    $('.duration').removeClass('d-none')
                }
            }




        })(jQuery);
    </script>
    <script>
        (function ($) {
            'use strict';

            $('select[name=slot_type]').on('change', function () {
                var type = $(this).val();
                schedule(type);
            })

            var type = $('select[name=slot_type]').val();
            if (type) {
                schedule(type);
            }

            function schedule(type) {
                if (type == 1) {
                    $('.duration').addClass('d-none');
                    $('.serial').removeClass('d-none');
                    $('.start').addClass('d-none');
                    $('.end').addClass('d-none');
                } else {
                    $('.start').removeClass('d-none');
                    $('.end').removeClass('d-none');
                    $('.serial').addClass('d-none');
                    $('.duration').removeClass('d-none')
                }
            }




        })(jQuery);
    </script>
@endpush