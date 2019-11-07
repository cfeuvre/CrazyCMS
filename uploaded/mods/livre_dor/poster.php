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
if(!defined('CCMS'))die('' );

if ( $grade >= 1 ){

	$template->set_filename ( 'haut_mods.tpl' );

	$template->set_filename ( './modules/livre_dor/poster.tpl' );

	// si le formulaire à ete valide, on ajoute le comms ;)
	if ( isset ( $_POST['contenu'] ) ){

		$contenu = $Bdd->secure ( $_POST['contenu'] );
		$note = intval ( $_POST['note'] );
		if ( $note > 10 )$note = 10;
		if ( $note < 0 )$note = 0;
			
		if ( $livre_or_validation == 1 ){
			
			// On ajoute le commentaire
			$Bdd->sql('INSERT INTO '.PT.'_livredor VALUES("","'.intval($uid).'","'.$contenu.'","'.time().'","1","'.$note.'")' );
			
			// On indique au visiteur que le commentaires va etre valide ;)
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => VALIDATION ) );
			$template->assign_block_vars ( 'text' , array (
				'TXT' => COMMENT_WAITING,
				'BACK' => back ) );
		
		}
		else{
		
			// On ajoute le commentaire
			$Bdd->sql('INSERT INTO '.PT.'_livredor VALUES("","'.intval($uid).'","'.$contenu.'","'.time().'","0","'.$note.'")' );
		
			// On indique que le message à été validé
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => COMMENT_ADD ) );
			$template->assign_block_vars ( 'text' , array (
				'TXT' => COMMENT_ADDED,
				'BACK' => back ) );
		}			
	}
	else{
		// si le formulaire n'a point ete valide, on l'affiche ;)
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => add_comment ) );
		$template->assign_block_vars ( 'form' , array (
		'NOTE' => note,
		'ON_TEN' => ON_TEN,
		'FORM' => default_form( TRUE ) ) );
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => NEED_REGISTRATION ) );	
}
?>