<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $groupNumber = $_POST["groupNumber"];
    $meters = $_POST["meters"] ?? [];
    $directions = $_POST["direction"] ?? [];

    $x = 9.0;
    $y = 1.0;

    $targetX = 4.0;
    $targetY = 5.5;
    $maxDistance = 11.0;
    $totalDistance = 0.0;

    $obstacles = [
        ['x1' => 5.0, 'y1' => 1.0, 'x2' => 6.0, 'y2' => 2.0],
        ['x1' => 6.0, 'y1' => 2.0, 'x2' => 8.0, 'y2' => 6.0],
        ['x1' => 4.0, 'y1' => 7.5, 'x2' => 8.0, 'y2' => 10.0],
    ];

    function isInsideOrTouchingObstacle($x, $y, $obstacles) {
        foreach ($obstacles as $o) {
            if ($x >= $o['x1'] && $x <= $o['x2'] && $y >= $o['y1'] && $y <= $o['y2']) {
                return true;
            }
        }
        return false;
    }

    for ($i = 0; $i < count($meters); $i++) {
        $stepLength = floatval($meters[$i]);
        $dir = $directions[$i];

        $stepX = 0.0;
        $stepY = 0.0;

        switch ($dir) {
            case "rechts": $stepX = $stepLength; break;
            case "links":  $stepX = -$stepLength; break;
            case "oben":   $stepY = $stepLength; break;
            case "unten":  $stepY = -$stepLength; break;
            default: showError("Ungültige Richtung bei Schritt " . ($i + 1));
        }

        $steps = max(abs($stepX), abs($stepY)) * 2;
        for ($j = 1; $j <= $steps; $j++) {
            $intermediateX = $x + ($stepX * $j / $steps);
            $intermediateY = $y + ($stepY * $j / $steps);

            if (isInsideOrTouchingObstacle($intermediateX, $intermediateY, $obstacles)) {
                showError("❌ Die Drohne ist bei (" . round($intermediateX, 2) . ", " . round($intermediateY, 2) . ") gegen ein Hindernis geflogen!");
            }
        }

        $x += $stepX;
        $y += $stepY;
        $totalDistance += $stepLength;
    }

    if (abs($x - $targetX) > 0.01 || abs($y - $targetY) > 0.01) {
        showError("❌ Die Drohne hat das Ziel nicht erreicht! Aktuelle Position: (" . round($x, 2) . ", " . round($y, 2) . ")");
    }

    if ($totalDistance > $maxDistance) {
        showError("❌ Die Drohne hatte nicht genug Akku (Strecke: " . round($totalDistance, 2) . " m) und ist abgestürzt.");
    }


    $groupHints = [
        "1" => "Herr Tröger hat ein Alibi, er ist nicht der Täter.",
        "2" => "Der Täter unterrichtet nicht Wirtschaft.",
        "3" => "Der Täter unterrichtet nicht Geographie und nicht Musik.",
        "4" => "Der Täter unterrichtet nicht Geographie und nicht Musik.",
        "5" => "Der Täter unterrichtet nicht Wirtschaft.",
        "6" => "Frau Frauenholz hat ein Alibi, sie ist nicht der Täter.",
        "7" => "Frau Pfeiffer hat ein Alibi, sie ist nicht der Täter."
    ];

    $hint = $groupHints[$groupNumber] ?? "Hinweis nicht verfügbar.";


    showHint("Hinweis für Gruppe $groupNumber", $hint);
}



function showError($msg) {
    renderPage("Flugfehler", $msg, true);
}


function showHint($title, $msg) {
    renderPage($title, $msg, false);
}


function renderPage($title, $msg, $isError = false) {
    $buttonText = "Zurück zur Eingabe";
    $buttonLink = "index.html";
    echo "<!DOCTYPE html><html lang='de'><head><meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>" . htmlspecialchars($title) . "</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
                color: #333;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                max-width: 500px;
                background: white;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .hint {
                font-size: 18px;
                font-weight: bold;
                padding: 15px;
                background: #e9ecef;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            .btn {
                display: block;
                margin: 20px auto 0;
                padding: 12px 20px;
                font-size: 18px;
                font-weight: bold;
                color: white;
                background-color: #007bff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
            }
            .btn:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>" . htmlspecialchars($title) . "</h2>
            <div class='hint'>" . htmlspecialchars($msg) . "</div>
            <a href='" . htmlspecialchars($buttonLink) . "' class='btn'>" . htmlspecialchars($buttonText) . "</a>
        </div>
    </body></html>";
    exit();
}
?>
