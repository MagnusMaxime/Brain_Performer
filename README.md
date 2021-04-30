# Brain Performer
Site web: [https://healing-path.fr](https://healing-path.fr)

## Prérequis

### Les logiciels
 * Installer [github desktop](https://desktop.github.com/)  
 * Installer un éditeur de code comme [Visual Studio Code](https://code.visualstudio.com/) ou [IntelliJ Pro](https://www.jetbrains.com/fr-fr/idea/download/) (La version Pro est gratuite en utilisant ton mail isep lors de l'inscription)
 * Si nécessaire installer [git](https://git-scm.com/download/)  
 * Installer [mamp ou wamp ou lamp](https://www.mamp.info/en/windows/)  
 * Installer [Cmder](https://cmder.net/) 

### Les bases
  On met ici le strict minimum
  * Savoir les bases de PHP
 * Regarder les tutos de [Graphikart](https://www.youtube.com/c/grafikart/playlists) :
	 * Composer
	 * Structure [MVC](https://www.youtube.com/watch?v=a3NZtp3FJEE&feature=emb_logo)
	 * twig

## Workflow

### Github desktop  
* Se connecter à son compte github: [ aide ]( https://docs.github.com/en/free-pro-team@latest/desktop/installing-and-configuring-github-desktop/setting-up-github-desktop)  
* Choisir un dossier vide sur son ordinateur et cloner le projet dedans  

#### Commandes
* Pull: récupère des modifications sur github  
* Commit: ajoute une modification locale dans son historique git  
* Push: envoie ses modifications sur github pour les partager aux autres
  
### Éditeur de code  
* Ouvrir le projet cloné  
* Chercher sur google comment ouvrir un terminal sur l'éditeur de text sélectionné  

## Installation

### Installer les dépendances du site web  
* taper dans le terminal de son éditeur  
```bash  
composer install  
```

### Lancer le site sur sa machine  
* trouver le projet du site avec mamp  
* lancer mamp  
* ouvrir son navigateur à l'url mamp indiqué surement "http://localhost:8888/web/index.php"  
  
## Tutoriels recommandés  
* [html/css](https://openclassrooms.com/fr/courses/1603881-apprenez-a-creer-votre-site-web-avec-html5-et-css3)  
* [php](https://openclassrooms.com/fr/courses/918836-concevez-votre-site-web-avec-php-et-mysql)  
* [git et github](https://openclassrooms.com/fr/courses/5641721-utilisez-git-et-github-pour-vos-projets-de-developpement)  
* [sql dans php](https://openclassrooms.com/fr/courses/918836-concevez-votre-site-web-avec-php-et-mysql)  
* [javascript](https://openclassrooms.com/fr/courses/1916641-dynamisez-vos-sites-web-avec-javascript/2725486-tp-un-formulaire-interactif)  
* [jquery](https://openclassrooms.com/fr/courses/1567926-un-site-web-dynamique-avec-jquery)  

## Hébergement
Le projet possède 2 branches: main et heroku
La branche main est la branche principale sur laquelle on travail et est donc instable. Une fois que celle-ci devient stable on peut la fusionner ('merge') avec la branche heroku.
Une fois cette fusion effectuée, le site sur heroku sera automatiquement mis à jour lorsque github reçoit une mise à jour sur la branche heroku.
