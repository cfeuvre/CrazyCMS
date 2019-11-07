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

This software is governed by the CeCILL� license under French law and
abiding by the rules of distribution of free software.  You can  use, 
modify and/ or redistribute the software under the terms of the CeCILL�
license as circulated by CEA, CNRS and INRIA at the following URL
"http://www.cecill.info". 

The fact that you are presently reading this means that you have had
knowledge of the CeCILL� license and that you accept its terms.
*/
// On verifie le grade.
$grades = explode ( ',' , $page_grade_admin );
if($grade==4 || in_array ( $grade , $grades , TRUE ) )
{

	$template->set_filename ( 'haut_mods.tpl' );
	
	// On edite la oage.
	if(isset($_POST['contenu']) && isset($_POST['title']))
	{
		$contenu = $Bdd->secure($_POST['contenu']);
		$titre = $Bdd->secure($_POST['title']);
		// On modifie en BDD.
		$Bdd->sql('UPDATE '.PT.'_page SET titre="'.$titre.'",contenu="'.$contenu.'" WHERE id="'.intval($_GET['id']).'"' );
		// On supprimer le cache.
		$Bdd->delete_cached_data('page' );

		$template->set_filename ( './modules/page/post.tpl' );
		$template->assign_block_vars ( 'text' , array (
		'TXT' => PAGE_UPDATED_SUCCESSFULLY,
		'URL' => 'index.php?mods=page&amp;page=admin',
		'BACK' => back ) );
		
	}
	//On afficheur l'editeur Wysiwyg.	
	else
	{
		$cp = $Bdd->sql('
			SELECT 
				'.PT.'_page.id AS idpage,
				'.PT.'_page.titre AS titre,
				'.PT.'_page.contenu  AS contenu 
			FROM 
				'.PT.'_page 
			WHERE 
				'.PT.'_page.id="'.intval($_GET['id']).'"' );
		$pager = $Bdd->get_array ( $cp );
		
		$contenu1 = to_html ( $pager['contenu'] );
		$titre1 = to_html ( $pager['titre'] );
		
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => PAGE_EDIT_PAGE ) );
		$template->set_filename ( './modules/page/post.tpl' );
		$template->assign_block_vars ( 'form' , array (
		'FORM' => default_form( TRUE , $titre1 ,$contenu1 ),
		'URL' => 'index.php?mods=page&amp;page=admin',
		'BACK' => back ) );
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>