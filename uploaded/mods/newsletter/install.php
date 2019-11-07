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
if ( file_exists ( $rep.'/mods/newsletter/bloc.php' ) && file_exists ( $rep.'/mods/newsletter/admin.php' ) ){

$Bdd->sql ( 'INSERT INTO '.PT.'_parametres VALUES ( "" , "newsletter_grade_admin" , "4," )' );

$Bdd->delete_cached_data ( 'config' );

//Création de la table des categories
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_newsletter (
  id int(11) NOT NULL auto_increment,
  email varchar(255) NOT NULL,
  user int(11) NOT NULL,
  date_registration int(11) NOT NULL,
  PRIMARY KEY  (id)
) ' );

		$cont.= '<font color="green">'.NEWSLETTER_INSTALLED.'</font>';

}
else{

if(!file_exists($rep.'/mods/newsletter/bloc.php'))
	echo ' - '.file.' "bloc.php" '.is_requis.' <br />';
if(!file_exists($rep.'/mods/newsletter/admin.php'))
	echo ' - '.file.' "admin.php" '.is_requis.' <br />';

	$cont.= '<font color="red">'.NEWSLETTER_ERROR.'</font>';
}

?>