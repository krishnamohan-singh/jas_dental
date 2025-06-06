@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-6 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Deposit Via') {{ __(@$deposit->gateway->name) }}</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Date')
                            <span class="fw-bold">{{ showDateTime($deposit->created_at) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Transaction Number')
                            <span class="fw-bold">{{ $deposit->trx }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Method')
                            <span class="fw-bold">{{ __(@$deposit->gateway->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Amount')
                            <span class="fw-bold">{{ showAmount($deposit->amount) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Charge')
                            <span class="fw-bold">{{ showAmount($deposit->charge) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('After Charge')
                            <span class="fw-bold">{{ showAmount($deposit->amount + $deposit->charge) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Rate')
                            <span class="fw-bold">1 {{ __(gs('cur_text')) }}
                                = {{ showAmount($deposit->rate) }} {{ __($deposit->baseCurrency()) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Patient Payable ')
                            <span class="fw-bold">{{ showAmount($deposit->final_amo) }}
                                {{ __($deposit->method_currency) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @php echo $deposit->statusBadge @endphp
                        </li>
                        @if ($deposit->admin_feedback)
                            <li class="list-group-item">
                                <strong>@lang('Admin Response')</strong>
                                <br>
                                <p>{{ __($deposit->admin_feedback) }}</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Appointment Details')</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Patient Name')
                            <span class="fw-bold">{{ __(@$deposit->appointment->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span class="fw-bold">{{ @$deposit->appointment->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Mobile No')
                            <span class="fw-bold">{{ @$deposit->appointment->mobile }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Age')
                            <span class="fw-bold">{{ @$deposit->appointment->age }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Doctor')
                            <span class="fw-bold">
                                <a
                                    href="{{ route('admin.doctor.detail', $deposit->doctor_id) }}">{{ @$deposit->doctor->name }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Preferred Date')
                            <span class="fw-bold">{{ showDateTime(@$deposit->appointment->booking_date, 'Y-m-d') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Preferred Time or Serial')
                            <span class="fw-bold">{{ @$deposit->appointment->time_serial }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Added By')
                            <span class="fw-bold">
                                @if (@$deposit->appointment->added_staff_id)
                                    <a
                                        href="{{ route('admin.staff.detail', $deposit->appointment->staff->id) }}">{{ __(@$deposit->appointment->staff->name) }}</a>
                                    <br> <span class="text--small badge badge--primary">@lang('Staff')</span>
                                @elseif(@$deposit->appointment->added_assistant_id)
                                    <a href="{{ route('admin.assistant.detail', $deposit->appointment->assistant->id) }}">
                                        {{ __(@$deposit->appointment->assistant->name) }}</a>
                                    <br> <span class="text--small badge badge--dark">@lang('Assistant')</span>
                                @elseif(@$deposit->appointment->added_doctor_id)
                                    <a href="{{ route('admin.doctor.detail', $deposit->appointment->doctor->id) }}">
                                        {{ __(@$deposit->appointment->doctor->name) }}</a>
                                    <br> <span class="text--small badge badge--success">@lang('Doctor')</span>
                                @elseif(@$deposit->appointment->added_admin_id)
                                    <span class="text--small badge badge--primary">@lang('Admin')</span>
                                @elseif(@$deposit->appointment->site)
                                    <span class="text--small badge badge--info">@lang('Site')</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item">
                            @lang('Disease')
                            <br>
                            <p>{{ __(@$deposit->appointment->disease) }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if ($details || $deposit->status == Status::PAYMENT_PENDING)
        <div class="row mb-none-30 justify-content-center">
            <div class="col-xl-12 col-md-12 mt-30">
                <div class="card b-radius--10 overflow-hidden box--shadow1">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">@lang('Payment Information')</h5>
                        @if ($details != null)
                            @foreach (json_decode($details) as $val)
                                @if ($deposit->method_code >= 1000)
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h6>{{ __($val->name) }}</h6>
                                            @if ($val->type == 'checkbox')
                                                {{ implode(',', $val->value) }}
                                            @elseif($val->type == 'file')
                                                @if ($val->value)
                                                    <a href="{{ route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}"
                                                        class="me-3"><i class="fa fa-file"></i> @lang('Attachment') </a>
                                                @else
                                                    @lang('No File')
                                                @endif
                                            @else
                                                <p>{{ __($val->value) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if ($deposit->method_code < 1000)
                                @include('admin.deposit.gateway_data', [
                                    'details' => json_decode($details),
                                ])
                            @endif
                        @endif
                        @if ($deposit->status == Status::PAYMENT_PENDING)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button class="btn btn-outline--success btn-sm ms-1 confirmationBtn"
                                        data-action="{{ route('admin.deposit.approve', $deposit->id) }}"
                                        data-question="@lang('Are you sure to approve this payment?')"><i class="las la-check"></i>
                                        @lang('Approve')
                                    </button>


                                    <button class="btn btn-outline--danger btn-sm ms-1" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal"><i class="las la-ban"></i> @lang('Reject')
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Deposit Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.deposit.reject') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $deposit->id }}">
                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span class="fw-bold">@lang('reject')</span> <span
                                class="fw-bold text--success">{{ showAmount($deposit->amount) }}</span> @lang('deposit of')
                            <span class="fw-bold">{{ @$deposit->user->username }}</span>?</p>

                        <div class="form-group">
                            <label class="mt-2">@lang('Reason for Rejection')</label>
                            <textarea name="message" maxlength="255" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.find('.withdraw-user').text($(this).data('username'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
