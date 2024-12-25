<!doctype html>
<html lang="@antlers{{ site:short_locale }}@endantlers">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="view-transition" content="same-origin">
        <title>
            @antlers
                {{ title ?? site:name }}
            @endantlers
        </title>
        {{-- @antlers
        {{ vite src="resources/js/site.js|resources/css/site.css" }}
        @endantlers --}}
        {{-- @vite([
            'vendor/mkocansey/bladewind/public/css/animate.min.css',
            'vendor/mkocansey/bladewind/public/css/bladewind-ui.min.css',
            'vendor/mkocansey/bladewind/public/js/helpers.js'
        ]) --}}
        @vite(['resources/css/site.css', 'resources/js/site.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    </head>
    <body class="bg-dark">
        <!-- START::HEADER -->
        <div class="container px-[1em] my-5 sticky top-4 z-20">
            <header class="container bg-light flex justify-between items-center gap-2 rounded-[30px] px-[20px] py-[14px] ">
            <div class="flex items-center justify-center gap-[34px] relative ">
                <button class="menu-toggle rounded-full bg-dark text-light flex items-center justify-center w-[3.75em] h-[3.75em] relative z-10"><svg
                    width="34" height="22" viewBox="0 0 34 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 2H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                    <path d="M2 11H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                    <path d="M2 20H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                </svg>
                </button>

                <a href="/" class="p-0 m-0 relative z-10 hidden md:block transition-all">
                    <img src="<s:glide:data_url src='/assets/img/logo.png' quality='75' format='webp' />" alt="" class="max-w-[13.625em]">
                </a>

                <ul class="absolute top-[90%] left-[-20px] bg-light rounded-b-[1.875em] p-5  min-w-[17.9375em] menu-items z-9 hidden">
                <li>
                    <a href="/"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">ГЛАВНАЯ СТРАНИЦА</a>
                </li>
                <li>
                    <a href="cicle"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">САЙКЛ</a>
                </li>
                <li>
                    <a href="crossfit"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">Кроссфит</a>
                </li>
                <li>
                    <a href="fitness"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">фитнес</a>
                </li>
                <li>
                    <a href="hall"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">тренажерный зал</a>
                </li>
                <li>
                    <a href="pool"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">бассейн</a>
                </li>
                <li>
                    <a href="schedule"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">Календарь</a>
                </li>
                <li>
                    <a href="trainers"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">ТРЕНЕРЫ</a>
                </li>
                <li>
                    <a href="trainer"
                    class="uppercase text-black leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all">Страница тренера</a>
                </li>
                </ul>

            </div>

            <div class="flex items-center justify-between gap-2 relative z-10">

                <button type="button" class="w-[52px] md:w-[5.4375em] show grayscale-[1] hover:grayscale-0 transition-all">
                    <img
                    src="<s:glide:data_url src='/assets/img/grelka-logo.png' quality='75' format='webp' />" alt="" class="block hover:opacity-70 transition-all"
                    alt="">
                </button>
                <button type="button" class="w-[52px] md:w-[5.4375em] show grayscale-[1] hover:grayscale-0 transition-all">
                    <img
                    src="<s:glide:data_url src='/assets/img/logo-dzhunior.png' quality='75' format='webp' />" alt="" class="block hover:opacity-70 transition-all"
                    alt=""
                    >
                </button>
                <button type="button" class="w-[52px] md:w-[5.4375em] show grayscale-[1] hover:grayscale-0 transition-all">
                    <img
                    src="<s:glide:data_url src='/assets/img/dzhifud-logo.png' quality='75' format='webp' />" alt="" class="block hover:opacity-70 transition-all"
                    alt="">
                </button>
            </div>

            <div class="flex items-center justify-center">
                <p class="text-black font-normal [font-size:_clamp(1rem,0.9228rem+0.3861vw,1.25rem)] hidden lg:block mr-5"> г.
                Симферополь <br> ул.
                Киевская, 115</p>
                <a href="#"
                class="flex items-center justify-center bg-main-red px-[10px] py-[19px] rounded-[30px] text-[20px] text-light hover:opacity-70 transition-all hidden lg:block">записаться</a>
                <a href="#" class="flex items-center justify-center">
                    <img
                    src="<s:glide:data_url src='/assets/img/phone' quality='75' format='webp' />"
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

        <!-- START::FOOTER -->
        <footer class="bg-light py-10 md:py-24 px-4">
            <div class="container sm:grid sm:grid-cols-4 md:grid-cols-5 items-center gap-12 bg-dark rounded-[clamp(3rem,2.3449rem+2.9116vw,4.8125rem)] px-[clamp(2.375rem,1.7877rem+2.6104vw,4rem)] py-10">

            <a href="" class="sm:col-span-4 md:col-span-1 flex justify-center items-center">
                <img
                    src="<s:glide:data_url src='/assets/img/footer-logo.svg' quality='75' format='webp' />"
                    alt=""
                    class="max-w-full block">
            </a>

            <ul class="col-span-2">
                <li class="">
                <a href=""
                    class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">команда</a>
                </li>
                <li class="">
                <a href=""
                    class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">ПАРТНЕРЫ</a>
                </li>
                <li class="">
                <a href=""
                    class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">ОПЛАТА</a>
                </li>
                <li class="">
                <a href=""
                    class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">СОТРУДНИЧЕСТВО
                    И РЕКЛАМА</a>
                </li>
                <li class="">
                <a href=""
                    class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">ПРАВИЛА
                    КЛУБА</a>
                </li>
                <li class="">
                <a href=""
                    class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">ПОЛИТИКА
                    КОНФИДЕЦИАЛЬНОСТИ</a>
                </li>
                <li class="">
                <a href=""
                    class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">ДОГОВОР
                    ОФЕРТЫ</a>
                </li>
                <li class="">
                <a href=""
                    class="text-[clamp(0.6875rem,0.2809rem+1.8072vw,1.8125rem)] text-light font-normal uppercase hover:border-b hover:border-light">КОНТАКТЫ</a>
                </li>
            </ul>

            <ul class="col-span-2">
                <li
                class="text-light [font-size:_clamp(1.125rem,0.7775rem+1.7375vw,2.25rem)] font-normal leading-5 text-right mb-3">
                8 800 500
                1598</li>

                <li class="">
                <span class="block text-light text-right [font-size:_clamp(0.625rem,0.4706rem+0.7722vw,1.125rem)]">пн-пт
                    7-23</span>
                <span class="block text-light text-right [font-size:_clamp(0.625rem,0.4706rem+0.7722vw,1.125rem)]">сб-вс,
                    праздники 7-22</span>
                </li>

                <li class="flex items-center justify-end mb-4">
                <button class="hover:opacity-70 transition-all">
                    <img
                    src="<s:glide:data_url src='/assets/img/telegram_button_light.svg' quality='75' format='webp' />"
                    alt=""
                    class="max-w-[3.3125em]">
                </button>
                <button class="hover:opacity-70 transition-all">
                    <img
                    src="<s:glide:data_url src='/assets/img/vk_button_light.svg' quality='75' format='webp' />"
                    alt=""
                    class="max-w-[3.3125em]"></button>
                </li>

                <li class="">
                <p class="[font-size:_clamp(0.625rem,0.5092rem+0.5792vw,1rem)] text-light font-normal text-right">наше
                    мобильное приложение</p>
                </li>

                <li class="flex items-center justify-end gap-4 py-4">
                <button class="border border-light rounded-[64px] h-16 px-4 py-2 text-light">App Store</button>
                <button class="border border-light rounded-[64px] h-16 px-4 py-2 text-light">Google Play</button>
                </li>

                <li class="flex justify-end items-center gap-5">
                <button class="">
                    <img
                        src="<s:glide:data_url src='/assets/img/yandex_button.svg' quality='75' format='webp' />"
                        alt="">
                </button>
                <p class="text-light [font-size:_clamp(0.5rem,0.3649rem+0.6757vw,0.9375rem)] font-normal">наш рейтинг <br>на
                    Яндекс</p>
                <p class="[font-size:_clamp(1.3125rem,0.9457rem+1.834vw,2.5rem)] text-light font-normal">4,9</p>
                </li>

            </ul>

            </div>
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
                        class="[font-size:_clamp(1.625rem,-0.2494rem+6.0465vw,4.875rem)] font-normal uppercase leading-none"
                    >
                        название
                    </h2>
                    <p
                        class="[font-size:_clamp(1.1875rem,0.4666rem+2.3256vw,2.4375rem)]"
                    >
                        текст акции
                    </p>

                    @antlers
                {{ form:grelka attr:x-ref="form" js="alpine" }}
                    <div
                        x-data='{
                            form: $form(
                                "post",
                                $refs.form.getAttribute("action"),
                                JSON.parse($refs.form.getAttribute("x-data"))
                            ).setErrors({{ error | json }}),
                        }' @submit.prevent="form.submit()"
                        class="mt-16 flex flex-col lg:flex-row items-center justify-between gap-4 pb-4"
                    >

                        {{-- {{ if success }}
                            <div class="bg-green-300 text-white p-2">
                                {{ success }}
                            </div>
                        {{ /if }} --}}

                        <template x-if="form.hasErrors">
                            <div>
                                <div class="bg-red-300 text-white p-2">
                                    Errors!
                                    <ul>
                                        <template x-for="error in form.errors">
                                            <li x-text="error"></li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </template>

                        <input type="text" name="full_name" value="" x-model="full_name" required="" placeholder="Имя" class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase" />
                        <input type="tel" name="phone" value="" x-model="phone" required="" placeholder="Номер" class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase" />
                        <small x-show="form.invalid('{{ handle }}')" x-text="form.errors.{{ handle }}"></small>

                        <input type="text" class="hidden" name="{{ honeypot ?? 'honeypot' }}">

                        <button :disabled="form.processing" class="transition-all hover:opacity-70">
                            <svg
                                width="161"
                                height="81"
                                viewBox="0 0 161 81"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <rect width="161" height="81" rx="33" fill="#E23333" />
                                <path
                                    d="M133.121 42.1213C134.293 40.9497 134.293 39.0503 133.121 37.8787L114.029 18.7868C112.858 17.6152 110.958 17.6152 109.787 18.7868C108.615 19.9584 108.615 21.8579 109.787 23.0294L126.757 40L109.787 56.9706C108.615 58.1421 108.615 60.0416 109.787 61.2132C110.958 62.3848 112.858 62.3848 114.029 61.2132L133.121 42.1213ZM29 43H131V37H29V43Z"
                                    fill="#FFF8F8"
                                />
                            </svg>
                        </button>

                    </div>
                {{ /form:grelka }}
                @endantlers

                    <!-- <form
                        action=""
                        method="post"
                        class="mt-16 flex flex-col lg:flex-row items-center justify-between gap-4 pb-4"
                    >
                        <input
                            type="text"
                            name=""
                            id=""
                            placeholder="имя"
                            class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase"
                        />

                        <input
                            type="tel"
                            name=""
                            id=""
                            placeholder="номер"
                            class="rounded-[32px] px-8 py-4 text-dark w-full h-[81px] lg:flex-1 uppercase"
                        />

                        <button type="submit" class="transition-all hover:opacity-70">
                            <svg
                                width="161"
                                height="81"
                                viewBox="0 0 161 81"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <rect width="161" height="81" rx="33" fill="#E23333" />
                                <path
                                    d="M133.121 42.1213C134.293 40.9497 134.293 39.0503 133.121 37.8787L114.029 18.7868C112.858 17.6152 110.958 17.6152 109.787 18.7868C108.615 19.9584 108.615 21.8579 109.787 23.0294L126.757 40L109.787 56.9706C108.615 58.1421 108.615 60.0416 109.787 61.2132C110.958 62.3848 112.858 62.3848 114.029 61.2132L133.121 42.1213ZM29 43H131V37H29V43Z"
                                    fill="#FFF8F8"
                                />
                            </svg>
                        </button>
                    </form> -->
                </div>
            </div>
        </dialog>

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        </script>
    </body>
</html>
