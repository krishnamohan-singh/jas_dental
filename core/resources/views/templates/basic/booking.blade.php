@extends($activeTemplate . 'layouts.frontend')
@section('content')



    <!-- booking-section start -->
      <section class="doctor-profile-section pd-t-80 pd-b-40">
            <div class="container">
                <div class="doctor-profile-card">
                    <div class="profile-header">
                        <div class="profile-image">
                            <img src="{{ getImage(getFilePath('doctorProfile') . '/' . $doctor->image, getFileSize('doctorProfile')) }}"
                                alt="{{ __($doctor->name) }}">
                            @if ($doctor->featured)
                                <span class="featured-badge" title="@lang('Featured Doctor')"><i class="las la-medal"></i></span>
                            @endif
                        </div>
                        <div class="profile-info">
                            <h4 class="doctor-name">{{ __($doctor->name) }} <i class="fas fa-check-circle verified-icon" title="@lang('Verified Doctor')"></i></h4>
                            <p class="doctor-qualification">{{ __($doctor->qualification) }}</p>
                            <ul class="contact-info">
                                <li><i class="fas fa-map-marker-alt"></i> {{ __($doctor->location->name) }}</li>
                                <li><i class="fas fa-phone"></i> <a href="tel:{{ __($doctor->mobile) }}">{{ __($doctor->mobile) }}</a></li>
                            </ul>
                            @if ($doctor->speciality || !empty($doctor->speciality))
                                <div class="specializations">
                                    @foreach ($doctor->speciality as $item)
                                        <span class="specialization-tag">{{ __($item) }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <ul class="social-icons">
                                @foreach ($doctor->socialIcons as $social)
                                    <li><a href="{{ $social->url }}" target="_blank" title="{{ $social->name }}">@php echo $social->icon @endphp</a></li>
                                @endforeach
                            </ul>
                            <div class="appointment-availability">
                                @if ($doctor->serial_day && $doctor->serial_or_slot)
                                    <span class="availability-badge available" title="@lang('Appointment Available')"><i class="la la-check-circle"></i> @lang('Available for Appointment')</span>
                                @else
                                    <span class="availability-badge unavailable" title="@lang('Not Available for Appointment')"><i class="la la-times-circle"></i> @lang('Currently Unavailable')</span>
                                @endif
                            </div>
                            <div class="action-buttons">
                                <a href="#about-section" class="btn btn-primary btn-sm smooth-scroll">@lang('Learn More')</a>
                                <button class="btn btn-outline-secondary btn-sm save-doctor" data-doctor-id="{{ $doctor->id }}">
                                    <i class="far fa-heart"></i> <span class="save-text">@lang('Save')</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="profile-details">
                        <div class="detail-section" id="about-section">
                            <h5 class="detail-title">@lang('About Me')</h5>
                            <div class="about-me-content">
                                @if ($doctor->about)
                                    {!! nl2br(e(__($doctor->about))) !!}
                                @else
                                    <span>@lang('Doctor about will be appearing soon')</span>
                                @endif
                            </div>
                        </div>

                        <div class="detail-section" id="education-section">
                            <h5 class="detail-title">@lang('Education')</h5>
                            @if (count($doctor->educationDetails))
                                <ul class="timeline">
                                    @foreach ($doctor->educationDetails as $education)
                                        <li>
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6 class="institution">{{ __($education->institution) }}</h6>
                                                <p class="discipline">{{ __($education->discipline) }}</p>
                                                <span class="period">{{ __($education->period) }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p><span>@lang('Education data will be appearing soon')</span></p>
                            @endif
                        </div>

                        <div class="detail-section" id="experience-section">
                            <h5 class="detail-title">@lang('Work & Experience')</h5>
                            @if (count($doctor->experienceDetails))
                                <ul class="timeline">
                                    @foreach ($doctor->experienceDetails as $experience)
                                        <li>
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6 class="institution">{{ __($experience->institution) }}</h6>
                                                <p class="discipline">{{ __($experience->discipline) }}</p>
                                                <span class="period">{{ __($experience->period) }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p><span>@lang('Experience data will be appearing soon')</span></p>
                            @endif
                        </div>

                        <div class="detail-section" id="specializations-section">
                            <h5 class="detail-title">@lang('Specializations')</h5>
                            @if ($doctor->speciality)
                                <ul class="specialization-list">
                                    @foreach ($doctor->speciality as $item)
                                        <li><i class="fas fa-check-circle"></i> {{ __($item) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p><span>@lang('Specializations data will be appearing soon')</span></p>
                            @endif
                        </div>

                        </div>
                </div>
            </div>
        </section>

@endsection
@push('style')
    <style>
         /* Utility Styles */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .title {
        color: #333;
        margin-bottom: 15px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        font-size: 1.5em;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .cmn-btn {
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none; /* For <a> tags styled as buttons */
        display: inline-block; /* For consistent button behavior */
    }

    /* Input Group Text */
    .input-group-text {
        background-color: #eee;
        border: 1px solid #ccc;
        border-right: none;
        padding: 10px;
        border-radius: 0.5rem 0 0 0.5rem !important;
        font-size: 14px;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 4px 4px 0;
    }

    /* Select2 Override */
    .select2-selection--single {
        background: #FF8686 !important;
        height: auto !important; /* Ensure proper height */
        padding: 8px !important; /* Adjust padding */
    }
    .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important; /* Adjust line height for better text alignment */
    }

    /* Disabled Timeslot */
    a.timeslotdisabled {
        background-color: #e7e7e7 !important;
        color: white !important;
        cursor: not-allowed;
    }

    /* Doctor Profile Section */
    .doctor-profile-section {
        background-color: #f9f9f9;
        padding-top: 80px; /* Assuming you had this in the HTML */
        padding-bottom: 40px; /* Assuming you had this in the HTML */
    }

    .doctor-profile-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    .profile-header {
        display: flex;
        gap: 30px;
        margin-bottom: 25px;
        border-bottom: 1px solid #eee;
        padding-bottom: 25px;
    }

    .profile-header-left {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .profile-header-right {
        flex-basis: 40%;
    }

    .profile-image {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 20px;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .featured-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #ffc107;
        color: #fff;
        padding: 5px;
        border-radius: 4px;
        font-size: 0.8em;
    }

    .profile-info .doctor-name {
        font-size: 1.8em;
        margin-bottom: 5px;
        color: #333;
    }

    .profile-info .verified-icon {
        color: #28a745;
        margin-left: 5px;
        font-size: 0.9em;
    }

    .profile-info .doctor-department {
        display: block;
        color: #6c757d;
        margin-bottom: 8px;
        font-size: 0.95em;
    }

    .profile-info .doctor-department a {
        color: #007bff;
        text-decoration: none;
    }

    .profile-info .doctor-qualification {
        color: #555;
        margin-bottom: 10px;
        font-size: 1em;
    }

    .profile-info .contact-info {
        list-style: none;
        padding: 0;
        margin-bottom: 15px;
    }

    .profile-info .contact-info li {
        margin-bottom: 5px;
        color: #555;
        font-size: 0.95em;
    }

    .profile-info .contact-info li i {
        margin-right: 8px;
        color: rgb(255, 191, 0);
    }

    .profile-info .specializations {
        margin-bottom: 15px;
    }

    .profile-info .specialization-tag {
        display: inline-block;
        background-color: #e9ecef;
        color: #495057;
        padding: 5px 10px;
        border-radius: 4px;
        margin-right: 5px;
        margin-bottom: 5px;
        font-size: 0.9em;
    }

    .profile-info .social-icons {
        list-style: none;
        padding: 0;
        margin-bottom: 15px;
    }

    .profile-info .social-icons li {
        display: inline-block;
        margin-right: 10px;
    }

    .profile-info .social-icons li a {
        color: #007bff;
        font-size: 1.2em;
        text-decoration: none;
    }

    .profile-info .appointment-availability {
        margin-bottom: 15px;
    }

    .profile-info .availability-badge {
        display: inline-block;
        color: #fff;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 0.9em;
    }

    .profile-info .availability-badge.available {
        background-color: #28a745;
    }

    .profile-info .availability-badge.unavailable {
        background-color: #dc3545;
    }

    .profile-info .action-buttons a,
    .profile-info .action-buttons button {
        margin-right: 10px;
        margin-bottom: 5px;
    }

    .profile-details {
        padding-top: 20px;
    }

    .detail-section {
        margin-bottom: 30px;
    }

    .detail-title {
        font-size: 1.5em;
        color: #333;
        margin-bottom: 15px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .about-me-content {
        line-height: 1.6;
        color: #555;
    }

    .about-me-content p {
        margin-bottom: 10px;
    }

    /* Style for the About Me section in the header */
    .profile-header-right .detail-section {
        margin-bottom: 0;
    }

    .profile-header-right .detail-title {
        border-bottom: none;
        margin-bottom: 5px;
        font-size: 1.2em; /* Adjust if needed */
    }

    .timeline {
        list-style: none;
        padding: 0;
    }

    .timeline li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 20px;
    }

    .timeline li:before {
        content: '';
        position: absolute;
        left: 0;
        top: 5px;
        width: 10px;
        height: 10px;
        background-color: #007bff;
        border-radius: 50%;
    }

    .timeline-content {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f8f9fa;
    }

    .timeline-content .institution {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .timeline-content .discipline {
        color: #555;
        margin-bottom: 3px;
        font-size: 0.95em;
    }

    .timeline-content .period {
        color: #777;
        font-size: 0.9em;
    }

    .specialization-list {
        list-style: none;
        padding: 0;
    }

    .specialization-list li {
        margin-bottom: 8px;
        color: #555;
    }

    .specialization-list li i {
        color: #28a745;
        margin-right: 8px;
    }

    /* Interaction Styles - Moved to be closer to relevant selectors */
    .action-buttons a:hover,
    .action-buttons button:hover {
        opacity: 0.9;
    }

    .save-doctor:hover .save-text {
        font-weight: bold;
    }

    .profile-image:hover .featured-badge {
        transform: scale(1.1);
    }

    .social-icons li a:hover {
        opacity: 0.8;
        transform: translateY(-2px);
    }


    </style>
@endpush


