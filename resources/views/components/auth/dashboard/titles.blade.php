@switch(Route::current()->getName())
    @case('dashboard')
        <title>Espace utilisateur</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @default
        <title>{{ config('app.title') }}</title>
        <meta name="description" content="{{ config('app.description') }}">
@endswitch
