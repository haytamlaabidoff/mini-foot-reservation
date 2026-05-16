<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QR Scanner</title>

<script src="https://unpkg.com/html5-qrcode"></script>

<style>
body {
    background-color: #121212;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
}

.scanner-container {
    background-color: #0f0f0f;
    width: 320px;
    padding: 30px 20px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}

.title {
    color: white;
    margin-bottom: 20px;
}

/* STATUS */
#status {
    margin-bottom: 15px;
    padding: 10px;
    border: 2px solid orange;
    color: white;
}

/* ZONE CAMERA */
#reader {
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
}

/* RESULT */
#result {
    margin-top: 15px;
    color: white;
}

/* BUTTON */
.scan-button {
    background-color: #31e163;
    color: #121212;
    border: none;
    padding: 12px;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
    margin-top: 15px;
}
</style>

</head>
<body>

<div class="scanner-container">

    <h2 class="title">📷 Scanner QR Code</h2>

    <!-- STATUS -->
    <div id="status">🟡 En attente de scan...</div>

    <!-- CAMERA -->
    <div id="reader"></div>

    <!-- RESULT -->
    <div id="result"></div>

    <!-- BUTTON -->
    <button class="scan-button" onclick="startScanner()">🎥 Scanner</button>

</div>

<script>

let html5QrCode;

// 🎯 SUCCESS
function onScanSuccess(decodedText) {

    console.log("QR:", decodedText);

    // 🟢 status
    document.getElementById('status').innerHTML = "🟢 QR détecté, redirection...";
    document.getElementById('status').style.borderColor = "green";

    // 🔥 استخراج TOKEN
    let token = decodedText;

    if (decodedText.includes('/')) {
        let parts = decodedText.split('/');
        token = parts[parts.length - 1];
    }

    console.log("TOKEN:", token);

    // ⛔ stop scanner
    html5QrCode.stop().then(() => {

        // 🚀 REDIRECTION CORRECTE
        window.location.href = "/verify-payment/" + token;

    });
}
// ❌ ERROR
function onScanFailure(error) {}

// 🚀 START
function startScanner() {

    document.getElementById('status').innerHTML = "📷 Scan en cours...";
    document.getElementById('status').style.borderColor = "blue";

    html5QrCode = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(cameras => {

        if (!cameras.length) {
            alert("No camera found");
            return;
        }

        html5QrCode.start(
            cameras[0].id,
            {
                fps: 15,
                qrbox: { width: 250, height: 250 }
            },
            onScanSuccess,
            onScanFailure
        );
    });
}

</script>

</body>
</html>