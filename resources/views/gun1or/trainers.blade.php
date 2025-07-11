@extends('gun1or.layout')

@section('trainersContent')
    <!-- Hero секция -->
    <section class="pt-sectionPadding px-4 relative overflow-hidden"
             style="background: linear-gradient(135deg, {{ $site_settings['gradient_from'] ?? '#60A5FA' }}, {{ $site_settings['gradient_to'] ?? '#F472B6' }})">
        <div class="container text-light relative z-10">
            <!-- Декоративные элементы -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-yellow-300 rounded-full opacity-70 animate-bounce"></div>
            <div class="absolute top-32 right-20 w-16 h-16 bg-green-300 rounded-full opacity-60 animate-pulse"></div>
            <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-orange-300 rounded-full opacity-80 animate-bounce"></div>

            <h1 class="text-light text-xl md:text-xxl leading-tight uppercase text-center mb-4" data-aos="zoom-in">
                {{ $hero_title }}
            </h1>
            <p class="text-center text-lg md:text-xl mb-8" data-aos="fade-up">
                {{ $hero_subtitle }}
            </p>

            <!-- Изображение hero -->
            <div class="flex justify-center" data-aos="zoom-in">
                <img src="<s:glide:data_url src='/assets/{{ $hero_image }}' quality='75' format='webp' />"
                     alt="Детский фитнес"
                     class="max-w-md rounded-3xl shadow-2xl">
            </div>
        </div>
    </section>

    <!-- Секция тренеров -->
    <section class="py-sectionPadding bg-gradient-to-b from-blue-50 to-white">
        <div class="px-4">
            @if(isset($trainersByDepartment) && count($trainersByDepartment) > 0)
                @foreach ($trainersByDepartment as $departmentTitle => $trainers)
                    <div class="container px-4 mb-16">
                        <h2 class="text-2xl md:text-3xl text-blue-600 uppercase flex gap-6 items-center justify-center text-center mb-8" data-aos="fade-right">
                            <span class="inline-block w-8 h-8 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full"></span>
                            {{ $departmentTitle }}
                            <span class="inline-block w-8 h-8 bg-gradient-to-r from-pink-400 to-purple-400 rounded-full"></span>
                        </h2>
                    </div>

                    <div class="py-5">
                        <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @if (count($trainers) > 0)
                                @foreach ($trainers as $trainer)
                                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105" data-aos="flip-left">
                                        <!-- Фото тренера -->
                                        <div class="relative overflow-hidden h-64 bg-gradient-to-br from-blue-200 to-purple-200">
                                            @if($trainer->localPhotoPath)
                                                <img src="{{ $trainer->localPhotoPath }}"
                                                     alt="{{ $trainer->name }} {{ $trainer->last_name }}"
                                                     class="w-full h-full object-contain object-center bg-gradient-to-br from-blue-100 to-purple-100">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-200 to-pink-200">
                                                    <div class="text-6xl text-white">👨‍🏫</div>
                                                </div>
                                            @endif

                                            <!-- Цветные украшения -->
                                            <div class="absolute top-4 right-4 w-6 h-6 bg-yellow-400 rounded-full animate-pulse"></div>
                                            <div class="absolute bottom-4 left-4 w-4 h-4 bg-green-400 rounded-full animate-bounce"></div>
                                        </div>

                                        <!-- Информация о тренере -->
                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-blue-800 mb-2 text-center">
                                                {{ $trainer->name }} {{ $trainer->last_name }}
                                            </h3>

                                            @if(isset($trainer->position) && $trainer->position->title)
                                                <p class="text-purple-600 font-medium text-center mb-4 text-sm uppercase tracking-wide">
                                                    {{ $trainer->position->title }}
                                                </p>
                                            @endif

                                            @if($trainer->short_description)
                                                <div class="text-gray-700 text-sm mb-4 leading-relaxed">
                                                    {!! $trainer->short_description !!}
                                                </div>
                                            @endif

                                            <!-- Кнопка подробнее -->
                                            <div class="text-center">
                                                <a href="/gun1or/trainers/{{ $trainer->slug }}"
                                                   class="inline-flex items-center justify-center px-6 py-3 rounded-full text-white font-bold transition-all hover:scale-105"
                                                   style="background: linear-gradient(45deg, {{ $site_settings['primary_color'] ?? '#3B82F6' }}, {{ $site_settings['button_hover_color'] ?? '#2563EB' }})">
                                                    Узнать больше
                                                    <span class="ml-2">🌟</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-span-full text-center py-16">
                                    <div class="text-6xl mb-4">🏃‍♂️</div>
                                    <p class="text-xl text-gray-600">Скоро здесь появятся наши замечательные тренеры!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="container text-center py-16">
                    <div class="text-8xl mb-8">🎪</div>
                    <h2 class="text-3xl text-blue-600 mb-4">Готовим команду супер-тренеров!</h2>
                    <p class="text-xl text-gray-600">Скоро здесь появятся лучшие специалисты детского фитнеса</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Секция "Хочешь попробовать?" -->
    <section class="py-sectionPadding px-4 bg-gradient-to-r from-green-400 to-blue-500">
        <div class="container">
            <h2 class="text-light text-xl md:text-xxxl uppercase leading-tight mb-8 text-center" data-aos="zoom-in">
                {{ $cta_title }}
            </h2>

            <div class="bg-white rounded-3xl p-8 shadow-2xl max-w-4xl mx-auto" data-aos="zoom-in">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-2xl md:text-3xl text-blue-800 font-bold mb-4">
                            {{ $cta_main_title }} 🎉
                        </h3>
                        <p class="text-gray-700 text-lg mb-6">
                            {{ $cta_description }}
                        </p>
                        <a href="{{ $cta_link }}"
                           data-dialog="dialog"
                           class="inline-flex items-center justify-center px-8 py-4 rounded-full text-white font-bold text-lg transition-all hover:scale-105"
                           style="background: linear-gradient(45deg, {{ $site_settings['primary_color'] ?? '#3B82F6' }}, {{ $site_settings['button_hover_color'] ?? '#2563EB' }})">
                            {{ $cta_button_text }}
                            <span class="ml-2">🚀</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <div class="inline-block p-8 bg-gradient-to-br from-yellow-200 to-orange-200 rounded-full">
                            <div class="text-6xl">{!! $cta_emoji !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
