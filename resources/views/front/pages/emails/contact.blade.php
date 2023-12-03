<!DOCTYPE html>
<html>
<head>
    <title>Message du formulaire de contact</title>
</head>
<body>
    <h2>Nouveau message du formulaire de contact</h2>
    
    <p><strong>Nom:</strong> {{ $details['name'] }}</p>
    <p><strong>E-mail:</strong> {{ $details['email'] }}</p>
    <p><strong>Sujet:</strong> {{ $details['subject'] }}</p>
    <p><strong>Message:</strong> {{ $details['message'] }}</p>
</body>
</html>
