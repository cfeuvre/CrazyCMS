<?php

header('Content-type: text/html; charset=iso-8859-15' ); 
include('../../includes/config.php' );
include('../../includes/fonctions.php' );
include('../../mods/forum/class.forum.php' );
$Forum = new Class_Forum();
define ( 'CCMS' , TRUE );
include('../../langues/'.htmlentities($_POST['lang']).'/lang.php' );
include('./langues/'.htmlentities($_POST['lang']).'.php' );

include('../../includes/class.template.php' );
$template = new Template( '../../themes/'.htmlspecialchars($_POST['theme'],ENT_QUOTES) , TRUE );
$template->set_filename ( './modules/espace_membre/trait.tpl' );

$query = $Bdd->sql('SELECT groupe, grades FROM '.PT.'_users WHERE id="'.intval ( $_POST['uid'] ).'" AND pass = "'.htmlspecialchars ( $_POST['pass'] ).'"' );

$sql = $Bdd->get_array ( $query );

$grade = $sql['grades'];
$groupe = $sql['groupe'];
	
if ( $Bdd->get_num_rows ( $query ) == 0 ){
	$template->assign_block_vars ( 'error' , array (
	'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
else{

	if(isset($_POST['div_aff'])){
		if($_POST['div_aff']=="n1"){
			$req = $Bdd->sql('SELECT ft.id as id,
									ft.nom as nom,
									ft.contenu as contenu,
									ft.date as date,
									ff.groupes as groupes,
									ff.ecriture as ecriture
									FROM '.PT.'_forum_topic  as ft
									LEFT JOIN '.PT.'_forum_for as ff
									ON ff.id = ft.parent
									WHERE ft.auteur="'.intval($_POST['id_user']).'" 
									ORDER BY id DESC' );
			$a = 0;
			while($rep = $Bdd->get_array($req)){
			
				$grpes = $Forum->verif_groupes ( $rep['groupes'] , $rep['ecriture'] );
				if ( $grpes === true && $a <5){
					$a ++;
					$template->assign_block_vars ( 'liste' , array (
					'TITRE' => to_html ( $rep['nom'] , '../..' ),
					'URL' => 'index.php?mods=forum&page=viewtopic&id='.$rep['id'],
					'CONTENU' => to_html ( $rep['contenu'] ,'../..' ) ) );
				}
			}
			if ( $a == 0 ){
				$template->assign_block_vars ( 'none' , array (
				'TXT' => NONE_TOPIC ) );
			}
		}
		else if($_POST['div_aff']=="n2"){
				$req = $Bdd->sql('SELECT 
					r.id,
					r.parent AS parent,
					r.auteur AS auteur,
					r.contenu AS contenu,
					r.date AS date,
					t.id AS tid,
					t.nom AS nom,
					f.groupes AS groupes,
					f.ecriture AS ecriture
				FROM '.PT.'_forum_reply AS r
				LEFT JOIN '.PT.'_forum_topic AS t
				ON t.id = r.parent
				LEFT JOIN '.PT.'_forum_for AS f
				ON f.id = t.parent
				WHERE r.auteur="'.intval($_POST['id_user']).'" 
				ORDER BY r.id DESC' );
			$a = 0;
			
			$req_param = $Bdd->sql('SELECT valeur FROM '.PT.'_parametres WHERE nom="forum_nb_reponses_page"' );
			while ( $conf = $Bdd->get_array ( $req_param ) ){
				$forum_nb_reponses_page = $conf['valeur'];
			}
			$Bdd->free_result($req_param);	
			
			while($rep = $Bdd->get_array($req) ){
			
				// On cherche le nb de page
				$nb_reply = $Bdd->sql ( '
				SELECT 
					COUNT(*) AS nb_reply 
				FROM 
					'.PT.'_forum_reply 
				WHERE 
					'.PT.'_forum_reply.parent = "'.$rep['parent'].'" 
				AND 
					'.PT.'_forum_reply.date <= '.$rep['date'].'' );

				$nb = $Bdd->get_array($nb_reply);
				$pages = ceil ( $nb['nb_reply'] / $forum_nb_reponses_page );
				$Bdd->free_result ( $nb_reply );
			
				$grpes = $Forum->verif_groupes ( $rep['groupes'] , $rep['ecriture'] );
				if ( $grpes === true && $a < 5){
					$a ++;
					$template->assign_block_vars ( 'liste' , array (
					'TITRE' => to_html ( $rep['nom'] , '../..' ),
					'URL' => 'index.php?mods=forum&page=viewtopic&id='.$rep['tid'].'&amp;nb_page='.$pages.'#r-'.$rep['id'],
					'CONTENU' => to_html ( $rep['contenu'] ,'../..' ) ) );
				}
			}
			if ( $a == 0 ){
				$template->assign_block_vars ( 'none' , array (
				'TXT' => NONE_POST ) );
			}
		}
		else if($_POST['div_aff']=="n3"){
				$req = $Bdd->sql('SELECT c.id AS cid,
										 c.contenu AS ccontenu,
										 c.auteur AS cauteur,
										 c.smileys AS csmileys,
										 n.id AS nid,
										 n.titre AS ntitre,
										 n.groupes AS ngroupes,
										 u.groupe AS ugroupe
										 FROM '.PT.'_comment AS c
										 LEFT JOIN '.PT.'_news AS n
										 ON c.parent = n.id
										 LEFT JOIN '.PT.'_users AS u
										 ON u.id = "'.intval ( $_POST['uid'] ).'"
										 WHERE c.auteur = "'.intval($_POST['id_user']).'" AND ( "'.$groupe.'" REGEXP "^n.groupes;|;n.groupes;" OR n.groupes="0;" OR n.groupes="" ) 
										 ORDER BY c.id DESC' );
				$a = 0;
				while($rep = $Bdd->get_array($req)){
				$perm = false;
				$news_groupe = explode(';',$rep['ngroupes']);
				foreach ( $news_groupe as $news_see ){
				if (eregi(';'.$news_see.';',$groupe) || eregi('^'.$news_see.';',$groupe)){
						$perm = true;
					}
				}
					if(($perm===true || $rep['ngroupes']=='') && $a<5){
						$a++;
					$template->assign_block_vars ( 'liste' , array (
					'TITRE' => to_html ( $rep['ntitre'], '../..' ),
					'URL' => 'index.php?mods=news&page=viewnews&news='.$rep['nid'].'#n'.$rep['cid'],
					'CONTENU' => to_html ( $rep['ccontenu'] , '../..' ) ) );
					}
				}
				if($a==0){
					$template->assign_block_vars ( 'none' , array (
					'TXT' => NONE_COMMENT ) );
				}
		}
	}
	else{
		$template->assign_block_vars ( 'error' , array (
		'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}
	$template->gen();
}
?>