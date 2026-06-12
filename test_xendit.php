<?php
$ch2 = curl_init();
curl_setopt_array($ch2, [
    CURLOPT_URL => 'https://api.xendit.co/qr_codes',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_USERPWD => 'xnd_development_75aRrPhFYfNzlQc0UuOdXpZVtyNvPW4PmI6a4M9QVgJOOIVY9YggXoqj6WZnCQ:',
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode([
        'external_id' => 'TEST-' . time(),
        'type' => 'DYNAMIC',
        'callback_url' => 'https://grieving-groovy-tabby.ngrok-free.dev/api/callback-xendit',
        'amount' => 10000
    ])
]);
$res2 = curl_exec($ch2);
echo "Response with user code: " . $res2 . "\n";
