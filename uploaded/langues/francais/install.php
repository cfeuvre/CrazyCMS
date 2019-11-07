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

This software is governed by the CeCILL� license under French law and
abiding by the rules of distribution of free software.  You can  use, 
modify and/ or redistribute the software under the terms of the CeCILL�
license as circulated by CEA, CNRS and INRIA at the following URL
"http://www.cecill.info". 

The fact that you are presently reading this means that you have had
knowledge of the CeCILL� license and that you accept its terms.

FICHIERS DE LANGUE DE L'INSTALLATION FRANCAIS
*/

// Description des etapes
define ( 'STEP_0' , 'Choix de la langue' );
define ( 'STEP_1' , 'Nouvelle Installation' );
define ( 'STEP_2' , 'V�rification Serveur' );
define ( 'STEP_3' , 'Serveur SQL' );
define ( 'STEP_4' , 'Modules' );
define ( 'STEP_5' , 'Cr�ation de votre Compte' );


//Variables de langues de l'install : 
define ( 'MUST_ACCEPT_LICENSE' , 'Vous devez accepter les termes de la licence' );
define ( 'UPDATE_SUCCESFULLY_DONE' , 'La mise � jour � �t� effectu� avec succ�s' );
define ( 'UPDATE_ALREADY_DONE' , 'Ce site est d�ja � jour !' );
define ( 'BACK_TO_WEBSITE' , 'Retour � votre Site' );
define ( 'UPDATE_HELP' , 'Si votre fichier de configuration est introuvable, cela signifique qu\'aucun installation de CrazyCMS n\'a pu �tre trouv� !' );
define ( 'CHMOD_ERROR' , 'Erreur d\'autorisation' );
define ( 'UPDATE_ERROR_CONFIG' , 'Fichier de configuration du site introuvable ! Ce site ne peut pas �tre mis � jour, vous devez faire une nouvelle Installation !' );
define ( 'FORCE_INSTALLATION' , 'Forcer l\'installation !

Cliquez ici si vous effectuez l\'installation pour la premi�re fois et que vous �tes arriv� ici en revenant en arri�re durant une des �tapes de l\'installation !' );
define ( 'SHOW_PASSWORD' , 'Voir le Mot de Passe' );
define ( 'BASE_ALREADY_EXISTS' , 'Une installation pr�c�dente de CrazyCMS � �t� apparemment effectu� sur cette Base de Donn�e !

Si vous voulez effectuer une nouvelle installation de CrazyCMS, vous devez soit vider la Base de Donn�e, soit choisir un prefixe diff�rent � la page pr�c�dente.

Si vous souhaitez conserver votre site et effectuer une mise � jour, vous devez passer par le script de mise � jour.' );
define ( 'GO_TO_UPDATE_SCRIPT' , 'Se rendre sur le script de mise � jour' );
define ( 'GD_DISABLED' , ' <u>L\'extension Gd2 n\'est pas charg�e sur le serveur ! </u>

 Elle n\'est pas n�cessaire pour faire tourner CrazyCMS, cependant, elle est <b>recommand�e</b>, car sans elle, vous ne pouvez pas utiliser de code de s�ucrit� lors de l\'inscription de vos membres afin d\'�viter les inscriptions par des robots' );
 
 define ( 'UP_DISABLED' , ' <u>L\'envoi de fichier n\'est pas possible sur ce serveur !</u>

 Ce n\'est pas n�cessaire pour faire tourner CrazyCMS, cependant, c\'est <b>recommand�e</b>, car cela permet aux membres d\'envoyer des photos, avatars, archive sur votre site' );
define ( 'CHMOD_ERROR_STOP' , 'Certains fichiers ou dossiers n\'ont pas les chmod requis, l\'installation ne peut continuer tant que les CHMOD sont corrects' );

define ( 'INSTALL_DEF' , 'Bienvenue dans l\'assistant d\'installation de Crazy CMS, et merci de l\'avoir choisit pour cr�er votre site.

Avant de continuer l\'installation, veuillez appliquer le chmod 644 ( 777 n�c�ssaire chez certains h�bergeurs ) au fichier ./install/index.php

D\'autres fichiers n�cessiterons peut �tre �galement un chmod plus �lev�, vous le verrez � l\'�tape 4

Si vous souhaitez effectuer la mise � jour de CrazyCMS depuis une ancienne version, cliquez sur mise � jour ci-dessous' );
define ( 'WELCOME_UPDATE' , 'Bienvenue dans la mise � jour de CrazyCMS, ce script vous permet la mise � jour depuis la/les version(s) {LAST_VERSION} vers la version {NEW_VERSION}.

Attention, pour utilisez ce script, vous devez d�ja avoir effectu� l\'installation d\'une ancienne version de CrazyCMS !' );
define ( 'ACCEPT_LICENSE' , 'Pour continuer l\'installation, veuillez lire la licence d\'utilisation et l\'accepter' );
define ( 'ACCEPT_TERMS' , 'Accepter les termes de la license d\'utilisation' );
define ( 'STEP_0_5' , 'Retour ( Choix du Type d\'installation )' );
define ( 'DO_UPDATE' , ' Effectuer la mise � jour' );
define ( 'REFFUSE_TERMS' , 'Refuser les termes de la license d\'utilisation' );
define ( 'INSTALL_MAIN_FUNCTIONS' , 'Fonctions Principales' );
define ( 'INSTALL_PHP_VERSION' , 'Version PHP' );
define ( 'GO_TO_UPDATE' , 'Effectuer une mise � jour' );
define ( 'INSTALL_COMPATIBLE' , 'COMPATIBLE' );
define ( 'INSTALL_INCOMPATIBLE' , 'NON COMPATIBLE' );
define ( 'INSTALL_SQL_BASE' , 'Base SQL' );
define ( 'INSTALL_ACTIVATED' , 'ACTIVE' );
define ( 'CLICK_IF_NOT_REDIRECTED' , 'Cliquez ici si vous n\'�tes pas redirig�s automatiquement' );
define ( 'INSTALL_SUMMER_HOUR' , 'Heure d\'�t�' );
define ( 'INSTALL_UNACTIVATED' , 'NON ACTIVE' );
define ( 'INSTALL_FILE_UPLOAD' , 'Upload de fichiers' );
define ( 'INSTALL_GD_LIBRARY' , 'Librairie gd2' );
define ( 'INSTALL_CHMOD_777' , 'CHMOD' );
define ( 'INSTALL_YES' , 'OUI' );
define ( 'ALERT_SECURITY' , 'Erreur de S�curit� !<br /><br />Recommencez l\'installation d�s le d�but !' );
define ( 'INSTALL_NO' , 'NON' );
define ( 'INSTALL_PASSWORD' , 'Mot de Passe' );
define ( 'INSTALL_NEXT_STEP' , 'Etape suivante' );
define ( 'INSTALL_SQL_CONNECTION' , 'Connexion SQL' );
define ( 'INSTALL_SQL_SERVER_NAME' , 'Nom du serveur SQL' );
define ( 'INSTALL_SQL_USER_NAME' , 'Nom d\'utilisateur SQL' );
define ( 'INSTALL_SQL_USER_PASS' , 'Mot de passe SQL' );
define ( 'INSTALL_SQL_BASE_NAME' , 'Nom de la base SQL' );
define ( 'INSTALL_SQL_TABLE_PREFIXE' , 'Pr�fixe des Tables SQL ( Optionnel )' );
define ( 'INSTALL_COULDNT_CONNECT_SQL_SERVER' , 'Erreur de connection au serveur SQL' );
define ( 'INSTALL_COULDNT_SELECT_SQL_BASE' , 'Impossible de se connecter � la Base' );
define ( 'CONFIG_FILE_SUCCESSFULLY_CREATED' , 'Fichier de configuration cr�e avec Succ�s' );
define ( 'INSTALL_SITE_CONFIG' , 'Configuration du Site' );
define ( 'INSTALL_SITE_NAME' , 'Nom du Site' );
define ( 'INSTALL_SITE_URL' , 'Url du site' );
define ( 'INSTALL_HOUR_FUSEAUX' , 'Fuseau horaire' );
define ( 'INSTALL_MODS_TO_INSTALL' , 'Modules � installer' );
define ( 'INSTALL_PORTAL' , 'Portail' );
define ( 'INSTALL_USERS_STATS' , 'Utilisateurs, stats, etc...' );
define ( 'INSTALL_MODS_PORTAL_INSTALLED' , 'Tables et Modules Install�s avec succ�s' );
define ( 'INSTALL_ADMIN_ACCOUNT' , 'Information compte administrateur' );
define ( 'INSTALL_PSEUDO' , 'Pseudo' );
define ( 'INSTALL_REPEAT_PASSWORD' , 'Repetez votre mot de passe' );
define ( 'INSTALL_EMAIL' , 'Adresse Email' );
define ( 'INSTALL_INVALID_PSEUDO' , 'Pseudo invalide ( les * sont interdites )' );
define ( 'IDENTICAL_PASSWORD' , 'Mots de Passe identiques' );
define ( 'DIFFERENT_PASSWORD' , 'Mots de Passe diff�rents !' );
define ( 'VOID_FIELD' , 'Vous devez entrez un mot de passe !' );
define ( 'INSTALL_EMAIL_INVALID' , 'Adresse E-Mail invalide' );
define ( 'INSTALL_CANT_INSTALL' , 'La configuration de votre serveur emp�che l\'installation de CrazyCMS' );
define ( 'INSTALL_FINISH' , 'Votre compte d\'administrateur a &eacute;t&eacute; cr�e avec succ&egrave;s, l\'installation de votre site est maintenant termin�.

Vous allez maintenant profiter de votre site. N\'oubliez pas de faire un tour dans l\'administration pour parametrer les dernieres options...' );

// Aide des diff�rentes �tapes
define ( 'STEP_1_HELP' , '&nbsp;&nbsp;Cliquez sur la fl�che de droite afin de commencer l\'installation de CrazyCMS

&nbsp;&nbsp;&nbsp;&nbsp;<u>CHMOD :</u>

&nbsp;&nbsp;&nbsp;<i>Qu\'est-ce-qu\'un CHMOD ?</i>

&nbsp;Le CHMOD est l\'autorisation que poss�de un certain fichier ou dossier afin de pouvoir lire et �crire dans un autre fichier / dossier ou bien pour que l\'on puisse lire ou �crire ce fichier.

&nbsp;&nbsp;&nbsp;<i>Comment changer le CHMOD d\'un fichier / dossier ?</i>

&nbsp;Pour changer le CHMOD d\'un fichier ou d\'un dossier, vous devez utiliser votre client FTP. Une fois connect�, faites un clic-droit sur le fichier ou le dossier concern� puis choisissez "Attributs" ou "Propri�t�s" en fonction du client FTP puis vous pourrez alors changer le num�ro du CHMOD
Si jamais vous ne trouvez pas comment changer le CHMOD d\'un de vos fichiers / dossiers, n\'h�sitez pas � venir demander une aide sur <a href="http://crazycms.com">http://crazycms.com</a>' );
define ( 'STEP_2_HELP' , '&nbsp;&nbsp;Vous devez accepter les termes de la licence d\'utilisation ci-dessous afin de poursuivre l\'installation de CrazyCMS' );
define ( 'STEP_3_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Fonctions principales :</u>

&nbsp;&nbsp;Les Fonctions principales doivent �tre activ�s sur votre serveur / h�bergeur afin que CrazyCMS puisse �tre install� dessus.
Si une des fonctions principales ne passe pas, vous pouvez changer d\'h�bergeur ou bien venir demander une aide sur <a href="http://crazycms.com">http://crazycms.com</a>

&nbsp;&nbsp;&nbsp;&nbsp;<u>CHMOD :</u>

&nbsp;&nbsp;&nbsp;<i>Qu\'est-ce-qu\'un CHMOD ?</i>

&nbsp;Le CHMOD est l\'autorisation que poss�de un certain fichier ou dossier afin de pouvoir lire et �crire dans un autre fichier / dossier ou bien pour que l\'on puisse lire ou �crire ce fichier.

&nbsp;&nbsp;&nbsp;<i>Comment changer le CHMOD d\'un fichier / dossier ?</i>

&nbsp;Pour changer le CHMOD d\'un fichier ou d\'un dossier, vous devez utiliser votre client FTP. Une fois connect�, faites un clic-droit sur le fichier ou le dossier concern� puis choisissez "Attributs" ou "Propri�t�s" en fonction du client FTP puis vous pourrez alors changer le num�ro du CHMOD
Si jamais vous ne trouvez pas comment changer le CHMOD d\'un de vos fichiers / dossiers, n\'h�sitez pas � venir demander une aide sur <a href="http://crazycms.com">http://crazycms.com</a>

&nbsp;&nbsp;&nbsp;<i>Quel CHMOD attribuer ?</i>

&nbsp;Le CHMOD � attribuer � un fichier ou bien � un dossier est indiqu� au d�but de la ligne entre-crochets.
En g�n�ral, le CHMOD � appliquer est de 700 pour les dossiers et de 644 pour les fichiers' );

define ( 'STEP_4_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Nom du serveur SQL: </u>

&nbsp;&nbsp;L\'adresse du serveur SQL. <i>(Fournit par l\'h�bergeur)</i>


&nbsp;&nbsp;&nbsp;&nbsp;<u>Nom d\'utilisateur SQL: </u>

&nbsp;&nbsp;Le login de connection. <i>(Fournit par l\'h�bergeur)</i>


&nbsp;&nbsp;&nbsp;&nbsp;<u>Mot de passe SQL: </u>

&nbsp;&nbsp;Le mot de passe de votre compte. <i>(Fournit par l\'h�bergeur)</i>


&nbsp;&nbsp;&nbsp;&nbsp;<u>Nom de la base SQL: </u>

&nbsp;&nbsp;Nom de votre base SQL. <i>(Fournit par l\'h�bergeur, Dans un certain nombre de cas, c\'est le m�me nom que celui d\'utilisateur )</i>


&nbsp;&nbsp;&nbsp;&nbsp;<u>Pr�fixe des Tables SQL: </u>

&nbsp;&nbsp;Seulement si vous d�sirez h�berger plusieurs site CrazyCMS. Diff�rent d\'un site � l\'autre.<i>(Optionnel)</i>' );
define ( 'STEP_5_HELP' , '&nbsp;&nbsp;Cliquez sur la fl�che de droite afin de continuer l\'installation de CrazyCMS' );
define ( 'STEP_6_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Informations g�n�rales :</u>

&nbsp;&nbsp;Le nom de votre site, l\'adresse de votre site et le fuseau sont n�c�ssaires. Vous pourrez les changer par la suite si vous le souhaitez. Cependant le choix d\'un mauvais fuseau d�calera toutes les heures du site ( messages, news, etc ... ) et l\'entr�e d\'une mauvaise adresse empechera la bonne marche de certaines fonctionalit�s

&nbsp;&nbsp;&nbsp;&nbsp;<u>Modules � installer : </u>

&nbsp;&nbsp;Vous pouvez choisir les modules � installer pour votre site. Ne vous inquietez pas, vous pourrez toujours installer ou m�me d�sinstaller des modules par la suite' );
define ( 'STEP_7_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Installation des modules :</u>

&nbsp;&nbsp;Les modules que vous avez s�l�ctionn�s ont �t�s install�s ainsi que le portail, cliquez sur la fl�che de droite pour arriver � la derni�re �tape de l\'installation

&nbsp;&nbsp;Si un modules s\'est mal install�, ne vous inquietez pas et continuez, si l\'installation de ce module � r�ellement �chou�, vous pourrez le r�-installer par la suite. Si jamais il y � toujours une erreur d\'installation de ce module, vous pouvez venir demander de l\'aide sur <a href="http://crazycms.com">http://crazycms.com</a>' );
define ( 'STEP_8_HELP' , '&nbsp;&nbsp;&nbsp;&nbsp;<u>Cr�ation du compte administrateur : </u>

&nbsp;&nbsp;Vous devez d�sormais cr�er votre compte. Il vous permettra de vous connecter sur votre site pour pouvoir participer et administrer votre site.
Vous pourrez cr�er d\'autres comptes administrateurs par la suite si vous souhaitez que d\'autres personnes viennent vous aider � g�rer votre site' );
define ( 'SHOW_ADMIN_INDEX' , 'Voir l\'administration des modules' );
define ( 'SHOW_ADMIN_DEFAULTS' , 'Voir l\'administration du portail' );
define ( 'VIEW_CACHE_ADMIN' , 'Voir l\'administration du Cache' );
define ( 'MANAGE_GRADES' , 'G�rer les Grades' );
define ( 'GUEST' , 'Invit�' );
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