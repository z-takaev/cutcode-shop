@extends('layouts.auth')

@section('title', 'Сброс пароля')

@section('content')
    <x-auth.form title="Сброс пароля">
        @csrf

        <x-auth.text-field type="email" name="email" placeholder="E-mail"></x-auth.text-field>
        <x-auth.text-field type="password" name="password" placeholder="Пароль"></x-auth.text-field>
        <x-auth.text-field type="password" name="password_confirmation" placeholder="Повтор пароля"></x-auth.text-field>
        <x-auth.btn-primary>Сбросить</x-auth.btn-primary>
    </x-auth.form>
@endsection
