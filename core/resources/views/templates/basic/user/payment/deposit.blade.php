@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container ptb-80">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <form action="{{ route('deposit.insert') }}" method="post" class="deposit-form">
                    @csrf
                    <input type="hidden" name="currency">
                    <input type="hidden" name="trx" value="{{ $trx }}">
                    <input type="hidden" name="clinic_id" value="{{ $clinicId }}">
                    <div class="gateway-card">
                        <div class="row justify-content-center gy-sm-4 gy-3">
                            <div class="col-lg-6">
                                <div class="payment-system-list is-scrollable gateway-option-list">
                                    @foreach ($gatewayCurrency as $data)
                                        <label for="{{ titleToKey($data->name) }}"
                                            class="payment-item @if ($loop->index > 4) d-none @endif gateway-option">
                                            <div class="payment-item__info">
                                                <span class="payment-item__check"></span>
                                                <span class="payment-item__name">{{ __($data->name) }}</span>
                                            </div>
                                            <div class="payment-item__thumb">
                                                <img class="payment-item__thumb-img"
                                                    src="{{ getImage(getFilePath('gateway') . '/' . $data->method->image) }}"
                                                    alt="@lang('payment-thumb')">
                                            </div>
                                            <input class="payment-item__radio gateway-input"
                                                id="{{ titleToKey($data->name) }}" hidden
                                                data-gateway='@json($data)' type="radio" name="gateway"
                                                value="{{ $data->method_code }}"
                                                @if (old('gateway')) @checked(old('gateway') == $data->method_code) @else @checked($loop->first) @endif
                                                data-min-amount="{{ showAmount($data->min_amount) }}"
                                                data-max-amount="{{ showAmount($data->max_amount) }}">
                                        </label>
                                    @endforeach
                                    @if ($gatewayCurrency->count() > 4)
                                        <button type="button" class="payment-item__btn more-gateway-option">
                                            <p class="payment-item__btn-text">@lang('Show All Payment Options')</p>
                                            <span class="payment-item__btn__icon"><i class="fas fa-chevron-down"></i></span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="payment-system-list p-3">
                                    <div class="deposit-info">
                                        <div class="deposit-info__title">
                                            <p class="text mb-0">@lang('Amount')</p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <div class="deposit-info__input-group input-group">
                                                <span class="deposit-info__input-group-text">{{ gs('cur_sym') }}</span>
                                                <input type="text" class="form-control form--control amount"
                                                    name="amount" placeholder="@lang('00.00')"
                                                    value="{{ $fees }}" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="deposit-info">
                                        <div class="deposit-info__title">
                                            <p class="text has-icon"> @lang('Limit')
                                                <span></span>
                                            </p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <p class="text"><span class="gateway-limit">@lang('0.00')</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="deposit-info">
                                        <div class="deposit-info__title">
                                            <p class="text has-icon">@lang('Processing Charge')
                                                <span data-bs-toggle="tooltip" title="@lang('Processing charge for payment gateways')"
                                                    class="proccessing-fee-info"><i class="las la-info-circle"></i> </span>
                                            </p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <p class="text"><span class="processing-fee">@lang('0.00')</span>
                                                {{ __(gs('cur_text')) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="deposit-info total-amount pt-3">
                                        <div class="deposit-info__title">
                                            <p class="text">@lang('Total')</p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <p class="text"><span class="final-amount">@lang('0.00')</span>
                                                {{ __(gs('cur_text')) }}</p>
                                        </div>
                                    </div>

                                    <div class="deposit-info gateway-conversion d-none total-amount pt-2">
                                        <div class="deposit-info__title">
                                            <p class="text">@lang('Conversion')
                                            </p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <p class="text"></p>
                                        </div>
                                    </div>
                                    <div class="deposit-info conversion-currency d-none total-amount pt-2">
                                        <div class="deposit-info__title">
                                            <p class="text">
                                                @lang('In') <span class="gateway-currency"></span>
                                            </p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <p class="text">
                                                <span class="in-currency"></span>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="d-none crypto-message mb-3">
                                        @lang('Conversion with') <span class="gateway-currency"></span> @lang('and final value will Show on next step')
                                    </div>
                                    <button type="submit" class="cmn-btn w-100">
                                        @lang('Confirm Deposit')
                                    </button>
                                    <div class="info-text pt-3">
                                        <p class="text">@lang('Ensuring your funds grow safely through our secure deposit process with world-class payment options.')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .deposit-info__input-group-text {
            align-self: center;
            padding: 0px 10px;
        }

        hr {
            color: #c7c7c7;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            var amount = parseFloat($('.amount').val() || 0);
            var gateway, minAmount, maxAmount;

            // Error handling wrapper
            function safeExecute(fn) {
                try {
                    return fn();
                } catch (error) {
                    console.error('Error in deposit form:', error);
                    return false;
                }
            }

            $('.amount').on('input', function(e) {
                safeExecute(function() {
                    amount = parseFloat($(e.target).val());
                    if (!amount || isNaN(amount)) {
                        amount = 0;
                    }
                    calculation();
                });
            });

            $('.gateway-input').on('change', function(e) {
                safeExecute(function() {
                    gatewayChange();
                });
            });

            function gatewayChange() {
                let gatewayElement = $('.gateway-input:checked');
                if (gatewayElement.length === 0) {
                    console.warn('No gateway selected');
                    return;
                }

                let methodCode = gatewayElement.val();
                gateway = gatewayElement.data('gateway');
                
                if (!gateway) {
                    console.warn('Gateway data not found');
                    return;
                }

                minAmount = parseFloat(gatewayElement.data('min-amount')) || 0;
                maxAmount = parseFloat(gatewayElement.data('max-amount')) || 0;

                // Safe property access with fallbacks
                let percentCharge = parseFloat(gateway.percent_charge || 0).toFixed(2);
                let fixedCharge = parseFloat(gateway.fixed_charge || 0).toFixed(2);
                let currencyText = '{{ __(gs("cur_text")) }}';
                
                let processingFeeInfo = `${percentCharge}% with ${fixedCharge} ${currencyText} charge for payment gateway processing fees`;
                
                let feeInfoElement = $(".proccessing-fee-info");
                if (feeInfoElement.length > 0) {
                    feeInfoElement.attr("data-bs-original-title", processingFeeInfo);
                }
                
                calculation();
            }

            $(".more-gateway-option").on("click", function(e) {
                safeExecute(function() {
                    let paymentList = $(".gateway-option-list");
                    paymentList.find(".gateway-option").removeClass("d-none");
                    $(e.target).closest('.more-gateway-option').addClass('d-none');
                    paymentList.animate({
                        scrollTop: (paymentList.height() - 60)
                    }, 'slow');
                });
            });

            function calculation() {
                if (!gateway) {
                    console.warn('Gateway not initialized');
                    return;
                }

                // Safe property access with fallbacks
                let displayMinAmount = parseFloat(minAmount || 0).toFixed(2);
                let displayMaxAmount = parseFloat(maxAmount || 0).toFixed(2);
                $(".gateway-limit").text(displayMinAmount + " - " + displayMaxAmount);

                let percentCharge = 0;
                let fixedCharge = 0;
                let totalPercentCharge = 0;

                if (amount && amount > 0) {
                    percentCharge = parseFloat(gateway.percent_charge || 0);
                    fixedCharge = parseFloat(gateway.fixed_charge || 0);
                    totalPercentCharge = parseFloat(amount / 100 * percentCharge);
                }

                let totalCharge = parseFloat(totalPercentCharge + fixedCharge);
                let totalAmount = parseFloat((amount || 0) + totalPercentCharge + fixedCharge);

                $(".final-amount").text(totalAmount.toFixed(2));
                $(".processing-fee").text(totalCharge.toFixed(2));
                
                // Safe currency setting
                let currencyInput = $("input[name=currency]");
                if (currencyInput.length > 0 && gateway.currency) {
                    currencyInput.val(gateway.currency);
                }
                
                $(".gateway-currency").text(gateway.currency || '');

                // Enable/disable submit button based on amount limits
                let submitButton = $(".deposit-form button[type=submit]");
                if (amount < Number(minAmount) || amount > Number(maxAmount)) {
                    submitButton.attr('disabled', true);
                } else {
                    submitButton.removeAttr('disabled');
                }

                // Currency conversion handling
                let currentCurrency = '{{ gs("cur_text") }}';
                let gatewayCurrency = gateway.currency || '';
                let isCrypto = gateway.method && gateway.method.crypto == 1;

                if (gatewayCurrency !== currentCurrency && !isCrypto) {
                    $('.deposit-form').addClass('adjust-height');
                    $(".gateway-conversion, .conversion-currency").removeClass('d-none');
                    
                    let rate = parseFloat(gateway.rate || 1).toFixed(2);
                    $(".gateway-conversion").find('.deposit-info__input .text').html(
                        `1 ${currentCurrency} = <span class="rate">${rate}</span> <span class="method_currency">${gatewayCurrency}</span>`
                    );
                    
                    let convertedAmount = parseFloat(totalAmount * (gateway.rate || 1));
                    let decimalPlaces = isCrypto ? 8 : 2;
                    $('.in-currency').text(convertedAmount.toFixed(decimalPlaces));
                } else {
                    $(".gateway-conversion, .conversion-currency").addClass('d-none');
                    $('.deposit-form').removeClass('adjust-height');
                }

                // Crypto message handling
                if (isCrypto) {
                    $('.crypto-message').removeClass('d-none');
                } else {
                    $('.crypto-message').addClass('d-none');
                }
            }

            // Initialize tooltips safely
            safeExecute(function() {
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            });

            // Initialize the form
            safeExecute(function() {
                gatewayChange();
            });

        })(jQuery);
    </script>
@endpush