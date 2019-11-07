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
		$template->set_filename ( './modules/copyright/admin.tpl' );
	
		//Suppression d'un Copyright .
		if(isset($_REQUEST['del'])){
			$Bdd->sql('DELETE  FROM '.PT.'_copy WHERE id="'.intval($_REQUEST['del']).'"' );
			$Bdd->delete_cached_data('copyright' );
			$template->assign_block_vars ( 'del' , array (
			'TXT' => COPYRIGHT_DELETED,
			'BACK' => back ) );
		}
		else{
			$template->assign_block_vars ( 'copyright' , array (
			'WHATS_COP_PAGE' => COPYRIGHT_WHATS_COP_PAGE,
			'WHATS_COP_PAGE_TXT' => COPYRIGHT_WHATS_COP_PAGE_TXT,
			'ADD_PAGE' => COPYRIGHT_ADD_PAGE,
			'BACK' => back ) );
			
			$sql = $Bdd->get_cached_data ('
			SELECT 
				'.PT.'_copy.id AS idcopy,
				'.PT.'_copy.question AS question,
				'.PT.'_copy.sujet AS sujet
			FROM 
				'.PT.'_copy' , 1000 , 'copyright' );

			// Si il 'y a des copy alors on l'indique .
			if($Bdd->num_rows($sql)>0){
				$template->assign_block_vars ( 'copyright.cops' , array (
				'TITLE' => title,
				'MODIF' => modify,
				'DEL' => delete ) );
				//On traite les données.
				foreach($sql AS $id=>$copy){
				
					$template->assign_block_vars ( 'copyright.cops.cop' , array (
					'TITLE' => to_html ( $copy['question'] ),
					'ID' => $copy['idcopy'] ) );
				}
			}
			// Si il n'y a aucun copyright alors on l'indique .
			else
			{
				$template->assign_block_vars ( 'copyright.none_cops' , array ( 'TXT' => COPYRIGHT_NONE_COPS ) );
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