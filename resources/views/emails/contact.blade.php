<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8">
</head>

<body>

    <h2>Prise de contact</h2>

    <p>Réception d'une prise de contact avec les éléments suivants :</p>

    <ul>
        <li><strong>Nom / Prénom</strong> : {{ $contact['name'] }}</li>
        <li><strong>Email</strong> : {{ $contact['email'] }}</li>
        <li><strong>Sujet</strong> : {{ $contact['sujet'] }}</li>
        <li><strong>Message</strong> : {{ $contact['message'] }}</li>
    </ul>

    <h4><b>Cordialement</b></h4>

    <h4 style="margin: 1.5rem 0;"><b>Gaëtan Seigneur</b></h4>

    <div>
        <img style="max-width: 90px" src="https://portfolio-gaetan.fr/img/icons/favicon.png" alt="">
    </div>

</body>

</html>
