# PatchWork



## IMPORTANT - Configuration du serveur pour lib GD
- go to php.ini file
- search this ;extension=gd
- remove ; then restart the server

## TODO LIST
- [X] Changer la formule HSL
- [X] Mettre en place la purge de la base (images -> repertoire corbeille)
- [X] Charger les photos : soit sélection répertoire mais le mieux serait "glisser/lacher" pour qu'elle soit intégrée
- [X] Chargement multiple des photos selon choix utilisateur du répertoire
- [X] Ajouter une zone de saisie en HEX pour le choix de la couleur de REFERENCE
- [X] Ajouter une case à option (3 choix) pour la finesse THIN / REGULAR / LARGE
- [X] Lorsqu'on clique sur une couleur complémentaire/gauche/droite, elle devient la couleur de Référence (et calculer les autres couleurs)
- [X] Basculer en AJAX toute la gestion de version et sauvegarde des tables (purge -> base corbeille / images -> rep. corbeille)
- [X] Mettre en place le Workflow suivant : upload des nouvelles images -> insertion en base (choix de version) -> Lancement de la recherche des dominantes
- [ ] Lorsqu'on charge de nouveaux fichiers, on créé une nouvelle version des tables "image/couleur"
- [X] Intégrer l'existant concernant la recherche d'image (ajax)
- [X] Développer en AJAX la partie recherche d'image (recherche puis affichage)


## Tips
Pas de TIPS pour le moment


## ARCHIVES
- 18.11.2024 : Création des deux pages d'administration - Charger et Purger
Pas de contenu pour l'instant, la priorité sur le calcul des couleurs cf. # 

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
Utilisation du module Javascript : https://jscolor.com/
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

- 04.12.2024
Possibilité d'avoir la couleur complémentaire, mais également des couleurs similaires sur le cercles chromatique
Actuellement le choix est fait via une box, puis nous aurons le remplissage de cadre avec la couleur complémentaire (en place) et les couleurs semblables (en cours)
Pour les couleurs semblables, actuellement nous en avons deux espacées de 30° par rapport a la couleur choisie. A voir pour créer un algo pour X couleurs semblables avec un degré d'ecart paramètrable.

- 09.12.2024
Verisonning des ensembles image/couleur
AJAX : https://www.w3schools.com/php/php_ajax_database.asp
Création de la partie tehcnique en base 
CREATE TABLE image_vX LIKE refimage;
INSERT INTO image_vX SELECT * FROM image;
Activation : faire pointer les Views Image/Couleur vers image_x/couleur_x précédement créées

DROP TABLE image_vX.
Le faire pour le couple image/couleur.
- Il faut mettre en place l'IHM Web
- Afficher l'ensemble des versions en base
- un bouton par version trouvée et lancer la suppression version par version (prefixe "archive_")

- 15.12.2024
Choix de la couleur et recherche
Lorsqu'on recherche une couleur avec une roue chromatique (ou input=color) (https://www.w3schools.com/howto/tryit.asp?filename=tryhow_html_colorpicker) il faut proposer une marge de recherche autour de la couleur recherchée :

- THIN : précis par rapport à la recherche (très peu de marge)
- REGULAR : juste un peu plus au tour (valuer par défaut)
- LARGE : on déborde et on rammasse un max de correspondance meme si on s'en éloigne un peu.


## DOCUMENTATIONS
Page avec l'ensemble des formules de conversion des couleurs : 
https://gist.github.com/mjackson/5311256?permalink_comment_id=2357261
Outil de conversion PHP->Javascript : https://www.codeconvert.ai/php-to-javascript-converter
