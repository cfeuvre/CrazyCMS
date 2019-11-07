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

// On regarde si l'utilisateur a l'autorisation d'administrer ce module ou si c'est un administrateur
$grades = explode ( ',' , $tchat_grade_admin );
if( $grade == 4 || in_array ( $grade , $grades , TRUE ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => CHAT_ADMIN ) );

	$template->set_filename ( './modules/tchat/admin.tpl' );
	
	if ( isset ( $_GET['manage'] ) ){
		
		if ( isset ( $_POST['pub_welcome'] ) ) {
			
			if ( htmlspecialchars ( $_POST['salon'] ) == 'default' ){
				$salon = './mods/tchat/salons/'.htmlspecialchars ( $_POST['salon'] ).'.ini';
			}
			else{
				$salon = './mods/tchat/salons/public/'.htmlspecialchars ( $_POST['salon'] ).'.ini';
			}
			
			$new_conf = '';
			$lastconf = parse_ini_file ( $salon , TRUE );
			$conf = fopen ( $salon , 'r' );
			while ( !feof ( $conf ) ){
				$new_conf .= fgets ( $conf , 4096 );
			}
			$new_conf = str_replace ( 'welcome = '.$lastconf['config']['welcome'].';' ,  'welcome = '.str_replace ( '=' , 'egaletoreplace' , base64_encode ( htmlspecialchars ( $_POST['pub_welcome'] ) ) ).';' , $new_conf );
			
			$conf_n = fopen ( $salon , 'w' );
				fputs ( $conf_n , $new_conf );
			fclose ( $conf_n );

			$template->assign_block_vars ( 'text' , array (
			'TXT' => WELCOME_MESS_UPDATED,
			'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
			'BACK' => back ) );		
		}
		else if ( isset ( $_POST['pri_welcome'] ) ){
		
			$salon = './mods/tchat/salons/prive/'.htmlspecialchars ( $_POST['salon'] ).'.ini';

			$new_conf = '';
			$lastconf = parse_ini_file ( $salon , TRUE );
			$conf = fopen ( $salon , 'r' );
			while ( !feof ( $conf ) ){
				$new_conf .= fgets ( $conf , 4096 );
			}
			$new_conf = str_replace ( 'welcome = '.$lastconf['config']['welcome'].';' ,  'welcome = '.str_replace ( '=' , 'egaletoreplace' , base64_encode ( htmlspecialchars ( $_POST['pri_welcome'] ) ) ).';' , $new_conf );
			
			$conf_n = fopen ( $salon , 'w' );
				fputs ( $conf_n , $new_conf );
			fclose ( $conf_n );
			$template->assign_block_vars ( 'text' , array (
			'TXT' => WELCOME_MESS_UPDATED,
			'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
			'BACK' => back ) );		
		}
		else if ( isset ( $_POST['pri_pass'] ) ){
		
			$salon = './mods/tchat/salons/prive/'.htmlspecialchars ( $_POST['salon'] ).'.ini';

			$new_conf = '';
			$lastconf = parse_ini_file ( $salon , TRUE );
			$conf = fopen ( $salon , 'r' );
			while ( !feof ( $conf ) ){
				$new_conf .= fgets ( $conf , 4096 );
			}
			$new_conf = str_replace ( 'salon_password = '.$lastconf['config']['salon_password'].';' ,  'salon_password = '.md5 ( $_POST['pri_pass'] ).';' , $new_conf );
			
			$conf_n = fopen ( $salon , 'w' );
				fputs ( $conf_n , $new_conf );
			fclose ( $conf_n );
			$template->assign_block_vars ( 'text' , array (
			'TXT' => PASSWORD_UPDATED,
			'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
			'BACK' => back ) );		
		}
		else if ( isset ( $_GET['move_pub'] ) ){
			if ( isset ( $_POST['confirm'] ) ){
			
				if ( !strpos ( 'default' , htmlspecialchars ( base64_decode ( $_GET['move_pub'] ) ) ) ){
			
					switch ( $_POST['confirm'] ){
				
						case 0 :
							header ( 'Location: index.php?mods=tchat&page=admin&manage' );
						break;
					
						case 1 :
							if ( !rename ( './mods/tchat/salons/public/'.htmlspecialchars ( $_GET['move_pub'] ).'.ini' ,  './mods/tchat/salons/prive/'.htmlspecialchars ( $_GET['move_pub'] ).'.ini') ){
								$template->assign_block_vars ( 'text' , array (
								'TXT' => SALON_SECURE_FAILED,
								'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
								'BACK' => back ) );
							}
							else {
							
								$file = fopen ( './mods/tchat/salons/prive/'.htmlspecialchars ( $_GET['move_pub'] ).'.ini' , 'r' );
								$cont = '';
								while ( !feof ( $file ) ){
									$cont .= fgets ( $file , 4096 );
								}
								fclose ( $file );
								$cont = str_replace ( '[config]' , '[config]
								salon_password = '.md5 ( $_POST['password'] ).';' , $cont );
								$file = fopen ( './mods/tchat/salons/prive/'.htmlspecialchars ( $_GET['move_pub'] ).'.ini' , 'w' );
									fputs ( $file , $cont );
								fclose ( $file );
								$template->assign_block_vars ( 'text' , array (
								'TXT' => SALON_SECURE,
								'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
								'BACK' => back ) );							
							}

						break ;
				
					}
				
				}
			
			}
			else{
				$template->assign_block_vars ( 'confirm_private' , array (
				'CONFIRM_SECURE_SALON' => CONFIRM_SECURE_SALON,
				'NAME' => htmlspecialchars ( base64_decode ( $_GET['move_pub'] ) ),
				'NO' => NO,
				'YES' => YES,
				'PASSWORD' => PASSWORD,
				'CONFIRM' => CONFIRM ) );
			}
		}
		else if ( isset ( $_GET['move_pri'] ) ){
			if ( isset ( $_POST['confirm'] ) ){
			
				if ( !strpos ( 'default' , htmlspecialchars ( base64_decode ( $_GET['move_pri'] ) ) ) ){
			
					switch ( $_POST['confirm'] ){
				
						case 0 :
							header ( 'Location: index.php?mods=tchat&page=admin&manage' );
						break;
					
						case 1 :
							if ( !rename ( './mods/tchat/salons/prive/'.htmlspecialchars ( $_GET['move_pri'] ).'.ini' ,  './mods/tchat/salons/public/'.htmlspecialchars ( $_GET['move_pri'] ).'.ini') ){
								$template->assign_block_vars ( 'text' , array (
								'TXT' => SALON_PUBLICED_FAILED,
								'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
								'BACK' => back ) );
							}
							else {
							
								$file = fopen ( './mods/tchat/salons/public/'.htmlspecialchars ( $_GET['move_pri'] ).'.ini' , 'r' );
								$cont = '';
								while ( !feof ( $file ) ){
									$cont .= fgets ( $file , 4096 );
								}
								fclose ( $file );
								$salon = parse_ini_file ( './mods/tchat/salons/public/'.htmlspecialchars ( $_GET['move_pri'] ).'.ini' , TRUE );
								$cont = str_replace ( 'salon_password = '.$salon['config']['salon_password'].';' , '' , $cont );
								$file = fopen ( './mods/tchat/salons/public/'.htmlspecialchars ( $_GET['move_pri'] ).'.ini' , 'w' );
									fputs ( $file , $cont );
								fclose ( $file );
								$template->assign_block_vars ( 'text' , array (
								'TXT' => SALON_PUBLICED,
								'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
								'BACK' => back ) );							
							}

						break ;
					}
				}
			}
			else{
				$template->assign_block_vars ( 'confirm_public' , array (
				'CONFIRM_PUBLICED_SALON' => CONFIRM_PUBLICED_SALON,
				'NAME' => htmlspecialchars ( base64_decode ( $_GET['move_pri'] ) ),
				'NO' => NO,
				'YES' => YES,
				'CONFIRM' => CONFIRM ) );
			}
		}
		else if ( isset ( $_GET['del_pub'] ) ){
			if ( isset ( $_POST['confirm'] ) ){
			
				if ( !strpos ( 'default' , htmlspecialchars ( base64_decode ( $_GET['del_pub'] ) ) ) ){
			
					switch ( $_POST['confirm'] ){
				
						case 0 :
							header ( 'Location: index.php?mods=tchat&page=admin&manage' );
						break;
					
						case 1 :
							@unlink ( './mods/tchat/salons/public/'.htmlspecialchars ( $_GET['del_pub'] ).'.ini' );
							$template->assign_block_vars ( 'text' , array (
							'TXT' => SALON_DELETED,
							'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
							'BACK' => back ) );
						break ;
					}
				}
			}
			else{
				$template->assign_block_vars ( 'confirm_del' , array (
				'CONFIRM' => CONFIRM_DELETE_SALON,
				'NAME' => htmlspecialchars ( base64_decode ( $_GET['del_pub'] ) ),
				'NO' => NO,
				'YES' => YES,
				'CONFIRM' => CONFIRM ) );
			}
		}
		else if ( isset ( $_GET['del_pri'] ) ){
			if ( isset ( $_POST['confirm'] ) ){
			
				if ( !strpos ( 'default' , htmlspecialchars ( base64_decode ( $_GET['del_pri'] ) ) ) ){
			
					switch ( $_POST['confirm'] ){
				
						case 0 :
							header ( 'Location: index.php?mods=tchat&page=admin&manage' );
						break;
					
						case 1 :
							@unlink ( './mods/tchat/salons/prive/'.htmlspecialchars ( $_GET['del_pri'] ).'.ini' );
							$template->assign_block_vars ( 'text' , array (
							'TXT' => SALON_DELETED,
							'URL' => 'index.php?mods=tchat&amp;page=admin&amp;manage',
							'BACK' => back ) );
						break ;
					}
				}
			}
			else{
				$template->assign_block_vars ( 'confirm_del' , array (
				'CONFIRM' => CONFIRM_DELETE_SALON,
				'NAME' => htmlspecialchars ( base64_decode ( $_GET['del_pri'] ) ),
				'NO' => NO,
				'YES' => YES,
				'CONFIRM' => CONFIRM ) );
			}
		}
		else{
			$config = parse_ini_file ( './mods/tchat/salons/default.ini' , TRUE );
			$template->assign_block_vars ( 'admin' , array ( 
			'PUBLIC_SALON' => PUBLIC_SALON,
			'PRIVATE_SALON' => PRIVATE_SALON,
			'DEFAULT_SALON' => DEFAULT_SALON,
			'WELCOME_MESS' => WELCOME_MESS,
			'WELCOME_VALUE' => stripslashes ( base64_decode ( str_replace ( 'egaletoreplace' , '=' , $config['config']['welcome'] ) ) ),
			'UPDATE' => UPDATE ) );
				$a = false;
				$salon_public = opendir('./mods/tchat/salons/public' );
				while ( ( $salon = readdir ( $salon_public ) ) != false ){
					if ( $salon != '..' && $salon != '.' && is_file ( './mods/tchat/salons/public/'.$salon ) && substr ( $salon , ( strlen ( $salon ) - 4 ) , strlen ( $salon ) ) == '.ini' )
					{
						$a = true ;
						$config = parse_ini_file ( './mods/tchat/salons/public/'.$salon , TRUE );
						$salon = substr ( $salon , 0 , ( strlen ( $salon ) - 4 ) );
						
						$template->assign_block_vars ( 'admin.pub' , array (
						'SALON' => $salon,
						'SALON_NAME' => base64_decode ( $salon ),
						'WELCOME_MESS' => WELCOME_MESS,
						'WELCOME_VALUE' => stripslashes ( base64_decode ( str_replace ( 'egaletoreplace' , '=' , $config['config']['welcome'] ) ) ),
						'UPDATE' => UPDATE,
						'DELETE' => DELETE,
						'BE_PRIVATE' => BE_PRIVATE) );
					}
				}
				closedir ( $salon_public );

				if ( $a === false ) {
					$template->assign_block_vars ( 'admin.none_pub' , array ( 'TXT' => NONE_PUBLIC_SALON ) );
				}
				$a = false;
				$salon_prive = opendir('./mods/tchat/salons/prive' );
				while ( ( $salon = readdir ( $salon_prive ) ) != false ){
					if ( $salon != '..' && $salon != '.' && is_file ( './mods/tchat/salons/prive/'.$salon ) && substr ( $salon , ( strlen ( $salon ) - 4 ) , strlen ( $salon ) ) == '.ini' )
					{
						$a = true ;
						$config = parse_ini_file ( './mods/tchat/salons/prive/'.$salon , TRUE );
						$salon = substr ( $salon , 0 , ( strlen ( $salon ) - 4 ) );

						$template->assign_block_vars ( 'admin.pri' , array (
						'SALON' => $salon,
						'SALON_NAME' => base64_decode ( $salon ),
						'WELCOME_MESS' => WELCOME_MESS,
						'WELCOME_VALUE' => stripslashes ( base64_decode ( str_replace ( 'egaletoreplace' , '=' , $config['config']['welcome'] ) ) ),
						'PASSWORD' => PASSWORD,
						'UPDATE' => UPDATE,
						'DELETE' => DELETE,
						'BE_PUBLIC' => BE_PUBLIC) );
					}
				}
				closedir ( $salon_prive );

				if ( $a === false ) {
					$template->assign_block_vars ( 'admin.none_pri' , array ( 'TXT' => NONE_PRIVATE_SALON ) );
				}
		}
	
	}
	else if ( isset ( $_GET['create'] ) ){
		
		if ( isset ( $_POST['salle'] ) ){
		
			// Nom du salon
			$salon = base64_encode ( htmlspecialchars ( $_POST['salle'] ) );
			
			// Configuration du salon
			$config_salon = 
'[config]
lastdate = ;
welcome = '.str_replace ( '=' , 'egaletoreplace' , base64_encode ( htmlspecialchars ( $_POST['welcome'] ) ) ).';
actual_users = ;';

			switch ( $_POST['type'] ){
			
				case 0 :
				
					$type = 'prive';
					$config_salon .= '
salon_password = '.md5 ( htmlspecialchars ( $_POST['password'] ) ).';';
				
				break;
				
				case 1 :
				
					$type = 'public';
				
				break ;
			
			}
			
			$chemin = './mods/tchat/salons/'.$type.'/'.$salon.'.ini';
			
			// On verifie si le salon existe deja
			if ( is_file ( $chemin ) || $salon == 'default'){
					$template->assign_block_vars ( 'text' , array (
					'TXT' => ALREADY_DEFINED,
					'URL' => 'index.php?mods=tchat&amp;page=admin&amp;create',
					'BACK' => back ) );			
			}
			else{
				// On va creer le salon avec les informations definies
				$new_salon = fopen ( $chemin , 'a+' );
					fputs ( $new_salon , $config_salon );
				fclose ( $new_salon );
				$template->assign_block_vars ( 'text' , array (
				'TXT' => SALON_CREATED,
				'URL' => 'index.php?mods=tchat&amp;page=admin',
				'BACK' => back ) );			
			}
		}
		else{
			$template->assign_block_vars ( 'create_form' , array (
			'PASSWORD' => PASSWORD,
			'SALON_NAME' => SALON_NAME,
			'SALON_TYPE' => SALON_TYPE,
			'CHAT_PUBLIC' => CHAT_PUBLIC,
			'CHAT_PRIVATE' => CHAT_PRIVATE,
			'WELCOME_MESS' => WELCOME_MESS,
			'WELCOME_TO_THIS' => WELCOME_TO_THIS,
			'CREATE_THIS_SALON' => CREATE_THIS_SALON,
			'BACK' => back ) );		
		}
	}
	else if ( isset ( $_GET['config'] ) ){
		$titre_mod .= ' - '.CONFIG_CHAT;
		$chat_config = parse_ini_file ( './mods/tchat/config/config.ini' );
		
		if ( isset ( $_POST['mess_nbr'] ) ){
			$config = fopen ( './mods/tchat/config/config.ini' , 'r' );
			$conf = '';
			while ( !feof ( $config ) ){
				$conf .= fgets ( $config , 4096 );
			}
			fclose ( $config );
			
			$conf = str_replace ( 'nbre_mess = '.$chat_config['nbre_mess'].';' , 'nbre_mess = '.intval ( $_POST['mess_nbr'] ).';' , $conf );
			
			$new_config = fopen (  './mods/tchat/config/config.ini' , 'w' );
				fputs ( $new_config , $conf );
			fclose ( $new_config );
			
			$template->assign_block_vars ( 'text' , array (
			'TXT' => MESS_NBR_UPDATED,
			'URL' => 'index.php?mods=tchat&amp;page=admin&amp;config',
			'BACK' => back ) );
		}
		else{
			$template->assign_block_vars ( 'config_form' , array (
			'MESS_NBR_TO_PRINT' => MESS_NBR_TO_PRINT,
			'MESS_NBR_TO_PRINT_VALUE' => $chat_config['nbre_mess'],
			'VALID' => valid,
			'BACK' => back ) );
		}
	}
	else {
		$template->assign_block_vars ( 'index' , array (
		'NO_JS' => NO_JS,
		'MANAGE_SALONS' => MANAGE_SALONS,
		'ADD_SALONS' => ADD_SALONS,
		'CONFIG_CHAT' => CONFIG_CHAT,
		'BACK' => back ) );
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>