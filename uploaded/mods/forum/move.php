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

	// On recupere l'ancien forum parent du topic et le nom du topic
	$q = $Bdd->sql('SELECT 
		'.PT.'_forum_topic.parent AS parent, 
		'.PT.'_forum_topic.nom AS nom, 
		'.PT.'_forum_for.groupes AS groupes, 
		'.PT.'_forum_for.moderators AS moderators,
		'.PT.'_forum_topic.messages AS reponses, 
		'.PT.'_forum_for.ecriture AS ecriture 
	FROM 
		'.PT.'_forum_topic, 
		'.PT.'_forum_for
	WHERE 
		'.PT.'_forum_topic.id="'.intval($_GET['id']).'" 
	AND 
		'.PT.'_forum_for.id = '.PT.'_forum_topic.parent' );

	$s = mysql_fetch_array($q);
	$last_parent = $s['parent'];
	$nb_reponses = $s['reponses'];

	// Si l'utilisateur est moderateur de ce forum, on lui donne les permissions de moderateur ici.
	$modo = $Forum->is_mod ( $s['moderators'] );
	$permissions_f = $permissions.$modo['perms'];

	$grpes = $Forum->verif_groupes ( $s['groupes'] , $s['ecriture'] );

if ( ( ereg ( 'move_topic;' , $permissions_f ) AND $grpes === true ) OR $grade==4){

	// On affiche un formulaire pour choisir ou deplacer le sujet
	if(!isset($_POST['dest'])){

		$template->set_filename ( 'haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre' , array (
		'TITRE' => MOVE_TOPIC
		) );

		$template->set_filename ( './modules/forum/move.tpl' );
		$template->assign_block_vars ( 'move_form' , array (
		'MOVE_TOPIC' => MOVE_TOPIC,
		'TOPIC_NAME' => stripslashes( htmlspecialchars ( $s['nom'] ) ),
		'TO' => TO,
		'CHOOSE_DESTINATION' => CHOOSE_DEST,
		'VALID' => valid
		) );


		$query = $Bdd->sql('SELECT id, nom, groupes, ecriture, locked, moderators, parent FROM '.PT.'_forum_for WHERE id!="'.$last_parent.'" ORDER BY parent ASC' );
		while( $sql = mysql_fetch_array ( $query ) ){
			if ( $Forum->verif_groupes ( $sql['groupes'] , $sql['ecriture'] ) === true ){

				// On regarde si l'utilisateur est moderateur dans le forum de destination
				$modo = $Forum->is_mod ( $sql['moderators'] );
				$permissions_f2 = $permissions.$modo['perms'];
				$grpes = FALSE;
				$grpes = $Forum->verif_groupes ( $sql['groupes'] , $sql['ecriture'] , false);
				if ( ( ( $sql['locked'] == 0 OR ereg('lock_topic;',$permissions_f2) ) AND ereg('post_topic;',$permissions_f2) AND $grpes === true ) OR $grade == 4 ) {

					if ( !isset ( $parent ) OR $parent != $sql['parent'] )
						$template->assign_block_vars ( 'move_form.move_form_choix_cat' , array ( 'NAME' => '------' ) );

					$parent = $sql['parent'];

					$template->assign_block_vars ( 'move_form.move_form_choix_cat.move_form_choix' , array (
					'ID' => $sql['id'],
					'NOM' => stripslashes ( htmlspecialchars($sql['nom']) )
					) );
				}
			}
		}
		$template->set_filename ( 'bas_mods.tpl' );
	}
	else{

		$template->set_filename ( 'haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre' , array (
		'TITRE' => MOVE_TOPIC
		) );

		$template->set_filename ( './modules/forum/move.tpl' );

		$new_parent = intval($_POST['dest']);

		// Requete qui verifie que le forum parent existe par securite
		$sec = $Bdd->sql('SELECT moderators, groupes, ecriture, locked FROM '.PT.'_forum_for WHERE id="'.$new_parent.'"' );
		$sce = $Bdd->get_array ( $sec );
		if($Bdd->get_num_rows($sec)==0){
			$template->assign_block_vars ( 'move_valid_error' , array (
			'TXT' => MOVING_ERROR,
			'URL' => 'index.php?mods=forum&amp;page=move&amp;id='.intval($_GET['id']),
			'BACK' => back
			) );
		}
		else{

			// On regarde si l'utilisateur est moderateur dans le forum de destination
			$modo = $Forum->is_mod ( $sce['moderators'] );
			$permissions_f2 = $permissions.$modo['perms'];
			$grpes = FALSE;
			$grpes = $Forum->verif_groupes ( $sce['groupes'] , $sce['ecriture'] , false);
			if ( ( ( $sce['locked'] == 0 OR ereg('lock_topic;',$permissions_f2) ) AND ereg('post_topic;',$permissions_f2) AND $grpes === true ) OR $grade == 4 ) {

			// On deplace le topic
			$Bdd->sql('UPDATE '.PT.'_forum_topic SET parent="'.intval($_POST['dest']).'" WHERE id="'.intval($_GET['id']).'"' );

			// On fait une premiere boucle qui decrementera tous les anciens forum parents ( en nombre de sujets )
			$sub_bool = true;

			$lastmess = $Forum->give_lastmess($last_parent,0,1);
			if($lastmess == '|*--*||*--*|&amp;last_page#r-0|*--*|')$lastmess = '';

			while($sub_bool){

				$qu_for = $Bdd->sql('SELECT parent,is_sub FROM '.PT.'_forum_for WHERE id="'.$last_parent.'"' );
				$sq_for = $Bdd->get_array($qu_for);

				// On met a jour le nombre de sujet de ce forum la.
				// On recupere le dernier message
				$Bdd->sql('UPDATE '.PT.'_forum_for SET sujets=sujets-1,messages=messages-'.$nb_reponses.', lastmess="'.$lastmess.'" WHERE id="'.$last_parent.'"' );

				// On remonte d'une forum pour prochain tour de boucle
				$last_parent = $sq_for['parent'];

				// Si ce forum est le plus haut, on arrete la boucle
				if($sq_for['is_sub']==0)
					$sub_bool = false;
			}

			// Puis on fait une seconde boucle qui incrementera tous les nouveaux forums parents ( en nombre de sujets )
			$sub_bool = true;
			$lastmess = $Forum->give_lastmess($new_parent,0,1);

			while($sub_bool){

				$qu_for = $Bdd->sql('SELECT parent,is_sub FROM '.PT.'_forum_for WHERE id="'.$new_parent.'"' );
				$sq_for = $Bdd->get_array($qu_for);

				// On met a jour le nombre de sujet, de reponses et le dernier message de ce forum la.
				$Bdd->sql('UPDATE '.PT.'_forum_for SET sujets=sujets+1,messages=messages+'.$nb_reponses.', lastmess="'.$lastmess.'" WHERE id="'.$new_parent.'"' );

				// On remonte d'une forum pour prochain tour de boucle
				$new_parent = $sq_for['parent'];

				// Si ce forum est le plus haut, on arrete la boucle
				if($sq_for['is_sub']==0){
					$sub_bool = false;
					$cat_parent = $new_parent;
				}
			}

			$Bdd->sql('UPDATE '.PT.'_forum_topic SET cat_parent="'.$new_parent.'" WHERE id="'.intval($_GET['id']).'"' );

				$template->assign_block_vars ( 'move_valid' , array (
				'TXT' => SUCCESSFULLY_MOVED,
				'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;id='.intval($_GET['id']),
				'BACK' => back
				) );
			}
			else{
				$template->assign_block_vars ( 'move_valid_error' , array (
				'TXT' => DESTINATION_FORUM_UNWRITABLE,
				'URL' => 'index.php?mods=forum&amp;page=move&amp;id='.intval($_GET['id']),
				'BACK' => back
				) );
			}

		}
		$template->set_filename ( 'bas_mods.tpl' );
	}

}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>