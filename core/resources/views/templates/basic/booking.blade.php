@extends($activeTemplate . 'layouts.frontend')

@section('content')
<section class="doctor-profile-section py-5 bg-light">
    <div class="container">
        <div class="card shadow-sm rounded-3 p-4">
            <div class="row align-items-center">
                {{-- Doctor Image --}}
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    <img src="{{ getImage(getFilePath('doctorProfile') . '/' . $doctor->image, getFileSize('doctorProfile')) }}"
                         alt="{{ __($doctor->name) }}"
                         class="img-fluid rounded-circle border border-primary" style="max-width: 180px;">
                </div>
                {{-- Doctor Basic Info --}}
                <div class="col-md-6">
                    <h2 class="fw-bold">{{ __($doctor->name) }}
                        @if($doctor->verified)
                        <span class="text-success" data-bs-toggle="tooltip" title="@lang('Verified Doctor')">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        @endif
                    </h2>
                    <p class="text-muted fs-5 mb-2">{{ __($doctor->qualification) }}</p>

                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>@lang('Location'):</strong> {{ __($doctor->location->name ?? '-') }}</p>
                    <p><i class="fas fa-phone me-2 text-primary"></i><strong>@lang('Phone'):</strong> <a href="tel:{{ __($doctor->mobile) }}" class="text-decoration-none">{{ __($doctor->mobile) }}</a></p>

                    @if ($doctor->speciality && count($doctor->speciality) > 0)
                    <div>
                        <strong>@lang('Specializations'):</strong><br>
                        @foreach ($doctor->speciality as $item)
                        <span class="badge bg-primary me-1 mb-1">{{ __($item) }}</span>
                        @endforeach
                    </div>
                    @endif

                    {{-- Appointment Badge --}}
                    <div class="mt-3">
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle me-1"></i>@lang('Available for Appointment')
                        </span>
                    </div>
                </div>

                {{-- Social Icons --}}
                <div class="col-md-3 text-center text-md-start mt-3 mt-md-0">
                    @if ($doctor->socialIcons && count($doctor->socialIcons) > 0)
                    <h5 class="mb-3">@lang('Connect')</h5>
                    <div>
                        @foreach ($doctor->socialIcons as $social)
                        <a href="{{ $social->url }}" target="_blank" class="text-primary fs-4 me-3 social-icon" title="{{ $social->name }}">
                            {!! $social->icon !!}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- About Section --}}
            <div class="mt-5">
                <h3 class="mb-3 border-bottom pb-2">@lang('About')</h3>
                @if ($doctor->about)
                <p style="white-space: pre-line;">{!! nl2br(e(__($doctor->about))) !!}</p>
                @else
                <p class="text-muted fst-italic">@lang('Doctor about will be appearing soon')</p>
                @endif
            </div>

            {{-- Education Section --}}
            <div class="mt-4">
                <h3 class="mb-3 border-bottom pb-2">@lang('Education')</h3>
                @if ($doctor->educationDetails && count($doctor->educationDetails) > 0)
                <ul class="list-group list-group-flush">
                    @foreach ($doctor->educationDetails as $education)
                    <li class="list-group-item">
                        <strong>{{ __($education->institution) }}</strong> — {{ __($education->discipline) }}<br>
                        <small class="text-muted">{{ __($education->period) }}</small>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted fst-italic">@lang('Education data will be appearing soon')</p>
                @endif
            </div>

            {{-- Experience Section --}}
            <div class="mt-4">
                <h3 class="mb-3 border-bottom pb-2">@lang('Experience')</h3>
                @if ($doctor->experienceDetails && count($doctor->experienceDetails) > 0)
                <ul class="list-group list-group-flush">
                    @foreach ($doctor->experienceDetails as $experience)
                    <li class="list-group-item">
                        <strong>{{ __($experience->institution) }}</strong> — {{ __($experience->discipline) }}<br>
                        <small class="text-muted">{{ __($experience->period) }}</small>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted fst-italic">@lang('Experience data will be appearing soon')</p>
                @endif
            </div>

           
        </div>
    </div>
</section>

@push('style')
<style>
    .social-icon:hover {
        color: #0d6efd !important;
        transform: scale(1.2);
        transition: transform 0.3s ease, color 0.3s ease;
    }
</style>
@endpush

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush

@endsection
