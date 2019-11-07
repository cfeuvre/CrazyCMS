<?php

// On récupère toutes les informations relatives à ce fichier
$query = $Bdd->sql ( '
SELECT
	file.parent AS parent,
	file.nom AS nom,
	file.description AS description,
	file.pictures AS pictures,
	file.password AS password,
	file.groupes AS gps,
	file.grades AS gds,
	file.minimum_date AS min_date,
	file.maximum_date AS max_date,
	file.votes AS votes,
	file.add_comment AS add_comment,
	file.add_comment_groupe AS add_comment_gps,
	file.add_comment_grade AS add_comment_gds,
	file.hits AS hits,
	file.downloads AS downloads,
	file.version AS version,
	file.taille AS size,
	file.licence AS license,
	file.sortie_date AS sortie_date,
	file.editeur AS editeur
FROM
	'.PT.'_download_files AS file
WHERE
		file.id = '.intval ( $_GET['id'] ) );
	$grades_right = explode ( ',' , $download_grade_admin );
	$sql = $Bdd->get_array ( $query );
	
if ( $Bdd->get_num_rows ( $query ) == 0 OR ( ( $sql['min_date'] > time() OR $sql['max_date'] < time() ) AND $grade != 4 AND !in_array ( $grade , $grades_right , TRUE ) ) ){
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
else{

	// Si un mot de passe à été entré, on le vérifie
	if ( isset ( $_POST['file_pass'] ) ){
		$try = TRUE;
		
		setcookie ( 'download_pass_dl_'.intval ( $_POST['file_id'] ) , $sql['password'] , ( time() + 3600 ) );
		
		if ( md5 ( $_POST['file_pass'] ) == $sql['password'] ){
			$_COOKIE['download_pass_dl_'.intval ( $_POST['file_id'] )] = $sql['password'];
		}
	}

	// On vérifie que l'utilisateur à l'autorisation d'acceder a ce fichier et à sa catégorie parent ;)
	
	// On recupere les infos de la catégorie parent :
	$query_parent = $Bdd->sql ( '
	SELECT
		cat.groupes AS groupes,
		cat.grades AS grades,
		cat.password AS password,
		cat.parent AS parent
	FROM
		'.PT.'_download_cat AS cat
	WHERE
		cat.id = "'.$sql['parent'].'"' );

	$sql_parent = $Bdd->get_array ( $query_parent );
	$Bdd->free_result ( $query_parent );	

	$secu = FALSE;
	//Grade requis ?
	if ( ereg ( '^0;' , $sql_parent['grades'] ) || ereg ( ';0;' , $sql_parent['grades'] ) ){
		$secu = TRUE;
	}
	else{
		$gds = explode ( ';' , $sql_parent['grades'] );
		if ( in_array ( $grade , $gds ) ){
			$secu = TRUE;
		}
	}

	$secu2 = FALSE;
	// Groupe requis ?
	if ( ereg ( '^0;' , $sql_parent['groupes'] ) || ereg ( ';0;' , $sql_parent['groupes'] ) ){
		$secu2 = TRUE;
	}
	else{
		$gps = explode ( ';' , $sql_parent['groupes'] );
		$gpgp = explode ( ';' , $groupe );
		foreach ( $gpgp AS $gp_act )
			if ( in_array ( $gp_act , $gps ) )
				$secu2 = TRUE;
	}

	$secu3 = FALSE;
	if ( $sql_parent['password'] == NULL OR ( isset ( $_COOKIE['download_pass_'.intval ( $_GET['id'] ) ] ) AND $_COOKIE['download_pass_'.intval ( $_GET['id'] ) ] == $sql_parent['password'] ) )
		$secu3 = TRUE;

	if ( $grade == 4 OR ( ereg ( 'view_download_index' , $permissions ) AND $secu AND $secu2 AND $secu3 ) ){

		// On met a jour le compteur de hits
		$Bdd->sql ( 'UPDATE '.PT.'_download_files SET hits = hits + 1 WHERE id="'.intval ( $_GET['id'] ).'"' );
		
		$boucle = TRUE;
		
		$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET nb_hits = nb_hits + 1 WHERE id="'.$sql['parent'].'"' );
		
		if ( $sql_parent['parent'] == 0 )$boucle = FALSE;
		
		$parent = $sql_parent['parent'];
		
		while ( $boucle ){
		
			$qp = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_cat WHERE id="'.$parent.'"' );
			$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET nb_hits = nb_hits + 1 WHERE id="'.$parent.'"' );
			
			$sq = $Bdd->get_array ( $qp );
			
			if ( $sq['parent'] != 0 )
				$parent = $sq['parent'];
			else
				$boucle = FALSE;
			
		}
		//

		$template->set_filename ( 'haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => to_html ( $sql['nom'] ) ) );
		
		$template->set_filename ( './modules/download/viewfile.tpl' );
		
		$template->assign_block_vars ( 'file' , array (
		'NOM' => to_html ( $sql['nom'] ),
		'CONTENU' => to_html ( $sql['description'] ),
		'DOWNLOAD' => DOWNLOAD_DOWN,
		'ID' => $sql['parent'],
		'BACK' => back ) );
		
		// On regarde si l'utilisateur a droit d'administration
		if($grade==4 OR in_array ( $grade , $grades_right , TRUE ) )
			$template->assign_block_vars ( 'file.admin_file' , array ( 
			'ID' => intval ( $_GET['id'] ),
			'DEL' => DOWNLOAD_DELETE_FILE,
			'EDIT' => DOWNLOAD_EDIT_FILE ) );
		
		//On recupere la note
		if ( $sql['votes'] != NULL ){
			$nts = explode ( ';' , $sql['votes'] );
			$note = round ( array_sum ( $nts ) / ( count ( $nts ) - 1 ) , 0 );
			
			$template->assign_block_vars ( 'file.notes' , array ( 'NOTE' => DOWNLOAD_NOTE ) );
			
			for ( $i = 1 ; $i <= $note ; $i++ ){
				$template->assign_block_vars ( 'file.notes.note' , array ( 'IMG' => 'stars_on' ) );
			}
			
			$max = ( 10 - $note );
			for ( $i = 1 ; $i <= $max ; $i++ ){
				$template->assign_block_vars ( 'file.notes.note' , array ( 'IMG' => 'stars_off' ) );
			}
			
		}
		
		// On affiche les infos supplémentaires si il y en a ;)
		if ( $sql['editeur'] != NULL OR $sql['version'] != NULL OR $sql['sortie_date'] != NULL OR $sql['license'] != NULL OR $sql['size'] != NULL ){
			
			$template->assign_block_vars ( 'file.plus' , array ( 'INFOPLUS' => DOWNLOAD_INFOPLUS ) );
			
			// Editeur du fichier
			if ( $sql['editeur'] != NULL )
				$template->assign_block_vars ( 'file.plus.editor' , array (
				'NOM' => DOWNLOAD_EDITOR,
				'VALUE' => htmlspecialchars ( $sql['editeur'] ) ) );
				
			// Version du fichier
			if ( $sql['version'] != NULL )
				$template->assign_block_vars ( 'file.plus.version' , array (
				'NOM' => DOWNLOAD_VERSION,
				'VALUE' => htmlspecialchars ( $sql['version'] ) ) );
				
			// Date de sortie du fichier
			if ( $sql['sortie_date'] != NULL AND $sql['sortie_date'] != '' )
				$template->assign_block_vars ( 'file.plus.sortie' , array (
				'NOM' => DOWNLOAD_SORTIE,
				'VALUE' => date ( 'd\/m\/Y' , $sql['sortie_date'] ) ) );
				
			// Licence du fichier
			if ( $sql['license'] != NULL )
				$template->assign_block_vars ( 'file.plus.licence' , array (
				'NOM' => DOWNLOAD_LICENSE,
				'VALUE' => htmlspecialchars ( $sql['license'] ) ) );
				
			// Taille du fichier
			if ( $sql['size'] != NULL ){
				$taille = $sql['size'];
				$ext = '';
				if ( $taille < 1000 ){
					$ext = 'octets';
				}
				else if ( $taille < 1000000 ){
					$ext = 'Ko';
					$taille = round ( $taille / 1000 , 1 );
				}
				else if ( $taille < 1000000000 ){
					$ext = 'Mo';
					$taille = round ( $taille / 1000000 , 2 );
				}
				else{
					$ext = 'Go';
					$taille = round ( $taille / 1000000000 , 2 );
				}
				
				$template->assign_block_vars ( 'file.plus.size' , array (
				'NOM' => DOWNLOAD_SIZE,
				'VALUE' => $taille,
				'EXT' => $ext ) );
			}
		}
	
		// On affiche les statistiques du fichier
		$template->assign_block_vars ( 'file.stats' , array ( 
		'NB_HIT' => DOWNLOAD_HITS,
		'NB_HITS' => $sql['hits'],
		'NB_DL' => DOWNLOAD_DOWNLOADS,
		'NB_DLS' => $sql['downloads'] ) );
	
		// On affiche des liens vers les image de présentation si il y en a ;)
		if ( $sql['pictures'] != NULL ){
			$template->assign_block_vars ( 'file.pics' , array ( 'TXT' => DOWNLOAD_PRES_PICS ) );
			$pics = explode ( '}' , htmlspecialchars ( $sql['pictures'] ) );
			
			foreach ( $pics AS $pic ){
				if ( $pic != NULL )$template->assign_block_vars ( 'file.pics.pic' , array ( 'URL' => $pic ) );
			}
		}
		
		// Si ce téléchargement expire dans moins d'une semaine, on prévient l'utilisateur
		if ( $sql['max_date'] < ( time() + ( 3600 * 24 * 7 ) ) )
			$template->assign_block_vars ( 'file.expiration' , array ( 'TXT' => DOWNLOAD_EXPIRATION.date ( 'd\/m\/Y' , $sql['max_date'] ) ) );
		
		// On vérifie que l'utilisateur à l'autorisation de télécharger ce fichier, sinon on lui dit qu'il ne peut pas histoire qu'il ne cherche pas le lien pour telecharger pdt 2h ( ca m'est arrivée ^^ )
		$secu = FALSE;
		//Grade requis ?
		if ( ereg ( '^0;' , $sql['gds'] ) || ereg ( ';0;' , $sql['gds'] ) ){
			$secu = TRUE;
		}
		else{
			$gds = explode ( ';' , $sql['gds'] );
			if ( in_array ( $grade , $gds ) ){
				$secu = TRUE;
			}
		}

		$secu2 = FALSE;
		// Groupe requis ?
		if ( ereg ( '^0;' , $sql['gps'] ) || ereg ( ';0;' , $sql['gps'] ) ){
			$secu2 = TRUE;
		}
		else{
			$gps = explode ( ';' , $sql['gps'] );
			$gpgp = explode ( ';' , $groupe );
			foreach ( $gpgp AS $gp_act )
				if ( in_array ( $gp_act , $gps ) )
					$secu2 = TRUE;
		}

		$secu3 = FALSE;
		// Si il n'y a pas de mot de passe ou qu'il est hérité de la catégorie parent, on s'en fout ^^, sinn on regarde si il a deja ete entré recemment
		if ( $sql['password'] == NULL OR $sql['password'] == $sql_parent['password'] OR ( isset ( $_COOKIE['download_pass_dl_'.intval ( $_GET['id'] ) ] ) AND $_COOKIE['download_pass_dl_'.intval ( $_GET['id'] ) ] == $sql['password'] ) )
			$secu3 = TRUE;

		if ( !$secu2 OR !$secu ){
			// On indique le manque de permissions
			$template->assign_block_vars ( 'file.dl_need' , array ( 'CANT' => DOWNLOAD_NEEDED_PERMS ) );
			
			if ( !$secu )
				$template->assign_block_vars ( 'file.dl_need.err' , array ( 'TXT' => NEED_MORE_GRADE ) );
			
			if ( !$secu2 )
				$template->assign_block_vars ( 'file.dl_need.err' , array ( 'TXT' => NEED_MORE_GROUPS ) );
		}
		else if ( !$secu3 ){
			$template->assign_block_vars ( 'file.pass' , array (
			'TXT' => DOWNLOAD_PASS_NEEDED_TO_DL,
			'ID' => intval ( $_GET['id'] ),
			'VALID' => valid ) );
			
			if ( isset ( $try ) )
				$template->assign_block_vars ( 'file.pass.error' , array ( 'TXT' => DOWNLOAD_WRONG_PASSWORD ) );
		}
		else{
			// On affiche le lien vers la page de téléchargement et un lien pour recommander le fichier
			
			$template->assign_block_vars ( 'file.dl' , array ( 'ID' => intval ( $_GET['id'] ) ) );
		}
		
		// Si il est possible d'ajouter des commentaire a ce fichier, on ouvre le cadre des commentaires
		if ( $sql['add_comment'] == 1 ){

			// On cherche les commentaires associes au fichier
			$template->assign_block_vars ( 'file.comms' , array (
			'COMMENTS' => DOWNLOAD_COMMENTS ) );
			
			// On regarde si l'utilisateur à l'autorisation d'ajouter des commentaires
			$secu = FALSE;
			//Grade requis ?
			if ( ereg ( '^0;' , $sql['add_comment_gds'] ) || ereg ( ';0;' , $sql['add_comment_gds'] ) ){
				$secu = TRUE;
			}
			else{
				$gds = explode ( ';' , $sql['add_comment_gds'] );
				if ( in_array ( $grade , $gds ) ){
					$secu = TRUE;
				}
			}

			$secu2 = FALSE;
			// Groupe requis ?
			if ( ereg ( '^0;' , $sql['add_comment_gps'] ) || ereg ( ';0;' , $sql['add_comment_gps'] ) ){
				$secu2 = TRUE;
			}
			else{
				$gps = explode ( ';' , $sql['add_comment_gps'] );
				$gpgp = explode ( ';' , $groupe );
				foreach ( $gpgp AS $gp_act )
					if ( in_array ( $gp_act , $gps ) )
						$secu2 = TRUE;
			}

			if ( $secu AND $secu2 ){
				$template->assign_block_vars ( 'file.comms.add' , array (
				'ID' => intval ( $_GET['id'] ),
				'ADD' => DOWNLOAD_ADD_COMMENT ) );
			}
			else{
				$template->assign_block_vars ( 'file.comms.cant_add' , array ( 'TXT' => DOWNLOAD_CANT_ADD_COMMENT ) );
			}
		
			$com_par_page = 5;
			
			// On compte le nombre de réponses pour afficher les differentes pages possibles ;)
			$nb_reply = $Bdd->sql ( 'SELECT COUNT(*) AS nb_comment FROM '.PT.'_download_comments WHERE '.PT.'_download_comments.parent = "'.intval ( $_GET['id'] ).'"' );
			$nb = $Bdd->get_array($nb_reply);
			$pages = ceil ( $nb['nb_comment'] / $com_par_page );

				// Gestion du multipage.
				if ( isset ( $_GET['nb_page'] ) ){
					$page = intval ( $_GET['nb_page'] );
					$id_depart = ( $page * $com_par_page ) - $com_par_page;
				}
				else{
					$page = 1;
					$id_depart = 0;
				}
				
				give_pages ( $pages , array ( 'file.comms.page' ) , './index.php?mods=download&amp;page=viewfile&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page=' , $page );
				
				// Liens pour changer de pages //
				if ( $pages > 1 AND $pages < 15 ){

					// Si il y a moins de 15 pages, on peut se permettre d'afficher le lien vers chaque page ;)

					$template->assign_block_vars ( 'file.comms.page' , array ( 'PAGE' => DOWNLOAD_PAGE ) );

					for ( $i = 1; $i <= $pages; $i++ ){

						$size = 2;

						if ( $i == $page )$size = 5;
						if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
						if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

						$template->assign_block_vars ( 'file.comms.page.pg' , array ( 
						'URL' => './index.php?mods=download&amp;page=viewfile&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page='.$i,
						'SIZE' => $size,
						'NM' => $i) );
					}
				}
				else if ( $pages > 1 ){

				// Si il y a plus de 15 pages, on affiche uniquement les 8 pages autour de celle actuelle ainsi que les 3 premieres et les 3 dernieres

					$template->assign_block_vars ( 'file.comms.page' , array ( 'PAGE' => PAGE ) );

					for ( $i = 1; $i <= 3; $i++ ){

						$size = 2;

						if ( $i == $page )$size = 5;
						if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
						if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

						$template->assign_block_vars ( 'file.comms.page.pg' , array ( 
						'URL' => './index.php?mods=download&amp;page=viewfile&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page='.$i,
						'SIZE' => $size,
						'NM' => $i) );
					}

					if ( $page <= 7 ){

						for ( $i = 4; $i <= 9; $i++ ){

							$size = 2;

							if ( $i == $page )$size = 5;
							if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
							if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

							$template->assign_block_vars ( 'file.comms.page.pg' , array ( 
							'URL' => './index.php?mods=download&amp;page=viewfile&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page='.$i,
							'SIZE' => $size,
							'NM' => $i) );
						}

						$template->assign_block_vars ( 'file.comms.page.pg.etc' , array() );

					}

					if ( $page > 7 AND $page < $pages -6 ){

						if ( $page > 10 ){
							$template->assign_block_vars ( 'file.comms.page.pg.etc' , array() );
						}

						for ( $i = $page - 4; $i <= $page + 4; $i++ ){

							$size = 2;

							if ( $i == $page )$size = 5;
							if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
							if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

							$template->assign_block_vars ( 'file.comms.page.pg' , array ( 
							'URL' => './index.php?mods=download&amp;page=viewfile&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page='.$i,
							'SIZE' => $size,
							'NM' => $i) );
						}

						if ( $page < $pages - 7 ){
							$template->assign_block_vars ( 'file.comms.page.pg.etc' , array() );
						}

					}

					if ( $page >= $pages -6 ){

						$template->assign_block_vars ( 'file.comms.page.pg.etc' , array() );

						for ( $i = $pages - 9; $i < $pages - 2; $i++ ){

							$size = 2;

							if ( $i == $page )$size = 5;
							if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
							if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

							$template->assign_block_vars ( 'file.comms.page.pg' , array ( 
							'URL' => './index.php?mods=download&amp;page=viewfile&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page='.$i,
							'SIZE' => $size,
							'NM' => $i) );
						}
					}

					for ( $i = $pages - 2; $i <= $pages; $i++ ){

						$size = 2;

						if ( $i == $page )$size = 5;
						if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
						if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

						$template->assign_block_vars ( 'file.comms.page.pg' , array ( 
						'URL' => './index.php?mods=download&amp;page=viewfile&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page='.$i,
						'SIZE' => $size,
						'NM' => $i) );
					}
				}
				//
			
			$qc = $Bdd->sql ( '
			SELECT
				com.id AS id,
				com.auteur AS id_auteur,
				com.contenu AS contenu,
				com.note AS note,
				com.date AS date,
				u.pseudo AS pseudo
			FROM
				'.PT.'_download_comments AS com,
				'.PT.'_users AS u
			WHERE
				com.parent = "'.intval ( $_GET['id'] ) .'"
			AND
				com.auteur = u.id
			LIMIT '.$id_depart.', '.$com_par_page );
				
			if ( $Bdd->get_num_rows ( $qc ) == 0 ){
				$template->assign_block_vars ( 'file.comms.none' , array ( 'TXT' => DOWNLOAD_NONE_COMMENT ) );
			}
			else{
				
				// On affiche les commentaires
				while ( $sc = $Bdd->get_array ( $qc ) ){
					$template->assign_block_vars ( 'file.comms.com' , array(
					'ID' => $sc['id'],
					'COMMENT_FROM' => DOWNLOAD_COMMENT_FROM,
					'PSEUDO' => $sc['pseudo'],
					'CONTENU' => to_html ( $sc['contenu'] ),
					'NOTE' => DOWNLOAD_NOTE,
					'NT' => $sc['note'],
					'THE' => the,
					'DATE' => ccmsdate ( $fuseaux , $sc['date'] ) ) );
					if ( $grade == 4 OR in_array ( $grade , $grades_right , TRUE ) )
						$template->assign_block_vars ( 'file.comms.com.admin' , array (
						'ID' => $sc['id'],
						'DELETE' => delete,
						'EDIT' => edit,
						'UID' => $uid,
						'PWD' => $user_password,
						'USER_AGENT' => htmlspecialchars ( $_SERVER['HTTP_USER_AGENT'] ),
						'LANGUE' => $u_lang,
						'THEME' => $u_theme ) );
				}
				
			}
			$Bdd->free_result ( $qc );
		
		}
		
		$template->set_filename ( 'bas_mods.tpl' );
		
	}
	else if ( ereg ( 'view_download_index' , $permissions ) AND $secu AND $secu2 AND isset ( $_POST['cat_password'] ) ){
		// Validation de la selection du mot de passe
		$template->set_filename ( 'haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => DOWNLOAD ) );
		
		if ( md5 ( $_POST['cat_password'] ) == $sql_parent['password'] ){
			setcookie (  'download_pass_'.intval ( $_GET['id'] ) , $sql_parent['password'] , ( time() + 3600 ) );
			$template->assign_block_vars ( 'password_valid' , array (
			'TXT' => CAT_IDENTIFICATION_SUCCESSFULL,
			'URL' => 'index.php?mods=download&amp;page=viewfile&amp;id='.intval ( $_GET['id'] ),
			'GO' => GO_TO_CAT) );
		}
		else{
			$template->assign_block_vars ( 'password_valid' , array (
			'TXT' => CAT_IDENTIFICATION_ERROR,
			'URL' => 'index.php?mods=download&amp;page=viewfile&amp;id='.intval ( $_GET['id'] ),
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
	
}

?>