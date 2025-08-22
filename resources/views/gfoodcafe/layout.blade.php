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
            @antlers
                {{ seo_title or title or site:name }}
            @endantlers
        </title>

        @vite(['resources/css/site.css', 'resources/js/site.js'])
    </head>
    <body class="bg-[#4CAF50]">
        <!-- START::HEADER -->
        <div class="container px-[1em] my-5 sticky top-4 z-20">
            <header class="container bg-[#3d3d3d] grid grid-cols-3 md:flex md:justify-between items-center gap-2 rounded-[30px] px-[20px] py-[14px] ">
            <!-- Мобильная версия: кнопка меню слева -->
            <div class="flex items-center justify-start md:justify-center md:gap-[34px] relative">
                <button aria-label="menu button" class="menu-toggle rounded-full bg-dark text-light flex items-center justify-center w-[3.75em] h-[3.75em] relative z-10"><svg
                    width="34" height="22" viewBox="0 0 34 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 2H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                    <path d="M2 11H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                    <path d="M2 20H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                </svg>
                </button>

                <!-- Логотип на десктопе -->
                <a href="/" class="hidden md:block p-0 m-0 relative z-10 transition-all">
                    @if(isset($site_settings['main_logo']) && $site_settings['main_logo'])
                        <img src="{{ $site_settings['main_logo'] }}" alt="" class="max-w-[4.5em] lg:max-w-[5.5em]">
                    @else
                        <img src="/assets/img/dzhifud-logo.png" alt="" class="max-w-[4.5em] lg:max-w-[5.5em]">
                    @endif
                </a>

                @antlers
                {{-- {{ partial:gfoodcafe/_nav }} --}}
                @endantlers
            </div>

            <!-- Логотип по центру на мобильных -->
            <div class="flex items-center justify-center md:hidden">
                <a href="/" class="p-0 m-0 relative z-10 block transition-all">
                    @if(isset($site_settings['main_logo']) && $site_settings['main_logo'])
                        <img src="{{ $site_settings['main_logo'] }}" alt="" class="max-w-[4.5em]">
                    @else
                        <img src="/assets/img/dzhifud-logo.png" alt="" class="max-w-[4.5em]">
                    @endif
                </a>
            </div>

            <div class="hidden md:flex items-center justify-between gap-6 relative z-10">
                {{-- Grelka - внешняя ссылка --}}
                <a href="https://grelkaspa.ru"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-[52px] md:w-[6em] lg:w-[7em] grayscale-[1] hover:grayscale-0 transition-all">
                    <img
                        src="<s:glide:data_url src='/assets/img/new_logo_grelka.png' quality='75' format='webp' />"
                        alt="Grelka"
                        class="block opacity-70 hover:opacity-100 transition-all"
                    >
                </a>

                {{-- G1unior --}}
                <a href="/gun1or/"
                   class="w-[52px] md:w-[6em] lg:w-[7em] grayscale-[1] hover:grayscale-0 transition-all">
                    <img
                        src="<s:glide:data_url src='/assets/img/new_logo_gunior.png' quality='75' format='webp' />"
                        alt="G1unior"
                        class="block opacity-70 hover:opacity-100 transition-all"
                    >
                </a>

                {{-- Gagarin - главный сайт (активный) --}}
                <a href="/"
                   class="w-[52px] md:w-[6em] lg:w-[7em] grayscale-0 transition-all">
                    <img
                        src="<s:glide:data_url src='/assets/img/new_logo_gfood.png' quality='75' format='webp' />"
                        alt="Gagarin"
                        class="block opacity-100 transition-all"
                    >
                </a>
            </div>

            <div class="flex items-center justify-end">
                <p class="text-white font-normal [font-size:_clamp(1rem,0.9228rem+0.3861vw,1.25rem)] hidden lg:block mr-5"> г.
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
                    class="show flex items-center justify-center bg-[#d9262e] rounded-full hover:opacity-80 transition-all lg:hidden"
                >
                    <img
                    src="<s:glide:data_url src='/assets/img/phone.png' quality='75' format='webp' />"
                    alt=""
                    class="w-[48px] h-[48px] object-contain m-1">
                </a>
            </div>
            </header>

            <!-- START::MOBILE LOGOS BLOCK -->
            <div class="container px-[1em] md:hidden mb-4">
                <div class="px-4 py-3">
                    <div class="flex items-center justify-center gap-4">
                        {{-- Grelka - внешняя ссылка --}}
                        <a href="https://grelkaspa.ru"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex-1 flex justify-center transition-all grayscale-[1] hover:grayscale-0">
                            <img
                                src="<s:glide:data_url src='/assets/img/new_logo_grelka.png' quality='75' format='webp' />"
                                alt="Grelka"
                                class="h-[40px] w-auto object-contain opacity-70 hover:opacity-100 transition-all"
                            >
                        </a>

                        {{-- G1unior --}}
                        <a href="/gun1or/" class="flex-1 flex justify-center transition-all grayscale-[1] hover:grayscale-0">
                            <img
                                src="<s:glide:data_url src='/assets/img/new_logo_gunior.png' quality='75' format='webp' />"
                                alt="G1unior"
                                class="h-[40px] w-auto object-contain opacity-70 hover:opacity-100 transition-all"
                            >
                        </a>

                        {{-- Gagarin - главный сайт (активный) --}}
                        <a href="/" class="flex-1 flex justify-center transition-all grayscale-0">
                            <img
                                src="<s:glide:data_url src='/assets/img/new_logo_gfood.png' quality='75' format='webp' />"
                                alt="Gagarin"
                                class="h-[40px] w-auto object-contain opacity-100 transition-all"
                            >
                        </a>
                    </div>
                </div>
            </div>
            <!-- END::MOBILE LOGOS BLOCK -->
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
                            class="border border-light rounded-[64px] h-16 px-4 text-light flex items-center justify-center"
                            target="_blank"
                            rel="noopener noreferrer">
                                App Store
                            </a>
                        @endif

                        @if($footer->google_play_link)
                            <a href="{{ $footer->google_play_link }}"
                            class="border border-light rounded-[64px] h-16 px-4 text-light flex items-center justify-center"
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
