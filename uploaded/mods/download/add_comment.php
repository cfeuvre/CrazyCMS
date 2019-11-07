<?php

// On récupre les information du fichier en question pour verifier que le fichier existe et que l'on a le droit d'ajouter des commentaires ;)
$query = $Bdd->sql ( '
SELECT
	file.add_comment AS add_comment,
	file.add_comment_groupe AS groupes,
	file.add_comment_grade AS grades,
	file.minimum_date AS min_date,
	file.maximum_date AS max_date,
	file.votes AS votes
FROM
	'.PT.'_download_files AS file
WHERE
		file.id = '.intval ( $_GET['id'] ) );
		
$grades_right = explode ( ',' , $download_grade_admin );

$ret = $Bdd->get_num_rows ( $query );
$sql = $Bdd->get_array ( $query );
$Bdd->free_result ( $query );

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

if ( ( $ret > 0 AND $sql['add_comment'] == 1 AND $secu AND $secu2 ) OR ( $grade == 4 OR in_array ( $grade , $grades_right , TRUE ) ) ){

	$template->set_filename ( 'haut_mods.tpl' );

	if ( !isset ( $_POST['contenu'] ) ){
	
		$template->set_filename ( './modules/download/add_comment.tpl' );
		$template->assign_block_vars ( 'form' , array (
		'NOTE' => DOWNLOAD_NOTE,
		'COMMENT' => DOWNLOAD_COMMENT,
		'FORM' => default_form ( ) ) );
		
		for ( $i = 0 ; $i <= 10 ; $i++ ){
			$template->assign_block_vars ( 'form.options' , array (
			'VALUE' => $i ) );
		}
	
	}
	else{
	
		$note = intval ( $_POST['note'] );
		if ( $note > 10 )
			$note = 10;
		if ( $note < 0 )
			$note = 0;
	
		$template->set_filename ( './modules/download/add_comment.tpl' );
		
		$template->assign_block_vars ( 'valid' , array (
		'TXT' => DOWNLOAD_COMMENT_ADDED_SUCCESSFULLY,
		'ID' => intval ( $_GET['id'] ),
		'BACK' => back ) );
	
		$Bdd->sql ( 'INSERT INTO '.PT.'_download_comments VALUES ( "" , "'.intval ( $_GET['id'] ).'" , "'.$uid.'" , "'.$Bdd->secure ( $_POST['contenu'] ).'" , "'.$note.'" , "'.convertime ( time() ).'" )' );
		$new_votes = $sql['votes'].$note.';';
		$Bdd->sql ( 'UPDATE '.PT.'_download_files SET votes="'.$new_votes.'" WHERE id="'.intval ( $_GET['id'] ).'"' );
	}
	
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
		// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>