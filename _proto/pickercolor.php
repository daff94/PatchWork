
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir une couleur</title>
    <scipt src="pickercolor.js"></scipt>
    <script src="../js/jscolor.js"></script>
    <link href="../css/pickercolor.css" rel="stylesheet">

    <script type="text/javascript" language="JavaScript">
    // Here we can adjust defaults for all color pickers on page:
    jscolor.presets.default = {
        position: 'bottom',
        shadow: true,
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

    <script type="text/javascript" language="JavaScript">
    function affComplementaire()
    {
        // Récupération de la couleur choisi
        const chxColor = document.querySelector('#pr1').getAttribute('data-current-color');
         // data-current-color est au format : rgb(51,153,255)
        const deci = chxColor.replace("rgb(", "").replace(")", "").split(",");
        const r = deci[0];
        const g = deci[1];
        const b = deci[2];

        // faire le calcul ou transformation pour trouver la couleur complémentaire
        const cr = 255 - r;
        const cg = 255 - g;
        const cb = 255 - b;
        /*
        console.log(r, g, b);
        console.log(cr, cg, cb);
        console.log("rgb("+cr+","+cg+","+cb+")");
        */
        // const chxColor = document.querySelector('#pr1').getAttribute('data-current-color');
        document.querySelector('#couleurComplementaire').style.backgroundColor = "rgb("+cr+","+cg+","+cb+")";
    }
    </script> 
</head>
<body>
<div class="container">
    <div class="carrepreview" id="pr1" data-jscolor="{previewElement:'#pr1', preset: 'dark', value:'rgb(170,80,30)', onInput: 'affComplementaire()'}" >&nbsp;</div>
    <div class="carrecomplementaire" id="couleurComplementaire" style="background-color: rgb(85,179,226); "><p>Complémentaire</p></div>
</div>
</body>
</html>
