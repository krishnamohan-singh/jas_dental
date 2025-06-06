@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-xxl-4 col-sm-6">
                    <x-widget link="javascript:void(0)" icon="las la-wallet" type="2" style="7"
                        title="Total Online Earn" value="{{ showAmount($totalOnlineEarn) }}" bg="19" />
                </div>
                <!-- dashboard-w1 end -->
                <div class="col-xxl-4 col-sm-6">
                    <x-widget link="javascript:void(0)" icon="las la-hand-holding-usd" type="2" style="7"
                        title="Total Cash Earn" value="{{ showAmount($totalCashEarn) }}" bg="11" />
                </div>
                <!-- dashboard-w1 end -->
                <div class="col-xxl-4 col-sm-6">
                    <x-widget link="javascript:void(0)" icon="las la-handshake" type="2" style="7"
                        title="Total Appointments" value="{{ $totalAppointments }}" bg="3" />
                </div>
                <!-- dashboard-w1 end -->
                <div class="col-xxl-4 col-sm-6">
                    <x-widget link="javascript:void(0)" icon="las la-check-circle" type="2" style="7"
                        title="Total Done Appointments" value="{{ $completeAppointments }}" bg="success" />
                </div>
                <!-- dashboard-w1 end -->
                <div class="col-xxl-4 col-sm-6">
                    <x-widget link="javascript:void(0)" icon="las la-calendar-day" type="2" style="7"
                        title="Total Booking Days" value="{{ $doctor->serial_day }}" bg="primary" />
                </div>
                <!-- dashboard-w1 end -->
                <div class="col-xxl-4 col-sm-6">
                    <x-widget link="javascript:void(0)" icon="las la-trash" title="Total Trashed Appointments"
                        type="2" style="7" value="{{ $trashedAppointments }}" bg="danger" />
                </div>
                <!-- dashboard-w1 end -->
            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <div class="flex-fill">
                    <a href="{{ route('admin.doctor.login.history', $doctor->id) }}" class="btn btn--primary w-100 btn-lg">
                        <i class="las la-history"></i>@lang('Login History')
                    </a>
                </div>
                <div class="flex-fill">
                    <a href="{{ route('admin.doctor.notification.log', $doctor->id) }}"
                        class="btn btn--warning w-100 btn-lg">
                        <i class="las la-envelope"></i>@lang('Notification Logs')
                    </a>
                </div>
                <div class="flex-fill">
                    <a href="{{ route('admin.doctor.login', $doctor->id) }}" target="_blank"
                        class="btn btn--primary btn--gradi w-100 btn-lg">
                        <i class="las la-sign-in-alt"></i>@lang('Login as Doctor')
                    </a>
                </div>
            </div>
            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $doctor->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.doctor.store', $doctor->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>@lang('Image')</label>
                                        <x-image-uploader name="image" :imagePath="getImage(
                                            getFilePath('doctorProfile') . '/' . @$doctor->image,
                                            getFileSize('doctorProfile'),
                                        )" :size="getFileSize('doctorProfile')" class="w-100"
                                            id="uploadLogo" :required="false" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input type="text" name="name" value="{{ $doctor->name }}"
                                                class="form-control " required />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Username')</label>
                                            <input type="text" name="username" value="{{ $doctor->username }}"
                                                class="form-control " required />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('E-mail')</label>
                                            <input type="text" name="email" value="{{ $doctor->email }}"
                                                class="form-control "   />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile')
                                                <i class="fa fa-info-circle text--primary" title="@lang('Add the country code by general setting. Otherwise, SMS won\'t send to that number.')">
                                                </i>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ gs('country_code') }}</span>
                                                <input type="number" name="mobile"
                                                    value="{{ str_replace(gs('country_code'), '', $doctor->mobile) }}"
                                                    class="form-control " autocomplete="off"  >
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group select2-wrapper" id="select2-wrapper-one">
                                            <label>@lang('Department')</label>
                                            <select class="select2-basic-one form-control" name="department" required>
                                                <option disabled selected>@lang('Select One')</option>
                                                @foreach ($departments as $department)
                                                    <option @selected($department->id == @$doctor->department_id)
                                                        value="{{ old('department', $department->id) }}">
                                                        {{ __($department->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group select2-wrapper" id="select2-wrapper-two">
                                            <label>@lang('Location')</label>
                                            <select class="select2-basic-two form-control" name="location" required>
                                                <option disabled selected>@lang('Select One')</option>
                                                @foreach ($locations as $location)
                                                    <option @selected($location->id == @$doctor->location_id) value="{{ $location->id }}">
                                                        {{ __($location->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-sm-12">
                                        <div class="form-group select2-wrapper" id="select2-wrapper-two">
                                            <label>@lang('Clinic')</label>
                                            <select class="select2-basic-two form-control" name="clinic" required>
                                                <option disabled selected>@lang('Select One')</option>
                                                @foreach ($clinics as $clinic)
                                                <option @selected($clinic->id == @$doctor->clinic_id) value="{{
                                                    $clinic->id }}">
                                                    {{ __($clinic->name) }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> @lang('Fees')</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                                <input type="number" name="fees" value="{{ $doctor->fees }}"
                                                    class="form-control"   />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> @lang('Qualification')</label>
                                            <input type="text" name="qualification"
                                                value="{{ $doctor->qualification }}" class="form-control"   />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>@lang('Address') </label>
                                        <textarea name="address" class="form-control"  >{{ $doctor->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="from-group">
                                <label>@lang('About') </label>
                                <textarea name="about" class="form-control"  >{{ $doctor->about }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.doctor.index') }}" />
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';
            $('.select2-basic-one , .select2-basic-two').select2();
        })(jQuery);
    </script>
@endpush
