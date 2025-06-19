@extends('grelka.layout')
@section('scheduleContent')
{{-- <s:locales:ru> --}}
    <section class="py-sectionPadding px-4">
        <div class="container grid grid-cols-12 gap-5 items-center">
            <div class="col-span-12 md:col-span-9 flex gap-2">
                <!-- Кнопка групповых тренировок -->
                <a
                    href="{{ route('schedule.show', array_merge(request()->except('schedule_type'), ['schedule_type' => 'classes'])) }}"
                    class="rounded-brxl bg-main-red w-1/2 py-4 md:py-12 px-4 flex items-center justify-center text-center text-light text-sm md:text-md uppercase transition-all hover:scale-90 {{ $scheduleType === 'classes' ? 'opacity-100' : 'opacity-70' }}"
                >
                    <span>Групповые тренировки</span>
                </a>

                <!-- Кнопка индивидуальных тренировок -->
                <a
                    href="/personal-training"
                    class="rounded-brxl bg-main-red w-1/2 py-4 md:py-12 px-4 flex items-center justify-center text-center text-light text-sm md:text-md uppercase transition-all hover:scale-90 {{ $scheduleType === 'personal' ? 'opacity-100' : 'opacity-70' }}"
                >
                    <span>Индивидуальные тренировки</span>
                </a>
                {{-- <a
                    href="{{ route('schedule.show', array_merge(request()->except('schedule_type'), ['schedule_type' => 'personal'])) }}"
                    class="rounded-brxl bg-main-red w-1/2 py-4 md:py-12 px-4 flex items-center justify-center text-center text-light text-sm md:text-md uppercase transition-all hover:scale-90 {{ $scheduleType === 'personal' ? 'opacity-100' : 'opacity-70' }}"
                >
                    <span>Индивидуальные тренировки</span>
                </a> --}}
            </div>
            <div class="col-span-12 md:col-span-3">
                <a
                    href="/fitness"
                    class="rounded-brxl bg-main-red w-full py-2 px-4 flex items-center justify-center text-center text-light text-sm md:text-md uppercase transition-all hover:scale-90"
                >
                    <span class="mr-2"> описание групповых тренировок </span>
                    <svg
                        class="w-[32px] h-[32px] md:w-full md:h-full"
                        viewBox="0 0 76 76"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <circle cx="37.79" cy="37.79" r="37.79" fill="#1E1E1E" />
                        <path
                            d="M53.5938 34.2657C51.6479 34.2657 50.0704 35.8432 50.0704 37.7891C50.0704 39.735 51.6479 41.3124 53.5938 41.3124V34.2657ZM58.49 40.2805C59.8659 38.9045 59.8659 36.6736 58.49 35.2977L36.0674 12.8751C34.6915 11.4992 32.4606 11.4992 31.0846 12.8751C29.7087 14.2511 29.7087 16.482 31.0846 17.8579L51.0158 37.7891L31.0846 57.7202C29.7087 59.0962 29.7087 61.327 31.0846 62.703C32.4606 64.0789 34.6915 64.0789 36.0674 62.703L58.49 40.2805ZM53.5938 41.3124H55.9986V34.2657H53.5938V41.3124Z"
                            fill="#4F4E4E"
                        />
                    </svg>
                </a>
            </div>

            <div class="col-span-2 h-full flex w-full md:w-auto">
                <a
                    href="#"
                    class="rounded-brxl p-2 bg-light flex items-center justify-center flex-col text-base md:text-xl hover:opacity-80 transition-all"
                >
                    <svg
                        class="w=[24px] h-[24px] md:w-[61px] md:h-[86px]"
                        viewBox="0 0 61 86"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                    >
                        <rect
                            width="61"
                            height="86"
                            fill="url(#pattern0_202_5913)"
                        />
                        <defs>
                            <pattern
                                id="pattern0_202_5913"
                                patternContentUnits="objectBoundingBox"
                                width="1"
                                height="1"
                            >
                                <use
                                    xlink:href="#image0_202_5913"
                                    transform="matrix(0.0111111 0 0 0.00788114 0 0.145349)"
                                />
                            </pattern>
                            <image
                                id="image0_202_5913"
                                width="90"
                                height="90"
                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEQ0lEQVR4nO2dTYiWVRTHf41J2ow25VibxqAW46B9rHKVJZEpgmahJYgbR9tFm6CCRARRW2WbyEULiWqKEMGNX1AiiKaTLSodNcrGSShFMOxD6MjF42ZonPfjueee53nuD/4wDPO+zzn/ue997nPuxwuZTCaTyWQydaYXWAVsAgaBb4FzwGXgH9Vl/d0Q8Jn+7Sv62sw4TAIWAjuAM4C0qfAeHwLPAR3jXbROzAK2ASMFmDuewntv1WvVjoeB7cDfEQ0eq3+BncBsakCntq7rhgaP1XX9J0+norwEXEho8P91KcupEHdpCxKnCt3JVErOQzo0E+caKvOwsB8478BEaVCjwGOUjHnAJQfmSZMKMT9JSZhTUpNFdaUMLftB4BcHZkkBI5Jwf3E7uhhyYJIUpO+AKTjkAwfmSMF6H4cPI1JRLcMJ0yIXhSSxfgW6cMB7DsyQyHo3tcl9iQtEYlj5eySl0R85MEGMFCYlktCrU0qpDRDDVp1kbL3NQfJirC3WJnfo3VhqphGd3zRjoYOkJZGetTR6h4OEJZHCE7AZZ42T2wsM6HCyUxUmWdcB+4xjOW1l8izDpE4BTzUQ03w1wCquUKWMziqjZL4CupuI617ga6PYXsaATUYtubuF2ILZwwbxbcSAQYNEnmkjvvkG8X2CAbGL+/sKiPFA5BiPY8DPkZNYW0CM6yPH+BMG/BE5ib4CYpwdOcbfMSB2IamrgBi7IscYFmdG568SGD09cozXMOBiCbqO/sgx/oYBpyInMVBAjK9GjvEHDDgaOYn9BcR4MHKMRzDg08hJCLCgjfieNojvYwx40yCRc0BPC7HdV9Bmo4n0BgYsNkhEtEAUahfNmHzIKLbnMeAB4D+jhIYbrHssMGrJornfjxHHjZIS1QF9rO7XcXaX/rze4MY3Vscw5B3j5MSR3rI0+lEHCUsihU+SKcccJC3G+oYErHaQuBgrbOo3Z3LNFtGMaM5JeN2BAWKk10jIZONpfkmkH1O25lssdWCERFZ4GnbBLgdmSCR9gSN6tBguFdMoMANnLDGsgYiBQi6LcIrFKiYx0gYcc4fRSiaJrC81F9d06lSPlFSHgbspCfckKKVKATrZ5GSDC2bqxnUpkcmtTJ+5oFs/iuJcRz0O41rps/c4MHM87S5TnzwRk/S8O3Gm7dbb2axYA/zpwOCrWk+vNH1640ll8vfAXGrClESHDu6sUn/cDMsNVqeKFrxeoOZ061nPsUz+vMzj4xis1FPOizI4vNeK1El5pbegXV8nynzWqBU9bW7KDAvlc1fRIE+0eFp62F/zeKMXydxkSwtGb9bXZpo8T2+0CZMvVvk4+dgMGG8yqi13NrjsLOlyrarwdgNGh301mTbpmWC37rUqFO29MHgbo8N2vExBvHgboyv1XSqpmapn7481+UoVvkPFGxvLtpqorHSosedVYWdY/gq9TCZDhbkB9a4D7gPF080AAAAASUVORK5CYII="
                            />
                        </defs>
                    </svg>
                <span class="-rotate-90 md:rotate-0 mt-2 ">где</span>
                </a>
            </div>
            <div class="col-span-10">
                <div class="flex flex-wrap gap-2">
                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="тренажерный зал"
                        >тренажерный зал</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="зона кроссфита"
                        >зона кроссфита</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="ринг"
                        >ринг</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="зона йоги"
                        >зона йоги</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="зал пилатеса"
                        >зал пилатеса</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="сайкл студия"
                        >сайкл студия</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="зал для групповых занятий №1"
                        >зал для групповых занятий №1</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="зал для групповых занятий №2"
                        >зал для групповых занятий №2</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="аква зона"
                        >аква зона</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="малый бассейн"
                        >малый бассейн</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="зал единоборств KIDS"
                        >зал единоборств KIDS</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="эстетический зал KIDS"
                        >эстетический зал KIDS</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="студия ИНТЕЛЛЕКТ KIDS"
                        >студия ИНТЕЛЛЕКТ KIDS</a
                    >

                    <a
                        href="#"
                        class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-0 px-2 transition-all hover:text-dark hover:bg-light filter-item"
                        data-filter="студия КРЕАТИВ KIDS"
                        >студия КРЕАТИВ KIDS</a
                    >
                </div>
            </div>
            <div class="col-span-12 flex flex-wrap items-center  gap-2">
                <a
                    href="#"
                    class="inline-flex items-center justify-center border border-light rounded-xl py-2 px-2 transition-all text-dark bg-light leading-none gap-2 text-sm"
                >
                    <svg
                        width="31"
                        height="31"
                        viewBox="0 0 31 31"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                    >
                        <rect
                            x="0.632812"
                            y="0.367188"
                            width="29.7676"
                            height="29.7676"
                            fill="url(#pattern0_202_5873)"
                        />
                        <defs>
                            <pattern
                                id="pattern0_202_5873"
                                patternContentUnits="objectBoundingBox"
                                width="1"
                                height="1"
                            >
                                <use
                                    xlink:href="#image0_202_5873"
                                    transform="scale(0.0111111)"
                                />
                            </pattern>
                            <image
                                id="image0_202_5873"
                                width="90"
                                height="90"
                                xlink:href="data:image/png;base64,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"
                            />
                        </defs>
                    </svg>
                    возраст
                </a>

                <a
                    href="#"
                    class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-2 px-4 transition-all hover:text-dark hover:bg-light"
                    data-age-filter="любые"
                    >ЛЮБЫЕ</a
                >

                <a
                    href="#"
                    class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-2 px-4 transition-all hover:text-dark hover:bg-light"
                    data-age-filter="взрослые"
                    >ВЗРОСЛЫЕ</a
                >

                <a
                    href="#"
                    class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-2 px-4 transition-all hover:text-dark hover:bg-light"
                    data-age-filter="детские"
                    >ДЕТСКИЕ</a
                >

                <a
                    href="#"
                    class="text-sm inline-flex items-center justify-center border border-light rounded-xl py-2 px-2 transition-all text-dark bg-light leading-none gap-2 text-base"
                >
                    <svg
                        width="32"
                        height="32"
                        viewBox="0 0 32 32"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                    >
                        <rect
                            x="0.3125"
                            y="0.203125"
                            width="31.4149"
                            height="31.4149"
                            fill="url(#pattern0_202_5869)"
                        />
                        <defs>
                            <pattern
                                id="pattern0_202_5869"
                                patternContentUnits="objectBoundingBox"
                                width="1"
                                height="1"
                            >
                                <use
                                    xlink:href="#image0_202_5869"
                                    transform="scale(0.0111111)"
                                />
                            </pattern>
                            <image
                                id="image0_202_5869"
                                width="90"
                                height="90"
                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFIUlEQVR4nO2dO2xcRRSGJ8S8EVTG2Dv/P2ZZGkc0MVS8AgIaJB4SD4mAFB6hIJHCU7SIChBCkSUKCioKoAAHKIKCqEHICEIooAhQEF6xHVNhhO2LjjyRYOVdr7NzZubuzicdyfLurM/8Gs+dOXPmrDGFQqFQKBQKhUKhUOiZ7dbaa0g+CuAVkodIfkPyOMlFAH+Lyc/+d/LaIQAv+zZXy2f0/ueGiEajYQE8CeAjAH+SrPoxAEskPwRwwFrbMMOMtfZ8kg+R/ITkar/idrEVkkdIPuicO88MC6OjoxfJSCN5QlHcTvYHgBeazeYlZlCZnp4+m+RzJBcSCNxuC865Z8QnM0gAuJ7ksQwEbp/LvyN5i6k7MieSfJ3kWmpRu9gagJlWq3WuqSPOuUmSn2cgZNXj6P7SWtsydUL+HUMs0xhfbFkW3mzqgHPubgB/pRaNZy62bIjuNzlD8nHlNXEVyaQPe02OWGvv8puD1CJVocQGcJ/JCZnXACxnIE6lMI3cZnKg0WhcWccHH3sXewnAFUlFlrWnLItSi0F9m0u6zvabkdQiVJFG9kzKbXXOO74qsK1Za2+MrfMIyaMZdL6KbMeiBqJ8FK4aRgPwVLR4Msn51B1mOpsXDdSFJvl8Bp2tUprEstWPnwD8ptkJs3XOajabl1prr/IhgFmS/2j6COAX1WMxf8anOlpMACTcSfJdZV93Gy38QWr2Qp+G5H7F0f2x0UCO7WMEjUxgJI1ByddVlVQGRYcrTaEFn4Sj4e/+4M5KcktKobmeldRucwDek9jx+Pj4BV1836EUJ58NrfOIP+ZJKXS1iX1PstlF7E8V/F0Mmn7mc+GqzIWuJJIoy73Iu9npYEJL8mAdhCZZWWtv2Ki9c+4mDX+ttQ8HE9pnddZCaJLPdmg/peTzS8GEJvlBXYQG8OJG7ScmJqDkc7gHYsyQqOlTaJL7OrTfqeEvgK+CCQ3gx5oIvSZTRIc+3KEk9A/BhI4ZFjV9CA3grS7tX1Py+WQwof1VhpyFXgXwpkQXOzTf5tfZGiN6edCEfqPdALxqrX2i20bFt71Hy9+gQucwdZwpY2NjF/o86KoOU8dPNRV6G8l3NP0N/TAMvrwzykiQieTb2gMj6PJOI8xoFCF5O8lvY/wHAng/6y24CYSkasmuTxJ65MaVjLAYAmttwWsTVGJkA7Bn6MKkTGM7gwktwW0Ap4rQbB/Np4LfO5e71TFG7lZJPG2EexCexl8rLkJz80hhv0JPhEw3MPUf0SvOuctC9aO9U0e0O2DyE7STHVYROXVKGNML+z9zzj2gfbf7xLALDeDXLiHZeiShm3oI/bTRRsKOEhocYqHnoySiC5KIPaxCAzhgIiIpYl+n7jQH/bKQAOC6cv0tEnLJMYNRVkWygyYVEguW1NkMRKiU7YupqalzTErkQnqslF4mMB+1vNzkgHNuV52rzrB7GYlbTU4AuHPQCqOQvNfkiFxxGJBSPyskHzM5IyV/6jyNAFjOrsTPJqV/lur44HPO7TJ1YnJy0gH4LLV47N3mkpf06bMU0EzmO0jx7WDydXLA7frRDERtN/HpWjNgjEhREc0Q6xbspI/CjZhBZWw9jVZO1H+OLTCA3yVtrNVqXWyGBbd+LLZbqgQob3Tksw/LGd9QlZ7fCJLjvuTDrP82in7FXfSftU8tJWAA2C75bM65RyRTU7KBfIaoXLJf+M/Xg0gJ++PymrxH3iu3WH0uXPl6kEKhUCgUCoVCoVAwPfIvwNIrwiF10UMAAAAASUVORK5CYII="
                            />
                        </defs>
                    </svg>
                    СТОИМОСТЬ
                </a>

                <a
                    href="#"
                    class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-2 px-4 transition-all hover:text-dark hover:bg-light"
                    data-cost-filter="неважно"
                    >НЕВАЖНО</a
                >

                <a
                    href="#"
                    class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-2 px-4 transition-all hover:text-dark hover:bg-light"
                    data-cost-filter="платно"
                    >ПЛАТНО</a
                >

                <a
                    href="#"
                    class="text-sm inline-flex items-center justify-center border border-light rounded-xl text-light py-2 px-4 transition-all hover:text-dark hover:bg-light"
                    data-cost-filter="бесплатно"
                    >БЕСПЛАТНО</a
                >
            </div>
        </div>
    </section>

    <section id="schedule" class="schedule-data mb-5">
        <!-- SHEDULE DESKTOP VIEW -->
        <div id="schedule-container" class="container rounded-brxl bg-light py-6 hidden md:grid">
            @if(empty($daysOfWeek))
                <div class="p-8 text-center">
                    <div class="rounded-brxl bg-main-red/10 p-6">
                        <p class="text-lg mb-2">На выбранный период расписание {{ $scheduleType === 'personal' ? 'индивидуальных' : 'групповых' }} тренировок отсутствует</p>
                        <p class="text-sm text-gray-600">Пожалуйста, выберите другой период или тип тренировок</p>
                    </div>
                </div>
            @else
                <!-- Заголовок с днями недели -->
                <div class="grid grid-cols-8">
                    <div class=" "></div> <!-- Пустая ячейка для временных слотов -->
                    @foreach($daysOfWeek as $dayName => $day)
                        <div class="mb-6">
                            <span class="text-base font-bold lg:font-normal lg:text-xxl block text-center">{{ $day['date'] }}</span>
                            <span class="text-sm block text-center overflow-hidden text-nowrap w-full">{{ $dayName }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Строки с временными слотами и событиями -->
                @foreach($timeSlots as $timeSlot)
                    <div class="grid grid-cols-8 border-t border-dashed">
                        <!-- Временной слот -->
                        <div class="text-sm lg:text-lg text-center bg-gradient-to-b from-main-red/25 rounded-t-brxl py-4 min-h-40">
                            {{ $timeSlot }}
                        </div>

                        <!-- События для каждого дня недели -->
                        @foreach($daysOfWeek as $day)
                            @php
                                $currentSlotStart = \Carbon\Carbon::parse($timeSlot)->format('H:i');
                                $currentSlotEnd = \Carbon\Carbon::parse($timeSlot)->addHour()->format('H:i');

                                // Фильтруем события для текущего временного интервала
                                $eventsInSlot = array_filter($day['schedule'], function($item) use ($currentSlotStart, $currentSlotEnd) {
                                    if (!isset($item['service'])) return false;
                                    $eventStart = \Carbon\Carbon::parse($item['start_date'])->format('H:i');
                                    $eventEnd = \Carbon\Carbon::parse($item['end_date'])->format('H:i');
                                    return ($eventStart >= $currentSlotStart && $eventStart < $currentSlotEnd) ||
                                           ($eventEnd > $currentSlotStart && $eventEnd <= $currentSlotEnd) ||
                                           ($eventStart <= $currentSlotStart && $eventEnd >= $currentSlotEnd);
                                });
                            @endphp

                            <div class="py-4 border-l-dark border-dashed border-l-[2px]">
                                @foreach($eventsInSlot as $item)
                                    @if(isset($item['service']))
                                    <div class="text-[10px] border-l-8 pl-2 mb-2" style="border-left-color: {{ $item['service']['color'] ?? '#cccccc' }};">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="uppercase font-semibold">{{ $item['service']['title'] }}</h4>
                                                <p>{{ \Carbon\Carbon::parse($item['start_date'])->format('H:i') }} - {{ \Carbon\Carbon::parse($item['end_date'])->format('H:i') }}</p>
                                                <p>{{ $item['employee']['name'] }}</p>
                                            </div>
                                            <div class="text-right flex flex-col items-end ml-1 flex-shrink-0">
                                                <span>{{ $item['room']['title'] }}</span>
                                                <a href="#" class="mt-1">
                                                    <img src="/assets/img/location.png" alt="location" class="w-4 h-4" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>

        <!-- SHEDULE MOBILE VIEW -->
        <div class="grid grid-cols-8 rounded-brxl p-4 bg-light gap-2 md:hidden">
            @if(empty($daysOfWeek))
                <div class="col-span-8">
                    <div class="rounded-brxl bg-main-red/10 p-4 text-center">
                        <p class="text-base mb-2">На выбранный период расписание {{ $scheduleType === 'personal' ? 'индивидуальных' : 'групповых' }} тренировок отсутствует</p>
                        <p class="text-sm text-gray-600">Пожалуйста, выберите другой период или тип тренировок</p>
                    </div>
                </div>
            @else
                <div class="col-span-8">
                    <ul class="flex justify-between items-center space-x-1">
                        @foreach($daysOfWeek as $index => $day)
                        <li class="flex flex-col items-center justify-center rounded-lg day-selector {{ $loop->first ? 'bg-main-red text-light' : 'hover:bg-main-red hover:text-light' }} px-2" data-day-index="{{ $index }}">
                            <span class="text-base">{{ $day['date'] }}</span>
                            <span class="text-sm uppercase">{{ getDayAbbreviation($day['name']) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-span-8">
                    <div class="bg-main-red/45 px-4 py-2 rounded-xl text-center text-base" id="selected-day-name">
                        {{-- {{ strtoupper($daysOfWeek[0]['name']) }} --}}
                    </div>
                </div>

                @foreach($timeSlots as $timeSlot)
                    @php
                        $slotStart = \Carbon\Carbon::parse($timeSlot);
                        $slotEnd = \Carbon\Carbon::parse($timeSlot)->addHour();
                    @endphp

                    <div class="col-span-2 flex h-full gap-0">
                        <div class="bg-gradient-to-b rounded-lg from-main-red/25 text-sm text-center p-1 w-full">
                            {{ $timeSlot }}
                        </div>
                    </div>
                    <div class="col-span-6">
                        @foreach($daysOfWeek as $index => $day)
                            <div class="day-schedule" data-day-index="{{ $index }}" style="{{ $loop->first ? '' : 'display: none;' }}">
                                @foreach($day['schedule'] as $item)
                                    @php
                                        if (!isset($item['service'])) continue;
                                        $eventStart = \Carbon\Carbon::parse($item['start_date']);
                                        $eventStartHour = $eventStart->format('H');
                                        $slotHour = $slotStart->format('H');
                                    @endphp

                                    @if($eventStartHour === $slotHour)
                                        <div class="grid grid-cols-8 gap-1 mb-2 bg-main-red/10 rounded-md">
                                            <div class="col-span-5 rounded-md overflow-hidden border-l-[10px] px-1" style="border-color: {{ $item['service']['color'] }}">
                                                <h5 class="text-base">{{ $item['service']['title'] }}</h5>
                                                <p class="text-sm">{{ $eventStart->format('H:i') }} - {{ \Carbon\Carbon::parse($item['end_date'])->format('H:i') }}</p>
                                                <p class="text-sm">{{ $item['employee']['name'] }}</p>
                                            </div>
                                            <div class="col-span-3 flex gap-0 justify-end items-baseline text-sm p-1">
                                                {{ $item['room']['title'] }}
                                                <svg class="h-[18px]" viewBox="-3 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <!-- SVG код без изменений -->
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endsection
{{-- </s:locales:ru> --}}

<script>
document.addEventListener("DOMContentLoaded", () => {
    const daySelectors = document.querySelectorAll('.day-selector');
    const daySchedules = document.querySelectorAll('.day-schedule');
    const selectedDayName = document.getElementById('selected-day-name');

    daySelectors.forEach(selector => {
        selector.addEventListener('click', () => {
            const dayIndex = selector.getAttribute('data-day-index');

            // Обновляем отображение активного дня
            daySelectors.forEach(s => s.classList.remove('bg-main-red', 'text-light'));
            selector.classList.add('bg-main-red', 'text-light');

            // Обновляем отображение расписания
            daySchedules.forEach(schedule => {
                if (schedule.getAttribute('data-day-index') === dayIndex) {
                    schedule.style.display = ''; // Показываем расписание для выбранного дня
                } else {
                    schedule.style.display = 'none'; // Скрываем расписание для других дней
                }
            });

            // Обновляем название выбранного дня
            selectedDayName.textContent = selector.querySelector('span.text-sm').textContent.toUpperCase();
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const filterItems = document.querySelectorAll('.filter-item');
    const urlParams = new URLSearchParams(window.location.search);
    const selectedFilters = urlParams.getAll('filters[]');

    // Выделяем выбранные фильтры
    filterItems.forEach(item => {
        const filterId = item.getAttribute('data-filter');
        if (selectedFilters.includes(filterId)) {
            item.classList.add('bg-main-red', 'text-light'); // Добавляем классы для выделения
        }

        item.addEventListener('click', (event) => {
            event.preventDefault(); // Предотвращаем переход по ссылке
            const filterId = item.getAttribute('data-filter');

            // Получаем текущие параметры URL
            const urlParams = new URLSearchParams(window.location.search);

            // Добавляем или удаляем фильтр из параметров
            if (urlParams.has('filters[]')) {
                const filters = urlParams.getAll('filters[]');
                if (filters.includes(filterId)) {
                    // Если фильтр уже выбран, удаляем его
                    const index = filters.indexOf(filterId);
                    if (index > -1) {
                        filters.splice(index, 1);
                    }
                } else {
                    // Если фильтр не выбран, добавляем его
                    filters.push(filterId);
                }
                // Обновляем параметры URL
                urlParams.delete('filters[]');
                filters.forEach(filter => urlParams.append('filters[]', filter));
            } else {
                // Если фильтров нет, добавляем текущий
                urlParams.append('filters[]', filterId);
            }

            // Перезагружаем страницу с новыми параметрами
            window.location.search = urlParams.toString();
        });
    });
});

// Новый скрипт для фильтров возраста и стоимости
document.addEventListener("DOMContentLoaded", () => {
    const ageFilters = document.querySelectorAll('a[data-age-filter]');
    const costFilters = document.querySelectorAll('a[data-cost-filter]');
    const urlParams = new URLSearchParams(window.location.search);
    const currentAge = urlParams.get('age');
    const currentCost = urlParams.get('cost');

    // Функция для обновления URL и перезагрузки
    const updateUrlAndReload = (paramName, paramValue) => {
        const urlParams = new URLSearchParams(window.location.search);
        if (paramValue === 'любые' || paramValue === 'неважно') {
            urlParams.delete(paramName);
        } else {
            urlParams.set(paramName, paramValue);
        }
        window.location.search = urlParams.toString();
    };

    // Выделение активных фильтров при загрузке
    ageFilters.forEach(filter => {
        const filterValue = filter.getAttribute('data-age-filter');
        if ((!currentAge && filterValue === 'любые') || currentAge === filterValue) {
            filter.classList.add('bg-light', 'text-dark');
            filter.classList.remove('text-light');
        } else {
            filter.classList.remove('bg-light', 'text-dark');
            filter.classList.add('text-light');
        }
        filter.addEventListener('click', (e) => {
            e.preventDefault();
            updateUrlAndReload('age', filterValue);
        });
    });

    costFilters.forEach(filter => {
        const filterValue = filter.getAttribute('data-cost-filter');
        if ((!currentCost && filterValue === 'неважно') || currentCost === filterValue) {
            filter.classList.add('bg-light', 'text-dark');
            filter.classList.remove('text-light');
        } else {
            filter.classList.remove('bg-light', 'text-dark');
            filter.classList.add('text-light');
        }
        filter.addEventListener('click', (e) => {
            e.preventDefault();
            updateUrlAndReload('cost', filterValue);
        });
    });

});
</script>



