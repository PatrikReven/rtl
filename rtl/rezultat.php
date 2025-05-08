<?php
session_start();
if (!isset($_SESSION['users'])) {
    header("Location: index.php");
    exit();
}

$dice_results = [];
$totals = [];

foreach ($_SESSION['users'] as $i => $user) {
    $rolls = [];
    for ($j = 0; $j < 3; $j++) {
        $rolls[] = rand(1, 6);
    }
    $dice_results[] = $rolls;
    $totals[] = array_sum($rolls);
}

$max = max($totals);
$winners = [];
foreach ($totals as $i => $total) {
    if ($total == $max) {
        $winners[] = $_SESSION['users'][$i]['ime'] . ' ' . $_SESSION['users'][$i]['priimek'];
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezultat igre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #1b1b1b, #2c2c2c);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            background: rgba(30, 30, 30, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        h2, h3 {
            font-family: 'Playfair Display', serif;
            color: #ffcc00;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        h2 {
            margin-bottom: 30px;
        }

        .user-result {
            background: #252525;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 2px solid #ffcc00;
        }

        .user-result strong {
            color: #ffcc00;
            font-size: 1.2rem;
        }

        .dice-container {
            display: flex;
            gap: 10px;
            margin: 10px 0;
        }

        .dice-img {
            width: 60px;
            height: 60px;
            animation: roll 0.5s ease-in-out;
        }

        @keyframes roll {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.2); }
            100% { transform: rotate(360deg) scale(1); }
        }

        .winner {
            background: linear-gradient(to right, #e52d27, #ff6a00);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(255, 106, 0, 0.4);
        }

        .redirect-notice {
            color: #eaeaea;
            text-align: center;
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rezultati igre</h2>
        <?php foreach ($_SESSION['users'] as $i => $user): ?>
            <div class="user-result">
                <strong><?= htmlspecialchars($user['ime']) . ' ' . htmlspecialchars($user['priimek']) ?></strong><br>
                Naslov: <?= htmlspecialchars($user['naslov']) ?><br>
                Kocke:
                <div class="dice-container" id="dice-user-<?= $i ?>">
                    <?php foreach ($dice_results[$i] as $j => $roll): ?>
                        <img src="http://193.2.139.22/dice/dice-anim.gif" 
                             data-final-src="http://193.2.139.22/dice/dice<?= $roll ?>.gif" 
                             alt="kocka <?= $roll ?>" 
                             class="dice-img dice-<?= $i ?>-<?= $j ?>">
                    <?php endforeach; ?>
                </div>
                Skupaj: <?= $totals[$i] ?>
            </div>
        <?php endforeach; ?>

        <h3 class="winner">Zmagovalec: <?= implode(', ', $winners) ?></h3>
        <p class="redirect-notice">Preusmeritev nazaj čez 10 sekund...</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to reveal dice after spinning animation
        function revealDice() {
            const diceContainers = document.querySelectorAll('.dice-container');
            diceContainers.forEach((container, userIndex) => {
                const diceImages = container.querySelectorAll('img');
                diceImages.forEach((img, diceIndex) => {
                    setTimeout(() => {
                        const finalSrc = img.getAttribute('data-final-src');
                        img.src = finalSrc;
                        img.classList.add('roll'); // Trigger roll animation on reveal
                    }, 1000 + (userIndex * 500) + (diceIndex * 200)); // Staggered reveal
                });
            });
        }

        // Trigger dice reveal on page load
        window.onload = revealDice;

        // Redirect after 10 seconds
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 10000);
    </script>
</body>
</html>