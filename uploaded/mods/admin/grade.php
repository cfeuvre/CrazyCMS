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

if($grade == 4 || ereg("admin_grades;",$permissions)){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/admin/grade.tpl' );

	// Si on a choisi de supprimer un grade et que l'on a validé l'action, on supprime le grade ;)
	if ( isset ( $_GET [ 'delete' ]) && isset ( $_GET [ 'valid' ] ) && $_GET [ 'delete' ] != 5  && $_GET [ 'delete' ] != 4 && $_GET [ 'delete' ] != 3 && $_GET [ 'delete' ] != 2 && $_GET [ 'delete' ] != 1 ){

		$logs->add_event ( HAS_DELETED_GRADE , GRADES );
	
		// On supprime le grade
		$Bdd->sql ( 'DELETE FROM '.PT.'_grades WHERE id="'.intval ( $_GET [ 'delete' ] ).'"' );
		
		$Bdd->delete_cached_data('config');
		
		// On met a jour tous les utilisateurs qui appartenaient a ce grade en leur mettant le grade de membre simple
		$qq = $Bdd->sql ( 'SELECT nbr FROM '.PT.'_grades WHERE id="'.intval ( $_GET [ 'delete' ] ).'"' );
		$sq = $Bdd->get_array ( $qq );
		
		$Bdd->sql ( 'UPDATE '.PT.'_users SET grades="1" WHERE grades="'.$sq [ 'nbr' ].'"' );
	
		$template->assign_block_vars ( 'text' , array (
		'TXT' => GRADE_SUCCESSFULLY_DELETED,
		'URL' => 'index.php?mods=admin&amp;page=grade',
		'BACK' => back ) );
	
	}
	// Si l'on a choisi de supprimer le grade, on demande confirmation
	else if ( isset ( $_GET [ 'delete' ] ) && $_GET [ 'delete' ] != 5  && $_GET [ 'delete' ] != 4 && $_GET [ 'delete' ] != 3 && $_GET [ 'delete' ] != 2 && $_GET [ 'delete' ] != 1 ){
	
		$template->assign_block_vars ( 'confirm' , array (
		'TXT' => nl2br ( REALLY_SURE_TO_DELETE_GRADE ),
		'BACK' => back,
		'ID' => intval ( $_GET [ 'delete' ] ),
		'DELETE' => DELETE ) );
	
	}
	// Si l'on a choisi d'editer unun grade et ke formulaire valide
	else if ( isset ( $_GET [ 'edit' ] ) && isset ( $_POST [ 'name' ] ) && $_GET [ 'edit' ] != 5 ){
	
		$logs->add_event ( HAS_UPDATED_GRADE , GRADES );
	
		$perms = '';
		// On recupere toutes les permissions
		$query = $Bdd->sql('SELECT name FROM '.PT.'_permissions' );
		$Bdd->delete_cached_data('config');
		// On fait une boucle pour lire toutes les permissions existantes
		while($sql = $Bdd->get_array ( $query ) ){
			if ( isset ( $_POST [ $sql [ 'name' ] ] ) && $_POST [ $sql [ 'name' ] ] == 1 ){
				// On ajoute aux permissions les permissions choisies
				$perms .= $sql['name'].';';
			}
		}
		
		$nom = $Bdd->secure ( $_POST [ 'name' ] );
		$Bdd->sql ( 'UPDATE '.PT.'_grades SET name = "'.$nom.'", permissions="'.$perms.'" WHERE id = "'.intval ( $_GET [ 'edit' ] ).'" ' );
		
		$template->assign_block_vars ( 'text' , array (
		'TXT' => GRADES_UPDATED_SUCCESSFULLY,
		'URL' => 'index.php?mods=admin&amp;page=grade',
		'BACK' => back ) );

		$Bdd->delete_cached_data('config' );	
	}
	// Si l'on a choisis d'editer, on afficher le formulaire d'edition
	else if ( isset ( $_GET [ 'edit' ] ) && $_GET [ 'edit' ] != 5 ){
	
		$query = $Bdd->sql ( 'SELECT name, permissions FROM '.PT.'_grades WHERE id="'.intval ( $_GET['edit'] ).'"' );
		$sql = $Bdd->get_array ( $query );
		
		$template->assign_block_vars ( 'form' , array (
		'GRADE_NAME' => GRADE_NAME,
		'NAME_VALUE' => htmlspecialchars ( $sql [ 'name' ] ),
		'PERMS' => PERMS,
		'VALID' => valid ) );
		
		$query2 = $Bdd->sql ( 'SELECT name, description, element FROM '.PT.'_permissions ORDER BY element' );
		// On fait une boucle pour lire toutes les permissions existantes
		while ( $sql2 = $Bdd->get_array ( $query2 ) ){
		
			if ( !isset ( $element ) ){
				$element = $sql2 [ 'element' ];
			}
			else if ( $element != $sql2 [ 'element' ] ){
				$template->assign_block_vars ( 'form.perm.sep' , array() );
				$element = $sql2 [ 'element' ];
			}
			
			//On regarde les permissions que l'utilisateur possede afin de montrer qu'il les possede deja
			$array = explode ( ';' , $sql [ 'permissions' ] ); 

			$used = false ;

			foreach ( $array as $value ){ 
				if ( $value == $sql2 [ 'name' ] ){
					$used = true;
				}
			} 

			if($used === true){
				$checked = 'checked="checked"';
			}
			else{
				$checked = '';
			}

			$template->assign_block_vars ( 'form.perm' , array (
			'DESC' => $sql2['description'],
			'NAME' => $sql2['name'],
			'CHECKED' => $checked ) );
		}
	}
	// Si l'on a ajouté un grade et validé, on l'ajoute ^^
	else if ( isset ( $_GET [ 'add' ] ) && isset ( $_POST [ 'name' ] ) ){

		$logs->add_event ( HAS_ADDED_GRADE , GRADES );
	
		$perms = '';
		$Bdd->delete_cached_data('config');
		// On recupere toutes les permissions
		$query = $Bdd->sql('SELECT name FROM '.PT.'_permissions' );
		// On fait une boucle pour lire toutes les permissions existantes
		while($sql = $Bdd->get_array ( $query ) ){
			if ( isset ( $_POST [ $sql [ 'name' ] ] ) && $_POST [ $sql [ 'name' ] ] == 1 ){
				// On ajoute aux permissions les permissions choisies
				$perms .= $sql['name'].';';
			}
		}
		
		$nom = $Bdd->secure ( $_POST [ 'name' ] );
		
		$qq = $Bdd->sql ( 'SELECT nbr FROM '.PT.'_grades ORDER BY nbr DESC LIMIT 0,1' );
		$sq = $Bdd->get_array ( $qq );
		
		$Bdd->sql ( 'INSERT INTO '.PT.'_grades VALUES ( "", "'.( $sq [ 'nbr' ] + 1 ).'", "'.$nom.'", "'.$perms.'" )' );

		$template->assign_block_vars ( 'text' , array (
		'TXT' => GRADES_CREATED_SUCCESSFULLY,
		'URL' => 'index.php?mods=admin&amp;page=grade',
		'BACK' => back ) );

		$Bdd->delete_cached_data('config' );
	}
	// Si l'on choisit d'ajouter un grade, on affiche le formulaire
	else if ( isset ( $_GET [ 'add' ] ) ){

		$template->assign_block_vars ( 'form' , array (
		'GRADE_NAME' => GRADE_NAME,
		'NAME_VALUE' => '',
		'PERMS' => PERMS,
		'VALID' => valid ) );
		
		$query = $Bdd->sql ( 'SELECT name, description, element FROM '.PT.'_permissions ORDER BY element' );
		// On fait une boucle pour lire toutes les permissions existantes
		while ( $sql = $Bdd->get_array ( $query ) ){
		
			if ( !isset ( $element ) ){
				$element = $sql [ 'element' ];
			}
			else if ( $element != $sql [ 'element' ] ){
				$template->assign_block_vars ( 'form.perm.sep' , array() );
				$element = $sql [ 'element' ];
			}
		
			$template->assign_block_vars ( 'form.perm' , array (
			'DESC' => $sql['description'],
			'NAME' => $sql['name'],
			'CHECKED' => '' ) );
		}
	}
	// Si on a rien demandé, on affiche l'index ;)
	else{
		$template->assign_block_vars ( 'index' , array (
		'ADD_GRADE' => ADD_GRADE,
		'GRADE' => GRADE,
		'GRADE_NAME' => GRADE_NAME,
		'EDIT' => EDIT,
		'DELETE' => DELETE,
		'BACK' => back ) );
			
		// On récupère tous les grades
		$query = $Bdd->sql ( 'SELECT id, nbr, name FROM '.PT.'_grades ORDER BY nbr' );
		
		while ( $sql = $Bdd->get_array ( $query ) ){

			$template->assign_block_vars ( 'index.grade' , array (
			'NBR' => $sql['nbr'],
			'NAME' => htmlspecialchars ( $sql [ 'name' ] ) ) );
			
			if ( $sql [ 'nbr' ] != '4' ){
				$template->assign_block_vars ( 'index.grade.edit' , array (
				'ID' => $sql['id'],
				'EDIT' => EDIT ) );
			}
			else{
				$template->assign_block_vars ( 'index.grade.no_ed' , array () );
			}
			if ( $sql [ 'nbr' ] != '4' && $sql [ 'nbr' ] != '3' && $sql [ 'nbr' ] != '2' && $sql [ 'nbr' ] != '1' && $sql [ 'nbr' ] != '0' ){
				$template->assign_block_vars ( 'index.grade.del' , array (
				'ID' => $sql['id'],
				'DELETE' => DELETE ) );
			}
			else{
				$template->assign_block_vars ( 'index.grade.no_del' , array () );
			}
		}
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>