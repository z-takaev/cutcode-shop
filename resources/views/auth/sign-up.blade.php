@extends('layouts.auth')

@section('title', 'Регистрация аккаунта')

@section('content')
    <x-auth.form title="Регистрация аккаунта">
        @csrf

        <x-auth.text-field type="text" name="name" placeholder="Имя"></x-auth.text-field>
        <x-auth.text-field type="email" name="email" placeholder="E-mail"></x-auth.text-field>
        <x-auth.text-field type="password" name="password" placeholder="Пароль"></x-auth.text-field>
        <x-auth.text-field type="password" name="password_confirmation" placeholder="Повтор пароля"></x-auth.text-field>
        <x-auth.btn-primary>Зарегистрироваться</x-auth.btn-primary>

        <x-slot:links>
            <div class="text-xxs md:text-xs">
                <a
                    href="{{ route('auth.sign-in') }}"
                    class="text-white hover:text-white/70 font-bold">Уже есть аккаунт?</a>
            </div>
        </x-slot:links>
    </x-auth.form>
@endsection
