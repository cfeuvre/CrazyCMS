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

// On charge infos du sujet et forum si on affiche un sujet
if ( !isset ( $_GET['id'] ) OR substr ( $_GET['id'] , 0 ,4 ) != 'news' ){

if ( isset ( $_GET['id'] ) )
	$id = intval ( $_GET['id'] );
else if ( isset ( $_GET['attach'] ) )
	$id = intval ( $_GET['attach'] );
else if ( isset ( $_GET['unattach'] ) )
	$id = intval ( $_GET['unattach'] );
else if ( isset ( $_GET['lock'] ) )
	$id = intval ( $_GET['lock'] );
else if ( isset ( $_GET['unlock'] ) )
	$id = intval ( $_GET['unlock'] );
else if ( isset ( $_GET['signal'] ) )
	$id = intval ( $_GET['signal'] );

	$query_topic = $Bdd->sql('
	SELECT  
		'.PT.'_forum_topic.id as id, 
		'.PT.'_forum_topic.attached as attached, 
		'.PT.'_forum_topic.locked as locked, 
		'.PT.'_forum_topic.parent as parent, 
		'.PT.'_forum_topic.auteur as id_auteur, 
		'.PT.'_forum_topic.nom as nom, 
		'.PT.'_forum_topic.contenu as contenu,
		'.PT.'_forum_topic.date as date, 
		'.PT.'_forum_topic.messages as messages, 
		'.PT.'_forum_topic.smileys as smileys, 
		'.PT.'_forum_topic.bb as bb, 
		'.PT.'_forum_topic.groupes as groupes, 
		'.PT.'_forum_topic.ecriture as ecriture,
		'.PT.'_forum_topic.cat_parent AS cat_parent,
		'.PT.'_users.pseudo as pseudo, 
		'.PT.'_users.avatar as avatar, 
		'.PT.'_users.nb_post as nb_post, 
		'.PT.'_users.icq as icq, 
		'.PT.'_users.msn as msn, 
		'.PT.'_users.aim as aim, 
		'.PT.'_users.yahoom as yahoom,
		'.PT.'_users.reputation as reputation, 
		'.PT.'_users.avertissements as avertissements, 
		'.PT.'_users.privacy as privacy, 
		'.PT.'_users.email as email, 
		'.PT.'_users.signature as signature, 
		'.PT.'_users.grades AS grades 
	FROM 
		'.PT.'_forum_topic, 
		'.PT.'_users 
	WHERE 
		'.PT.'_forum_topic.id = "'.$id.'"
	AND 
		'.PT.'_forum_topic.auteur = '.PT.'_users.id
	' );

	$sql_top = $Bdd->get_array($query_topic);

	$p = $Bdd->get_cached_data ( 'SELECT nom FROM '.PT.'_forum_cat WHERE id="'.$sql_top['cat_parent'].'"' , 86400 , 'forum' );
	$cat_parent = $p[0]['nom'];

	$id_forum = $sql_top['parent'];
	$attach = $sql_top['attached'];
	$lock = $sql_top['locked'];

	//On récupère le forum parent
	$query_for = $Bdd->sql('SELECT ecriture,groupes,locked,is_sub, parent,nom, moderators FROM '.PT.'_forum_for WHERE id="'.$sql_top['parent'].'"' );
	$array_for = mysql_fetch_array($query_for);

	// On met l'arborescence dans un array pour la gerer par les templates apres ;)
	$links = array ();

	if ( isset ( $_GET['id'] ) ){
			$links[2] = array ( intval($sql_top['parent']) , to_html ( $array_for['nom'] ) );
			$links[3] = array ( intval($_GET['id']) , to_html ( $sql_top['nom'] ) );

		// Si ce forum est un sous forum, on recupere forum parent
		if ( $array_for['is_sub'] == 1 ){

			$qquery = $Bdd->sql ( 'SELECT id, nom, is_sub FROM '.PT.'_forum_for WHERE id="'.$array_for['parent'].'"' );
			$ssql = $Bdd->get_array ( $qquery );

			$links[1] = array ( $ssql['id'] , to_html ( $ssql['nom'] ) );

			// Si le forum parent du forum parent, est un sous forum, on indique qu'il y a d'autres forum au dessus
			if ( $ssql['is_sub'] == 1){
				$links[0] = TRUE;
			}

		}
	}

	// Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
	$modo = $Forum->is_mod ( $array_for['moderators'] );
	$permissions_f = $permissions.$modo['perms'];

}
else{
	$permissions_f = $permissions;
}

if( ( ereg ( "view_forum_topic;" , $permissions_f ) OR $grade == 4  ) AND isset($_GET['id'] ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/forum/viewtopic.tpl' );

	if ( substr ( $_GET['id'] , 0 ,4 ) == 'news' ){

		$id = intval ( substr ( $_GET [ 'id' ] , 5 , strlen ( $_GET [ 'id' ] ) ) );

		$query = $Bdd->sql('SELECT n.id AS id,
								n.titre AS nom,
								n.date AS date,
								n.auteur AS id_auteur,
								n.contenu AS contenu, 
								n.hit AS hitnews,
								u.grades AS grades,
								n.groupes AS groupes,
								n.comments AS nb_com,
								n.add_coment AS unlocked,

								u.pseudo AS pseudo,
								u.icq AS icq,
								u.msn AS msn,
								u.aim AS aim,
								u.yahoom AS yahoom,
								u.avatar AS avatar,
								u.nb_post AS nb_post,
								u.avertissements AS avertissements,
								u.reputation AS reputation,
								u.signature AS signature,
								u.email AS email,
								u.privacy AS privacy
			FROM '.PT.'_news AS n
			LEFT JOIN '.PT.'_users AS u
			ON (u.id=n.auteur AND n.valid="1") 
			WHERE n.id = "'.$id.'"
			AND n.publication <= "'.time().'"' );

		$sql = $Bdd->get_array ( $query );
		$Bdd->free_result ( $query );

		$perm = false;
		if($sql['groupes'] ==''){
			$perm = true;
		}
		else{
			//On regarde si le gorupe du membre est le même que celui de la news, ou si la news est visible par tout le monde
			$news_groupe = explode(';',$sql['groupes']);
			foreach ( $news_groupe as $news_see ){
				if (eregi(';'.$news_see.';',$groupe) OR eregi('^'.$news_see.';',$groupe)){
					$perm = true;
				}
			}
		}
		if ( $perm === true ){

			$p = $Bdd->get_cached_data ( 'SELECT nom FROM '.PT.'_forum_cat WHERE id="'.$news_to_forum.'"' , 86400 , 'forum' );
			$cat_parent = $p[0]['nom'];

			$template->assign_block_vars ( 'forum_news_head' , array (
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
				function redir(url){
					window.location.href = url;
				}
			</script>',
			'NOM' => $nom_site,
			'ACCUEIL' => INDEX,
			'CAT_PARENT' => to_html ( $cat_parent ),
			'FORUM_RULES' => FORUM_RULES,
			'SEARCH' => SEARCH,
			'FAST_SEARCH' => FAST_SEARCH,
			'ON_THE_TITLE' => ON_THE_TITLE,
			'ON_THE_CONTENT' => ON_THE_CONTENT,
			'PROFIL_URL' => ( ( $sql['id_auteur'] == 1 ) ? ('') : ( 'index.php?mods=espace_membre&page=profil&id='.$sql['id_auteur'] ) ),
			'PSEUDO' => htmlspecialchars ( $sql [ 'pseudo' ] ),
			'THE' => the,
			'DATE' => ccmsdate ( $fuseaux , $sql [ 'date' ] ),
			'DIV_ID' => 'news_'.$sql [ 'id' ],
			'CONTENU' => to_html ( $sql [ 'contenu' ] ) ) );

			// On affiche l'arborescence
			$template->assign_block_vars ( 'forum_news_head.links1' , array ( 'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id=999999999999' , 'NOM' => htmlspecialchars ( $news_to_forum_cat_name )  ) );
			$template->assign_block_vars ( 'forum_news_head.links2' , array ( 'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;id='.htmlspecialchars ( $_GET['id'] ) , 'NOM' => to_html ( $sql['nom'] ) ) );

			if ( $grade == 4 ){
				$template->assign_block_vars ( 'forum_news_head.edit' , array (
				'ON_CLICK_EDIT' => 'real_edit(\'news_'.$id.'\',\''.$uid.'\',\''.$user_password.'\',\''.$sql [ 'id' ].'\',\'news\', \''.htmlspecialchars($_SERVER['HTTP_USER_AGENT'],ENT_QUOTES).'\',\''.$u_lang.'\',\''.$u_theme.'\' , \'_news\');return false;',
				'HREF_EDIT' => 'index.php?mods=news&page=admin&modif',
				'TXT_EDIT' => edit ) );
			}
				if ( $sql [ 'privacy' ] == '' )$sql [ 'privacy' ] = '0,0,0,0,0,0,0';
				// Si le membre n'a pas été supprimé
				if ( $sql['grades'] != -2 AND $sql['id_auteur'] != 1 ){

					$template->assign_block_vars ( 'forum_news_head.profil' , array () );
					$template->assign_block_vars ( 'forum_news_head.profil.user' , array (
					'POST' => POSTS,
					'NB_POSTS' => $sql['nb_post'] ) );

					if ( $sql['grades'] != 0 AND $uid != 1 )
						$template->assign_block_vars ( 'forum_news_head.profil.user.mp' , array (
						'MP_URL' => 'index.php?mods=espace_membre&page=mess&to='.$sql['id_auteur'],
						'MP' => mp ) );

					// Si il y a un avatar
					if( $sql ['avatar'] != ''){

							// On verifie que l'image existe en cherchant sa taille
							$imz = @getimagesize($sql ['avatar']);

							// Si pas d'avatar :
							if($imz[0]==0 OR $imz[1]==0){
								// On affiche avatar par defaut
								$template->assign_block_vars ( 'forum_news_head.profil.user.avatar_default' , array () );
							}
							else{
								// On redimensionne l'image avec des proportions ideales
								$new_size = resize ( 125 , 125 , $imz[0] , $imz[1] );
								$template->assign_block_vars ( 'forum_news_head.profil.user.avatar' , array (
								'SRC' => $sql ['avatar'],
								'WIDTH' => $new_size[0],
								'HEIGHT' => $new_size[1] ) );
							}

					}
					else{
						// On affiche avatar par defaut
						$template->assign_block_vars ( 'forum_news_head.profil.user.avatar_default' , array () );
					}
					// Si les rangs sont actives, on affiche le rang actuel de l'user ;)
					if ( $forum_use_ranks == 1 ){
						$template->assign_block_vars ( 'forum_news_head.profil.user.ranks' , array ( 'RANK' => $Forum->give_rank ( $sql ['nb_post'] ) ) );
					}

					if ( $function_reputation == 1 ){
						$reputation = 0;
						$rep = explode(';',$sql['reputation']);
						foreach ( $rep as $value){
							if($value != ''){
								$rept = explode(':',$value);
								$reputation = $reputation + $rept[3];
							}
						}
						$template->assign_block_vars ( 'forum_news_head.profil.user.reputation' , array ( 
						'REP' => reputation,
						'REPUTATION' => $reputation,
						'URL_PLUS' => 'index.php?mods=forum&page=reputation&amp;increase='.$sql['id'].'&amp;topic='.intval($_GET['id']),
						'URL_MOINS' => 'index.php?mods=forum&page=reputation&amp;decrease='.$sql['id'].'&amp;topic='.intval($_GET['id'])) );
					}

					if ( $sql['privacy']{0} == 0 ) 
						$template->assign_block_vars ( 'forum_news_head.profil.user.email' , array (
						'URL' => $sql['email'],
						'TITRE' => email ) );

					if( $sql['msn']!='' AND $sql['privacy']{2}== 0 )
						$template->assign_block_vars ( 'forum_news_head.profil.user.msn' , array (
						'URL' => $sql['msn'],
						'TITRE' => MSN ) );
					if($sql['aim']!='' AND $sql['privacy']{8}== 0 )
						$template->assign_block_vars ( 'forum_news_head.profil.user.aim' , array (
						'URL' => $sql['aim'],
						'TITRE' => AIM ) );
					if($sql['yahoom']!='' AND $sql['privacy']{6}== 0 )
						$template->assign_block_vars ( 'forum_news_head.profil.user.yahoom' , array (
						'URL' => $sql['yahoom'],
						'TITRE' => YAHOOM ) );
					if($sql['icq']!='' AND $sql['privacy']{4}== 0 )
						$template->assign_block_vars ( 'forum_news_head.profil.user.icq' , array (
						'URL' => $sql['icq'],
						'TITRE' => ICQ ) );

					if ( $sql['signature']!='' )
						$template->assign_block_vars ( 'forum_news_head.signature' , array ( 'SIGNATURE' => to_html ( $sql['signature'] ) ) );
				}
				else if ( $sql['id_auteur'] == 1 ){
					$template->assign_block_vars ( 'forum_news_head.profil' , array () );
					$template->assign_block_vars ( 'forum_news_head.profil.none' , array ( 'TXT' => '' ) );
				}
				else{
					$template->assign_block_vars ( 'forum_news_head.profil' , array () );
					$template->assign_block_vars ( 'forum_news_head.profil.none' , array ( 'TXT' => MEMBER_DELETED ) );
				}

			//On regarde si les commentaires sont autorisés et si le membre posséde la permission pour poster des commentaires
			if ( ( $sql [ 'unlocked' ] == 1 AND  ( ereg ( "poster_comment;" , $permissions_f ) ) ) OR $grade == 4 ){
				//On affiche le lien pour poster commentaires :)
				$template->assign_block_vars ( 'forum_news_head.head_news_post' , array ( 
				'HREF' => './index.php?mods=news&amp;page=post_comment&amp;news='.$id,
				'TXT' => add_comment ) );
				$template->assign_block_vars ( 'forum_news_head.foot_news_post' , array (
				'HREF' => './index.php?mods=news&amp;page=post_comment&amp;news='.$id,
				'TXT' => add_comment ) );
			}


			// On compte le nombre de réponses pour afficher les differentes pages possibles ;)
			$nb_reply = $Bdd->sql ( 'SELECT COUNT(*) AS nb_comment FROM '.PT.'_comment WHERE '.PT.'_comment.parent = "'.$id.'"' );
			$nb = $Bdd->get_array($nb_reply);
			$pages = ceil ( $nb['nb_comment'] / $forum_nb_reponses_page );

				// Gestion du multipage.

				if ( isset ( $_GET['nb_page'] ) ){
					$page = intval ( $_GET['nb_page'] );
					$id_depart = ( $page * $forum_nb_reponses_page ) - $forum_nb_reponses_page;
				}
				else{
					$page = 1;
					$id_depart = 0;
				}

				give_pages ( $pages , array ( 'forum_news_head.page_haut' , 'forum_news_head.page_bas' ) , './index.php?mods=forum&amp;page=viewtopic&amp;id='.htmlspecialchars($_GET['id']).'&amp;nb_page=' , $page );


				if ( $nb['nb_comment'] > 0 ){
					$template->assign_block_vars( 'forum_news_head.comments' , array ( 'COMMENTS' => COMMENTS ) );
				}

			$query = $Bdd->sql ( 'SELECT n.id AS id,
									n.date AS date,
									n.auteur AS id_auteur,
									n.contenu AS contenu, 
									u.pseudo AS pseudo,
									u.icq AS icq,
									u.msn AS msn,
									u.grades AS grades,
									u.aim AS aim,
									u.yahoom AS yahoom,
									u.avatar AS avatar,
									u.nb_post AS nb_post,
									u.avertissements AS avertissements,
									u.reputation AS reputation,
									u.signature AS signature,
									u.email AS email,
									u.privacy AS privacy
				FROM '.PT.'_comment AS n
				LEFT JOIN '.PT.'_users AS u
				ON (u.id=n.auteur)
				WHERE n.parent = "'.$id.'" LIMIT '.$id_depart.','.$forum_nb_reponses_page );

			while ( $sql_rep = $Bdd->get_array ( $query ) ) {

				if ( $sql_rep['privacy'] == '' )$sql_rep['privacy'] = '0,0,0,0,0,0,0';

				$template->assign_block_vars ( 'forum_news_head.comments.comm' , array (
				'PROFIL_URL' => ( ( $sql_rep['id_auteur'] == 1 ) ? ('') : ( 'index.php?mods=espace_membre&page=profil&id='.$sql_rep['id_auteur'] ) ),
				'PSEUDO' => htmlspecialchars ( $sql_rep['pseudo'] ),
				'THE' => the,
				'DATE' => ccmsdate ( $fuseaux , $sql_rep [ 'date' ] ) ,
				'DIV_ID' => 'reply-'.$sql_rep['id'],
				'CONTENU' => to_html ( $sql_rep['contenu'] ) ) );

				// Lien pour editer le commentaire
				if ( ereg ( "modif_comment;" , $permissions_f ) || $grade == 4 || $uid == $sql_rep['id_auteur'] ){

					$template->assign_block_vars ( 'forum_news_head.comments.comm.edit' , array ( 
					'ON_CLICK_EDIT' => 'real_edit(\'reply-'.$sql_rep['id'].'\',\''.$uid.'\',\''.$user_password.'\',\''.$sql_rep['id'].'\',\'comment\', \''.htmlspecialchars($_SERVER['HTTP_USER_AGENT'],ENT_QUOTES).'\',\''.$u_lang.'\',\''.$u_theme.'\',\'_rep_'.$sql_rep['id'].'\' );return false;',
					'HREF_EDIT' => 'index.php?mods=news&amp;page=editcom&amp;news='.$id.'&amp;edit='.$sql_rep['id'],
					'TXT_EDIT' => edit ) );

				}

				if( ereg ( "del_comment;" , $permissions_f ) OR $grade == 4 ){
					$template->assign_block_vars ( 'forum_news_head.comments.comm.del' , array ( 
					'HREF' => 'index.php?mods=news&page=viewnews&amp;news='.$id.'&amp;del='.$sql_rep['id'],
					'TXT' => delete ) );
				}

				$template->assign_block_vars ( 'forum_news_head.comments.comm.profil' , array() );

				if ( $sql_rep['grades'] != -2 AND $sql_rep['id_auteur'] != 1 ){

					$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user' , array (
					'POST' => POSTS,
					'NB_POSTS' => $sql_rep['nb_post'] ) );

					if ( $sql_rep['grades'] != 0 AND $uid != 1 )
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.mp' , array (
						'MP_URL' => 'index.php?mods=espace_membre&page=mess&to='.$sql_rep['id'],
						'MP' => mp ) );

					// Si il y a un avatar
					if( $sql_rep ['avatar'] != ''){

							// On verifie que l'image existe en cherchant sa taille
							$imz = @getimagesize($sql_rep ['avatar']);

							// Si pas d'avatar :
							if($imz[0]==0 OR $imz[1]==0){
								// On affiche avatar par defaut
								$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.avatar_default' , array () );
							}
							else{
								// On redimensionne l'image avec des proportions ideales
								$new_size = resize ( 125 , 125 , $imz[0] , $imz[1] );
								$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.avatar' , array (
								'SRC' => $sql_rep ['avatar'],
								'WIDTH' => $new_size[0],
								'HEIGHT' => $new_size[1] ) );
							}

					}
					else{
						// On affiche avatar par defaut
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.avatar_default' , array () );
					}
					// Si les rangs sont actives, on affiche le rang actuel de l'user ;)
					if ( $forum_use_ranks == 1 ){
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.ranks' , array ( 'RANK' => $Forum->give_rank ( $sql_rep ['nb_post'] ) ) );
					}

					if ( $function_reputation == 1 ){
						$reputation = 0;
						$rep = explode(';',$sql_rep['reputation']);
						foreach ( $rep as $value){
							if($value != ''){
								$rept = explode(':',$value);
								$reputation = $reputation + $rept[3];
							}
						}
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.reputation' , array ( 
						'REP' => reputation,
						'REPUTATION' => $reputation,
						'URL_PLUS' => 'index.php?mods=forum&page=reputation&amp;increase='.$sql_rep['id'].'&amp;topic='.intval($_GET['id']),
						'URL_MOINS' => 'index.php?mods=forum&page=reputation&amp;decrease='.$sql_rep['id'].'&amp;topic='.intval($_GET['id'])) );
					}

					if ( $sql_rep['privacy']{0} == 0 ) 
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.email' , array (
						'URL' => $sql_rep['email'],
						'TITRE' => email ) );

					if( $sql_rep['msn']!='' AND $sql_rep['privacy']{2}== 0 )
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.msn' , array (
						'URL' => $sql_rep['msn'],
						'TITRE' => MSN ) );
					if($sql_rep['aim']!='' AND $sql_rep['privacy']{8}== 0 )
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.aim' , array (
						'URL' => $sql_rep['aim'],
						'TITRE' => AIM ) );
					if($sql_rep['yahoom']!='' AND $sql_rep['privacy']{6}== 0 )
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.yahoom' , array (
						'URL' => $sql_rep['yahoom'],
						'TITRE' => YAHOOM ) );
					if($sql_rep['icq']!='' AND $sql_rep['privacy']{4}== 0 )
						$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.user.icq' , array (
						'URL' => $sql_rep['icq'],
						'TITRE' => ICQ ) );
					if ( $sql_rep['signature']!='' )
						$template->assign_block_vars ( 'forum_news_head.comments.comm.signature' , array ( 'SIGNATURE' => to_html ( $sql_rep['signature'] ) ) );
				}
				else if ( $sql_rep['id_auteur'] == 1 ){
					$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.none' , array( 'TXT' => '' ) );
				}
				else{
					$template->assign_block_vars ( 'forum_news_head.comments.comm.profil.none' , array( 'TXT' => MEMBER_DELETED ) );
				}
			}
		}
		else{
			// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
			$template->set_filename('error_page.tpl' );
			$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
		}
	}
	else{

		if($Bdd->get_num_rows($query_topic)==0){
			$Bdd->free_result($query_topic);
			// Si il n'y a pas de sujet
			$template->set_filename('error_page.tpl' );
			$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );

		}
		else{
			$Bdd->free_result($query_topic);

			// On verifie que l'utilisateur a le bon groupe pr acceder a ce topic
			$grpes = $Forum->verif_groupes ( $array_for['groupes'] , $array_for['ecriture'] );
			if ( $grpes === true ){

				// On met a jour le lu / non-lu si l'utilisateur n'est pas un invité
				if ( $uid != 1 ){

					// On indique tout d'abord le sujet comme lu
					if(ereg('\{'.intval($_GET['id']).';'.$sql_top['parent'].'\}',$lunonlu)){
						$lunonlu = str_replace('{'.intval($_GET['id']).';'.$id_forum.'}' , '',$lunonlu);
					}

					//Maintenant on va lancer une boucle qui mettre a jour tt forum parent, jusqu'a ce qu'un des forums
					$bool = true;
					while($bool){
						$qu_tops = $Bdd->sql('SELECT id FROM '.PT.'_forum_topic WHERE parent="'.$id_forum.'"' );
						// Si il n'y a aucun autre sujet dans ce forum, on va indiquer ce forum comme lu
						if($Bdd->get_num_rows($qu_tops)==1){
							$lunonlu = str_replace('('.$id_forum.')' , '',$lunonlu);
						}
						else{
						// Si il y a d'autres sujets, on va indiquer ce forum non lu seulement si tous les autres sont non lu, si un autre est lu, on arrete immediatement la boucle
							if(ereg('\{[0-9]+;'.$id_forum.'\}',$lunonlu)){
								$bool = false;
							}
							if($bool === true){
								$lunonlu = str_replace('('.$id_forum.')' , '',$lunonlu);
							}
						}

						$qq_sub = $Bdd->sql('SELECT parent, is_sub FROM '.PT.'_forum_for WHERE id="'.$id_forum.'"' );
						$sq_sub = $Bdd->get_array($qq_sub);
						$id_forum = $sq_sub['parent'];
						if($sq_sub['is_sub']==0){
							$bool = false;
						}
					}
					// Si l'utilisateur est abonné a ce sujet, on indique qu'il a lu le sujet pour renvoyer mail a prochaine réponse ;)
					if ( strpos ( $u_abo , '('.intval($_GET['id']).',1)' ) !== FALSE )
						$u_abo = str_replace ( '('.intval($_GET['id']).',1)' , '('.intval($_GET['id']).',0)' , $u_abo );

					$Bdd->sql('UPDATE '.PT.'_users SET lunonlu="'.$lunonlu.'", abonnements="'.$u_abo.'" WHERE id="'.$uid.'"' );

					$Bdd->sql('UPDATE '.PT.'_forum_topic SET vue=vue+1 WHERE id="'.intval($_GET['id']).'"' );

				}

				$template->assign_block_vars ( 'forum_topic' , array (
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
					function redir(url){
						window.location.href = url;
					}
				</script>',
				'NOM' => $nom_site,
				'ACCUEIL' => INDEX,
				'CAT_PARENT' => to_html ( $cat_parent ),
				'FORUM_RULES' => FORUM_RULES,
				'SEARCH' => SEARCH,
				'FAST_SEARCH' => FAST_SEARCH,
				'ON_THE_TITLE' => ON_THE_TITLE,
				'ON_THE_CONTENT' => ON_THE_CONTENT,
				'PROFIL_URL' => ( ( $sql_top['id_auteur'] == 1 ) ? ('') : ('index.php?mods=espace_membre&page=profil&id='.$sql_top['id_auteur'] ) ),
				'PSEUDO' => htmlspecialchars ( $sql_top [ 'pseudo' ] ),
				'THE' => the,
				'DATE' => ccmsdate ( $fuseaux , $sql_top [ 'date' ] ),
				'DIV_ID' => 'topic_contenu',
				'CONTENU' => to_html ( $sql_top [ 'contenu' ] ) ) );

				if ( isset ( $links[0] ) )
					$template->assign_block_vars ( 'forum_topic.links' , array () );
				if ( isset ( $links[1] ) )
					$template->assign_block_vars ( 'forum_topic.links1' , array (
					'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id='.$links[1][0],
					'NOM' => $links[1][1] ) );
				if ( isset ( $links[2] ) )
					$template->assign_block_vars ( 'forum_topic.links2' , array (
					'URL' => 'index.php?mods=forum&amp;page=viewfor&amp;id='.$links[2][0],
					'NOM' => $links[2][1] ) );
				if ( isset ( $links[3] ) )
					$template->assign_block_vars ( 'forum_topic.links3' , array (
					'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;id='.$links[3][0],
					'NOM' => $links[3][1] ) );

				// On vérifie les Permissions pour éditer ou supprimer le sujet ;)
				//Verification des permissions pour editer le sujet
				$permis = FALSE;
				$permis = $Forum->give_permissions($permissions_f,$grade,'edit_all_replys' , 'edit_our_replys',1,$sql_top['id_auteur']);

				//Verification des permissions pour supprimer le sujet
				$permis2 = FALSE;
				$permis2 = $Forum->give_permissions($permissions_f,$grade,'delete_all_topics' , 'delete_our_topics',1,$sql_top['id_auteur']);

				$grades = explode ( ',' , $forum_grade_admin );
				if( $grades == 4 OR in_array ( $grade , $grades , TRUE ) OR ( $modo['is_mod'] === TRUE AND in_array ( 3 , $grades , TRUE ) ) ){
					$permis = TRUE;
					$permis2 = TRUE;
				}

				if ( $permis === TRUE )
					$template->assign_block_vars ( 'forum_topic.edit' , array (
					'ON_CLICK' => 'real_edit(\'topic_contenu\',\''.$uid.'\',\''.$user_password.'\',\''.$sql_top [ 'id' ].'\',\'forumtopic\', \''.htmlspecialchars($_SERVER['HTTP_USER_AGENT'],ENT_QUOTES).'\',\''.$u_lang.'\',\''.$u_theme.'\' ,\'_topic\');return false;',
					'HREF' => 'index.php?mods=forum&amp;page=edit&amp;edittopic='.$sql_top['id'],
					'TXT' => edit ) );

				if ( $permis2 === TRUE )
					$template->assign_block_vars ( 'forum_topic.delete' , array (
					'HREF' => 'index.php?mods=forum&amp;page=delete&amp;deltopic='.$sql_top['id'],
					'TXT' => delete ) );

				// On verifie que l'utilisateur a le bon groupe pr poster
				$grpes = $Forum->verif_groupes ( $array_for['groupes'] , $array_for['ecriture'] , false );
				if ( ( ereg('post_reply;',$permissions_f) AND $array_for['locked'] == 0 AND $grpes === true AND ( $lock != 1 OR ereg('lock_topic;',$permissions_f) ) ) OR $grade == 4 ){
					//si mec a lautorisation de poster, on lui affiche les liens
					$template->assign_block_vars ( 'forum_topic.head_post' , array (
					'HREF' => './index.php?mods=forum&amp;page=post&amp;newreply='.$sql_top['id'],
					'TXT' => POST_REPLY ) );
					$template->assign_block_vars ( 'forum_topic.foot_post' , array (
					'FORMULAIRE' => default_form ( FALSE ),
					'HREF' => './index.php?mods=forum&amp;page=post&amp;newreply='.$sql_top['id'],
					'TXT' => POST_REPLY ) );

				}

		if ( $sql_top ['privacy'] == '' )$sql_top['privacy'] = '0,0,0,0,0,0,0';

				// Si le membre n'a pas été supprimé
				if ( $sql_top['grades'] != -2 AND $sql_top['id_auteur'] != 1 ){

					$template->assign_block_vars ( 'forum_topic.profil' , array () );
					$template->assign_block_vars ( 'forum_topic.profil.user' , array (
					'POST' => POSTS,
					'NB_POSTS' => $sql_top['nb_post'] ) );

					if ( $sql_top['grades'] != 0 AND $uid != 1 )
						$template->assign_block_vars ( 'forum_topic.profil.user.mp' , array (
						'MP_URL' => 'index.php?mods=espace_membre&page=mess&to='.$sql_top['id_auteur'],
						'MP' => mp ) );

					// Si il y a un avatar
					if( $sql_top ['avatar'] != ''){

							// On verifie que l'image existe en cherchant sa taille
							$imz = @getimagesize($sql_top ['avatar']);

							// Si pas d'avatar :
							if($imz[0]==0 OR $imz[1]==0){
								// On affiche avatar par defaut
								$template->assign_block_vars ( 'forum_topic.profil.user.avatar_default' , array () );
							}
							else{
								// On redimensionne l'image avec des proportions ideales
								$new_size = resize ( 125 , 125 , $imz[0] , $imz[1] );
								$template->assign_block_vars ( 'forum_topic.profil.user.avatar' , array (
								'SRC' => $sql_top ['avatar'],
								'WIDTH' => $new_size[0],
								'HEIGHT' => $new_size[1] ) );
							}

					}
					else{
						// On affiche avatar par defaut
						$template->assign_block_vars ( 'forum_topic.profil.user.avatar_default' , array () );
					}
					// Si les rangs sont actives, on affiche le rang actuel de l'user ;)
					if ( $forum_use_ranks == 1 ){
						$template->assign_block_vars ( 'forum_topic.profil.user.ranks' , array ( 'RANK' => $Forum->give_rank ( $sql_top ['nb_post'] ) ) );
					}

					if ( $function_reputation == 1 ){
						$reputation = 0;
						$rep = explode(';',$sql_top['reputation']);
						foreach ( $rep as $value){
							if($value != ''){
								$rept = explode(':',$value);
								$reputation = $reputation + $rept[3];
							}
						}
						$template->assign_block_vars ( 'forum_topic.profil.user.reputation' , array ( 
						'REP' => reputation,
						'REPUTATION' => $reputation,
						'URL_PLUS' => 'index.php?mods=forum&page=reputation&amp;increase='.$sql_top['id'].'&amp;topic='.intval($_GET['id']),
						'URL_MOINS' => 'index.php?mods=forum&page=reputation&amp;decrease='.$sql_top['id'].'&amp;topic='.intval($_GET['id'])) );
					}

					if ( $sql_top['privacy']{0} == 0 )
						$template->assign_block_vars ( 'forum_topic.profil.user.email' , array (
						'URL' => $sql_top['email'],
						'TITRE' => email ) );

					if( $sql_top['msn']!='' AND $sql_top['privacy']{2}== 0 )
						$template->assign_block_vars ( 'forum_topic.profil.user.msn' , array (
						'URL' => $sql_top['msn'],
						'TITRE' => MSN ) );
					if($sql_top['aim']!='' AND $sql_top['privacy']{8}== 0 )
						$template->assign_block_vars ( 'forum_topic.profil.user.aim' , array (
						'URL' => $sql_top['aim'],
						'TITRE' => AIM ) );
					if($sql_top['yahoom']!='' AND $sql_top['privacy']{6}== 0 )
						$template->assign_block_vars ( 'forum_topic.profil.user.yahoom' , array (
						'URL' => $sql_top['yahoom'],
						'TITRE' => YAHOOM ) );
					if($sql_top['icq']!='' AND $sql_top['privacy']{4}== 0 )
						$template->assign_block_vars ( 'forum_topic.profil.user.icq' , array (
						'URL' => $sql_top['icq'],
						'TITRE' => ICQ ) );

					if ( $sql_top['signature']!='' )
						$template->assign_block_vars ( 'forum_topic.signature' , array ( 'SIGNATURE' => to_html ( $sql_top['signature'] ) ) );
				}
				else if ( $sql_top['id_auteur'] == 1 ){
					$template->assign_block_vars ( 'forum_topic.profil' , array () );
					$template->assign_block_vars ( 'forum_topic.profil.none' , array ( 'TXT' => '' ) );
				}
				else{
					$template->assign_block_vars ( 'forum_topic.profil' , array () );
					$template->assign_block_vars ( 'forum_topic.profil.none' , array ( 'TXT' => MEMBER_DELETED ) );
				}

				// On compte le nombre de réponses pour afficher les differentes pages possibles ;)
				$nb_reply = $Bdd->sql ( 'SELECT COUNT(*) AS nb_reply FROM '.PT.'_forum_reply WHERE '.PT.'_forum_reply.parent = "'.intval($_GET['id']).'"' );
				$nb = $Bdd->get_array($nb_reply);

				$pages = ceil ( $nb['nb_reply'] / $forum_nb_reponses_page );

				// Gestion du multipage.
				if ( isset ( $_GET['nb_page'] ) ){
					$page = intval ( $_GET['nb_page'] );
					$id_depart = ( $page * $forum_nb_reponses_page ) - $forum_nb_reponses_page;
				}
				else if ( isset ( $_GET['last_page'] ) ){
					$page = $pages;
					$id_depart = ( $page * $forum_nb_reponses_page ) - $forum_nb_reponses_page;
					if ( $id_depart < 0 )$id_depart = 0;
				}
				else{
					$page = 1;
					$id_depart = 0;
				}

				give_pages ( $pages , array ( 'forum_topic.page_haut' , 'forum_topic.page_bas' ) , './index.php?mods=forum&amp;page=viewtopic&amp;id='.intval($_GET['id']).'&amp;nb_page=' , $page );

				if ( $nb['nb_reply'] > 0 ){
					$template->assign_block_vars ( 'forum_topic.replys' , array ( 'REPLYS' => REPLYS ) );
				}

				// On recupere les reponses associes a ce sujet.
				$query_reply = $Bdd->sql('SELECT  
					'.PT.'_forum_reply.id as id, 
					'.PT.'_forum_reply.parent as parent, 
					'.PT.'_forum_reply.auteur as auteur, 
					'.PT.'_forum_reply.contenu as contenu,
					'.PT.'_forum_reply.date as date, 
					'.PT.'_forum_reply.smileys as smileys, 
					'.PT.'_forum_reply.bb as bb, 
					'.PT.'_forum_reply.groupes as groupes, 
					'.PT.'_users.grades AS grades, 
					'.PT.'_users.pseudo as pseudo, 
					'.PT.'_users.avatar as avatar, 
					'.PT.'_users.nb_post as nb_post,
					'.PT.'_users.reputation as reputation, 
					'.PT.'_users.avertissements as avertissements, 
					'.PT.'_users.icq as icq, 
					'.PT.'_users.msn as msn, 
					'.PT.'_users.aim as aim, 
					'.PT.'_users.yahoom as yahoom, 
					'.PT.'_users.privacy as privacy, 
					'.PT.'_users.email as email, 
					'.PT.'_users.signature as signature 
				FROM 
					'.PT.'_forum_reply, 
					'.PT.'_users 
				WHERE 
					'.PT.'_forum_reply.parent = "'.intval($_GET['id']).'" 
				AND 
					'.PT.'_users.id = '.PT.'_forum_reply.auteur 
				ORDER  BY 
					'.PT.'_forum_reply.date 
				LIMIT 
					'.$id_depart.','.$forum_nb_reponses_page 
				);

				while($sql_rep = $Bdd->get_array($query_reply)){

						// On vérifie si l'utilisateur à les permissions d'editer ou de supprimer la reponse
						//Verification des permissions pour editer la reponse
						$permis = FALSE;
						$permis = $Forum->give_permissions($permissions_f,$grade,'edit_all_replys' , 'edit_our_replys',1,$sql_rep['auteur']);
						//Verification des permissions pour supprimer la reply
						$permis2 = FALSE;
						$permis2 = $Forum->give_permissions($permissions_f,$grade,'delete_all_topics' , 'delete_our_topics',1,$sql_rep['auteur']);

						$grades = explode ( ',' , $forum_grade_admin );
						if($grades == 4 OR in_array ( $grade , $grades , TRUE ) OR ( $modo['is_mod'] === TRUE AND in_array ( 3 , $grades , TRUE ) ) ){
							$permis = TRUE;
							$permis2 = TRUE;
						}

						$template->assign_block_vars ( 'forum_topic.replys.rep' , array (
						'ID' => $sql_rep['id'],
						'PROFIL_URL' => ( ( $sql_rep['auteur'] == 1 ) ? ('') : ( 'index.php?mods=espace_membre&page=profil&id='.$sql_rep['auteur'] ) ),
						'PSEUDO' => htmlspecialchars ( $sql_rep['pseudo'] ),
						'THE' => the,
						'DATE' => ccmsdate($fuseaux,$sql_rep['date']),
						'DIV_ID' => 'topic_reply_'.$sql_rep['id'],
						'CONTENU' => to_html ( $sql_rep['contenu'] ) ) );

						if ( $permis === TRUE )
							$template->assign_block_vars ( 'forum_topic.replys.rep.edit' , array (
							'ON_CLICK' => 'real_edit(\'topic_reply_'.$sql_rep['id'].'\',\''.$uid.'\',\''.$user_password.'\',\''.$sql_rep [ 'id' ].'\',\'forumreply\', \''.htmlspecialchars($_SERVER['HTTP_USER_AGENT'],ENT_QUOTES).'\',\''.$u_lang.'\',\''.$u_theme.'\',\'_rep_'.$sql_rep['id'].'\' );return false;',
							'HREF' => 'index.php?mods=forum&amp;page=edit&amp;editreply='.$sql_rep['id'],
							'TXT' => edit ) );

						if ( $permis2 === TRUE )
							$template->assign_block_vars ( 'forum_topic.replys.rep.del' , array (
							'HREF' => 'index.php?mods=forum&amp;page=delete&amp;delreply='.$sql_rep['id'],
							'TXT' => delete ) );

						if ( $sql_rep['privacy'] == '' )$sql_rep['privacy'] = '0,0,0,0,0,0,0';

						// Si le membre n'a pas été supprimé
						if ( $sql_rep['grades'] != -2 AND $sql_rep['auteur'] != 1 ){

							$template->assign_block_vars ( 'forum_topic.replys.rep.profil' , array () );
							$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user' , array (
							'POST' => POSTS,
							'NB_POSTS' => $sql_rep['nb_post'] ) );

							if ( $sql_rep['grades'] != 0 AND $uid != 1 )
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.mp' , array (
								'MP_URL' => 'index.php?mods=espace_membre&page=mess&to='.$sql_rep['auteur'],
								'MP' => mp ) );

							// Si il y a un avatar
							if( $sql_rep ['avatar'] != ''){

									// On verifie que l'image existe en cherchant sa taille
									$imz = @getimagesize($sql_rep ['avatar']);

									// Si pas d'avatar :
									if($imz[0]==0 OR $imz[1]==0){
										// On affiche avatar par defaut
										$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.avatar_default' , array () );
									}
									else{
										// On redimensionne l'image avec des proportions ideales
										$new_size = resize ( 125 , 125 , $imz[0] , $imz[1] );
										$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.avatar' , array (
										'SRC' => $sql_rep ['avatar'],
										'WIDTH' => $new_size[0],
										'HEIGHT' => $new_size[1] ) );
									}

							}
							else{
								// On affiche avatar par defaut
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.avatar_default' , array () );
							}
							// Si les rangs sont actives, on affiche le rang actuel de l'user ;)
							if ( $forum_use_ranks == 1 ){
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.ranks' , array ( 'RANK' => $Forum->give_rank ( $sql_rep ['nb_post'] ) ) );
							}

							if ( $function_reputation == 1 ){
								$reputation = 0;
								$rep = explode(';',$sql_rep['reputation']);
								foreach ( $rep as $value){
									if($value != ''){
										$rept = explode(':',$value);
										$reputation = $reputation + $rept[3];
									}
								}
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.reputation' , array ( 
								'REP' => reputation,
								'REPUTATION' => $reputation,
								'URL_PLUS' => 'index.php?mods=forum&page=reputation&amp;increase='.$sql_rep['id'].'&amp;topic='.intval($_GET['id']),
								'URL_MOINS' => 'index.php?mods=forum&page=reputation&amp;decrease='.$sql_rep['id'].'&amp;topic='.intval($_GET['id'])) );
							}

							if ( $sql_rep['privacy']{0} == 0 ) 
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.email' , array (
								'URL' => $sql_rep['email'],
								'TITRE' => email ) );

							if( $sql_rep['msn']!='' AND $sql_rep['privacy']{2}== 0 )
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.msn' , array (
								'URL' => $sql_rep['msn'],
								'TITRE' => MSN ) );
							if($sql_rep['aim']!='' AND $sql_rep['privacy']{8}== 0 )
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.aim' , array (
								'URL' => $sql_rep['aim'],
								'TITRE' => AIM ) );
							if($sql_rep['yahoom']!='' AND $sql_rep['privacy']{6}== 0 )
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.yahoom' , array (
								'URL' => $sql_rep['yahoom'],
								'TITRE' => YAHOOM ) );
							if($sql_rep['icq']!='' AND $sql_rep['privacy']{4}== 0 )
								$template->assign_block_vars ( 'forum_topic.replys.rep.profil.user.icq' , array (
								'URL' => $sql_rep['icq'],
								'TITRE' => ICQ ) );

							if ( $sql_rep['signature']!='' )
								$template->assign_block_vars ( 'forum_topic.replys.rep.signature' , array ( 'SIGNATURE' => to_html ( $sql_rep['signature'] ) ) );
						}
						else if ( $sql_rep['auteur'] == 1 ){
							$template->assign_block_vars ( 'forum_topic.replys.rep.profil' , array () );
							$template->assign_block_vars ( 'forum_topic.replys.rep.profil.none' , array ( 'TXT' => '' ) );
						}
						else{
							$template->assign_block_vars ( 'forum_topic.replys.rep.profil' , array () );
							$template->assign_block_vars ( 'forum_topic.replys.rep.profil.none' , array ( 'TXT' => MEMBER_DELETED ) );
						}
				}
				$Bdd->free_result($query_reply);

				if(ereg('move_topic;',$permissions_f) OR $grade==4){

					$template->assign_block_vars ( 'forum_topic.move' , array ( 
					'URL' => 'index.php?mods=forum&amp;page=move&amp;id='.$sql_top['id'],
					'TXT' => MOVE_TOPIC ) );

				}
				if ( $grade == 4 OR ereg('attach_topic;',$permissions_f) ){

					if ( $attach == 1 ){
						$template->assign_block_vars ( 'forum_topic.unattach' , array ( 
						'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;unattach='.$sql_top['id'],
						'TXT' => UNATTACHED_TOPIC ) );
					}
					else{
						$template->assign_block_vars ( 'forum_topic.unattach' , array ( 
						'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;attach='.$sql_top['id'],
						'TXT' => ATTACHED_TOPIC ) );
					}
				}
				if ( $grade == 4 OR ereg('lock_topic;',$permissions_f) ){

					if ( $lock == 1 ){
						$template->assign_block_vars ( 'forum_topic.unlock' , array ( 
						'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;unlock='.$sql_top['id'],
						'TXT' => UNLOCK_TOPIC ) );
					}
					else{
						$template->assign_block_vars ( 'forum_topic.unlock' , array ( 
						'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;lock='.$sql_top['id'],
						'TXT' => LOCKED_TOPIC ) );
					}
				}
				if ( $grade > 0 ){
					$template->assign_block_vars ( 'forum_topic.signal' , array ( 
					'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;signal='.$sql_top['id'],
					'TXT' => SIGNAL_TOPIC ) );
				}



			}
			else{
				// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
				$template->set_filename('error_page.tpl' );
				$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
			}
		}
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else if ( ( ereg("attach_topic;",$permissions_f) OR $grade == 4  ) AND ( isset ( $_GET [ 'attach' ] ) OR isset ( $_GET[ 'unattach' ] ) ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/forum/viewtopic.tpl' );

	// On attache ou on détache un sujet
	if ( isset ( $_GET['attach'] ) ){
		$Bdd->sql ('UPDATE '.PT.'_forum_topic SET attached="1" WHERE id="'.intval($_GET['attach']).'"') ;
		$template->assign_block_vars ( 'forum_topic_action' , array (
		'TXT' => TOPIC_ATTACHED_SUCCESSFULLY,
		'URL' => './index.php?mods=forum&amp;page=viewtopic&amp;id='.intval($_GET['attach']),
		'BACK' => back ) );
	}
	else{
		$Bdd->sql ('UPDATE '.PT.'_forum_topic SET attached="0" WHERE id="'.intval($_GET['unattach']).'"') ;
		$template->assign_block_vars ( 'forum_topic_action' , array (
		'TXT' => TOPIC_UNATTACHED_SUCCESSFULLY,
		'URL' => './index.php?mods=forum&amp;page=viewtopic&amp;id='.intval($_GET['unattach']),
		'BACK' => back ) );

		}
	$template->set_filename ( 'bas_mods.tpl' );
}
else if ( isset ( $_GET[ 'signal' ] ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/forum/viewtopic.tpl' );

	// On recupere les moderateurs du forum parent si il y en a pour les prevenir eux, sinon on previent les moderateur et administrateurs generaux
	if ( strlen ( $array_for['moderators'] ) > 1 ){

		// On envoi un MP a chaque modérateur du forum !
		$modos = explode ( ',' , $array_for['moderators'] );
		foreach ( $modos AS $modid ){
			if ( intval ( $modid ) != '' ){
				$Bdd->sql('INSERT INTO '.PT.'_messagerie VALUES ("","'.$modid.'","'.$uid.'","'.TOPIC_ALERT.'","'.str_replace ( '{ID}' , intval ( $_GET['signal'] ) , str_replace ( '{PSEUDO}' , $pseudo , SIGNAL_TOPIC_TXT ) ).'","'.convertime(time()).'","1")' );
			}
		}
	}
	else{

		// On selectionne tous les moderateurs et les administrateurs pour leur envoyer le MP ;)
		$qquser = $Bdd->sql ( 'SELECT id FROM '.PT.'_users WHERE grades IN ( 3 , 4 )' );
		while ( $ssuser = $Bdd->get_array ( $qquser ) ){
			$Bdd->sql('INSERT INTO '.PT.'_messagerie VALUES ("","'.$ssuser['id'].'","'.$uid.'","'.TOPIC_ALERT.'","'.str_replace ( '{ID}' , intval ( $_GET['signal'] ) , str_replace ( '{PSEUDO}' , $pseudo , SIGNAL_TOPIC_TXT ) ).'","'.convertime(time()).'","1")' );
		}

	}
	$template->assign_block_vars ( 'forum_topic_action' , array (
	'TXT' => THIS_TOPIC_SIGNAL,
	'URL' => './index.php?mods=forum&amp;page=viewtopic&amp;id='.intval($_GET['signal']),
	'BACK' => back ) );
	$template->set_filename ( 'bas_mods.tpl' );
}
else if ( ( ereg("lock_topic;",$permissions_f) OR $grade == 4  ) AND ( isset($_GET['lock']) OR isset ( $_GET['unlock'] ) ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/forum/viewtopic.tpl' );
	// On verrouille ou deverrouille un sujet
	if ( isset ( $_GET['lock'] ) ){
		$template->assign_block_vars ( 'forum_topic_action' , array (
		'TXT' => TOPIC_LOCKED_SUCCESSFULLY,
		'URL' => './index.php?mods=forum&amp;page=viewtopic&amp;id='.intval($_GET['lock']),
		'BACK' => back ) );
		$Bdd->sql ('UPDATE '.PT.'_forum_topic SET locked="1" WHERE id="'.intval($_GET['lock']).'"') ;
	}
	else{
		$template->assign_block_vars ( 'forum_topic_action' , array (
		'TXT' => TOPIC_UNLOCKED_SUCCESSFULLY,
		'URL' => './index.php?mods=forum&amp;page=viewtopic&amp;id='.intval($_GET['unlock']),
		'BACK' => back ) );
		$Bdd->sql ('UPDATE '.PT.'_forum_topic SET locked="0" WHERE id="'.intval($_GET['unlock']).'"') ;
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}

?>