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
if($grade==4 || ereg("view_admin_gene;",$permissions)){

	$template->set_filename ( 'haut_mods.tpl' );	
	$template->set_filename ( './modules/admin/admin_mod.tpl' );

	if ( isset ( $_POST['mods_all'] ) ){
	
		$logs->add_event ( HAS_UPDATED_ACCESS , GEN_ADMIN );
	
		$template->assign_block_vars ( 'text' , array (
		'TXT' => updated_successfully,
		'BACK' => back ) );
	
		$modss = explode ( '/' , $_POST['mods_all'] );
		foreach ( $modss as $mod ){
			if ( $mod != '' ){
			
				$GRADE = '';
				if(isset($_POST[$mod.'GRADE_0']))$GRADE .= '0,-1,-5,-6,';
				
				for ( $i = 1 ; $i < $nb_total_grades ; $i++ ) {
					if ( $i != 4 ){
						if(isset($_POST[$mod.'GRADE_'.$i]))$GRADE .= $i.',';
					}
				}

				$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$GRADE.'" WHERE nom="'.$mod.'_grade_admin"' );
			
			}		
		}	
		$Bdd->delete_cached_data ( 'config' );
	}
	else{

		$template->assign_block_vars ( 'index' , array (
		'MODULE' => MODULE,
		'MIN_RANK' => MIN_RANK,
		'UPDATE' => update,
		'BACK' => back ) );
						
		for ( $i = 0 ; $i < $nb_total_grades ; $i++ ) {
			if ( $i != 4 ){
				$template->assign_block_vars ( 'index.rank' , array ( 'TXT' => ${'grade_'.$i}['name'] ) );
			}
		}

		$handle = opendir ( './mods/' ); 
		$var ='';
		while (($file = readdir())!=false) { 
			clearstatcache(); 
			$mod_see_admin = $file.'_grade_admin';
			
			if($file!=".." && $file!="." && isset ( ${$mod_see_admin} ) && file_exists('./mods/'.$file.'/admin.php') && substr ( $file , -5 ) != '{N-I}' )
			{

				// On affiche que module fonctionnant avec ce systeme ;)
				if ( isset ( ${$mod_see_admin} ) ) {
				$grade_see_admin = ${$mod_see_admin};
				$grades = explode ( ',' , $grade_see_admin );
				unset ( $grades[ count($grades) - 1 ] );

				$template->assign_block_vars ( 'index.mod' , array ( 'NAME' => ucfirst ( str_replace ( '_' , ' ' , $file ) ) ) );
				
					for ( $i = 0 ; $i < $nb_total_grades ; $i++ ) {
						if ( $i != 4 ){
							$template->assign_block_vars ( 'index.mod.poss' , array (
							'NAME' => $file.'GRADE_'.$i,
							'CHECKED' => ( (in_array( $i ,array_values($grades)  ) && $grade_see_admin != '' ) ? ('checked="checked"') : ('') ) ) );
						}
					}
					$var .= $file.'/';
				}
			}
		}
		$template->assign_block_vars ( 'index.input' , array ( 'VAR' => $var ) );
		closedir($handle); 
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>