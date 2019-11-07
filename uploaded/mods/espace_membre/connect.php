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

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => connection ) );

	$template->set_filename ( './modules/espace_membre/connect.tpl' );
	
	$template->assign_block_vars ( 'index' , array ( 
	'IDENTIFICATION' => identification,
	'PLEASE_ENTER_LOGIN' => please_enter_login,
	'PLEASE_ENTER_PASSWORD' => please_enter_password,
	'TO_REMEMBER' => to_remember,
	'VALID' => valid,
	'FORGETTED_PASSWORD' => forgetted_password,
	'U_THEME' => $u_theme,
	'U_LANG' => $u_lang ) );
	
	if ( $be_log == 1 )
		$template->assign_block_vars ( 'index.be_log' , array (
		'CONNECTION_INDISPENSABLE' => CONNECTION_INDISPENSABLE,
		'YOU_MUST_BE_CONNECTED' => YOU_MUST_BE_CONNECTED,
		'IF_NOT_CLICK' => IF_NOT_CLICK,
		'HERE' => here,
		'TO_REGISTER' => TO_REGISTER ) );

	$template->set_filename ( 'bas_mods.tpl' );

?>