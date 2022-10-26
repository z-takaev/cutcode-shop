@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
    <x-auth.form title="Восстановление пароля">
        @csrf

        <x-auth.text-field type="email" name="email" placeholder="E-mail"></x-auth.text-field>
        <x-auth.btn-primary>Восстановить</x-auth.btn-primary>

        <x-slot:links>
            <div class="text-xxs md:text-xs">
                <a
                    href="{{ route('auth.sign-in') }}"
                    class="text-white hover:text-white/70 font-bold">Вспомнил пароль</a>
            </div>
        </x-slot:links>
    </x-auth.form>
@endsection
