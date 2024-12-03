# PatchWork

18-11-2024 : Création des deux pages d'administration - Charger et Purger
Pas de contenu pour l'instant, la priorité sur le calcul des couleurs cf. # 

## IMPORTANT - Configuration du serveur pour lib GD
- go to php.ini file
- search this ;extension=gd
- remove ; then restart the server

- [X] Changer la formule HSL
- [ ] Mettre en place la purge de la base (image -> repertoire corbeille)
- [x] Charger les photos : soit sélection répertoire mais le mieux serait "glisser/lacher" pour qu'elle soit intégrée
- [ ] Sélection des photos selon une couleur choisie avec une marge d'erreur
- [x] Chargement multiple des photos selon choix utilisateur du répertoire

*** TROUVE ***
Pour le Design de la selection de couleurs pour la recherche de photos similaires : https://github.com/dcode-youtube/color-picker-with-local-storage


## Tips
### Choix de la couleur et recherche
Lorsqu'on recherche une couleur avec une roue chromatique (ou input=color) (https://www.w3schools.com/howto/tryit.asp?filename=tryhow_html_colorpicker) il faut proposer une marge de recherche autour de la couleur recherchée :

- THIN : précis par rapport à la recherche (très peu de marge)
- REGULAR : juste un peu plus au tour (valuer par défaut)
- LARGE : on déborde et on rammasse un max de correspondance meme si on s'en éloigne un peu.

### Possibilité d'avoir la couleur complémentaire, mais également des couleurs similaires sur le cercles chromatique
Actuellement le choix est fait via une box, puis nous aurons le remplissage de cadre avec la couleur complémentaire (en place) et les couleurs semblables (en cours)
Pour les couleurs semblables, actuellement nous en avons deux espacées de 30° par rapport a la couleur choisie. A voir pour créer un algo pour X couleurs semblables avec un degré d'ecart paramètrable.

### Verisonning des ensembles image/couleur
Création de la partie tehcnique en base 
CREATE TABLE image_vX LIKE refimage;
INSERT INTO image_vX SELECT * FROM image;
Activation : faire pointer les Views Image/Couleur vers image_x/couleur_x précédement créées

DROP TABLE image_vX.
Le faire pour le couple image/couleur.
- [ ] Il faut mettre en place l'IHM Web
- [ ] Afficher l'ensemble des versions en base
- [ ] un bouton par version trouvée et lancer la suppression version par version
- [ ] Mise en place d'une corbeille


## ARCHIVES
- 23.11.2024
Menu commun pour toutes les pages - TERMINE - fichier HTML "menu_principal.html" en include php
Voir comment inégrer un menu commun pour toutes les pages -> include
https://www.w3schools.com/howto/howto_html_include.asp

- 23.11.2024
Prévoir sur la page principale des "Caroussel" avec des mokups des photos dans des espaces amménagés comme Salon, cuisine, salle loisirs ...
Voir avec Bootstrap pour la mise en place.

- 25.11.2024
Changer la fonction rgb_to_hsl (dominante.php) en RGB_to_HSV (transformation.php) car celle-ci correspond au TSL de Photoshop (référence)

- 28.11.2024
Outil pour sélectionner la couleur : https://www.w3schools.com/php/php_forms.asp
A voir avec le choix par defaut du input pour trouver quelque chose de plus "grand" et plus complet.
Trouvé un objet qui prendra la couleur sélectionnée car la preview est assez petite pour se faire une idée de la teinte.

-28.11.2024
Calcul de la dominante et son interprétation HSL
Revoir la transformation entre RGB et TSL - Les couleurs ne correspondent pas sous Photoshop.
Seule la couleur en RGB (Hexa) correspond à une couleur dans Photoshop
Photoshop : 
RVB -> TSL OK contrairement au TSL de l'application PatchWork.
/!\  IL FAUT REVOIR LA TRANSFORMATION RGB to TSL lorsque les photos sont intégrées
Tester l'algorithme qui permettra de se rapprocher de Photoshop et sa roue chromatique.
    https://stackoverflow.com/questions/1773698/rgb-to-hsv-in-php

## DOCUMENTATIONS
Page avec l'ensemble des formules de conversion des couleurs : 
https://gist.github.com/mjackson/5311256?permalink_comment_id=2357261
