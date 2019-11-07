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
if($grade == 4 ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array (
	'TITRE' => GESTION_ALERT ) );
	
	$template->set_filename ( './modules/admin/galerte.tpl' );

	/*
	if(!isset($_GET['modif']) && !isset($_GET['add'])){
	$cont = '<p align="center"><a href="index.php?mods=admin&amp;page=galerte&amp;add">'.ADD_ALERTE.'</a></p>';
		$cont .='<form action="?mods=admin&amp;page=galerte&amp;modif" method="post">
		<p>'.DEFAULT_ALERT.':</p>
		<textarea name="default_alerte" rows="8" cols="15">'.$default_alert.'</textarea>';
		$all_alerte = $alerte->messAlerte();
		ksort($all_alerte);
		
		foreach($all_alerte AS $mod=>$alerte){
			if($mod != "default_alert"){
				$cont .= '<p>'.$mod.'</p>
				<textarea name="'.$mod.'" rows="8" cols="15">'.$alerte.'</textarea>';
			}
		}
		$cont .= '<p align="center"><input type="submit" value="'.SEND.'" /></p></form>';
	}
	else if(!isset($_GET['add']) && isset($_GET['modif'])){
	
	foreach($_POST AS $mod1=>$alerte1){
	if($mod1 != '')		$alerte->modifAlerte(htmlspecialchars($alerte1,ENT_QUOTES),htmlspecialchars($mod1,ENT_QUOTES));
	}
	$Bdd->delete_cached_data('config' );
	$cont = ALERT_MAJ_OK;
	$cont .= $alerte->redir("?mods=admin");
	}
	else if(isset($_GET['add'])){
		if(!isset($_POST['new_alerte'])){
			$cont = '<form action="index.php?mods=admin&amp;page=galerte&amp;add" method="post">';
			$cont .= '<select name="mod_alert"><option value="">'.choose.'</option>';
			$var = opendir('./mods' );
			while ( ( $file = readdir($var))!=false){
				if($file != '.' && $file!='..'){
				$cont .= '<option value="'.$file.'">'.$file.'</option>';
				}
			}
			$cont .= '</select><p><textarea name="new_alerte"></textarea></p><p align="center"><input type="submit" value="'.SEND.'" /></p></form>';
		}
		else{
			$new_alert = htmlspecialchars($_POST['new_alerte'],ENT_QUOTES);
			$mod = htmlspecialchars($_POST['mod_alert'],ENT_QUOTES);
			$alerte->modifAlerte($new_alert,$mod);
			$cont = ALERT_ADDITION_SUCCESSFULLY;
			$cont .= $alerte->redir("?mods=admin");
		}
					
	}
	*/	
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>