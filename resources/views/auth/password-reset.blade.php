@extends('layouts.auth')

@section('title', 'Сброс пароля')

@section('content')
    <x-auth.form title="Сброс пароля" method="POST" action="{{ route('password.reset') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <x-auth.text-field type="email" name="email" value="{{ $email }}" placeholder="E-mail"
                           :isError="$errors->has('email')"></x-auth.text-field>
        @error('email')
        <x-auth.error>{{ $message }}</x-auth.error>
        @enderror

        <x-auth.text-field type="password" name="password" value="{{ old('password') }}" placeholder="Пароль"
                           :isError="$errors->has('password')"></x-auth.text-field>
        @error('password')
        <x-auth.error>{{ $message }}</x-auth.error>
        @enderror

        <x-auth.text-field type="password" name="password_confirmation" placeholder="Повтор пароля"></x-auth.text-field>
        <x-auth.btn-primary>Сбросить</x-auth.btn-primary>
    </x-auth.form>
@endsection
