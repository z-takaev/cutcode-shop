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


<main class="py-16 lg:py-20">
    <div class="container">
        @yield('content')
    </div>
</main>

</body>
</html>
