@extends($activeTemplate . 'layouts.frontend')

@section('content')
<section class="clinic-details ptb-80">
    <div class="container">

      <!-- Clinic Header -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-location mb-3" style="font-size: 2.5rem;">
                {{ $clinic->name ?? 'Clinic Name' }}
            </h1>
        </div>

        <!-- Department Tabs -->
        @if ($clinic->departments->isNotEmpty())
            <ul class="nav nav-pills justify-content-center mb-4" id="deptTabs" role="tablist">
                @foreach($clinic->departments as $index => $department)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                id="tab-{{ $department->id }}" 
                                data-bs-toggle="pill"
                                data-bs-target="#content-{{ $department->id }}" 
                                type="button" 
                                role="tab" 
                                aria-controls="content-{{ $department->id }}"
                                aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                            {{ $department->name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <!-- Doctors Under Each Department -->
            <div class="tab-content" id="deptTabsContent">
                @foreach($clinic->departments as $index => $department)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                         id="content-{{ $department->id }}" 
                         role="tabpanel" 
                         aria-labelledby="tab-{{ $department->id }}">
                        <div class="row justify-content-center mb-30">
                            @forelse($departmentDoctors as $dept)
                                @if($dept['department']->id == $department->id)
                                    @forelse($dept['doctors'] as $doctor)
                                        <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
                                            <a href="{{ route('doctors.booking', trim(base64_encode($doctor->id . '-' . time()), '=')) }}">
                                                <div class="booking-item">
                                                    <div class="booking-thumb position-relative">
                                                        <img src="{{ getImage(getFilePath('doctorProfile') . '/' . @$doctor->image, getFileSize('doctorProfile')) }}"
                                                             alt="{{ __('Doctor Image') }}">
                                                        @if ($doctor->featured)
                                                            <span class="fav-btn"><i class="fas fa-medal"></i></span>
                                                        @endif
                                                    </div>
                                                    <div class="booking-content">
                                                        <h5 class="title">
                                                            {{ __($doctor->name) }} <i class="fas fa-check-circle text-success"></i>
                                                        </h5>
                                                        <ul class="booking-list">
                                                            <li>
                                                                <i class="fas fa-street-view"></i>
                                                                <a href="{{ route('doctors.locations', $doctor->location->id) }}">
                                                                    {{ __($doctor->location->name) }}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <i class="fas fa-phone"></i> {{ __($doctor->mobile) }}
                                                            </li>
                                                        </ul>
                                                        <div class="booking-btn">
                                                            <a href="{{ route('doctors.booking', trim(base64_encode($doctor->id . '-' . time()), '=')) }}"
                                                               class="cmn-btn w-100 text-center">
                                                                @lang('Book Now')
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-info text-center" role="alert">
                                                @lang('No doctors found in this department.')
                                            </div>
                                        </div>
                                    @endforelse
                                @endif
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info text-center" role="alert">
                                        @lang('No doctors available.')
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning text-center">
                @lang('No departments found in this clinic.')
            </div>
        @endif

    </div>
</section>
@endsection

@push('style')
<style>
    .nav-pills .nav-link {
        background-color: #f2f2f2;
        color: #356F85;
        margin: 0 6px;
        border-radius: 50px;
    }

    .nav-pills .nav-link.active {
        background-color: #356F85;
        color: #fff;
    }

    .booking-item {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        overflow: hidden;
        transition: 0.3s ease;
    }

    .booking-item:hover {
        box-shadow: 0 0 10px rgba(53, 111, 133, 0.2);
        transform: translateY(-3px);
    }

    .booking-thumb img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .fav-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #f0ad4e;
        color: white;
        padding: 5px;
        border-radius: 50%;
    }

    .booking-content {
        padding: 15px;
    }

    .booking-content .title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .booking-list {
        list-style: none;
        padding: 0;
        margin: 0 0 15px 0;
    }

    .booking-list li {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .booking-btn .cmn-btn {
        background-color: #356F85;
        color: white;
        border: none;
        padding: 8px 0;
        border-radius: 5px;
        display: block;
    }

    .booking-btn .cmn-btn:hover {
        background-color: #285467;
    }
</style>
@endpush
