@switch(Route::current()->getName())
    @case('blog')
        <title>Bienvenue sur mon super blog 📚</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('article')
        <title>{{ $article->title }}</title>
        <meta name="description" content="{{ $article->small_content }}">
    @break

    @default
        <title>{{ config('app.title') }}</title>
        <meta name="description" content="{{ config('app.description') }}">
@endswitch

@switch(Route::current()->getName())
    @case('article')
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->full() }}">
        <meta property="og:title" content="{{ $article->title }}">
        <meta property="og:description" content="{{ $article->small_content }}">
        <meta property="og:image" content="{{ URL::asset('img/news') }}/{{ $article->image }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->full() }}">
        <meta property="twitter:title" content="{{ $article->title }}">
        <meta property="twitter:description" content="{{ $article->small_content }}">
        <meta property="twitter:image" content="{{ URL::asset('img/news') }}/{{ $article->image }}">
    @break

    @default
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->full() }}">
        <meta property="og:title" content="{{ config('app.title') }}">
        <meta property="og:description" content="{{ config('app.description') }}">
        <meta property="og:image" content="{{ URL::asset('img/bg_image_1.jpg') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->full() }}">
        <meta property="twitter:title" content="{{ config('app.title') }}">
        <meta property="twitter:description" content="{{ config('app.description') }}">
        <meta property="twitter:image" content="{{ URL::asset('img/bg_image_1.jpg') }}">
@endswitch

<link rel="canonical" href="{{ url()->full() }}">
