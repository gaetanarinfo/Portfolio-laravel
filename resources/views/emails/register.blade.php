<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8">
</head>

<body>

    <h2>Inscription sur mon portfolio.</h2>

    <p>Tout d'abord merci pour votre inscription.</p>

    <p>Vos informations :</p>

    <ul>
        @if(!empty($contact['firstname']))<li><strong>Nom</strong> : {{ $contact['lastname'] }}</li>@else <li><strong>Nom</strong> : {{ $contact['name'] }}</li> @endif
        @if(!empty($contact['firstname']))<li><strong>Prenom</strong> : {{ $contact['firstname'] }}</li>@endif
        <li><strong>Email</strong> : {{ $contact['email'] }}</li>
        <li><strong>Mot de passe</strong> : {{ $contact['password'] }}</li>
    </ul>

    <p>Modifier ou réinitialiser votre mot de passe <a href="https://portfolio-gaetan.fr/forgot-password/{{ $contact['token'] }}">cliquez-ici</a></p>

    <h4><b>Cordialement</b></h4>

    <h4 style="margin: 1.5rem 0;"><b>Gaëtan Seigneur</b></h4>

    <div>
        <img style="max-width: 90px; border-radius: 50%;" src="https://portfolio-gaetan.fr/img/logo.png" alt="">
    </div>

</body>

</html>
