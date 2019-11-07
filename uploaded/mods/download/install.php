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
*/

/*
FICHIER D'INSTALLATION DU MODULE DE TELECHARGEMENTS
*/

// On vérifie que tous les fichiers nécessaires au fonctionnement du module download marchent ;)
if ( file_exists($rep.'/mods/download/add_comment.php') AND file_exists($rep.'/mods/download/admin.php') AND file_exists($rep.'/mods/download/dl.php') AND file_exists($rep.'/mods/download/index.php') AND file_exists($rep.'/mods/download/recommander.php') AND file_exists($rep.'/mods/download/viewcat.php') AND file_exists($rep.'/mods/download/viewfile.php') ){

	// Creation de la table des catégories
	$Bdd->sql ( 'CREATE TABLE IF NOT EXISTS '.PT.'_download_cat 
		(
		  `id` int(11) NOT NULL auto_increment,
		  `parent` int(11) NOT NULL,
		  `nb_files` int(5) NOT NULL,
		  `nb_hits` int(5) NOT NULL,
		  `nb_downloads` int(5) NOT NULL,
		  `nom` varchar(40) NOT NULL,
		  `description` varchar(255) NOT NULL,
		  `groupes` varchar(255) NOT NULL,
		  `grades` varchar(255) NOT NULL,
		  `password` varchar(255) NOT NULL,
		  PRIMARY KEY  (`id`)
		)' );
		
	// Creation de la table des commentaires
	$Bdd->sql ( 'CREATE TABLE IF NOT EXISTS '.PT.'_download_comments 
		(
		  `id` int(11) NOT NULL auto_increment,
		  `parent` int(11) NOT NULL,
		  `auteur` int(11) NOT NULL,
		  `contenu` text NOT NULL,
		  `note` int(2) NOT NULL,
		  `date` int(11) NOT NULL,
		  PRIMARY KEY  (`id`)
		)' );

	// Creation de la table des fichiers
	$Bdd->sql ( 'CREATE TABLE IF NOT EXISTS '.PT.'_download_files 
		(
		  `id` int(11) NOT NULL auto_increment,
		  `parent` int(11) NOT NULL,
		  `nom` varchar(20) NOT NULL,
		  `description` text NOT NULL,
		  `mirrors` text NOT NULL,
		  `pictures` text NOT NULL,
		  `password` varchar(255) NOT NULL,
		  `groupes` varchar(255) NOT NULL,
		  `grades` varchar(255) NOT NULL,
		  `minimum_date` int(11) NOT NULL,
		  `maximum_date` int(11) NOT NULL,
		  `votes` text NOT NULL,
		  `add_comment` int(1) NOT NULL,
		  `add_comment_groupe` varchar(255) NOT NULL,
		  `add_comment_grade` varchar(255) NOT NULL,
		  `hits` int(11) NOT NULL,
		  `downloads` int(11) NOT NULL,
		  `version` varchar(20) NOT NULL,
		  `taille` int(11) NOT NULL,
		  `licence` varchar(30) NOT NULL,
		  `sortie_date` int(11) NOT NULL,
		  `editeur` varchar(40) NOT NULL,
		  PRIMARY KEY  (`id`)
		)' );
		// , 	;
		$Bdd->sql ( 'INSERT INTO '.PT.'_parametres VALUES 
			( NULL , "download_reco_mess" , "Je trouve que le fichier suivant est intéressant, Je vous invite à venir le voir : {LIEN}" ),
			( NULL , "download_grade_admin", "4" )' );
			
		$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ( "" , "view_download_index" , "Voir le module de téléchargement" , "download" , "module")');
	
	$cont .= '<font color="green">'.DOWNLOAD_INSTALL_SUCCESS.'</font>';
}
else{

	$cont .= '<font color="red">'.DOWNLOAD_INSTALL_ERROR.'</font><br />';

	if(!file_exists($rep.'/mods/download/add_comment.php')){
		$cont_forum .= ' - '.file.' "add_comment.php" '.is_requis.' <br />';
	}
	if(!file_exists($rep.'/mods/download/admin.php')){
		$cont_forum .= ' - '.file.' "admin.php" '.is_requis.' <br />';
	}
	if(!file_exists($rep.'/mods/download/dl.php')){
		$cont_forum .= ' - '.file.' "dl.php" '.is_requis.'<br />';
	}
	if(!file_exists($rep.'/mods/download/index.php')){
		$cont_forum .= ' - '.file.' "index.php" '.is_requis.'<br />';
	}
	if(!file_exists($rep.'/mods/download/recommander.php')){
		$cont_forum .= ' - '.file.' "recommander.php" '.is_requis.'<br />';
	}
	if(!file_exists($rep.'/mods/download/viewcat.php')){
		$cont_forum .= ' - '.file.' "viewcat.php" '.is_requis.'<br />';
	}
	if(!file_exists($rep.'/mods/download/viewfile.php')){
		$cont_forum .= ' - '.file.' "viewfile.php" '.is_requis.'<br />';
	}

}
?>