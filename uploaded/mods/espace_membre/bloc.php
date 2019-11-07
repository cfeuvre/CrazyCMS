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

$template->set_filename ( './modules/espace_membre/bloc.tpl' , FALSE , $row['colonne'] );
$template->assign_bloc_name ( 'BLOC_ESPACE_MEMBRE_TITLE' , $row['tbloc'] );

include_once('./mods/espace_membre/langues/'.$u_lang.'.php' );

if($grade == 0){
	$template->assign_block_vars ( 'espace_membre_bloc_connect' , array (
	'PSEUDO' => pseudo,
	'PASSWORD' => password,
	'TO_REMEMBER' => to_remember,
	'FORGETTED_PASSWORD' => forgetted_password,
	'VALID' => valid,
	'THEME' => $u_theme,
	'LANG' => $u_lang,
	'URL' => htmlspecialchars ( $_SERVER['REQUEST_URI'] ) ) );
}
elseif($grade >= 1){
	$arch = 0;
	$new = 0;
	$sql2=$Bdd->sql('SELECT * FROM '.PT.'_messagerie WHERE  '.PT.'_messagerie.destinataire="'.$uid.'" ' );
	while($compte_nb = $Bdd->get_object($sql2)){
		if($compte_nb->vu == 0){
			$arch++;
		}
		else if($compte_nb->vu ==1){
			$new++;
		}
	}
	
	$imz = @getimagesize ( $u_avatar );
	
	if ( $imz[0] == '' AND $imz[1] == '' ){
		$new_width = 125;
		$new_height = 125;
	}
	else{	
		$size = resize ( 125 , 125 , $imz[0] , $imz[1] );
		$new_width = $size[0];
		$new_height = $size[1];
	}
	
	$template->assign_block_vars ( 'espace_membre_bloc_connected' , array (
	'WELCOME' => welcome,
	'PSEUDO' => $pseudo,
	'AVATAR' => $u_avatar,
	'WIDTH' => $new_width,
	'HEIGHT' => $new_height,
	'UNLOG' => unlog,
	'UID' => $uid,
	'PWD' => $user_password,
	'SPACEMEMBER' => SPACEMEMBER,
	'ARCH' => $arch,
	'READED' => readed_mps,
	'SEND' => send_mp_bloc,
	'BLOCNOTE' => my_bloc_note,
	'CONFIG' => my_config ) );

	if($new != 0){
		$template->assign_block_vars ( 'espace_membre_bloc_connected.mps' , array (
		'NB' => $new,
		'TITLE' => see_own_mp,
		'NEW' => new_mp ) );
	}
}
?>