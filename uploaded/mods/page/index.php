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

$template->set_filename ( 'haut_mods.tpl' );

if ( isset ( $_GET['id'] ) ){

	$sql = $Bdd->get_cached_data('SELECT titre,contenu FROM '.PT.'_page WHERE '.PT.'_page.id="'.intval($_GET['id']).'"',1000,'page' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => to_html ( $sql[0]['titre'] ) ) );
	$template->set_filename ( './modules/page/index.tpl' );
	$template->assign_block_vars ( 'page' , array( 'CONTENU' => to_html ( $sql[0]['contenu'] ) ) );
}
else{

	include_once ( './mods/free_page/langues/'.$u_lang.'.php' );

	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => INTERNAL_PAGES ) );
	$template->set_filename ( './modules/page/index.tpl' );
	$template->assign_block_vars ( 'index' , array ( 
	'PAGES_DISPO' => PAGES_DISPO ) );

	$sql=$Bdd->sql('SELECT id,titre FROM '.PT.'_page' );
	
	while ( $page = $Bdd->get_array ( $sql ) )
		$template->assign_block_vars ( 'index.pg' , array (
		'URL' => 'index.php?mods=page&amp;id='.$page['id'],
		'NOM' => to_html ( $page['titre'] ) ) );
	
	$a = FALSE;
	$dir = opendir ( './mods/free_page/' );
		while ( $file = readdir ( $dir ) ){
			if ( $file != '.' AND $file != '..' AND is_file ( './mods/free_page/'.$file ) AND $file != 'index.php' AND $file != 'install_def.php' AND $file != 'admin.php' ){
				$file = substr ( $file , 0 , strlen ( $file ) - 4 );
				$template->assign_block_vars ( 'index.pg' , array (
					'URL' => 'index.php?mods=free_page&amp;page='.$file,
					'NOM' => $file ) );
				$a = TRUE;
			}
		}
	closedir ( $dir );
	
	if ( $Bdd->get_num_rows ( $sql ) == 0 AND $a === FALSE )
		$template->assign_block_vars ( 'index.none' , array ( 'TXT' => NONE_PAGE ) );
}

$template->set_filename ( 'bas_mods.tpl' );

?>