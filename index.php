<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PatchWork</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/modale.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
</head>
<body>


<!-- Chargement du menu principal du site -->
<?php include 'menu_principal.html' ?>

<div class="container-fluid">
  <div class="row" >
    <div id="TextePresentation" class="col-8">
      <p>Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.</p>
    </div>
    <div class="col-4"><img src="images/presentation/mockup02.jpg" class="rounded img-thumbnail" ></div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-4"><img src="images/presentation/mockup01.jpg" class="rounded img-thumbnail" ></div>
    <div class="col-4"><img src="images/presentation/mockup02.jpg" class="rounded img-thumbnail" ></div>
    <div class="col-4"><img src="images/presentation/mockup03.jpg" class="rounded img-thumbnail" ></div>
  </div>
</div>  
</div>  

  
<!-- Fenetre A PROPOS seulement accessible depuis le menu "A propos" -->
  <div id="apropos" class="modal">
    <div class="modal_content">
      <h1>PatchWork - v0.2-2024</h1>
      <p>Réalisé en HTML, CSS, PHP et MySql<br>Développé avec IDE VSCode et IntelliJ</p>
      <p>Fabriqué par Yoann Tessier</p>
      <a href="#" class="modal_close">&times;</a>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
  

</html>