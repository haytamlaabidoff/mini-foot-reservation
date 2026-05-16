<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding: 50px;
        }
        .box {
            max-width: 600px;
            margin: auto;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            margin-top: 20px;
        }
        .text {
            font-size: 18px;
            color: #555;
            margin-top: 10px;
        }
        .success-img {
            width: 120px;
        }
        .badge {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border-radius: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="box">

    <!-- success icon -->
    <img class="success-img" src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="success">

    <!-- message -->
    <div class="title">🎉 Paiement confirmé !</div>

    <div class="text">
Votre réservation est bien validée. Vous pouvez maintenant accéder au terrain et jouer votre match.    </div>

    <!-- terrain info -->
    <div class="badge">
        ⚽ Terrain is paid — you can play now!
    </div>

    <hr style="margin:30px 0;">

    <p><strong>Reservation ID:</strong> {{ $reservation->id }}</p>
    <p><strong>Status:</strong> {{ $reservation->payment_status }}</p>
    <p><strong>Terrain:</strong> {{ $reservation->terrain->name ?? 'N/A' }}</p>

</div>

</body>
</html>