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
$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => MEMBER_LIST ) );

$last = $Bdd->sql ( '
	SELECT 
		id,
		pseudo  
	FROM 
		'.PT.'_users 
	WHERE 
		id!= 1 AND grades > 0
	ORDER BY 
		date_inscription DESC LIMIT 0,1' );
$var = $Bdd->get_array ( $last );

// Page actuelle
$user_par_page = 20;

if (isset($_GET['lien'])){
	$page = intval($_GET['lien']);
	$id_depart = ( $page * $user_par_page ) - $user_par_page;
}
else {
	$page = 1;
	$id_depart = 0;
}

$compt = $Bdd->sql('SELECT id FROM '.PT.'_users WHERE id!= 1 AND grades > 0' );
$compteur = $Bdd->get_num_rows ( $compt );

$pages = ceil ( $compteur / $user_par_page );

$template->set_filename ( './modules/liste/index.tpl' );
$template->assign_block_vars ( 'index' , array ( 
	'LAST_MEMBER_IS' => LISTE_LAST_MEMBER_IS,
	'LAST_MEMBER_ID' => $var['id'],
	'LAST_MEMBER_PSEUDO' => $var['pseudo'],
	'PAGE_ACTUELLE' => $page,
	'PSEUDO' => pseudo,
	'DATE_INSCRIPTION' => LISTE_INSCRIPTION,
	'LOCALISATION' => LISTE_LOCALISATION,
	'POSTS' => LISTE_POSTS,
	'WEBSITE' => LISTE_WEBSITE ) );

// Gestion du multipage.

// Liens pour changer de pages //
if ( $pages > 1 AND $pages < 15 ){

	// Si il y a moins de 15 pages, on peut se permettre d'afficher le lien vers chaque page ;)
	$template->assign_block_vars ( 'index.page' , array( 'PAGE' => page ) );

	for ( $i = 1; $i <= $pages; $i++ ){

		$size = 2;

		if ( $i == $page )$size = 5;
		if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
		if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

		$template->assign_block_vars ( 'index.page.pg' , array( 
		'URL' => './index.php?mods=liste'.( ( isset ( $_GET['pseudo'] ) ) ? ( '&amp;pseudo' ) : ('') ).( ( isset ( $_GET['post'] ) ) ? ( '&amp;post' ) : ('') ).( ( isset ( $_GET['date'] ) ) ? ( '&amp;date' ) : ('') ).'&amp;lien='.$i,
		'SIZE' => $size,
		'NM' => $i ) );
	}
}
else if ( $pages > 1 ){

	// Si il y a plus de 15 pages, on affiche uniquement les 8 pages autour de celle actuelle ainsi que les 3 premieres et les 3 dernieres
	$template->assign_block_vars ( 'index.page' , array( 'PAGE' => page ) );

	for ( $i = 1; $i <= 3; $i++ ){

		$size = 2;

		if ( $i == $page )$size = 5;
		if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
		if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

		$template->assign_block_vars ( 'index.page.pg' , array( 
		'URL' => './index.php?mods=liste'.( ( isset ( $_GET['pseudo'] ) ) ? ( '&amp;pseudo' ) : ('') ).( ( isset ( $_GET['post'] ) ) ? ( '&amp;post' ) : ('') ).( ( isset ( $_GET['date'] ) ) ? ( '&amp;date' ) : ('') ).'&amp;lien='.$i,
		'SIZE' => $size,
		'NM' => $i ) );

	}

	if ( $page <= 7 ){

		for ( $i = 4; $i <= 9; $i++ ){

			$size = 2;

			if ( $i == $page )$size = 5;
			if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
			if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

			$template->assign_block_vars ( 'index.page.pg' , array( 
			'URL' => './index.php?mods=liste'.( ( isset ( $_GET['pseudo'] ) ) ? ( '&amp;pseudo' ) : ('') ).( ( isset ( $_GET['post'] ) ) ? ( '&amp;post' ) : ('') ).( ( isset ( $_GET['date'] ) ) ? ( '&amp;date' ) : ('') ).'&amp;lien='.$i,
			'SIZE' => $size,
			'NM' => $i ) );
		}

		$template->assign_block_vars ( 'index.page.pg.etc' , array( 'PAGE' => page ) );

	}

	if ( $page > 7 AND $page < $pages -6 ){

		if ( $page > 10 )
			$template->assign_block_vars ( 'index.page.pg.etc' , array( 'PAGE' => page ) );

		for ( $i = $page - 4; $i <= $page + 4; $i++ ){

			$size = 2;

			if ( $i == $page )$size = 5;
			if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
			if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

			$template->assign_block_vars ( 'index.page.pg' , array( 
			'URL' => './index.php?mods=liste'.( ( isset ( $_GET['pseudo'] ) ) ? ( '&amp;pseudo' ) : ('') ).( ( isset ( $_GET['post'] ) ) ? ( '&amp;post' ) : ('') ).( ( isset ( $_GET['date'] ) ) ? ( '&amp;date' ) : ('') ).'&amp;lien='.$i,
			'SIZE' => $size,
			'NM' => $i ) );
		}

		if ( $page < $pages - 7 )
			$template->assign_block_vars ( 'index.page.pg.etc' , array( 'PAGE' => page ) );

	}

	if ( $page >= $pages -6 ){

		$template->assign_block_vars ( 'index.page.pg.etc' , array( 'PAGE' => page ) );

		for ( $i = $pages - 9; $i < $pages - 2; $i++ ){

			$size = 2;

			if ( $i == $page )$size = 5;
			if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
			if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

			$template->assign_block_vars ( 'index.page.pg' , array( 
			'URL' => './index.php?mods=liste'.( ( isset ( $_GET['pseudo'] ) ) ? ( '&amp;pseudo' ) : ('') ).( ( isset ( $_GET['post'] ) ) ? ( '&amp;post' ) : ('') ).( ( isset ( $_GET['date'] ) ) ? ( '&amp;date' ) : ('') ).'&amp;lien='.$i,
			'SIZE' => $size,
			'NM' => $i ) );
		}
	}

	for ( $i = $pages - 2; $i <= $pages; $i++ ){

		$size = 2;

		if ( $i == $page )$size = 5;
		if ( $i == $page - 1 OR $i == $page + 1)$size = 4;
		if ( $i == $page - 2 OR $i == $page + 2)$size = 3;

		$template->assign_block_vars ( 'index.page.pg' , array( 
		'URL' => './index.php?mods=liste'.( ( isset ( $_GET['pseudo'] ) ) ? ( '&amp;pseudo' ) : ('') ).( ( isset ( $_GET['post'] ) ) ? ( '&amp;post' ) : ('') ).( ( isset ( $_GET['date'] ) ) ? ( '&amp;date' ) : ('') ).'&amp;lien='.$i,
		'SIZE' => $size,
		'NM' => $i ) );
	}
}

///////////////////////////////////////////////////////////			

$order = 'date_inscription ASC';
if ( isset ( $_GET['pseudo'] ) )
	$order = 'pseudo';
if ( isset ( $_GET['date'] ) )
	$order = 'date_inscription ASC';
if ( isset ( $_GET['post'] ) )
	$order = 'nb_post';
	
	
$sql = $Bdd->sql('
	SELECT 
		id,
		pseudo,
		date_inscription,
		localisation,
		nb_post,
		site 
	FROM 
		'.PT.'_users 
	WHERE 
		id!= 1 AND grades > 0
	ORDER BY 
		'.$order.'
	LIMIT 
		'.$id_depart.' ,'.$user_par_page.'' );

while ($liste = $Bdd->get_array ( $sql ) ){
	$date=ccmsdate ( $fuseaux , $liste['date_inscription'] );

	if ( substr ( $liste['site'] , 0 , 7 ) != 'http://' AND strlen ( $liste['site'] ) > 5 )
		$liste['site'] = 'http://'.$liste['site'];
	
	$template->assign_block_vars ( 'index.mb' , array (
	'ID' => $liste['id'],
	'PSEUDO' => $liste['pseudo'],
	'DATE' => $date,
	'LOCALISATION' => $liste['localisation'],
	'POSTS' => $liste['nb_post'],
	'WEBSITE' => $liste['site'] ) );
}

$template->set_filename ( 'bas_mods.tpl' );

?>