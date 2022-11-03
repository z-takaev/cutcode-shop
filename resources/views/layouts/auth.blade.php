<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'CutCode')</title>
    <meta name="description" content="Видеокурс по изучению принципов программирования">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
</head>
<body>

@if($flash = flash()->get())
    <div class="{{ $flash->classes() }}">{{ $flash->message()  }}</div>
@endif


<main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
    <div class="container">
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block" rel="home">
                <img src="{{ Vite::image('logo.svg') }}" class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]"
                     alt="CutCode">
            </a>
        </div>

        @yield('content')
    </div>
</main>

</body>
</html>
