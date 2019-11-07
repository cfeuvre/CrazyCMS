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

header('Content-type: text/html; charset=iso-8859-15' ); 

include('../../includes/config.php' );
include('../../includes/fonctions.php' );
include('../../mods/forum/class.forum.php' );

if ( file_exists ( '../../langues/'.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['lang'] ).'/lang.php' ) )
	include('../../langues/'.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['lang'] ).'/lang.php' );
$Forum = new Class_Forum();

	// On recupere les parametres
	$query2 = $Bdd->sql('SELECT nom, valeur FROM '.PT.'_parametres' );
	while ( $sql2 = $Bdd->get_array($query2) ){
		${$sql2['nom']} = $sql2['valeur'];
	}
	
	// On verifie que l'utilisateur existe et on recupere ses permissions
	$query = $Bdd->sql('SELECT groupe, permission, grades FROM '.PT.'_users WHERE id="'.intval($_POST['uid']).'" AND pass="'.htmlspecialchars($_POST['pass'],ENT_QUOTES).'"' );	
	$sql = $Bdd->get_array($query);
	
	$req_grades = $Bdd->sql('SELECT nbr, name, permissions FROM '.PT.'_grades' );
	while ( $array = $Bdd->get_array ( $req_grades ) ){
	${'grade_'.$array['nbr']} = array ( 
		'name' => $array [ 'name' ],
		'permissions' => $array [ 'permissions' ]
		);
	}
	
	// On va fusionner les permissions que l'utilisateur possede avec celle héritée de son grade ;)
		
		// On recupere les permissions de l'utilisateur dans un array
		$permissions_user = explode ( ';' , $sql['permission'] );
		
		// On recupere celle du grade auxquel il appartient dans un autre array
		$permissions_grade = explode ( ';' , ${'grade_'.$sql['grades']}['permissions'] );
		
		// On fusionne les deux array
		$permissions_f = array_merge ( $permissions_user , $permissions_grade );

		$permissions = implode ( ';' , $permissions_f );
		//
	
