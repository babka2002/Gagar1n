@extends('grelka.layout')
@section('trainersContent')
    <section class="bg-dark pt-sectionPadding px-4">
        <div class="container text-light relative">
            <h1
            data-aos="zoom-in"
                class="text-light text-xl md:text-xxl leading-tight uppercase xl:absolute xl:max-w-[58%] right-0 -top-6 z-9 xl:text-right text-center">
                {{ $hero_title }}
                <span class="text-xl md:text-xxl block">{{ $hero_subtitle }}</span>
            </h1>
            <img
                {{-- src="{{ glide:data_url src='/assets/{{ $hero_image }}' quality='75' format='webp' }}" --}}
                src="<s:glide:data_url src='/assets/{{ $hero_image }}' quality='75' format='webp' />"
                alt=""
                class="trainer-hero-mask object-contain" />
        </div>
    </section>

    <section class="py-sectionPadding bg-light">
        <div class="px-4">
            @foreach ($trainersByDepartment as $departmentTitle => $trainers)
                <div class="container px-4">
                    <h2 class="arrow-title text-lg text-dark uppercase flex gap-6 items-center justify-center lg:justify-start text-center lg:text-left">
                        {{ $departmentTitle }}
                    </h2>
                </div>

                <div class="py-5">
                    <div class="swiper mySwiper2">
                        <div class="swiper-wrapper">
                            @if (count($trainers) > 0) <!-- Проверяем, есть ли тренеры в отделе -->
                                @foreach ($trainers as $trainer)
                                    <div class="swiper-slide">
                                        <div
                                            onclick="window.location='{{ route('trainers.show', ['slug' => $trainer->slug]) }}';"
                                            class="cursor-pointer bg-dark rounded-xl flex flex-col overflow-hidden">
                                            <div class="bg-neutral-800 relative overflow-hidden h-[392px] max-h-[392px]">
                                                {{-- <img src="{{ $trainer->photo }}" alt="{{ $trainer->name }} {{ $trainer->last_name }}" class="hover:scale-105 transition-all" /> --}}
                                                <img src="{{ $trainer->localPhotoPath }}" alt="{{ $trainer->name }} {{ $trainer->second_name }} {{ $trainer->last_name }}" class="hover:scale-105 transition-all" />
                                                <a href="{{ route('trainers.show', ['slug' => $trainer->slug]) }}" class="rounded-full bg-light p-4 absolute right-4 bottom-4 flex items-center justify-center hover:scale-110 transition-all">
                                                {{-- <a href="{{ route('trainers.show', ['employeeId' => $trainer->id]) }}" class="rounded-full bg-light p-4 absolute right-4 bottom-4 flex items-center justify-center hover:scale-110 transition-all"> --}}
                                                    <svg class="w-4 h-4" viewBox="0 0 30 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M23.4258 22.5555C21.4889 22.5555 19.9188 24.1256 19.9188 26.0625C19.9188 27.9994 21.4889 29.5695 23.4258 29.5695V22.5555ZM28.2989 28.5423C29.6685 27.1728 29.6685 24.9522 28.2989 23.5827L5.98041 1.26419C4.61084 -0.105382 2.39032 -0.105382 1.02075 1.26419C-0.348826 2.63376 -0.348826 4.85428 1.02075 6.22385L20.8594 26.0625L1.02075 45.9011C-0.348826 47.2707 -0.348826 49.4912 1.02075 50.8608C2.39032 52.2304 4.61084 52.2304 5.98041 50.8608L28.2989 28.5423ZM23.4258 29.5695H25.8191V22.5555H23.4258V29.5695Z" fill="#4F4E4E" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="p-2 lg:p-4 text-light">
                                                <h3 class="text-base leading-tight mb-2 text-left">
                                                    {{ $trainer->name }} {{ $trainer->last_name }}
                                                </h3>
                                                {{-- <p class="text-sm">{{ Str::words($trainer->description, 100, '...') }}</p>
                                                <p class="text-sm">Позиция: {{ $trainer->position->title }}</p> --}}
                                                <ul class="text-sm list-inside">
                                                    <li class="text-left text-sm mb-2">
                                                        <div class="markdown-content">
                                                            {!! $trainer->short_description !!}
                                                        </div>
                                                        {{-- {{ Str::words($trainer->description, 50, '...') }} --}}
                                                    </li>
                                                    <li class="text-right text-sm">
                                                        Позиция: {{ $trainer->position->title }}
                                                    </li>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Нет тренеров в этом отделе.</p> <!-- Сообщение, если нет тренеров -->
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach


            {{-- <div class="py-5">
                <!-- Swiper -->
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="bg-dark rounded-xl flex flex-col overflow-hidden">
                                <div class="bg-neutral-800 relative overflow-hidden h-[392px] max-h-[392px]">
                                    <img
                                        src="<s:glide:data_url src='/assets/img/trainer-1.png' quality='75' format='webp' />"
                                        alt="" class="hover:scale-105 transition-all" />
                                    <a href="#"
                                        class="rounded-full bg-light p-4 absolute right-4 bottom-4 flex items-center justify-center hover:scale-110 transition-all"><svg
                                            class="w-4 h-4" viewBox="0 0 30 52" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M23.4258 22.5555C21.4889 22.5555 19.9188 24.1256 19.9188 26.0625C19.9188 27.9994 21.4889 29.5695 23.4258 29.5695V22.5555ZM28.2989 28.5423C29.6685 27.1728 29.6685 24.9522 28.2989 23.5827L5.98041 1.26419C4.61084 -0.105382 2.39032 -0.105382 1.02075 1.26419C-0.348826 2.63376 -0.348826 4.85428 1.02075 6.22385L20.8594 26.0625L1.02075 45.9011C-0.348826 47.2707 -0.348826 49.4912 1.02075 50.8608C2.39032 52.2304 4.61084 52.2304 5.98041 50.8608L28.2989 28.5423ZM23.4258 29.5695H25.8191V22.5555H23.4258V29.5695Z"
                                                fill="#4F4E4E" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="p-2 lg:p-4 text-light">
                                    <h3 class="text-base leading-tight mb-2 text-left">
                                        Екатерина Кайгородцева
                                    </h3>
                                    <ul class="text-sm list-disc list-inside">
                                        <li class="text-right text-sm">
                                            восстановление после родов и травм
                                        </li>

                                        <li class="text-right text-sm">
                                            боли в спине
                                        </li>

                                        <li class="text-right text-sm">
                                            набор мышечной массы и похудение
                                        </li>

                                        <li class="text-right text-sm">
                                            мобильность суставов
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div> --}}

        </div>
    </section>

    <section class="py-sectionPadding px-4 bg-light">
        <div class="container">
            <div class="">
                <h2 class="text-dark text-xl md:text-xxxl uppercase leading-tight mb-6" data-aos="zoom-in">
                    {{ $cta_title }}
                </h2>

                <div data-dialog="dialog-more" class="show cursor-pointer rounded-brxl bg-dark text-light p-[clamp(1rem,0.4127rem+2.6104vw,2.625rem)]"  data-aos="zoom-in">
                    <div class="max-h-[409px] object-center object-cover overflow-hidden rounded-brxl mb-6">
                        <img
                            {{-- src="{{ glide:data_url src='/assets/{{ $cta_image }}' quality='75' format='webp' }}" --}}
                            src="<s:glide:data_url src='/assets/{{ $cta_image }}' quality='75' format='webp' />"
                            alt=""
                            class="" />
                    </div>
                    <div class="grid grid-cols-3 gap-2 justify-between items-center">
                        <p class="text-base md:text-lg col-span-2 hyphens-manual">
                            {{ $cta_subtitle }} <br />
                            {{ $cta_subtitle_highlight }}
                        </p>
                        <a href="{{ $cta_link }}"
                            class="ml-auto col-span-1 flex items-center justify-center w-[clamp(3rem,1.6672rem+5.9237vw,6.6875rem)] h-[clamp(3rem,1.6672rem+5.9237vw,6.6875rem)] transition-all hover:scale-110">
                            <svg width="100%" height="100%" viewBox="0 0 108 108" class=""
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="53.7238" cy="53.7238" r="53.7238" class="fill-[#FFF8F8]" />
                                <path
                                    d="M76.1914 48.7157C73.425 48.7157 71.1825 50.9582 71.1825 53.7246C71.1825 56.491 73.425 58.7336 76.1914 58.7336V48.7157ZM83.1521 57.2665C85.1082 55.3104 85.1082 52.1389 83.1521 50.1827L51.2753 18.306C49.3192 16.3499 46.1477 16.3499 44.1916 18.306C42.2355 20.2621 42.2355 23.4336 44.1916 25.3897L72.5265 53.7246L44.1916 82.0595C42.2355 84.0156 42.2355 87.1871 44.1916 89.1432C46.1477 91.0993 49.3192 91.0993 51.2753 89.1432L83.1521 57.2665ZM76.1914 58.7336H79.6102V48.7157H76.1914V58.7336Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4 my-5 lg:my-14">
                <div
                    onclick="window.location='{{ $academy_link }}';"
                    class="cursor-pointer col-span-3 text-light bg-main-red rounded-brxl p-[clamp(1rem,0.4127rem+2.6104vw,2.625rem)] grid grid-cols-1 lg:gap-9 lg:grid-cols-3 items-center" data-aos="fade-right">
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <h3 class="text-base md:text-lg leading-tight uppercase mb-5">
                            {{ $academy_title }}
                        </h3>
                        <p class="text-light text-sm md:text-base">
                            <span class="text-sm md:text-md block">{{ $academy_subtitle_dash }}</span>
                            {{ $academy_description }}
                        </p>
                    </div>
                    <div class="col-span-1 rounded-brxl overflow-hidden">
                        <img
                            {{-- src="{{ glide:data_url src='/assets/{{ $academy_image }}' quality='75' format='webp' }}" --}}
                            src="<s:glide:data_url src='/assets/{{ $academy_image }}' quality='75' format='webp' />"
                            alt="" />
                    </div>
                </div>
                <a href="{{ $academy_link }}" data-aos="fade-left"
                    class="bg-dark rounded-brxl text-light flex items-center justify-center transition-all hover:scale-105">
                    <svg class="h-[clamp(3rem,0.9217rem+9.2369vw,8.75rem)] fill-[#fff8f8]" viewBox="0 0 80 140" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M63.7812 60.4893C58.5427 60.4893 54.296 64.736 54.296 69.9746C54.296 75.2132 58.5427 79.4599 63.7812 79.4599V60.4893ZM77.1281 76.6817C80.8323 72.9775 80.8323 66.9717 77.1281 63.2675L16.764 2.90346C13.0598 -0.800781 7.05404 -0.800781 3.3498 2.90346C-0.354435 6.60769 -0.354435 12.6134 3.3498 16.3177L57.0067 69.9746L3.3498 123.632C-0.354435 127.336 -0.354435 133.342 3.3498 137.046C7.05404 140.75 13.0598 140.75 16.764 137.046L77.1281 76.6817ZM63.7812 79.4599H70.421V60.4893H63.7812V79.4599Z" />
                        </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Форма записи -->

    <section class="bg-dark">
        <div class="container grid grid-cols-1 items-center px-4 lg:grid-cols-3 gap-y-5 lg:gap-24 py-sectionPadding">
            <div class="col-span-2">
                <h3 class="text-xl md:text-xxl leading-none uppercase mb-7 text-light max-w-full md:max-w-[60%]" data-aos="zoom-in">
                    {{ $form_title }}
                </h3>

                <form id="contact-form" action="" method="get" class="flex flex-col gap-5" data-aos="zoom-in" data-aos-delay="1000">
                    <div>
                        <input type="text" placeholder="{{ $form_name_placeholder }}"
                            class="w-full px-[clamp(0.625rem,0.2636rem+1.6064vw,1.625rem)] py-[clamp(0.5rem,0.3193rem+0.8032vw,1rem)] bg-light rounded-brxl focus:outline-none focus:ring-2 focus:ring-red-600"
                            required />
                    </div>
                    <div>
                        <input type="tel" placeholder="{{ $form_phone_placeholder }}"
                            class="w-full px-[clamp(0.625rem,0.2636rem+1.6064vw,1.625rem)] py-[clamp(0.5rem,0.3193rem+0.8032vw,1rem)] bg-light rounded-brxl focus:outline-none focus:ring-2 focus:ring-red-600"
                            required />
                    </div>
                    <button type="submit"
                        class="w-full text-light px-[clamp(0.625rem,0.2636rem+1.6064vw,1.625rem)] py-[clamp(0.5rem,0.3193rem+0.8032vw,1rem)] bg-red-600 hover:bg-red-700 transition rounded-brxl">
                        {{ $form_button_text }}
                    </button>
                    <p class="text-sm text-center text-light">
                        {{ $form_privacy_text }}
                    </p>
                </form>
            </div>
            <div class="col-span-1" data-aos="zoom-in">
                <img
                    {{-- src="{{ glide:data_url src='/assets/{{ $form_image }}' quality='75' format='webp' }}" --}}
                    src="<s:glide:data_url src='/assets/{{ $form_image }}' quality='75' format='webp' />"
                    alt=""
                    class="block w-full mx-auto rounded-brxl" />
            </div>
        </div>
    </section>
@endsection
