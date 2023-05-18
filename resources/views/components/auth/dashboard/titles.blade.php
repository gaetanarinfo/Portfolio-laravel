@switch(Route::current()->getName())
    @case('dashboard')
        <title>Espace utilisateur</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('add-article')
        <title>Ajouter un article au blog</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('show-blog')
        <title>Les articles de mon blog</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('show-users')
        <title>Les utilisateurs de mon blog</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('show-projets')
        <title>Les projets de mon blog</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('show-projets')
        <title>Les projets de mon blog</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('show-orders-google')
        <title>Les commandes Google Play</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('show-orders-client')
        <title>Mes commandes</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @case('show-apps')
        <title>Mes applications achetées</title>
        <meta name="description" content="{{ config('app.description') }}">
    @break

    @default
        <title>{{ config('app.title') }}</title>
        <meta name="description" content="{{ config('app.description') }}">
@endswitch
