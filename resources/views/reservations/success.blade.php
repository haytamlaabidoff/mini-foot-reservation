<!DOCTYPE html>
<html>
<head>
    <title>Réservation confirmée ddddddd</title>
</head>
<body>

<h1>🎉 Paiement confirmé !</h1>

<p>Votre réservation est validée avec succès.</p>
<p>⚽ Vous pouvez maintenant jouer sur le terrain.</p>

<hr>

<p><strong>Date:</strong> {{ $reservation->reservation_date }}</p>
<p><strong>Heure:</strong> {{ $reservation->start_time }} - {{ $reservation->end_time }}</p>
<p><strong>Status:</strong> {{ $reservation->payment_status }}</p>

<hr>

<p>QR Code :</p>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $qrUrl }}">

</body>
</html>