if(isset($_GET['load'])){
	$u_theme = htmlspecialchars($_POST['theme'],ENT_QUOTES);

	if($Bdd->get_num_rows($query)==0){
		echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!!!';
	}
	else{
		
		$uid = intval($_POST['uid']);

		switch($_POST['module']){
		
		case 'dl_comment' :
		
			$grades = explode ( ',' , $download_grade_admin );
			if( $sql['grades'] ==4 OR in_array ( $sql['grades'] , $grades , TRUE ) ){
				$query = $Bdd->sql ( 'SELECT parent,contenu FROM '.PT.'_download_comments WHERE id="'.intval ( $_POST['idp'] ).'"' );
				$sql2 = $Bdd->get_array ( $query );
				$Bdd->free_result ( $query );
					$form = default_form(
					FALSE,
					NULL,
					to_html ( $sql2['contenu'] , '../..' , FALSE ),
					200,
					'real_post(\''.htmlspecialchars ( $_POST['div'] ).'\',
					\''.$uid.'\',
					\''.htmlspecialchars($_POST['pass'],ENT_QUOTES).'\',
					\''.htmlspecialchars($_POST['idp'],ENT_QUOTES).'\',
					\'dl_comment\',
					\''.htmlspecialchars($_POST['module'],ENT_QUOTES).'\',
					\''.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['lang'] ).'\',
					false,
					\''.htmlspecialchars($_POST['sdiv'],ENT_QUOTES).'\');',
					'../..',
					htmlspecialchars($_POST['sdiv'],ENT_QUOTES));
				
				$form = str_replace( '<script type="text/javascript">' , '' , str_replace ( '</script>' , '|*|ÙÛÞþµµÕõÒÔÓ|*|', $form ) );
				echo $form;
			}
			else{
				echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!';
			}
		break;
		
		case 'forumtopic' :
		
			$mess = $Bdd->sql('SELECT nom, contenu, auteur, parent FROM '.PT.'_forum_topic WHERE id="'.intval($_POST['idp']).'"' );
			if($Bdd->get_num_rows($mess)>0){
				$sql_mess = $Bdd->get_array($mess);
				
				// On regarde si l'utilisateur n'est pas moderateur du forum parent ;)
					$q2 = $Bdd->sql ( 'SELECT moderators FROM '.PT.'_forum_for WHERE id="'.$sql_mess['parent'].'"' );
					$s2 = $Bdd->get_array ( $q2 );
					
					// Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
					$modo = $Forum->is_mod ( $s2['moderators'] );
					$permissions .= $modo['perms'];
				
				// On verifie permissions d'edit
				$permis = false;
				$permis = $Forum->give_permissions($permissions,$sql['grades'],'edit_all_topics' , 'edit_our_topics',1,$sql_mess['auteur']);
				$grades = explode ( ',' , $forum_grade_admin );
				if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
					$permis = true;
				}
				if($permis === true){
					$form = default_form(
					TRUE,
					to_html ( $sql_mess['nom'] , '../..' , FALSE ),
					to_html ( $sql_mess['contenu'] , '../..' , FALSE ),
					200,
					'real_post(\'topic_contenu\',
					\''.$uid.'\',
					\''.htmlspecialchars($_POST['pass'],ENT_QUOTES).'\',
					\''.htmlspecialchars($_POST['idp'],ENT_QUOTES).'\',
					\'forumtopic\',
					\''.htmlspecialchars($_POST['module'],ENT_QUOTES).'\',
					\''.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['lang'] ).'\',
					true,
					\''.htmlspecialchars($_POST['sdiv'],ENT_QUOTES).'\');',
					'../..',
					htmlspecialchars($_POST['sdiv'],ENT_QUOTES));
					
					$form = str_replace( '<script type="text/javascript">' , '' , str_replace ( '</script>' , '|*|ÙÛÞþµµÕõÒÔÓ|*|', $form ) );
					echo $form;
				}
				else{
					echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!';
				}
			}
			else{
				echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!!';
			}
		
		break;
		
		case 'forumreply' :
		
			$mess = $Bdd->sql('SELECT contenu, auteur, parent FROM '.PT.'_forum_reply WHERE id="'.intval($_POST['idp']).'"' );
			$sql_mess = $Bdd->get_array($mess);
		
			// On regarde si l'utilisateur n'est pas moderateur du forum parent ;)
				$query2 = $Bdd->sql ( 'SELECT parent FROM '.PT.'_forum_topic WHERE id="'.$sql_mess['parent'].'"' );
				$sql2 = $Bdd->get_array ( $query2 );
				
				$q2 = $Bdd->sql ( 'SELECT moderators FROM '.PT.'_forum_for WHERE id="'.$sql2['parent'].'"' );
				$s2 = $Bdd->get_array ( $q2 );
				
				// Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
				$modo = $Forum->is_mod ( $s2['moderators'] );
				$permissions .= $modo['perms'];
				
			if($Bdd->get_num_rows($mess)>0){

				$permis = false;
			
				$permis = $Forum->give_permissions($permissions,$sql['grades'],'edit_all_replys' , 'edit_our_replys',1,$sql_mess['auteur']);
				$grades = explode ( ',' , $forum_grade_admin );
				if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
					$permis = true;
				}
		
				if($permis === true){
					
					$form = default_form(
					FALSE,
					NULL,
					to_html ( $sql_mess['contenu'] , '../..' , FALSE ),
					200,
					'real_post(\'topic_reply_'.intval($_POST['idp']).'\',
					\''.$uid.'\',
					\''.htmlspecialchars($_POST['pass'],ENT_QUOTES).'\',
					\''.htmlspecialchars($_POST['idp'],ENT_QUOTES).'\',
					\'forumreply\',
					\''.htmlspecialchars($_POST['module'],ENT_QUOTES).'\',
					\''.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['lang'] ).'\',
					false,
					\''.htmlspecialchars($_POST['sdiv'],ENT_QUOTES).'\');',
					'../..',
					htmlspecialchars($_POST['sdiv'],ENT_QUOTES));

					$form = str_replace( '<script type="text/javascript">' , '' , str_replace ( '</script>' , '|*|ÙÛÞþµµÕõÒÔÓ|*|', $form ) );
					echo $form;
				}
				else{
					echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!';
				}
			}
			else{
				echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!!';
			}
		break;
		
		case 'livredor' :
			$grades = explode ( ',' , $livre_dor_grade_admin );
			if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
				
				$query_mess = $Bdd->sql('SELECT com FROM '.PT.'_livredor WHERE id="'.intval($_POST['idp']).'"' );
				if($Bdd->get_num_rows($query_mess)>0){
				
				$sql_mess = $Bdd->get_array($query_mess);

				$form = default_form(
					FALSE,
					NULL,
					to_html ( $sql_mess['com'] , '../..' , FALSE ),
					200,
					'real_post(\'lvor_'.intval($_POST['idp']).'\',
					\''.$uid.'\',
					\''.htmlspecialchars($_POST['pass'],ENT_QUOTES).'\',
					\''.htmlspecialchars($_POST['idp'],ENT_QUOTES).'\',
					\'livredor\',
					\''.htmlspecialchars($_POST['module'],ENT_QUOTES).'\',
					\''.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['lang'] ).'\',
					false,
					\''.htmlspecialchars($_POST['sdiv'],ENT_QUOTES).'\');',
					'../..',
					htmlspecialchars($_POST['sdiv'],ENT_QUOTES));
				
				$form = str_replace( '<script type="text/javascript">' , '' , str_replace ( '</script>' , '|*|ÙÛÞþµµÕõÒÔÓ|*|', $form ) );
				echo $form;
				
				}
			}
			else{
				echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!';
			}		
		
		break ;
		
		case 'news' :
			$grades = explode ( ',' , $news_grade_admin );
			if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
				
				$query_mess = $Bdd->sql('SELECT titre, contenu FROM '.PT.'_news WHERE id="'.intval($_POST['idp']).'"' );
				if(mysql_num_rows($query_mess)>0){
				$sql_mess = $Bdd->get_array ( $query_mess );
				$form = default_form(
					TRUE,
					to_html ( $sql_mess['titre'] , '../..' , FALSE ),
					to_html ( $sql_mess['contenu'] , '../..' , FALSE ),
					200,
					'real_post(\'news_'.intval($_POST['idp']).'\',
					\''.$uid.'\',
					\''.htmlspecialchars($_POST['pass'],ENT_QUOTES).'\',
					\''.htmlspecialchars($_POST['idp'],ENT_QUOTES).'\',
					\'news\',
					\''.htmlspecialchars($_POST['module'],ENT_QUOTES).'\',
					\''.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['lang'] ).'\',
					true,
					\''.htmlspecialchars($_POST['sdiv'],ENT_QUOTES).'\');',
					'../..',
					htmlspecialchars($_POST['sdiv'],ENT_QUOTES));

				$form = str_replace( '<script type="text/javascript">' , '' , str_replace ( '</script>' , '|*|ÙÛÞþµµÕõÒÔÓ|*|', $form ) );
				echo $form;
				
				}
			}
			else{
				echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!';
			}		
		
		break;		
		
		case 'comment' :
		
			$grades = explode ( ',' , $news_grade_admin );
			if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){

				$query_mess = $Bdd->sql('SELECT contenu FROM '.PT.'_comment WHERE id="'.intval($_POST['idp']).'"' );
				if(mysql_num_rows($query_mess)>0){
				
				$sql_mess = $Bdd->get_array($query_mess);
				
				$form = default_form(
					FALSE,
					NULL,
					to_html ( $sql_mess['contenu'] , '../..' , FALSE ),
					200,
					'real_post(\''.htmlspecialchars($_POST['div'],ENT_QUOTES).'\',
					\''.$uid.'\',
					\''.htmlspecialchars($_POST['pass'],ENT_QUOTES).'\',
					\''.htmlspecialchars($_POST['idp'],ENT_QUOTES).'\',
					\'comment\',
					\''.htmlspecialchars($_POST['module'],ENT_QUOTES).'\',
					\''.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['lang'] ).'\',
					false,
					\''.htmlspecialchars($_POST['sdiv'],ENT_QUOTES).'\');',
					'../..',
					htmlspecialchars($_POST['sdiv'],ENT_QUOTES));

				$form = str_replace( '<script type="text/javascript">' , '' , str_replace ( '</script>' , '|*|ÙÛÞþµµÕõÒÔÓ|*|', $form ) );
				echo $form;
				
				}
			}
			else{
				echo '|*|ÙÛÞþµµÕõÒÔÓ|*|!';
			}		
		
		break;	
		
		}	
	}
}
else if(isset($_GET['post'])){

	if($Bdd->get_num_rows($query)==0){
		echo 'echec d\'authentification';
	}
	else{
		$uid = intval($_POST['uid']);
		switch($_POST['module']){
		
			case 'dl_comment' :
				$grades = explode ( ',' , $download_grade_admin );
				if( $sql['grades'] ==4 OR in_array ( $sql['grades'] , $grades , TRUE ) ){
					$contenu = $Bdd->secure( utf8_decode ( html_entity_decode ( stripslashes ( $_POST['message'] ) ) ) );
					$Bdd->sql ( 'UPDATE '.PT.'_download_comments SET contenu="'.$contenu.'" WHERE id="'.intval($_POST['idp']).'"' );
					echo to_html (  str_replace ( '\n' , '<br />' , str_replace ( '\r\n' , '<br />' , $contenu ) ) ,'../..' );
				}
				else{
					echo '!';
				}
			break;
			
			case 'forumtopic' :
			
				$mess = $Bdd->sql('SELECT nom, contenu, auteur, parent FROM '.PT.'_forum_topic WHERE id="'.intval($_POST['idp']).'"' );
				if($Bdd->get_num_rows($mess)>0){
					$sql_mess = $Bdd->get_array($mess);
					
					// On regarde si l'utilisateur n'est pas moderateur du forum parent ;)
						$q2 = $Bdd->sql ( 'SELECT moderators FROM '.PT.'_forum_for WHERE id="'.$sql_mess['parent'].'"' );
						$s2 = $Bdd->get_array ( $q2 );
						
						// Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
						$modo = $Forum->is_mod ( $s2['moderators'] );
						$permissions .= $modo['perms'];
					
					$permis = false;
					$permis = $Forum->give_permissions($permissions,$sql['grades'],'edit_all_topics' , 'edit_our_topics',1,$sql_mess['auteur']);
					$grades = explode ( ',' , $forum_grade_admin );
					if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
						$permis = true;
					}
		
					if($permis === true){
						$contenu = $Bdd->secure( utf8_decode ( html_entity_decode ( stripslashes ( $_POST['message'] ) ) ) );
						$titre = $Bdd->secure( utf8_decode ( html_entity_decode ( stripslashes ( $_POST['title'] ) ) ) );
						$contenu = str_replace('varandtoreplace' , '&',str_replace('varplustoreplace' , '+',str_replace('vareurotoreplace' , '&euro;',$contenu)));
						$titre = str_replace('varandtoreplace' , '&',str_replace('varplustoreplace' , '+',str_replace('vareurotoreplace' , '&euro;',$titre)));
						$Bdd->sql('UPDATE '.PT.'_forum_topic SET nom="'.$titre.'", contenu="'.$contenu.'" WHERE id="'.intval($_POST['idp']).'"' );
						echo to_html (  str_replace ( '\n' , '<br />' , str_replace ( '\r\n' , '<br />' , $contenu ) ) ,'../..' );
					}
					else{
					
						echo '!';
					
					}
				
				}
				else{
					echo '!';
				}
			
			break;
			
			case 'forumreply' :
			
				$mess = $Bdd->sql('SELECT contenu, auteur, parent FROM '.PT.'_forum_reply WHERE id="'.intval($_POST['idp']).'"' );
				$sql_mess = $Bdd->get_array($mess);
			
				// On regarde si l'utilisateur n'est pas moderateur du forum parent ;)
					$query2 = $Bdd->sql ( 'SELECT parent FROM '.PT.'_forum_topic WHERE id="'.$sql_mess['parent'].'"' );
					$sql2 = $Bdd->get_array ( $query2 );
					
					$q2 = $Bdd->sql ( 'SELECT moderators FROM '.PT.'_forum_for WHERE id="'.$sql2['parent'].'"' );
					$s2 = $Bdd->get_array ( $q2 );
					
					// Si l'utilisateur est moderateur du forum parent, on lui donne les permissions de moderateur ici.
					$modo = $Forum->is_mod ( $s2['moderators'] );
					$permissions .= $modo['perms'];
				
				if($Bdd->get_num_rows($mess)>0){
					
					
					$permis = false;
					$permis = $Forum->give_permissions($permissions,$sql['grades'],'edit_all_replys' , 'edit_our_replys',1,$sql_mess['auteur']);
					$grades = explode ( ',' , $forum_grade_admin );
					if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
						$permis = true;
					}
		
					if($permis === true){
						$contenu = $Bdd->secure( html_entity_decode ( utf8_decode ( stripslashes ( $_POST['message'] ) ) ) );
						$contenu = str_replace('varandtoreplace' , '&',str_replace('varplustoreplace' , '+',str_replace('vareurotoreplace' , '&euro;',$contenu)));
						$Bdd->sql('UPDATE '.PT.'_forum_reply SET contenu="'.$contenu.'" WHERE id="'.intval($_POST['idp']).'"' );
						echo to_html (  str_replace ( '\n' , '<br />' , str_replace ( '\r\n' , '<br />' , $contenu ) ) ,'../..' );
						
					}
					else{
					
						echo '!';
					
					}
				
				}
				else{
					echo '!';
				}
				
			break;
			
			case 'livredor' :
			
				$grades = explode ( ',' , $livre_dor_grade_admin );
				if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
				
				
					$contenu = $Bdd->secure ( html_entity_decode ( utf8_decode ( stripslashes ( $_POST['message'] ) ) ) );
					$contenu = str_replace('varandtoreplace' , '&',str_replace('varplustoreplace' , '+',str_replace('vareurotoreplace' , '&euro;',$contenu)));
				
					$Bdd->sql('UPDATE '.PT.'_livredor SET com="'.$contenu.'" WHERE id="'.intval($_POST['idp']).'"' );
					echo to_html (  str_replace ( '\n' , '<br />' , str_replace ( '\r\n' , '<br />' , $contenu ) ) ,'../..' );
				
				}
				else{
					echo '!';
				}
			
			break;
			
			case 'news' :
			
				$grades = explode ( ',' , $news_grade_admin );
				if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
				
				
					$contenu = $Bdd->secure ( html_entity_decode ( utf8_decode ( stripslashes ( $_POST['message'] ) ) ) );
					$titre = $Bdd->secure ( html_entity_decode ( utf8_decode ( stripslashes ( $_POST['title'] ) ) ) );
					$contenu = str_replace('varandtoreplace' , '&',str_replace('varplustoreplace' , '+',str_replace('vareurotoreplace' , '&euro;',$contenu)));
					$titre = str_replace('varandtoreplace' , '&',str_replace('varplustoreplace' , '+',str_replace('vareurotoreplace' , '&euro;',$titre)));
				
					$Bdd->sql('UPDATE '.PT.'_news SET contenu="'.$contenu.'", titre="'.$titre.'" WHERE id="'.intval($_POST['idp']).'"' );
					$Bdd->delete_cached_data('news','../../');
					echo to_html (  str_replace ( '\n' , '<br />' , str_replace ( '\r\n' , '<br />' , $contenu ) ) ,'../..' );
					$doss = opendir ( '../../cache/cache/news/' );
					while ( $file = readdir ( $doss ) ){
						if ( $file != '.' && $file != '..' ){
							@unlink ( '../../cache/cache/news/'.$file );
						}
					}
					fclose ( $doss );
					@unlink ( '../news/news.xml' );
				}
				else{
					echo '!'.$sql['grades'];
				}
			
			break;
		
			case 'comment' :
			
				$grades = explode ( ',' , $news_grade_admin );
				if($sql['grades']==4 || in_array ( $sql['grades'] , $grades , TRUE ) ){
				
				
					$contenu = $Bdd->secure ( html_entity_decode ( utf8_decode ( stripslashes ( $_POST['message'] ) ) ) );
					$contenu = str_replace('varandtoreplace' , '&',str_replace('varplustoreplace' , '+',str_replace('vareurotoreplace' , '&euro;',$contenu)));
				
					$Bdd->sql('UPDATE '.PT.'_comment SET contenu="'.$contenu.'" WHERE id="'.intval($_POST['idp']).'"' );
					echo to_html (  str_replace ( '\n' , '<br />' , str_replace ( '\r\n' , '<br />' , $contenu ) ) ,'../..' );
					$doss = opendir ( '../../cache/cache/comment/' );
					while ( $file = readdir ( $doss ) ){
						if ( $file != '.' && $file != '..' ){
							@unlink ( '../../cache/cache/comment/'.$file );
						}
					}
					fclose ( $doss );
				}
				else{
					echo '!';
				}
			
			break;
		}
	
	}

}
?>