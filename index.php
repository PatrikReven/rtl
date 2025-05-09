<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['num_players'] = (int)$_POST['num_players'];
    $_SESSION['num_rounds'] = (int)$_POST['num_rounds'];
    $_SESSION['num_dice'] = (int)$_POST['num_dice'];
    header("Location: players.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Nastavitve igre s kockami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at center, #111, #000);
            color: #ffd700;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #222;
            border: 2px solid #ffd700;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.6);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-primary {
            background: linear-gradient(to right, #ffcc00, #ff8800);
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #ffaa00, #ff5500);
        }

        label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>⚅ Nastavitve igre s kockami ⚅</h2>
    <form method="post">
        <div class="mb-3">
            <label for="num_players">Število igralcev:</label>
            <select class="form-control" name="num_players" id="num_players" required>
                <?php for ($i = 2; $i <= 6; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="num_rounds">Število rund:</label>
            <select class="form-control" name="num_rounds" id="num_rounds" required>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="num_dice">Število kock na rundo:</label>
            <select class="form-control" name="num_dice" id="num_dice" required>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Naprej ➜</button>
    </form>
</div>
</body>
</html>
