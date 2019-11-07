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

// En raison des risques de sécurité, ce module est réservé aux seuls administrateurs dieux!
$arr = explode(',',$god_user);
if ( $grade == 4 && in_array ( $uid , $arr ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => FREE_PAGE ) );
	$template->set_filename ( './modules/free_page/admin.tpl' );
	
	if ( isset ( $_GET['add_page'] ) ){
	
		if ( isset ( $_POST['name'] ) ){
		
			$name = $Bdd->secure ( $_POST['name'] );
			$name = preg_replace ( '![^a-zA-Z0-9 -_.]!' , '' , $name );
			
			if ( $name == 'bloc' OR $name == 'admin' OR $name == 'index' OR $name == 'install_def' OR file_exists ( './mods/free_page/'.$name.'.php' ) ){
				$template->assign_block_vars ( 'text' , array ( 
				'TXT' => NAME_ALREADY_USED,
				'URL' => '?mods=free_page&amp;page=admin&amp;add_page',
				'BACK' => back ) );
			}
			else{
				$template->assign_block_vars ( 'text' , array ( 
				'TXT' => PAGE_SUCCESSFULLY_ADDED,
				'URL' => '?mods=free_page&amp;page=admin',
				'BACK' => back ) );			
				
				$file = fopen ( './mods/free_page/'.$name.'.php' , 'a+' );
					fputs ( $file , stripslashes ( $_POST['contenu'] ) );
				fclose ( $file );
				
			}
		
		}
		else{
			$template->assign_block_vars ( 'form' , array (
			'PAGENAME' => PAGE_NAME,
			'PAGECODE' => PAGE_CODE,
			'PAGECODE_VALUE' => '
<?php

$titre = \''.PAGE_NAME.'\';

$contenu = \''.PAGE_CONTENT.'\';

$template->assign_block_vars(\'module\' , array(\'TITRE_MODULE\' => $titre, \'CONTENU_MODULE\' => \'<br /><br />\'.$contenu));

?>',
			'VALID' => valid,
			'BACK' => back ) );
		}
	}
	else if ( isset ( $_GET['edit_page'] ) ){

		if ( isset ( $_POST['name'] ) ){
		
			$name = stripslashes ( $_POST['name'] );
			$name = preg_replace ( '![^a-zA-Z0-9 -_.]!' , '' , $name );
			
			if ( $name != base64_decode ( $_GET['edit_page'] ) )
				$modif = TRUE;
			else
				$modif = FALSE;
			
			if ( $name == 'bloc' OR $name == 'admin' OR $name == 'index' OR $name == 'install_def' OR ( $modif === TRUE && file_exists ( './mods/free_page/'.$name.'.php' ) ) ){
				$template->assign_block_vars ( 'text' , array ( 
				'TXT' => NAME_ALREADY_USED,
				'URL' => '?mods=free_page&amp;page=admin&amp;add_page',
				'BACK' => back ) );
			}
			else{
			
				if ( $modif === TRUE )
					unlink ( './mods/free_page/'.base64_decode ( $_GET['edit_page'] ).'.php'  );

				$template->assign_block_vars ( 'text' , array ( 
				'TXT' => PAGE_SUCCESSFULLY_UPDATED,
				'URL' => '?mods=free_page&amp;page=admin',
				'BACK' => back ) );
				
				$file = fopen ( './mods/free_page/'.$name.'.php' , 'w+' );
					fputs ( $file , stripslashes ( $_POST['contenu'] ) );
				fclose ( $file );
				
			}
		
		}
		else{
			$cont = '';
			$file = fopen ( './mods/free_page/'.base64_decode ( $_GET['edit_page'] ).'.php' , 'r' );
			while ( !feof ( $file ) ){
				$cont .= fgets ( $file , 4096 );
			}
			fclose ( $file );
			$template->assign_block_vars ( 'form' , array (
			'PAGENAME' => PAGE_NAME,
			'PAGENAME_VALUE' => base64_decode ( $_GET['edit_page'] ),
			'PAGECODE' => PAGE_CODE,
			'PAGECODE_VALUE' => $cont,
			'VALID' => valid,
			'BACK' => back ) );
		}
	
	}
	else if ( isset ( $_GET['del_page'] ) ){
		unlink ( './mods/free_page/'.base64_decode ( $_GET['del_page'] ).'.php'  );
		$template->assign_block_vars ( 'text' , array ( 
		'TXT' => PAGE_DELETED_SUCCESSFULLY,
		'URL' => '?mods=free_page&amp;page=admin',
		'BACK' => back ) );
	}
	else{

		$template->assign_block_vars ( 'index' , array (
		'PAGEDISPOS' => PAGES_DISPO,
		'PAGENAME' => PAGE_NAME,
		'ADD_PAGE' => ADD_PAGE,
		'HELP' => FREEPAGE_HELP,
		'HELPTXT' => nl2br ( FREEPAGE_HELPS ) ) );

		$a = FALSE;
		$dir = opendir ( './mods/free_page/' );
			while ( $file = readdir ( $dir ) ){
				if ( $file != '.' AND $file != '..' AND is_file ( './mods/free_page/'.$file ) AND $file != 'index.php' AND $file != 'install_def.php' AND $file != 'admin.php' ){
					$file = substr ( $file , 0 , strlen ( $file ) - 4 );
					$template->assign_block_vars ( 'index.pg' , array (
					'FILE' => $file,
					'FILE64' => base64_encode ( $file ),
					'MODIFY' => modify,
					'DEL' => delete ) );
					$a = TRUE;
				}
			}
		closedir ( $dir );
		
		if ( $a === FALSE )
			$template->assign_block_vars ( 'index.none' , array ( 'TXT' => NONE_PAGE ) );
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>