@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-4 mb-30">
            <div class="card b-radius--5 overflow-hidden">
                <div class="card-body">
                    <div class="form-group">

                        <div class="image-upload-wrapper">
                            <div class="image-upload-preview"
                                style="background-image: url({{ getImage(getFilePath('clinic') . '/' . $clinic->photo, getFileSize('clinic')) }})">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card b-radius--5 overflow-hidden mt-4">
                <div class="card-body p-0">
                    <h3 class="p-3">@lang('Clinic Information')</h3>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Clinic')
                            <span class="fw-bold">{{ __($clinic->name) }}</span>
                        </li>

                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <a href="{{ route('admin.doctor.detail', $clinic->id) }}"><span
                                    class="fw-bold">{{ $clinic->username }}</span></a>
                        </li> --}}

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span class="fw-bold">{{ $clinic->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            <span class="fw-bold"> @php echo $clinic->status_text @endphp</span>
                        </li>
                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Feature')
                            <span class="fw-bold"> @php echo $clinic->featureBadge @endphp</span>
                        </li> --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Location')
                            <span class="fw-bold"> {{ __($clinic->location->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Fees')
                            <span class="fw-bold"> {{ __($clinic->fees) }} </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-8 mb-30">
            <form action="{{ route('admin.appointment.store', $clinic->id) }}" method="post">
                @csrf
                <div class="card b-radius--10 overflow-hidden box--shadow1">
                    <div class="card-body p-0">
                        <div class="p-3 bg--white">
                            <div class="widget-two box--shadow2 b-radius--5 bg--white mb-4">
                                <i class="far fa-clock overlay-icon text--primary"></i>
                                <div class="widget-two__icon b-radius--5 bg--primary">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div class="widget-two__content">
                                    @if (($clinic->start_time == null || $clinic->end_time == null) && $clinic->max_serial)
                                        <h3>{{ $doctor->max_serial }}</h3>
                                        <p>@lang('Limit of Serial')</p>
                                    @elseif($clinic->start_time && $clinic->end_time2)
                                        <h3>{{ $clinic->start_time }} - {{ $clinic->end_time2 }}</h3>
                                        <p>@lang('Limit Of Time')</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-2 date-label">@lang('Select Date')</label>
                                <select name="booking_date" class="form-control select2" required>
                                    <option selected disabled>@lang('Select One')</option>
                                    @foreach ($availableDate as $date)
                                        <option value="{{ $date }}">{{ __($date) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <h3 class="py-2">@lang('Available Schedule')</h3>
                            <hr>
                            <div class="time-serial-parent mt-3">
                                <h3 class="py-2">@lang('Morning Shift')</h3>
                                @foreach ($clinic->serial_or_slot as $item)
                                    <button type="button"
                                        class="btn btn-primary mr-2 mb-2 available-time item-{{ slug($item) }}"
                                        data-value="{{ $item }}">{{ __($item) }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="time_serial" required>
                            <div class="time-serial-parent mt-3">
                                <h3 class="py-2">@lang('Afternoon Shift')</h3>
                                @foreach ($clinic->serial_or_slot1 as $item)
                                    <button type="button"
                                        class="btn btn-primary mr-2 mb-2 available-time item-{{ slug($item) }}"
                                        data-value="{{ $item }}">{{ __($item) }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="time_serial" required>
                            <div class="time-serial-parent mt-3">
                                <h3 class="py-2">@lang('Evening Shift')</h3>
                                @foreach ($clinic->serial_or_slot2 as $item)
                                    <button type="button"
                                        class="btn btn-primary mr-2 mb-2 available-time item-{{ slug($item) }}"
                                        data-value="{{ $item }}">{{ __($item) }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="time_serial" required>
                        </div>
                    </div>
                </div>

                <div class="card b-radius--10 overflow-hidden box--shadow1 mt-4">
                    <div class="card-body p-0">
                        <div class="row p-3 bg--white">
                            <h3 class="py-2">@lang('Patient Information')</h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Full Name')</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Age')</label>
                                    <div class="input-group">
                                        <input type="number" name="age" step="any" class="form-control"
                                            value="{{ old('age') }}" required>
                                        <span class="input-group-text">
                                            @lang('Years')
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('E-mail')</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Mobile')
                                        <i class="fa fa-info-circle text--primary" title="@lang('Add the country code by general setting. Otherwise, SMS won\'t send to that number.')">
                                        </i>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ gs('country_code') }}</span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}"
                                            class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('Disease Details')</label>
                                <textarea name="disease" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection


@push('style')
    <style>
        a.timeslotdisabled {
            background-color: #e7e7e7 !important;
            color: white !important;
            cursor: not-allowed;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $(".available-time").on('click', function() {
                $(this).parent('.time-serial-parent').find('.btn--success').removeClass(
                    'btn--success disabled').addClass('btn--primary');

                $('[name=time_serial]').val($(this).data('value'));
                $(this).removeClass('btn--primary');
                $(this).addClass('btn--success disabled');
            })

            function slug(text) {
                return text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            }
            $("select[name=booking_date]").on('change', function() {

                $('.available-time').removeClass('btn--success disabled').addClass('btn--primary');

                let url = "{{ route('admin.appointment.available.date') }}";
                let data = {
                    date: $(this).val(),
                    clinic_id: '{{ $clinic->id }}'
                }

                $.get(url, data, function(response) {
                    $('[name=time_serial]').val('');
                    if (response.length == 0) {
                        $('.available-time').removeClass('btn--danger disabled');
                    } else {
                        $.each(response, function(key, value) {
                            var demo = slug(value);
                            $(`.item-${demo}`).addClass('btn--danger disabled');
                        });
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
