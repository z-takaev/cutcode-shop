@extends('layouts.auth')

@section('title', 'Регистрация аккаунта')

@section('content')
    <x-auth.form title="Регистрация аккаунта" method="POST" action="{{ route('registration') }}">
        @csrf

        <x-auth.text-field type="text" name="name" value="{{ old('name') }}" placeholder="Имя"
                           :isError="$errors->has('name')"></x-auth.text-field>
        @error('name')
        <x-auth.error>{{ $message }}</x-auth.error>
        @enderror
        <x-auth.text-field type="email" name="email" value="{{ old('email') }}" placeholder="E-mail"
                           :isError="$errors->has('email')"></x-auth.text-field>
        @error('email')
        <x-auth.error>{{ $message }}</x-auth.error>
        @enderror
        <x-auth.text-field type="password" name="password" placeholder="Пароль"
                           :isError="$errors->has('password')"></x-auth.text-field>
        @error('password')
        <x-auth.error>{{ $message }}</x-auth.error>
        @enderror
        <x-auth.text-field type="password" name="password_confirmation" placeholder="Повтор пароля"></x-auth.text-field>
        <x-auth.btn-primary>Зарегистрироваться</x-auth.btn-primary>

        <x-slot:links>
            <div class="text-xxs md:text-xs">
                <a
                    href="{{ route('login') }}"
                    class="text-white hover:text-white/70 font-bold">Уже есть аккаунт?</a>
            </div>
        </x-slot:links>
    </x-auth.form>
@endsection
