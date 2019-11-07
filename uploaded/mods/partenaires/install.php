<?php
/*
Copyright CrazyCMS : 

Valmori Quentin
	gay_4_ever@hotmail.fr
Feuvre Christophe
	chris_tophe2@hotmail.com
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
FICHIER D'INSTALLATION DU MODULE PARTENAIRE
*/

// On vérifie que tous les fichiers nécessaires au fonctionnement du forum marchent ;)
if(file_exists($rep.'/mods/partenaires/admin.php') AND file_exists($rep.'/mods/partenaires/admincat.php') AND file_exists($rep.'/mods/partenaires/index.php') AND file_exists($rep.'/mods/partenaires/mort.php') AND file_exists($rep.'/mods/partenaires/register.php') AND file_exists($rep.'/mods/partenaires/show.php') AND file_exists($rep.'/mods/partenaires/visite.php')){

//Création de la table des categories
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_partenaires_cat (
  id int(11) NOT NULL auto_increment,
  cat varchar(255) NOT NULL default "",
  PRIMARY KEY  (id)
) ' );

//Création de la table des parteanires
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_partenaires (
  id int(11) NOT NULL auto_increment,
  url_site varchar(255) NOT NULL,
  rss varchar(250) NOT NULL,
  cat varchar(255) NOT NULL,
  nb_click int(10) NOT NULL default "0",
  nb_aff int(10) NOT NULL default "0",
  description text NOT NULL,
  nom varchar(255) NOT NULL,
  valid int(1) NOT NULL default "0",
  date int(11) NOT NULL,
  short_desc varchar(100) NOT NULL,
  PRIMARY KEY  (id)
)' );

//Enregistrement de la condition de partenariat
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "cdt_partenaires", "PAS ENCORE DEFINIE")' );

		$cont .= '<font color="green">'.PARTENAIRES_INSTALL_SUCCESS.'</font>';
}
else{

		$cont .= '<font color="red">'.PARTENAIRES_INSTALL_ERROR.'</font><br />';

if(!file_exists($rep.'/mods/partenaires/index.php')){
	$cont_forum .= ' - '.file.' "index.php" '.is_requis.' <br />';
}
if(!file_exists($rep.'/mods/partenaires/delete.php')){
	$cont_forum .= ' - '.file.' "mort.php" '.is_requis.' <br />';
}
if(!file_exists($rep.'/mods/partenaires/admin.php')){
	$cont_forum .= ' - '.file.' "admin.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/partenaires/admin2.php')){
	$cont_forum .= ' - '.file.' "admincat.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/partenaires/edit.php')){
	$cont_forum .= ' - '.file.' "register.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/partenaires/post.php')){
	$cont_forum .= ' - '.file.' "show.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/partenaires/search.php')){
	$cont_forum .= ' - '.file.' "visite.php" '.is_requis.'<br />';
}

}
?>