<?php

if ( $grade == 4 OR ereg ( 'view_download_index' , $permissions ) ){
	
	// On ouvre le bloc central
	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => DOWNLOAD ) );
	
	// Array qui va stocker les statistiques pour les afficher en fin de page ;)
	$stats = array ( 'files' => 0 , 'hits' => 0 , 'downloads' => 0 );
	
	// On charge le template de la page
	$template->set_filename ( './modules/download/index.tpl' );
	
	$template->assign_block_vars ( 'download_index' , array (
	'CATS' => DOWNLOAD_CATS,
	'NOM_CAT' => DOWNLOAD_CAT,
	'FILES' => DOWNLOAD_FILES,
	'HITS' => DOWNLOAD_HITS,
	'DOWNLOADS' => DOWNLOAD_DOWNLOADS ) );
	
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
		cat.parent = "0"' );
		
	if ( $Bdd->get_num_rows ( $query ) == 0 ){
		$template->assign_block_vars ( 'download_index.none' , array ( 'TXT' => DOWNLOAD_NONE_CATS ) );
	}
	else{
		
		$a = FALSE;
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
			
			
			if ( ( $secu AND $secu2 ) OR $grade == 4 ){
				$template->assign_block_vars ( 'download_index.cat' , array (
				'ID' => $sql['id'],
				'NOM' => to_html ( $sql['nom'] ),
				'DEF' => to_html ( $sql['description'] ),
				'FILES' => $sql['files'],
				'HITS' => $sql['hits'],
				'DOWNLOADS' => $sql['downloads']
				) );
				
				$a = TRUE;
				
				$stats['files'] = $stats['files'] + $sql['files'];
				$stats['hits'] = $stats['hits'] + $sql['hits'];
				$stats['downloads'] = $stats['downloads'] + $sql['downloads'];
				
				if ( $sql['password'] != NULL ){
					$template->assign_block_vars ( 'download_index.cat.pass' , array () );
				}
			}
		
		}
		if ( !$a )$template->assign_block_vars ( 'download_index.none' , array ( 'TXT' => DOWNLOAD_NONE_CATS ) );
	}
	$Bdd->free_result ( $query );
	
	// On affiche les stats
	$template->assign_block_vars ( 'download_index.stats' , array (
	'STATS' => DOWNLOAD_STATS,
	'NB_FILE' => DOWNLOAD_NB_FILE,
	'FILES' => $stats['files'],
	'NB_HITS' => DOWNLOAD_NB_HIT,
	'HITS' => $stats['hits'],
	'NB_DOWNLOADS' => DOWNLOAD_NB_DOWNLOAD,
	'DOWNLOADS' => $stats['downloads'] ) );
	
	unset ( $stats );
	
	// On ferme le bloc central
	$template->set_filename ( 'bas_mods.tpl' );

}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}

?>