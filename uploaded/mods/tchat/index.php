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

if ( !isset ( $pseudo ) || $pseudo == '' ){
	$pseudo = guest;
}

// Si l'utilisateur à l'autorisation de voir le chat, on lui affiche ;)
if( ereg("view_chat;",$permissions) || $grade == 4)
{

	//On va inscrire le pseudo, pass, permissions et grade de cette utilisateur dans un fichier temporaire pour verifier qu'il sagit bien de lui par la suite sans sql
	$users = parse_ini_file('./mods/tchat/config/users.ini', true);
	$users[$uid] = array(
	'pseudo' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $pseudo ) ),
	'password' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $user_password ) ),
	'permissions' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $permissions ) ),
	'grade' => $grade);
	$new_ini = '';
	foreach($users as $id => $array){
		$new_ini .= '['.$id.']
		pseudo = '.$array['pseudo'].';
		password = '.$array['password'].';
		permissions = '.$array['permissions'].';
		grade='.$array['grade'].';
		
		';
	}
	$file = fopen('./mods/tchat/config/users.ini' , 'w' );
	fputs ( $file , $new_ini );
	fclose ( $file );
	// Fin de la mise a jour de listes des users du chat
	
	//Si aucun salon special n'a ete defini, on charge le salon par defaut
	if(!isset($_GET['salon'])){
		$salle = 'defaut';
	}
	else{
		$salle = htmlspecialchars($_GET['salon'],ENT_QUOTES);	
	}
	if(isset($_GET['pass'])){
		// Si le password est defini, on le recupere
		$password = htmlspecialchars($_GET['pass'],ENT_QUOTES);
	}
	else{
		$password = 'aucunpass';
	}

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => CHAT_TITRE ) );

	$date_format = str_replace ( '+' , 'plustoreplace' , str_replace ( '&' , 'andtoreplace' , str_replace ( '=' , 'egaletoreplace' , $format_date ) ) );
	
	$template->set_filename ( './modules/tchat/index.tpl' );
	$template->assign_block_vars ( 'index' , array (
	'NO_JS' => no_js,
	'PUBLIC_SALON' => PUBLIC_SALON,
	'DEFAULT_SALON' => DEFAULT_SALON,
	'PRIVATE_SALON' => PRIVATE_SALON,
	'SMILIES' => SMILIES,
	'UID' => $uid,
	'PSEUDO' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $pseudo ) ),
	'U_PWD' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $user_password ) ),
	'SALLE' => $salle,
	'PASS' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $password ) ),
	'CONNECTS' => CONNECTS,
	'IS_COME' => IS_COME,
	'ARE_COME' => ARE_COME,
	'IS_LEFT' => IS_LEFT,
	'ARE_LEFT' => ARE_LEFT,
	'FUSEAUX' => $fuseaux,
	'LANGUE' => $u_lang,
	'TRUE' => TRUE,
	'DATE_FORMAT' => $date_format,
	'THEME' => $u_theme ) );
	
	$a = false;
	$salon_public = opendir('./mods/tchat/salons/public' );
	while ( ( $salon = readdir ( $salon_public ) ) != false ){
		if ( $salon != '..' && $salon != '.' && is_file ( './mods/tchat/salons/public/'.$salon ) && substr ( $salon , ( strlen ( $salon ) - 4 ) , strlen ( $salon ) ) == '.ini' )
		{
			$a = true ;
			$salon = substr ( $salon , 0 , ( strlen ( $salon ) - 4 ) );
			$template->assign_block_vars ( 'index.pubs' , array ( 
			'URL' => 'index.php?mods=tchat&amp;salon=pub-'.$salon.'&amp;pub',
			'TXT' => base64_decode ( $salon ) ) );
		}
	}
	
	if ( $a === false ) {
		$template->assign_block_vars ( 'index.npubs' , array ( 'TXT' => NONE_PUBLIC_SALON ) );
	}
					
	$a = false;
	$salon_public = opendir('./mods/tchat/salons/prive' );
	while ( ( $salon = readdir ( $salon_public ) ) != false ){
		if ( $salon != '..' && $salon != '.' && is_file ( './mods/tchat/salons/prive/'.$salon ) && substr ( $salon , ( strlen ( $salon ) - 4 ) , strlen ( $salon ) ) == '.ini')
		{
			$a = true ;
			$salon = substr ( $salon , 0 , ( strlen ( $salon ) - 4 ) );
			$template->assign_block_vars ( 'index.privs' , array ( 
			'URL' => 'javascript:open_salle(\'pri-'.$salon.'\', \''.GIVE_PASS.'\', \''.PASSWORD.'\')',
			'TXT' => base64_decode ( $salon ) ) );
		}	
	}
	
	if ( $a === false ) {
		$template->assign_block_vars ( 'index.nprivs' , array ( 'TXT' => NONE_PRIVATE_SALON ) );
	}
					
	if ( !ereg("post_chat;",$permissions) AND $grade != 4)
		$template->assign_block_vars ( 'index.cant_add' , array ( 'POST_FORBIDDEN' => POST_FORBIDDEN ) );
	else
		$template->assign_block_vars ( 'index.add' , array ( 
		'ADD_MESSAGE' => ADD_MESSAGE,
		'UID' => $uid,
		'PSEUDO' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $pseudo ) ),
		'U_PWD' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $user_password ) ),
		'SALLE' => $salle,
		'PASS' => str_replace ( '=' , 'egaletoreplace' , base64_encode ( $password ) ),
		'TIME' => convertime ( time() ),
		'VALID' => valid ) );

	$date_format = str_replace ( '+' , 'plustoreplace' , str_replace ( '&' , 'andtoreplace' , str_replace ( '=' , 'egaletoreplace' , $format_date ) ) );
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>