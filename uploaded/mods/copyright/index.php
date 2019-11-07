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

$sql = $Bdd->get_cached_data('
	SELECT 
		question, sujet 
	FROM 
		'.PT.'_copy 
	WHERE 
		'.PT.'_copy.id="'.intval($_GET['id']).'"' , 1000 , 'copyright' );

$titre = stripslashes ( $sql[0]['question'] );
$contenu = stripslashes ( $sql[0]['sujet'] );

$template->set_filename ( 'haut_mods.tpl' );
$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => to_html ( $titre ) ) );

$template->set_filename ( './modules/copyright/index.tpl' );
$template->assign_block_vars ( 'copyright' , array ( 'CONTENU' => to_html ( $contenu ) ) );

$template->set_filename ( 'bas_mods.tpl' );

?>