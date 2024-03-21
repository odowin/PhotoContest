<?php
// Fonction pour obtenir le top 3 des options les plus votées avec leur nombre de votes
function getTopThreeOptionsWithVotes() {
    // Récupérer les votes existants
    $votes = [];
    if (file_exists('votes.txt')) {
        $votes = json_decode(file_get_contents('votes.txt'), true);
    }
    // Initialiser un tableau associatif pour stocker le nombre de votes pour chaque option
    $voteCounts = [];
    // Parcourir les votes et compter les votes pour chaque option
    foreach ($votes as $vote) {
        if (isset($voteCounts[$vote])) {
            $voteCounts[$vote]++;
        } else {
            $voteCounts[$vote] = 1;
        }
    }
    // Trier le tableau en ordre décroissant de nombre de votes
    arsort($voteCounts);
    // Récupérer les trois premières options (clés) du tableau trié avec leur nombre de votes
    $topThreeOptionsWithVotes = array_slice($voteCounts, 0, 3, true);
    return $topThreeOptionsWithVotes;
}

// Récupérer les trois premières options les plus votées avec leur nombre de votes
$topThreeOptionsWithVotes = getTopThreeOptionsWithVotes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 des photos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
        }
        .grid-item {
            text-align: center;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .grid-item img {
            width: 100%;
            height: auto;
        }
        .grid-item .caption {
            padding: 10px;
            background-color: #f8f8f8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Top 3 des photos les plus votées :</h1>
        <!-- Afficher les trois premières options avec leurs nombres de votes -->
        <div class="grid">
            <?php foreach ($topThreeOptionsWithVotes as $option => $voteCount): ?>
            <div class="grid-item">
                <img src="photos/<?= $option ?>.jpg" alt="Photo <?= $option ?>">
                <div class="caption">Vote<?= $voteCount > 1 ? 's' : '' ?> : <?= $voteCount ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
