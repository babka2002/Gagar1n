@extends('gun1or.layout')

@section('trainerContent')
    <!-- Hero секция -->
    <section class="bg-gradient-to-br from-purple-400 via-pink-500 to-red-400 py-sectionPadding px-4 relative overflow-hidden">
        <div class="container relative z-10">
            <!-- Декоративные элементы -->
            <div class="absolute top-4 left-4 w-16 h-16 bg-yellow-300 rounded-full opacity-70 animate-spin"></div>
            <div class="absolute top-16 right-8 w-12 h-12 bg-green-300 rounded-full opacity-60 animate-bounce"></div>
            <div class="absolute bottom-8 left-1/3 w-8 h-8 bg-blue-300 rounded-full opacity-80 animate-pulse"></div>

            <!-- Кнопка назад -->
            <a href="/gun1or/trainers"
               class="inline-flex items-center gap-2 bg-white text-blue-600 font-bold px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-105 mb-8"
               data-aos="fade-right">
                <svg width="20" height="20" viewBox="0 0 70 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.229 5.8377C0.90097 6.16572 0.90097 6.69756 1.229 7.02558L6.57447 12.3711C6.9025 12.6991 7.43433 12.6991 7.76236 12.3711C8.09038 12.043 8.09038 11.5112 7.76236 11.1832L3.01082 6.43164L7.76236 1.68011C8.09038 1.35208 8.09038 0.820249 7.76236 0.492224C7.43433 0.164199 6.9025 0.164199 6.57447 0.492224L1.229 5.8377ZM69.4141 5.59168L1.82294 5.59168V7.2716L69.4141 7.2716V5.59168Z" fill="currentColor"/>
                </svg>
                К списку тренеров
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Фото тренера -->
                <div class="order-2 lg:order-1" data-aos="zoom-in">
                    <div class="relative">
                        @if($trainer->localPhotoPath)
                            <img src="{{ $trainer->localPhotoPath }}"
                                 alt="{{ $trainer->name }} {{ $trainer->last_name }}"
                                 class="w-full max-w-md mx-auto rounded-3xl shadow-2xl object-cover object-top h-96">
                        @else
                            <div class="w-full max-w-md mx-auto h-96 bg-gradient-to-br from-yellow-200 to-pink-200 rounded-3xl shadow-2xl flex items-center justify-center">
                                <div class="text-8xl">👨‍🏫</div>
                            </div>
                        @endif

                        <!-- Украшения вокруг фото -->
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-yellow-400 rounded-full animate-pulse"></div>
                        <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-green-400 rounded-full animate-bounce"></div>
                    </div>
                </div>

                <!-- Основная информация -->
                <div class="order-1 lg:order-2 text-white" data-aos="fade-left">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">
                        {{ $trainer->name }} {{ $trainer->last_name }}
                    </h1>

                    @if(isset($trainer->position) && $trainer->position->title)
                        <div class="text-xl md:text-2xl bg-white text-blue-600 inline-block px-6 py-2 rounded-full font-bold mb-6">
                            {{ $trainer->position->title }}
                        </div>
                    @endif

                    @if(!empty($trainer->experience))
                        <div class="text-lg md:text-xl mb-6 bg-yellow-300 text-blue-800 inline-block px-4 py-2 rounded-full font-bold">
                            {{ $trainer->experience }} лет опыта 🏆
                        </div>
                    @endif

                    <!-- Кнопка записи -->
                    <a href="#"
                       data-dialog="dialog"
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-bold text-lg rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        Записаться на тренировку
                        <span class="ml-2">🚀</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Подробная информация -->
    <section class="py-sectionPadding bg-gradient-to-b from-blue-50 to-white">
        <div class="container px-4">
            <div class="max-w-4xl mx-auto">
                @if($trainer->description)
                    <div class="bg-white rounded-3xl shadow-xl p-8 mb-8" data-aos="fade-up">
                        <h2 class="text-2xl md:text-3xl text-blue-800 font-bold mb-6 text-center">
                            О тренере
                            <span class="text-3xl ml-2">🌟</span>
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! $trainer->description !!}
                        </div>
                    </div>
                @endif

                <!-- Дополнительные блоки с специализацией -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Преимущества -->
                    <div class="bg-gradient-to-br from-yellow-100 to-orange-100 rounded-3xl p-8 shadow-lg" data-aos="fade-right">
                        <h3 class="text-xl font-bold text-orange-800 mb-4 text-center">
                            Почему выбирают меня? 🎯
                        </h3>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-center">
                                <span class="text-2xl mr-3">🎮</span>
                                Игровой подход к обучению
                            </li>
                            <li class="flex items-center">
                                <span class="text-2xl mr-3">👶</span>
                                Работа с детьми разных возрастов
                            </li>
                            <li class="flex items-center">
                                <span class="text-2xl mr-3">🏃‍♂️</span>
                                Индивидуальные программы
                            </li>
                            <li class="flex items-center">
                                <span class="text-2xl mr-3">🏆</span>
                                Подготовка к соревнованиям
                            </li>
                        </ul>
                    </div>

                    <!-- Контакты/запись -->
                    <div class="bg-gradient-to-br from-green-100 to-blue-100 rounded-3xl p-8 shadow-lg" data-aos="fade-left">
                        <h3 class="text-xl font-bold text-blue-800 mb-4 text-center">
                            Готов заниматься! 💪
                        </h3>
                        <div class="text-center">
                            <p class="text-gray-700 mb-6">
                                Первое занятие совершенно <strong>БЕСПЛАТНО!</strong>
                                Приходи знакомиться и пробовать.
                            </p>
                            <a href="#"
                               data-dialog="dialog"
                               class="inline-flex items-center justify-center px-6 py-3 rounded-full text-white font-bold transition-all hover:scale-105"
                               style="background: linear-gradient(45deg, {{ $site_settings['primary_color'] ?? '#3B82F6' }}, {{ $site_settings['button_hover_color'] ?? '#2563EB' }})">
                                Записаться на пробное занятие
                                <span class="ml-2">🎉</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Другие тренеры -->
                <div class="mt-16" data-aos="fade-up">
                    <h3 class="text-2xl md:text-3xl text-blue-800 font-bold text-center mb-8">
                        Другие наши тренеры
                        <span class="text-3xl ml-2">👥</span>
                    </h3>
                    <div class="text-center">
                        <a href="/gun1or/trainers"
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold text-lg rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-105">
                            Посмотреть всех тренеров
                            <span class="ml-2">👀</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
