<?php
// Generate RSA Key Pair
function generateKeyPair() {
    $config = [
        "digest_alg" => "sha256",
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    ];

    $keyPair = openssl_pkey_new($config);
    openssl_pkey_export($keyPair, $privateKey);

    $publicKey = openssl_pkey_get_details($keyPair)["key"];

    return ["privateKey" => $privateKey, "publicKey" => $publicKey];
}

// Sign data with private key
function signData($data, $privateKey) {
    openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
    return base64_encode($signature);
}

// Verify signature with public key
function verifySignature($data, $signature, $publicKey) {
    $decodedSignature = base64_decode($signature);
    return openssl_verify($data, $decodedSignature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
}

// Example Usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'generate') {
        $keys = generateKeyPair();
        file_put_contents('private.key', $keys['privateKey']);
        file_put_contents('public.key', $keys['publicKey']);
        echo "Keys generated and saved!";
    } elseif ($action === 'sign') {
        $data = $_POST['data'];
        $privateKey = file_get_contents('private.key');
        $signature = signData($data, $privateKey);
        echo "Signature: " . $signature;
    } elseif ($action === 'verify') {
        $data = $_POST['data'];
        $signature = $_POST['signature'];
        $publicKey = file_get_contents('public.key');
        $isValid = verifySignature($data, $signature, $publicKey);
        echo $isValid ? "Signature is valid!" : "Signature is invalid!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>RSA Digital Certificate Verification</title>
</head>
<body>
    <form method="POST">
        <button name="action" value="generate">Pembuatan Kunci</button>
    </form>

    <form method="POST">
        <textarea name="data" placeholder="Enter data to sign" required></textarea><br>
        <button name="action" value="sign">Sign Data</button>
    </form>

    <form method="POST">
        <textarea name="data" placeholder="Enter data to verify" required></textarea><br>
        <textarea name="signature" placeholder="Enter signature" required></textarea><br>
        <button name="action" value="verify">Verify Certificate</button>
    </form>
</body>
</html>