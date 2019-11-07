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
// Si l'utilisateur n'est pas un invité, on lui affiche son espace personel
if($grade>0)
{

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => help_member ) );

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
	
	$template->set_filename ( './modules/espace_membre/aide.tpl' );

	$template->assign_block_vars ( 'help' , array (
	'SPACEMEMBER_FUNCTIONMENT' => spacemember_functionment,
	'OPERATORY_MODE' => operatory_mode,
	'PROFIL_MODIF' => profil_modif,
	'PROFIL_MODIF_DEF' => profil_modif_def,
	'LITTLE_RAPPEL' => little_rappel,
	'MDP_MORE_5_CHAR' => mdp_more_5_char,
	'CREATE_A_NOTE_DEF' => create_a_note_def,
	'HOW_TO_CREATE_NOTE' => how_to_create_note,
	'HOW_TO_SEE_OR_DELETE_NOTE' => how_to_see_or_delete_note,
	'SEND_MP' => send_mp,
	'HOW_TO_SEND_MP' => how_to_send_mp,
	'TO_KNOW_IF_MP' => to_know_if_mp,
	'BACK' => back_to_spacemember ) );
	
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}

?>