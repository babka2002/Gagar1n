@extends('gun1or.layout')

@section('scheduleContent')
    <!-- Hero секция -->
    <section class="bg-gradient-to-br from-blue-400 via-purple-500 to-pink-400 pt-sectionPadding px-4 relative overflow-hidden">
        <div class="container text-light relative z-10">
            <!-- Декоративные элементы -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-yellow-300 rounded-full opacity-70 animate-bounce"></div>
            <div class="absolute top-32 right-20 w-16 h-16 bg-green-300 rounded-full opacity-60 animate-pulse"></div>
            <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-orange-300 rounded-full opacity-80 animate-bounce"></div>

            <h1 class="text-light text-xl md:text-xxl leading-tight uppercase text-center mb-4" data-aos="zoom-in">
                {{ $title ?? 'Расписание детских занятий' }}
            </h1>
            <p class="text-center text-lg md:text-xl mb-8" data-aos="fade-up">
                Найди своё время для спорта и веселья! 🎉
            </p>

            <!-- Переключатель групповых/индивидуальных -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 justify-center mb-8 px-4 sm:px-0" data-aos="zoom-in">
                <a href="{{ route('gun1or.schedule.show', array_merge(request()->except('schedule_type'), ['schedule_type' => 'classes'])) }}"
                   class="rounded-full px-4 sm:px-6 py-2 sm:py-3 font-bold text-sm sm:text-lg transition-all hover:scale-105 text-center {{ $scheduleType === 'classes' ? 'bg-white text-blue-600' : 'bg-white/20 text-white hover:bg-white/30' }}">
                    🏃‍♂️ Групповые занятия
                </a>
                <a href="{{ route('gun1or.schedule.show', array_merge(request()->except('schedule_type'), ['schedule_type' => 'personal'])) }}"
                   class="rounded-full px-4 sm:px-6 py-2 sm:py-3 font-bold text-sm sm:text-lg transition-all hover:scale-105 text-center {{ $scheduleType === 'personal' ? 'bg-white text-blue-600' : 'bg-white/20 text-white hover:bg-white/30' }}">
                    👨‍🏫 Индивидуальные
                </a>
            </div>
        </div>
    </section>

    <!-- Фильтры -->
    <section class="py-8 bg-gradient-to-b from-blue-50 to-white">
        <div class="container px-4">
            <form method="GET" action="/gun1or/schedule" class="bg-white rounded-3xl shadow-xl p-6 mb-8">
                <h2 class="text-2xl font-bold text-blue-800 text-center mb-6">
                    Найди идеальное занятие! 🔍
                </h2>

                <!-- Основные фильтры -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Фильтр по возрасту -->
                    <div>
                        <label class="block text-sm font-bold text-blue-700 mb-2">Возраст 👶</label>
                        <select name="age" class="w-full rounded-full border-2 border-blue-200 p-3 focus:border-blue-500 focus:outline-none">
                            <option value="любые" {{ request('age') === 'любые' || !request('age') ? 'selected' : '' }}>Любой возраст</option>
                            <option value="малыш" {{ request('age') === 'малыш' ? 'selected' : '' }}>Малыши (до 5 лет)</option>
                            <option value="дошкольн" {{ request('age') === 'дошкольн' ? 'selected' : '' }}>Дошкольники (5-7 лет)</option>
                            <option value="школьн" {{ request('age') === 'школьн' ? 'selected' : '' }}>Школьники (7-12 лет)</option>
                            <option value="подрост" {{ request('age') === 'подрост' ? 'selected' : '' }}>Подростки (12-16 лет)</option>
                            <option value="5+" {{ request('age') === '5+' ? 'selected' : '' }}>От 5 лет и старше</option>
                        </select>
                    </div>

                    <!-- Фильтр по стоимости -->
                    <div>
                        <label class="block text-sm font-bold text-blue-700 mb-2">Стоимость 💰</label>
                        <select name="cost" class="w-full rounded-full border-2 border-blue-200 p-3 focus:border-blue-500 focus:outline-none">
                            <option value="неважно" {{ request('cost') === 'неважно' || !request('cost') ? 'selected' : '' }}>Неважно</option>
                            <option value="бесплатно" {{ request('cost') === 'бесплатно' ? 'selected' : '' }}>Бесплатно</option>
                            <option value="платно" {{ request('cost') === 'платно' ? 'selected' : '' }}>Платно</option>
                        </select>
                    </div>

                    <!-- Кнопка применить -->
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full rounded-full text-white font-bold py-3 px-6 transition-all hover:scale-105"
                                style="background: linear-gradient(45deg, {{ $site_settings['primary_color'] ?? '#3B82F6' }}, {{ $site_settings['button_hover_color'] ?? '#2563EB' }})">
                            Применить фильтры 🚀
                        </button>
                    </div>
                </div>

                <!-- Фильтры по залам -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-blue-700 mb-3">Залы 🏢</label>
                    <div class="flex flex-wrap gap-2">
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="аква зона">Аква зона</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="зона кроссфита">Зона кроссфита</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="малый бассейн">Малый бассейн</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="эстетический зал kids">Эстетический зал KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="кабинет кинезиолога">Кабинет кинезиолога</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="сайкл студия">Сайкл студия</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="зал единоборств kids">Зал единоборств KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="студия 1 (g1unior)">Студия 1 (G1unior)</a>
                    </div>
                </div>

                <!-- Фильтры по типам занятий -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-blue-700 mb-3">Типы занятий 🏃‍♂️</label>
                    <div class="flex flex-wrap gap-2">
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="аква плавание kids">Аква ПЛАВАНИЕ KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="crossfit kids">CROSSFIT KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="dance mix kids">DANCE MIX KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="каратэ kids">КАРАТЭ KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="акробатика kids">АКРОБАТИКА KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="mma kids">MMA KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="здоровая спина kids">ЗДОРОВАЯ СПИНА KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="грэпплинг kids">ГРЭППЛИНГ KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="boxing kids">BOXING KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="ритмика kids">РИТМИКА KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="taekick kids">TAEKICK KIDS</a>
                        <a href="#" class="filter-item text-sm inline-flex items-center justify-center border border-blue-200 rounded-xl text-blue-700 py-2 px-3 transition-all hover:text-white hover:bg-blue-500" data-filter="дзюдо kids">ДЗЮДО KIDS</a>
                    </div>
                </div>

                <!-- Скрытые поля для сохранения текущих параметров -->
                <input type="hidden" name="schedule_type" value="{{ $scheduleType }}">
                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            </form>
        </div>
    </section>

        <!-- Расписание как у Grelka -->
    <section id="schedule" class="schedule-data mb-5">
        <!-- DESKTOP VIEW -->
        <div id="schedule-container" class="container rounded-brxl bg-light py-6 hidden md:grid my-4">
            @if(empty($daysOfWeek))
                <div class="p-8 text-center">
                    <div class="rounded-brxl bg-blue-500/10 p-6">
                        <p class="text-lg mb-2">На выбранный период расписание {{ $scheduleType === 'personal' ? 'индивидуальных' : 'групповых' }} занятий отсутствует</p>
                        <p class="text-sm text-gray-600">Пожалуйста, выберите другой период или тип занятий</p>
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
                        <div class="text-sm lg:text-lg text-center bg-gradient-to-b from-blue-500/25 rounded-t-brxl py-4 min-h-40">
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

        <!-- MOBILE VIEW -->
        <div class="grid grid-cols-8 rounded-brxl mt-2 p-4 bg-light gap-2 md:hidden">
            @if(empty($daysOfWeek))
                <div class="col-span-8">
                    <div class="rounded-brxl bg-blue-500/10 p-4 text-center">
                        <p class="text-base mb-2">На выбранный период расписание {{ $scheduleType === 'personal' ? 'индивидуальных' : 'групповых' }} занятий отсутствует</p>
                        <p class="text-sm text-gray-600">Пожалуйста, выберите другой период или тип занятий</p>
                    </div>
                </div>
            @else
                <div class="col-span-8">
                    <ul class="flex justify-between items-center space-x-1">
                        @foreach($daysOfWeek as $index => $day)
                        <li class="flex flex-col items-center justify-center rounded-lg day-selector {{ $loop->first ? 'bg-blue-500 text-light' : 'hover:bg-blue-500 hover:text-light' }} px-2" data-day-index="{{ $index }}">
                            <span class="text-base">{{ $day['date'] }}</span>
                            <span class="text-sm uppercase">{{ getDayAbbreviation($day['name']) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-span-8">
                    <div class="bg-blue-500/45 px-4 py-2 rounded-xl text-center text-base" id="selected-day-name">
                        @if(!empty($daysOfWeek))
                            {{ getDayAbbreviation(array_values($daysOfWeek)[0]['name'] ?? '') }}
                        @else
                            ДЕНЬ
                        @endif
                    </div>
                </div>

                @foreach($timeSlots as $timeSlot)
                    @php
                        $slotStart = \Carbon\Carbon::parse($timeSlot);
                        $slotEnd = \Carbon\Carbon::parse($timeSlot)->addHour();
                    @endphp

                    <div class="col-span-2 flex h-full gap-0">
                        <div class="bg-gradient-to-b rounded-lg from-blue-500/25 text-sm text-center p-1 w-full">
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
                                        <div class="grid grid-cols-8 gap-1 mb-2 bg-blue-500/10 rounded-md">
                                            <div class="col-span-5 rounded-md overflow-hidden border-l-[10px] px-1" style="border-color: {{ $item['service']['color'] }}">
                                                <h5 class="text-base">{{ $item['service']['title'] }}</h5>
                                                <p class="text-sm">{{ $eventStart->format('H:i') }} - {{ \Carbon\Carbon::parse($item['end_date'])->format('H:i') }}</p>
                                                <p class="text-sm">{{ $item['employee']['name'] }}</p>
                                            </div>
                                            <div class="col-span-3 flex gap-1 justify-end items-center text-sm p-1">
                                                <span class="truncate">{{ $item['room']['title'] }}</span>
                                                <img src="/assets/img/location.png" alt="location" class="w-3 h-3 flex-shrink-0" />
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

    <!-- CTA секция -->
    <section class="py-sectionPadding px-4 bg-gradient-to-r from-green-400 to-blue-500">
        <div class="container">
            <div class="bg-white rounded-3xl p-8 shadow-2xl max-w-4xl mx-auto" data-aos="zoom-in">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-2xl md:text-3xl text-blue-800 font-bold mb-4">
                            {{ $subscription_not_found_title ?? 'Не нашли подходящее время?' }} 🤔
                        </h3>
                        <p class="text-gray-700 text-lg mb-6">
                            Мы поможем подобрать идеальное время для занятий вашего ребенка!
                            Звоните или пишите нам.
                        </p>
                        <a href="#"
                           data-dialog="dialog"
                           class="show inline-flex items-center justify-center px-8 py-4 rounded-full text-white font-bold text-lg transition-all hover:scale-105"
                           style="background: linear-gradient(45deg, {{ $site_settings['primary_color'] ?? '#3B82F6' }}, {{ $site_settings['button_hover_color'] ?? '#2563EB' }})">
                            {{ $subscription_not_found_subtitle ?? 'Связаться с нами' }}
                            <span class="ml-2">📞</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <div class="inline-block p-8 bg-gradient-to-br from-yellow-200 to-orange-200 rounded-full">
                            <div class="text-6xl">📅⏰</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
document.addEventListener("DOMContentLoaded", () => {
    const daySelectors = document.querySelectorAll('.day-selector');
    const daySchedules = document.querySelectorAll('.day-schedule');
    const selectedDayName = document.getElementById('selected-day-name');

    daySelectors.forEach(selector => {
        selector.addEventListener('click', () => {
            const dayIndex = selector.getAttribute('data-day-index');

            // Обновляем отображение активного дня
            daySelectors.forEach(s => s.classList.remove('bg-blue-500', 'text-light'));
            selector.classList.add('bg-blue-500', 'text-light');

            // Обновляем отображение расписания
            daySchedules.forEach(schedule => {
                if (schedule.getAttribute('data-day-index') === dayIndex) {
                    schedule.style.display = ''; // Показываем расписание для выбранного дня
                } else {
                    schedule.style.display = 'none'; // Скрываем расписание для других дней
                }
            });

            // Обновляем название выбранного дня
            if (selectedDayName) {
                selectedDayName.textContent = selector.querySelector('span.text-sm').textContent;
            }
        });
    });
});

// Функционал фильтров по залам и типам занятий
document.addEventListener("DOMContentLoaded", () => {
    const filterItems = document.querySelectorAll('.filter-item');
    const urlParams = new URLSearchParams(window.location.search);
    const selectedFilters = urlParams.getAll('filters[]');

    // Выделяем выбранные фильтры при загрузке
    filterItems.forEach(item => {
        const filterId = item.getAttribute('data-filter');
        if (selectedFilters.includes(filterId)) {
            item.classList.add('bg-blue-500', 'text-white');
            item.classList.remove('text-blue-700', 'border-blue-200');
        }

        item.addEventListener('click', (event) => {
            event.preventDefault();
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
</script>
