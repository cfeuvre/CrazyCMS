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
if($grade>0)
{
	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => lang ) );

	$template->set_filename ( './modules/espace_membre/links.tpl' );
	$template->assign_block_vars ( 'links' , array (
	'UID' => $uid,
	'PWD' => $user_password,
	'UNLOG' => unlog,
	'MY_BLOC_NOTE' => my_bloc_note,
	'MODIF_PROFIL' => modif_profil,
	'CHANGE_LANGUAGE' => change_language,
	'CHANGE_THEME' => change_theme,
	'MY_INFOS' => my_infos,
	'MY_CONFIG' => my_config ) );
	
	$template->set_filename ( './modules/espace_membre/langue.tpl' );
		
	if (isset ($_POST['lang']))
	{
		$Bdd->sql('UPDATE '.PT.'_users  SET langue="'.htmlspecialchars($_POST['lang'],ENT_QUOTES).'" WHERE id="'.$uid.'"' );
		header ( 'Location: #');
		die ('') ;
	}
	
	$template->assign_block_vars ( 'lang' , array (
	'LANG' => lang,
	'PLEASE_CHOOSE_LANGUAGE' => please_choose_language,
	'VALID' => valid ) );
	
	$lang_liste = '';
	$t=opendir('./langues/' ); 
	while ($lg=readdir($t))
	{
		if($lg != '.' && $lg !='..' && $lg!='.htaccess' && $lg!='index.html'){
			$template->assign_block_vars ( 'lang.lg' , array (
			'LANGUE' => $lg,
			'SELECTED' => ( ( $lg == $u_lang ) ? ('selected="selected"') : ('') ) ) );
		}
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>	