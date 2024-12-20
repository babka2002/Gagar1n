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
        @antlers
        {{ vite src="resources/js/site.js|resources/css/site.css" }}
        @endantlers
        @vite([
            'vendor/mkocansey/bladewind/public/css/animate.min.css',
            'vendor/mkocansey/bladewind/public/css/bladewind-ui.min.css',
            'vendor/mkocansey/bladewind/public/js/helpers.js'
        ])
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="bg-gray-100 font-sans leading-normal text-gray-800">
        <div class="mx-auto px-2 lg:min-h-screen flex flex-col items-center justify-center">
            <x-bladewind::button onclick=>Кнопка</x-bladewind::button>

            @antlers
                {{ template_content }}
            @endantlers
        </div>
    </body>
</html>
