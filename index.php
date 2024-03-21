<?php

// Récupérer l'adresse IP de l'utilisateur
$ip = $_SERVER['REMOTE_ADDR'];
// Vérifier si l'utilisateur a déjà voté
$votedOption = getVotedOption($ip);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Photo constest</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
</head>
<body>
    <div class="widget center">

  <div class="blur"></div>

  <div class="text center">
    <h1 class="">Photo contest</h1>
    <?php

// Vérifier si un vote a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['vote'])) {
  $votedOption = $_GET['vote'];
  $ip = $_SERVER['REMOTE_ADDR']; // Récupérer l'adresse IP de l'utilisateur
  // Enregistrer le vote et l'adresse IP dans un fichier
  saveVoteAndIP($votedOption, $ip);
  // Afficher un message de confirmation
  echo "<p>Merci pour votre vote pour la photo $votedOption !</p>";
} elseif ($votedOption !== null) {
  echo "<p>Vous avez déjà voté pour la photo $votedOption.</p>";
}

// Fonction pour enregistrer le vote et l'adresse IP dans un fichier
function saveVoteAndIP($votedOption, $ip) {
    // Récupérer les votes existants
    $votes = [];
    if (file_exists('votes.txt')) {
        $votes = json_decode(file_get_contents('votes.txt'), true);
    }
    // Enregistrer le vote avec l'adresse IP comme clé
    $votes[$ip] = $votedOption;
    // Écrire les votes dans le fichier
    file_put_contents('votes.txt', json_encode($votes));
}

// Fonction pour obtenir l'option pour laquelle un utilisateur a voté
function getVotedOption($ip) {
  // Récupérer les votes existants
  $votes = [];
  if (file_exists('votes.txt')) {
      $votes = json_decode(file_get_contents('votes.txt'), true);
  }
  // Vérifier si l'adresse IP a déjà voté
  if (isset($votes[$ip])) {
      return $votes[$ip];
  }
  return null; // Si l'adresse IP n'a pas encore voté
}

// Fonction pour compter les votes pour une option donnée
function countVotes($option) {
    // Récupérer les votes existants
    $votes = [];
    if (file_exists('votes.txt')) {
        $votes = json_decode(file_get_contents('votes.txt'), true);
    }
    // Compter les votes pour l'option donnée
    $count = 0;
    foreach ($votes as $vote) {
        if ($vote === $option) {
            $count++;
        }
    }
    return $count;
}

// Fonction pour obtenir le top 3 des options les plus votées
function getTopThreeOptions() {
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
  // Récupérer les trois premières options (clés) du tableau trié
  $topThreeOptions = array_slice(array_keys($voteCounts), 0, 3);
  return $topThreeOptions;
}

// Récupérer les trois premières options les plus votées
$topThreeOptions = getTopThreeOptions();
?>
  </div>

</div>


<style>
    body {
        font-family: 'Roboto', sans-serif; /* Exemple de police Google Fonts */
    }
    
    
    body {
      background: url("photos/<?= $votedOption ?>.jpg")
        no-repeat center center fixed;
      background-size: cover;
    }
    
    .blur {
      background: url("photos/<?= $votedOption ?>.jpg")
        no-repeat center center fixed;
      background-size: cover;
      overflow: hidden;
      filter: blur(13px);
      position: absolute;
      height: 300px;
      top: -50px;
      left: -50px;
      right: -50px;
      bottom: -50px;
    }
    
    .widget {
      border-top: 2px solid rgba(255, 255, 255, 0.5);
      border-bottom: 2px solid rgba(255, 255, 255, 0.5);
      height: 200px;
      width: 100%;
      overflow: hidden;
    }
    
    .center {
      position: absolute;
      margin: auto;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
    }
    
    /*  NOT REQUIRED  */
    
    .text {
      height: 200px;
      width: 340px;
    }
    
    .text h1 {
      text-align: center;
      text-shadow: 1px 1px rgba(0, 0, 0, 0.1);
      color: #ffffff;
      margin-top: 57px;
      font-family: "Lora", serif;
      font-weight: 700;
      font-size: 38px;
    }
    
    .text p {
      text-align: center;
      color: #ffffff;
      text-shadow: 1px 1px rgba(0, 0, 0, 0.1);
      margin-top: 0px;
      font-family: "Lato", serif;
      font-weight: 400;
      font-size: 22px;
    }

</style>
</body>
</html>