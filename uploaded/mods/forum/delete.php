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


if(isset($_GET['delreply'])){

	// On recupere la reponse et le topic parent
	$query = $Bdd->sql('
	SELECT 
		'.PT.'_forum_reply.parent as parent, 
		'.PT.'_forum_for.groupes as groupes, 
		'.PT.'_forum_for.ecriture as ecriture,
		'.PT.'_forum_for.moderators AS moderators,
		'.PT.'_forum_reply.auteur as auteur, 
		'.PT.'_forum_topic.parent as forum 
	FROM 
		'.PT.'_forum_reply, 
		'.PT.'_forum_topic, 
		'.PT.'_forum_for 
	WHERE 
		(
			'.PT.'_forum_reply.id="'.intval($_GET['delreply']).'" 
			AND 
			'.PT.'_forum_topic.id = '.PT.'_forum_reply.parent 
			AND 
			'.PT.'_forum_for.id = '.PT.'_forum_topic.parent 
		) ' );
	$sql = $Bdd->get_array($query);

	// Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
	$modo = $Forum->is_mod ( $sql['moderators'] );
	$permissions_f = $permissions.$modo['perms'];

	// On verifie que l'utilisateur fait partiv dun groupe autorise a modifier ce forum
	$grpes = $Forum->verif_groupes ( $sql['groupes'] , $sql['ecriture'] );

	//Verification des permissions pour supprimer la reponse
	$permis = false;
	$permis = $Forum->give_permissions($permissions_f,$grade,'delete_all_replys' , 'delete_our_replys',1,$sql['auteur']);

	if( ( $permis === true && $grpes === true ) || $grade == 4){

		// On ouvre le template pour la mise en page du bloc centrale
		$template->set_filename('haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre', array ( 'TITRE' => FORUM ) );

		// On ouvre le fichier de template de la page de delete
		$template->set_filename('./modules/forum/delete.tpl' );

		// On decremente le nombre de post de l'auteur
		$Bdd->sql('UPDATE '.PT.'_users SET nb_post = nb_post-1 WHERE id="'.$sql['auteur'].'"' );

		// On met a jour le topic avec le nouveau nombre de message et le nouveau lastmess
		$lastmess = $Forum->give_lastmess(0,$sql['parent'],0,intval($_GET['delreply']));
		if($lastmess == '|*--*|')$lastmess = '';
		$Bdd->sql('UPDATE '.PT.'_forum_topic SET messages=messages-1,lastmess="'.$lastmess.'" WHERE id="'.$sql['parent'].'"' );
		$sub_bool = true;

		$forum_parent = $sql['forum'];
		// On fait une boucle pour mettre a jour les compteurs de messages de tous les forums parents et le lastmess de tt forum
		$a =false;
		while($sub_bool){
			$qu_for = $Bdd->sql('SELECT parent, is_sub, lastmess FROM '.PT.'_forum_for WHERE id="'.$forum_parent.'"' );
			$sq_for = $Bdd->get_array($qu_for);

			if(!$a)$lastmess = $sq_for['lastmess'];
			// Si le last message est de ce topic, on en recalcule un
			if(ereg('(.+)\|\*--\*\|[0-9]+\|\*--\*\|'.$sql['parent'].'\|\*--\*\|(.+)',$sq_for['lastmess'])){
				if(!$a)$lastmess = $Forum->give_lastmess($forum_parent,0,0,$sql['parent']);
				if($lastmess == '|*--*||*--*||*--*|')$lastmess = '';
			}
			$Bdd->sql('UPDATE '.PT.'_forum_for SET   messages=messages-1,lastmess="'.$lastmess.'" WHERE id="'.$forum_parent.'"' );
			$forum_parent = $sq_for['parent'];

			if($sq_for['is_sub']==0){
				$sub_bool = false;
			}
			$a = true;
		}

		$template->assign_block_vars ( 'delete' , array ( 
		'TXT' => REPLY_SUCCESSFULLY_DELETED,
		'URL' => 'index.php?mods=forum&page=viewtopic&id='.$sql['parent'],
		'BACK' => back ) );

		$Forum->redir('index.php?mods=forum&page=viewtopic&id='.$sql['parent']);

		// On supprime la reponse
		$Bdd->sql('DELETE FROM '.PT.'_forum_reply WHERE id="'.intval($_GET['delreply']).'"' );

	}
	else{
		// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}
}
else if(isset($_GET['deltopic'])){

	// On recupere les infos du topic
	$query = $Bdd->sql('
	SELECT 
		'.PT.'_forum_topic.parent as parent, 
		'.PT.'_forum_topic.auteur as auteur, 
		'.PT.'_forum_for.groupes as groupes, 
		'.PT.'_forum_for.ecriture as ecriture ,
		'.PT.'_forum_for.moderators AS moderators
	FROM 
		'.PT.'_forum_topic, 
		'.PT.'_forum_for 
	WHERE 
		'.PT.'_forum_topic.id="'.intval($_GET['deltopic']).'" 
	AND 
		'.PT.'_forum_for.id = '.PT.'_forum_topic.parent' );
	$sql = $Bdd->get_array($query);

	//Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
	$modo = $Forum->is_mod ( $sql['moderators'] );
	$permissions_f = $modo['perms'];

	// On verifie que l'utilisateur fait partiv dun groupe autorise a modifier ce forum
	$grpes = $Forum->verif_groupes ( $sql['groupes'] , $sql['ecriture'] );

	//Verification des permissions pour supprimer la reponse
	$permis = false;
	$permis = $Forum->give_permissions($permissions_f,$grade,'delete_all_topics' , 'delete_our_topics',1,$sql['auteur']);

	if( ( $permis === true && $grpes === true ) || $grade ==4 ){

		// On ouvre le template pour la mise en page du bloc centrale
		$template->set_filename('haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre', array ( 'TITRE' => FORUM ) );

		// On ouvre le fichier de template de la page de delete
		$template->set_filename('./modules/forum/delete.tpl' );

		// On met a jour nombre de post de tous les utilisateurs et on modifie le lu/non lu tant qu'on y est ;) :
		$query = $Bdd->sql('SELECT id, lunonlu FROM '.PT.'_users WHERE id!="'.$uid.'"' );
		while($sqlu = $Bdd->get_array($query)){
			$quer_1 = $Bdd->sql('SELECT id FROM '.PT.'_forum_topic WHERE auteur="'.$sqlu['id'].'"' );
			$quer_2 = $Bdd->sql('SELECT id FROM '.PT.'_forum_reply WHERE auteur="'.$sqlu['id'].'"' );
			$cnt = $Bdd->get_num_rows($quer_1) + $Bdd->get_num_rows($quer_2);

			$honolulu = str_replace('{'.intval($_GET['deltopic']).';'.$sql['parent'].'}' , '',$sqlu['lunonlu']);
			$honolulu .= '{'.intval($_GET['deltopic']).';'.$sql['parent'].'}';

			$Bdd->sql('UPDATE '.PT.'_users SET nb_post = "'.$cnt.'", lunonlu = "'.$honolulu.'" WHERE id="'.$sqlu['id'].'"' );
		}

	// On recupere le nombre de reponse du sujet
	$qu_nbr = $Bdd->sql('SELECT id FROM '.PT.'_forum_reply WHERE parent="'.intval($_GET['deltopic']).'"' );
	$nbr = $Bdd->get_num_rows($qu_nbr);

		//On lance une boucle qui mettra a jour le nombre de sujets, de messages et le lastmess de tt les forum =)
		$for_bool = true;
		$forum_parent = $sql['parent'];
		$a = false;
		while($for_bool){

			$qu_for = $Bdd->sql('SELECT parent, is_sub, lastmess FROM '.PT.'_forum_for WHERE id="'.$forum_parent.'"' );
			$sq_for = $Bdd->get_array($qu_for);

			if(!$a)$lastmess = $sq_for['lastmess'];

			// Mise a jour du lastmess
			// Si le last message est de ce topic, on en recalcule un
			if(ereg('(.+)\|\*--\*\|[0-9]+\|\*--\*\|'.intval($_GET['deltopic']).'\|\*--\*\|(.+)',$sq_for['lastmess'])){
				if(!$a)$lastmess = $Forum->give_lastmess($forum_parent,0,1,intval($_GET['deltopic']));
				if($lastmess == '|*--*||*--*||*--*|')$lastmess = '';
			}

			$Bdd->sql('UPDATE '.PT.'_forum_for SET messages=messages-'.$nbr.', lastmess="'.$lastmess.'",sujets=sujets-1 WHERE id="'.$forum_parent.'"' );

			$forum_parent = $sq_for['parent'];

			if($sq_for['is_sub']==0){
				$for_bool = false;
			}
			$a = true;
		}

		// On supprime le sujet et toutes ses reponses
		$Bdd->sql('DELETE FROM '.PT.'_forum_topic WHERE id="'.intval($_GET['deltopic']).'"' );
		$Bdd->sql('DELETE FROM '.PT.'_forum_reply WHERE parent="'.intval($_GET['deltopic']).'"' );

		$template->assign_block_vars ( 'delete' , array ( 
		'TXT' => TOPIC_SUCCESSFULLY_DELETED,
		'URL' => 'index.php?mods=forum&page=viewfor&id='.$sql['parent'],
		'BACK' => back ) );

		$Forum->redir('index.php?mods=forum&page=viewfor&id='.$sql['parent']);
	}
	else{
		// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}
}
else{

	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );

}
?>