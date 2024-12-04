
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
    

    function HSV_TO_RGB(h,s,v) {
        // var h = hsv.hue, s = hsv.sat, v = hsv.val;
        var rgb, i, data = [];
        if (s === 0) {
            rgb = [v,v,v];
        } else {
            h = h / 60;
            i = Math.floor(h);
            data = [v*(1-s), v*(1-s*(h-i)), v*(1-s*(1-(h-i)))];
            switch(i) {
            case 0:
                rgb = [v, data[2], data[0]];
                break;
            case 1:
                rgb = [data[1], v, data[0]];
                break;
            case 2:
                rgb = [data[0], v, data[2]];
                break;
            case 3:
                rgb = [data[0], data[1], v];
                break;
            case 4:
                rgb = [data[2], data[0], v];
                break;
            default:
                rgb = [v, data[0], data[1]];
                break;
            }
        }
        return '#' + rgb.map(function(x){ 
            return ("0" + Math.round(x*255).toString(16)).slice(-2);
        }).join('');
    }




    function RGB_TO_HSV(r, g, b) 
    {
        r = Math.max(0, Math.min(parseInt(r), 255));
        g = Math.max(0, Math.min(parseInt(g), 255));
        b = Math.max(0, Math.min(parseInt(b), 255));
        const result = [];
        const min = Math.min(r, g, b);
        const max = Math.max(r, g, b);
        const delta_min_max = max - min;
        let result_h = 0;

        if (delta_min_max !== 0 && max === r && g >= b) {
            result_h = 60 * ((g - b) / delta_min_max) + 0;
        } else if (delta_min_max !== 0 && max === r && g < b) {
            result_h = 60 * ((g - b) / delta_min_max) + 360;
        } else if (delta_min_max !== 0 && max === g) {
            result_h = 60 * ((b - r) / delta_min_max) + 120;
        } else if (delta_min_max !== 0 && max === b) {
            result_h = 60 * ((r - g) / delta_min_max) + 240;
        }

        const result_s = max === 0 ? 0 : (1 - (min / max));
        const result_v = max;
        result[0] = Math.round(result_h);
        result[1] = Math.floor(result_s * 100);
        result[2] = Math.floor(result_v / 2.55);
        
        return result;
    }


    function hsvToRgb_min(h, s, v) {
        var r, g, b;

        var i = Math.floor(h * 6);
        var f = h * 6 - i;
        var p = v * (1 - s);
        var q = v * (1 - f * s);
        var t = v * (1 - (1 - f) * s);

        switch (i % 6) {
            case 0: r = v, g = t, b = p; break;
            case 1: r = q, g = v, b = p; break;
            case 2: r = p, g = v, b = t; break;
            case 3: r = p, g = q, b = v; break;
            case 4: r = t, g = p, b = v; break;
            case 5: r = v, g = p, b = q; break;
        }

        return [ r * 255, g * 255, b * 255 ];
    }

    function rgbToHsv_min(r, g, b) {
        r /= 255, g /= 255, b /= 255;

        var max = Math.max(r, g, b), min = Math.min(r, g, b);
        var h, s, v = max;

        var d = max - min;
        s = max == 0 ? 0 : d / max;

        if (max == min) {
            h = 0; // achromatic
        } else {
            switch (max) {
            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
            case g: h = (b - r) / d + 2; break;
            case b: h = (r - g) / d + 4; break;
            }

            h /= 6;
        }

        return [ h, s, v ];
        }


    function affSemblable()
    {
        // Récupération de la couleur choisi
        const chxColor = document.querySelector('#pr1').getAttribute('data-current-color');
         // data-current-color est au format : rgb(51,153,255)
        const delta = 20;
        const deci = chxColor.replace("rgb(", "").replace(")", "").split(",");
        const r = deci[0];
        const g = deci[1];
        const b = deci[2];
        // console.log("Couleur sélectionnée en RGB : " + deci);
        const hsv = rgbToHsv_min(r,g,b);
        // Après la conversion on remet les valeurs correspondantes à la roue Chromatique
        // https://fr.wikipedia.org/wiki/Cercle_chromatique#/media/Fichier:CYM_color_wheel.png
        const tdegre = Math.round(hsv[0] * 360);
        const spourc = Math.round(hsv[1] * 100);
        const lpourc = Math.round(hsv[2] * 100);
        // On ajoute les delta sup. et inf. pour avoir des couleurs semblables
        const tPlus = tdegre + delta;
        const tMoins = tdegre - delta;
        // On remet les valeurs en HSV
        const hsvPlus = [tPlus / 360, spourc / 100, lpourc / 100];
        const hsvMoins = [tMoins / 360 , spourc / 100, lpourc / 100];
        // Convertion des valeurs HSV en RGB
        const rvbsemblablePlus = hsvToRgb_min(hsvPlus[0],hsvPlus[1], hsvPlus[2]);
        const rvbsemblableMoins = hsvToRgb_min(hsvMoins[0],hsvMoins[1], hsvMoins[2]);
        // Affichage des codes RGB des couleurs semblables
        // console.log("Valeur semblable Plus : " + rvbsemblablePlus[0], rvbsemblablePlus[1], rvbsemblablePlus[2]);
        // console.log("Valeur semblable Moins : " + rvbsemblableMoins[0], rvbsemblableMoins[1] , rvbsemblableMoins[2]);
        document.querySelector('#couleurSemblablePlus').style.backgroundColor = "rgb("+rvbsemblablePlus[0]+","+rvbsemblablePlus[1]+","+rvbsemblablePlus[2]+")";
        document.querySelector('#couleurSemblableMoins').style.backgroundColor = "rgb("+rvbsemblableMoins[0]+","+rvbsemblableMoins[1]+","+rvbsemblableMoins[2]+")";
    }


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
        affSemblable();
    }

   
    </script> 
</head>
<body>
<div class="container">
    <div class="carrecomplementaire" id="couleurComplementaire" style="background-color: rgb(85,179,226); "><p>Complémentaire</p></div>
    <div class="parent">
        <div class="div1 carrepreview" id="couleurSemblableMoins"><p>Semblable Gauche</p></div>
        <div class="div2 carrepreview" id="pr1" data-jscolor="{previewElement:'#pr1', preset: 'dark', value:'rgb(170,80,30)', onInput: 'affComplementaire()'}" ><p>Référence</p></div>
        <div class="div3 carrepreview" id="couleurSemblablePlus"><p>Semblable Droite</p></div>
    </div>
    <div><button class="button" type="button">Rechercher les photos similaires</button></div>
</div>

</body>
</html>
