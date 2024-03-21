<?php 
function qrcode($photoNumber) {
        $baseUrl = "https://contest.highfivelabs.org/?vote=";
        $url = $baseUrl . $photoNumber;

        // Générer le QR Code avec l'URL spécifiée
        return "<img class='barcode' src='https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($url) . "&amp;size=200x200' width='200' height='200' />";
    }
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>qrcode</title>
  <style>
    body {
        font-family: 'Roboto', sans-serif; /* Exemple de police Google Fonts */
    }
</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
</head>
<body>
<?php for ($counter = 1; $counter <= 10; $counter++): ?>
          
          <thead>
    <tr>
      <th><h1>Photo <?= $counter ?></h1></th>
      <th> </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><img src="photos/<?= $counter ?>.jpg" alt="Photo <?= $counter ?>" style="max-width: 200px; max-height: 200px;"/></td>
      <td><?php echo qrcode($counter); ?></td>
    </tr>
    <tr>
      <td><p>lien du QRCode :</p></td>
      <td><a href="https://contest.highfivelabs.org/?vote=<?= $counter ?>">https://contest.highfivelabs.org/?vote=<?= $counter ?></a></td>
    </tr>
    <!-- Répétez cette structure pour chaque ligne du tableau -->
  </tbody>
<?php endfor; ?>
<hr>
<h1>QRCode Board :</h1>
<br>
<img class='barcode' src='https://api.qrserver.com/v1/create-qr-code/?data=https://contest.highfivelabs.org/board.html&amp;size=200x200' width='200' height='200' />
</body>
</html>