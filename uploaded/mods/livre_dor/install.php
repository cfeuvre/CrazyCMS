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
FICHIERS POUR L'INSTALLATION DU LIVRE D'OR
*/

// On vérifie que tous les fichiers nécessaires au fonctionnement du forum marchent ;)
if(file_exists($rep.'/mods/livre_dor/index.php') && file_exists($rep.'/mods/livre_dor/admin.php') && file_exists($rep.'/mods/livre_dor/look.php') && file_exists($rep.'/mods/livre_dor/poster.php')){

//Table des messages du livre dor
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_livredor (
  id int(11) NOT NULL auto_increment,
  auteur varchar(50) NOT NULL default "",
  com text NOT NULL default "",
  date int(11) NOT NULL default "0",
  propose char(2) NOT NULL default "",
  note text NOT NULL,
  PRIMARY KEY  (id)
)' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "livre_dor_grade_admin","3")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "livre_or_validation","1")' );
$Bdd->sql('INSERT INTO '.PT.'_blocs VALUES (11, "livre_dor", "Livre d\'Or", 1, 6,"left");
' );
$Bdd->sql('INSERT INTO '.PT.'_livredor VALUES ("", "2", "'.FIRST_MESS_LIVREOR_CONTENU.'", 1172755729, "0", "5")' );

$Bdd->sql ( 'INSERT INTO '.PT.'_parametres VALUES ("", "livre_or_validation","1")' );

		$cont .= '<font color="green">'.LIVREDOR_INSTALLED.'</font>';

}
else{

	$cont.= ERROR_LIVREOR.'<br />';

if(!file_exists($rep.'/mods/livre_dor/admin.php')){
	$cont .= ' - '.file.' "admin.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/livre_dor/index.php')){
	$cont .= ' - '.file.' "index.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/livre_dor/look.php')){
	$cont .= ' - '.file.' "look.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/livre_dor/poster.php')){
	$cont .= ' - '.file.' "poster.php" '.is_requis.'<br />';
}


}
?>