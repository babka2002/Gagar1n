<!doctype html>
<html lang="@antlers{{ site:short_locale }}@endantlers">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="view-transition" content="same-origin">
        @antlers
            {{ icon | favicon }}
        @endantlers
        <title>
            @if(isset($title))
                {{ $title }}
            @else
                @antlers
                    {{ title or site:name }}
                @endantlers
            @endif
        </title>

        @vite(['resources/css/site.css', 'resources/js/site.js'])
    </head>
    <body class="bg-[#4CAF50]">
        <!-- START::HEADER -->
        <div class="container px-[1em] my-5 sticky top-4 z-20">
            <header class="container bg-light flex justify-between items-center gap-2 rounded-[30px] px-[20px] py-[14px] ">
            <div class="flex items-center justify-center gap-[34px] relative ">
                <button aria-label="menu button" class="menu-toggle rounded-full bg-dark text-light flex items-center justify-center w-[3.75em] h-[3.75em] relative z-10"><svg
                    width="34" height="22" viewBox="0 0 34 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 2H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                    <path d="M2 11H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                    <path d="M2 20H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                </svg>
                </button>

                <a href="/" class="p-0 m-0 relative z-10 hidden md:block transition-all">
                    @if(isset($site_settings['main_logo']) && $site_settings['main_logo'])
                        <img src="{{ $site_settings['main_logo'] }}" alt="" class="max-w-[13.625em]">
                    @else
                        <img src="/assets/img/dzhifud-logo.png" alt="" class="max-w-[13.625em]">
                    @endif
                </a>

                @antlers
                {{-- {{ partial:gfoodcafe/_nav }} --}}
                @endantlers

            </div>

            <div class="flex items-center justify-between gap-2 relative z-10">
                {{-- Grelka - основной сайт --}}
                <s:get_site:Grelka>
                    <a href="{{ $permalink }}"
                       class="w-[52px] md:w-[4.4375em] {{ $site->handle === 'Grelka' ? 'grayscale-0' : 'grayscale-[1] hover:grayscale-0' }} transition-all">
                        <img
                            src="<s:glide:data_url src='/assets/img/grelka-logo.png' quality='75' format='webp' />"
                            alt="{{ $name }}"
                            class="block hover:opacity-70 transition-all"
                        >
                    </a>
                </s:get_site:Grelka>

                {{-- Junior --}}
                <s:get_site:Gun1or>
                    <a href="{{ $permalink }}"
                       class="w-[52px] md:w-[4.4375em] {{ $site->handle === 'Gun1or' ? 'grayscale-0' : 'grayscale-[1] hover:grayscale-0' }} transition-all">
                        <img
                            src="<s:glide:data_url src='/assets/img/logo-dzhunior.png' quality='75' format='webp' />"
                            alt="{{ $name }}"
                            class="block hover:opacity-70 transition-all"
                        >
                    </a>
                </s:get_site:Gun1or>

                {{-- GFood Cafe --}}
                <s:get_site:GFoodcafe>
                    <a href="#"
                       class="w-[52px] md:w-[4.4375em] {{ $site->handle === 'GFoodcafe' ? 'grayscale-0' : 'grayscale-[1] hover:grayscale-0' }} transition-all">
                        <img
                            src="<s:glide:data_url src='/assets/img/dzhifud-logo.png' quality='75' format='webp' />"
                            alt="{{ $name }}"
                            class="block hover:opacity-70 transition-all"
                        >
                    </a>
                </s:get_site:GFoodcafe>
            </div>

            <div class="flex items-center justify-center">
                <p class="text-black font-normal [font-size:_clamp(1rem,0.9228rem+0.3861vw,1.25rem)] hidden lg:block mr-5"> г.
                Симферополь <br> ул.
                Киевская, 115</p>
                <a
                    href="#"
                    data-dialog="dialog"
                    aria-label="call button"
                    class="show flex items-center justify-center px-[10px] py-[19px] rounded-[30px] text-[20px] text-light hover:opacity-70 transition-all hidden lg:block"
                    style="background-color: {{ $site_settings['primary_color'] ?? '#10B981' }}">
                    записаться
                </a>
                <a
                    href="#"
                    data-dialog="dialog"
                    class="show flex items-center justify-center"
                >
                    <img
                    src="<s:glide:data_url src='/assets/img/phone.png' quality='75' format='webp' />"
                    alt=""
                    class="min-w-[52px] h-[52px] flex-1 lg:hidden">
                </a>
            </div>
            </header>
        </div>
        <!-- END::HEADER -->

        @antlers
        {{ template_content }}
        @endantlers

        <!-- START::FOOTER -->
        <footer class="bg-light py-10 md:py-24 px-4">
            <div class="container sm:grid sm:grid-cols-4 md:grid-cols-5 items-center gap-12 bg-dark rounded-[clamp(3rem,2.3449rem+2.9116vw,4.8125rem)] px-[clamp(2.375rem,1.7877rem+2.6104vw,4rem)] py-10">

                <!-- Логотип -->
                <a href="/" class="sm:col-span-4 md:col-span-1 flex justify-center items-center">
                    @if(isset($site_settings['footer_logo']) && $site_settings['footer_logo'])
                        <img src="{{ $site_settings['footer_logo'] }}" alt="GFoodcafe" class="max-w-full block">
                    @elseif(isset($footer->footer_logo) && $footer->footer_logo)
                        <img src="{{ $footer->footer_logo }}" alt="GFoodcafe" class="max-w-full block">
                    @else
                        <img src="/assets/img/dzhifud-logo.png" alt="GFoodcafe" class="max-w-full block">
                    @endif
                </a>

                <!-- Меню футера -->
                <ul class="col-span-2">
                    @foreach($footer->footer_menu as $menuItem)
                        <li>
                            <a href="{{ $menuItem->link }}"
                            class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">
                                {{ $menuItem->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Контактная информация -->
                <ul class="col-span-2">
                    <!-- Телефон -->
                    <li class="text-light [font-size:_clamp(1.125rem,0.7775rem+1.7375vw,2.25rem)] font-normal leading-5 text-right mb-3">
                        <a href="tel:{{ $footer->phone_number }}">{{ $footer->phone_number }}</a>
                    </li>

                    <!-- Часы работы -->
                    <li>
                        <span class="block text-light text-right [font-size:_clamp(0.625rem,0.4706rem+0.7722vw,1.125rem)]">
                            {{ $footer->work_hours_weekdays }}
                        </span>
                        <span class="block text-light text-right [font-size:_clamp(0.625rem,0.4706rem+0.7722vw,1.125rem)]">
                            {{ $footer->work_hours_weekends }}
                        </span>
                    </li>

                    <!-- Социальные сети -->
                    <li class="flex items-center justify-end mb-4">
                        @if($footer->telegram_link)
                            <a href="{{ $footer->telegram_link }}" class="hover:opacity-70 transition-all" target="_blank" rel="noopener noreferrer">
                                <img src="/assets/img/telegram_button_light.svg" alt="Telegram" class="max-w-[3.3125em]">
                            </a>
                        @endif

                        @if($footer->vk_link)
                            <a href="{{ $footer->vk_link }}" class="hover:opacity-70 transition-all" target="_blank" rel="noopener noreferrer">
                                <img src="/assets/img/vk_button_light.svg" alt="VK" class="max-w-[3.3125em]">
                            </a>
                        @endif
                    </li>

                    <!-- Мобильное приложение -->
                    <li>
                        <p class="[font-size:_clamp(0.625rem,0.5092rem+0.5792vw,1rem)] text-light font-normal text-right">
                            {{ $footer->mobile_app_text ?? 'наше мобильное приложение' }}
                        </p>
                    </li>

                    <!-- Кнопки магазинов приложений -->
                    <li class="flex items-center justify-end gap-4 py-4">
                        @if($footer->app_store_link)
                            <a href="{{ $footer->app_store_link }}"
                            class="border border-light rounded-[64px] h-16 px-4 py-2 text-light"
                            target="_blank"
                            rel="noopener noreferrer">
                                App Store
                            </a>
                        @endif

                        @if($footer->google_play_link)
                            <a href="{{ $footer->google_play_link }}"
                            class="border border-light rounded-[64px] h-16 px-4 py-2 text-light"
                            target="_blank"
                            rel="noopener noreferrer">
                                Google Play
                            </a>
                        @endif
                    </li>

                    <!-- Рейтинг Яндекс -->
                    <li class="flex justify-end items-center gap-5">
                        <button>
                            <img src="/assets/img/yandex_button.svg" alt="Яндекс">
                        </button>
                        <p class="text-light [font-size:_clamp(0.5rem,0.3649rem+0.6757vw,0.9375rem)] font-normal">
                            наш рейтинг<br>на Яндекс
                        </p>
                        <p class="[font-size:_clamp(1.3125rem,0.9457rem+1.834vw,2.5rem)] text-light font-normal">
                            {{ $footer->yandex_rating ?? '4.9' }}
                        </p>
                    </li>
                </ul>

            </div>
        </footer>
        <!-- END::FOOTER -->

        <!-- Popup dialogs будут добавлены позже -->
    </body>
</html>
