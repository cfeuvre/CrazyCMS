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
$template->set_filename ( './modules/livre_dor/bloc.tpl' , FALSE , $row['colonne'] );
$template->assign_bloc_name ( 'BLOC_LVOR_TITLE' , $row['tbloc'] );

include('./mods/livre_dor/langues/'.$u_lang.'.php' );
$query = $Bdd->sql('SELECT '.PT.'_livredor.com as com, '.PT.'_livredor.date as date, '.PT.'_livredor.note as note, '.PT.'_users.pseudo as auteur FROM '.PT.'_livredor, '.PT.'_users WHERE '.PT.'_users.id = '.PT.'_livredor.auteur AND '.PT.'_livredor.propose=0 ORDER BY RAND()' );
$sql = $Bdd->get_array($query);
if ( $Bdd->get_num_rows ( $query ) == 0 ){
	$template->assign_block_vars ( 'lvor_bloc_none' , array (
	'TXT' => no_comments ) );
}
else{
	$template->assign_block_vars ( 'lvor_bloc' , array (
	'BY' => by,
	'AUTEUR' => htmlspecialchars ( $sql['auteur'] ),
	'THE' => The,
	'DATE' => ccmsdate ( $fuseaux , $sql['date'] ),
	'COM' => to_html ( $sql['com'] ),
	'NOTE' => $sql['note'],
	'ON_TEN' => ON_TEN ) );
}
?>