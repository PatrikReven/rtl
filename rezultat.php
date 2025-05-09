<?php
session_start();
if (!isset($_SESSION['players'], $_SESSION['num_rounds'], $_SESSION['num_dice'])) {
    header("Location: index.php");
    exit();
}

$players = $_SESSION['players'];
$numRounds = $_SESSION['num_rounds'];
$numDice = $_SESSION['num_dice'];

$diceResults = [];
$totals = array_fill(0, count($players), 0);

foreach ($players as $i => $player) {
    for ($r = 0; $r < $numRounds; $r++) {
        $round = [];
        for ($d = 0; $d < $numDice; $d++) {
            $roll = rand(1, 6);
            $round[] = $roll;
            $totals[$i] += $roll;
        }
        $diceResults[$i][$r] = $round;
    }
}

$max = max($totals);
$winners = [];
foreach ($totals as $i => $score) {
    if ($score == $max) {
        $winners[] = $players[$i]['ime'] . ' ' . $players[$i]['priimek'];
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Rezultat igre</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle, #0d0d0d, #000000);
            color: #ffd700;
            font-family: 'Orbitron', sans-serif;
            padding: 20px;
            overflow-x: hidden;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: rgba(0, 0, 0, 0.85);
            border: 2px solid #ffcc00;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 0 50px rgba(255, 215, 0, 0.5);
        }

        h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #ffcc00;
            text-shadow: 0 0 20px #ffcc00;
        }

        .player-box {
            background: #1a1a1a;
            padding: 20px;
            margin-bottom: 20px;
            border: 2px solid #ff9900;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(255, 136, 0, 0.5);
        }

        .dice-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
    justify-content: center;
}


        .dice-img {
            width: 60px;
            height: 60px;
        }

        .score {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .winner-box, .tie-box {
            margin-top: 40px;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            font-size: 1.6rem;
            font-weight: bold;
            color: white;
            display: none;
            animation: pulse 1s infinite;
        }

        .winner-box {
            background: linear-gradient(to right, #e52d27, #ff6a00);
            box-shadow: 0 0 40px rgba(255, 106, 0, 0.9);
        }

        .tie-box {
            background: linear-gradient(45deg, #ff0033, #ff6600);
            text-shadow: 0 0 20px #fff;
            box-shadow: 0 0 40px rgba(255, 50, 50, 0.8);
        }

        .redirect {
            font-style: italic;
            font-size: 0.9rem;
            margin-top: 10px;
            color: #eee;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        #introScreen {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: black;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            animation: fadeOut 1s ease-out 3.5s forwards;
        }

        #introScreen h1 {
            color: gold;
            font-size: 3rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 0 0 20px #ff0, 0 0 40px #f00;
            animation: glow 1s ease-in-out infinite alternate;
        }

        #introScreen p {
            color: #ccc;
            font-size: 1.2rem;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        @keyframes glow {
            from { text-shadow: 0 0 10px #ffd700, 0 0 20px #ff0000; }
            to { text-shadow: 0 0 20px #ff6600, 0 0 40px #ff0000; }
        }

        #roundLabel {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #00ffcc;
            text-shadow: 0 0 15px #00ffcc;
        }
    </style>
</head>
<body>

<!-- Intro ekran -->
<div id="introScreen">
    <h1>🎰 KOCKICA 🎲</h1>
    <p>Pripravljamo kocke...</p>
</div>


<div class="container">
    <h2>Rezultati igre</h2>
    <div id="roundLabel"></div>

    <?php foreach ($players as $i => $player): ?>
        <div class="player-box" id="player-<?= $i ?>">
            <strong><?= htmlspecialchars($player['ime']) . ' ' . htmlspecialchars($player['priimek']) ?></strong><br>
            <small><?= htmlspecialchars($player['naslov']) ?></small>
            <div id="dice-area-<?= $i ?>"></div>
            <div class="score" id="score-<?= $i ?>"></div>
        </div>
    <?php endforeach; ?>

    <div class="winner-box" id="winnerBox">
        🏆 Zmagovalec: <?= implode(', ', $winners) ?> 🏆
        <div class="redirect">Preusmeritev v 10 sekundah...</div>
    </div>

    <div class="tie-box" id="tieBox">
        🔥 IZENAČENJE! 🔥<br>
        Igralci: <?= implode(', ', $winners) ?>
        <div class="redirect">Preusmeritev v 10 sekundah...</div>
    </div>
</div>

<!-- Konfeti -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
const diceResults = <?= json_encode($diceResults) ?>;
const totals = <?= json_encode($totals) ?>;
const numRounds = <?= $numRounds ?>;
const numDice = <?= $numDice ?>;
const winners = <?= json_encode($winners) ?>;

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function playGame() {
    const roundLabel = document.getElementById('roundLabel');

    for (let r = 0; r < numRounds; r++) {
        roundLabel.textContent = `🎯 Runda ${r + 1}`;
        for (let i = 0; i < diceResults.length; i++) {
            const playerArea = document.getElementById('dice-area-' + i);
            const round = diceResults[i][r];

            const roundBox = document.createElement('div');
            roundBox.className = 'dice-container';

            round.forEach(roll => {
                const img = document.createElement('img');
                img.src = 'http://193.2.139.22/dice/dice-anim.gif';
                img.className = 'dice-img';
                roundBox.appendChild(img);

                setTimeout(() => {
                    img.src = `http://193.2.139.22/dice/dice${roll}.gif`;
                }, 800);
            });

            playerArea.appendChild(roundBox);
        }
        await sleep(1000 + numDice * 150);
    }

    roundLabel.textContent = "";

    for (let i = 0; i < totals.length; i++) {
        document.getElementById('score-' + i).textContent = "Skupaj: " + totals[i];
    }

    if (winners.length > 1) {
        document.getElementById('tieBox').style.display = 'block';
        confetti({ particleCount: 250, spread: 120, origin: { y: 0.6 }, colors: ['#ff0000', '#ff3333'] });
    } else {
        document.getElementById('winnerBox').style.display = 'block';
        confetti({ particleCount: 300, spread: 120, origin: { y: 0.6 }, colors: ['#ffd700', '#fff8dc'] });
    }

    setTimeout(() => {
        window.location.href = 'index.php';
    }, 10000);
}

window.onload = () => {
    setTimeout(playGame, 3500);
};
</script>
</body>
</html>
