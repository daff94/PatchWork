# PatchWork

18-11-2024 : Création des deux pages d'administration - Charger et Purger

Revoir la transformation entre RGB et TSL - Les couleurs ne correspondent pas sous Photoshop.
Seule la couleur en RGB (Hexa) correspond à une couleur dans Photoshop
Photoshop : 
RVB -> TSL OK contrairement au TSL de l'application PatchWork.
/!\  IL FAUT REVOIR LA TRANSFORMATION RGB to TSL lorsque les photos sont intégrées
Tester l'algorithme qui permettra de se rapprocher de Photoshop et sa roue chromatique.
    https://stackoverflow.com/questions/1773698/rgb-to-hsv-in-php


*** TROUVE ---
Changer la fonction rgb_to_hsl (dominante.php) en RGB_to_HSV (transformation.php) car celle-ci correspond au TSL de Photoshop (référence)

Pour le Design de la selection de couleurs pour la recherche de photos similaires : https://github.com/dcode-youtube/color-picker-with-local-storage


Tips :
Lorsqu'on recherche une couleur avec une roue chromatique (ou input=color) (https://www.w3schools.com/howto/tryit.asp?filename=tryhow_html_colorpicker) il faut proposer une marge de recherche autour de la couleur recherchée :

THIN : précis par rapport à la recherche (très peu de marge)
REGULAR : juste un peu plus au tour (valuer par défaut)
LARGE : on déborde et on rammasse un max de correspondance meme si on s'en éloigne un peu.

Récupérer une valeur sélectionnée : https://www.w3schools.com/php/php_forms.asp
A voir avec le choix par defaut du input pour trouver quelque chose de plus "grand" et plus complet.
Trouvé un objet qui prendra la couleur sélectionnée car la preview est assez petite pour se faire une idée de la teinte.
