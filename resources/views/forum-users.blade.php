<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('components/titles')

    @include('components/icons')

    @include('components/styles')

</head>

<body @if (Cookie::get('theme') !== null) class="{{ Cookie::get('theme') }} disputo" @else class="theme-red disputo" @endif>

    @include('components/settings')

    @include('components/header')

    @include('components/forum/users')

    @include('components/footer')

    @include('components/scripts')

</body>

</html>
