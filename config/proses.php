<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $message = $_POST['message'];
    $p = intval($_POST['prime1']);
    $q = intval($_POST['prime2']);

    // Validasi bilangan prima
    if (!isPrime($p) || !isPrime($q)) {
        die("Salah satu atau kedua bilangan bukan bilangan prima.");
    }

    // Fungsi validasi bilangan prima
    function isPrime($num) {
        if ($num < 2) return false;
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i === 0) return false;
        }
        return true;
    }

    // Load fungsi RSA
    include 'rsa_functions.php';

    // Hitung parameter RSA
    list($n, $phi) = calculateParameters($p, $q);
    list($e, $d) = generateKeys($phi);

    // Enkripsi pesan dan buat tanda tangan
    $cipherText = encryptMessage($message, $e, $n);
    $signature = bcpowmod(hash('sha256', $message), $d, $n);

    // Verifikasi tanda tangan
    $isValid = verifyDigitalSignature($message, $signature, $e, $n);

    // Tampilkan hasil
    echo "<h1>Hasil Proses</h1>";
    echo "<p><strong>Pesan Asli:</strong> " . htmlspecialchars($message) . "</p>";
    echo "<p><strong>Pesan Terenkripsi:</strong> $cipherText</p>";
    echo "<p><strong>Tanda Tangan Digital:</strong> $signature</p>";
    echo "<p><strong>Verifikasi:</strong> " . ($isValid ? "Berhasil" : "Gagal") . "</p>";
} else {
    die("Akses tidak valid.");
}
?>
