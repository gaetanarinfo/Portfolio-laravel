<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8">
</head>

<body>

    <h2>Modification de votre mot de passe sur mon portfolio.</h2>

    <p>Vous avez demander une modification de votre mot de passe le {{ date('d/m/Y à H:i') }}.</p>

    <p><a href="https://portfolio-gaetan.fr/forgot-password/{{ $contact['tokens'] }}">Cliquez-ici</a>.</p>

    <p>Si ce n'est pas le cas merci de me contacter au plus vite.</p>

    <h4><b>Cordialement</b></h4>

    <h4 style="margin: 1.5rem 0;"><b>Gaëtan Seigneur</b></h4>

    <div>
        <img style="max-width: 90px" src="https://portfolio-gaetan.fr/img/icons/favicon.png" alt="">
    </div>

</body>

</html>
