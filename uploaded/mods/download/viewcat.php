<?php
// On charge les infos de cette catégorie pour vérifer que l'utilisateur y a accès et qu'il n'y s pas de mot de passe à donner pour accèder à la catégorie
$query = $Bdd->sql ( '
	SELECT
		cat.nom AS nom,
		cat.parent AS parent,
		cat.description AS description,
		cat.groupes AS groupes,
		cat.grades AS grades,
		cat.password AS password
	FROM
		'.PT.'_download_cat AS cat
	WHERE
		cat.id = "'.intval ( $_GET['id'] ).'"' );

$sql = $Bdd->get_array ( $query );
$parent_cat = $sql['parent'];
$Bdd->free_result ( $query );

// Droit d'admins
$grades_right = explode ( ',' , $download_grade_admin );

// Si cette catégorie est enfant et qu'elle necessite un mot de passe, on verifie que le mot de passe nest pas directement heirté du parent
if ( $sql['parent'] != 0 AND $sql['password'] != NULL ){
	$qp = $Bdd->sql ( 'SELECT password FROM '.PT.'_download_cat WHERE id="'.$sql['parent'].'"' );
	$sq = $Bdd->get_num_rows ( $qp );
	if ( $Bdd->get_num_rows ( $qp ) != 0 ){
		if ( $sq['password'] == $sql['password'] ){
			setcookie ( 'download_pass_'.intval ( $_GET['id'] ) , $sql['password'] , ( time() + 3600 ) );
			$_COOKIE['download_pass_'.intval ( $_GET['id'] )] = $sql['password'];
		}
	}
	$Bdd->free_result ( $qp );
}
		
// On vérifie que l'utilisateur à le droit de voir la cat&gorie

$secu = FALSE;
//Grade requis ?
if ( ereg ( '^0;' , $sql['grades'] ) || ereg ( ';0;' , $sql['grades'] ) ){
	$secu = TRUE;
}
else{
	$gds = explode ( ';' , $sql['grades'] );
	if ( in_array ( $grade , $gds ) ){
		$secu = TRUE;
	}
}

$secu2 = FALSE;
// Groupe requis ?
if ( ereg ( '^0;' , $sql['groupes'] ) || ereg ( ';0;' , $sql['groupes'] ) ){
	$secu2 = TRUE;
}
else{
	$gps = explode ( ';' , $sql['groupes'] );
	$gpgp = explode ( ';' , $groupe );
	foreach ( $gpgp AS $gp_act )
		if ( in_array ( $gp_act , $gps ) )
			$secu2 = TRUE;
}

$secu3 = FALSE;
if ( $sql['password'] == NULL )
	$secu3 = TRUE;
else if ( isset ( $_COOKIE['download_pass_'.intval ( $_GET['id'] ) ] ) AND $_COOKIE['download_pass_'.intval ( $_GET['id'] ) ] == $sql['password'] )
	$secu3 = TRUE;
	
if ( ( $grade == 4 OR ( ereg ( 'view_download_index' , $permissions ) AND $secu AND $secu2 AND $secu3 ) ) AND $Bdd->get_num_rows ($query) > 0 ){
	
	// On ouvre le bloc central
	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => DOWNLOAD ) );

	// On charge le template de la page
	$template->set_filename ( './modules/download/viewcat.tpl' );
	
	// On charge les catégories
	$query = $Bdd->sql ( '
	SELECT
		cat.id AS id,
		cat.nb_files AS files,
		cat.nb_hits AS hits,
		cat.nb_downloads AS downloads,
		cat.nom AS nom,
		cat.description AS description,
		cat.groupes AS groupes,
		cat.grades AS grades,
		cat.password AS password
	FROM
		'.PT.'_download_cat AS cat
	WHERE
		cat.parent = "'.intval ( $_GET['id'] ).'"' );
	if ( $Bdd->get_num_rows ( $query ) > 0 ){

		$template->assign_block_vars ( 'download_viewcat_cats' , array (
		'CATS' => DOWNLOAD_SUB_CATS,
		'NOM_CAT' => DOWNLOAD_CAT,
		'FILES' => DOWNLOAD_FILES,
		'HITS' => DOWNLOAD_HITS,
		'DOWNLOADS' => DOWNLOAD_DOWNLOADS ) );
			
		while ( $sql = $Bdd->get_array ( $query ) ){
			
			// On vérifie que l'utilisateur à le droit de voir la cat&gorie
				
				$secu = FALSE;
				//Grade requis ?
				if ( ereg ( '^0;' , $sql['grades'] ) || ereg ( ';0;' , $sql['grades'] ) ){
					$secu = TRUE;
				}
				else{
					$gds = explode ( ';' , $sql['grades'] );
					if ( in_array ( $grade , $gds ) ){
						$secu = TRUE;
					}
				}
				
				$secu2 = FALSE;
				// Groupe requis ?
				if ( ereg ( '^0;' , $sql['groupes'] ) || ereg ( ';0;' , $sql['groupes'] ) ){
					$secu2 = TRUE;
				}
				else{
					$gps = explode ( ';' , $sql['groupes'] );
					$gpgp = explode ( ';' , $groupe );
					foreach ( $gpgp AS $gp_act )
						if ( in_array ( $gp_act , $gps ) )
							$secu2 = TRUE;
				}
			
			
			if ( ( $secu AND $secu2 ) OR $grade == 4 OR in_array ( $grade , $grades_right , TRUE ) ){
				$template->assign_block_vars ( 'download_viewcat_cats.cat' , array (
				'ID' => $sql['id'],
				'NOM' => to_html ( $sql['nom'] ),
				'DEF' => to_html ( $sql['description'] ),
				'FILES' => $sql['files'],
				'HITS' => $sql['hits'],
				'DOWNLOADS' => $sql['downloads']
				) );
				
				if ( $sql['password'] != NULL ){
					$template->assign_block_vars ( 'download_viewcat_cats.cat.pass' , array () );
				}
			}
		
		}
	
	}
	$Bdd->free_result ( $query );
	
	if ( $parent_cat == 0 )
		$back_url = 'index.php?mods=download';
	else
		$back_url = 'index.php?mods=download&amp;page=viewcat&amp;id='.$parent_cat;
	
	// On affiche les fichiers disponibles dans cette catégorie
	$template->assign_block_vars ( 'download_viewcat' , array (
	'FILES' => DOWNLOAD_CAT_FILES,
	'FILENAME' => DOWNLOAD_FILENAME,
	'HITS' => DOWNLOAD_HITS,
	'DOWNLOADS' => DOWNLOAD_DOWNLOADS,
	'BACK_URL' => $back_url,
	'BACK' => back ) );

	// On regarde si l'utilisateur a droit d'administration
	if($grade==4 OR in_array ( $grade , $grades_right , TRUE ) ){
		$template->assign_block_vars ( 'download_viewcat.add' , array (
		'ID' => intval ( $_GET['id'] ),
		'ADD' => DOWNLOAD_ADD_SUBCAT,
		'ADD_FILE' => DOWNLOAD_ADD_FILES,
		'EDIT' => edit,
		'DELETE' => delete ) );
	}
	
	$query = $Bdd->sql ( '
	SELECT
		file.id AS id,
		file.nom AS nom,
		file.password AS password,
		file.groupes AS groupes,
		file.grades AS grades,
		file.hits AS hits,
		file.minimum_date AS min,
		file.maximum_date AS max,
		file.downloads AS downloads
	FROM
		'.PT.'_download_files AS file
	WHERE
		file.parent = '.intval ( $_GET['id'] ) );
	
	if ( $Bdd->get_num_rows ( $query ) == 0 ){
	
		$template->assign_block_vars ( 'download_viewcat.none' , array ( 'TXT' => DOWNLOAD_NONE_FILES ) );
	
	}
	else{
	
		while ( $sql = $Bdd->get_array ( $query ) ){

			// On vérifie que l'utilisateur a le droit de voir le fichier
			$secu = FALSE;
			//Grade requis ?
			if ( ereg ( '^0;' , $sql['grades'] ) || ereg ( ';0;' , $sql['grades'] ) ){
				$secu = TRUE;
			}
			else{
				$gds = explode ( ';' , $sql['grades'] );
				if ( in_array ( $grade , $gds ) ){
					$secu = TRUE;
				}
			}
			
			$secu2 = FALSE;
			// Groupe requis ?
			if ( ereg ( '^0;' , $sql['groupes'] ) || ereg ( ';0;' , $sql['groupes'] ) ){
				$secu2 = TRUE;
			}
			else{
				$gps = explode ( ';' , $sql['groupes'] );
				$gpgp = explode ( ';' , $groupe );
				foreach ( $gpgp AS $gp_act )
					if ( in_array ( $gp_act , $gps ) )
						$secu2 = TRUE;
				}
			if ( ( $secu AND $secu2 AND $sql['min'] <= time() AND $sql['max'] >= time() ) OR $grade == 4 OR in_array ( $grade , $grades_right , TRUE ) ){
				$template->assign_block_vars ( 'download_viewcat.file' , array ( 
				'ID' => $sql['id'],
				'NOM' => to_html ( $sql['nom'] ),
				'HITS' => $sql['hits'],
				'DOWNLOADS' => $sql['downloads']) );
			}
			if ( $sql['password'] != NULL ){
				$template->assign_block_vars ( 'download_viewcat.file.pass' , array () );
			}
		}
	}
	$Bdd->free_result ( $query );
	
	// On ferme le bloc central
	$template->set_filename ( 'bas_mods.tpl' );

}
else if ( ereg ( 'view_download_index' , $permissions ) AND $secu AND $secu2 AND isset ( $_POST['cat_password'] ) ){
	// Validation de la selection du mot de passe
	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => DOWNLOAD ) );
	
	if ( md5 ( $_POST['cat_password'] ) == $sql['password'] ){

	setcookie ( 'download_pass_'.intval ( $_GET['id'] ) , $sql['password'] , ( time() + 3600 ) );
	$template->assign_block_vars ( 'password_valid' , array (
		'TXT' => CAT_IDENTIFICATION_SUCCESSFULL,
		'URL' => 'index.php?mods=download&amp;page=viewcat&amp;id='.intval ( $_GET['id'] ),
		'GO' => GO_TO_CAT) );
	}
	else{
		$template->assign_block_vars ( 'password_valid' , array (
		'TXT' => CAT_IDENTIFICATION_ERROR,
		'URL' => 'index.php?mods=download&amp;page=viewcat&amp;id='.intval ( $_GET['id'] ),
		'GO' => back ) );
	}
	
	$template->set_filename ( './modules/download/viewcat.tpl' );
	
	$template->set_filename ( 'bas_mods.tpl' );
}
else if ( ereg ( 'view_download_index' , $permissions ) AND $secu AND $secu2 AND !$secu3 ){
	// Formulaire pour demander le mot de pass
	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => DOWNLOAD ) );
	
	$template->set_filename ( './modules/download/viewcat.tpl' );
	$template->assign_block_vars ( 'password_needed' , array (
	'TXT' => NEED_PASSWORD,
	'ID' => intval ( $_GET['id'] ),
	'VALUE' => valid,
	'BACK' => back ) );
	
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}

?>