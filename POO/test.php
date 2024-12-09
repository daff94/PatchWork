<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php
    require "connexion.php";
    $connexionBase  = new Connexion("localhost","root","","patchwork");

    $result = $connexionBase->lanceSQL("select * from image;");
    
    if ($connexionBase->statusconnect()) {
        while ($row = mysqli_fetch_array($result)) {
            echo $row[2];
        }
    }   
   
    $connexionBase->statusconnect();
    $connexionBase->fermerdatabase();    
    ?>

</body>
</html>