@extends('layout')
@section('fitness')
<section class="py-sectionPadding">
    <div class="container px-4">
        <div style="background-image: url({{ $first_bg }})"
            class="bg-no-repeat bg-top bg-cover flex items-start justify-center rounded-brxl overflow-hidden h-[625px] relative">
            <h1 class="text-lg md:text-xxl uppercase text-light rounded-b-brxl bg-dark px-4 md:px-24 py-0 text-center invert-border-crossfit hyphens-auto z-9">
                {{ $first_title }}
            </h1>
        </div>

        <div class="text-light pt-sectionPadding">
            <div class="flex items-center justify-around leading-none">
                <div class="flex flex-col items-center justify-center">
                    <span class="text-xxxl lg:text-[clamp(3.3125rem,0.805rem+11.1446vw,10.25rem)]" data-aos="zoom-in">{{ $zal }}</span>
                    <span class="md:text-lg" data-aos="zoom-out">{{ $zal_text ?? 'ЗАЛА' }}</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <span class="text-xxxl lg:text-[clamp(3.3125rem,0.805rem+11.1446vw,10.25rem)]" data-aos="zoom-in">{{ $napravlenie }}</span>
                    <span class="md:text-lg" data-aos="zoom-out">{{ $napravlenie_text ?? 'НАПРАВЛЕНИЙ' }}</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <span class="text-xxxl lg:text-[clamp(3.3125rem,0.805rem+11.1446vw,10.25rem)]" data-aos="zoom-in">{{ $trenerov }}</span>
                    <span class="md:text-lg" data-aos="zoom-out">{{ $trenerov_text ?? 'ТРЕНЕРОВ' }}</span>
                </div>
            </div>
        </div>

        <div class="pt-sectionPadding">
            <a href="#" data-aos="zoom-in"
                class="rounded-brxl bg-main-red w-full py-6 px-4 flex items-center justify-center text-center text-light text-base md:text-md uppercase transition-all hover:scale-90">
                {{ $knopka_tekst }}
            </a>
        </div>
    </div>
</section>

