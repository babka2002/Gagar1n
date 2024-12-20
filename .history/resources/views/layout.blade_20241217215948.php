<!doctype html>
<html lang="@antlers{{ site:short_locale }}@endantlers">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            @antlers
                {{ title ?? site:name }}
            @endantlers
        </title>
        {{-- @antlers
        {{ vite src="resources/js/site.js|resources/css/site.css" }}
        @endantlers --}}
        @vite([
            'vendor/mkocansey/bladewind/public/css/animate.min.css',
            'vendor/mkocansey/bladewind/public/css/bladewind-ui.min.css',
            'vendor/mkocansey/bladewind/public/js/helpers.js'
        ])
        @vite(['resources/css/site.css', 'resources/js/site.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    </head>
    <body class="bg-dark">
        <!-- START::HEADER -->
        <div class="container px-[1em] my-5 sticky top-4 z-20">
            <header class="container bg-light flex justify-between items-center gap-2 rounded-[30px] px-[20px] py-[14px] ">
            <div class="flex items-center justify-center gap-[34px] relative ">
                <button onclick="MobileMenu.toggle()"
                class="rounded-full bg-dark text-light flex items-center justify-center w-[3.75em] h-[3.75em] relative z-10"><svg
                    width="34" height="22" viewBox="0 0 34 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 2H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                    <path d="M2 11H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                    <path d="M2 20H32" stroke="#EBE7E7" stroke-width="4" stroke-linecap="round" />
                </svg>
                </button>

                <a href="/" class="p-0 m-0 relative z-10 hidden md:block">
                <img src="<s:glide src='/assets/img/logo.png' />" alt="" class="max-w-[13.625em]">

                </a>

                <ul class="absolute top-[90%] left-[-20px] bg-light rounded-b-[1.875em] p-5  min-w-[18.75em] menu-items z-9">
                <li>
                    <a href="/fitness.html"
                    class="uppercase leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all text-[clamp(1.4375rem,1.302rem+0.6024vw,1.8125rem)]">Фитнес</a>
                </li>
                <li>
                    <a href="/pool.html"
                    class="uppercase leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all text-[clamp(1.4375rem,1.302rem+0.6024vw,1.8125rem)]">Бессейн</a>
                </li>
                <li>
                    <a href="#"
                    class="uppercase leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all text-[clamp(1.4375rem,1.302rem+0.6024vw,1.8125rem)]">тренажерный
                    зал</a>
                </li>
                <li>
                    <a href="#"
                    class="uppercase leading-8 font-normal block hover:underline hover:underline-offset-4 transition-all text-[clamp(1.4375rem,1.302rem+0.6024vw,1.8125rem)]">групповые
                    тренировки</a>
                </li>
                </ul>

            </div>

            <div class="flex items-center justify-between gap-2 relative z-10">

                <button type="button" class="w-[52px] md:w-[5.4375em] show grayscale-[1] hover:grayscale-0 transition-all">
                    <img src="<s:glide src='/assets/img/grelka-logo.png' />" alt="" class="block hover:opacity-70 transition-all" />
                </button>
                <button type="button" class="w-[52px] md:w-[5.4375em] show grayscale-[1] hover:grayscale-0 transition-all">
                    <img src="<s:glide src='/assets/img/logo-dzhunior.png' />" alt="" class="block hover:opacity-70 transition-all"/>
                </button>
                <button type="button" class="w-[52px] md:w-[5.4375em] show grayscale-[1] hover:grayscale-0 transition-all">
                    <img src="<s:glide src='/assets/img/dzhifud-logo.png' />" alt="" class="block hover:opacity-70 transition-all" />
                </button>


                <!-- <button type="button" class="w-[52px] md:w-[5.4375em]"><img src="/img/g1.png" alt="" -->
                <!--     class="block show"></button> -->
                <!-- <button type="button" class="w-[52px] md:w-[5.4375em]"><img src="/img/g1.png" alt="" -->
                <!--     class="block filter grayscale-[.7] hover:grayscale-0 transition-all"></button> -->
                <!-- <button type="button" class="w-[52px] md:w-[5.4375em]"><img src="/img/g1.png" alt="" -->
                <!--     class="block filter grayscale hover:grayscale-0 transition-all"></button> -->
            </div>

            <div class="flex items-center justify-center">
                <p class="text-black font-normal [font-size:_clamp(1rem,0.9228rem+0.3861vw,1.25rem)] hidden lg:block mr-5"> г.
                Симферополь <br> ул.
                Киевская, 115</p>
                <a href="#"
                class="flex items-center justify-center bg-main-red px-[10px] py-[19px] rounded-[30px] text-[20px] text-light hover:opacity-70 transition-all hidden lg:block">записаться</a>
                <a href="#" class="flex items-center justify-center"><img src="<s:glide src='/assets/img/phone.png' />" alt=""
                    class="min-w-[52px] h-[52px] flex-1 lg:hidden"></a>
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
    <div
      class="container sm:grid sm:grid-cols-4 md:grid-cols-5 items-center gap-12 bg-dark rounded-[clamp(3rem,2.3449rem+2.9116vw,4.8125rem)] px-[clamp(2.375rem,1.7877rem+2.6104vw,4rem)] py-10">

      <a href="" class="sm:col-span-4 md:col-span-1 flex justify-center items-center"><img src="{{ glide src='/assets/img/footer-logo.svg' }}"
          alt="" class="max-w-full block"></a>

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
          <button class="hover:opacity-70 transition-all"><img src="{{ glide src='/assets/img/telegram_button_light.svg' }}" alt=""
              class="max-w-[3.3125em]"></button>
          <button class="hover:opacity-70 transition-all"><img src="{{ glide src='/assets/img/vk_button_light.svg' }}" alt=""
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
          <button class=""><img src="{{ glide src='/assets/img/yandex_button.svg' }}" alt=""></button>
          <p class="text-light [font-size:_clamp(0.5rem,0.3649rem+0.6757vw,0.9375rem)] font-normal">наш рейтинг <br>на
            Яндекс</p>
          <p class="[font-size:_clamp(1.3125rem,0.9457rem+1.834vw,2.5rem)] text-light font-normal">4,9</p>
        </li>

      </ul>

    </div>
  </footer>
  <!-- END::FOOTER -->

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <!-- Initialize Swiper -->
        <script>
            var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            centeredSlides: true,
            freeMode: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: false,
            },
            breakpoints: {
                640: {
                slidesPerView: 1,
                spaceBetween: 20,
                },
                768: {
                slidesPerView: 2,
                spaceBetween: 40,
                },
                1024: {
                slidesPerView: 3,
                spaceBetween: 50,
                },
            },
            });
            // Компонент формы
            const ContactForm = {
            submit(e) {
                e.preventDefault()
                // Логика отправки формы
            }
            }

            // Мобильное меню
            const MobileMenu = {
            toggle() {
                const menu = document.querySelector('.menu-items');
                if (menu) {
                menu.classList.toggle('hidden');
                }
            }
            }
            // Скрыть меню по умолчанию
            document.addEventListener('DOMContentLoaded', () => {
            const menu = document.querySelector('.menu-items');
            if (menu) {
                menu.classList.add('hidden'); // Добавлено: скрыть меню по умолчанию
            }
            });

            // DIALOG
            const dialogElem = document.getElementById("dialog");
            const showBtn = document.querySelector(".show");
            const closeBtn = document.querySelector(".close");

            showBtn.addEventListener("click", () => {
            dialogElem.showModal();
            });

            closeBtn.addEventListener("click", () => {
            dialogElem.close();
            });

        </script>
    </body>
</html>
