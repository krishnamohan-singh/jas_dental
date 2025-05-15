<!-- <div class="bg- text-white py-2 top">-->
    <!--<div class="container d-flex justify-content-between align-items-center">-->
        <!-- Left Logos -->
        <!--<div class="d-flex align-items-center social">-->
            <!--<img src="{{asset('assets/images/new/facebook.png')}}" alt="Logo 1" class="me-3" >-->
                <!--<img src="{{asset('assets/images/new/insta.png')}}" alt="Logo 2" class="me-3" >-->
                    <!--<img src="{{asset('assets/images/new/linkedIn.png')}}" alt="Logo 3" >-->
        <!--</div>-->

        <!-- Right Information -->
        <!--<div class="d-flex align-items-center">-->
            <!--<div class="me-4 d-flex align-items-center phone">-->
                <!--<img src="{{asset('assets/images/new/PhoneCall.png')}}" alt="Phone Icon" class="me-2" >-->
                    <!--<span>+91 8217216397</span>-->
                        <!--</div>-->
                            <!--<div class="d-flex align-items-center add">-->
            <!--<img src="{{asset('assets/images/new/MapLocation.png')}}" alt="Address Icon" class="me-2">-->
            <!--<span>36th Main Road, KAS Officers Colony, BTM 2nd Stage, Bengaluru,
              Karnataka-560068.</span>-->
              <!--</div>-->
              <!--</div>-->
              <!--</div>-->
              <!--</div> -->

<header class="header-section header-section-two">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo('dark') }}"
                                alt="logo"></a>
                        <div class="d-flex gap-2 d-lg-none">
                            @if (gs('multi_language'))
                                @php
                                    $language = App\Models\Language::all();

                                    $defaultLanguage = App\Models\Language::where(
                                        'code',
                                        config('app.locale'),
                                    )->first();
                                @endphp
                                <div class="custom--dropdown">
                                    <div class="custom--dropdown__selected dropdown-list__item">
                                        <div class="thumb"> <img class="flag" alt="img"
                                                src="{{ getImage(getFilePath('language') . '/' . @$defaultLanguage->image) }}">
                                        </div>
                                        <span class="text">{{ __(strtoupper($defaultLanguage->code)) }}</span>
                                    </div>
                                    <ul class="dropdown-list">
                                        @foreach ($language as $lang)
                                            <li class="dropdown-list__item langSel" data-value="en">
                                                <div class="thumb"> <img class="flag" alt="img"
                                                        src="{{ getImage(getFilePath('language') . '/' . @$lang->image) }}">
                                                </div>
                                                <span class="text">{{ __(strtoupper($lang->code)) }}</span>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            @endif

                            <button class="navbar-toggler ml-auto collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <i class="las la-bars"></i>
                            </button>
                        </div>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu mx-auto justify-content-center">
                                <li class="{{ menuActive('home') }}"><a href="{{ route('home') }}">@lang('Home')</a>
                                </li>
                                <li class="{{ menuActive(['doctors.all']) }}"><a
                                        href="{{ route('clinics.index') }}">@lang('Our Clinics')</a></li>

                                @php
                                    $pages = App\Models\Page::where('tempname', $activeTemplate)
                                        ->where('is_default', 0)
                                        ->get();
                                @endphp
                                @foreach ($pages as $k => $data)
                                    @php $isActive = route('pages', [$data->slug]) == request()->url(); @endphp
                                    <li class="@if ($isActive) active @endif"><a
                                            href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                                @endforeach

                                <li class="{{ menuActive(['blogs', 'blog.details']) }}"><a
                                        href="{{ route('blogs') }}">@lang('Blogs')</a>
                                </li>
                                <li class="{{ menuActive('contact') }}"><a
                                        href="{{ route('contact') }}">@lang('Contact')</a>
                                </li>
                            </ul>
                            @if (gs('multi_language'))
                                @php
                                    $language = App\Models\Language::all();
                                    $defaultLanguage = App\Models\Language::where(
                                        'code',
                                        config('app.locale'),
                                    )->first();
                                @endphp

                                <div class="custom--dropdown d-none d-lg-block">
                                    <div class="custom--dropdown__selected dropdown-list__item">
                                        <div class="thumb"> <img class="flag" alt="img"
                                                src="{{ getImage(getFilePath('language') . '/' . @$defaultLanguage->image) }}">
                                        </div>
                                        <span class="text">{{ __(strtoupper($defaultLanguage->code)) }}</span>
                                    </div>
                                    <ul class="dropdown-list">
                                        @foreach ($language as $item)
                                            <a class="dropdown-list__item" href="{{ route('lang', @$item->code) }}">
                                                <li class="d-flex" data-value="en">
                                                    <div class="thumb"> <img class="flag" alt="img"
                                                            src="{{ getImage(getFilePath('language') . '/' . @$item->image) }}">
                                                    </div>
                                                    <span class="text">{{ __(strtoupper($item->code)) }}</span>
                                                </li>
                                            </a>
                                        @endforeach

                                    </ul>
                                </div>

                            @endif
                            <div class="header-bottom-action">
                                <a href="{{ route('doctors.all') }}" class="cmn-btn">@lang('Book an Appoinment')</a>
                            </div>
                            <!--<div class="header-bottom-action">
                                <a href="{{ route('login') }}" class="cmn-btn">@lang('Login')</a>
                            </div> -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-section end -->
