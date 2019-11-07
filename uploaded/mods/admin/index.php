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
if(!defined('CCMS'))die('');
if ( $grade == 4 || ereg ( 'view_admin;' , $permissions ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array (
	'TITRE' => ADMINISTRATION ) );
	
	$template->set_filename ( './modules/admin/index.tpl' );
	$template->assign_block_vars ( 'index' , array ( 
	'ADM_OPTIONS' => ADM_OPTIONS,
	'MODS_ADM' => MODS_ADM ) );

	// On affiche les catégories par défaut de l'ADMINISTRATION ( utilisateurs, GENeral)
	if($grade==4 || ereg("view_admin_gene;",$permissions)){

		$template->assign_block_vars ( 'index.main' , array (
		'ADM_OPTIONS' => ADM_OPTIONS,
		'USERS' => USERS,
		'GEN' => GEN,
		'ADMIN_INTERFACE' => ADMIN_INTERFACE,
		'GRADES' => GRADES,
		'SEE_ADMIN_MOD' => SEE_ADMIN_MOD,
		'GESTION_ALERTE' => GESTION_ALERTE,
		'MODS' => MODS,
		'CACHE' => CACHE,
		'DATE' => DATE,
		'LOGS' => LOGS ) );
	
		// On recupere certains module generaux qui sont situes dans des dossier different
		$handle = opendir("./mods"); 
		$a = 0;
		
		// Liste des module a compter comme dependant du portail
		$pages = array ( 
		'groupes',
		'free_bloc',
		'free_page',
		'page',
		'copyright');
		
		// Liste des modules dont l'acces est limites aux admins dieux pour raisons de secu ;)
		$god_mod = array (
		'free_page',
		'free_bloc' );
		$arr = explode(',',$god_user);
		
		if ( in_array ( $uid , $arr ) )
			$template->assign_block_vars ( 'index.main.sql' , array ( 'SQL' => SQL ) );
		
		while ( ( $file = readdir() ) != FALSE ){
			clearstatcache(); 
			if($file!=".." && $file!="." && in_array ( $file , $pages ) && file_exists('./mods/'.$file.'/admin.php') && substr ( $file , -5 ) != '{N-I}')
			{
				$grade_see_admin = ( (isset(${$file.'_grade_admin'})) ? ${$file.'_grade_admin'} : ('') );
				$grades = explode ( ',' , $grade_see_admin );
				if( ( $grade==4 || (isset ( $grade_see_admin ) && in_array ( $grade_see_admin , $grades )) ) AND ( !in_array ( $file , $god_mod ) OR in_array ( $uid , $arr ) ) ){
					$a ++;

					if ( is_file ( './mods/'.$file.'/install_def.php' ) ){
						include ( './mods/'.$file.'/install_def.php' );
						$nom = ${'mod_name_'.$u_lang};
					}
					else{
						$nom = ucfirst ( $file );
					}

					$template->assign_block_vars ( 'index.main.cat' , array (
					'FILE' => $file,
					'NOM' => $nom ) );
					if ( $a == 6 ){
						$template->assign_block_vars ( 'index.main.cat.sep' , array () );
						$a = 1;
					}
				}
			}
		}
		closedir($handle);
	}

	// On recherche dans les autres modules si ils possedent une page d'ADMINISTRATION

	$handle = opendir("./mods"); 
	$a = 0;
	while (($file = readdir())!=false) { 
		
		clearstatcache(); 
		if($file!=".." && $file!="." && !in_array ( $file , $pages ) && file_exists('./mods/'.$file.'/admin.php') && substr ( $file , -5 ) != '{N-I}')
		{
		
			$grade_see_admin = ( (isset(${$file.'_grade_admin'})) ? ${$file.'_grade_admin'} : ('') );
			$grades = explode ( ',' , $grade_see_admin );
			if($grade==4 || (isset ( $grade_see_admin ) && in_array ( $grade_see_admin , $grades ))){
				$a ++;

				if ( is_file ( './mods/'.$file.'/install_def.php' ) ){
					include ( './mods/'.$file.'/install_def.php' );
					$nom = ${'mod_name_'.$u_lang};
				}
				else{
					$nom = ucfirst ( $file );
				}
				
				if ( is_file ( './themes/'.$u_theme.'/img/'.$file.'/admin.png' ) )
					$url = './themes/'.$u_theme.'/img/'.$file.'/admin.png';
				else if ( is_file ( './mods/'.$file.'/images/admin.png' ) )
					$url = './mods/'.$file.'/images/admin.png';
				else
					$url = '';
					
				if ( $url != '' ){
					$imz = getimagesize ( $url );
					$new_size = resize ( 60 , 60 , $imz[0] , $imz[1] );			
				}
				else{
					$new_size = array ( '60' , '60' );
				}

				$template->assign_block_vars ( 'index.cat' , array (
				'FILE' => $file,
				'NOM' => $nom,
				'IMG_URL' => $url,
				'WIDTH' => $new_size[0],
				'HEIGHT' => $new_size[1] ) );
				if ( $a == 6 ){
					$template->assign_block_vars ( 'index.cat.sep' , array () );
					$a = 1;
				}
			}
		}
	}
	closedir($handle);
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>
