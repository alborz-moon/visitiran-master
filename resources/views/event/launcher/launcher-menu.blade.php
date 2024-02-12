<?php $isLauncher = Auth::check() && Auth::user()->isLauncher(); ?>
<div class="{{ isset($desktopMenu) && $desktopMenu ? 'col-12' : 'col-xl-3 col-lg-3 col-md-4' }}  mb-md-0 mb-3 zIndex0">
    <div class="ui-sticky ui-sticky-top StickyMenuMoveOnTop">
        <div
            class="profile-user-info py-3 ui-box bg-white {{ isset($desktopMenu) && $desktopMenu == 'true' ? 'p-0 boxShadowNone' : '' }} ">
            <div class="profile-detail">
                <div class="d-flex align-items-center">
                    <div class="profile-avatar me-3"><img src="./theme-assets/images/avatar/default.png" alt="avatar">
                    </div>
                    <div class="profile-info">
                        <a
                            class="text-decoration-none text-dark fw-bold mb-2">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</a>
                        <div class="text-muted fw-bold bold">{{ Auth::user()->phone }}</div>
                    </div>
                </div>
                @if ($isLauncher)
                    <div class="user-options">
                        <ul>
                            <li class="d-block">
                                <div class="label fontSize14 colorBlack whiteSpaceNoWrap">تعداد رویدادها</div>
                                <div class="colorBlue text-align-end mr-90">
                                    {{ request()->user()->events()->count() }} رویداد
                                </div>
                            </li>
                            <li class="d-block">
                                <div class="label fontSize14 colorBlack whiteSpaceNoWrap">مبلغ تسویه نشده</div>
                                <div class="colorBlue text-align-end mr-90">
                                    50000000 <span class="colorYellow">ت</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>
            <ul class="nav nav-items-with-icon flex-column"
                style="border-bottom: 1px solid #dedede;padding-bottom: 15px;">
                @if ($isLauncher)
                    <li class="nav-item simpleProducer">
                        <a role="button" class="nav-link whiteSpaceNoWrap textColor"><i
                                class="nav-link-icon ri-user-line"></i>
                            بازگشت به پروفایل عادی
                        </a>
                    </li>
                @else
                    <li class="nav-item goLauncher">
                        <a href="{{ route('launcher') }}" role="button" class="nav-link whiteSpaceNoWrap textColor"><i
                                class="nav-link-icon ri-user-line"></i>
                            ارتقا به برگزار کننده
                        </a>
                    </li>
                @endif
                <li class="nav-item hidden launcherProducer">
                    <a role="button" class="nav-link whiteSpaceNoWrap textColor"><i
                            class="nav-link-icon ri-user-line"></i>
                        رفتن به پروفایل برگزار کننده
                    </a>
                </li>
            </ul>
            @if ($isLauncher)
                <ul class="nav nav-items-with-icon flex-column launcherProfileHidden">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('create-event') }}"><i
                                class="nav-link-icon ri-file-list-3-line"></i>
                            ایجاد رویداد
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('show-events') }}"><i
                                class="nav-link-icon ri-heart-3-line"></i>
                            رویدادهای من
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('report') }}"><i
                                class="nav-link-icon ri-notification-line"></i>
                            گزارشات مالی
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('launcher-bank') }}"><i
                                class="nav-link-icon ri-user-line"></i>
                            اطلاعات
                            حساب</a>
                    </li>
                    {{-- متصل شود با آیدی launcher-register --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('launcher') }}"><i class="nav-link-icon ri-user-line"></i>
                            اطلاعات برگزار کننده
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <i class="nav-link-icon ri-logout-box-r-line"></i>
                            خروج
                        </a>
                    </li>
                </ul>
            @endif
            <ul class="nav nav-items-with-icon flex-column {{ $isLauncher ? 'hidden' : '' }} simpleProfileHidden">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('my-events') }}">
                        <i class="nav-link-icon ri-file-list-3-line"></i>
                        بلیت های من
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.my-transaction') }}"><i
                            class="nav-link-icon ri-notification-line"></i>
                        تراکنش های من
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile-favorites-event') }}"><i
                            class="nav-link-icon ri-heart-3-line"></i>
                        علاقه مندی ها
                    </a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.offcode') }}"><i
                            class="nav-link-icon ri-price-tag-3-line"></i>
                            تخفیف ها
                        </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.comments') }}"><i
                            class="nav-link-icon ri-chat-1-line"></i>
                        نظرات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.my-tickets') }}"><i
                            class="nav-link-icon ri-notification-line"></i>
                        پشتیبانی
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"><i class="nav-link-icon ri-logout-box-r-line"></i>
                        خروج
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#goLauncher').removeClass('hidden').on('click', function() {
            window.location.href = "{{ route('launcher') }}";
        });

        $('.launcherProducer').on('click', function() {
            $('.simpleProfileHidden').addClass('hidden');
            $('.launcherProfileHidden').removeClass('hidden');
            $('.simpleProducer').removeClass('hidden');
            $('.launcherProducer').addClass('hidden');
        });

        $('.simpleProducer').on('click', function() {
            $('.launcherProducer').removeClass('hidden');
            $('.simpleProducer').addClass('hidden');
            $('.simpleProfileHidden').removeClass('hidden');
            $('.launcherProfileHidden').addClass('hidden');
        });
    });
</script>
