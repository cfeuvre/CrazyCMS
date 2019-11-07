<?php

// On récupere les informations relatives au fichier à télécharger ( miroirs et securites )
$query = $Bdd->sql ( '
SELECT
	file.mirrors AS miroirs,
	file.password AS password,
	file.parent AS parent,
	file.groupes AS gps,
	file.grades AS gds,
	file.nom AS nom
FROM
	'.PT.'_download_files AS file
WHERE
	file.id="'.intval ( $_GET['id'] ).'"
AND
	file.minimum_date < '.time().'
AND
	file.maximum_date > '.time() );
	
if ( $Bdd->get_num_rows ( $query ) != 0 ){
	
	$sql = $Bdd->get_array ( $query );
	$Bdd->free_result ( $query );

	
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
		if ( $sql['password'] == NULL OR ( isset ( $_COOKIE['download_pass_dl_'.intval ( $_GET['id'] ) ] ) AND $_COOKIE['download_pass_dl_'.intval ( $_GET['id'] ) ] == $sql['password'] ) )
			$secu3 = TRUE;

	
	if ( $grade == 4 OR ( ereg ( 'view_download_index' , $permissions ) AND $secu AND $secu2 AND $secu3 ) ){
	
		$template->set_filename ( 'haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => DOWNLOAD_ON_DOWNLOAD.to_html ( $sql['nom'] ) ) );
		
		// On met a jour les compteurs de dls
		$Bdd->sql ( 'UPDATE '.PT.'_download_files SET downloads = downloads + 1 WHERE id="'.intval ( $_GET['id'] ).'"' );
		
		$boucle = TRUE;
		
		$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET nb_downloads = nb_downloads + 1 WHERE id="'.$sql['parent'].'"' );
		
		$qp = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_cat WHERE id="'.$sql['parent'].'"' );
		$sql_parent = $Bdd->get_array ( $qp );
		
		if ( $sql_parent['parent'] == 0 )$boucle = FALSE;
		
		$parent = $sql_parent['parent'];
		
		while ( $boucle ){
		
			$qp = $Bdd->sql ( 'SELECT parent FROM '.PT.'_download_cat WHERE id="'.$parent.'"' );
			$Bdd->sql ( 'UPDATE '.PT.'_download_cat SET nb_downloads = nb_downloads + 1 WHERE id="'.$parent.'"' );
			
			$sq = $Bdd->get_array ( $qp );
			
			if ( $sq['parent'] != 0 )
				$parent = $sq['parent'];
			else
				$boucle = FALSE;
			
		}
		//
		
		$miroirs = explode ( '}' , htmlspecialchars ( $sql['miroirs'] ) );
		
		$template->set_filename ( './modules/download/dl.tpl' );
		
		$template->assign_block_vars ( 'dl' , array ( 
		'JS' => '
		<script type="text/javascript">
			<!--
				function redir ( url ){
					window.location.href = url;
				}
				setTimeout ( "redir(\''.$miroirs[0].'\')" , 2500 );
			-->
		</script>',
		'TXT' => DOWNLOAD_WILL_BEGIN_NOW,
		'MAIN_MIRROR' => $miroirs[0],
		'MIRRORS' => DOWNLOAD_SELECT_AN_OTHER_MIROR,
		'ID' => intval ( $_GET['id'] ),
		'BACK' => back) );
		
		foreach ( $miroirs AS $miroir ){
			if ( $miroir != NULL )$template->assign_block_vars ( 'dl.mirror' , array ( 'URL' => $miroir ) );
		}
		
		$template->set_filename ( 'bas_mods.tpl' );

	}
	else{
		// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );	
	}
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}

?>