<section class="py-sectionPadding bg-light">
    <div class="container text-dark px-4">
        @foreach($tipy_blok as $index => $blok)
            <details data-aos="zoom-in">
                <summary>
                    <div class="flex items-center gap-6 relative overflow-hidden text-dark">
                        <img src="<s:glide:data_url src='{{ $blok->tipy_blok_image }}' quality='75' format='webp' />"
                             alt="{{ $blok->tipy_blok_title }}"
                             class="{{ $index == 0 ? 'flex-1' : 'flex-1 lg:flex-2' }}" />

                        <p class="text-lg md:text-xl uppercase leading-none absolute right-4 bottom-4 text-right text-light lg:bottom-0 lg:right-0 lg:relative lg:text-dark lg:text-left">
                            {!! $blok->tipy_blok_title !!}
                        </p>
                    </div>
                </summary>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
                    @php
                        $columns = [[], [], [], []];
                        foreach ($blok->tipy_blok_napravleniya as $key => $napravlenie) {
                            $columns[$key % 4][] = $napravlenie;
                        }
                    @endphp

                    @foreach($columns as $column)
                        <div class="col-span-1 text-sm flex flex-col gap-4">
                            @foreach($column as $napravlenie)
                                <div class="flex flex-col relative bg-[#7E2020] rounded-[1em] overflow-hidden">
                                    <div class="px-4 py-8 relative gap-4 bg-main-red/80 rounded-b-[1em]">
                                        @if($napravlenie->rubl)
                                            <a href="#" class="flex items-center justify-center absolute top-3 left-3">
                                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g clip-path="url(#clip0_134_2358)">
                                                        <rect width="32" height="32" fill="url(#pattern0_134_2358)" />
                                                        <circle cx="15.5" cy="16.5" r="11.5" stroke="white" stroke-width="4" />
                                                    </g>
                                                    <defs>
                                                        <pattern id="pattern0_134_2358" patternContentUnits="objectBoundingBox"
                                                            width="1" height="1">
                                                            <use xlink:href="#image0_134_2358" transform="scale(0.0111111)" />
                                                        </pattern>
                                                        <clipPath id="clip0_134_2358">
                                                            <rect width="32" height="32" fill="white" />
                                                        </clipPath>
                                                        <image id="image0_134_2358" width="90" height="90"
                                                            xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEYUlEQVR4nO2dO4yVRRTHj4ACarAzwEJ8gA3EBrXCBxi0MfGR+EhAEh5CISSAQGyNFRpDyCYWFlYWSIHro8BorDUGs8JSQLFAwUPZZRcrdyPLz5zcY7Ka/ZZd75z5Zr5vfsnX3Hxz73/+uXe+mTNnzhUpFAqFQqFQKBQKhcLMAOYCTwDbgQ+BL4HTwCAwAozbNWKvnbZ7PrA2j+t7zPDj2gWwDNgLfAP8QffcAL4G9gA90maAhcBm4HtgAj9uAt8BbwILpC0A99o37TLxuQa8B9wnTQW4EzgIXKd+VMN+1SRNAngKGCA9zgIbJHd0TAQ+Bm6RLqqtF5gvOQI8CPxEPvwCrJSc0J9joGlabHRa+KzkAPAK8Cf5Mg68ISkD7HSeE8dC+7BDUgR42RYHTWECeF1SQsc1YIzmMQ48LykAPJLpg282D8gVdZs836ZFTedkrfNsW4y0hd46l9Upr/hCo319JrbJ84BTtI+BqIEoi8K1lX0x48nDtJdh9SCG0e/W3dME2B9j++k3zx7I7DXNAe4HHrUQQB/wl6dG4Irrtpjt8bkiYXSuBI45S90UQmtVB3Qj1RUJq3e347f725BaJ4vuiRE0kvC6NY3BK+gUPpXBUfC/CC68o10TbDzY7SFWk1vckerPH5zi0hjEcY0dA3dP03a1U5y8z2MlqFEsd6Raw+04Bzw8TfsfHOSOBE0/s1w4EjcaiyTOibyafSyk0Zo8mIPRytMV7dfjw9aQRmtWZy5GH6hov8pJ8qGQRn9FPka/X9F+uZPkcA/EmCFR6d7oXRXt1zhJ7g9p9AXyMPqWDhEV7V90knw+pNHDmRj92TTtDztJHgpptG67p2z0BPCpRhcr2t5h82wPxppm9CdTXB8Bb0+3ULG2rzpKHmvU0PF/Ae6xPGhyGDouEgkJiA0ZnztLPp/09E6c0SATcBR/+pMOM4ojwAvAGeLwRdJLcAmblrbcEnr0xFU/cTnU1qBSbLa0MUxaB2tCn88ejaFa8jJ6NPi5cztbHQwJp6tOwj0IJ3VIjxUHQ8LpqpMpI4XddmhpyHQDCaerLtSLxaH68d9OaZUAVyQ9Q6s44WJy3SlhpMdG77PdruUfJA+jr1aFZLNJQpc8jH7H1eRJYcehFhs9HCUR3TqtRUXaavSeKCZPShH7lfYxEL1qDfBkOf4WCavc0haOxPK1KhasqbNN52fgrtqMNrNXxErprTFC95CkALAu86ozVWiaxXOSEsBLDSyM8pqkiB1xaEKpn5vAW5IyVvIn52FkLLkSP7cp/XMj0wffOskJ4AHgR/LhZO0lfbqcZ/cmvoJUbUdqnycHXK6fIj1U01ppEnQCUfs8Q6yzYMg2m+dJU6ETz9ZOXqrB4N8tbWyRtAU622KbtEqA80JH3/uE7vG1qvT8VABLrORDnx377ZYRe69dbikBuUMn/UyPqm3TTE3NBrIM0UErGf/P34Nct9f67R69d6u1LX8PUigUCoVCoVAoFAoyQ/4GeK/7aAMlfmAAAAAASUVORK5CYII=" />
                                                    </defs>
                                                </svg>
                                            </a>
                                        @endif
                                        <h3 class="text-light text-lg leading-none uppercase text-center px-4 pt-2 hyphens-auto">
                                            {!! $napravlenie->tipy_blok_napravleniya !!}
                                        </h3>
                                    </div>
                                    <div class="px-4 py-8">
                                        <p class="text-light mb-3 text-sm hyphens-auto leading-[1.6]">
                                            {!! $napravlenie->tipy_blok_napravleniya_text !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </details>
        @endforeach
    </div>
</section>

<section class="py-sectionPadding">
    <div class="container px-4">
        <h2 class="text-lg md:text-xxl text-center uppercase mb-5 text-light" data-aos="zoom-in">
            {{ $third_block_title }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6" data-aos="zoom-in">
            <a href="{{ $left_link }}" class="rounded-brxl relative group overflow-hidden max-h-80 flex text-light">
                <img src="<s:glide:data_url src='{{ $left_image }}' quality='75' format='webp' />" alt=""
                    class="group-hover:scale-125 group-hover:opacity-90 transition-all object-cover opacity-35 w-full" />

                <div class="flex items-center justify-center absolute bottom-5 right-5 gap-6 text-lg md:text-xl lg:text-xxl uppercase group-hover:scale-105 transition-all">
                    {{ $left_title }}
                    <span class="w-[80px] h-[80px] p-4 rounded-full bg-light flex items-center justify-center">
                        <svg width="100%" height="100%" viewBox="0 0 42 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M34 31.9911C31.2336 31.9911 28.9911 34.2336 28.9911 37C28.9911 39.7664 31.2336 42.0089 34 42.0089V31.9911ZM40.5419 40.5419C42.498 38.5857 42.498 35.4143 40.5419 33.4581L8.66511 1.58139C6.70899 -0.374729 3.5375 -0.374729 1.58139 1.58139C-0.374729 3.5375 -0.374729 6.70899 1.58139 8.66511L29.9163 37L1.58139 65.3349C-0.374729 67.291 -0.374729 70.4625 1.58139 72.4186C3.5375 74.3747 6.70899 74.3747 8.66511 72.4186L40.5419 40.5419ZM34 42.0089H37V31.9911H34V42.0089Z" fill="#1E1E1E"/>
                        </svg>
                    </span>
                </div>
            </a>
            <a href="{{ $right_ssylka }}" class="rounded-brxl relative group overflow-hidden max-h-80 flex text-light">
                <img src="<s:glide:data_url src='{{ $right_kartinka }}' quality='75' format='webp' />" alt=""
                    class="group-hover:scale-125 group-hover:opacity-90 transition-all object-cover opacity-35 w-full" />


                <div class="flex items-center justify-center absolute bottom-5 right-5 gap-6 text-lg md:text-xl lg:text-xxl uppercase group-hover:scale-105 transition-all">
                    {{ $right_zagolovok }}
                    <span class="w-[80px] h-[80px] p-4 rounded-full bg-light flex items-center justify-center">
                        <svg width="100%" height="100%" viewBox="0 0 42 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M34 31.9911C31.2336 31.9911 28.9911 34.2336 28.9911 37C28.9911 39.7664 31.2336 42.0089 34 42.0089V31.9911ZM40.5419 40.5419C42.498 38.5857 42.498 35.4143 40.5419 33.4581L8.66511 1.58139C6.70899 -0.374729 3.5375 -0.374729 1.58139 1.58139C-0.374729 3.5375 -0.374729 6.70899 1.58139 8.66511L29.9163 37L1.58139 65.3349C-0.374729 67.291 -0.374729 70.4625 1.58139 72.4186C3.5375 74.3747 6.70899 74.3747 8.66511 72.4186L40.5419 40.5419ZM34 42.0089H37V31.9911H34V42.0089Z" fill="#1E1E1E"/>
                        </svg>
                    </span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Форма записи -->
<section class="">
    <div class="container grid grid-cols-1 items-center px-4 lg:grid-cols-3 gap-y-5 lg:gap-24 py-sectionPadding">
        <div class="col-span-2">
            <h3 class="text-xl md:text-xxl leading-none uppercase mb-7 text-light max-w-full md:max-w-[60%]"
                data-aos="zoom-in">
                {{ $forma_title }}
            </h3>

            <div class="" data-aos="fade-in" data-aos-delay="1000">
                @csrf
                <form id="mainContactForm">
                    <div>
                        <input type="text" id="name" name="name" autocomplete="name" placeholder="ИМЯ"
                            class="w-full px-[clamp(0.625rem,0.2636rem+1.6064vw,1.625rem)] py-[clamp(0.5rem,0.3193rem+0.8032vw,1rem)] bg-light rounded-brxl focus:outline-none focus:ring-2 focus:ring-red-600"
                            required />
                    </div>
                    <div>
                        <input type="tel" id="phone" name="phone" autocomplete="tel" placeholder="НОМЕР ТЕЛЕФОНА"
                            class="w-full px-[clamp(0.625rem,0.2636rem+1.6064vw,1.625rem)] py-[clamp(0.5rem,0.3193rem+0.8032vw,1rem)] bg-light rounded-brxl focus:outline-none focus:ring-2 focus:ring-red-600 my-2"
                            required />
                    </div>
                    <button type="submit"
                        class="w-full text-light px-[clamp(0.625rem,0.2636rem+1.6064vw,1.625rem)] py-[clamp(0.5rem,0.3193rem+0.8032vw,1rem)] bg-red-600 hover:bg-red-700 transition rounded-brxl">
                        СТАТЬ БЛИЖЕ К СВОЕЙ ЦЕЛИ
                    </button>

                    <!-- Согласие на обработку ПД -->
                    <div class="mt-4 flex items-start gap-3">
                        <input
                            type="checkbox"
                            id="privacy-consent-fitness"
                            name="privacy_consent"
                            required
                            class="mt-1 w-5 h-5 text-main-red border-gray-300 rounded focus:ring-main-red"
                        />
                        <label for="privacy-consent-fitness" class="text-sm text-light leading-relaxed">
                            Я согласен(а) на обработку персональных данных и принимаю условия <a href="https://new.gagar1n.ru/policy" target="_blank" class="underline hover:no-underline">политики конфиденциальности</a>
                        </label>
                    </div>

                    <!-- Индикатор состояния -->
                    <div id="formStatus" class="mt-4 p-4 rounded-lg hidden">
                        <p class="text-center"></p>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-span-1" data-aos="zoom-in">
            <img src="<s:glide:data_url src='{{ $form_bg }}' quality='75' format='webp' />" alt="" class="block w-full mx-auto rounded-brxl" />
        </div>
    </div>
</section>
@endsection
