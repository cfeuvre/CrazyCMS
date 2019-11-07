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

if($grade==4 || ereg("view_admin_cache;",$permissions)){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/admin/cache.tpl' );

	if ( isset ( $_GET['empty'] ) ){
	
		$logs->add_event ( HAS_EMPTIED_CACH , CACHE );
	
		$template->assign_block_vars ( 'text' , array (
		'TXT' => CACHE_EMPTIED_SUCCESSFULLY,
		'URL' => 'index.php?mods=admin&amp;page=cache',
		'BACK' => back ) );
		
		$dir = opendir ( './cache/cache/'.base64_decode ( $_GET['empty'] ).'/' );
		while ( $file = readdir ( $dir ) ){
			if ( $file != '.' AND $file != '..' AND is_file ( './cache/cache/'.base64_decode ( $_GET['empty'] ).'/'.$file ) ){
				@unlink ( './cache/cache/'.base64_decode ( $_GET['empty'] ).'/'.$file );
			}
		}
		closedir ( $dir );
	
	}
	else if ( isset ( $_GET['empty_all'] ) ){
	
		$logs->add_event ( HAS_EMPTIED_ALL_CACH , CACHE );
	
		$template->assign_block_vars ( 'text' , array (
		'TXT' => CACHE_EMPTIED_SUCCESSFULLY,
		'URL' => 'index.php?mods=admin&amp;page=cache',
		'BACK' => back ) );
		
		$dir = opendir ( './cache/cache/' );
		while ( $file = readdir ( $dir ) ){
			if ( $file != '.' AND $file != '..' AND is_dir ( './cache/cache/'.$file.'/' ) ){

				$size = 0;
				$dir2 = opendir ( './cache/cache/'.$file.'/' );
				while ( $file2 = readdir ( $dir2 ) ){
					if ( $file2 != '.' AND $file2 != '..' AND is_file ( './cache/cache/'.$file.'/'.$file2 ) ){
						@unlink ( './cache/cache/'.$file.'/'.$file2 );
					}
				}
				closedir ( $dir2 );
			}
		}
		closedir ( $dir );
	
	}
	else{

		$template->assign_block_vars ( 'index' , array ( 
		'CACHE_CONTENT' => CACHE_CONTENT,
		'NAME' => NAME,
		'SIZE' => SIZE,
		'EMPT' => EMPT,
		'EMPTY_ALL' => EMPTY_ALL,
		'BACK' => back ) );

		$dir = opendir ( './cache/cache/' );

		while ( $file = readdir ( $dir ) ){

			if ( $file != '.' AND $file != '..' AND is_dir ( './cache/cache/'.$file.'/' ) ){
			
				// On calcule la taille occupe par ce dossier ;)
				$size = 0;
				$dir2 = opendir ( './cache/cache/'.$file.'/' );
				while ( $file2 = readdir ( $dir2 ) ){
					if ( $file2 != '.' AND $file2 != '..' AND is_file ( './cache/cache/'.$file.'/'.$file2 ) ){
						$size = $size + filesize ( './cache/cache/'.$file.'/'.$file2 );
					}
				}
				closedir ( $dir2 );
				
				if ( $size < 1000 )
					$size = $size.' Octets';
				else if ( $size >= 1000 AND $size < 1000000 )
					$size = round ( $size / 1000 , 2 ).' Kilo-Octets';
				else if ( $size >= 1000000 )
					$size = round ( $size / 1000000 , 2 ).' Mega-Octets';
			
				$template->assign_block_vars ( 'index.mod' , array (
				'FILE' => ucfirst ( $file ),
				'SIZE' => $size,
				'HREF' => 'index.php?mods=admin&amp;page=cache&amp;empty='.base64_encode ( $file ),
				'EMPT' => EMPT ) );
			}
		}
		closedir ( $dir );	
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>