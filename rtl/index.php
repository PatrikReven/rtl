<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['users'] = [
        [
            'ime' => $_POST['ime1'],
            'priimek' => $_POST['priimek1'],
            'naslov' => $_POST['naslov1'],
        ],
        [
            'ime' => $_POST['ime2'],
            'priimek' => $_POST['priimek2'],
            'naslov' => $_POST['naslov2'],
        ],
        [
            'ime' => $_POST['ime3'],
            'priimek' => $_POST['priimek3'],
            'naslov' => $_POST['naslov3'],
        ],
    ];
    header("Location: rezultat.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulacija igre s kockami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #1b1b1b;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #242424;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.5);
        }

        h2 {
            text-align: center;
            color: #ffcc00;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        fieldset {
            border: 1px solid #ffcc00;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
        }

        legend {
            padding: 0 8px;
            font-size: 1rem;
            color: #ffcc00;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .form-control {
            padding: 6px 10px;
            font-size: 0.9rem;
            background: #333;
            color: white;
            border: 1px solid #555;
        }

        .form-control:focus {
            border-color: #ffcc00;
            box-shadow: none;
        }

        .btn-submit {
            background: #ff6600;
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            font-weight: bold;
            border-radius: 6px;
            margin-top: 10px;
            transition: 0.2s ease;
        }

        .btn-submit:hover {
            background: #ff8800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Vnesite podatke za 3 igralce</h2>
        <form method="post">
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <fieldset>
                    <legend>Uporabnik <?= $i ?></legend>
                    <div class="mb-3">
                        <label for="ime<?= $i ?>" class="form-label">Ime:</label>
                        <input type="text" class="form-control" id="ime<?= $i ?>" name="ime<?= $i ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="priimek<?= $i ?>" class="form-label">Priimek:</label>
                        <input type="text" class="form-control" id="priimek<?= $i ?>" name="priimek<?= $i ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="naslov<?= $i ?>" class="form-label">Naslov:</label>
                        <input type="text" class="form-control" id="naslov<?= $i ?>" name="naslov<?= $i ?>" required>
                    </div>
                </fieldset>
            <?php endfor; ?>
            <button type="submit" class="btn btn-submit">Začni igro</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>