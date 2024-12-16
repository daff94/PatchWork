
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir une couleur</title>
    <scipt src="pickercolor.js"></scipt>
    <script src="js/jscolor.js"></script>
    <link href="css/pickercolor.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
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

    function affSemblable(chxColor) {
        // Récupération de la couleur choisi
        // const chxColor = document.querySelector('#pr1').getAttribute('data-current-color');
         // data-current-color est au format : rgb(51,153,255)
        const delta = 20;
        const deci = chxColor.replace("rgb(", "").replace(")", "").split(",");
        const r = deci[0];
        const g = deci[1];
        const b = deci[2];
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

    function affComplementaire(chxColor) {
        // Récupération de la couleur choisi
        // chxColor est au format : rgb(51,153,255)
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
        affSemblable(chxColor);
        chxRefTolerance(chxColor);
    }


    function chxRefTolerance(chxColor) {
        // Récupération de la couleur de la case selectionnée
        // const chxColor = document.querySelector('#pr1').getAttribute('data-current-color');
        // On sépare le mot "rgb(...)"
        const deci = chxColor.replace("rgb(", "").replace(")", "").split(",");
        const r = deci[0];
        const g = deci[1];
        const b = deci[2];
        // console.log("couleur de ref RGB : " + deci);
        // Transformation RGB -> HSV
        hsv = rgbToHsv_min(r, g, b);
        // console.log(hsv);
        const tdegre = Math.round(hsv[0] * 360);
        const spourc = Math.round(hsv[1] * 100);
        const lpourc = Math.round(hsv[2] * 100);
        /*
        console.log("En degré : " + tdegre);
        console.log("En Pourcentage Saturation : " + spourc);
        console.log("En pourcentage Luminance : " + lpourc);
        */
        // Récupérer l'option de choix de la tolérance
        chxToleranceTiny = document.querySelector('#Tiny').checked;
        chxToleranceRegular = document.querySelector('#Regular').checked;
        chxToleranceLarge = document.querySelector('#Large').checked;
        chxCouleurOnly = document.querySelector('#chxcouleurOnly').checked;
        
        let ttolerance = 0;
        let stolerance = 0;
        let ltolerance = 0;

        if (chxToleranceTiny) {
            ttolerance = 10;  // degrés sur le cercle chromatique
            stolerance = 0.1; // 10% sur la saturation
            ltolerance = 0.1; // 10% sur la luminance
        }
        if (chxToleranceRegular) {
            ttolerance = 20;  // degrés sur le cercle chromatique
            stolerance = 0.2; // 20% sur la saturation
            ltolerance = 0.2; // 20% sur la luminance
        }
        if (chxToleranceLarge) {
            ttolerance = 60;  // degrés sur le cercle chromatique
            stolerance = 0.4; // 40% sur la saturation
            ltolerance = 0.4; // 40% sur la luminance
        }
        // Si le choix est couleur uniquement on supprime les tolerances pour la saturation et luminance
        if (chxCouleurOnly == true) {
            stolerance = 0;
            ltolerance = 0;
        }

        // Calcul la fourchette de tolérance pour la Teinte et pour les autres.
        // Tolerance appliquée sur le cercle chromatique
        let tdegreplus = Math.round((hsv[0] + (ttolerance/360)) * 360);
        let tdegremoins = Math.round((hsv[0] - (ttolerance/360)) * 360);
        // Tolérance appliquée sur Saturation et Luminance si la case "Couleurs" n'est pas cochée
        let spourcplus = Math.round((hsv[1] + stolerance) * 100);
        let spourcmoins = Math.round((hsv[1] - stolerance) * 100);
        let lpourcplus = Math.round((hsv[2] + ltolerance) * 100);
        let lpourcmoins = Math.round((hsv[2] - ltolerance) * 100);

        // Gestion des limites
        // pour les degres
        if (tdegreplus > 359) { tdegreplus = 359; }
        if (tdegremoins < 0) { tdegremoins = 0; }
        // pour les pourcentages
        if (spourcplus >= 100) { spourcplus = 100; }
        if (spourcmoins < 0) { spourcmoins = 0; }
        if (lpourcplus >= 100) { lpourcplus = 100; }
        if (lpourcmoins < 0){ lpourcmoins = 0; }

        // On se garde en GLOBAL pour utiliser lors de la recherche de la photo
        global_tdegreplus = tdegreplus;
        global_tdegremoins = tdegremoins;
        global_spourcplus = spourcplus;
        global_spourcmoins = spourcmoins;
        global_lpourcplus = lpourcplus;
        global_lpourcmoins = lpourcmoins;

        const hsvTolerancePlus = [tdegreplus / 360, spourcplus / 100, lpourcplus / 100];
        const hsvToleranceMoins = [tdegremoins / 360, spourcmoins / 100, lpourcmoins / 100];

        let rgbtolerancePlus = hsvToRgb_min(hsvTolerancePlus[0], hsvTolerancePlus[1], hsvTolerancePlus[2]);
        let rgbtoleranceMoins = hsvToRgb_min(hsvToleranceMoins[0],hsvToleranceMoins[1],hsvToleranceMoins[2]);

        document.querySelector('#tolerancePLUS').style.backgroundColor = "rgb("+rgbtolerancePlus[0]+","+rgbtolerancePlus[1]+","+rgbtolerancePlus[2]+")";
        document.querySelector('#toleranceMOINS').style.backgroundColor = "rgb("+rgbtoleranceMoins[0]+","+rgbtoleranceMoins[1]+","+rgbtoleranceMoins[2]+")";
                

        // Lancer la recherche des photos selon la sélection de couleur et la tolérance appliquée.
        // Afficher en grille l'ensemble des images sélectionnées.
    }

    function switchcolor(idClick) {
        // Récupération de la couleur "cliquée"
        idSource = "#" + idClick.id;
        const chxColor = document.querySelector(idSource).style.backgroundColor;
        // Mise à jour du DIV de Référence
        document.querySelector('#pr1').style.backgroundImage = "linear-gradient(to right, " + chxColor + " 0%, " + chxColor + " 100%)";
        document.querySelector('#pr1').style.backgroundColor = chxColor;
        document.querySelector('#pr1').setAttribute('data-current-color',chxColor);
    }

    function rechercheImages(){
        // Récupération de la couleur de référence - rgb(xxx,xxx,xxx)
        const referenceCouleur = document.querySelector('#pr1').style.backgroundColor;
        console.log(global_tdegreplus);
        console.log(global_tdegremoins);
        console.log(global_spourcplus);
        console.log(global_spourcmoins);
        console.log(global_lpourcplus);
        console.log(global_lpourcmoins);

        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
              }
            };
            xmlhttp.open("GET","/patchwork/ajax/ajxaffichephoto.php?reqhuemin=" + global_tdegremoins + "&reqhuemax=" + global_tdegreplus + "&reqsatmin=" + global_spourcmoins + "&reqsatmax=" + global_spourcplus + "&reqlummin=" + global_lpourcmoins + " &reqlummax=" + global_lpourcplus,true);
            xmlhttp.send();
    }

    function update(picker, selector) {
    affComplementaire(picker.toRGBString());
    document.querySelector('#pr1').style.backgroundColor = picker.toRGBString();
    rechercheImages();
    }

    // triggers 'onInput' and 'onChange' on all color pickers when they are ready
    // Permet de mettre à jour la boite "Référence" avec la couleur par defaut du composant
    jscolor.trigger('input change');

    </script> 

