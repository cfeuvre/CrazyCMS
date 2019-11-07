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
include('./mods/forum/class.forum.php' );
$Forum = new Class_Forum();

if(isset($_GET['editreply'])){

	//Modification d'une reponse
	$titre = EDIT_REPLY;

	// On recupere toutes les informations relative a la reponse a modifier
	$query_reply = $Bdd->sql('SELECT parent,auteur,contenu,smileys,bb FROM '.PT.'_forum_reply WHERE id="'.intval($_GET['editreply']).'"' );
	$sql_reply = $Bdd->get_array($query_reply);

	// On regarde si l'utilisateur n'est pas moderateur du forum parent ;)
	$query = $Bdd->sql ( 'SELECT parent FROM '.PT.'_forum_topic WHERE id="'.$sql_reply['parent'].'"' );
	$sql = $Bdd->get_array ( $query );

	$q2 = $Bdd->sql ( 'SELECT moderators FROM '.PT.'_forum_for WHERE id="'.$sql['parent'].'"' );
	$s2 = $Bdd->get_array ( $q2 );

	// Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
	$modo = $Forum->is_mod ( $s2['moderators'] );
	$permissions_f = $permissions.$modo['perms'];

	//Verification des permissions pour editer la reponse
	$permis = false;
	$permis = $Forum->give_permissions($permissions_f,$grade,'edit_all_replys' , 'edit_our_replys',1,$sql_reply['auteur']);

	//Si l'utilisateur a toutes les permissions
	if($permis === true){

		// On ouvre le template pour la mise en page du bloc centrale
		$template->set_filename('haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre', array ( 'TITRE' => FORUM ) );

		// On ouvre le fichier de template de la page d'edit
		$template->set_filename('./modules/forum/edit.tpl' );

		//Si le formulaire a deja ete valide, on met a jour la reponse
		if(isset($_POST['contenu']) && strlen($_POST['contenu'])>5){

			$contenu = $Bdd->secure($_POST['contenu']);
			$Bdd->sql('UPDATE '.PT.'_forum_reply SET contenu="'.$contenu.'",smileys="1",bb="1" WHERE id="'.intval($_GET['editreply']).'"' );

			$template->assign_block_vars ( 'edit_form_valid', array (
			'VALID_TXT' => REPLY_UPDATED,
			'URL' => 'index.php?mods=forum&page=viewtopic&id='.$sql_reply['parent'],
			'BACK' => back ) );
			$Forum->redir('index.php?mods=forum&page=viewtopic&id='.$sql_reply['parent']);
		}
		else{

			//Si le formulaire n'as pas deja ete valide, on affiche le formulaire
			$template->assign_block_vars ( 'edit_form', array ( 'FORM' => default_form ( FALSE , '' , to_html ( $sql_reply['contenu'] ) ) ) );
		}
		// On ferme le bloc central
		$template->set_filename ( 'bas_mods.tpl' );
	}
	else{
		// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}
}
elseif(isset($_GET['edittopic'])){

	//Modification d'une sujet
	$titre = EDIT_TOPIC;

	// On recupere toutes les informations relative a la reponse a modifier
	$query_topic = $Bdd->sql('SELECT id,parent,nom,auteur,contenu,smileys,bb FROM '.PT.'_forum_topic WHERE id="'.intval($_GET['edittopic']).'"' );
	$sql_topic = mysql_fetch_array($query_topic);

	// On regarde si l'utilisateur n'est pas moderateur du forum parent ;)
	$q2 = $Bdd->sql ( 'SELECT moderators FROM '.PT.'_forum_for WHERE id="'.$sql_topic['parent'].'"' );
	$s2 = $Bdd->get_array ( $q2 );

	// Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
	$modo = $Forum->is_mod ( $s2['moderators'] );
	$permissions_f = $permissions.$modo['perms'];

	//Verification des permissions pour editer le sujet
	$permis = false;
	$permis = $Forum->give_permissions($permissions_f,$grade,'edit_all_topics' , 'edit_our_topics',1,$sql_topic['auteur']);

	//Si l'utilisateur a toutes les permissions
	if($permis === true){

		// On ouvre le template pour la mise en page du bloc centrale
		$template->set_filename('haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre', array ( 'TITRE' => FORUM ) );

		// On ouvre le fichier de template de la page d'edit
		$template->set_filename('./modules/forum/edit.tpl' );

		//Si le formulaire a deja ete valide, on met a jour le topic
		if(isset($_POST['contenu']) && strlen($_POST['contenu'])>5){

			$contenu = $Bdd->secure($_POST['contenu']);
			$Bdd->sql('UPDATE '.PT.'_forum_topic SET nom="'.$Bdd->secure($_POST['title']).'",contenu="'.$contenu.'" WHERE id="'.intval($_GET['edittopic']).'"' );

			$template->assign_block_vars ( 'edit_form_valid', array (
			'VALID_TXT' => POST_UPDATED,
			'URL' => 'index.php?mods=forum&page=viewtopic&id='.$sql_topic['id'],
			'BACK' => back ) );
			$Forum->redir('index.php?mods=forum&page=viewtopic&id='.$sql_topic['id']);
		}
		else{

			$template->assign_block_vars ( 'edit_form', array ( 'FORM' => default_form ( TRUE , to_html ( $sql_topic['nom'] ) , to_html ( $sql_topic['contenu'] ) ) ) );

		}
		// On ferme le bloc central
		$template->set_filename ( 'bas_mods.tpl' );
	}
	else{
		// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}
}
?>