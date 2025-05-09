<?php
session_start();
if (!isset($_SESSION['num_players'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $players = [];
    for ($i = 1; $i <= $_SESSION['num_players']; $i++) {
        $players[] = [
            'ime' => $_POST["ime$i"],
            'priimek' => $_POST["priimek$i"],
            'naslov' => $_POST["naslov$i"],
            'rezultati' => []
        ];
    }
    $_SESSION['players'] = $players;
    header("Location: rezultat.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Vnos igralcev</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #111;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #222;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #ffd700;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.4);
        }

        h2 {
            text-align: center;
            color: #ffd700;
        }

        label {
            color: #ccc;
        }

        .btn-primary {
            background: #ffa500;
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background: #ff6600;
        }

        fieldset {
            border: 1px solid #444;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        legend {
            color: #ffcc00;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Vnesi podatke igralcev</h2>
    <form method="post">
        <?php for ($i = 1; $i <= $_SESSION['num_players']; $i++): ?>
            <fieldset>
                <legend>Igralec <?= $i ?></legend>
                <div class="mb-3">
                    <label for="ime<?= $i ?>">Ime:</label>
                    <input type="text" class="form-control" id="ime<?= $i ?>" name="ime<?= $i ?>" required>
                </div>
                <div class="mb-3">
                    <label for="priimek<?= $i ?>">Priimek:</label>
                    <input type="text" class="form-control" id="priimek<?= $i ?>" name="priimek<?= $i ?>" required>
                </div>
                <div class="mb-3">
                    <label for="naslov<?= $i ?>">Naslov:</label>
                    <input type="text" class="form-control" id="naslov<?= $i ?>" name="naslov<?= $i ?>" required>
                </div>
            </fieldset>
        <?php endfor; ?>
        <button type="submit" class="btn btn-primary w-100">Začni igro 🎲</button>
    </form>
</div>
</body>
</html>
