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

$grades = explode ( ',' , $livre_dor_grade_admin );
if($grade==4 || in_array ( $grade , $grades , TRUE ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => LVOR_ADMIN ) );

	$template->set_filename ( './modules/livre_dor/admin.tpl' );

	if ( isset ( $_GET['activation'] ) ){
		$Bdd->sql ( 'UPDATE '.PT.'_parametres SET valeur="'.intval ( $_GET['activation'] ).'" WHERE nom="livre_or_validation"' );
		$Bdd->delete_cached_data ( 'config' );
		$livre_or_validation = intval ( $_GET['activation'] );
		if ( $livre_or_validation == 0 ){
			$Bdd->sql('UPDATE '.PT.'_livredor SET propose="0"' );
		}
	}
				
	// On Valide le commentaire + Redirection
	if(isset($_GET['action'])&& $_GET['action']== "valider" && $_GET['id']){
		$Bdd->sql('UPDATE '.PT.'_livredor SET propose="0" WHERE id="'.intval($_GET['id']).'"' );
		
		$template->assign_block_vars ( 'text' , array (
		'TXT' => comments_validate,
		'URL' => 'index.php?mods=livre_dor&amp;page=admin',
		'BACK' => back ) );
	}
	else if(isset($_GET['action'])&& $_GET['action']== "supprimer" && $_GET['id']){
		// On supprime le commentaire + redirection
		$Bdd->sql('DELETE FROM '.PT.'_livredor WHERE id="'.intval($_GET['id']).'"' );

		$template->assign_block_vars ( 'text' , array (
		'TXT' => comments_deleted,
		'URL' => 'index.php?mods=livre_dor&amp;page=admin',
		'BACK' => back ) );		
	}
	else if(isset($_GET['action'])&& $_GET['action']== "supp"){
		// On supprime les commentaires + redirection
		$Bdd->sql('DELETE  FROM '.PT.'_livredor' );

		$template->assign_block_vars ( 'text' , array (
		'TXT' => all_comments_deleted,
		'URL' => 'index.php?mods=livre_dor&amp;page=admin',
		'BACK' => back ) );		
	}
	else{
	
		$template->assign_block_vars ( 'index' , array (
		'MESS_TO_VALID' => MESS_TO_VALID,
		'MESSAGES' => messages ) );
	
		// Partie concernant la validation
		$sql=$Bdd->sql('SELECT * FROM  '.PT.'_livredor WHERE  '.PT.'_livredor.propose="1" ' );
		if($Bdd->get_num_rows($sql)==0){
			$template->assign_block_vars ( 'index.nonev' , array ( 'TXT' => NONE_COMMENTS_WAITING ) );
		}
		else{
			$livre=$Bdd->sql('SELECT  '.PT.'_livredor.id AS idliv,'.PT.'_livredor.auteur AS auteur,'.PT.'_livredor.com AS com,'.PT.'_livredor.date AS date,'.PT.'_livredor.propose AS propose,'.PT.'_livredor.note AS note, '.PT.'_users.id AS id, '.PT.'_users.pseudo AS pseudo FROM '.PT.'_livredor, '.PT.'_users WHERE '.PT.'_livredor.propose="1" AND '.PT.'_livredor.auteur='.PT.'_users.id ORDER BY idliv DESC' );
			while ($mess=$Bdd->get_array($livre)){
				
				$coupe = preg_replace('!<([^<]+)>!isU' , '', to_html ( htmlspecialchars ( $mess['com'] ) ) );
				$coupe = substr ( $coupe , 0 , 25 );
				$template->assign_block_vars ( 'index.valid' , array ( 
				'MESS' => mess,
				'COUPE' => $coupe,
				'AUTHOR' => AUTOR,
				'PSEUDO' => htmlspecialchars ( $mess['pseudo'] ),
				'NOTE' => note,
				'ON_TEN' => ON_TEN,
				'NT' => $mess['note'],
				'ID' => $mess['idliv'],
				'ACTION' => action,
				'SEE_COMPLETE_COMMENT' => SEE_COMPLETE_COMMENT,
				'VALID' => valid,
				'DEL' => delete ) );
			}
		}
		
		if ( $livre_or_validation == 1 )
			$template->assign_block_vars ( 'index.disable' , array ( 'TXT' => DISABLE_MODERATION ) );
		else
			$template->assign_block_vars ( 'index.enable' , array ( 'TXT' => ENABLE_MODERATION ) );

		// Messages validés
		$livre1=$Bdd->sql('SELECT  '.PT.'_livredor.id AS idliv,'.PT.'_livredor.auteur AS auteur,'.PT.'_livredor.com AS com,'.PT.'_livredor.date AS date,'.PT.'_livredor.propose AS propose,'.PT.'_livredor.note AS note, '.PT.'_users.id AS id, '.PT.'_users.pseudo AS pseudo FROM '.PT.'_livredor, '.PT.'_users WHERE '.PT.'_livredor.propose="0" AND '.PT.'_livredor.auteur='.PT.'_users.id ORDER BY idliv DESC' );
		if ( $Bdd->get_num_rows ( $livre1 ) == 0 ){
			$template->assign_block_vars ( 'index.none' , array ( 'NO_COMMENTS' => no_comments ) );
		}
		else{
			$template->assign_block_vars ( 'index.messages' , array ( 'DELETE_ALL_LVOR' => delete_all_lvor ) );
			while ( $mess1 = $Bdd->get_array ( $livre1 ) ){
				
				$coupe1 = preg_replace('!<([^<]+)>!isU' , '', to_html ( $mess1['com'] ) );
				$coupe1 = substr ( $coupe1 , 0 , 30 );
				
				$template->assign_block_vars ( 'index.messages.mess' , array (
				'MESS' => mess,
				'COUPE' => $coupe1,
				'AUTHOR' => AUTOR,
				'PSEUDO' => htmlspecialchars ( $mess1['pseudo'] ),
				'NOTE' => note,
				'NT' => $mess1['note'],
				'ON_TEN' => ON_TEN,
				'ACTION' => action,
				'ID' => $mess1['idliv'],
				'SEE_COMPLETE_COMMENT' => SEE_COMPLETE_COMMENT,
				'DEL' => delete ) );
			}
		}	
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>