</head>

<body class="mybody">

<!-- Chargement du menu principal du site -->
<?php include 'menu_principal.html' ?>

<div class="container">
    <div class="carrecomplementaire" id="couleurComplementaire" style="background-color: rgb(85,179,226);" onclick="switchcolor(this);"><p>Complémentaire</p></div>
    <div class="parent">
        <div class="div1 carrepreview" id="couleurSemblableMoins" style="background-color: rgb(166, 32, 30);" onclick="switchcolor(this);"></div>
        <div class="div2 reference" id="pr1" ><p>Référence</p></div>
        <div class="div3 carrepreview" id="couleurSemblablePlus" style="background-color: rgb(166, 123, 30);" onclick="switchcolor(this);"></div>
    </div>

    <div class="parent">
        <div class="div1 carretolerance" id="toleranceMOINS" onclick="switchcolor(this);"></div>
        <div class="div2">
            <input class="form-check-input" type="radio" id="Tiny" name="chxtolerance" />
            <label class="form-check-label" for="Tiny">Tiny</label>
            <input class="form-check-input" type="radio" id="Regular" name="chxtolerance" checked/>
            <label class="form-check-label" for="Regular">Regular</label>
            <input class="form-check-input" type="radio" id="Large" name="chxtolerance" />
            <label class="form-check-label" for="Large">Large</label>
            <input class="form-check-input" type="checkbox" id="chxcouleurOnly" name="chxcouleurOnly" checked/>
            <label class="form-check-label" for="chxcouleurOnly">Couleurs</label>
        </div>
        <div class="div3 carretolerance" id="tolerancePLUS" onclick="switchcolor(this);"></div>
    </div>
    <div class="input-group mb-3 carreinput">
        <span class="input-group-text" id="basic-addon1">Choix de la couleur : </span>
        <input class="form-control" data-jscolor="{value:'#FC9737', previewElement:'#pr1', onChange:'rechercheImages()'}" id="chxcouleurtxt"  oninput="update(this.jscolor, '#pr1')" >
    </div>
    <div><button class="button" type="button" onclick="rechercheImages();">Rechercher les photos similaires</button></div>
    <!-- Reception de l'appel AJAX pour trouver les photos en fonction du choix des couleurs -->
    <div class="div1" id="txtHint"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>




</body>
</html>
