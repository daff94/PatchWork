
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir une couleur</title>
    <scipt src="pickercolor.js"></scipt>
    <script src="../js/jscolor.js"></script>
    <link href="../css/pickercolor.css" rel="stylesheet">

    <script>
    // Here we can adjust defaults for all color pickers on page:
    jscolor.presets.default = {
        position: 'right',
        height: 250,
        width:250,
        palette: [
            '#000000', '#7d7d7d', '#870014', '#ec1c23', '#ff7e26',
            '#fef100', '#22b14b', '#00a1e7', '#3f47cc', '#a349a4',
            '#ffffff', '#c3c3c3', '#b87957', '#feaec9', '#ffc80d',
            '#eee3af', '#b5e61d', '#99d9ea', '#7092be', '#c8bfe7',
        ],
        paletteCols: 10,
        //hideOnPaletteClick: true,
    };
    </script>

</head>
<body>

<!-- Afficher le code RGB et HSL de la couleur choisi -->
<!-- Afficher la couleur complémentaire -->

<div class="carrepreview" id="pr1" >&nbsp;</div>
<div class="carrecomplementaire" id="prevcomplementaire" >&nbsp;</div>
<div class="chxcolor"><button class="boutonchoix" data-jscolor="{previewElement:'#pr1', preset: 'dark', value:'rgb(51,153,255)'}">Choix de la couleur</button></div>



</body>
</html>
