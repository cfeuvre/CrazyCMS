<?php
$grades = explode ( ',' , $download_grade_admin );
if($grade==4 OR in_array ( $grade , $grades , TRUE ) ){
	
	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => DOWNLOAD_ADMIN ) );
	
	$template->set_filename ( './modules/download/admin.tpl' );
	
	if ( isset ( $_GET['add_cat'] ) ){
		
		if ( isset ( $_POST['contenu'] ) ){

			if ( strlen ( $_POST['title'] ) < 3 ){
				$template->assign_block_vars ( 'add_cat_valid' , array (
				'TXT' => DOWNLOAD_BIG_TITLE_PLEASE,
				'URL' => '',
				'BACK' => back ) );
			}
			else{
			
				// On récupère le titre et la def
				$title = $Bdd->secure ( $_POST['title'] );
				$contenu = $Bdd->secure ( $_POST['contenu'] );
			
				// Mot de Passe ?
				if ( $_POST['password'] == '' )
					$password = '';
				else
					$password = md5 ( $_POST['password'] );
					
				// Recuperation des groupes , grades choisis
				
				$groupes = '';
				$query = $Bdd->sql('SELECT id FROM '.PT.'_groupe' );
				while ( $sql = $Bdd->get_array ( $query ) ){
					if ( isset ( $_POST['gps_'.$sql['id']] ) )
						$groupes .= $sql['id'].';';
				}
				if ( $groupes == '' )
					$groupes = '0;';
					
				$grades = '';
				$query = $Bdd->sql('SELECT id FROM '.PT.'_grades' );
				while ( $sql = $Bdd->get_array ( $query ) ){
					if ( isset ( $_POST['gds_'.$sql['id']] ) )
						$grades .= $sql['id'].';';
				}
				if ( $grades == '' )
					$grades = '0;';
					
				$Bdd->sql ( 'INSERT INTO '.PT.'_download_cat 
					( parent , nb_files , nb_hits , nb_downloads , nom , description , groupes , grades , password ) 
				VALUES 
					( "0" , "0" , "0" , "0" , "'.$title.'" , "'.$contenu.'" , "'.$groupes.'" , "'.$grades.'" , "'.$password.'" )' );
			
				$template->assign_block_vars ( 'add_cat_valid' , array (
					'TXT' => DOWNLOAD_CAT_ADDED_SUCCESSFULLY,
					'URL' => 'index.php?mods=download&amp;page=admin',
					'BACK' => back ) );
			
			}
		}
		else{
		
			$template->assign_block_vars ( 'add_cat_form' , array (
			'TITLE' => title,
			'TITLE_VALUE' => '',
			'DESCRIPTION' => DOWNLOAD_CAT_DESCRIPTION,
			'FORM' => default_form( FALSE , NULL , NULL , 50 ),
			'SECURITY' => DOWNLOAD_SECURITY_OPTIONS,
			'PASSWORD' => DOWNLOAD_PASSWORD,
			'VALID' => valid ) );
			
			// On recupere tous les groupes existants
			$query = $Bdd->sql('SELECT id, nom, description FROM '.PT.'_groupe' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$template->assign_block_vars ( 'add_cat_form.gps' , array ( 'TXT' => DOWNLOAD_GROUPS_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_cat_form.gps.gp' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => 'checked="checked"' ) );
				$template->assign_block_vars ( 'add_cat_form.gps.gp.def' , array ( 'DEF' => DOWNLOAD_ALL_USER ) );
				
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					$template->assign_block_vars ( 'add_cat_form.gps.gp' , array (
					'NOM' => $sql['nom'],
					'ID' => $sql['id'],
					'CHECKED' => '' ) );
					if ( $sql['description'] != '' )
						$template->assign_block_vars ( 'add_cat_form.gps.gp.def' , array ( 'DEF' => $sql['description'] ) );
				}
			}
			
			// On recupere tous les grades existants
			$query = $Bdd->sql('SELECT id, name FROM '.PT.'_grades' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$template->assign_block_vars ( 'add_cat_form.gds' , array ( 'TXT' => DOWNLOAD_GRADES_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_cat_form.gds.gd' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => 'checked="checked"' ) );
				
				while ( $sql = $Bdd->get_array ( $query ) )
					$template->assign_block_vars ( 'add_cat_form.gds.gd' , array (
					'NOM' => $sql['name'],
					'ID' => $sql['id'],
					'CHECKED' => '' ) );
			
			}
		
		}
		
	}
	else if ( isset ( $_GET['add_subcat'] ) ){
	
		if ( isset ( $_POST['contenu'] ) ){

			if ( strlen ( $_POST['title'] ) < 3 ){
				$template->assign_block_vars ( 'add_cat_valid' , array (
				'TXT' => DOWNLOAD_BIG_TITLE_PLEASE,
				'URL' => '',
				'BACK' => back ) );
			}
			else{
			
				// On récupère le titre et la
				$title = $Bdd->secure ( $_POST['title'] );
				$contenu = $Bdd->secure ( $_POST['contenu'] );
			
				// Si la strategie de securite est hérité de la catégorie parent,  on la recupere
				if ( $_POST['strategie'] == 0 ){
					$query = $Bdd->sql ( 'SELECT password, grades, groupes FROM '.PT.'_download_cat WHERE id="'.intval ( $_GET['add_subcat'] ).'"' );
					$sql = $Bdd->get_array ( $query );
					$password = $sql['password'];
					$groupes = $sql['groupes'];
					$grades = $sql['grades'];
				}
				else{
					// Mot de Passe ?
					if ( $_POST['password'] == '' )
						$password = '';
					else
						$password = md5 ( $_POST['password'] );
						
					// Recuperation des groupes , grades choisis
					
					$groupes = '';
					$query = $Bdd->sql('SELECT id FROM '.PT.'_groupe' );
					while ( $sql = $Bdd->get_array ( $query ) ){
						if ( isset ( $_POST['gps_'.$sql['id']] ) )
							$groupes .= $sql['id'].';';
					}
					if ( $groupes == '' )
						$groupes = '0;';
						
					$grades = '';
					$query = $Bdd->sql('SELECT id FROM '.PT.'_grades' );
					while ( $sql = $Bdd->get_array ( $query ) ){
						if ( isset ( $_POST['gds_'.$sql['id']] ) )
							$grades .= $sql['id'].';';
					}
					if ( $grades == '' )
						$grades = '0;';
				}
				
				$Bdd->sql ( 'INSERT INTO '.PT.'_download_cat 
					( parent , nb_files , nb_hits , nb_downloads , nom , description , groupes , grades , password ) 
				VALUES 
					( "'.intval ( $_GET['add_subcat'] ).'" , "0" , "0" , "0" , "'.$title.'" , "'.$contenu.'" , "'.$groupes.'" , "'.$grades.'" , "'.$password.'" )' );
			
				$template->assign_block_vars ( 'add_cat_valid' , array (
					'TXT' => DOWNLOAD_CAT_ADDED_SUCCESSFULLY,
					'URL' => 'index.php?mods=download&amp;page=admin',
					'BACK' => back ) );
			}
		}
		else{
		
			$template->assign_block_vars ( 'add_cat_form' , array (
			'TITLE' => title,
			'TITLE_VALUE' => '',
			'DESCRIPTION' => DOWNLOAD_CAT_DESCRIPTION,
			'FORM' => default_form( FALSE , NULL , NULL , 50 ),
			'SECURITY' => DOWNLOAD_SECURITY_OPTIONS,
			'PASSWORD' => DOWNLOAD_PASSWORD,
			'VALID' => valid ) );
			
			$template->assign_block_vars ( 'add_cat_form.sub' , array (
			'JS' => '
			<script type="text/javascript">
				function strateg ( type ){
					if ( type == 0 ){
						document.getElementById(\'strateg\').style.visibility = "hidden";
						document.getElementById(\'strateg\').style.width = "0px";
						document.getElementById(\'strateg\').style.height = "0px";
					}
					else{
						document.getElementById(\'strateg\').style.visibility = "visible";
						document.getElementById(\'strateg\').style.width = "";
						document.getElementById(\'strateg\').style.height = "";
					}
				}
			</script>',
			'HERIT' => DOWNLOAD_HERIT_STRATEGIE,
			'NEW' => DOWNLOAD_NEW_STRATEGIE ) );
			
			// On recupere tous les groupes existants
			$query = $Bdd->sql('SELECT id, nom, description FROM '.PT.'_groupe' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$template->assign_block_vars ( 'add_cat_form.gps' , array ( 'TXT' => DOWNLOAD_GROUPS_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_cat_form.gps.gp' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => 'checked="checked"' ) );
				$template->assign_block_vars ( 'add_cat_form.gps.gp.def' , array ( 'DEF' => DOWNLOAD_ALL_USER ) );
				
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					$template->assign_block_vars ( 'add_cat_form.gps.gp' , array (
					'NOM' => $sql['nom'],
					'ID' => $sql['id'],
					'CHECKED' => '' ) );
					if ( $sql['description'] != '' )
						$template->assign_block_vars ( 'add_cat_form.gps.gp.def' , array ( 'DEF' => $sql['description'] ) );
				}
			}
			
			// On recupere tous les grades existants
			$query = $Bdd->sql('SELECT id, name FROM '.PT.'_grades' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$template->assign_block_vars ( 'add_cat_form.gds' , array ( 'TXT' => DOWNLOAD_GRADES_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_cat_form.gds.gd' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => 'checked="checked"' ) );
				
				while ( $sql = $Bdd->get_array ( $query ) )
					$template->assign_block_vars ( 'add_cat_form.gds.gd' , array (
					'NOM' => $sql['name'],
					'ID' => $sql['id'],
					'CHECKED' => '' ) );
			
			}
		
		}	
	}
	else if ( isset ( $_GET['add_file'] ) ){
	
		if ( isset ( $_POST['contenu'] ) ){
			
			if ( strlen ( $_POST['title'] ) < 3 ){
				$template->assign_block_vars ( 'add_cat_valid' , array (
				'TXT' => DOWNLOAD_BIG_TITLE_PLEASE,
				'URL' => '',
				'BACK' => back ) );
			}
			else{
			
				// On récupère le titre et la def
				$title = $Bdd->secure ( $_POST['title'] );
				$contenu = $Bdd->secure ( $_POST['contenu'] );
	
				// Mot de Passe ?
				if ( $_POST['password'] == '' )
					$password = '';
				else
					$password = md5 ( $_POST['password'] );

				// Recuperation des groupes , grades choisis
				
				$groupes = '';
				$com_gps = '';
				$query = $Bdd->sql('SELECT id FROM '.PT.'_groupe' );
				while ( $sql = $Bdd->get_array ( $query ) ){
					if ( isset ( $_POST['gps_'.$sql['id']] ) )
						$groupes .= $sql['id'].';';
					if ( isset ( $_POST['gps_com_'.$sql['id']] ) )
						$com_gps .= $sql['id'].';';
				}
				if ( $groupes == '' )
					$groupes = '0;';
				if ( $com_gps == '' )
					$com_gps = '0;';
					
				$grades = '';
				$com_gds = '';
				$query = $Bdd->sql('SELECT id FROM '.PT.'_grades' );
				while ( $sql = $Bdd->get_array ( $query ) ){
					if ( isset ( $_POST['gds_'.$sql['id']] ) )
						$grades .= $sql['id'].';';
					if ( isset ( $_POST['gds_com_'.$sql['id']] ) )
						$com_gds .= $sql['id'].';';
				}
				if ( $grades == '' )
					$grades = '0;';
				if ( $com_gds == '' )
					$com_gds = '0;';
			
				$add_comment = ( ( isset ( $_POST['comments'] ) ) ? ( 1 ) : ( 0 ) );
				$version = $Bdd->secure ( $_POST['version'] );
				$editeur = $Bdd->secure ( $_POST['editeur'] );
				$licence = $Bdd->secure ( $_POST['licence'] );
				
				$sortie = mktime ( intval ( $_POST['sortie_date_hour'] ) , intval ( $_POST['sortie_date_mn'] ) , 0 , intval ( $_POST['sortie_date_month'] ) , intval ( $_POST['sortie_date_day'] ) , intval ( $_POST['sortie_date_y'] ) );
				$min_date = mktime ( intval ( $_POST['min_date_hour'] ) , intval ( $_POST['min_date_mn'] ) , 0 , intval ( $_POST['min_date_month'] ) , intval ( $_POST['min_date_day'] ) , intval ( $_POST['min_date_y'] ) );
				$max_date = mktime ( intval ( $_POST['max_date_hour'] ) , intval ( $_POST['max_date_mn'] ) , 0 , intval ( $_POST['max_date_month'] ) , intval ( $_POST['max_date_day'] ) , intval ( $_POST['max_date_y'] ) );
				
				if ( $max_date <= time() )
					$max_date = 99999999999;
					
				if ( $sortie == 1199142000 )
					$sortie = '';
				
				$size = intval ( $_POST['size'] );
				if ( $_POST['size_type'] == 1 )
					$size = $size * 1000;
				else if ( $_POST['size_type'] == 2 )
					$size = $size * 1000000;
				else if ( $_POST['size_type'] == 3 )
					$size = $size * 1000000000;
					
				$miroirs = str_replace ( '\r\n' , '}' , $Bdd->secure ( $_POST['mirrors'] ) );
				$pictures = str_replace ( '\r\n' , '}' , $Bdd->secure ( $_POST['pictures'] ) );

				$Bdd->sql ( '
				INSERT INTO '.PT.'_download_files
				VALUES (
					NULL , 
					"'.intval ( $_GET['add_file'] ).'",
					"'.$title.'",
					"'.$contenu.'",
					"'.$miroirs.'",
					"'.$pictures.'",
					"'.$password.'",
					"'.$groupes.'",
					"'.$grades.'",
					"'.$min_date.'",
					"'.$max_date.'",
					"",
					"'.$add_comment.'",
					"'.$com_gps.'",
					"'.$com_gds.'",
					0,
					0,
					"'.$version.'",
					"'.$size.'",
					"'.$licence.'",
					"'.$sortie.'",
					"'.$editeur.'" 
				)' );
				
				// On met a jour les compteurs de fichiers
				
				$boucle = TRUE;
				
				$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET nb_files = nb_files + 1 WHERE id="'.intval ( $_GET['add_file'] ).'"' );
				
				$qp = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_cat WHERE id="'.intval ( $_GET['add_file'] ).'"' );
				$sql_parent = $Bdd->get_array ( $qp );
				
				if ( $sql_parent['parent'] == 0 )$boucle = FALSE;
				
				$parent = $sql_parent['parent'];
				
				while ( $boucle ){
				
					$qp = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_cat WHERE id="'.$parent.'"' );
					$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET nb_files = nb_files + 1 WHERE id="'.$parent.'"' );
					
					$sq = $Bdd->get_array ( $qp );
					
					if ( $sq['parent'] != 0 )
						$parent = $sq['parent'];
					else
						$boucle = FALSE;
					
				}
				//
		
				$template->assign_block_vars ( 'add_cat_valid' , array (
					'TXT' => DOWNLOAD_FILE_ADDED_SUCCESSFULLY,
					'URL' => 'index.php?mods=download&amp;page=viewcat&amp;id='.intval( $_GET['add_file'] ),
					'BACK' => back ) );
			}
		}
		else{
		
			$template->assign_block_vars ( 'add_file' , array (
			'TITLE' => title,
			'DESCRIPTION' => DOWNLOAD_FILE_DESCRIPTION,
			'FORM' => default_form( FALSE , NULL , NULL , 50 ),
			'MIRRORS' => DOWNLOAD_ENTER_URLS,
			'MIRRORS_HP' => DOWNLOAD_ENTER_EACH_LINE,
			'PICTURES' => DOWNLOAD_ENTER_PICS,
			'PICTURES_HP' => DOWNLOAD_ENTER_EACH_LINE,
			'OPT_OPTIONS' => DOWNLOAD_OPTIONEL,
			'MIN_DATE' => DOWNLOAD_MINIMAL_DATE,
			'COMM_CHECK' => 'checked="checked"',
			'MAX_DATE' => DOWNLOAD_MAXIMAL_DATE,
			'VERSION' => DOWNLOAD_VERSION,
			'EDITEUR' => DOWNLOAD_EDITOR,
			'LICENCE' => DOWNLOAD_LICENSE,
			'SIZE' => DOWNLOAD_SIZE,
			'SORTIE_DATE' => DOWNLOAD_SORTIE,
			'COMMENTS' => DOWNLOAD_COMMENTS_OR_NOT,
			'SECURITY' => DOWNLOAD_SECURITY_OPTIONS,
			'PASSWORD' => DOWNLOAD_PASSWORD,
			'VALID' => valid ) );
			
			for ( $i = 1 ; $i <= 31 ; $i++ ){
				$template->assign_block_vars ( 'add_file.day' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.day2' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.day3' , array ( 'ID' => $i ) );
			}
			for ( $i = 1 ; $i <= 12 ; $i++ ){
				$template->assign_block_vars ( 'add_file.mth' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.mth2' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.mth3' , array ( 'ID' => $i ) );
			}
			for ( $i = 2000 ; $i <= 2020 ; $i++ ){
				$template->assign_block_vars ( 'add_file.year' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.year2' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.year3' , array ( 'ID' => $i ) );
			}
			for ( $i = 0 ; $i <= 23 ; $i++ ){
				$template->assign_block_vars ( 'add_file.hour' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.hour2' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.hour3' , array ( 'ID' => $i ) );
			}
			for ( $i = 0 ; $i <= 59 ; $i++ ){
				$template->assign_block_vars ( 'add_file.mn' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.mn2' , array ( 'ID' => $i ) );
				$template->assign_block_vars ( 'add_file.mn3' , array ( 'ID' => $i ) );
			}	
			// On recupere tous les groupes existants
			$query = $Bdd->sql('SELECT id, nom, description FROM '.PT.'_groupe' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$template->assign_block_vars ( 'add_file.gps' , array ( 'TXT' => DOWNLOAD_GROUPSF_ALLOWED, 'TXTCOM' => DOWNLOAD_GROUPSC_ALLOWED ) );
				$template->assign_block_vars ( 'add_file.gps2' , array ( 'TXT' => DOWNLOAD_GROUPSF_ALLOWED, 'TXTCOM' => DOWNLOAD_GROUPSC_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_file.gps.gp' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => 'checked="checked"' ) );
				$template->assign_block_vars ( 'add_file.gps.gp.def' , array ( 'DEF' => DOWNLOAD_ALL_USER ) );
				
				$template->assign_block_vars ( 'add_file.gps2.gp' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => 'checked="checked"' ) );
				$template->assign_block_vars ( 'add_file.gps2.gp.def' , array ( 'DEF' => DOWNLOAD_ALL_USER ) );
				
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					$template->assign_block_vars ( 'add_file.gps.gp' , array (
					'NOM' => $sql['nom'],
					'ID' => $sql['id'],
					'CHECKED' => '' ) );
					if ( $sql['description'] != '' )
						$template->assign_block_vars ( 'add_file.gps.gp.def' , array ( 'DEF' => $sql['description'] ) );
					
					$template->assign_block_vars ( 'add_file.gps2.gp' , array (
					'NOM' => $sql['nom'],
					'ID' => $sql['id'],
					'CHECKED' => '' ) );
					if ( $sql['description'] != '' )
						$template->assign_block_vars ( 'add_file.gps2.gp.def' , array ( 'DEF' => $sql['description'] ) );
				}
			}
			
			// On recupere tous les grades existants
			$query = $Bdd->sql('SELECT id, name FROM '.PT.'_grades' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$template->assign_block_vars ( 'add_file.gds' , array ( 'TXT' => DOWNLOAD_GRADESF_ALLOWED, 'TXTCOM' => DOWNLOAD_GRADESC_ALLOWED ) );
				$template->assign_block_vars ( 'add_file.gds2' , array ( 'TXT' => DOWNLOAD_GRADESF_ALLOWED, 'TXTCOM' => DOWNLOAD_GRADESC_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_file.gds.gd' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => 'checked="checked"' ) );
				$template->assign_block_vars ( 'add_file.gds2.gd' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => 'checked="checked"' ) );
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					$template->assign_block_vars ( 'add_file.gds.gd' , array (
					'NOM' => $sql['name'],
					'ID' => $sql['id'],
					'CHECKED' => '' ) );
					$template->assign_block_vars ( 'add_file.gds2.gd' , array (
					'NOM' => $sql['name'],
					'ID' => $sql['id'],
					'CHECKED' => '' ) );
				}
			}
		}
	}
	else if ( isset ( $_GET['del_file'] ) ){
	
		// On recupere le nombre de hits et de dl du fichier
		$q = $Bdd->sql ( 'SELECT hits, downloads, parent FROM '.PT.'_download_files WHERE id="'.intval ( $_GET['del_file'] ).'"' );
		$s = $Bdd->get_array ( $q );
		
		// Boucle pour mettre a jour les compteurs de la catégorie parent et de celles au dessus
		$boucle = TRUE;
		
		$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET nb_hits = nb_hits - '.$s['hits'].', nb_downloads = nb_downloads - '.$s['downloads'].', nb_files = nb_files - 1 WHERE id="'.$s['parent'].'"' );
		
		$q_parent = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_cat WHERE id="'.$s['parent'].'"' );
		$sql_parent = $Bdd->get_array ( $q_parent );
		
		if ( $sql_parent['parent'] == 0 )$boucle = FALSE;
		
		$parent = $sql_parent['parent'];
		
		while ( $boucle ){
		
			$qp = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_cat WHERE id="'.$parent.'"' );
			$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET nb_hits = nb_hits - '.$s['hits'].', nb_downloads = nb_downloads - '.$s['downloads'].', nb_files = nb_files - 1 WHERE id="'.$parent.'"' );
			
			$sq = $Bdd->get_array ( $qp );
			
			if ( $sq['parent'] != 0 )
				$parent = $sq['parent'];
			else
				$boucle = FALSE;
			
		}
	
		$Bdd->sql ( 'DELETE FROM '.PT.'_download_files WHERE id="'.intval ( $_GET['del_file'] ).'"' );

		$template->assign_block_vars ( 'add_cat_valid' , array (
		'TXT' => DOWNLOAD_FILE_SUCCESSFULLY_DELETED,
		'URL' => 'index.php?mods=download',
		'BACK' => back ) );
	}
	else if ( isset ( $_GET['del_cat'] ) ){
		
		// On vérifie si c une sous catégorie ou non
		$query = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_cat WHERE id="'.intval ( $_GET['del_cat'] ).'"' );
		$infos = $Bdd->get_array ( $query );
		$parent = $infos['parent'];
		$Bdd->free_result ( $query );
		
		// On commence par supprimer la catégorie ( La partie facile )
		$Bdd->sql ('DELETE FROM '.PT.'_download_cat WHERE id="'.intval ( $_GET['del_cat'] ).'"' );
		
		// Et maintenant on retrouve toutes les categorie, fichiers ou commentaires qui etaient associes a cette catégorie ( La partie difficile ^^ ( dumoins chiante ^^ ))
			//On recherche les catégorie enfants ( Facile )
			$childrens = array ();
			$sub = $Bdd->sql ( 'SELECT id FROM '.PT.'_download_cat WHERE parent = "'.intval ( $_GET['del_cat']).'"' );
			while ( $sb = $Bdd->get_array ( $sub ) ){
				$childrens[] = $sb['id'];
			}
			// On recherche les catégories parents ( Moins Facile ^^ [Oui, c'est ca de coder quand on est fatigué, on fout plein de conneries dans les commentaires ^^] )
			$boucle = $parent;
			$elder = array();
			while ( $boucle != 0 ){
				$query = $Bdd->sql ( 'SELECT id,parent FROM '.PT.'_download_cat WHERE id="'.$boucle.'"' );
				$infos = $Bdd->get_array ( $query );
				$boucle = $infos['parent'];
				$elder[] = $infos['id'];
				$Bdd->free_result ( $query );
			}
			// En fait c po si compliké ^^ ( En mm tps si vous avez pris le tps de lire tout le code de ccms [ Bravo à vous ;) ], vous verez que g du faire ca bcp de fois, donc a force je connais l'astuce par coeur lol )
			// Et mtn on recupere .... ( Pas facile ac la télé derriere ), lol g trou de memoire xD, fo vmt j'aille dormir moi ^^, ah oui c fichier qu'on recupere forcemen,t ^^
			// Donc on recupere tous les fichiers appartenant a  la categorie en question et aux catégories enfants
			// On recupere aussi le nombre de ces fichiers pour decrementer les compteurs de fichier des catégorie parents a la catégorie que l'on suppr ( J'hesite tjs entre developpeur et ecrivain comme metier ^^ )
			$idss = '(';
			foreach ( $childrens AS $id ){
				$idss.=$id.',';
			}
			$idss.= intval ( $_GET['del_cat'] ).')';
			$files = array();
			$hits = 0;
			$downloads = 0;
			$req_file = $Bdd->sql ( 'SELECT id, hits, downloads FROM '.PT.'_download_files WHERE parent IN '.$idss );
			while ( $fl = $Bdd->get_array ( $req_file ) ){
				$files[] = $fl['id'];
				$hits = $hits + $fl['hits'];
				$downloads = $downloads + $fl['downloads'];
				// On supprime les commentaires ;)
				$Bdd->sql ('DELETE FROM '.PT.'_download_comments WHERE parent="'.$fl['id'].'"');		
			}
			$nb_files = count ( $files );
			// Et mtn on decremente les compteurs des categories parents
			$idss2 = '(';
			foreach ( $elder AS $id ){
				$idss2 .= $id.',';
			}
			$idss2 = substr ( $idss , 0 , strlen ( $idss ) - 1 );
			$idss2 .= ')';
			$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET
			nb_files = ( nb_files - '.$nb_files.'),
			nb_hits = ( nb_hits - '.$hits.' ),
			nb_downloads = ( nb_downloads - '.$downloads.' )
			WHERE id IN '.$idss2 );
			// Une bonne chose de faite =)
			// Mtn on supprime tous les fichiers et catégorie enfants :D:D:D
			$Bdd->sql ( 'DELETE FROM '.PT.'_download_files WHERE parent IN '.$idss );
			$Bdd->sql ( 'DELETE FROM '.PT.'_download_cat WHERE id IN '.$idss );
			// Et voilou, je pense n'avoir rien oublié, donc il ne reste plus qu'a annoncer que c'est fait =)
			$template->assign_block_vars ( 'add_cat_valid' , array (
			'TXT' => DOWNLOAD_DELETED_CAT,
			'URL' => 'index.php?mods=download',
			'BACK' => back ) );
	}
	else if ( isset ( $_GET['edit_file'] ) ){
		if ( isset ( $_POST['contenu'] ) ){
			if ( strlen ( $_POST['title'] ) < 3 ){
				$template->assign_block_vars ( 'add_cat_valid' , array (
				'TXT' => DOWNLOAD_BIG_TITLE_PLEASE,
				'URL' => '',
				'BACK' => back ) );
			}
			else{
			
				// On récupère le titre et la def
				$title = $Bdd->secure ( $_POST['title'] );
				$contenu = $Bdd->secure ( $_POST['contenu'] );
	
				// Mot de Passe ?
				if ( $_POST['password'] == '' )
					$password = '';
				else
					$password = md5 ( $_POST['password'] );

				// Recuperation des groupes , grades choisis
				
				$groupes = '';
				$com_gps = '';
				$query = $Bdd->sql('SELECT id FROM '.PT.'_groupe' );
				while ( $sql = $Bdd->get_array ( $query ) ){
					if ( isset ( $_POST['gps_'.$sql['id']] ) )
						$groupes .= $sql['id'].';';
					if ( isset ( $_POST['gps_com_'.$sql['id']] ) )
						$com_gps .= $sql['id'].';';
				}
				if ( $groupes == '' )
					$groupes = '0;';
				if ( $com_gps == '' )
					$com_gps = '0;';
					
				$grades = '';
				$com_gds = '';
				$query = $Bdd->sql('SELECT id FROM '.PT.'_grades' );
				while ( $sql = $Bdd->get_array ( $query ) ){
					if ( isset ( $_POST['gds_'.$sql['id']] ) )
						$grades .= $sql['id'].';';
					if ( isset ( $_POST['gds_com_'.$sql['id']] ) )
						$com_gds .= $sql['id'].';';
				}
				if ( $grades == '' )
					$grades = '0;';
				if ( $com_gds == '' )
					$com_gds = '0;';
			
				$add_comment = ( ( isset ( $_POST['comments'] ) ) ? ( 1 ) : ( 0 ) );
				$version = $Bdd->secure ( $_POST['version'] );
				$editeur = $Bdd->secure ( $_POST['editeur'] );
				$licence = $Bdd->secure ( $_POST['licence'] );
				
				$sortie = mktime ( intval ( $_POST['sortie_date_hour'] ) , intval ( $_POST['sortie_date_mn'] ) , 0 , intval ( $_POST['sortie_date_month'] ) , intval ( $_POST['sortie_date_day'] ) , intval ( $_POST['sortie_date_y'] ) );
				$min_date = mktime ( intval ( $_POST['min_date_hour'] ) , intval ( $_POST['min_date_mn'] ) , 0 , intval ( $_POST['min_date_month'] ) , intval ( $_POST['min_date_day'] ) , intval ( $_POST['min_date_y'] ) );
				$max_date = mktime ( intval ( $_POST['max_date_hour'] ) , intval ( $_POST['max_date_mn'] ) , 0 , intval ( $_POST['max_date_month'] ) , intval ( $_POST['max_date_day'] ) , intval ( $_POST['max_date_y'] ) );
				
				if ( $max_date <= time() )
					$max_date = 99999999999;
					
				if ( $sortie == 1199142000 )
					$sortie = '';
				
				$size = intval ( $_POST['size'] );
				if ( $_POST['size_type'] == 1 )
					$size = $size * 1000;
				else if ( $_POST['size_type'] == 2 )
					$size = $size * 1000000;
				else if ( $_POST['size_type'] == 3 )
					$size = $size * 1000000000;
					
				$miroirs = str_replace ( '\r\n' , '}' , $Bdd->secure ( $_POST['mirrors'] ) );
				$pictures = str_replace ( '\r\n' , '}' , $Bdd->secure ( $_POST['pictures'] ) );

				$Bdd->sql ( 'UPDATE '.PT.'_download_files 
				SET
					nom = "'.$title.'",
					description = "'.$contenu.'",
					mirrors = "'.$miroirs.'",
					pictures = "'.$pictures.'",
					password = "'.$password.'",
					groupes = "'.$groupes.'",
					grades = "'.$grades.'",
					minimum_date = "'.$min_date.'",
					maximum_date = "'.$max_date.'",
					add_comment = "'.$add_comment.'",
					add_comment_groupe = "'.$com_gps.'",
					add_comment_grade = "'.$com_gds.'",
					version = "'.$version.'",
					taille = "'.$size.'",
					licence = "'.$licence.'",
					sortie_date = "'.$sortie.'",
					editeur = "'.$editeur.'"
				WHERE 
					id="'.intval ( $_GET['edit_file'] ).'"' );

				$template->assign_block_vars ( 'add_cat_valid' , array (
					'TXT' => DOWNLOAD_FILE_UPDATED_SUCCESSFULLY,
					'URL' => 'index.php?mods=download&amp;page=viewfile&amp;id='.intval( $_GET['edit_file'] ),
					'BACK' => back ) );
			}
		}
		else{
			// On récupère les infos du sujet :
			$query = $Bdd->sql ( 'SELECT
			nom,
			description,
			mirrors,
			pictures,
			password,
			groupes,
			grades,
			minimum_date,
			maximum_date,
			votes,
			add_comment,
			add_comment_groupe,
			add_comment_grade,
			version,
			taille,
			licence,
			sortie_date,
			editeur
			FROM '.PT.'_download_files WHERE id="'.intval ( $_GET['edit_file'] ).'"' );
			$infos = $Bdd->get_array ( $query );
			$Bdd->free_result ( $query );

			$taille = $infos['taille'];
			$ext = 0;
			if ( $taille < 1000 ){
				$ext = 0;
			}
			else if ( $taille < 1000000 ){
				$ext = 1;
				$taille = round ( $taille / 1000 , 1 );
			}
			else if ( $taille < 1000000000 ){
				$ext = 2;
				$taille = round ( $taille / 1000000 , 2 );
			}
			else{
				$ext = 3;
				$taille = round ( $taille / 1000000000 , 2 );
			}

			$template->assign_block_vars ( 'add_file' , array (
			'TITLE' => title,
			'TITLE_VALUE' => $infos['nom'],
			'DESCRIPTION' => DOWNLOAD_FILE_DESCRIPTION,
			'FORM' => default_form( FALSE , NULL , to_html ( $infos['description'] ) , 50 ),
			'MIRRORS' => DOWNLOAD_ENTER_URLS,
			'MIRRORS_VALUE' => htmlspecialchars ( str_replace ( '}' , "\n" , $infos['mirrors'] ) ),
			'MIRRORS_HP' => DOWNLOAD_ENTER_EACH_LINE,
			'PICTURES' => DOWNLOAD_ENTER_PICS,
			'PICTURES_HP' => DOWNLOAD_ENTER_EACH_LINE,
			'PICTURES_VALUE' => htmlspecialchars ( str_replace ( '}' , "\n" , $infos['pictures'] ) ),
			'OPT_OPTIONS' => DOWNLOAD_OPTIONEL,
			'MIN_DATE' => DOWNLOAD_MINIMAL_DATE,
			'COMM_CHECK' => ( ($infos['add_comment'] == 1 ) ? ( 'checked="checked"' ) : ('') ),
			'MAX_DATE' => DOWNLOAD_MAXIMAL_DATE,
			'VERSION' => DOWNLOAD_VERSION,
			'VERSION_VALUE' => htmlspecialchars ( $infos['version'] ),
			'EDITEUR' => DOWNLOAD_EDITOR,
			'EDITEUR_VALUE' => htmlspecialchars ( $infos['editeur'] ),
			'LICENCE' => DOWNLOAD_LICENSE,
			'LICENCE_VALUE' => htmlspecialchars ( $infos['licence'] ),
			'SIZE' => DOWNLOAD_SIZE,
			'SIZE_VALUE' => $taille,
			'SIZE_CHK' => ( ( $ext == 0 ) ? ( 'selected="selected"' ) : ('') ),
			'SIZE_CHK_1' => ( ( $ext == 1 ) ? ( 'selected="selected"' ) : ('') ),
			'SIZE_CHK_2' => ( ( $ext == 2 ) ? ( 'selected="selected"' ) : ('') ),
			'SIZE_CHK_3' => ( ( $ext == 3 ) ? ( 'selected="selected"' ) : ('') ),
			'SORTIE_DATE' => DOWNLOAD_SORTIE,
			'COMMENTS' => DOWNLOAD_COMMENTS_OR_NOT,
			'SECURITY' => DOWNLOAD_SECURITY_OPTIONS,
			'PASSWORD' => DOWNLOAD_PASSWORD,
			'VALID' => valid ) );
			
			$min_date = $infos['minimum_date'];
			$max_date = $infos['maximum_date'];
			$sortie = $infos['sortie_date'];

			for ( $i = 1 ; $i <= 31 ; $i++ ){
				$template->assign_block_vars ( 'add_file.day' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('d' , $min_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.day2' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('d' , $max_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.day3' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('d' , $sortie ) == $i ) ? ('selected="selected"' ) : ('') ) ) ); 
			}
			for ( $i = 1 ; $i <= 12 ; $i++ ){
				$template->assign_block_vars ( 'add_file.mth' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('m' , $min_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.mth2' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('m' , $max_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.mth3' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('m' , $sortie ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
			}
			for ( $i = 2000 ; $i <= 2020 ; $i++ ){
				$template->assign_block_vars ( 'add_file.year' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('Y' , $min_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.year2' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('Y' , $max_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.year3' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('Y' , $sortie ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
			}
			for ( $i = 0 ; $i <= 23 ; $i++ ){
				$template->assign_block_vars ( 'add_file.hour' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('H' , $min_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.hour2' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('H' , $max_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.hour3' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('H' , $sortie ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
			}
			for ( $i = 0 ; $i <= 59 ; $i++ ){
				$template->assign_block_vars ( 'add_file.mn' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('i' , $min_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.mn2' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('i' , $max_date ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.mn3' , array ( 
				'ID' => $i,
				'SELECTED' => ( ( date('i' , $sortie ) == $i ) ? ('selected="selected"' ) : ('') ) ) );
			}

			// On recupere tous les groupes existants
			$query = $Bdd->sql('SELECT id, nom, description FROM '.PT.'_groupe' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$gpps2 = explode ( ';' , $infos['groupes'] );
				$gpps = explode ( ';' , $infos['add_comment_groupe'] );
			
				$template->assign_block_vars ( 'add_file.gps' , array ( 'TXT' => DOWNLOAD_GROUPSF_ALLOWED, 'TXTCOM' => DOWNLOAD_GROUPSC_ALLOWED ) );
				$template->assign_block_vars ( 'add_file.gps2' , array ( 'TXT' => DOWNLOAD_GROUPSF_ALLOWED, 'TXTCOM' => DOWNLOAD_GROUPSC_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_file.gps.gp' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => ( ( in_array ( '0' , $gpps ) ) ? ( 'checked="checked"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.gps.gp.def' , array ( 'DEF' => DOWNLOAD_ALL_USER ) );
				
				$template->assign_block_vars ( 'add_file.gps2.gp' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => ( ( in_array ( '0' , $gpps2 ) ) ? ( 'checked="checked"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.gps2.gp.def' , array ( 'DEF' => DOWNLOAD_ALL_USER ) );
				
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					$template->assign_block_vars ( 'add_file.gps.gp' , array (
					'NOM' => $sql['nom'],
					'ID' => $sql['id'],
					'CHECKED' => ( ( in_array ( $sql['id'] , $gpps ) ) ? ( 'checked="checked"' ) : ('') ) ) );
					if ( $sql['description'] != '' )
						$template->assign_block_vars ( 'add_file.gps.gp.def' , array ( 'DEF' => $sql['description'] ) );
					
					$template->assign_block_vars ( 'add_file.gps2.gp' , array (
					'NOM' => $sql['nom'],
					'ID' => $sql['id'],
					'CHECKED' => ( ( in_array ( $sql['id'] , $gpps2 ) ) ? ( 'checked="checked"' ) : ('') ) ) );
					if ( $sql['description'] != '' )
						$template->assign_block_vars ( 'add_file.gps2.gp.def' , array ( 'DEF' => $sql['description'] ) );
				}
			}
			
			// On recupere tous les grades existants
			$query = $Bdd->sql('SELECT id, name FROM '.PT.'_grades' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$gdds2 = explode ( ';' , $infos['grades'] );
				$gdds = explode ( ';' , $infos['add_comment_grade'] );
				
				$template->assign_block_vars ( 'add_file.gds' , array ( 'TXT' => DOWNLOAD_GRADESF_ALLOWED, 'TXTCOM' => DOWNLOAD_GRADESC_ALLOWED ) );
				$template->assign_block_vars ( 'add_file.gds2' , array ( 'TXT' => DOWNLOAD_GRADESF_ALLOWED, 'TXTCOM' => DOWNLOAD_GRADESC_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_file.gds.gd' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => ( ( in_array ( '0' , $gdds ) ) ? ( 'checked="checked"' ) : ('') ) ) );
				$template->assign_block_vars ( 'add_file.gds2.gd' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => ( ( in_array ( '0' , $gdds2 ) ) ? ( 'checked="checked"' ) : ('') ) ) );
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					$template->assign_block_vars ( 'add_file.gds.gd' , array (
					'NOM' => $sql['name'],
					'ID' => $sql['id'],
					'CHECKED' => ( ( in_array ( $sql['id'] , $gdds ) ) ? ( 'checked="checked"' ) : ('') ) ) );
					$template->assign_block_vars ( 'add_file.gds2.gd' , array (
					'NOM' => $sql['name'],
					'ID' => $sql['id'],
					'CHECKED' => ( ( in_array ( $sql['id'] , $gdds2 ) ) ? ( 'checked="checked"' ) : ('') ) ) );
				}
			}
		}
	}
	else if ( isset ( $_GET['edit_cat'] ) ){
	
		// On récupère les infos de la catégorie en question
		$query = $Bdd->sql ( '
		SELECT
			nom,
			description,
			groupes,
			grades,
			password
		FROM
			'.PT.'_download_cat
		WHERE
			id="'.intval ( $_GET['edit_cat'] ).'"' );
		$infos = $Bdd->get_array ( $query );
		
		if ( isset ( $_POST['contenu'] ) ){
		
			if ( strlen ( $_POST['title'] ) < 3 ){
				$template->assign_block_vars ( 'add_cat_valid' , array (
				'TXT' => DOWNLOAD_BIG_TITLE_PLEASE,
				'URL' => '',
				'BACK' => back ) );
			}
			else{
			
				$groupes = '';
				$query = $Bdd->sql('SELECT id FROM '.PT.'_groupe' );
				while ( $sql = $Bdd->get_array ( $query ) ){
					if ( isset ( $_POST['gps_'.$sql['id']] ) )
						$groupes .= $sql['id'].';';
				}
				if ( $groupes == '' )
					$groupes = '0;';
					
				$grades = '';
				$query = $Bdd->sql('SELECT id FROM '.PT.'_grades' );
				while ( $sql = $Bdd->get_array ( $query ) ){
					if ( isset ( $_POST['gds_'.$sql['id']] ) )
						$grades .= $sql['id'].';';
				}
				if ( $grades == '' )
					$grades = '0;';

				// On commence par mettre a jour cette catégorie
				$Bdd->sql ( '
				UPDATE '.PT.'_download_cat SET
					nom="'.$Bdd->secure ( $_POST['title'] ).'",
					description="'.$Bdd->secure ( $_POST['contenu'] ).'",
					groupes="'.$groupes.'",
					grades="'.$grades.'"
				WHERE
					id="'.intval($_GET['edit_cat']).'"' );

				// Si mot de passe défini, on le redéfini également ;)
				if ( $_POST['password'] == '' )
					$password = '';
				else
					$password = md5 ( $_POST['password'] );
				$Bdd->sql ( '
				UPDATE '.PT.'_download_cat SET
				password="'.$password.'"
				WHERE id="'.intval($_GET['edit_cat']).'"' );
					
				// On récupère toutes les catégories enfants qui ont hérités les secu de la
				$sub = $Bdd->sql ('
				SELECT
					id,
					groupes,
					grades,
					password
				FROM '.PT.'_download_cat
				WHERE parent="'.intval ( $_GET['edit_cat'] ).'"');
				
				$to_edit = array ();
				
				while ( $sb = $Bdd->get_array ( $sub ) ){
					// SI hérites ?
					if ( 
						$sb['groupes'] == $infos['groupes']
						AND
						$sb['grades'] == $infos['grades']
						AND
						$sb['password'] == $infos['password']
					)
					$to_edit[] = $sb['id'];
				}
				
				if ( count ( $to_edit ) > 0 ){
					// On met a jour tout ca ;)
					$idss = '(';
					foreach ( $to_edit AS $idz ){
						$idss .= $idz.',';
					}
					$idss = substr ( $idss , 0 , strlen ( $idss ) - 1 );
					$idss .= ')';
					
					$Bdd->sql ( '
					UPDATE '.PT.'_download_cat SET
					password="'.$password.'",
					groupes="'.$groupes.'",
					grades="'.$grades.'"
					WHERE id IN '.$idss );
				}
					
				$template->assign_block_vars ( 'add_cat_valid' , array (
					'TXT' => DOWNLOAD_CAT_EDITED_SUCCESSFULLY,
					'URL' => 'index.php?mods=download&amp;page=admin',
					'BACK' => back ) );
			}
		}
		else{
			$template->assign_block_vars ( 'add_cat_form' , array (
			'TITLE' => title,
			'TITLE_VALUE' => $infos['nom'],
			'DESCRIPTION' => DOWNLOAD_CAT_DESCRIPTION,
			'FORM' => default_form( FALSE , NULL , to_html ( $infos['description'] ) , 50 ),
			'SECURITY' => DOWNLOAD_SECURITY_OPTIONS,
			'PASSWORD' => DOWNLOAD_PASSWORD,
			'VALID' => valid ) );
			
			// On recupere tous les groupes existants
			$query = $Bdd->sql('SELECT id, nom, description FROM '.PT.'_groupe' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$gpps = explode ( ';' , $infos['groupes'] );
			
				$template->assign_block_vars ( 'add_cat_form.gps' , array ( 'TXT' => DOWNLOAD_GROUPS_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_cat_form.gps.gp' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => ( ( in_array ( '0' , $gpps ) ) ? ('checked="checked"') : ('') ) ) );
				$template->assign_block_vars ( 'add_cat_form.gps.gp.def' , array ( 'DEF' => DOWNLOAD_ALL_USER ) );
				
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					$template->assign_block_vars ( 'add_cat_form.gps.gp' , array (
					'NOM' => $sql['nom'],
					'ID' => $sql['id'],
					'CHECKED' => ( ( in_array ( $sql['id'] , $gpps ) ) ? ('checked="checked"') : ('') ) ) );
					if ( $sql['description'] != '' )
						$template->assign_block_vars ( 'add_cat_form.gps.gp.def' , array ( 'DEF' => $sql['description'] ) );
				}
			}
			
			// On recupere tous les grades existants
			$query = $Bdd->sql('SELECT id, name FROM '.PT.'_grades' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
			
				$gdds = explode ( ';' , $infos['grades'] );
			
				$template->assign_block_vars ( 'add_cat_form.gds' , array ( 'TXT' => DOWNLOAD_GRADES_ALLOWED ) );
				
				$template->assign_block_vars ( 'add_cat_form.gds.gd' , array (
					'NOM' => DOWNLOAD_EVERYONE,
					'ID' => 0,
					'CHECKED' => ( ( in_array ( '0' , $gdds ) ) ? ('checked="checked"') : ('') ) ) );
				
				while ( $sql = $Bdd->get_array ( $query ) )
					$template->assign_block_vars ( 'add_cat_form.gds.gd' , array (
					'NOM' => $sql['name'],
					'ID' => $sql['id'],
					'CHECKED' => ( ( in_array ( $sql['id'] , $gdds ) ) ? ('checked="checked"') : ('') ) ) );
			
			}
		}
	}
	else if ( isset ( $_GET['del_comment'] ) ){
		// On retire le vote du fichier
		$query = $Bdd->sql ( 'SELECT parent,note FROM '.PT.'_download_comments WHERE id="'.intval ( $_GET['del_comment'] ).'"' );
		$sql = $Bdd->get_array ( $query );
		$note = $sql['note'];
		$parent = $sql['parent'];
		$Bdd->free_result ( $query );
		
		$query = $Bdd->sql ( 'SELECT votes FROM '.PT.'_download_files WHERE id="'.$parent.'"' );
		$sql = $Bdd->get_array ( $query );
		$votes = explode ( ';' , $sql['votes'] );
		$new_votes = array();
		$a = 0;
		foreach ( $votes AS $vt ){
			if ( $vt == $note AND $a == 0){
				$a = 1;
			}
			else{
				$new_votes[] = $vt;
			}
		}
		$vt = implode ( ';' , $new_votes );
		$Bdd->sql ( 'UPDATE '.PT.'_download_files SET votes = "'.$vt.'" WHERE id="'.$parent.'"' );
		// On supprime le comment
		$Bdd->sql ( 'DELETE FROM '.PT.'_download_comments WHERE id="'.intval ( $_GET['del_comment'] ).'"' );
		// Et on le dit =)
		$template->assign_block_vars ( 'add_cat_valid' , array (
			'TXT' => DOWNLOAD_COMMENT_DELETED_SUCCESSFULLY,
			'URL' => 'index.php?mods=download&amp;page=viewfile&amp;id='.$parent,
			'BACK' => back ) );
	}
	else if ( isset ( $_GET['edit_comment' ] ) ){
		if ( isset ( $_POST['contenu' ] ) ){
			$query = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_comments WHERE id="'.intval ( $_GET['edit_comment'] ).'"' );
			$sql = $Bdd->get_array ( $query );
			$parent = $sql['parent'];
			$Bdd->free_result ( $query );
			
			$Bdd->sql ( 'UPDATE '.PT.'_download_comments SET contenu="'.$Bdd->secure ( $_POST['contenu'] ).'" WHERE id="'.intval ( $_GET['edit_comment'] ).'"' );
			$template->assign_block_vars ( 'add_cat_valid' , array (
				'TXT' => DOWNLOAD_COMMENT_EDITED_SUCCESSFULLY,
				'URL' => 'index.php?mods=download&amp;page=viewfile&amp;id='.$parent,
				'BACK' => back ) );
		}
		else{
		
			$query = $Bdd->sql ( 'SELECT parent,contenu FROM '.PT.'_download_comments WHERE id="'.intval ( $_GET['edit_comment'] ).'"' );
			$sql = $Bdd->get_array ( $query );
			$parent = $sql['parent'];
			$Bdd->free_result ( $query );

			$template->assign_block_vars ( 'edit_comment_form' , array (
			'FORM' => default_form ( FALSE , NULL , to_html ( $sql['contenu' ] ) ),
			'URL' => 'index.php?mods=download&amp;page=viewfile&amp;id='.$parent,
			'BACK' => back ) );
			
		}
	}
	else{
	
		$template->assign_block_vars ( 'index' , array (
			'ADD_MAIN_CAT' => DOWNLOAD_ADD_MAIN_CAT,
			'HOWTO_ADD_SUB_AND_FILES' => DOWNLOAD_HOWTO_ADD_SUB_AND_FILES,
			'HOWTO_ADD_SUB_AND_FILES_TXT' => nl2br ( DOWNLOAD_HOWTO_ADD_SUB_AND_FILES_TXT )
		) );
	
	}
	
	$template->set_filename ( 'bas_mods.tpl' );

}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}

?>