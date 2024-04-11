<?php
// Ciljna adresa Ratchet WebSocket servera
$targetUrl = 'wss://polovni-telefoni.rs:443';

// Pročitajte zahtev metodom POST ili GET
$request = file_get_contents('php://input');

// Kreirajte novi zahtev prema ciljnoj URL adresi
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // Ovde koristite POST metodu jer je WebSocket handshake obično HTTP zahtev
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

// Prosledite zaglavlja
$headers = [];
foreach (getallheaders() as $name => $value) {
    $headers[] = $name . ': ' . $value;
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Izvršite zahtev
$response = curl_exec($ch);

// Pročitajte status odgovora
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Zatvorite CURL sesiju
curl_close($ch);

// Postavite statusni kod odgovora
http_response_code($status);

// Ispisujte odgovor
echo $response;
?>
