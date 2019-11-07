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

// On charge la classe du forum
include('./mods/forum/class.forum.php' );
$Forum = new Class_Forum();

if ( isset ( $_GET['newreply'] ) ){

	$permission = 'post_reply';

	// On verifie que l'utilisateur a acces a ce forum et qu'il n'est pas verrouille ( le forum )
	$secu = $Bdd->sql ( '
		SELECT 
			ff.groupes AS groupes,
			ff.locked as locked,
			ff.ecriture AS ecriture,
			ff.moderators AS moderators,
			ft.locked AS locked,
			ft.messages AS reponses
		FROM '.PT.'_forum_for AS ff
		LEFT JOIN '.PT.'_forum_topic AS ft
			ON ff.id=ft.parent
		WHERE ft.id = "'.intval ( $_GET['newreply'] ).'"' );

	// On recupere le nombre de reponses du sujet ( pour la redirection apres l'envoi d'une reponse ) et les groupes autorises a ecrire
	$qsecu = $Bdd->get_array ( $secu );
	$grpes =  $Forum->verif_groupes ( $qsecu['groupes'] , $qsecu['ecriture'] );
	$nb_reponses = $qsecu['reponses'];

	// Si l'utilisateur est moderateur de ce forum, on lui donne les permissions de moderateur ici.
	$modos = $Forum->is_mod ( $qsecu['moderators'] );
	$permissions_f = $permissions.$modos['perms'];
}
elseif ( isset ( $_GET['newtopic'] ) ){

	$permission = 'post_topic';

	// On verifie que l'utilisateur a acces a ce forum et qu'il n'est pas verrouille ( le forum )
	$secu = $Bdd->sql ( '
		SELECT 
			ff.groupes AS groupes,
			ff.ecriture AS ecriture,
			ff.locked AS locked,
			ff.moderators AS moderators
		FROM '.PT.'_forum_for AS ff
		WHERE ff.id = "'.intval ( $_GET['newtopic'] ).'"' );
	$qsecu = $Bdd->get_array ( $secu );

	// Si l'utilisateur est moderateur de ce forum, on lui donne les permissions de moderateur ici.
	$modos = $Forum->is_mod ( $qsecu['moderators'] );
	$permissions_f = $permissions.$modos['perms'];

	// On vérifie les groupes autorisés a ecrire ici
	$grpes =  $Forum->verif_groupes ( $qsecu['groupes'] , $qsecu['ecriture'] );

}

if ( ( ereg($permission.';',$permissions_f) AND $grpes === TRUE AND ( $qsecu['locked'] == 0 OR ereg ('lock_topic;' , $permissions_f ) ) ) OR $grade==4 ){

	// On ouvre le template pour la mise en page du bloc centrale
	$template->set_filename('haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre', array ( 'TITRE' => FORUM ) );

	// On charge le template de la page de post
	$template->set_filename('./modules/forum/post.tpl' );

	// Si le formulaire a ete valide, on le traite
	if ( isset ( $_POST['contenu'] ) ){

		if ( strlen ( $_POST['contenu'] ) <= 5 ){
			$template->assign_block_vars ( 'post_valid_size',
					array (
						'MINIMUM_5_CHAR' => MINIMUM_5_CHAR,
						'BACK' => back
					)
			);
		}
		else if ( isset ( $_POST['title'] ) AND strlen ( $_POST['title'] ) < 1 ){
			$template->assign_block_vars ( 'post_valid_size',
					array (
						'MINIMUM_5_CHAR' => MUST_GIVE_TITLE,
						'BACK' => back
					)
			);
		}
		else{

			if ( isset ( $_GET['newreply'] ) ){
				if ( ( convertime ( time() ) - $user_last_mess ) < $flood_time ){

					$time_left = $flood_time - ( convertime ( time() ) - $user_last_mess );

					$template->assign_block_vars ( 'post_valid_flood',
						array (
							'MUST_WAIT' => MUST_WAIT,
							'FLOOD_TIME' => $flood_time,
							'SECONDS_BETWEEN_TWO_POST' => SECONDS_BETWEEN_TWO_POSTS,
							'WAIT_FOR' => PLEASE_WAIT_FOR,
							'TIME_LEFT' => $time_left,
							'SECONDS_TO_POST' => SECONDS_TO_POST,
							'TO_NOT_REWRITE' => TO_NOT_WRITE_BACK,
							'SECONDS_WITH_F5' => SECONDS_WITH_F5
						)
					);
				}
				else{

					// On recupere dernier post si il y a ;
					$qq = $Bdd->sql('
					SELECT 
						'.PT.'_users.pseudo as pseudo, 
						'.PT.'_forum_reply.contenu as contenu, 
						'.PT.'_forum_reply.date as date 
					FROM 
						'.PT.'_users, 
						'.PT.'_forum_reply 
					WHERE 
						'.PT.'_users.id = '.PT.'_forum_reply.auteur 
					AND 
						parent="'.intval($_GET['newreply']).'" 
					AND 
						date > '.( ( isset ( $_POST['last_date'] ) ? ( intval ( $_POST['last_date'] ) ) : ('0' ) ) ).'
					ORDER BY date DESC LIMIT 0,1' );

					if ( $Bdd->get_num_rows ( $qq ) > 0 AND isset ( $_POST['last_date'] ) AND intval ( $_POST['last_date'] ) != 0 ){

						$sql2 = $Bdd->get_array ( $qq );

						$template->assign_block_vars ( 'post_valid_reply_during_writing',
							array (
								'REPLY_POSTED_DURING_WRITE' => REPLY_POSTED_DURING_WRITE,
								'LAST_REPLY' => LAST_REPLY,
								'BY' => by,
								'PSEUDO' => htmlspecialchars ( $sql2['pseudo'] ),
								'THE' => the,
								'DATE' => ccmsdate ( $fuseaux , $sql2['date'] ),
								'CONTENU' => to_html ( $sql2['contenu'] ),
								'FORM' => default_form ( FALSE , '' , to_html ( $_POST['contenu'] ) ),
								'LDATE' => $sql2['date'],
								'BACK' => back
							)
						);

					}
					else{

						// On recupere les donnees de la reponse a poster
						$contenu_reply = $Bdd->secure ( $_POST['contenu'] );
						$recup_for = $Bdd->sql ( 'SELECT parent FROM '.PT.'_forum_topic WHERE id="'.intval($_GET['newreply']).'"' );
						$sql_for = $Bdd->get_array ( $recup_for );
						$first_forum = $forum_parent = $sql_for['parent'];
						$post_reply = TRUE;
						// On recupere dans un array tous les forums parents pour le mod lu/non-lu apres ;)
						$forums = array();

						// Booleen qui permettra de continuer la boucle jusqu'a ce que tous les forum parents soit mis a jour
						$sub_bool = TRUE;
						
						// On poste le sujet
						$Bdd->sql('INSERT INTO '.PT.'_forum_reply ( parent , auteur , contenu , date , smileys , bb) VALUES ("'.intval ( $_GET['newreply'] ).'", "'.$uid.'", "'.$contenu_reply.'", "'.convertime ( time() ).'", "1", "1")' );
						$rid = $Bdd->last_insert_id();
			
						if ( isset ( $_POST['abon'] ) AND $_POST['abon'] == 1 ){
							$u_abo = str_replace ( '('.intval ( $_GET['newreply'] ).',0)' , '' , $u_abo );
							$u_abo = str_replace ( '('.intval ( $_GET['newreply'] ).',1)' , '' , $u_abo );
							$u_abo .= '('.intval ( $_GET['newreply'] ).',0)';
						}
						else{
							$u_abo = str_replace ( '('.intval ( $_GET['newreply'] ).',0)' , '' , $u_abo );
							$u_abo = str_replace ( '('.intval ( $_GET['newreply'] ).',1)' , '' , $u_abo );
						}
			
						$Bdd->sql('UPDATE '.PT.'_users SET last_mess_date="'.convertime ( time() ).'", nb_post = nb_post+1,last_activity_date="'.convertime ( time() ).'",abonnements="'.$u_abo.'" WHERE id="'.$uid.'"' );
						$lastmess = $Forum->give_lastmess ( 0 , intval ( $_GET['newreply'] ) );
						$Bdd->sql('UPDATE '.PT.'_forum_topic SET messages=messages+1, lastmess="'.$lastmess.'", lastreply_date="'.time().'" WHERE id="'.intval ( $_GET['newreply'] ).'"' );
						$lastmess = $Forum->give_lastmess ( $forum_parent , 0 , 0 , 0 , $rid );

						// On lance la boucle qui mettra a jour tous les forum parents ( nombre de posts )
						while ( $sub_bool ){

							// On recupere toutes les infos relatives a ce forum
							$query = $Bdd->sql('SELECT parent, is_sub FROM '.PT.'_forum_for WHERE id="'.$forum_parent.'"' );

							if( $Bdd->get_num_rows ( $query ) == 0 ){
								// Si le forum n'existe pas, on arrete tout de suite ce vilain petit lamer ^^
								$sub_bool = FALSE;
								$post_reply = FALSE;

								$template->assign_block_vars ( 'post_valid_error',
									array (
										'ERROR_POST_NOT_SENDED' => ERROR_POST_NOT_SENDED,
									)
								);

							}
							else{

								$forums[] = $forum_parent;
								$sql = $Bdd->get_array ( $query );
								$Bdd->free_result ( $query );
								$forum_parent = $sql['parent'];

								// Si ce forum parent n'est pas un sous forum, il s'agit du plus haut et on arrete la boucle
								if ( $sql['is_sub'] == 0 )
									$sub_bool = FALSE;
							}
						}
						
						// On incremente le compteur de sujets de ce forum et  on met a jour le compteur de dernier message
						$Bdd->sql('UPDATE '.PT.'_forum_for SET messages=messages+1, lastmess="'.$lastmess.'" WHERE id IN ( '.implode ( ',' , $forums ).' )' );

						// On cherche la page du sujet vers laquelle rediriger
						$page = ceil( ( $nb_reponses + 1 ) / $forum_nb_reponses_page );

						$template->assign_block_vars ( 'post_valid',
							array (
								'POSTED' => REPLY_POSTED,
								'URL' => 'index.php?mods=forum&page=viewtopic&id='.intval ( $_GET['newreply'] ).( ( isset ( $_GET['js'] ) ) ? ('&js' ) : ('') ).'&nb_page='.$page.'#reply-'.$rid,
								'BACK' => back
							)
						);

						$Forum->redir('index.php?mods=forum&page=viewtopic&id='.intval($_GET['newreply']).'&nb_page='.$page.( ( isset ( $_GET['js'] ) ) ? ('&js' ) : ('') ).'#reply-'.$rid );
							
						$entete = "MIME-Version: 1.0\r\n";
						$entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
						
						// Mise a jour du lu/non-lu
						$query = $Bdd->sql('SELECT id, lunonlu, abonnements, pseudo, email FROM '.PT.'_users WHERE id!="'.$uid.'" AND id!="1"' );
						while ( $sql = $Bdd->get_array ( $query ) ){
							// On envoi mail a tous les utilisateurs abonnes a ce sujet
							$abo = $sql['abonnements'];
							if ( strpos ( $abo , '('.intval ( $_GET['newreply'] ).',0)' ) ){
								$entete .= "To: ".htmlspecialchars($sql['pseudo'])." <".htmlspecialchars($sql['email']).">\r\n";
								$entete .= "From: $nom_site\r\n";
								
								$new_reply_posted_mail = str_replace ( '{PSEUDO}' , htmlspecialchars ( $sql['pseudo'] ) , $new_reply_posted_mail );
								
								$url = str_replace ( 'http://' , '' , preg_replace ( '!/$!' , '' , $url_site ) );
								$lien = 'http://'.$url.'/index.php?mods=forum&page=viewtopic&id='.$rid;
								
								$new_reply_posted_mail = str_replace ( '{URL}' , '<a href="'.$lien.'">'.$lien.'</a>' , $new_reply_posted_mail );
								
								@mail ( $sql['email'] , NEW_TOPIC_POSTED_MAIL, $new_reply_posted_mail, $entete);
							}

						$honolulu = $sql['lunonlu'];
							foreach ( $forums as $value ){
								$honolulu = str_replace ( '('.$value.')' , '' , $honolulu );
								$honolulu .= '('.$value.')';
							}
							$honolulu = str_replace ( '{'.intval($_GET['newreply']).';'.$first_forum.'}' , '' , $honolulu );
							$honolulu .= '{'.intval($_GET['newreply']).';'.$first_forum.'}';
							$Bdd->sql ( 'UPDATE '.PT.'_users SET lunonlu="'.$honolulu.'" WHERE id="'.$sql['id'].'"' );
						}
					}
				}
			}
			else if(isset($_GET['newtopic'])){

				if ( ( convertime ( time() ) - $user_last_mess ) < $flood_time ){
					$time_left = $flood_time - ( convertime ( time() ) - $user_last_mess );
					$template->assign_block_vars ( 'post_valid_flood',
						array (
							'MUST_WAIT' => MUST_WAIT,
							'FLOOD_TIME' => $flood_time,
							'SECONDS_BETWEEN_TWO_POST' => SECONDS_BETWEEN_TWO_POSTS,
							'WAIT_FOR' => PLEASE_WAIT_FOR,
							'TIME_LEFT' => $time_left,
							'SECONDS_TO_POST' => SECONDS_TO_POST,
							'TO_NOT_REWRITE' => TO_NOT_WRITE_BACK,
							'SECONDS_WITH_F5' => SECONDS_WITH_F5
						)
					);
				}
				else{
					if ( $grade == 4 OR ereg( 'attach_topic;' , $permissions_f ) ){
						$attached = ( ( isset( $_POST['attached'] ) ) ? ( intval ( $_POST['attached'] ) ) : ( 0 ) );
					}
					else{
						$attached = 0;
					}
					if ( $grade == 4 OR ereg ( 'lock_topic;' , $permissions_f ) ){
						$locked = ( ( isset( $_POST['locked'] ) ) ? ( intval ( $_POST['locked'] ) ) : ( 0 ) );
					}
					else{
						$locked = 0;
					}

					// On recupere les donnees du sujets a poster
					$titre_topic = $Bdd->secure ( $_POST['title'] );
					$contenu_topic = $Bdd->secure ( $_POST['contenu'] );
					$first_forum = $forum_parent = intval ( $_GET['newtopic'] );
					$post_topic = TRUE;

					// On recupere dans un array tous les forums parents pour le mod lu/non-lu apres ;)
					$forums = array();

					// Booleen qui permettra de continuer la boucle jusqu'a ce que tous les forum parents soit mis a jour
					$sub_bool = TRUE;

					// On recupere le dernier message a appliquer a tous forums parent
					$lastmess = $Forum->give_lastmess ( $forum_parent , 0 , 1 );

					// On lance la boucle qui mettra a jour tous les forum parents ( nombre de posts )
					while ( $sub_bool ){

						// On recupere toutes les infos relatives a ce forum
						$query = $Bdd->sql ( 'SELECT parent, is_sub FROM '.PT.'_forum_for WHERE id="'.$forum_parent.'"' );
						$sql = $Bdd->get_array ( $query );

						if ( $Bdd->get_num_rows ( $query ) == 0 ){
							// Si le forum n'existe pas, on arrete tout de suite ce vilain petit lamer ^^
							$sub_bool = FALSE;
							$post_topic = FALSE;
						}
						else{

							$forums[] = $forum_parent;
							$forum_parent = $sql['parent'];

							if ( $sql['is_sub'] == 0 ){
								// Si ce forum parent n'est pas un sous forum, il s'agit du plus haut et on arrete la boucle
								$sub_bool = FALSE;
								$cat_parent = $forum_parent;
							}
						}
						$Bdd->free_result ( $query );
					}
					// On incremente le compteur de sujets des forums parents
					$Bdd->sql ( 'UPDATE '.PT.'_forum_for SET sujets=sujets+1, lastmess="'.$lastmess.'" WHERE id IN ( '.implode ( ',' , $forums ).' )' );

					// On poste le sujet
					$Bdd->sql ( 'INSERT INTO '.PT.'_forum_topic ( parent , auteur , nom , contenu , date , smileys , bb , messages , vue, attached, locked, lastreply_date, cat_parent) VALUES ("'.intval ( $_GET['newtopic'] ).'", "'.$uid.'", "'.$titre_topic.'", "'.$contenu_topic.'", "'.convertime ( time() ).'", "1", "1", "0", "0","'.$attached.'","'.$locked.'", "'.time().'", "'.$cat_parent.'")' );
					$id_redirige = $Bdd->last_insert_id();
					
					if ( isset ( $_POST['abon'] ) AND $_POST['abon'] == 1 ){
						$u_abo = str_replace ( '('.intval ( $_GET['newtopic'] ).',0)' , '' , $u_abo );
						$u_abo = str_replace ( '('.intval ( $_GET['newtopic'] ).',1)' , '' , $u_abo );
						$u_abo .= '('.$id_redirige.',0)';
					}
					$Bdd->sql ( 'UPDATE '.PT.'_users SET last_mess_date="'.convertime ( time() ).'", last_activity_date="'.convertime ( time() ).'", nb_post = nb_post+1, abonnements="'.$u_abo.'" WHERE id="'.$uid.'"' );

					if ( $post_topic === FALSE ){
						$template->assign_block_vars ( 'post_valid_error',
							array (
								'ERROR_POST_NOT_SENDED' => ERROR_POST_NOT_SENDED,
							)
						);
					}
					else{

						$template->assign_block_vars ( 'post_valid',
							array (
								'POSTED' => POST_POSTED,
								'URL' => 'index.php?mods=forum&page=viewtopic&amp;id='.$id_redirige.( ( isset ( $_GET['js'] ) ) ? ('&amp;js' ) : ('') ),
								'BACK' => back
							)
						);

						$Forum->redir('index.php?mods=forum&page=viewtopic&id='.$id_redirige.( ( isset ( $_GET['js'] ) ) ? ('&js' ) : ('') ));
						
						$entete = "MIME-Version: 1.0\r\n";
						$entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
						
						// Mise a jour du lu/non-lu
						$query = $Bdd->sql ( 'SELECT id, lunonlu, abonnements, email, pseudo FROM '.PT.'_users WHERE id!="'.$uid.'" ANd id!="1"' );
						while ( $sql = $Bdd->get_array ( $query ) ){
							$honolulu = $sql['lunonlu'];
							
							// On abonne les utilisateurs abonnés au forum parent et on leur envoi un mail pour leur signaler l'arrivée du nouveau sujet
							$abo = $sql['abonnements'];
							if ( strpos ( $abo , '{all}' ) !== FALSE OR strpos ( $abo , '['.intval ( $_GET['newtopic'] ).']' ) ){
								$abo .= '('.$id_redirige.',1)';
								$entete .= "To: ".htmlspecialchars($sql['pseudo'])." <".htmlspecialchars($sql['email']).">\r\n";
								$entete .= "From: $nom_site\r\n";
								
								$new_topic_posted_mail = str_replace ( '{PSEUDO}' , htmlspecialchars ( $sql['pseudo'] ) , $new_topic_posted_mail );
								
								$url = str_replace ( 'http://' , '' , preg_replace ( '!/$!' , '' , $url_site ) );
								$lien = 'http://'.$url.'/index.php?mods=forum&page=viewtopic&id='.$id_redirige;
								
								$new_topic_posted_mail = str_replace ( '{URL}' , '<a href="'.$lien.'">'.$lien.'</a>' , $new_topic_posted_mail );
								
								@mail ( $sql['email'] , NEW_TOPIC_POSTED_MAIL, $new_topic_posted_mail, $entete);
							}
							
							foreach ( $forums as $value ){
								$honolulu = str_replace ( '('.$value.')' , '' , $honolulu );
								$honolulu .= '('.$value.')';
							}
							$honolulu = str_replace ( '{'.$id_redirige.';'.$first_forum.'}' , '' , $honolulu );
							$honolulu .= '{'.$id_redirige.';'.$first_forum.'}';
							$Bdd->sql ( 'UPDATE '.PT.'_users SET lunonlu="'.$honolulu.'", abonnements="'.$abo.'" WHERE id="'.$sql['id'].'"' );
						}
					}
				}
			}
		}
	}
	else{
		// Si le formulaire n'a pas ete valide, on lafficghe
		if ( isset ( $_GET['newtopic'] ) ){

			$template->assign_block_vars ( 'post',
			array ( 
				'TITLE' => FORUM,
				'FORMULAIRE' => default_form( TRUE ),
			)
			);
			// Case pour verrouiller ou attacher le sujet ;)
			if ( $grade == 4 OR ereg ( 'attach_topic;' , $permissions_f ) )
				$template->assign_block_vars ( 'post.post_attached', array ( 'ATTACH_TOPIC' => ATTACHED_TOPIC ) );
			if ( $grade == 4 OR ereg ( 'lock_topic;' , $permissions_f ) )
				$template->assign_block_vars ( 'post.post_locked', array ( 'LOCK_TOPIC' => LOCKED_TOPIC ) );
			// On affiche la case pour l'abonnement que l'on coche si l'utilisateur est abonné au forum ou si il à décidé d'etre automatiquement abonné a tous les nouveaux forums ;)
			if ( $grade > 0 )
				$template->assign_block_vars ( 'post.post_abo', array ( 
				'ABON' => ABON,
				'STATE' => ( ( strpos ( $u_abo , '{all}' ) !== FALSE OR strpos ( $u_abo , '['.intval ( $_GET['newtopic'] ).']' ) !== FALSE ) ? ('checked="checked"') : ('') ) ) );

		}
		else{

			// On recupere dernier post si il y a ;
			$query2 = $Bdd->sql( '
			SELECT 
				'.PT.'_users.pseudo as pseudo, 
				'.PT.'_forum_reply.contenu as contenu, 
				'.PT.'_forum_reply.date as date 
			FROM 
				'.PT.'_users, 
				'.PT.'_forum_reply 
			WHERE 
				'.PT.'_users.id = '.PT.'_forum_reply.auteur 
			AND 
				'.PT.'_forum_reply.parent = "'.intval ( $_GET['newreply'] ).'" 
			ORDER BY date DESC LIMIT 0,1' );

			$sql2 = $Bdd->get_array ( $query2 );

			if ( $Bdd->get_num_rows ( $query2 ) != 0 ){
				$last = TRUE;
				$ldate = $sql2['date'];
			}
			else{
				$last = FALSE;
				$ldate = 0;
			}

			// On affiche la derniere réponse si il y a
			if ( $last ){

				$template->assign_block_vars ( 'post_lastreply',
				array ( 
					'BY' => by,
					'THE' => the,
					'PSEUDO' => htmlspecialchars ( $sql2['pseudo'] ),
					'LAST_REPLY' => LAST_REPLY,
					'DATE' => ccmsdate ( $fuseaux , $sql2['date'] ),
					'CONTENU' => to_html ( $sql2['contenu'])
				)
				);

			// On recupere le post de lancement de conversation
			$query = $Bdd->sql ( '
			SELECT 
				'.PT.'_users.pseudo as pseudo,
				'.PT.'_forum_topic.nom as nom,
				'.PT.'_forum_topic.contenu as contenu,
				'.PT.'_forum_topic.date as date 
			FROM 
				'.PT.'_users,
				'.PT.'_forum_topic 
			WHERE 
				'.PT.'_users.id = '.PT.'_forum_topic.auteur 
			AND 
				'.PT.'_forum_topic.id = "'.intval($_GET['newreply']).'"' );

			$sql = $Bdd->get_array ( $query );

				$template->assign_block_vars ( 'post_main',
				array ( 
					'TOP' => MAIN_TOPIC,
					'TOP_NAME' => to_html ( $sql['nom'] ),
					'BY' => by,
					'PSEUDO' => htmlspecialchars ( $sql['pseudo'] ),
					'THE' => the,
					'DATE' => ccmsdate ( $fuseaux , $sql['date'] ),
					'CONTENU' => to_html ( $sql['contenu'])
				)
				);
			}
			$template->assign_block_vars ( 'post',
			array ( 
				'TITLE' => FORUM,
				'FORMULAIRE' => default_form (),
			)
			);

			$template->assign_block_vars ( 'post.post_reply', array ( 'LAST_DATE' => $ldate ) );
			
			// On affiche la case pour l'abonnement que l'on coche si l'utilisateur est abonné au forum ou si il à décidé d'etre automatiquement abonné a tous les nouveaux forums ;)
			if ( $grade > 0 )
				$template->assign_block_vars ( 'post.post_abo', array ( 
				'ABON' => ABON,
				'STATE' => ( ( strpos ( $u_abo , '('.intval ( $_GET['newreply'] ).',0)' ) !== FALSE OR strpos ( $u_abo , '('.intval ( $_GET['newreply'] ).',1)' ) !== FALSE ) ? ('checked="checked"') : ('') ) ) );


		}
	}
	// On ferme le bloc central
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>