<?php
/*
Copyright CrazyCMS : 

Valmori Quentin
	quentin.valmori@gmail.com
Feuvre Christophe
	neowan@live.fr
Haustrate Kevin
	gippel5@hotmail.com

This software is a computer program whose purpose is to make our own 
website. You just have to follow the automatic installation procedure
and you website is operational. Moreover, He is securized and optimized 
as much as possible.

This software is governed by the CeCILL² license under French law and
abiding by the rules of distribution of free software.  You can  use, 
modify and/ or redistribute the software under the terms of the CeCILL²
license as circulated by CEA, CNRS and INRIA at the following URL
"http://www.cecill.info". 

The fact that you are presently reading this means that you have had
knowledge of the CeCILL² license and that you accept its terms.

FICHIERS DE LANGUE DE L'INSTALLATION FRANCAIS
*/

// Description des etapes
define ( 'STEP_0' , 'Choix de la langue' );
define ( 'STEP_1' , 'Nouvelle Installation' );
define ( 'STEP_2' , 'Vérification Serveur' );
define ( 'STEP_3' , 'Serveur SQL' );
define ( 'STEP_4' , 'Modules' );
define ( 'STEP_5' , 'Création de votre Compte' );


//Variables de langues de l'install : 
define ( 'MUST_ACCEPT_LICENSE' , 'Vous devez accepter les termes de la licence' );
define ( 'UPDATE_SUCCESFULLY_DONE' , 'La mise à jour à été effectué avec succès' );
define ( 'UPDATE_ALREADY_DONE' , 'Ce site est déja à jour !' );
define ( 'BACK_TO_WEBSITE' , 'Retour à votre Site' );
define ( 'UPDATE_HELP' , 'Si votre fichier de configuration est introuvable, cela signifique qu\'aucun installation de CrazyCMS n\'a pu être trouvé !' );
define ( 'CHMOD_ERROR' , 'Erreur d\'autorisation' );
define ( 'UPDATE_ERROR_CONFIG' , 'Fichier de configuration du site introuvable ! Ce site ne peut pas être mis à jour, vous devez faire une nouvelle Installation !' );
define ( 'FORCE_INSTALLATION' , 'Forcer l\'installation !

Cliquez ici si vous effectuez l\'installation pour la première fois et que vous êtes arrivé ici en revenant en arrière durant une des étapes de l\'installation !' );
define ( 'SHOW_PASSWORD' , 'Voir le Mot de Passe' );
define ( 'BASE_ALREADY_EXISTS' , 'Une installation précédente de CrazyCMS à été apparemment effectué sur cette Base de Donnée !

Si vous voulez effectuer une nouvelle installation de CrazyCMS, vous devez soit vider la Base de Donnée, soit choisir un prefixe différent à la page précédente.

Si vous souhaitez conserver votre site et effectuer une mise à jour, vous devez passer par le script de mise à jour.' );
define ( 'GO_TO_UPDATE_SCRIPT' , 'Se rendre sur le script de mise à jour' );
define ( 'GD_DISABLED' , ' <u>L\'extension Gd2 n\'est pas chargée sur le serveur ! </u>

 Elle n\'est pas nécessaire pour faire tourner CrazyCMS, cependant, elle est <b>recommandée</b>, car sans elle, vous ne pouvez pas utiliser de code de séucrité lors de l\'inscription de vos membres afin d\'éviter les inscriptions par des robots' );
 
 define ( 'UP_DISABLED' , ' <u>L\'envoi de fichier n\'est pas possible sur ce serveur !</u>

 Ce n\'est pas nécessaire pour faire tourner CrazyCMS, cependant, c\'est <b>recommandée</b>, car cela permet aux membres d\'envoyer des photos, avatars, archive sur votre site' );
define ( 'CHMOD_ERROR_STOP' , 'Certains fichiers ou dossiers n\'ont pas les chmod requis, l\'installation ne peut continuer tant que les CHMOD sont corrects' );

define ( 'INSTALL_DEF' , 'Bienvenue dans l\'assistant d\'installation de Crazy CMS, et merci de l\'avoir choisit pour créer votre site.

Avant de continuer l\'installation, veuillez appliquer le chmod 644 ( 777 nécéssaire chez certains hébergeurs ) au fichier ./install/index.php

D\'autres fichiers nécessiterons peut être également un chmod plus élevé, vous le verrez à l\'étape 4

Si vous souhaitez effectuer la mise à jour de CrazyCMS depuis une ancienne version, cliquez sur mise à jour ci-dessous' );
define ( 'WELCOME_UPDATE' , 'Bienvenue dans la mise à jour de CrazyCMS, ce script vous permet la mise à jour depuis la/les version(s) {LAST_VERSION} vers la version {NEW_VERSION}.

Attention, pour utilisez ce script, vous devez déja avoir effectué l\'installation d\'une ancienne version de CrazyCMS !' );
define ( 'ACCEPT_LICENSE' , 'Pour continuer l\'installation, veuillez lire la licence d\'utilisation et l\'accepter' );
define ( 'ACCEPT_TERMS' , 'Accepter les termes de la license d\'utilisation' );
define ( 'STEP_0_5' , 'Retour ( Choix du Type d\'installation )' );
define ( 'DO_UPDATE' , ' Effectuer la mise à jour' );
define ( 'REFFUSE_TERMS' , 'Refuser les termes de la license d\'utilisation' );
define ( 'INSTALL_MAIN_FUNCTIONS' , 'Fonctions Principales' );
define ( 'INSTALL_PHP_VERSION' , 'Version PHP' );
define ( 'GO_TO_UPDATE' , 'Effectuer une mise à jour' );
define ( 'INSTALL_COMPATIBLE' , 'COMPATIBLE' );
define ( 'INSTALL_INCOMPATIBLE' , 'NON COMPATIBLE' );
define ( 'INSTALL_SQL_BASE' , 'Base SQL' );
define ( 'INSTALL_ACTIVATED' , 'ACTIVE' );
define ( 'CLICK_IF_NOT_REDIRECTED' , 'Cliquez ici si vous n\'êtes pas redirigés automatiquement' );
define ( 'INSTALL_SUMMER_HOUR' , 'Heure d\'été' );
define ( 'INSTALL_UNACTIVATED' , 'NON ACTIVE' );
define ( 'INSTALL_FILE_UPLOAD' , 'Upload de fichiers' );
define ( 'INSTALL_GD_LIBRARY' , 'Librairie gd2' );
define ( 'INSTALL_CHMOD_777' , 'CHMOD' );
define ( 'INSTALL_YES' , 'OUI' );
define ( 'ALERT_SECURITY' , 'Erreur de Sécurité !<br /><br />Recommencez l\'installation dès le début !' );
define ( 'INSTALL_NO' , 'NON' );
define ( 'INSTALL_PASSWORD' , 'Mot de Passe' );
define ( 'INSTALL_NEXT_STEP' , 'Etape suivante' );
define ( 'INSTALL_SQL_CONNECTION' , 'Connexion SQL' );
define ( 'INSTALL_SQL_SERVER_NAME' , 'Nom du serveur SQL' );
define ( 'INSTALL_SQL_USER_NAME' , 'Nom d\'utilisateur SQL' );
define ( 'INSTALL_SQL_USER_PASS' , 'Mot de passe SQL' );
define ( 'INSTALL_SQL_BASE_NAME' , 'Nom de la base SQL' );
define ( 'INSTALL_SQL_TABLE_PREFIXE' , 'Préfixe des Tables SQL ( Optionnel )' );
define ( 'INSTALL_COULDNT_CONNECT_SQL_SERVER' , 'Erreur de connection au serveur SQL' );
define ( 'INSTALL_COULDNT_SELECT_SQL_BASE' , 'Impossible de se connecter à la Base' );
define ( 'CONFIG_FILE_SUCCESSFULLY_CREATED' , 'Fichier de configuration crée avec Succès' );
define ( 'INSTALL_SITE_CONFIG' , 'Configuration du Site' );
define ( 'INSTALL_SITE_NAME' , 'Nom du Site' );
define ( 'INSTALL_SITE_URL' , 'Url du site' );
define ( 'INSTALL_HOUR_FUSEAUX' , 'Fuseau horaire' );
define ( 'INSTALL_MODS_TO_INSTALL' , 'Modules à installer' );
define ( 'INSTALL_PORTAL' , 'Portail' );
define ( 'INSTALL_USERS_STATS' , 'Utilisateurs, stats, etc...' );
define ( 'INSTALL_MODS_PORTAL_INSTALLED' , 'Tables et Modules Installés avec succès' );
define ( 'INSTALL_ADMIN_ACCOUNT' , 'Information compte administrateur' );
define ( 'INSTALL_PSEUDO' , 'Pseudo' );
define ( 'INSTALL_REPEAT_PASSWORD' , 'Repetez votre mot de passe' );
define ( 'INSTALL_EMAIL' , 'Adresse Email' );
define ( 'INSTALL_INVALID_PSEUDO' , 'Pseudo invalide ( les * sont interdites )' );
define ( 'IDENTICAL_PASSWORD' , 'Mots de Passe identiques' );
define ( 'DIFFERENT_PASSWORD' , 'Mots de Passe différents !' );
define ( 'VOID_FIELD' , 'Vous devez entrez un mot de passe !' );
define ( 'INSTALL_EMAIL_INVALID' , 'Adresse E-Mail invalide' );
define ( 'INSTALL_CANT_INSTALL' , 'La configuration de votre serveur empêche l\'installation de CrazyCMS' );
define ( 'INSTALL_FINISH' , 'Votre compte d\'administrateur a &eacute;t&eacute; crée avec succ&egrave;s, l\'installation de votre site est maintenant terminé.

Vous allez maintenant profiter de votre site. N\'oubliez pas de faire un tour dans l\'administration pour parametrer les dernieres options...' );

// Aide des différentes étapes
define ( 'STEP_1_HELP' , '&nbsp;&nbsp;Cliquez sur la flèche de droite afin de commencer l\'installation de CrazyCMS

&nbsp;&nbsp;&nbsp;&nbsp;<u>CHMOD :</u>

&nbsp;&nbsp;&nbsp;<i>Qu\'est-ce-qu\'un CHMOD ?</i>

&nbsp;Le CHMOD est l\'autorisation que possède un certain fichier ou dossier afin de pouvoir lire et écrire dans un autre fichier / dossier ou bien pour que l\'on puisse lire ou écrire ce fichier.

&nbsp;&nbsp;&nbsp;<i>Comment changer le CHMOD d\'un fichier / dossier ?</i>

&nbsp;Pour changer le CHMOD d\'un fichier ou d\'un dossier, vous devez utiliser votre client FTP. Une fois connecté, faites un clic-droit sur le fichier ou le dossier concerné puis choisissez "Attributs" ou "Propriétés" en fonction du client FTP puis vous pourrez alors changer le numéro du CHMOD
Si jamais vous ne trouvez pas comment changer le CHMOD d\'un de vos fichiers / dossiers, n\'hésitez pas à venir demander une aide sur <a href="http://crazycms.com">http://crazycms.com</a>' );
define ( 'STEP_2_HELP' , '&nbsp;&nbsp;Vous devez accepter les termes de la licence d\'utilisation ci-dessous afin de poursuivre l\'installation de CrazyCMS' );
define ( 'STEP_3_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Fonctions principales :</u>

&nbsp;&nbsp;Les Fonctions principales doivent être activés sur votre serveur / hébergeur afin que CrazyCMS puisse être installé dessus.
Si une des fonctions principales ne passe pas, vous pouvez changer d\'hébergeur ou bien venir demander une aide sur <a href="http://crazycms.com">http://crazycms.com</a>

&nbsp;&nbsp;&nbsp;&nbsp;<u>CHMOD :</u>

&nbsp;&nbsp;&nbsp;<i>Qu\'est-ce-qu\'un CHMOD ?</i>

&nbsp;Le CHMOD est l\'autorisation que possède un certain fichier ou dossier afin de pouvoir lire et écrire dans un autre fichier / dossier ou bien pour que l\'on puisse lire ou écrire ce fichier.

&nbsp;&nbsp;&nbsp;<i>Comment changer le CHMOD d\'un fichier / dossier ?</i>

&nbsp;Pour changer le CHMOD d\'un fichier ou d\'un dossier, vous devez utiliser votre client FTP. Une fois connecté, faites un clic-droit sur le fichier ou le dossier concerné puis choisissez "Attributs" ou "Propriétés" en fonction du client FTP puis vous pourrez alors changer le numéro du CHMOD
Si jamais vous ne trouvez pas comment changer le CHMOD d\'un de vos fichiers / dossiers, n\'hésitez pas à venir demander une aide sur <a href="http://crazycms.com">http://crazycms.com</a>

&nbsp;&nbsp;&nbsp;<i>Quel CHMOD attribuer ?</i>

&nbsp;Le CHMOD à attribuer à un fichier ou bien à un dossier est indiqué au début de la ligne entre-crochets.
En général, le CHMOD à appliquer est de 700 pour les dossiers et de 644 pour les fichiers' );

define ( 'STEP_4_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Nom du serveur SQL: </u>

&nbsp;&nbsp;L\'adresse du serveur SQL. <i>(Fournit par l\'hébergeur)</i>


&nbsp;&nbsp;&nbsp;&nbsp;<u>Nom d\'utilisateur SQL: </u>

&nbsp;&nbsp;Le login de connection. <i>(Fournit par l\'hébergeur)</i>


&nbsp;&nbsp;&nbsp;&nbsp;<u>Mot de passe SQL: </u>

&nbsp;&nbsp;Le mot de passe de votre compte. <i>(Fournit par l\'hébergeur)</i>


&nbsp;&nbsp;&nbsp;&nbsp;<u>Nom de la base SQL: </u>

&nbsp;&nbsp;Nom de votre base SQL. <i>(Fournit par l\'hébergeur, Dans un certain nombre de cas, c\'est le même nom que celui d\'utilisateur )</i>


&nbsp;&nbsp;&nbsp;&nbsp;<u>Préfixe des Tables SQL: </u>

&nbsp;&nbsp;Seulement si vous désirez héberger plusieurs site CrazyCMS. Différent d\'un site à l\'autre.<i>(Optionnel)</i>' );
define ( 'STEP_5_HELP' , '&nbsp;&nbsp;Cliquez sur la flèche de droite afin de continuer l\'installation de CrazyCMS' );
define ( 'STEP_6_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Informations générales :</u>

&nbsp;&nbsp;Le nom de votre site, l\'adresse de votre site et le fuseau sont nécéssaires. Vous pourrez les changer par la suite si vous le souhaitez. Cependant le choix d\'un mauvais fuseau décalera toutes les heures du site ( messages, news, etc ... ) et l\'entrée d\'une mauvaise adresse empechera la bonne marche de certaines fonctionalités

&nbsp;&nbsp;&nbsp;&nbsp;<u>Modules à installer : </u>

&nbsp;&nbsp;Vous pouvez choisir les modules à installer pour votre site. Ne vous inquietez pas, vous pourrez toujours installer ou même désinstaller des modules par la suite' );
define ( 'STEP_7_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Installation des modules :</u>

&nbsp;&nbsp;Les modules que vous avez séléctionnés ont étés installés ainsi que le portail, cliquez sur la flèche de droite pour arriver à la dernière étape de l\'installation

&nbsp;&nbsp;Si un modules s\'est mal installé, ne vous inquietez pas et continuez, si l\'installation de ce module à réellement échoué, vous pourrez le ré-installer par la suite. Si jamais il y à toujours une erreur d\'installation de ce module, vous pouvez venir demander de l\'aide sur <a href="http://crazycms.com">http://crazycms.com</a>' );
define ( 'STEP_8_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Création du compte administrateur : </u>

&nbsp;&nbsp;Vous devez désormais créer votre compte. Il vous permettra de vous connecter sur votre site pour pouvoir participer et administrer votre site.
Vous pourrez créer d\'autres comptes administrateurs par la suite si vous souhaitez que d\'autres personnes viennent vous aider à gêrer votre site' );
define ( 'SHOW_ADMIN_INDEX' , 'Voir l\'administration des modules' );
define ( 'SHOW_ADMIN_DEFAULTS' , 'Voir l\'administration du portail' );
define ( 'VIEW_CACHE_ADMIN' , 'Voir l\'administration du Cache' );
define ( 'MANAGE_GRADES' , 'Gêrer les Grades' );
define ( 'GUEST' , 'Invité' );
define ( 'GOODMORNING' , 'Bonjour' );
define ( 'PLEASE_CLICK_TO_GOT_NEW' , 'Vous avez demande un nouveau mot de passe, veuillez cliquez sur le lien ci dessous pour avoir votre nouveau mot de passe' );
define ( 'PASSWORD_UPDATED_AND_ITS' , 'votre mot de passe a ete change et le nouveau est' );
define ( 'GOT_VALIDATION_ALERT' , 'Vous avez une alerte de validation' );

// Nom des modules pour le menu
define ( 'REGISTER' , 'S\'inscrire' );
define ( 'FORUM_INSTALL' , 'Forum' );
define ( 'TO_LOG' , 'Se connecter' );
define ( 'PAGES_MODS' , 'Pages Internes' );
define ( 'SPACEMEMBER' , 'Espace Membre' );
define ( 'PHOTO_GALLERY' , 'Galerie Photo' );
define ( 'STATS' , 'Statistiques' );
define ( 'CHAT' , 'T\'chat' );
define ( 'LVDOR' , 'Livre d\'or' );
define ( 'NEWS' , 'News' );
define ( 'MEMBER_LIST' , 'Liste des Membres' );

?>