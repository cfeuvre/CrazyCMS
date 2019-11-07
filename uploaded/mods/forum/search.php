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
// Lorsque ce fichier est apelle par ajax, on retourne les réponses de la recherche
if(isset($_GET['ajax'])){

	define ( 'CCMS' , TRUE );
	header('Content-type: text/html; charset=iso-8859-15' ); 
	include('../../includes/config.php' );
	include('../../includes/class.template.php' );
	$template = new Template( '../../themes/'.htmlspecialchars($_POST['theme'],ENT_QUOTES) , TRUE );
	$template->set_filename ( 'modules/forum/search.tpl' );
	include('../../includes/fonctions.php' );
	include('../../langues/'.htmlspecialchars($_POST['lang'],ENT_QUOTES).'/lang.php' );
	include('./langues/'.htmlspecialchars($_POST['lang'],ENT_QUOTES).'.php' );
		if($Bdd->secure($_POST['text'])!=''){
			switch (intval($_POST['type'])){
				case 0 :
					$query = $Bdd->sql('
					SELECT 
						'.PT.'_forum_topic.id AS id,
						'.PT.'_forum_topic.nom AS nom 
					FROM
						'.PT.'_forum_topic 
					WHERE nom REGEXP "'.$Bdd->secure($_POST['text']).'"' );
				break;
				case 1 :
					$query = $Bdd->sql('
					SELECT 
						'.PT.'_forum_topic.id as id,
						'.PT.'_forum_topic.nom as nom 
					FROM 
						'.PT.'_forum_topic,
						'.PT.'_forum_reply 
					WHERE 
						('.PT.'_forum_topic.contenu REGEXP "'.$Bdd->secure($_POST['text']).'") 
					OR 
						(
							'.PT.'_forum_reply.contenu REGEXP "'.$Bdd->secure($_POST['text']).'" 
								AND 
							'.PT.'_forum_topic.id = '.PT.'_forum_reply.parent
						) 
					GROUP BY '.PT.'_forum_topic.id' );
				break;
				case 2 :
					$query = $Bdd->sql( '
					SELECT 
						'.PT.'_forum_topic.id,
						'.PT.'_forum_topic.nom 
					FROM 
						'.PT.'_forum_topic,
						'.PT.'_forum_reply 
					WHERE 
						'.PT.'_forum_topic.nom REGEXP "'.$Bdd->secure($_POST['text']).'" 
					OR 
						'.PT.'_forum_topic.contenu REGEXP "'.$Bdd->secure($_POST['text']).'" 
					OR 
						'.PT.'_forum_reply.contenu REGEXP "'.$Bdd->secure($_POST['text']).'" 
					GROUP BY '.PT.'_forum_topic.id' );
				break;
			}
			if(intval($_POST['type'])!=3){
				$template->assign_block_vars ( 'ajax_search' , array ( 'TOTAL' => $Bdd->get_num_rows($query), 'TOPICS' => TOPICS ) );
				while($sql = $Bdd->get_array($query)){
					$template->assign_block_vars ( 'ajax_search.reps' , array (
					'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;id='.$sql['id'],
					'NOM' => to_html($sql['nom'] , '../..' ) ) );
				}
			}
		}
	$template->gen();
}
else{

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => FORUM_RESEARCH ) );
	$template->set_filename ( './modules/forum/search.tpl' );

	//Si aucune requete n'a ete envoye, on affiche le formulaire ;)
	if(!isset($_POST['search'])){

		$template->assign_block_vars ( 'search_form' , array (
		'JS' => '
			<script type="text/javascript">
				// Fonction remettre le texte par defaut dans l\'input
				function reload(){
					if(document.getElementById(\'search\').value == ""){
						document.getElementById(\'search\').value = "'.SEARCH.'";
						document.getElementById(\'search\').style.color ="grey";
					}
				}

				function search_load(){
						var xhr_object = null; 
				 
						if(window.XMLHttpRequest) // Navigateur Normal :
							xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
							xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 

						// On voit si on choisit de chercher dans titre, dans contenu, dans les deux ou rien^^
						var type = 3;

						if(document.getElementById(\'topic\').checked==true && document.getElementById(\'contenu\').checked==true){
							var type = 2;
						}
						else if(document.getElementById(\'topic\').checked==true){
							var type = 0;
						}
						else if(document.getElementById(\'contenu\').checked==true){
							var type = 1;
						}

						var data = "text=" + document.getElementById(\'search\').value + "&lang='.$u_lang.'&type=" + type + "&theme='.$u_theme.'";

						// On appelle la page distante
						xhr_object.open("POST", "./mods/forum/search.php?ajax", true); 
				 
						xhr_object.onreadystatechange = function() {
							if(xhr_object.readyState == 4){
								document.getElementById(\'result\').innerHTML = xhr_object.responseText;
							}
							else{
								document.getElementById(\'result\').innerHTML = "<center><img src=\"./mods/news/images/loading.gif\" alt=\"Loading ...\"/></center>";
							}
						}

						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 

						xhr_object.send(data);
				}

				function load(){
					if(document.getElementById(\'search\').value == "'.SEARCH.'"){
						document.getElementById(\'search\').value=\'\';
						document.getElementById(\'search\').style.color=\'black\';
					}
				}
			</script>',
		'SEARCH_INTO' => SEARCH_INTO,
		'KEYWORDS' => KEYWORDS,
		'ON_THE_TITLE' => ON_THE_TITLE,
		'ON_THE_CONTENT' => ON_THE_CONTENT,
		'SEARCH' => SEARCH
		) );

	}
	else{

		//Recherche dans sujet :
		$search = $Bdd->secure($_POST['search']);
		$result_topics = '';
		$result_replys = '';

			// On cherche dans titre si coche et dans contenu si coche ;)
			if(isset($_POST['search_titre']) && $_POST['search_titre']==1){
				$keywords = explode(';',$search);
				foreach ( $keywords as $key ){

					$query = $Bdd->sql('
					SELECT 
						'.PT.'_forum_topic.id AS id,
						'.PT.'_forum_topic.nom AS nom,
						'.PT.'_forum_topic.auteur AS id_auteur,
						'.PT.'_forum_topic.messages AS messages,
						'.PT.'_forum_topic.date AS date,
						'.PT.'_users.pseudo AS auteur
					FROM 
						'.PT.'_forum_topic,
						'.PT.'_users
					WHERE '.PT.'_forum_topic.nom REGEXP "'.$key.'" AND '.PT.'_forum_topic.auteur = '.PT.'_users.id' );
					while($sql = mysql_fetch_array($query)){
						if ( !strstr ( $result_topics , $sql['id'].'|*-*|'.$sql['nom'].'|*-*|'.$sql['auteur'].'|*-*|'.$sql['messages'].'|*-*|'.$sql['date'].'|*-*-*|' ) ){
							$result_topics .= $sql['id'].'|*-*|'.$sql['nom'].'|*-*|'.$sql['auteur'].'|*-*|'.$sql['messages'].'|*-*|'.$sql['date'].'|*-*-*|';
						}
					}
					$Bdd->free_result ( $query );
				}
			}
			if(isset($_POST['search_contenu']) && $_POST['search_contenu']==1){
				$keywords = explode(';',$search);
				foreach ( $keywords as $key ){

					$query = $Bdd->sql('
					SELECT 
						'.PT.'_forum_topic.id AS id,
						'.PT.'_forum_topic.nom AS nom,
						'.PT.'_forum_topic.auteur AS id_auteur,
						'.PT.'_forum_topic.messages AS messages,
						'.PT.'_forum_topic.date AS date,
						'.PT.'_users.pseudo AS auteur
					FROM 
						'.PT.'_forum_topic,
						'.PT.'_users
					WHERE '.PT.'_forum_topic.contenu REGEXP "'.$key.'" AND '.PT.'_users.id = '.PT.'_forum_topic.auteur' );
					while($sql = mysql_fetch_array($query)){
						if ( !strstr ( $result_topics , $sql['id'].'|*-*|'.$sql['nom'].'|*-*|'.$sql['auteur'].'|*-*|'.$sql['messages'].'|*-*|'.$sql['date'].'|*-*-*|' ) ){
							$result_topics .= $sql['id'].'|*-*|'.$sql['nom'].'|*-*|'.$sql['auteur'].'|*-*|'.$sql['messages'].'|*-*|'.$sql['date'].'|*-*-*|';
						}
					}
					$Bdd->free_result ( $query );

					$query = $Bdd->sql('
					SELECT
						'.PT.'_forum_reply.id AS id,
						'.PT.'_forum_reply.parent AS parent,
						'.PT.'_forum_reply.auteur AS id_auteur,
						'.PT.'_forum_reply.date AS date,
						'.PT.'_users.pseudo AS auteur
					FROM 
						'.PT.'_forum_reply,
						'.PT.'_users
					WHERE contenu REGEXP "'.$key.'" AND '.PT.'_forum_reply.auteur = '.PT.'_users.id' );
					while($sql = mysql_fetch_array($query)){
						if( !ereg ( '[0-9]+\|\*\-\*\|'.$sql['parent'].'\|\*\-\*\|([^*])+\|\*\-\*\|[0-9]+\|\*\-\*\-\*\|' , $result_replys ) ){
							$result_replys .= $sql['id'].'|*-*|'.$sql['parent'].'|*-*|'.$sql['auteur'].'|*-*|'.$sql['date'].'|*-*-*|';
						}
					}
					$Bdd->free_result ( $query );
				}
			}
			$template->assign_block_vars ( 'search_valid' , array (
			'RESEARCH_ON_THE_TOPIC' => RESEARCH_ON_THE_TOPIC,
			'TOPICS' => TOPICS,
			'AUTHOR' => AUTHORS,
			'REPLYS' => REPLYS,
			'CREATION_DATE' => CREATION_DATE,
			'RESEARCH_ON_THE_CONTENT' => RESEARCH_ON_THE_CONTENT,
			'BACK' => back
			));
		$reps = explode('|*-*-*|',$result_topics);
		$a = 0;
		foreach ( $reps as $rep ){
			if($rep!=''){
				$a ++;
				$rep_det = explode('|*-*|',$rep);

				$template->assign_block_vars ( 'search_valid.search_valid_rep' , array (
				'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;id='.$rep_det[0],
				'NOM' => to_html($rep_det[1]),
				'PSEUDO' => htmlspecialchars($rep_det[2]),
				'REPLYS' => htmlspecialchars($rep_det[3]),
				'DATE' => The.' '.date('d/m/Y',$rep_det[4]).' '.at.' '.date('H \h i',$rep_det[4])
				));
			}
		}
		if($a == 0)
			$template->assign_block_vars ( 'search_valid.search_valid_empty' , array ( 'TXT' => NONE_CORELATION ) );

		$reps = explode('|*-*-*|',$result_replys);
		$b = 0;
		foreach ( $reps as $rep ){
			if($rep!=''){
				$b ++;
				$rep_det = explode('|*-*|',$rep);
				$sqlz = $Bdd->sql('SELECT nom FROM '.PT.'_forum_topic WHERE id="'.$rep_det[1].'"' );
				$sqlzz = mysql_fetch_array($sqlz);
				$template->assign_block_vars ( 'search_valid.search_valid_reps' , array (
				'URL' => 'index.php?mods=forum&amp;page=viewtopic&amp;id='.$rep_det[1],
				'NOM' => to_html($sqlzz['nom']),
				'PSEUDO' => htmlspecialchars($rep_det[2]),
				'DATE' => The.' '.date('d/m/Y',$rep_det[3]).' '.at.' '.date('H \h i',$rep_det[3])
				));
			}
		}

		if($b == 0)
			$template->assign_block_vars ( 'search_valid.search_valid_emptys' , array ( 'TXT' => NONE_CORELATION ) );
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
?>