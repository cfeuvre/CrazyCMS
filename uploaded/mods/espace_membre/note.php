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
//Menu
if($grade>0){

	$template->set_filename ( 'haut_mods.tpl' );

	$template->set_filename ( './modules/espace_membre/links.tpl' );
	$template->assign_block_vars ( 'links' , array (
	'UID' => $uid,
	'PWD' => $user_password,
	'UNLOG' => unlog,
	'MY_BLOC_NOTE' => my_bloc_note,
	'MODIF_PROFIL' => modif_profil,
	'CHANGE_LANGUAGE' => change_language,
	'CHANGE_THEME' => change_theme,
	'MY_INFOS' => my_infos,
	'MY_CONFIG' => my_config ) );
	
	$template->set_filename ( './modules/espace_membre/note.tpl' );
	
	$template->assign_block_vars ( 'index' , array (
	'MENU' => menu,
	'NAME' => name,
	'MY_BLOC_NOTE' => my_bloc_note,
	'MY_NOTES' => my_notes,
	'WRITE_NOTE' => write_note ) );

	
	// Poster une note
	if ( isset ( $_GET['action']) && $_GET['action']== "notes" && !isset($_POST['contenu'] )){
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => writing_note ) );
		$template->assign_block_vars ( 'notes' , array ( 
		'FORM' => form,
		'TITLE_NOTE' => title_note,
		'CONTENT_NOTE' => content_note,
		'CONTENU' => default_form() ) );
	}
	// On insert la note dans la BDD
	else if (isset ($_POST['notes_title']) &&  (!empty($_POST['notes_title'])) &&(!empty($_POST['contenu'])) ){
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => confirmation ) );
		$act=$Bdd->sql('INSERT INTO '.PT.'_note VALUES ("","'.$Bdd->secure($_POST['notes_title']).'","'.$Bdd->secure($_POST['contenu']).'","'.$uid.'")') ;
		$template->assign_block_vars ( 'confirm' , array (
		'CONFIRMATION' => confirmation,
		'NOTE_SAVE' => note_save,
		'BACK' => back ) );
	}
	//Partie concernant le lien "Voir mes notes"
	else if(isset($_GET['action']) && $_GET['action']== "voir")
	{
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => my_notes ) );
		$notes_voir=$Bdd->sql('SELECT id,title FROM '.PT.'_note WHERE '.PT.'_note.auteur="'.$uid.'"' );
		while ($note=$Bdd->get_array($notes_voir)){
			$template->assign_block_vars ( 'see' , array (
			'ID' => $note['id'],
			'TITLE' => $note['title'],
			'DELETE' => delete ) );
		}
		if($Bdd->get_num_rows ($notes_voir)==0){
			$template->assign_block_vars ( 'none_note' , array (
			'NO_NOTE' => no_note,
			'CLICK' => click,
			'HERE' => here,
			'TO_POST_NOTE' => to_post_note ) );
		}
	}
	//Supprimer une note
	else if(isset($_GET['action']) && $_GET['action']== "del")
	{
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => delete ) );
		$notes_del=$Bdd->sql('SELECT auteur,id FROM '.PT.'_note WHERE id="'.intval($_GET['id']).'"' );
		$noted = $Bdd->get_array($notes_del);
		if ( $noted['auteur'] == $uid ){
			$confirmation = $Bdd->sql('DELETE FROM '.PT.'_note  WHERE id="'.$noted['id'].'"' );
			$template->assign_block_vars ( 'del' , array (
			'CONFIRMATION' => confirmation,
			'DELETED' => NOTE_DELETED,
			'CLICK' => click,
			'HERE' => here,
			'TO_BACK_NOTE' => to_back_note ) );
		}
	}
	//Apparence de la note
	else if(isset($_GET['action']) && $_GET['action']== "look")
	{
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => my_notes ) );
		$notes_look=$Bdd->sql('SELECT auteur,title,contenu FROM '.PT.'_note WHERE id="'.intval($_GET['id']).'"' );
		$notel=$Bdd->get_array($notes_look);
		if($notel['auteur'] == $uid){
			$template->assign_block_vars ( 'print' , array (
			'NOTE' => note,
			'TITLE' => $notel['title'],
			'CONTENU' => to_html($notel['contenu']),
			'BACK' => back,
			'TO_PRINT_THIS_MESS' => to_print_this_mess ) );
		}
	}
	else{
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => my_notes ) );
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>