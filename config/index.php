<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Certificate Verification</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Digital Certificate Verification</h1>
        <form action="proses.php" method="post">
            <label for="message">Pesan:</label>
            <textarea id="message" name="message" rows="4" required></textarea><br><br>

            <label for="prime1">Bilangan Prima Pertama (p):</label>
            <input type="number" id="prime1" name="prime1" required min="2"><br><br>

            <label for="prime2">Bilangan Prima Kedua (q):</label>
            <input type="number" id="prime2" name="prime2" required min="2"><br><br>

            <button type="submit">Proses</button>
        </form>
    </div>
</body>
</html>
