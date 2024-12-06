<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php
    require "connexion.php";
    $connexionBase  = new Connexion("localhost","root","","patchwork");
    //$connectBase->statusconnect();
    // var_dump($connexionBase);
    $connexionBase->lanceSQL("select * from image;");
    $connexionBase->fermerdatabase();
    $connexionBase->statusconnect();
    
    ?>

</body>
</html>