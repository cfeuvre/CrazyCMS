<?php

// On ne peut recommander un fichier que si l'on est membre ;)
if ( $grade > 0 ){

	// On vérifie que ce fichier existe
	$query = $Bdd->sql ( 'SELECT id FROM '.PT.'_download_files WHERE id="'.intval ( $_GET['id'] ).'"' );
	
	if ( $Bdd->get_num_rows ( $query ) > 0 ){
		
		$Bdd->free_result ( $query );
		
		if ( isset ( $_POST['contenu'] ) ){
			
			// On vérifie que le destinataire existe
			$query = $Bdd->sql ( 'SELECT id FROM '.PT.'_users WHERE id="'.intval ( $_POST['user'] ).'"' );
			if ( $Bdd->get_num_rows ( $query ) > 0 ){
				if ( strlen ( $_POST['title'] ) < 3 OR strlen ( $_POST['contenu'] ) < 5 ){
					$template->set_filename('error_page.tpl' );
					$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => DOWNLOAD_COURT_MESSAGE ) );
				}
				else{
					$contenu = $Bdd->secure ( str_replace ( '{LIEN}' , '<a href="./index.php?mods=download&page=viewfile&id='.intval ( $_GET['id'] ).'">./index.php?mods=download&page=viewfile&id='.intval ( $_GET['id'] ).'</a>' , $_POST['contenu'] ) );
					$titre = $Bdd->secure ( $_POST['title'] );
					$destinataire = intval ( $_POST['user'] );
					// On envoi le MP ;)
					$Bdd->sql ( 'INSERT INTO '.PT.'_messagerie VALUES ( "" , "'.$destinataire.'" , "'.$uid.'" , "'.$titre.'" , "'.$contenu.'" , "'.convertime ( time() ).'" , "1" ) ' );
				
					$template->set_filename ( 'haut_mods.tpl' );
					
					$template->set_filename ( './modules/download/recommander.tpl' );
					$template->assign_block_vars ( 'success' , array (
					'TXT' => DOWNLOAD_RECOMMANDED_SUCCESSFULLY,
					'ID' => intval ( $_GET['id'] ),
					'BACK' => back ) );
					
					
					$template->set_filename ( 'bas_mods.tpl' );
				
				}
			}
			else{
				$template->set_filename('error_page.tpl' );
				$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => DOWNLOAD_MEMBER_DOESNT_EXIST ) );				
			}
		}
		else{
			$template->set_filename ( 'haut_mods.tpl' );
			
			
			$template->set_filename ( './modules/download/recommander.tpl' );
			$template->assign_block_vars ( 'reco' , array (
			'TXT' => DOWNLOAD_RECOMMAND,
			'USER_SELECT' => DOWNLOAD_CHOOSE_AN_USER,
			'FORM' => default_form ( TRUE , NULL , to_html ( $download_reco_mess ) ),
			'LIEN_REPLACE' => DOWNLOAD_LINK_WILL_BE_REPLACE,
			'ID' => intval ( $_GET['id'] ),
			'BACK' => back ) );
			
			// On charge la ( lourde ) liste des users
			$qu = $Bdd->sql ( 'SELECT id, pseudo FROM '.PT.'_users WHERE id != 1 ORDER BY pseudo' );
			while ( $su = $Bdd->get_array ( $qu ) ){
				$template->assign_block_vars ( 'reco.user_option' , array (
				'VALUE' => $su['id'],
				'NOM' => htmlspecialchars ( $su['pseudo'] ) ) );
			}
			$Bdd->free_result ( $qu );
			
			$template->set_filename ( 'bas_mods.tpl' );
		}
	
	}
	else{
		// Si le fichier n'existe pas, on envoie chier le mec tout simplement
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}

}
else{
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => DOWNLOAD_MUST_BE_MEMBER ) );
}

?>