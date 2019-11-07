<?php
/*
Copyright CrazyCMS : 

Valmori Quentin
Feuvre Christophe
	neowan@live.fr
Haustrate Kevin
	gippel5@hotmail.com

This software is a computer program whose purpose is to make our own 
	quentin.valmori@gmail.com
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
if ($grade != 4) { 
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
} 
else 
{
	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/admin/modules.tpl' );
	
	if ( isset ( $_GET [ 'install' ] ) ){
	
		$logs->add_event ( HAS_ADDED_MODULE , MODS );
	
		// On renomme le dossier pour qu'il ne soit plus considere comme non-installé
		$dossier = htmlspecialchars ( base64_decode ( $_GET [ 'install' ] ) );

		if ( substr ( $dossier , -5 ) == '{N-I}' ){
		
			@rename ( './mods/'.$dossier.'/' , './mods/'.substr ( $dossier , 0 , ( strlen ( $dossier ) - 5 ) ).'/' );
			$cont = '';
			$rep = '.';
			include ( './mods/'.substr ( $dossier , 0 , ( strlen ( $dossier ) - 5 ) ).'/langues/'.$u_lang.'.php' );
			include ( './mods/'.substr ( $dossier , 0 , ( strlen ( $dossier ) - 5 ) ).'/install.php' );
			
			$template->assign_block_vars ( 'text' , array (
			'TXT' => $cont,
			'BACK' => back ) );
			
			$Bdd->delete_cached_data ( 'config' );
			
			
		}
		else{
			$template->assign_block_vars ( 'text' , array (
			'TXT' => MODULE_NOT_INSTALLABLE,
			'BACK' => back ) );
		}
	
	}
	else if ( isset ( $_GET [ 'uninstall' ] ) ){
	
		if ( isset ( $_GET [ 'confirm' ] ) ){
		
		$logs->add_event ( HAS_DELETED_MODULE , MODS );
		
		// On renomme le dossier pour qu'il ne soit plus considere comme non-installé
		$dossier = htmlspecialchars ( base64_decode ( $_GET [ 'uninstall' ] ) );
		
			@rename ( './mods/'.$dossier.'/' , './mods/'.$dossier.'{N-I}/' );
			$cont = '';
			$rep = '.';
			include ( './mods/'.$dossier.'{N-I}/uninstall.php' );
			$template->assign_block_vars ( 'text' , array (
			'TXT' => MOD_UNINSTALLED,
			'BACK' => back ) );
			
			$Bdd->delete_cached_data ( 'config' );
			
		}
		else{
			$template->assign_block_vars ( 'confirm' , array (
			'SURE_TO_DEL' => SURE_TO_DEL,
			'MOD' => htmlspecialchars ( base64_decode ( $_GET [ 'uninstall' ] ) ),
			'THIS_WILL_DESTROY_DATA' => THIS_WILL_DESTROY_DATA,
			'NO' => NO,
			'OR' => ORR,
			'UNINSTALL' => htmlentities ( $_GET['uninstall'] ),
			'YES' => YES ) );
		}
	}
	else{

		// On recupere les modules non installés et pret a etre installés et ceux deja installés, pret a etre desinstallé ;)
		
		$to_install = array ( );
		$to_uninstall = array ( );
		
		$dossier = opendir ( './mods/' );
		while ( $file = readdir ( $dossier ) ){
			if ( $file != '.' AND $file != '..' AND is_dir ( './mods/'.$file ) ){
			
				if ( substr ( $file , -5 ) == '{N-I}' AND file_exists ( './mods/'.$file.'/install.php' ) ){
					$to_install[] = substr ( $file , 0 , ( strlen ( $file ) - 5 ) );
				}
				else if ( file_exists ( './mods/'.$file.'/uninstall.php' ) ) {
					$to_uninstall[] = $file;
				}
			}	
		}

		$template->assign_block_vars ( 'index' , array (
		'INSTALL_MOD' => INSTALL_MOD,
		'UNINSTALL_MOD' => UNINSTALL_MOD,
		'BACK' => back ) );
		
		if ( count ( $to_install ) == 0 ){
			$template->assign_block_vars ( 'index.none_install' , array ( 'TXT' => NONE_MOD_TO_INSTALL ) );
		}
		else{
			foreach ( $to_install as $mod ){
				$template->assign_block_vars ( 'index.install' , array ( 
				'URL' => 'index.php?mods=admin&amp;page=modules&amp;install='.base64_encode ( $mod.'{N-I}' ),
				'MOD' => ucfirst ( $mod ) ) );
			}
		}
		
		if ( count ( $to_uninstall ) == 0 ){
			$template->assign_block_vars ( 'index.none_uninstall' , array ( 'TXT' => NONE_MOD_TO_UNINSTALL ) );
		}
		else{
			foreach ( $to_uninstall as $mod ){
				$template->assign_block_vars ( 'index.uninstall' , array ( 
				'URL' => 'index.php?mods=admin&amp;page=modules&amp;uninstall='.base64_encode ( $mod ),
				'MOD' => ucfirst ( $mod ) ) );
			}
		}	
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
?>