<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu Réservation - FootBooking</title>
    <style>
        /* Configuration de base pour PDF */
        @page { margin: 0; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 40px;
            color: #374151;
            line-height: 1.5;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        /* En-tête stylisée */
        .header {
            background: #111827; /* Dark Pro */
            color: white;
            padding: 40px;
            text-align: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .logo span { color: #10b981; } /* Touche de vert sport */

        .receipt-title {
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 2px;
            font-weight: 600;
            opacity: 0.8;
        }

        /* Corps du reçu */
        .content {
            padding: 40px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 30px;
            text-transform: uppercase;
        }
        
        .status-confirmed { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .info-row td {
            padding: 16px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .label {
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            width: 40%;
        }

        .value {
            font-size: 15px;
            color: #111827;
            font-weight: 600;
            text-align: right;
        }

        /* Zone QR Code */
        .qr-section {
            text-align: center;
            background: #f9fafb;
            padding: 30px;
            border-top: 1px dashed #d1d5db;
        }

        .qr-code {
            background: white;
            padding: 10px;
            border-radius: 12px;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 10px;
        }

        .qr-instruction {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Pied de page */
        .footer {
            padding: 25px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
        }

        .contact-info {
            margin-bottom: 5px;
            color: #6b7280;
        }
    </style>
</head>
<body>

<div class="container">
    
    <div class="header">

          
        <div class="logo">  <span class="text-xl font-bold text-green-600 tracking-tight">
                {{ $setting->site_name ?? 'Foot' }}
            </span></div>
        <div class="receipt-title">Confirmation Officielle</div>
    </div>

    <div class="content">
        <div style="text-align: center;">
            <span class="status-badge {{ $reservation->payment_status == 'paid' ? 'status-confirmed' : 'status-pending' }}">
                {{ $reservation->payment_status == 'paid' ? 'Réservation Confirmée' : 'Paiement En Attente' }}
            </span>
        </div>

        <table class="info-grid">
            <tr class="info-row">
                <td class="label">Référence</td>
                <td class="value">#FB-{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr class="info-row">
                <td class="label">Terrain</td>
                <td class="value">{{ $reservation->terrain->name }}</td>
            </tr>
            <tr class="info-row">
                <td class="label">Date du match</td>
                <td class="value">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y') }}</td>
            </tr>
            <tr class="info-row">
                <td class="label">Créneau Horaire</td>
                <td class="value">{{ $reservation->start_time }} — {{ $reservation->end_time }}</td>
            </tr>
            <tr class="info-row">
                <td class="label">Client</td>
                <td class="value">{{ auth()->user()->name }}</td>
            </tr>
            <tr class="info-row">
                <td class="label">Mode de Paiement</td>
                <td class="value">{{ strtoupper($reservation->payment_method ?? 'En ligne') }}</td>
            </tr>
        </table>

        <div style="background: #111827; color: white; padding: 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-weight: 600;">Total Réglé</span>
            <span style="font-size: 20px; font-weight: 800;">{{ $reservation->total_price }} €</span>
        </div>
  
        <div class="qr-code">
            <img src="data:image/png;base64,{{ $qr }}" style="width:120px; display: block;">
        </div>
        <p class="qr-instruction">Présentez ce QR Code à l'entrée du complexe.</p>

        <div class="contact-info">Une question ? contact@footbooking.com</div>
        <div>&copy; {{ date('Y') }} FootBooking App. Document généré électroniquement.</div>
    </div>

</div>

</body>
</html>