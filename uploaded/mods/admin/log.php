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
if ( $grade == 4 || ereg ( 'view_admin;' , $permissions ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array (
	'TITRE' => LOG_ADM ) );
	
	$template->set_filename ( './modules/admin/log.tpl' );
	
	if ( isset ( $_GET['truncate'] ) ){
	
		if ( isset ( $_GET['log'] ) ){
			
			if ( @unlink ( './cache/logs/log_'.htmlspecialchars ( $_GET['log'] ).'.ini' ) ){
				$template->assign_block_vars ( 'logs_txt' , array ( 'TXT' => LOG_TRUNCATED_SUCCESSFULLY , 'BACK' => back ) );
			}	
			else{
				$template->assign_block_vars ( 'logs_txt' , array ( 'TXT' => LOG_CANT_BE_TRUNCATED , 'BACK' => back ) );
			}
			
			$logs->add_event ( HAS_TRUNCATED_LOG , LOG );
			
		}
		else{
			$template->assign_block_vars ( 'truncate_index' , array (
			'TO_DEL' => LOGS_TO_DEL,
			'BACK' => back ) );
		
			$arr = explode(', ',$god_user);
			if ( !in_array ( $pseudo , $arr ) )
				$god = TRUE;
			else
				$god = FALSE;
				
			// On récupère les logs visible par le mec
			$dir = opendir ( './cache/logs/' );
			while ( $file = readdir ( $dir ) ){
				if ( $file != '.' AND $file != '..' ){
					$gd = str_replace ( 'log_' , '' , str_replace ( '.ini' , '' , $file ) );
					if ( ( intval ( $gd ) != '' AND $gd < $grade ) OR $god === TRUE ){
							
						$query = $Bdd->sql ( 'SELECT name FROM '.PT.'_grades WHERE nbr="'.$gd.'"' );
						$sql = $Bdd->get_array ( $query );
						$nom = $sql['name'];
		
						if ( $gd == 'god' )
							$nom = GODS_ADMINS;
		
						$template->assign_block_vars ( 'truncate_index.jn' , array (
						'ID' => $gd,
						'NOM' => $nom ) );
					}
				}
			}	
		}
	}
	else if ( isset ( $_GET['see'] ) ){
		
		if ( isset ( $_GET['log'] ) ){
		
			$nom = '';
		
			$query = $Bdd->sql ( 'SELECT name FROM '.PT.'_grades WHERE nbr="'.$Bdd->secure ( $_GET['log'] ).'"' );
			$sql = $Bdd->get_array ( $query );
			$nom = $sql['name'];
		
			if ( $_GET['log'] == 'god' )
				$nom = GODS_ADMINS;
		
			$template->assign_block_vars ( 'see_log' , array (
			'PRINTING_LOGS_FROM' => PRINTING_LOGS_FROM,
			'GR' => $nom,
			'MODULE' => LOG_MODULE,
			'USER' => LOGS_USER,
			'ACTION' => LOG_ACTION,
			'DATE' => LOG_DATE,
			'DEL' => LOG_DEL,
			'BACK' => back ) );
			
			if ( file_exists ( './cache/logs/log_'.htmlspecialchars ( $_GET['log'] ).'.ini' ) ){
				$logs = parse_ini_file ( './cache/logs/log_'.htmlspecialchars ( $_GET['log'] ).'.ini' , TRUE );
			}
			else{
				$template->assign_block_vars ( 'see_log.empty' , array ( 'TXT' => NONE_LOG_HERE ) );
			}
			
			$a = 0;
			
			$users = array();
			
			foreach ( $logs AS $id => $log ){
				if ( $log != '' ){
				
					if ( !isset ( $users[$log['uid']] ) ){
						$query = $Bdd->sql('SELECT pseudo FROM '.PT.'_users WHERE id="'.$log['uid'].'"' );
						$sql = $Bdd->get_array ( $query );
						$lgpseudo = $sql['pseudo'];
						$users[$log['uid']] = $lgpseudo;
					}
					else{
						$lgpseudo = $users[$log['uid']];
					}
				
					$a++;
					$template->assign_block_vars ( 'see_log.lg' , array (
					'MODULE' => base64_decode ( str_replace ( 'egaltorepinlog%µ' , '=' , $log['module'] ) ),
					'USER' => $lgpseudo,
					'ACTION' => base64_decode ( str_replace ( 'egaltorepinlog%µ' , '=' , $log['event'] ) ),
					'DATE' => ccmsdate ( $fuseaux , $log['time'] ),
					'ID' => $id,
					'GRADE' => htmlspecialchars ( $_GET['log'] ),
					'DEL' => LOG_DEL ) );
				
				}
			}
			
			if ( $a == 0 )
				$template->assign_block_vars ( 'see_log.empty' , array ( 'TXT' => NONE_LOG_HERE ) );
		
		}
		else{
			
			$template->assign_block_vars ( 'see_index' , array (
			'PRESENT' => LOGS_PRESENT,
			'BACK' => back ) );
		
			$arr = explode(', ',$god_user);
			if ( !in_array ( $pseudo , $arr ) )
				$god = TRUE;
			else
				$god = FALSE;
				
			// On récupère les logs visible par le mec
			$dir = opendir ( './cache/logs/' );
			while ( $file = readdir ( $dir ) ){
				if ( $file != '.' AND $file != '..' ){
					$gd = str_replace ( 'log_' , '' , str_replace ( '.ini' , '' , $file ) );
					if ( ( intval ( $gd ) != '' AND $gd < $grade ) OR $god === TRUE ){
							
						$query = $Bdd->sql ( 'SELECT name FROM '.PT.'_grades WHERE nbr="'.$gd.'"' );
						$sql = $Bdd->get_array ( $query );
						$nom = $sql['name'];
		
						if ( $gd == 'god' )
							$nom = GODS_ADMINS;
		
						$template->assign_block_vars ( 'see_index.jn' , array (
						'ID' => $gd,
						'NOM' => $nom ) );
					}
				}
			}
		}
	}
	else if ( isset ( $_GET['del'] ) ){
		$logs->del_event ( htmlspecialchars ( $_GET['gd'] ) , intval ( $_GET['del'] ) );
		$template->assign_block_vars ( 'logs_txt' , array ( 'TXT' => LOG_DELETED_SUCCESSFULLY , 'BACK' => back ) );
		$logs->add_event ( HAS_DEL_A_LOG , LOG );
	}
	else{
	
		$template->assign_block_vars ( 'index' , array (
		'SEE_LOGS' => SEE_LOGS,
		'TRUNCATE_LOGS' => TRUNCATE_LOGS,
		'BACK' => back ) );
	
	}
	
	$template->set_filename ( 'bas_mods.tpl' );

}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>