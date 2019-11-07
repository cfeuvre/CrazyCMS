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
FICHIERS POUR L'INSTALLATION DE LA GALERIE PHOTO
*/

// On vérifie que tous les fichiers nécessaires au fonctionnement du forum marchent ;)
if(file_exists($rep.'/mods/galerie_photo/admin.php') AND file_exists($rep.'/mods/galerie_photo/index.php') AND file_exists($rep.'/mods/galerie_photo/view_comment.php') AND file_exists($rep.'/mods/galerie_photo/voter.php')){

//Table pour indexation des photos
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_gallery (
  id int(11) NOT NULL auto_increment,
  nom varchar(255) NOT NULL default "",
  description text NOT NULL,
  votes text NOT NULL,
  galerie varchar(255) NOT NULL default "",
  PRIMARY KEY  (id)
)' );

//Table contenant les commentaires
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_gallery_comment (
  id int(11) NOT NULL auto_increment,
  parent int(11) NOT NULL default "0",
  auteur int(11) NOT NULL default "0",
  date int(11) NOT NULL default "0",
  smiley int(1) NOT NULL default "0",
  ip varchar(15) NOT NULL default "",
  contenu text NOT NULL,
  PRIMARY KEY  (id)
)' );

//Requete pour supprimer permissions galerie si y sont déja ( vu qu'on va les remettre vaut mieux qu'elle ne soient pas en double );
$Bdd->sql('DELETE FROM '.PT.'_permissions WHERE element="gallery"' );

// Ajout des permissions relatives au forum
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "comment_photo", "'.ADD_COMMENT_GALLERY.'", "gallery", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "view_gallery", "'.SEE_GALLERY.'", "gallery", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "view_comment_photo", "'.SEE_GALLERY_COMMENT.'", "gallery", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "gallery_vote", "'.VOTE_GALLERY.'", "gallery", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "galerie_photo_grade_admin","4,")' );

	$cont .= '<font color="green">'.GALLERY_INSTALLED.'</font>';

}
else{

	$cont.= GALLERY_ERROR.'<br />';

if(!file_exists($rep.'/mods/galerie_photo/admin.php')){
	$cont .= ' - '.file.' "admin.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/galerie_photo/index.php')){
	$cont .= ' - '.file.' "index.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/galerie_photo/view_comment.php')){
	$cont .= ' - '.file.' "view_comment.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/galerie_photo/voter.php')){
	$cont .= ' - '.file.' "voter.php" '.is_requis.'<br />';
}
}
?>