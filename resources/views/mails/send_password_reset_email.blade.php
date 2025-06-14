<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            color: #fff;
            background-color: #F97316;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #E85D04;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Kata Sandi Anda</h2>
        <p>Halo, {{ $name }}</p>
        <p>Kami menerima permintaan untuk mereset kata sandi Anda. Klik tombol di bawah ini untuk mereset kata sandi Anda:</p>
        <a href="{{ $resetLink }}" class="button">Reset Kata Sandi</a>
        <p>Jika Anda tidak meminta reset kata sandi, harap abaikan email ini atau hubungi dukungan jika Anda memiliki pertanyaan.</p>
        <p>Terima kasih,<br>IITC 2024</p>
    </div>
</body>
</html>
