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
	$grades = explode ( ',' , $copyright_grade_admin );
	if($grade==4 || in_array ( $grade , $grades , TRUE ) )
	{
		$template->set_filename ( 'haut_mods.tpl' );
		$template->set_filename ( './modules/copyright/post.tpl' );
		// Ajout du copyright.
		if(isset($_POST['contenu']) && isset($_POST['title']))
		{
			$contenu = $Bdd->secure($_POST['contenu']);
			$titre = $Bdd->secure($_POST['title']);
			
			//On l'insert en BDD.
			$Bdd->sql('INSERT INTO '.PT.'_copy VALUES ("","'.$titre.'","'.$contenu.'")' );
			
			// On supprime le cache.
			$Bdd->delete_cached_data('copyright' );

			$template->assign_block_vars ( 'valid' , array (
			'TXT' => COPYRIGHT_PAGE_SUCCESSFULLY_ADDED,
			'BACK' => back ) );

		}
		// Affichage du formulaire
		else 
		{
			$template->assign_block_vars ( 'form' , array ( 'FORM' => default_form( TRUE ) ) );
		}
		$template->set_filename ( 'bas_mods.tpl' );
	}
	else{
		// Si l'utilisateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}


?>
