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
if ($grade != 4){ 
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
else{

	$template->set_filename ( 'haut_mods.tpl' );	
	$template->set_filename ( './modules/admin/interface.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array (
	'TITRE' => ADMIN_INTERFACE ) );

	//Si l'user fait une action
	if(isset($_GET['action'])){
	
		// Sécurité
		$action = htmlspecialchars($_GET['action'],ENT_QUOTES);
		// Si action + nom du bloc alors ca veut dire qu'il veut ajouter bloc
		if($action=='newbloc'AND $_GET['bloc'] != '' ){
		
			$logs->add_event ( HAS_ADDED_BLOC , ADMIN_INTERFACE );
		
			// Sécurité
			$bloc = htmlspecialchars($_GET['bloc'],ENT_QUOTES);
			
			$query = $Bdd->sql ( 'SELECT position FROM '.PT.'_blocs ORDER BY position DESC LIMIT 0,1' );
			$sql = $Bdd->get_array ( $query );
			$position = $sql['position'];
			$Bdd->free_result ( $query );
			
			// On regarde si le bloc existe pour ne pas avoir d'erreur par la suite
			if(file_exists('mods/'.$bloc.'/bloc.php')){
				
				// Si ca existe, on ajoute 1 au compteur position
				$new_pos = $position + 1;
				// On insére en bdd
				$Bdd->sql ('INSERT INTO '.PT.'_blocs VALUES ("","'.$bloc.'","'.$bloc.'","1","'.$new_pos.'" , "left")' );
				// On sup cache contenant info sur la position des modules
				$Bdd->delete_cached_data('bloc' );

				$template->assign_block_vars ( 'text' , array (
				'TXT' => BLOC_ADDED_SUCCESSFULLY,
				'URL' => 'index.php?mods=admin&page=interface',
				'BACK' => back ) );

			}
			else if ( substr ( $bloc , 0 , 4 ) == 'auto' ){
				//si ca existe, on ajoute 1 au compteur position
				$new_pos = $position + 1;
				//on insére en bdd
				$n = explode ( '-' , $bloc);
				$name = $n[4];
				$name = substr ( $name , 0 , strlen ( $name ) - 4 );
				$Bdd->sql ('INSERT INTO '.PT.'_blocs VALUES ("","auto-'.$n[2].'-'.$n[3].'","'.$Bdd->secure ( $name ).'","1","'.$new_pos.'" , "left")' );
				//on sup cache contenant info sur la position des modules
				$Bdd->delete_cached_data('bloc' );
				
				$template->assign_block_vars ( 'text' , array (
				'TXT' => BLOC_ADDED_SUCCESSFULLY,
				'URL' => 'index.php?mods=admin&page=interface',
				'BACK' => back ) );
			}
		}
		elseif($action=='moddem'AND $_GET['dem'] != '' ){
		
			$logs->add_event ( HAS_UPDATED_MODDEM , ADMIN_INTERFACE );
		
			$mod_dem = htmlspecialchars($_GET['dem'],ENT_QUOTES);
			if(file_exists('mods/'.$mod_dem.'/index.php')){
				//on modifie en bdd
				$Bdd->sql ('UPDATE '.PT.'_parametres SET '.PT.'_parametres.valeur="'.$mod_dem.'" WHERE '.PT.'_parametres.nom ="mod_acc" ' );
				//on sup cache contenant info sur la position des modules

				$template->assign_block_vars ( 'text' , array (
				'TXT' => BOOT_MOD_UPDATED,
				'URL' => 'index.php?mods=admin&page=interface',
				'BACK' => back ) );
				$Bdd->delete_cached_data('config' );
			}
			else if ( substr ( $mod_dem , 0 , 10 ) == 'auto-free-' AND file_exists ( './mods/free_page/'.substr ( $mod_dem , 10 , strlen ( $mod_dem ) ).'.php' ) ){
				//on modifie en bdd
				$Bdd->sql ('UPDATE '.PT.'_parametres SET '.PT.'_parametres.valeur="'.$mod_dem.'" WHERE '.PT.'_parametres.nom ="mod_acc" ' );
				//on sup cache contenant info sur la position des modules
				
				$template->assign_block_vars ( 'text' , array (
				'TXT' => BOOT_MOD_UPDATED,
				'URL' => 'index.php?mods=admin&page=interface',
				'BACK' => back ) );

				$Bdd->delete_cached_data('config' );
			}
			else if ( substr ( $mod_dem , 0 , 10 ) == 'auto-text-' ){
			
				$pid = substr ( $mod_dem , 10 , strlen ( $mod_dem ) );
				
				$query = $Bdd->sql ( 'SELECT titre FROM '.PT.'_page WHERE id="'.$pid.'"' );
				
				if ( $Bdd->get_num_rows ( $query ) > 0 ){
				
					$Bdd->sql ('UPDATE '.PT.'_parametres SET '.PT.'_parametres.valeur="'.$mod_dem.'" WHERE '.PT.'_parametres.nom ="mod_acc" ' );
				
					$template->assign_block_vars ( 'text' , array (
					'TXT' => BOOT_MOD_UPDATED,
					'URL' => 'index.php?mods=admin&page=interface',
					'BACK' => back ) );

					$Bdd->delete_cached_data('config' );
				}
			
			}
		}
	}
	//Si on demande de supprimer
	else if(isset($_REQUEST['del'])){
	
	$logs->add_event ( HAS_DELETED_BLOC , ADMIN_INTERFACE );
	
	//on supprime en bdd et dans le cache puis on redirige
	$Bdd->sql('DELETE FROM '.PT.'_blocs WHERE id="'.intval($_REQUEST['del']).'"' );
	$Bdd->delete_cached_data('bloc' );
	
	$template->assign_block_vars ( 'text' , array (
	'TXT' => BLOC_DELETED_SUCCESSFULLY,
	'URL' => 'index.php?mods=admin&page=interface',
	'BACK' => back ) );

}
	
	else{
	
		$template->assign_block_vars ( 'index' , array (
		'JS' => '
			<script type="text/javascript">
				<!--
					//Allez on commence par un petit js pour confirmer la suppression d\'un bloc
					function del(id){
						var req = confirm(\''.ADMIN_DEL_BLOC.'\' );
						if(req == true){
							window.location.href = "index.php?mods=admin&page=interface&del=" + id;
						}
					}
					//Un petit js pour cacher ou pasla liste des blocs
					function addbloc(){
						if(document.getElementById(\'ttblok\').style.visibility == "hidden"){
							document.getElementById(\'ttblok\').style.visibility = "VISIBLE";
							document.getElementById(\'ttblok\').style.height = "";
						}
						else{
							document.getElementById(\'ttblok\').style.visibility = "hidden";
							document.getElementById(\'ttblok\').style.height = "0px";
						}
					}
					// Fonction pour cacher ou pas la liste des modules
					function changemod(){
						if(document.getElementById(\'moddem\').style.visibility == "hidden"){
							document.getElementById(\'moddem\').style.visibility = "visible";
							document.getElementById(\'moddem\').style.height = "";
						}
						else{
							document.getElementById(\'moddem\').style.visibility = "hidden";
							document.getElementById(\'moddem\').style.height = "0px";
						}
					}
					//Un petit Js(et oui encore) pour monter ou descendre un  bloc
					function up(idbloc,type,position,colonne){
						var xhr_object = null; 
				 
						if(window.XMLHttpRequest) // Navigateur Normal :
							xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
							xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
						var  data = "idbloc=" + idbloc + "&type=" + type + "&position=" + position + "&id='.$uid.'&pass='.htmlspecialchars($_COOKIE['pass'],ENT_QUOTES).'+&colonne=" + colonne; 
				 
						xhr_object.open("POST", "./mods/admin/modifpos.php?move&time='.convertime(time()).'", true); 
				 
						xhr_object.onreadystatechange = function() { 
							if(xhr_object.readyState == 4) {
								document.location.reload();
							}
			            }
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
						xhr_object.send(data);
					}
					
					//Changement de colonne
					function col( idbloc , type ){
						var xhr_object = null; 
				 
						if(window.XMLHttpRequest) // Navigateur Normal :
							xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
							xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
						var  data = "idbloc=" + idbloc + "&type=" + type + "&id='.$uid.'&pass='.htmlspecialchars($_COOKIE['pass'],ENT_QUOTES).'"; 
				 
						xhr_object.open("POST", "./mods/admin/modifpos.php?colonne&time='.convertime(time()).'", true); 
				 
						xhr_object.onreadystatechange = function() { 
							if(xhr_object.readyState == 4) {
								document.location.reload();
							}
			            }
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
						xhr_object.send(data);
					}
					// Fonction pour rendre visible ou pas un bloc
					function cacher(idbloc,type){
						var xhr_object = null; 
				 
						if(window.XMLHttpRequest) // Navigateur Normal :
							xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
							xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
						var  data = "idbloc=" + idbloc + "&type=" + type + "&id='.$uid.'&pass='.htmlspecialchars($_COOKIE['pass'],ENT_QUOTES).'"; 
				 
						xhr_object.open("POST", "./mods/admin/modifpos.php?lol&time='.convertime(time()).'", true); 
				 
						xhr_object.onreadystatechange = function() { 
							if(xhr_object.readyState == 4) {
								document.location.reload();
							}
			            }
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
						xhr_object.send(data);
					}
				-->
			</script>',
		'NO_JS' => NO_JS,
		'ADD_BLOC' => ADD_BLOC,
		'ACTUAL_MOD' => ACTUAL_MOD,
		'MOD' => ( ( substr ( $mod_acc , 0 , 4 ) == 'auto' ) ? ( MANUAL_PAGE.' '.substr ( $mod_acc , 10 , strlen ( $mod_acc ) ) ) : ( $mod_acc ) ),
		'LISTEMOD' => LISTEMOD,
		'BLOC_LIST' => LISTEBLOC,
		'BLOCS_MANUAL' => BLOCS_MANUAL,
		'ADMIN_MOD_ACC' => ADMIN_MOD_ACC,
		'FREEPAGES_CREATED' => FREEPAGES_CREATED,
		'PAGES_CREATED' => TEXT_PAGES_CREATED,
		'BACK' => back ) );
		
		//Affiche les blocs 
		$req_blocs=$Bdd->sql('SELECT * FROM '.PT.'_blocs WHERE colonne="left" ORDER BY  position ASC' );
		//on définit la variable position
		$position_left = 0;
		while ( $result_blocs = $Bdd->get_object ( $req_blocs ) ){
			$template->assign_block_vars ( 'index.bloc' , array (
			'TITLE' => stripslashes ( $result_blocs->tbloc ) ) );
			//Si la position du bloc est différente de 1, alors on affiche image comme quoi on peut monter le bloc
			if  ( $result_blocs->position != 0 ){ 
				$template->assign_block_vars ( 'index.bloc.int' , array (
				'TYPE' => 'up',
				'ID' => $result_blocs->id,
				'TYPE2' => 'plus',
				'POSITION' => $result_blocs->position,
				'SRC' => './themes/'.$u_theme.'/img/admin/up.gif',
				'ALT' => UP_BLOC) );
				$template->assign_block_vars ( 'index.bloc.int' , array (
				'TYPE' => 'up',
				'ID' => $result_blocs->id,
				'TYPE2' => 'moins',
				'POSITION' => $result_blocs->position,
				'SRC' => './themes/'.$u_theme.'/img/admin/down.gif',
				'ALT' => DOWN_BLOC) );
			}
			else{
				$template->assign_block_vars ( 'index.bloc.int' , array (
				'TYPE' => 'up',
				'ID' => $result_blocs->id,
				'TYPE2' => 'moins',
				'POSITION' => $result_blocs->position,
				'SRC' => './themes/'.$u_theme.'/img/admin/down.gif',
				'ALT' => DOWN_BLOC) );
			}   
			//Si le bloc est affiché actuellement, on affiche image pour le cacher
			if ( $result_blocs->afficher == 1 ){
				$template->assign_block_vars ( 'index.bloc.hide' , array (
				'ID' => $result_blocs->id,
				'TYPE' => 0,
				'SRC' => './themes/'.$u_theme.'/img/admin/aff2.gif',
				'ALT' => INVISIBLE) );
			} 
			else 
			{
				$template->assign_block_vars ( 'index.bloc.hide' , array (
				'ID' => $result_blocs->id,
				'TYPE' => 1,
				'SRC' => './themes/'.$u_theme.'/img/admin/aff1.gif',
				'ALT' => VISIBLE) );
			}
			$template->assign_block_vars ( 'index.bloc.del' , array (
			'ID' => $result_blocs->id,
			'ALT' => delete ) );
			$template->assign_block_vars ( 'index.bloc.col' , array (
			'ID' => $result_blocs->id ) );

			//on incrémente a chaque bloc, utilie si on ajoute un nouveau bloc
			$position_left++;
		}
		
		//Affiche les blocs 
		$req_blocs=$Bdd->sql('SELECT * FROM '.PT.'_blocs WHERE colonne="right" ORDER BY  position ASC' );
		//on définit la variable position
		$position_right = 0;
		while ( $result_blocs = $Bdd->get_object ( $req_blocs ) ){
			$template->assign_block_vars ( 'index.bloc2' , array (
			'TITLE' => stripslashes ( $result_blocs->tbloc ) ) );
			//Si la position du bloc est différente de 1, alors on affiche image comme quoi on peut monter le bloc
			if  ( $result_blocs->position != 0 ){ 
				$template->assign_block_vars ( 'index.bloc2.int' , array (
				'TYPE' => 'up',
				'ID' => $result_blocs->id,
				'TYPE2' => 'plus',
				'POSITION' => $result_blocs->position,
				'SRC' => './themes/'.$u_theme.'/img/admin/up.gif',
				'ALT' => UP_BLOC) );
				$template->assign_block_vars ( 'index.bloc2.int' , array (
				'TYPE' => 'up',
				'ID' => $result_blocs->id,
				'TYPE2' => 'moins',
				'POSITION' => $result_blocs->position,
				'SRC' => './themes/'.$u_theme.'/img/admin/down.gif',
				'ALT' => DOWN_BLOC) );
			}
			else{
				$template->assign_block_vars ( 'index.bloc2.int' , array (
				'TYPE' => 'up',
				'ID' => $result_blocs->id,
				'TYPE2' => 'moins',
				'POSITION' => $result_blocs->position,
				'SRC' => './themes/'.$u_theme.'/img/admin/down.gif',
				'ALT' => DOWN_BLOC) );
			}   
			//Si le bloc est affiché actuellement, on affiche image pour le cacher
			if ( $result_blocs->afficher == 1 ){
				$template->assign_block_vars ( 'index.bloc2.hide' , array (
				'ID' => $result_blocs->id,
				'TYPE' => 0,
				'SRC' => './themes/'.$u_theme.'/img/admin/aff2.gif',
				'ALT' => INVISIBLE) );
			} 
			else 
			{
				$template->assign_block_vars ( 'index.bloc.hide' , array (
				'ID' => $result_blocs->id,
				'TYPE' => 1,
				'SRC' => './themes/'.$u_theme.'/img/admin/aff1.gif',
				'ALT' => VISIBLE) );
			}
			$template->assign_block_vars ( 'index.bloc2.del' , array (
			'ID' => $result_blocs->id,
			'ALT' => delete ) );
			$template->assign_block_vars ( 'index.bloc2.col' , array (
			'ID' => $result_blocs->id ) );
			//on incrémente a chaque bloc, utilie si on ajoute un nouveau bloc
			$position_right++;
		}

		if ( substr ( $mod_acc , 0 , 10 ) == 'auto-text-' ){
			// On recupere le titre du module d'accueil si jamais celui ci est une page crée manuellement en bdd ;)
			$query = $Bdd->sql ( 'SELECT titre FROM '.PT.'_page WHERE id="'.substr ( $mod_acc , 10 , strlen ( $mod_acc ) ).'"' );
			$sql = $Bdd->get_array ( $query );
			$titre = $sql ['titre' ];
			$mod_acc = 'auto_text-'.$titre;
		}

		$rep=opendir('./mods/' );
		while ($file = readdir($rep)) {
			if($file != '..' && $file !='.' && $file !=''){
				if (is_dir("mods/".$file) and (file_exists('mods/'.$file.'/bloc.php')==1) && substr($file,-5)!= '{N-I}'){
					if ( file_exists ( 'mods/'.$file.'/install_def.php' ) ){
						include ( './mods/'.$file.'/install_def.php' );
						$name = ${'mod_name_'.$u_lang} ;
					}
					else{
						$name = $file;
					}
					$template->assign_block_vars ( 'index.blocs' , array (
					'URL' => 'index.php?mods=admin&amp;page=interface&amp;action=newbloc&amp;bloc='.$file,
					'NAME' => ucfirst ( $name ) ) );
				}
			}
		}
		//On ferme le repertoire
		closedir($rep);

		// On recupere les blocs crées par l'utilisateur
		$rep=opendir('./mods/free_bloc/' );
		while ($file = readdir($rep)) {
			if ( $file != '..' AND $file !='.' AND $file !='admin.php' AND $file != 'install_def.php' AND is_file ( './mods/free_bloc/'.$file ) ){
					$name = explode ( '-' , $file );
					$name = $name[3];
					$name = substr ( $name , 0 , strlen ( $name ) - 4 );
					$template->assign_block_vars ( 'index.blocm' , array (
					'URL' => 'index.php?mods=admin&amp;page=interface&amp;action=newbloc&amp;bloc=auto-'.$file,
					'NAME' => ucfirst ( $name ) ) );
			}
		}
		//On ferme le repertoire
		closedir($rep);

		$rep = opendir('./mods' );
		while ($file = readdir($rep)) {
			if($file != '..' && $file !='.' && $file !=''){
				if (is_dir("mods/".$file) and (file_exists('mods/'.$file.'/index.php')==1) && substr($file,-5)!= '{N-I}'){
					if ( file_exists ( 'mods/'.$file.'/install_def.php' ) ){
						include ( './mods/'.$file.'/install_def.php' );
						$name = ${'mod_name_'.$u_lang} ;
					}
					else{
						$name = $file;
					}
					$template->assign_block_vars ( 'index.mods' , array (
					'URL' => 'index.php?mods=admin&amp;page=interface&amp;action=moddem&amp;dem='.$file,
					'NAME' => ucfirst ( $name ) ) );
				}
			}
		}
		//On ferme le repertoire
		closedir($rep);
		
		$dir = opendir ( './mods/free_page/' );
		while ( $file = readdir ( $dir ) ){
			if ( $file != '.' AND $file != '..' AND is_file ( './mods/free_page/'.$file ) AND $file != 'index.php' AND $file != 'install_def.php' AND $file != 'admin.php' ){
				$file = substr ( $file , 0 , strlen ( $file ) - 4 );
				$template->assign_block_vars ( 'index.freem' , array (
				'URL' => 'index.php?mods=admin&amp;page=interface&amp;action=moddem&amp;dem=auto-free-'.$file,
				'NAME' => ucfirst ( $name ) ) );
				$a = TRUE;
			}
		}
		closedir ( $dir );

		$sql=$Bdd->sql('SELECT id , titre FROM '.PT.'_page' );
		while ( $page = $Bdd->get_array ( $sql ) ){
			$template->assign_block_vars ( 'index.pagem' , array (
			'URL' => 'index.php?mods=admin&amp;page=interface&amp;action=moddem&amp;dem=auto-text-'.$page['id'],
			'NAME' => ucfirst ( $page['titre'] ) ) );
		}	
		
	}

	$template->set_filename ( 'bas_mods.tpl' );
}
?>
