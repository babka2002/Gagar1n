<!doctype html>
<html lang="@antlers{{ site:short_locale }}@endantlers">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="view-transition" content="same-origin">
        @antlers
            {{ '/assets/favicon.ico' | favicon }}
            {{-- {{ icon | favicon }} --}}
            {{-- {{ dump:site }} --}}
        @endantlers
        <title>
            @antlers
                {{ title ?? site:name }}
            @endantlers
        </title>

        @antlers
        {{ if field_meta_description }}
            <meta name="description" content="{{ field_meta_description }}">
        {{ /if }}

        {{ if field_meta_keywords }}
            <meta name="keywords" content="{{ field_meta_keywords }}">
        {{ /if }}
        @endantlers
        {{-- @vite([
            'vendor/mkocansey/bladewind/public/css/animate.min.css',
            'vendor/mkocansey/bladewind/public/css/bladewind-ui.min.css',
            'vendor/mkocansey/bladewind/public/js/helpers.js'
        ]) --}}

        {{-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> --}}
        {{-- <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script> --}}

        @vite(['resources/css/site.css', 'resources/css/markdown-content.css', 'resources/js/site.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-dark">
        <x-spinner />
        <!-- START::HEADER -->
        <div class="container px-[1em] md:px-0 my-5 sticky top-4 z-20">
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
                    <img src="<s:glide:data_url src='/assets/img/logo.png' quality='75' format='webp' />" alt="" class="max-w-[13.625em]">
                </a>

                @antlers
                {{ partial:grelka/_nav }}
                @endantlers

            </div>

            <div class="flex items-center justify-between gap-2 relative z-10">
                {{-- Grelka - основной сайт --}}
                <s:get_site:Grelka>
                    <a href="https://grelkaspa.ru"
                    {{-- <a href="{{ $permalink }}" --}}
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
                    <a href="https://gunior.ru"
                    {{-- <a href="{{ $permalink }}" --}}
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
                    <a href="https://gfoodcafe.ru"
                    {{-- <a href="{{ $permalink }}" --}}
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

                <!-- Кнопка записаться с выпадающим меню -->
                <div class="relative hidden lg:block" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        aria-label="booking button"
                        class="flex items-center justify-center gap-2 bg-main-red px-[10px] py-[19px] rounded-[30px] text-[20px] text-light hover:opacity-70 transition-all">
                        записаться
                        <svg
                            :class="open ? 'rotate-180' : ''"
                            class="w-4 h-4 transition-transform"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Выпадающее меню -->
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                    >
                        <div class="py-2">
                            <a href="#"
                               data-dialog="dialog"
                               data-booking-type="massage"
                               class="show flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-main-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4 4 4 0 004-4V5z"></path>
                                </svg>
                                Запись на массаж
                            </a>

                            <a href="#"
                               data-dialog="dialog"
                               data-booking-type="call"
                               class="show flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-main-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Запись на звонок
                            </a>

                            <a href="#"
                               data-dialog="dialog"
                               data-booking-type="personal"
                               class="show flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-main-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Персональные тренировки
                            </a>

                            <a href="#"
                               data-dialog="dialog"
                               data-booking-type="group"
                               class="show flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-main-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Групповые занятия
                            </a>
                        </div>
                    </div>
                </div>

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

        {{-- {{ $page->content }} --}}
        @antlers
        {{ template_content }}
        @endantlers
        @yield('trainersContent')
        @yield('trainerContent')
        @yield('scheduleContent')
        @yield('fitness')


        <!-- START::FOOTER -->
        <footer class="bg-light py-10 md:py-24 px-4">
            <div class="container sm:grid sm:grid-cols-4 md:grid-cols-5 items-center gap-12 bg-dark rounded-[clamp(3rem,2.3449rem+2.9116vw,4.8125rem)] px-[clamp(2.375rem,1.7877rem+2.6104vw,4rem)] py-10">

                <!-- Логотип -->
                <a href="/" class="sm:col-span-4 md:col-span-1 flex justify-center items-center">
                    @if($footer->footer_logo)
                        <img src="{{ $footer->footer_logo }}" alt="Gagar1n" class="max-w-full block">
                    @else
                        <img src="/assets/img/footer-logo.svg" alt="Gagar1n" class="max-w-full block">
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

            <!-- Copyright -->
            {{-- @if($footer->copyright)
                <div class="container text-center mt-4 text-dark">
                    <p>{{ $footer->copyright }}</p>
                </div>
            @endif --}}
        </footer>
        <!-- END::FOOTER -->


        <dialog
            id="dialog"
            class="dialog-glass text-light w-[95%] max-w-[1183px] p-8 lg:p-16 rounded-[32px] lg:rounded-[66px]"
            >
            <div class="flex flex-col mx-4">
                <button class="close hover:scale-90 transition-all ml-auto">
                    <svg
                        width="60"
                        height="60"
                        viewBox="0 0 60 60"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <circle cx="30" cy="30" r="30" fill="#D9D9D9" />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M21.4866 16.5368C20.1132 15.1765 17.8867 15.1765 16.5134 16.5368C15.1401 17.8972 15.1401 20.1027 16.5134 21.463L25.5268 30.3913L16.0683 39.7603C14.695 41.1207 14.695 43.3262 16.0683 44.6865C17.4416 46.0468 19.6682 46.0468 21.0415 44.6865L30.5 35.3175L39.9584 44.6865C41.3317 46.0468 43.5583 46.0468 44.9316 44.6865C46.3049 43.3262 46.3049 41.1207 44.9316 39.7603L35.4731 30.3913L44.4865 21.463C45.8599 20.1027 45.8599 17.8972 44.4865 16.5368C43.1132 15.1765 40.8867 15.1765 39.5134 16.5368L30.5 25.4651L21.4866 16.5368Z"
                            fill="#3D3D3D"
                        />
                    </svg>
                </button>

                <div class="h-auto">
                    <h2
                        id="dialog-title"
                        data-original-title="{{ $popup_pozvonit->title }}"
                        class="[font-size:_clamp(1.625rem,-0.2494rem+6.0465vw,4.875rem)] font-normal uppercase leading-none"
                    >
                        {{ $popup_pozvonit->title }}
                    </h2>
                    <p
                        id="dialog-text"
                        data-original-text="{{ $popup_pozvonit->text }}"
                        class="[font-size:_clamp(1.1875rem,0.4666rem+2.3256vw,2.4375rem)]"
                    >
                    {{ $popup_pozvonit->text }}
                    </p>

                    @antlers
                    {{ form:grelka }}
                        <div class="mt-16 flex flex-col lg:flex-row items-center justify-between gap-4 pb-4">
                            <!-- Индикатор состояния -->
                            <div id="formStatus" class="fixed top-4 right-4 p-4 rounded-lg hidden z-50">
                                <p class="text-white"></p>
                            </div>

                            <input
                                type="text"
                                name="full_name"
                                required
                                placeholder="Имя"
                                class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase"
                            />

                            <input
                                type="tel"
                                name="phone"
                                required
                                placeholder="Номер"
                                class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase"
                            />

                            <button
                                type="submit"
                                class="transition-all hover:opacity-70"
                            >
                                <svg width="161" height="81" viewBox="0 0 161 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="161" height="81" rx="33" fill="#E23333" />
                                    <path d="M133.121 42.1213C134.293 40.9497 134.293 39.0503 133.121 37.8787L114.029 18.7868C112.858 17.6152 110.958 17.6152 109.787 18.7868C108.615 19.9584 108.615 21.8579 109.787 23.0294L126.757 40L109.787 56.9706C108.615 58.1421 108.615 60.0416 109.787 61.2132C110.958 62.3848 112.858 62.3848 114.029 61.2132L133.121 42.1213ZM29 43H131V37H29V43Z" fill="#FFF8F8" />
                                </svg>
                            </button>
                        </div>

                        <!-- Согласие на обработку ПД -->
                        <div class="mt-4 flex items-start gap-3">
                            <input
                                type="checkbox"
                                id="privacy-consent-1"
                                name="privacy_consent"
                                required
                                class="mt-1 w-5 h-5 text-main-red border-gray-300 rounded focus:ring-main-red"
                            />
                            <label for="privacy-consent-1" class="text-base text-light leading-relaxed">
                                Я согласен(а) на обработку персональных данных и принимаю условия <a href="/policy" target="_blank" class="text-main-red hover:underline">политики конфиденциальности</a>
                            </label>
                        </div>
                    {{ /form:grelka }}

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dialogMoreElem = document.getElementById("dialog");
                        let form = dialogMoreElem.querySelector('form[action*="/!/forms/grelka"]');

                        function showSuccessMessage() {
                            form.style.display = 'none';
                            const successMessage = document.createElement('div');
                            successMessage.className = 'text-center py-8';
                            successMessage.innerHTML = `
                                <h3 class="text-2xl mb-4 text-green-400">Спасибо! Ваша заявка успешно отправлена</h3>
                                <p class="text-lg">Мы свяжемся с вами в ближайшее время</p>
                            `;
                            form.parentNode.appendChild(successMessage);
                        }
                        // Обработчик для всех кнопок с классом show
                        document.querySelectorAll('.show[data-dialog]').forEach(button => {
                            button.addEventListener('click', function(e) {
                                let formSubject = 'Заявка с сайта';
                                let leadType = "request";
                                const trainerName = this.getAttribute('data-trainer-name');
                                const bookingType = this.getAttribute('data-booking-type');

                                if (trainerName) {
                                    formSubject = `Форма Тренер - ${trainerName}`;
                                    leadType = "trainer";
                                }

                                 // Проверяем, это абонемент?
                                const abonimentName = this.getAttribute('data-aboniment-name');
                                if (abonimentName) {
                                    formSubject = `Форма Абонемент - ${abonimentName}`;
                                    leadType = "subscription";
                                }

                                // Проверяем тип записи из выпадающего меню
                                if (bookingType) {
                                    const dialogTitle = document.getElementById('dialog-title');
                                    const dialogText = document.getElementById('dialog-text');

                                    switch(bookingType) {
                                        case 'massage':
                                            formSubject = 'Запись на массаж';
                                            leadType = "massage";
                                            if (dialogTitle) dialogTitle.textContent = 'ЗАПИСЬ НА МАССАЖ';
                                            if (dialogText) dialogText.textContent = 'Оставьте свои контакты и мы свяжемся с вами для записи на массаж';
                                            break;
                                        case 'call':
                                            formSubject = 'Запись на звонок';
                                            leadType = "callback";
                                            if (dialogTitle) dialogTitle.textContent = 'ОБРАТНЫЙ ЗВОНОК';
                                            if (dialogText) dialogText.textContent = 'Оставьте свой номер телефона и мы вам перезвоним';
                                            break;
                                        case 'personal':
                                            formSubject = 'Запись на персональные тренировки';
                                            leadType = "personal_training";
                                            if (dialogTitle) dialogTitle.textContent = 'ПЕРСОНАЛЬНЫЕ ТРЕНИРОВКИ';
                                            if (dialogText) dialogText.textContent = 'Запишитесь на индивидуальные тренировки с персональным тренером';
                                            break;
                                        case 'group':
                                            formSubject = 'Запись на групповые занятия';
                                            leadType = "group_training";
                                            if (dialogTitle) dialogTitle.textContent = 'ГРУППОВЫЕ ЗАНЯТИЯ';
                                            if (dialogText) dialogText.textContent = 'Присоединяйтесь к нашим групповым тренировкам';
                                            break;
                                    }
                                } else {
                                    // Сбрасываем заголовок и текст к оригинальным если это не специальная запись
                                    const dialogTitle = document.getElementById('dialog-title');
                                    const dialogText = document.getElementById('dialog-text');
                                    if (dialogTitle) dialogTitle.textContent = dialogTitle.getAttribute('data-original-title');
                                    if (dialogText) dialogText.textContent = dialogText.getAttribute('data-original-text');
                                }

                                // Формируем данные для webhook
                                window.currentFormData = {
                                    leadtype: leadType,
                                    subject: formSubject
                                };

                                // Закрываем выпадающее меню если оно открыто
                                const dropdown = document.querySelector('[x-data*="open"]');
                                if (dropdown && dropdown.__x) {
                                    dropdown.__x.$data.open = false;
                                }
                            });
                        });

                        if (form) {
                            const oldForm = form.cloneNode(true);
                            form.parentNode.replaceChild(oldForm, form);
                            form = oldForm;

                            form.addEventListener('submit', async function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);
                                const token = document.querySelector('input[name="_token"]').value;
                                const submitButton = form.querySelector('button[type="submit"]');
                                const hostname = window.location.hostname.replace('www.', '');

                                submitButton.disabled = true;
                                window.showSpinner();

                                try {
                                    const statamicResponse = await fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-TOKEN': token
                                        },
                                        body: formData
                                    });

                                    if (statamicResponse.ok) {
                                        showSuccessMessage();
                                        this.reset();

                                        setTimeout(() => {
                                            // dialogElem.close();
                                            setTimeout(() => {
                                                form.style.display = 'block';
                                                const successMessage = form.parentNode.querySelector('div');
                                                if (successMessage) {
                                                    successMessage.remove();
                                                }
                                            }, 500);
                                        }, 3000);

                                        // Используем сохраненные данные для webhook
                                        const webhookData = {
                                            leadtype: window.currentFormData?.leadtype || "request",
                                            callerphone: formData.get('phone'),
                                            requestDate: new Date().toISOString().slice(0, 19).replace('T', ' '),
                                            subject: window.currentFormData?.subject || "Заявка с сайта",
                                            fio: formData.get('full_name'),
                                            source: hostname,
                                            medium: document.referrer || "direct",
                                            siteName: hostname,
                                            city: "Симферополь"
                                        };

                                        // Отправляем в webhook
                                        await fetch('/webhook-proxy', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': token
                                            },
                                            body: JSON.stringify(webhookData)
                                        });
                                    } else {
                                        throw new Error('Failed to submit form');
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'text-red-500 text-center mt-4';
                                    errorDiv.textContent = 'Произошла ошибка при отправке формы. Пожалуйста, попробуйте еще раз';
                                    form.appendChild(errorDiv);

                                    setTimeout(() => {
                                        errorDiv.remove();
                                    }, 3000);
                                } finally {
                                    submitButton.disabled = false;
                                    hideSpinner();
                                }
                            });
                        }
                    });
                    </script>
                    @endantlers
                </div>
            </div>
        </dialog>
        <dialog
            id="dialog-more"
            class="dialog-glass text-light w-[95%] max-w-[1183px] p-8 lg:p-16 rounded-[32px] lg:rounded-[66px]"
            >
            <div class="flex flex-col mx-4">
                <button class="close hover:scale-90 transition-all ml-auto">
                    <svg
                        width="60"
                        height="60"
                        viewBox="0 0 60 60"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <circle cx="30" cy="30" r="30" fill="#D9D9D9" />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M21.4866 16.5368C20.1132 15.1765 17.8867 15.1765 16.5134 16.5368C15.1401 17.8972 15.1401 20.1027 16.5134 21.463L25.5268 30.3913L16.0683 39.7603C14.695 41.1207 14.695 43.3262 16.0683 44.6865C17.4416 46.0468 19.6682 46.0468 21.0415 44.6865L30.5 35.3175L39.9584 44.6865C41.3317 46.0468 43.5583 46.0468 44.9316 44.6865C46.3049 43.3262 46.3049 41.1207 44.9316 39.7603L35.4731 30.3913L44.4865 21.463C45.8599 20.1027 45.8599 17.8972 44.4865 16.5368C43.1132 15.1765 40.8867 15.1765 39.5134 16.5368L30.5 25.4651L21.4866 16.5368Z"
                            fill="#3D3D3D"
                        />
                    </svg>
                </button>

                <div class="h-auto">
                    <h2
                        class="[font-size:_clamp(1.625rem,-0.2494rem+6.0465vw,4.875rem)] font-normal uppercase leading-none"
                    >
                        {{ $popup_podrobnee->popup_title }}
                    </h2>
                    <p
                        class="[font-size:_clamp(1.1875rem,0.4666rem+2.3256vw,2.4375rem)]"
                    >
                    {{ $popup_podrobnee->popap_text }}
                    </p>

                    @antlers
                    {{ form:grelka }}
                        <div class="mt-16 flex flex-col lg:flex-row items-center justify-between gap-4 pb-4">
                            <!-- Индикатор состояния -->
                            <div id="formStatus" class="fixed top-4 right-4 p-4 rounded-lg hidden z-50">
                                <p class="text-white"></p>
                            </div>

                            <input
                                type="text"
                                name="full_name"
                                required
                                placeholder="Имя"
                                class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase"
                            />

                            <input
                                type="tel"
                                name="phone"
                                required
                                placeholder="Номер"
                                class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase"
                            />

                            <button
                                type="submit"
                                class="transition-all hover:opacity-70"
                            >
                                <svg width="161" height="81" viewBox="0 0 161 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="161" height="81" rx="33" fill="#E23333" />
                                    <path d="M133.121 42.1213C134.293 40.9497 134.293 39.0503 133.121 37.8787L114.029 18.7868C112.858 17.6152 110.958 17.6152 109.787 18.7868C108.615 19.9584 108.615 21.8579 109.787 23.0294L126.757 40L109.787 56.9706C108.615 58.1421 108.615 60.0416 109.787 61.2132C110.958 62.3848 112.858 62.3848 114.029 61.2132L133.121 42.1213ZM29 43H131V37H29V43Z" fill="#FFF8F8" />
                                </svg>
                            </button>
                        </div>

                        <!-- Согласие на обработку ПД -->
                        <div class="mt-4 flex items-start gap-3">
                            <input
                                type="checkbox"
                                id="privacy-consent-2"
                                name="privacy_consent"
                                required
                                class="mt-1 w-5 h-5 text-main-red border-gray-300 rounded focus:ring-main-red"
                            />
                            <label for="privacy-consent-2" class="text-base text-light leading-relaxed">
                                Я согласен(а) на обработку персональных данных и принимаю условия <a href="/policy" target="_blank" class="text-main-red hover:underline">политики конфиденциальности</a>
                            </label>
                        </div>
                    {{ /form:grelka }}

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dialogMoreElem = document.getElementById("dialog-more");
                        let form = dialogMoreElem.querySelector('form[action*="/!/forms/grelka"]');


                        function showSuccessMessage() {
                            form.style.display = 'none';
                            const successMessage = document.createElement('div');
                            successMessage.className = 'text-center py-8';
                            successMessage.innerHTML = `
                                <h3 class="text-2xl mb-4 text-green-400">Спасибо! Ваша заявка успешно отправлена</h3>
                                <p class="text-lg">Мы свяжемся с вами в ближайшее время</p>
                            `;
                            form.parentNode.appendChild(successMessage);
                        }

                        if (form) {
                            const oldForm = form.cloneNode(true);
                            form.parentNode.replaceChild(oldForm, form);
                            form = oldForm;

                            form.addEventListener('submit', async function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);
                                const token = document.querySelector('input[name="_token"]').value;
                                const submitButton = form.querySelector('button[type="submit"]');
                                const hostname = window.location.hostname.replace('www.', '');

                                submitButton.disabled = true;
                                window.showSpinner();

                                try {
                                    const statamicResponse = await fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-TOKEN': token
                                        },
                                        body: formData
                                    });

                                    if (statamicResponse.ok) {
                                        showSuccessMessage();
                                        this.reset();

                                        setTimeout(() => {
                                            // dialogElem.close();
                                            setTimeout(() => {
                                                form.style.display = 'block';
                                                const successMessage = form.parentNode.querySelector('div');
                                                if (successMessage) {
                                                    successMessage.remove();
                                                }
                                            }, 500);
                                        }, 3000);

                                        // Формируем данные точно как в curl запросе
                                        const webhookData = {
                                            leadtype: "request",
                                            callerphone: formData.get('phone'),
                                            requestDate: new Date().toISOString().slice(0, 19).replace('T', ' '),
                                            subject: "Заявка с сайта",
                                            fio: formData.get('full_name'),
                                            source: hostname,
                                            medium: document.referrer || "direct",
                                            siteName: hostname,
                                            city: "Симферополь"
                                        };

                                        // Отправляем в webhook
                                        await fetch('/webhook-proxy', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': token
                                            },
                                            body: JSON.stringify(webhookData)
                                        });
                                    } else {
                                        throw new Error('Failed to submit form');
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'text-red-500 text-center mt-4';
                                    errorDiv.textContent = 'Произошла ошибка при отправке формы. Пожалуйста, попробуйте еще раз';
                                    form.appendChild(errorDiv);

                                    setTimeout(() => {
                                        errorDiv.remove();
                                    }, 3000);
                                } finally {
                                    submitButton.disabled = false;
                                    hideSpinner();
                                }
                            });
                        }
                    });
                    </script>
                    @endantlers

                </div>
            </div>
        </dialog>
        <dialog
            id="dialog-autoplay"
            class="dialog-glass text-light w-[95%] max-w-[1183px] p-8 lg:p-16 rounded-[32px] lg:rounded-[66px]"
            data-delay="{{ $popup_autoplay->popup_delay ?? 3 }}"
            data-interval="{{ $popup_autoplay->popup_interval ?? 7 }}"
            data-enabled="{{ $popup_autoplay->popup_enabled ? 'true' : 'false' }}"
            >
            <div class="flex flex-col mx-4">
                <button class="close hover:scale-90 transition-all ml-auto">
                    <svg
                        width="60"
                        height="60"
                        viewBox="0 0 60 60"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <circle cx="30" cy="30" r="30" fill="#D9D9D9" />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M21.4866 16.5368C20.1132 15.1765 17.8867 15.1765 16.5134 16.5368C15.1401 17.8972 15.1401 20.1027 16.5134 21.463L25.5268 30.3913L16.0683 39.7603C14.695 41.1207 14.695 43.3262 16.0683 44.6865C17.4416 46.0468 19.6682 46.0468 21.0415 44.6865L30.5 35.3175L39.9584 44.6865C41.3317 46.0468 43.5583 46.0468 44.9316 44.6865C46.3049 43.3262 46.3049 41.1207 44.9316 39.7603L35.4731 30.3913L44.4865 21.463C45.8599 20.1027 45.8599 17.8972 44.4865 16.5368C43.1132 15.1765 40.8867 15.1765 39.5134 16.5368L30.5 25.4651L21.4866 16.5368Z"
                            fill="#3D3D3D"
                        />
                    </svg>
                </button>

                <div class="h-auto">

                    @if($popup_autoplay->popap_image && $popup_autoplay->popap_image->url())
                        <img
                            src="{{ $popup_autoplay->popap_image->url() }}"
                            srcset="<s:glide:data_url src='{{ $popup_autoplay->popap_image }}' width='640' quality='75' format='webp' /> 640w,
                                <s:glide:data_url src='{{ $popup_autoplay->popap_image }}' width='768' quality='75' format='webp' /> 768w,
                                <s:glide:data_url src='{{ $popup_autoplay->popap_image }}' width='1024' quality='75' format='webp' /> 1024w"
                            alt="{{ $popup_autoplay->popup_title }}"
                            class="w-full h-auto object-cover max-h-[30vh] lg:max-h-[35vh] rounded-2xl pb-2"
                        >
                    @endif

                    <h2
                        class="[font-size:_clamp(1.625rem,-0.2494rem+6.0465vw,4.875rem)] font-normal uppercase leading-none"
                    >
                        {{ $popup_autoplay->popup_title }}
                    </h2>
                    <p
                        class="[font-size:_clamp(1.1875rem,0.4666rem+2.3256vw,2.4375rem)]"
                    >
                    {{ $popup_autoplay->popap_text }}
                    </p>

                    @antlers
                    {{ form:grelka }}
                        <div class="mt-16 flex flex-col lg:flex-row items-center justify-between gap-4 pb-4">
                            <!-- Индикатор состояния -->
                            <div id="formStatus" class="fixed top-4 right-4 p-4 rounded-lg hidden z-50">
                                <p class="text-white"></p>
                            </div>

                            <input
                                type="text"
                                name="full_name"
                                required
                                placeholder="Имя"
                                class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase"
                            />

                            <input
                                type="tel"
                                name="phone"
                                required
                                placeholder="Номер"
                                class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase"
                            />

                            <button
                                type="submit"
                                class="transition-all hover:opacity-70"
                            >
                                <svg width="161" height="81" viewBox="0 0 161 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="161" height="81" rx="33" fill="#E23333" />
                                    <path d="M133.121 42.1213C134.293 40.9497 134.293 39.0503 133.121 37.8787L114.029 18.7868C112.858 17.6152 110.958 17.6152 109.787 18.7868C108.615 19.9584 108.615 21.8579 109.787 23.0294L126.757 40L109.787 56.9706C108.615 58.1421 108.615 60.0416 109.787 61.2132C110.958 62.3848 112.858 62.3848 114.029 61.2132L133.121 42.1213ZM29 43H131V37H29V43Z" fill="#FFF8F8" />
                                </svg>
                            </button>
                        </div>

                        <!-- Согласие на обработку ПД -->
                        <div class="mt-4 flex items-start gap-3">
                            <input
                                type="checkbox"
                                id="privacy-consent-3"
                                name="privacy_consent"
                                required
                                class="mt-1 w-5 h-5 text-main-red border-gray-300 rounded focus:ring-main-red"
                            />
                            <label for="privacy-consent-3" class="text-base text-light leading-relaxed">
                                Я согласен(а) на обработку персональных данных и принимаю условия <a href="/policy" target="_blank" class="text-main-red hover:underline">политики конфиденциальности</a>
                            </label>
                        </div>
                    {{ /form:grelka }}

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dialogAutoplayElem = document.getElementById("dialog-autoplay");
                        let form = dialogAutoplayElem.querySelector('form[action*="/!/forms/grelka"]');

                        function showSuccessMessage() {
                            form.style.display = 'none';
                            const successMessage = document.createElement('div');
                            successMessage.className = 'text-center py-8';
                            successMessage.innerHTML = `
                                <h3 class="text-2xl mb-4 text-green-400">Спасибо! Ваша заявка успешно отправлена</h3>
                                <p class="text-lg">Мы свяжемся с вами в ближайшее время</p>
                            `;
                            form.parentNode.appendChild(successMessage);
                        }

                        if (form) {
                            const oldForm = form.cloneNode(true);
                            form.parentNode.replaceChild(oldForm, form);
                            form = oldForm;

                            form.addEventListener('submit', async function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);
                                const token = document.querySelector('input[name="_token"]').value;
                                const submitButton = form.querySelector('button[type="submit"]');
                                const hostname = window.location.hostname.replace('www.', '');

                                submitButton.disabled = true;
                                window.showSpinner();

                                try {
                                    const statamicResponse = await fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-TOKEN': token
                                        },
                                        body: formData
                                    });

                                    if (statamicResponse.ok) {
                                        showSuccessMessage();
                                        this.reset();

                                        setTimeout(() => {
                                            setTimeout(() => {
                                                form.style.display = 'block';
                                                const successMessage = form.parentNode.querySelector('div');
                                                if (successMessage) {
                                                    successMessage.remove();
                                                }
                                            }, 500);
                                        }, 3000);

                                        // Формируем данные для webhook
                                        const webhookData = {
                                            leadtype: "autoplay_popup",
                                            callerphone: formData.get('phone'),
                                            requestDate: new Date().toISOString().slice(0, 19).replace('T', ' '),
                                            subject: "Заявка из автоплей попапа",
                                            fio: formData.get('full_name'),
                                            source: hostname,
                                            medium: document.referrer || "direct",
                                            siteName: hostname,
                                            city: "Симферополь"
                                        };

                                        // Отправляем в webhook
                                        await fetch('/webhook-proxy', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': token
                                            },
                                            body: JSON.stringify(webhookData)
                                        });
                                    } else {
                                        throw new Error('Failed to submit form');
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'text-red-500 text-center mt-4';
                                    errorDiv.textContent = 'Произошла ошибка при отправке формы. Пожалуйста, попробуйте еще раз';
                                    form.appendChild(errorDiv);

                                    setTimeout(() => {
                                        errorDiv.remove();
                                    }, 3000);
                                } finally {
                                    submitButton.disabled = false;
                                    hideSpinner();
                                }
                            });
                        }
                    });
                    </script>
                    @endantlers

                </div>
            </div>
        </dialog>
        @if($footer->footer_block_metrika)
            {!! $footer->footer_block_metrika !!}
        @endif
    </body>
</html>
