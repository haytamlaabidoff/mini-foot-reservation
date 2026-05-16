<!DOCTYPE html>
<html>
<head>
    <title>Rappel Réservation</title>
</head>
<body>

<h2>Bonjour {{ $reservation->user->name ?? $reservation->client_name }}</h2>

<p>🎾 Ceci est un rappel pour votre réservation aujourd’hui.</p>

<p>
📅 Date: {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y') }}<br>
⏰ Heure: {{ $reservation->start_time }} - {{ $reservation->end_time }}
</p>

<p>Merci 🙏</p>

</body>
</html>