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
	// On verifie l grade.
	$grades = explode ( ',' , $copyright_grade_admin );
	if($grade==4 || in_array ( $grade , $grades , TRUE ) )
	{
		$template->set_filename ( 'haut_mods.tpl' );
		$template->set_filename ( './modules/copyright/post.tpl' );
	
		// On edite le copyright.
		if(isset($_POST['contenu']) && isset($_POST['title']))
		{
			$contenu = $Bdd->secure($_POST['contenu']);
			$titre =$Bdd->secure($_POST['title']);
			
			// On modifie en BDD.
			$Bdd->sql('UPDATE '.PT.'_copy SET question="'.$titre.'",sujet="'.$contenu.'" WHERE '.PT.'_copy.id="'.intval($_GET['id']).'"' );
			// On supprimer le cache.
			$Bdd->delete_cached_data('copyright' );

			$template->assign_block_vars ( 'valid' , array (
			'TXT' => COPYRIGHT_PAGE_SUCCESSFULLY_UPDATED,
			'BACK' => back ) );
			
		}
		//On afficheur l'editeur Wyziwig.	
		else
		{
			$cp=$Bdd->sql('SELECT '.PT.'_copy.id AS idcop, '.PT.'_copy.question AS question, '.PT.'_copy.sujet  AS sujet FROM '.PT.'_copy WHERE '.PT.'_copy.id="'.intval($_GET['id']).'"' );
			$copyr=$Bdd->get_array($cp);
			$contenu = $copyr['sujet'];
			$titre = $copyr['question'];
			$template->assign_block_vars ( 'form' , array ( 'FORM' => default_form( TRUE , to_html ( $titre ) , to_html ( $contenu ) ) ) );
		}
		$template->set_filename ( 'bas_mods.tpl' );
	}
	else{
		// Si l'utilisateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}
?>