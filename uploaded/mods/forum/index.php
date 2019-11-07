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

if( ereg("view_forum;",$permissions) || $grade == 4)
{
	// Si l'utilisateur a demande a voir les regles du forum, on les lui montre, sinon on lui affiche l'index du forum ;)
	if ( isset ( $_GET['rules'] ) ){
		$template->set_filename ( 'haut_mods.tpl' );
		$template->set_filename ( './modules/forum/index.tpl' );

		$template->assign_block_vars ( 'forum_rules' , array ( 
		'TITLE' => FORUM_RULES,
		'TXT' => to_html ( $forum_rules ),
		'BACK' => back) );

		$template->set_filename ( 'bas_mods.tpl' );
	}
	else{

		// On marque tous les forum comme lus
		if ( isset ( $_GET['reads'] ) ){
			$Bdd->sql('UPDATE '.PT.'_users SET lunonlu="" WHERE id="'.$uid.'"' );
			$Forum->redir('index.php?mods=forum',0);
		}
		
		// On active ou desactive l'abonnement automatique aux nouveaux sujets
		if ( isset ( $_GET['abogen'] ) AND isset ( $u_abo) ){
			if ( isset ( $_GET['on'] ) ){
				$Bdd->sql('UPDATE '.PT.'_users SET abonnements="{all}'.$u_abo.'" WHERE id="'.$uid.'"' );
				$u_abo = '{all}'.$u_abo;
			}
			else{
				$Bdd->sql('UPDATE '.PT.'_users SET abonnements="'.str_replace ( '{all}' , '' , $u_abo ).'" WHERE id="'.$uid.'"' );
				$u_abo = str_replace ( '{all}' , '' , $u_abo );
			}
		}
		
		// On se desabonne de tous les sujets et forums
		if ( isset ( $_GET['del_abo'] ) ){
			
			if ( strpos ( $u_abo , '{all}' ) === FALSE ){
				$Bdd->sql('UPDATE '.PT.'_users SET abonnements="" WHERE id="'.$uid.'"' );
				$u_abo = '';
			}
			else{
				$Bdd->sql('UPDATE '.PT.'_users SET abonnements="{all}" WHERE id="'.$uid.'"' );
				$u_abo = '{all}';
			}
			
		}
		
		// On s'abonne a tous les sujets et forums présent
		if ( isset ( $_GET['gen_abo'] ) ){
		
			$vis_forums = array ();
			$vis_topics = array ();
		
			// On récupere tous les forums auxquels s'abonner
			$q = $Bdd->sql('SELECT id, groupes, ecriture FROM '.PT.'_forum_for');
			while ( $s = $Bdd->get_array ( $q ) ){
				$grpes = $Forum->verif_groupes ( $s['groupes'] , $s['ecriture'] );
				
				if ( $grpes === TRUE ){
					$vis_forums[] = $s['id'];
				}				
			}
			$Bdd->free_result ( $q );
			
			// On recupere désormais les sujets auxquels s'abonner
			$q = $Bdd->sql ( 'SELECT id FROM '.PT.'_forum_topic WHERE parent IN ( '.implode ( ',' , $vis_forums ).' )' );
			while ( $s = $Bdd->get_array ( $q ) ){
				$vis_topics[] = $s['id'];
			}
			$Bdd->free_result ( $q );
			
			$abo = '';
			foreach ( $vis_forums AS $f ){
				$abo .= '['.$f.']';
			}
			
			foreach ( $vis_topics AS $t ){
				$abo .= '('.$t.',0)';
			}
			
			// On met a jour les abonnement du mec
			if ( strpos ( $u_abo , '{all}' ) === FALSE ){
				$Bdd->sql('UPDATE '.PT.'_users SET abonnements="'.$abo.'" WHERE id="'.$uid.'"' );
				$u_abo = $abo;
			}
			else{
				$Bdd->sql('UPDATE '.PT.'_users SET abonnements="{all}'.$abo.'" WHERE id="'.$uid.'"' );
				$u_abo = '{all}'.$abo;
			}
		
		}

		$template->set_filename ( 'haut_mods.tpl' );
		$template->set_filename ( './modules/forum/index.tpl' );
		$template->assign_block_vars ( 'forum_index' , array (
		'JS' => '
		<script type="text/javascript">
			<!--
				// Fonction remettre le texte par defaut dans l\'input
				function reload(){
					if(document.getElementById(\'search\').value == ""){
						document.getElementById(\'search\').value = "'.SEARCH.'";
						document.getElementById(\'search\').style.color ="grey";
					}
				}
				function load(){
					if(document.getElementById(\'search\').value == "'.SEARCH.'"){
						document.getElementById(\'search\').value=\'\';
						document.getElementById(\'search\').style.color=\'black\';
					}
				}
				
				function vis ( id ){
				
					if ( document.getElementById( id ).style.visibility == "hidden" ){
						document.getElementById( id ).style.visibility = "visible";
						document.getElementById( id ).style.height = "";
					}
					else{
						document.getElementById( id ).style.visibility = "hidden";
						document.getElementById( id ).style.height = "0px";
					}
				
				}
				
				function hide_cat( id ){

					// On recupere le contenu du cookie contenant les infos sur l\'etat des categorie
					var cookies = document.cookie.split(";");
					var i =0;
					var cook = "";
					while(i<cookies.length){
						var actual = cookies[i].split("=");
						if(actual[0]==2){
							cook = actual[1];
						}
						var i = i + 1;
					}

					if ( document.getElementById(\'cat:\'+id).style.visibility == "hidden" ){
						state = "visible";
						nostate = "hidden";
						document.getElementById(\'cat:\'+id).style.visibility = "visible";
						document.getElementById(\'cat:\'+id).style.height = "";
						document.getElementById(\'img:\'+id).src = "./themes/'.$u_theme.'/img/forum/visible.png";
					}
					else{
						state = "hidden";
						nostate = "visible";
						document.getElementById(\'cat:\'+id).style.visibility = "hidden";
						document.getElementById(\'cat:\'+id).style.height = "0px";
						document.getElementById(\'img:\'+id).src = "./themes/'.$u_theme.'/img/forum/hidden.png";
					}
					// Si aucune information sur cette categorie dans le cookie, on ajoute les infos dans le cookie
					if ( cook.indexOf ( "." + id ) == -1 ){
						cook += ".." + id + "." + state;
					}
					else{
						// Si le cookie comporte des informations vis a vis de cette cat, on les met a jour
						var reg = new RegExp("\.\." + id + "." + nostate, "g");
						cook = cook.replace ( reg , ".." + id + "." + state);
					}

					// On met a jour le cookie avec nouvelles valeurs
					var date_exp = new Date();
					date_exp.setTime(date_exp.getTime()+(365*24*3600*1000));
					document.cookie="2="+escape(cook)+((date_exp==null) ? "" : ("; date_exp="+date_exp.toGMTString()));

				}

			-->
		</script>',
		'NOM' => $nom_site,
		'ACCUEIL' => INDEX,
		'FORUM_RULES' => FORUM_RULES,
		'SEARCH' => SEARCH,
		'FAST_SEARCH' => FAST_SEARCH,
		'ON_THE_TITLE' => ON_THE_TITLE,
		'ON_THE_CONTENT' => ON_THE_CONTENT,
		'HELP' => HELP,
		'NEW_MESS' => NEW_MESS,
		'NEW_MESS_LOCKED' => NEW_MESS_LOCKED,
		'NONE_MESS' => NONE_MESS,
		'NONE_MESS_LOCKED' => NONE_MESS_LOCKED) );
		/*
		Variables pour les statistiques
		*/
		$nb_topics = 0;
		$nb_replys = 0;
		//

		$query2 = $Bdd->sql('
		SELECT 
			'.PT.'_forum_for.id AS forid,
			'.PT.'_forum_for.moderators AS moderators,
			'.PT.'_forum_for.parent AS forparent,
			'.PT.'_forum_for.nom AS fornom,
			'.PT.'_forum_for.def AS fordef,
			'.PT.'_forum_for.sujets AS forsujets,
			'.PT.'_forum_for.messages AS formessages,
			'.PT.'_forum_for.is_sub AS foris_sub,
			'.PT.'_forum_for.position AS forposition,
			'.PT.'_forum_for.ecriture AS forecriture,
			'.PT.'_forum_for.groupes AS forgroupes,
			'.PT.'_forum_for.locked AS forlocked,
			'.PT.'_forum_for.lastmess AS forlastmess 
		FROM 
			'.PT.'_forum_for 
		WHERE 
			'.PT.'_forum_for.is_sub = "0" 
		ORDER BY 
			'.PT.'_forum_for.position' );

		$forum = array();
		$a = 0;
		$total_modos = '';

		while ( $rep1 = mysql_fetch_array ( $query2 ) ){
			// Variable contenant les pseudo de tous les moderateurs pour recuperer tous leur pseudo en une requete ;)
			$total_modos .= $rep1['moderators'];

			// On rempli array qui contient les forums a afficher
			$forum[$rep1['forid']] = array('nom' => to_html ($rep1['fornom']), 'modos' => $rep1['moderators'] , 'parent' => $rep1['forparent'], 'def' => to_html($rep1['fordef']), 'sujets' => $rep1['forsujets'], 'messages' => $rep1['formessages'], 'sub' => $rep1['foris_sub'], 'position' => $rep1['forposition'], 'ecriture' => $rep1['forecriture'], 'groupes' => $rep1['forgroupes'], 'locked' => $rep1['forlocked'], 'lastmess'=> to_html ( $rep1['forlastmess'] ));
			$a ++;
		}
		mysql_free_result($query2);

		// On recupere le pseudo de tous les modos associes au forum ;)
		$total_modos = substr ( $total_modos , 0 , strlen ( $total_modos ) - 1 );
		if ( $total_modos != '' ){
			$condition = 'WHERE id IN ( '.$total_modos.' )';
			$q_modo = $Bdd->get_cached_data ( 'SELECT id, pseudo FROM '.PT.'_users '.$condition , 86400 , 'forum' );
			$modos_pseudo = array ();
			foreach ( $q_modo AS $array ){
				$modos_pseudo [ $array['id'] ] = $array['pseudo'];
			}
		}
		else{
			$modos_pseudo = array ();
		}
		$req_cat = $Bdd->get_cached_data('
		SELECT 
			'.PT.'_forum_cat.id AS catid,
			'.PT.'_forum_cat.nom AS catnom ,
			'.PT.'_forum_cat.def AS catdef ,
			'.PT.'_forum_cat.groupes AS cat_groupes,
			'.PT.'_forum_cat.ecriture AS cat_ecriture 
		FROM 
			'.PT.'_forum_cat 
		ORDER BY '.PT.'_forum_cat.position ' , 86400 , 'forum');

		if( count ( $req_cat ) <1 ){
			$template->assign_block_vars ( 'forum_index.forum_index_none' , array ( 'TXT' => NO_FORUM ) );
		}
		else{

			if($grade>0){
			
				$template->assign_block_vars ( 'forum_index.user_option' , array ( 'OPTION' => FORUM_USER_OPTION ) );
			
				$template->assign_block_vars ( 'forum_index.user_option.forum_mark_reads' , array ( 'TXT' => FORUM_ALL_READS ) );
				
				$template->assign_block_vars ( 'forum_index.user_option.forum_del_abo' , array ( 'TXT' => STOP_ABOS ) );
				
				$template->assign_block_vars ( 'forum_index.user_option.forum_gen_abo' , array ( 'TXT' => GENERAL_ABOS ) );
				
				if ( strpos ( $u_abo , '{all}' ) === FALSE )
					$template->assign_block_vars ( 'forum_index.user_option.forum_abogen' , array ( 
						'TXT' => FORUM_ABO_AUTO,
						'URL' => 'index.php?mods=forum&amp;abogen&amp;on') );
				else
					$template->assign_block_vars ( 'forum_index.user_option.forum_abogen' , array ( 
						'TXT' => FORUM_UNABO_AUTO,
						'URL' => 'index.php?mods=forum&amp;abogen&amp;off') );
			}
			$c = 0;

			foreach ( $req_cat AS $id => $rep ){

				$grpes = $Forum->verif_groupes ( $rep['cat_groupes'] , $rep['cat_ecriture'] );

				if ( $grpes === true ){
					$c ++;

					// On regarde si l'utilisateur n'a pas cache cette categorie ;)
					$visible = "visible";
					if ( isset ( $_COOKIE['2'] ) ){
						$arr = explode ( '..' , $_COOKIE['2'] );
						foreach ( $arr as $ar ){
							$ars = explode ( '.' , $ar );
							if ( $ars[0] == $rep['catid'] ){
								$visible = $ars[1];
							}
						}
					}
					else{
						$visible = "visible";
					}

					// On affiche les cats
					$template ->assign_block_vars ( 'forum_index.forum_cats' , array (
					'ID' => $rep['catid'],
					'VISIBLE' => $visible,
					'NOM' => $rep['catnom'],
					'DEF' => $rep['catdef'] ) );

					$a = 0;

					// On affiche le forum des News si jamais l'option est activé et que cette catégorie est celle choisie
					if ( $news_to_forum == 1 && $news_to_forum_cat == $rep['catid'] ){
						if($a == 0){
							$height = '0px';
							if ( $visible == "visible")$height = '';
							$template ->assign_block_vars ( 'forum_index.forum_cats.forum_for_haut' , array (
							'ID' => $rep['catid'],
							'VISIBLE' => $visible,
							'HEIGHT' => $height,
							'CATS' => CATS,
							'TOPICS' => TOPICS,
							'REPLYS' => REPLYS,
							'LAST_MESS' => LAST_MESS ) );
						}

						$query = $Bdd->sql ( 'SELECT id FROM '.PT.'_news' );
						$nb_news = $Bdd->get_num_rows ( $query );
						$Bdd->free_result ( $query );

						$query = $Bdd->sql ( 'SELECT id FROM '.PT.'_comment' );
						$nb_comment = $Bdd->get_num_rows ( $query );
						$Bdd->free_result ( $query );

						$nb_topics = $nb_topics + $nb_news;
						$nb_replys = $nb_replys + $nb_comment;

						$template->assign_block_vars ( 'forum_index.forum_cats.forum_fors' , array (
						'IMG' => 'none',
						'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id=999999999999',
						'NOM' => $news_to_forum_cat_name,
						'DEF' => '',
						'MODERATORS' => '',
						'MODOS' => '',
						'SUJETS' => $nb_news,
						'MESSAGES' => $nb_comment ) );

						$template->assign_block_vars ( 'forum_index.forum_cats.forum_fors.nlm' , array ( 'TXT' => NOT_ASSIGNABLE ) );

						$a ++;
					}

					foreach($forum AS $id_for => $array){

						if($id_for != '' && $array!='' && $rep['catid'] == $forum[$id_for]['parent']){

							$grpes = $Forum->verif_groupes ( $array['groupes'] , $array['ecriture'] );
							if ( $grpes === true ){

								if($a == 0){
									$height = '0px';
									if ( $visible == "visible")$height = '';
									$template ->assign_block_vars ( 'forum_index.forum_cats.forum_for_haut' , array (
									'ID' => $rep['catid'],
									'VISIBLE' => $visible,
									'HEIGHT' => $height,
									'CATS' => FORUM,
									'TOPICS' => TOPICS,
									'REPLYS' => REPLYS,
									'LAST_MESS' => LAST_MESS ) );
								}
								$a++;

								$moderators = '';
								$mod = explode ( ',' , $forum[$id_for]['modos'] );
								foreach ( $mod AS $id ){
									if ( $id != '' ){
										$moderators .= ' <a href="./index.php?mods=espace_membre&page=profil&id='.$id.'">'.$modos_pseudo [ $id ] .'</a>,';
									}
								}
								$moderators = substr ( $moderators , 0 , strlen ( $moderators ) - 1 );

								//On verifie si il y a de nouveaux messages et si le forum est verrouille
								if ( ereg ( '\('.$id_for.'\)' , $lunonlu ) ){
									if ( $forum[$id_for]['locked'] == 0 )
										$img = 'new';
									else
										$img = 'new_locked';
								}
								else{
									if ( $forum[$id_for]['locked'] == 0 )
										$img = 'none';
									else
										$img = 'none_locked';
								}

								$template->assign_block_vars ( 'forum_index.forum_cats.forum_fors' , array (
								'IMG' => $img,
								'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id='.$id_for,
								'NOM' => $forum[$id_for]['nom'],
								'DEF' => $forum[$id_for]['def'],

								'SUJETS' => $forum[$id_for]['sujets'],
								'MESSAGES' => $forum[$id_for]['messages'] ) );

								if ( $forum[$id_for]['lastmess'] != '' && $forum[$id_for]['lastmess'] != '|*--*||*--*||*--*|' ){
									$last = explode ( '|*--*|' , $forum[$id_for]['lastmess'] );
									$template->assign_block_vars ( 'forum_index.forum_cats.forum_fors.lm' , array (
									'LM_THE' => the,
									'LM_URL' => 'index.php?mods=forum&page=viewtopic&id='.$last[2],
									'LM_DATE' => ccmsdate($fuseaux,$last[1]),
									'LM_INTO' => INTO,
									'LM_SUJET' => htmlspecialchars($last[3]),
									'LM_BY' => by,
									'LM_PSEUDO' => htmlspecialchars($last[0]) ) );
								}
								else{
									$template->assign_block_vars ( 'forum_index.forum_cats.forum_fors.nlm' , array ( 'TXT' => NO_MESS ) );
								}

								if ( $moderators != '' ){
									$template->assign_block_vars ( 'forum_index.forum_cats.forum_fors.moderators' , array (
										'MODERATORS' => MODERATORS,
										'MODOS' => $moderators
									) );
								}

								$nb_topics = $nb_topics + $forum[$id_for]['sujets'];
								$nb_replys = $nb_replys + $forum[$id_for]['messages'];
							}
						}
					}
					if($a > 0 ){
						$template ->assign_block_vars ( 'forum_index.forum_cats.forum_for_bas' , array () );
					}
				}
			}

			if($c ==0){
				$template->assign_block_vars ( 'forum_index.forum_index_none' , array ( 'TXT' => NO_FORUM ) );
			}
		}

		$template->assign_block_vars ( 'forum_index.forum_index_stats' , array (
		'STATISTICS' => STATISTICS,
		'NB_TOPIC' => NB_TOPICS,
		'NB_TOPICS' => $nb_topics,
		'NB_REPLY' => NB_REPLYS,
		'NB_REPLYS' => $nb_replys ) );

		$template->set_filename ( 'bas_mods.tpl' );

	}
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>
