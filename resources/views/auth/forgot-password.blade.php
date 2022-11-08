@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
    @if($status = session('status'))
        {{ $status }}
    @endif

    <x-auth.form title="Восстановление пароля" method="POST" action="{{ route('forgot-password.handle') }}">
        @csrf

        <x-auth.text-field type="email" name="email" value="{{ old('email') }}" placeholder="E-mail"
                           :isError="$errors->has('email')"></x-auth.text-field>
        @error('email')
        <x-auth.error>{{ $message }}</x-auth.error>
        @enderror

        <x-auth.btn-primary>Восстановить</x-auth.btn-primary>

        <x-slot:links>
            <div class="text-xxs md:text-xs">
                <a
                    href="{{ route('login') }}"
                    class="text-white hover:text-white/70 font-bold">Вспомнил пароль</a>
            </div>
        </x-slot:links>
    </x-auth.form>
@endsection
