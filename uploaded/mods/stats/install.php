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
FICHIER D'INSTALLATION DE STATS
*/

// On vérifie que tous les fichiers nécessaires au fonctionnement des stats marchent ;)
if(file_exists('../mods/stats/arrs.php') && file_exists('../mods/stats/bloc.php') && file_exists('../mods/stats/index.php') && file_exists('../mods/stats/records.ini') ){

$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_stats (
  id int(11) NOT NULL auto_increment,
  id_user int(11) NOT NULL default "0",
  ip varchar(15) NOT NULL default "",
  pays varchar(40) NOT NULL default "",
  navig varchar(40) NOT NULL default "",
  os varchar(40) NOT NULL default "",
  theme varchar(40) NOT NULL default "",
  date text NOT NULL,
  location text NOT NULL,
  provenance varchar(255) NOT NULL default "",
  timestamp int(11) NOT NULL default "0",
  grade int(11) NOT NULL default "0",
  bonux text NOT NULL,
  KEY id (id)
)');

$Bdd->sql ( 'INSERT INTO '.PT.'_blocs VALUES ("", "stats", "Statistiques", 1, 2,"left")' );

	$cont .= '<font color="green">'.STATS_SUCCESSFULLY_INSTALLED.'</font>';

}
else{

if(!file_exists('../mods/stats/index.php')){
	$cont .= ' - '.file.' "index.php" '.is_requis.' <br />';
}
if(!file_exists('../mods/stats/records.ini')){
	$cont .= ' - '.file.' "records.ini" '.is_requis.' <br />';
}
if(!file_exists('../mods/stats/arrs.php')){
	$cont .= ' - '.file.' "arrs.php" '.is_requis.' <br />';
}
if(!file_exists('../mods/stats/bloc.php')){
	$cont .= ' - '.file.' "bloc.php" '.is_requis.' <br />';
}

}

?>