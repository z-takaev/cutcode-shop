@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    @auth()
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit">Logout</button>
        </form>
    @endauth
@endsection
