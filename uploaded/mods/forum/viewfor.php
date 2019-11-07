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

if ( $_GET['id'] != '999999999999' ){

	//On récupère tous les sous forum et le forum actuel
	$query_for = $Bdd->sql ( '
	SELECT
		'.PT.'_forum_for.id , 
		'.PT.'_forum_for.nom , 
		'.PT.'_forum_for.ecriture , 
		'.PT.'_forum_for.groupes , 
		'.PT.'_forum_for.locked , 
		'.PT.'_forum_for.parent , 
		'.PT.'_forum_for.is_sub , 
		'.PT.'_forum_for.def , 
		'.PT.'_forum_for.sujets , 
		'.PT.'_forum_for.messages , 
		'.PT.'_forum_for.lastmess ,
		'.PT.'_forum_for.moderators,
		'.PT.'_forum_for.cat_parent AS cat_parent
	FROM 
		'.PT.'_forum_for
	WHERE 
		(
			'.PT.'_forum_for.is_sub = "1" 
		AND 
			'.PT.'_forum_for.parent = "'.intval($_GET['id']).'" 
		)
		OR 
		'.PT.'_forum_for.id="'.intval($_GET['id']).'"' );

	$array_for = array();
	$total_modos = '';

	while($sql_for = mysql_fetch_array($query_for)){
		$array_for [ $sql_for['id'] ] = array(
		'is_sub' => $sql_for['is_sub'],
		'nom' => to_html ( $sql_for['nom'] ),
		'ecriture' => $sql_for['ecriture'],
		'groupes' => $sql_for['groupes'],
		'locked' => $sql_for['locked'],
		'parent' => $sql_for['parent'],
		'def' => to_html ( $sql_for['def'] ),
		'sujets' => $sql_for['sujets'],
		'messages' => $sql_for['messages'],
		'lastmess' => to_html ( $sql_for['lastmess'] ),
		'modos' => $sql_for['moderators'],
		'cat_parent' => $sql_for['cat_parent']
		);
		$total_modos .= $sql_for['moderators'];
	}
	$p = $Bdd->get_cached_data ( 'SELECT nom FROM '.PT.'_forum_cat WHERE id="'.$array_for[ intval ( $_GET['id'] ) ]['cat_parent'].'"' , 86400 , 'forum' );

	$cat_name = $p[0]['nom'];

	$Bdd->free_result($query_for);

	// On recupere le pseudo de tous les modos associes au forum ;)
	$total_modos = substr ( $total_modos , 0 , strlen ( $total_modos ) - 1 );
	if ( $total_modos != '' ){
		$condition = 'WHERE id IN ( '.$total_modos.' )';
	}
	else{
		$condition = '';
	}
	$q_modo = $Bdd->get_cached_data ( 'SELECT id, pseudo FROM '.PT.'_users '.$condition , 86400 , 'forum' );
	$modos_pseudo = array ( );
	foreach ( $q_modo AS $array ){
		$modos_pseudo [ $array['id'] ] = $array['pseudo'];
	}

	// Si l'utilisateur est moderateur de ce forum, on lui donne les permissions de moderateur ici.
	$modos = $Forum->is_mod ( $array_for [ intval ( $_GET['id'] ) ]['modos'] );
	$permissions_f = $permissions.$modos['perms'];

}
else{
	$permissions_f = $permissions;
}

if( ereg("view_forum_for;",$permissions_f) OR $grade == 4 ){

	// On regarde si ce forum est destiné a afficher les News ou pas ;)
	if ( $_GET['id'] == '999999999999' ){

		$template->set_filename ( 'haut_mods.tpl' );
		$template->set_filename ( './modules/forum/viewfor.tpl' );
		$p = $Bdd->get_cached_data ( 'SELECT nom FROM '.PT.'_forum_cat WHERE id="'.$news_to_forum.'"' , 86400 , 'forum' );
		$cat_name = $p[0]['nom'];

		$template->assign_block_vars ( 'forum_news' , array (
		'JS' => '
		<script type="text/javascript">
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
		</script>',
		'NOM' => $nom_site,
		'ACCUEIL' => INDEX,
		'FORUM_RULES' => FORUM_RULES,
		'SEARCH' => SEARCH,
		'FAST_SEARCH' => FAST_SEARCH,
		'ON_THE_TITLE' => ON_THE_TITLE,
		'ON_THE_CONTENT' => ON_THE_CONTENT,
		'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id='.htmlspecialchars($_GET['id']),
		'CAT_NAME' => to_html ( $cat_name ),
		'NAME' => htmlspecialchars ( $news_to_forum_cat_name ) ) );

			// On compte le nombre de réponses pour afficher les differentes pages possibles ;)
		$nb_reply = $Bdd->sql ( 'SELECT COUNT(*) AS nb_news FROM '.PT.'_news' );
		$nb = $Bdd->get_array($nb_reply);

		$pages = ceil ( $nb['nb_news'] / $forum_nb_topic_page );

				// Gestion du multipage.

				if ( isset ( $_GET['nb_page'] ) ){
					$page = intval ( $_GET['nb_page'] );
					$id_depart = ( $page * $forum_nb_topic_page ) - $forum_nb_topic_page;
				}
				else{
					$page = 1;
					$id_depart = 0;
				}
			
			give_pages ( $pages , array ( 'forum_news.page_haut' , 'forum_news.page_bas' ) , './index.php?mods=forum&amp;page=viewfor&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page=' , $page );

			$sql = $Bdd->sql('
			SELECT 
				n.id AS id,
				n.titre AS nom,
				n.date AS datenews,
				n.auteur AS id_auteur,
				n.contenu AS contenunews, 
				n.hit AS hitnews,
				n.groupes AS groupes,
				n.comments AS nb_com,
				n.add_coment AS unlocked,
				u.pseudo AS pseudo
			FROM '.PT.'_news AS n
			LEFT JOIN '.PT.'_users AS u
			ON u.id=n.auteur
			WHERE n.publication <= "'.time().'"
			GROUP BY n.id
			ORDER BY n.id DESC LIMIT '.$id_depart.','.$forum_nb_topic_page );
			$b = $c = 0;
			while ( $sql_topic = $Bdd->get_array ( $sql ) ){

				if($c==0){
						$template->assign_block_vars ( 'forum_news.news_header' , array (
						'TOPICS' => TOPICS,
						'AUTHORS' => AUTHORS,
						'REPLYS' => REPLYS ) );
				}
				$perm = false;
				if($sql_topic['groupes'] ==''){
					$perm = true;
				}
				else{
					//On regarde si le gorupe du membre est le même que celui de la news, ou si la news est visible par tout le monde
					$news_groupe = explode(';',$sql_topic['groupes']);
					foreach ( $news_groupe as $news_see ){
						if (eregi(';'.$news_see.';',$groupe) OR eregi('^'.$news_see.';',$groupe)){
							$perm = true;
						}
					}
				}
				if ( $perm === true ){
					$template->assign_block_vars ( 'forum_news.news' , array (
					'URL' => './index.php?mods=forum&amp;page=viewtopic&amp;id=news:'.$sql_topic['id'],
					'NOM' => to_html ($sql_topic['nom']),
					'PROFIL_URL' => 'index.php?mods=espace_membre&amp;page=profil&amp;id='.$sql_topic['id_auteur'],
					'PSEUDO' => htmlspecialchars($sql_topic['pseudo']),
					'MESSAGES' => $sql_topic['nb_com'] ) );
					$b++;
				}
				$c++;
			}
			if ( $b == 0 ){
				$template->assign_block_vars ( 'forum_news.none' , array ('TXT' => NOONE_NEWS ) );
			}
			$template->assign_block_vars ( 'forum_news.news_footer' , array () );
			$template->set_filename ( 'bas_mods.tpl' );
	}
	else{

		// On verifie que l'user a l'autorisation d'acceder au forum
		$grpes = $Forum->verif_groupes ( $array_for[intval($_GET['id'])]['groupes'] , $array_for[intval($_GET['id'])]['ecriture'] );
		if ($grpes === true) {

			$template->set_filename ( 'haut_mods.tpl' );
			$template->set_filename ( './modules/forum/viewfor.tpl' );

			$template->assign_block_vars ( 'forum_for' , array (
			'JS' => '
			<script type="text/javascript">
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
				function redir ( url ){
					window.location.href = url;
				}
			</script>',
			'NOM' => $nom_site,
			'ACCUEIL' => INDEX,
			'CAT_PARENT' => to_html ( $cat_name ),
			'FORUM_RULES' => FORUM_RULES,
			'SEARCH' => SEARCH,
			'FAST_SEARCH' => FAST_SEARCH,
			'ON_THE_TITLE' => ON_THE_TITLE,
			'ON_THE_CONTENT' => ON_THE_CONTENT,
			'ACCUEIL' => INDEX ) );

			$template->assign_block_vars ( 'forum_for.links2' , array(
			'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id='.intval($_GET['id']),
			'NOM' => to_html ( $array_for[intval($_GET['id'])]['nom'] ) ) );

			// Si ce forum est un sous forum, on recupere forum parent
			if ( $array_for[ intval ( $_GET['id'] ) ]['is_sub'] == 1 ){

				$qquery = $Bdd->sql ( 'SELECT id, nom, is_sub FROM '.PT.'_forum_for WHERE id="'.$array_for[ intval ( $_GET['id'] ) ]['parent'].'"' );
				$ssql = $Bdd->get_array ( $qquery );

				$template->assign_block_vars ( 'forum_for.links1' , array(
				'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id='.$ssql['id'],
				'NOM' => to_html ( $ssql['nom'] )) );

				// Si le forum parent du forum parent, est un sous forum, on indique qu'il y a d'autres forum au dessus
				if ( $ssql['is_sub'] == 1){
					$template->assign_block_vars ( 'forum_for.links' , array() );
				}

			}
			$a = 0;
			foreach($array_for as $id => $array){
				if($id != '' AND $array['is_sub'] == 1 AND $array['parent'] == intval($_GET['id'])){
					if($a == 0){
						$template->assign_block_vars ( 'forum_for.sub_head' , array(
						'TITRE' => SUBS,
						'CATS' => CATS,
						'TOPICS' => TOPICS,
						'REPLYS' => REPLYS,
						'LAST_MESS' => LAST_MESS ) );
					}

					$moderators = '';
					$mod = explode ( ',' , $array['modos'] );
					foreach ( $mod AS $suid ){
						if ( $suid != '' ){
							$moderators .= ' <a href="./index.php?mods=espace_membre&page=profil&id='.$suid.'">'.$modos_pseudo [ $suid ] .'</a>,';
						}
					}
					$moderators = substr ( $moderators , 0 , strlen ( $moderators ) - 1 );

					//On verifie si il y a de nouveaux messages et si le forum est verrouille
					if ( ereg ( '\('.$id.'\)' , $lunonlu ) ){
						if ( $array_for[$id]['locked'] == 0 )
							$img = 'new';
						else
							$img = 'new_locked';
					}
					else{
						if ( $array_for[$id]['locked'] == 0 )
							$img = 'none';
						else
							$img = 'none_locked';
					}

					$template->assign_block_vars ( 'forum_for.sub_fors' , array (
					'IMG' => $img,
					'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id='.$id,
					'NOM' => $array_for[$id]['nom'],
					'DEF' => $array_for[$id]['def'],

					'SUJETS' => $array_for[$id]['sujets'],
					'MESSAGES' => $array_for[$id]['messages'] ) );

					if ( $array_for[$id]['lastmess'] != '' && $array_for[$id]['lastmess'] != '|*--*||*--*||*--*|' ){

						$last = explode ( '|*--*|' , $array_for[$id]['lastmess'] );
						$template->assign_block_vars ( 'forum_for.sub_fors.lm' , array (
						'LM_THE' => the,
						'LM_URL' => 'index.php?mods=forum&page=viewtopic&id='.$last[2],
						'LM_DATE' => ccmsdate($fuseaux,$last[1]),
						'LM_INTO' => INTO,
						'LM_SUJET' => htmlspecialchars($last[3]),
						'LM_BY' => by,
						'LM_PSEUDO' => htmlspecialchars($last[0]) ) );
					}
					else{
						$template->assign_block_vars ( 'forum_for.sub_fors.nlm' , array (
						'TXT' => NO_MESS) );
					}

					if ( $moderators != '' ){
						$template->assign_block_vars ( 'forum_for.sub_fors.moderators' , array (
							'MODERATORS' => MODERATORS,
							'MODOS' => $moderators
						) );
					}
					$a++;
				}
			}
			if($a > 0){
				$template->assign_block_vars ( 'forum_for.sub_footer' , array() );
			}


			//On vérifie que l'utilisateur actuel à le droit de psoter des sujets
			//Si le sujet est verrouille, seul les administrateurs peuvent poster ;)
			$grpes = $Forum->verif_groupes ( $array_for[intval($_GET['id'])]['groupes'] , $array_for[intval($_GET['id'])]['ecriture'] , false);
			if ( ( $array_for[intval($_GET['id'])]['locked'] == 0 AND ( ereg('post_topic;',$permissions_f) ) AND $grpes === true ) OR $grade == 4 ) {
				//si mec a lautorisation de poster, on lui affiche un lien
				$template->assign_block_vars ( 'forum_for.post_haut' , array ( 
				'URL' => './index.php?mods=forum&amp;page=post&amp;newtopic='.intval($_GET['id']),
				'TXT' => POST_NEWTOPIC) );

				$template->assign_block_vars ( 'forum_for.post_bas' , array ( 
				'URL' => './index.php?mods=forum&amp;page=post&amp;newtopic='.intval($_GET['id']),
				'TXT' => POST_NEWTOPIC) );
			}

		// On compte le nombre de réponses pour afficher les differentes pages possibles ;)
		$nb_reply = $Bdd->sql ( 'SELECT COUNT(*) AS nb_topic FROM '.PT.'_forum_topic WHERE '.PT.'_forum_topic.parent = "'.intval($_GET['id']).'"' );
		$nb = $Bdd->get_array($nb_reply);

		$pages = ceil ( $nb['nb_topic'] / $forum_nb_topic_page );

				// Gestion du multipage.

				if ( isset ( $_GET['nb_page'] ) ){
					$page = intval ( $_GET['nb_page'] );
					$id_depart = ( $page * $forum_nb_topic_page ) - $forum_nb_topic_page;
				}
				else{
					$page = 1;
					$id_depart = 0;
				}

			give_pages ( $pages , array ( 'forum_for.pages_haut' , 'forum_for.pages_bas' ) , './index.php?mods=forum&amp;page=viewfor&amp;id='.intval($_GET['id']).'&amp;nb_page=' , $page );

			$b = 0;
			//On récupère tous les sujets
			$query_topic = $Bdd->sql('
			SELECT 
				'.PT.'_users.pseudo AS pseudo,
				'.PT.'_forum_topic.attached AS attached,
				'.PT.'_forum_topic.locked AS locked,
				'.PT.'_forum_topic.id AS id,
				'.PT.'_forum_topic.nom AS nom,
				'.PT.'_forum_topic.auteur as auteur,
				'.PT.'_forum_topic.messages AS messages,
				'.PT.'_forum_topic.lastmess AS lastmess,
				'.PT.'_forum_topic.parent AS parent,
				'.PT.'_forum_topic.vue AS vue 
			FROM
				'.PT.'_forum_topic,
				'.PT.'_users 
			WHERE 
				parent="'.intval($_GET['id']).'" 
			AND 
				'.PT.'_users.id = '.PT.'_forum_topic.auteur 
			ORDER BY 
				'.PT.'_forum_topic.attached DESC, '.PT.'_forum_topic.lastreply_date DESC, '.PT.'_forum_topic.date DESC LIMIT '.$id_depart.','.$forum_nb_topic_page );

			$template->assign_block_vars ( 'forum_for.topics' , array ( 'TOPICS' => TOPIC ) );

			while($sql_topic = mysql_fetch_array($query_topic)){
					if($b==0){
						$template->assign_block_vars ( 'forum_for.topics.head' , array ( 
						'TOPICS' => TOPICS,
						'AUTHORS' => AUTHORS,
						'REPLYS' => REPLYS,
						'HITS' => HITS,
						'LAST_MESS' => LAST_MESS ) );
					}

					//On verifie si il y a de nouveaux messages 
					if(ereg('\{'.$sql_topic['id'].';'.intval($_GET['id']).'\}',$lunonlu))
						$img = 'new';
					else
						$img = 'none';

					$template->assign_block_vars ( 'forum_for.topics.top' , array (
					'IMG' => $img,
					'URL' => './index.php?mods=forum&amp;page=viewtopic&amp;id='.$sql_topic['id'],
					'NOM' => to_html ($sql_topic['nom']),
					'PROFIL_URL' => 'index.php?mods=espace_membre&amp;page=profil&amp;id='.$sql_topic['auteur'],
					'PSEUDO' => htmlspecialchars($sql_topic['pseudo']),
					'MESSAGES' => $sql_topic['messages'],
					'VU' => $sql_topic['vue'] ) );
					$b++;

					if ( $sql_topic['lastmess']!=''){
						$last = explode('|*--*|',$sql_topic['lastmess']);
						$lastm = 	by.' '.htmlspecialchars($last[0]).' '.the.' '.ccmsdate($fuseaux,$last[1]);

						$template->assign_block_vars ( 'forum_for.topics.top.lm' , array (
						'LM_THE' => the,
						'LM_DATE' => ccmsdate($fuseaux,$last[1]),
						'LM_BY' => by,
						'LM_PSEUDO' => htmlspecialchars($last[0]) ) );
					}
					else{
						$template->assign_block_vars ( 'forum_for.topics.top.no_lm' , array (
							'TXT' => NO_MESS ) );
					}

					if ( $sql_topic['locked'] == 1 )$template->assign_block_vars ( 'forum_for.topics.top.locked' , array () );
					if ( $sql_topic['attached'] == 1 )$template->assign_block_vars ( 'forum_for.topics.top.attached' , array () );
			}
			mysql_free_result($query_topic);

			if ( $b > 0 )
				$template->assign_block_vars ( 'forum_for.topics.footer' , array () );

			if($b == 0){
				$template->assign_block_vars ( 'forum_for.topics.ntop' , array (
					'TXT' => NOONE_TOPIC ) );
			}

			$template->set_filename ( 'bas_mods.tpl' );
		}
		else{
			// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
			$template->set_filename('error_page.tpl' );
			$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
		}

	}

}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>