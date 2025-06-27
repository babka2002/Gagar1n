@extends('grelka.layout')
@section('trainerContent')
@php
    // dd($trainer)
@endphp
    <section class="py-sectionPadding px-4">
        <div class="container text-light">
            <div class="grid grid-cols-1 gap-0 md:grid-cols-3 md:gap-16">
                <div class="col-span-2 order-2 md:order-1">
                    <a href="{{ route('trainers.list') }}"
                        class="rounded-brxl px-4 py-2 leading-none text-dark bg-light text-base uppercase max-w-[190px] items-center justify-between gap-2 mb-5 hover:scale-105 transition-all hidden md:inline-flex">
                        <svg width="70" height="13" viewBox="0 0 70 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.229 5.8377C0.90097 6.16572 0.90097 6.69756 1.229 7.02558L6.57447 12.3711C6.9025 12.6991 7.43433 12.6991 7.76236 12.3711C8.09038 12.043 8.09038 11.5112 7.76236 11.1832L3.01082 6.43164L7.76236 1.68011C8.09038 1.35208 8.09038 0.820249 7.76236 0.492224C7.43433 0.164199 6.9025 0.164199 6.57447 0.492224L1.229 5.8377ZM69.4141 5.59168L1.82294 5.59168V7.2716L69.4141 7.2716V5.59168Z"
                                fill="black" />
                        </svg>
                        назад
                    </a>

                    <h2 class="text-left md:flex items-start justify-between mb-4">
                        <span class="text-xl uppercase">{{ $trainer->name }}</span>
                        <span class="text-md text-right uppercase hidden md:block">{{ $trainer->position->title ?? 'Не определена' }}</span>
                    </h2>
                    @if(!empty($trainer->experience))
                    <div class="text-left text-md mb-4">{{ $trainer->experience }} ГОДА ОПЫТА</div>
                    @endif
                    {{-- <div class="text-left text-md mb-4">{!! nl2br(e($trainer->description ?? '')) !!}</div> --}}
                    <div class="markdown-content text-left text-md mb-4">
                        {!! $trainer->description  !!}
                    </div>

                    <ul class="list-disc list-inside mb-8 space-y-3">
                        @if(!empty($trainer->biography))
                            <li class="leading-tight">{{ $trainer->biography }}</li>
                        @endif
                        @if(!empty($trainer->awards))
                            <li class="leading-tight">{{ $trainer->awards }}</li>
                        @endif
                    </ul>
                    <div class="text-lg text-left uppercase md:hidden my-5">{{ $trainer->position->title ?? 'Не определена' }}</div>



                    <a href="#"
                        data-dialog="dialog"
                        data-trainer-name="{{ $trainer->name . ' ' . $trainer->second_name . ' ' . $trainer->last_name }}"
                        class="show rounded-brxl px-6 py-2 leading-none text-dark bg-light text-md uppercase flex items-center justify-between gap-2 mb-5 mt-auto hover:scale-105 transition-all">
                        записаться
                        <svg width="448" height="19" viewBox="0 0 448 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M447.566 10.3414C448.062 9.84544 448.062 9.04128 447.566 8.54529L439.484 0.462712C438.988 -0.0332756 438.184 -0.0332756 437.688 0.462712C437.192 0.9587 437.192 1.76285 437.688 2.25884L444.872 9.44336L437.688 16.6279C437.192 17.1239 437.192 17.928 437.688 18.424C438.184 18.92 438.988 18.92 439.484 18.424L447.566 10.3414ZM0.878906 10.7134H446.668V8.1733H0.878906V10.7134Z"
                                fill="black" />
                        </svg>
                    </a>
                </div>
                <div class="col-span-1 order-1 md:order-2 mb-4 md:mb-0">
                    <div class="flex justify-between mb-5 md:hidden">
                        <button onclick="window.history.back()" class="hover:opacity-70 transition-all">
                            <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="17.4194" cy="17.4194" r="17.4194" fill="#D9D9D9" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M18.3672 8.26534C19.3343 7.30739 20.9023 7.30739 21.8693 8.26534C22.8364 9.22329 22.8364 10.7764 21.8693 11.7344L16.4199 17.1323L22.2167 22.8743C23.1838 23.8323 23.1838 25.3854 22.2167 26.3434C21.2496 27.3013 19.6817 27.3013 18.7146 26.3434L11.5961 19.2922C11.4068 19.1046 11.2545 18.8943 11.1393 18.67C10.2832 17.7065 10.3196 16.2368 11.2488 15.3165L18.3672 8.26534Z"
                                    fill="#3D3D3D" />
                            </svg>
                        </button>

                        <a href="{{ route('trainers.list') }}" class="hover:opacity-70 transition-all">
                            <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="17.389" cy="17.389" r="17.389" fill="#D9D9D9" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M22.6211 9.28756C23.4133 8.49529 24.6978 8.49529 25.4901 9.28756C26.2824 10.0798 26.2824 11.3643 25.4901 12.1566L20.4638 17.1829L25.9 22.6191C26.6923 23.4114 26.6923 24.6959 25.9 25.4881C25.1078 26.2804 23.8232 26.2804 23.031 25.4881L17.5948 20.0519L12.1585 25.4881C11.3663 26.2804 10.0818 26.2804 9.28951 25.4881C8.49725 24.6959 8.49725 23.4114 9.28951 22.6191L14.7257 17.1829L9.69943 12.1566C8.90717 11.3643 8.90717 10.0798 9.69943 9.28756C10.4917 8.49529 11.7762 8.49529 12.5685 9.28756L17.5948 14.3139L22.6211 9.28756Z"
                                    fill="#3D3D3D" />
                            </svg>
                        </a>
                    </div>
                    <img
                        src="{{ $trainer->localPhotoPath ?? asset('assets/img/default-trainer.png') }}"
                        alt="{{ $trainer->name }}"
                        class="rounded-brxl w-full mx-auto">
                </div>
            </div>
        </div>
    </section>
@endsection
