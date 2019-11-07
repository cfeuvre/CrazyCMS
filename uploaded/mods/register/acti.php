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
if(!defined('CCMS'))die('' );

$query = $Bdd->sql('SELECT id FROM '.PT.'_parametres WHERE nom="activ:'.str_replace('%20' , '',$Bdd->secure($_GET['pseudo'])).'" AND valeur="'.$Bdd->secure($_GET['code']).'"' );
if($Bdd->get_num_rows($query)==0){

	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => verification_error ) );

}
else{

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => ACTIVATION ) );

	$template->set_filename ( './modules/register/acti.tpl' );

	$Bdd->sql('UPDATE '.PT.'_users SET grades="1" WHERE pseudo="'.str_replace('%20' , '',$Bdd->secure($_GET['pseudo'])).'" AND date_inscription="'.$Bdd->secure($_GET['i']).'"' );
	
	$template->assign_block_vars ( 'text' , array (
	'TXT' => verification_success,
	'URL' => 'index.php?mods=espace_membre&amp;page=connect',
	'BACK' => back ) );

	$template->set_filename ( 'bas_mods.tpl' );
	
}

?>