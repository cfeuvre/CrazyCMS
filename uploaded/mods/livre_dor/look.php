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
if(isset($grade) && $grade==4){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => GOLDBOOK ) );

	$template->set_filename ( './modules/livre_dor/look.tpl' );

	// On affiche le commentaire que l'admin désire voir en entier
	$titre_mod = LVOR_ADMIN;
	$sql=$Bdd->sql('SELECT  '.PT.'_livredor.id AS idliv,'.PT.'_livredor.auteur AS auteur,'.PT.'_livredor.com AS com,'.PT.'_livredor.date AS date,'.PT.'_livredor.propose AS propose,'.PT.'_livredor.note AS note, '.PT.'_users.id AS id, '.PT.'_users.pseudo AS pseudo FROM '.PT.'_livredor, '.PT.'_users WHERE '.PT.'_livredor.id="'.intval($_GET['id']).'" AND '.PT.'_livredor.auteur='.PT.'_users.id' );
	$id=$Bdd->get_array($sql);
	$date = ccmsdate($fuseaux,$id['date']);
	
	$template->assign_block_vars ( 'look' , array (
			'MESS_FROM' => comments_from,
			'PSEUDO' => htmlspecialchars ( $id['pseudo'] ),
			'THE' => post_the,
			'DATE' => $date,
			'NOTE' => $id['note'],
			'ON_TEN' => ON_TEN,
			'COM' => to_html ( $id['com'] ),
			'BACK' => BACK_LVOR_ADMIN ) );

	$template->set_filename ( 'bas_mods.tpl' );
}
?>