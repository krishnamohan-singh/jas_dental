@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.doctor.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <x-image-uploader name="image"
                                        :imagePath="getImage(getFilePath('doctorProfile') . '/' . @$doctor->image, getFileSize('doctorProfile'))"
                                        :size="getFileSize('doctorProfile')" class="w-100" id="uploadLogo" :required="false" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Name')</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control "
                                            required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Username')</label>
                                        <input type="text" name="username" value="{{ old('username') }}"
                                            class="form-control " required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('E-mail')</label>
                                        <input type="text" name="email" value="{{ old('email') }}" class="form-control "
                                            required1 />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Mobile')
                                            <i class="fa fa-info-circle text--primary"
                                                title="@lang('Add the country code by general setting. Otherwise, SMS won\'t send to that number.')">
                                            </i>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">{{ gs('country_code') }}</span>
                                            <input type="number" name="mobile" value="{{ old('mobile') }}"
                                                class="form-control" autocomplete="off" required1>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group select2-wrapper" id="select2-wrapper-one">
                                        <label>@lang('Department')</label>
                                        <select class="select2-basic-one form-control" name="department" required>
                                            <option disabled selected>@lang('Select One')</option>
                                            @foreach ($departments as $department)
                                            <option @selected($department->id == @$doctor->department_id) value="{{
                                                $department->id }}">
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
                                            <option @selected($location->id == @$doctor->location_id) value="{{
                                                $location->id }}">
                                                {{ __($location->name) }}
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
                                            <input type="number" name="fees" value="{{ old('fees') }}"
                                                class="form-control" required1 />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label> @lang('Qualification')</label>
                                        <input type="text" name="qualification" value="{{ old('qualification') }}"
                                            class="form-control" required1 />

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label> @lang('Address')</label>
                                        <textarea name="address" class="form-control"
                                            required1>{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label> @lang('About')</label>
                                <textarea name="about" class="form-control" required1>{{ old('about') }}</textarea>
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
<x-back route="{{ route('admin.doctor.index') }}"/>

@endpush

@push('script')
<script>
    (function($) {
            'use strict';
            $('.select2-basic-one').select2({
                dropdownParent: $('#select2-wrapper-one')
            });
            $('.select2-basic-two').select2({
                dropdownParent: $('#select2-wrapper-two')
            });
        })(jQuery);
</script>
@endpush

@push('style')
<style>
    .select2-wrapper {
        position: relative;
    }
</style>
@endpush