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

// On verifie le grade.
$grades = explode ( ',' , $page_grade_admin );
if($grade==4 || in_array ( $grade , $grades , TRUE ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	
	//Suppression d'une page
	if ( isset ( $_REQUEST['del'] ) ){
		$Bdd->sql('DELETE  FROM '.PT.'_page WHERE id="'.intval ( $_GET['del'] ).'"' );
		$Bdd->delete_cached_data ( 'page' );
		
		$template->set_filename ( './modules/page/admin.tpl' );
		$template->assign_block_vars ( 'text' , array (
		'TXT' => PAGE_SUCCESSFULLY_DELETED,
		'URL' => 'index.php?mods=page&amp;page=admin',
		'BACK' => back ) );
	}
	else{
	
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => PAGE_ADMIN ) );
		$template->set_filename ( './modules/page/admin.tpl' );
		
		//Recuperation des pages depuis le cache
		$sql = $Bdd->get_cached_data ('
			SELECT 
				'.PT.'_page.id AS idpage,
				'.PT.'_page.titre AS titre,
				'.PT.'_page.contenu AS contenu 
			FROM 
				'.PT.'_page' , 1000 , 'page' );

		$template->assign_block_vars ( 'index' , array (
		'CREATE_PAGE' => CREATE_PAGE,
		'PAGE' => page,
		'MODIFY' => modify,
		'DEL' => delete,
		'BACK' => back ) );

		// Si il 'y a des pages alors on l'indique .
		if ( $Bdd->num_rows ( $sql ) > 0 ){
			//On traite les données.
			foreach($sql AS $page){
				$template->assign_block_vars ( 'index.pg' , array (
				'ID' => $page['idpage'],
				'NOM' => to_html ( $page['titre'] ) ) );
			}
		}
		// Si il n'y a aucune page alors on l'indique .
		else{
			$template->assign_block_vars ( 'index.none' , array ( 'TXT' => NONE_PAGE ) );
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