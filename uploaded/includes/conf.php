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

//Variables pour lactivation de l'url rewriting ( a automatiser plus tard ;) ):
define ( 'URL_REWRITING' , 'off' );

$nb_requete = 0;

$uid = 1;

$permissions = '';

// On definit le mot de passe utilise par les invites
$user_password = 'fgdfgs1df35sg4df3xcg24f';
$format_date = '';
include_once('./includes/config.php' );
$u_privacy = '0,0,0,0,0,0,0';

$appear_offline = 0;

// On stocke la cle de cryptage provenant du fichier config pour la comparer avec celle venant de la base
$crypt_key_config = $crypt_key;
// On importe les parametres
$req_param = $Bdd->get_cached_data('SELECT nom,valeur FROM '.PT.'_parametres', 3600,'config' );
foreach ($req_param as $conf){
	${$conf['nom']} = $conf['valeur'];
}
$Bdd->free_result($req_param);	
// Puis les Grades
// On importe les parametres
$req_grades = $Bdd->get_cached_data('SELECT nbr, name, permissions FROM '.PT.'_grades', 86400,'config' );
foreach ($req_grades as $array){
	${'grade_'.$array['nbr']} = array ( 
		'name' => $array [ 'name' ],
		'permissions' => $array [ 'permissions' ]
		);
}
// On compte le nombre total de grades servant pour apres
$nb_total_grades = $Bdd->num_rows ( $req_grades );

$fuseaux_def_2 = explode ( ';' , $fuseaux_def );
$fuseaux_def_2 = $fuseaux_def_2[0] + $fuseaux_def_2[1];

$Bdd->free_result($req_grades);	

$Bdd->return_error($Bdd);

if( isset( $_COOKIE['id'] ) AND isset( $_COOKIE ['pass'] ) )//utilisateur déjà loggué
{
	// On importe la liste des users
	$req_user = $Bdd->sql('SELECT '.PT.'_users.id AS id, '.PT.'_users.abonnements AS abonnements, '.PT.'_users.avatar AS avatar, '.PT.'_users.icq AS icq, '.PT.'_users.pseudo AS pseudo,'.PT.'_users.pass AS pass,'.PT.'_users.email AS  email,'.PT.'_users.permission AS  permission, '.PT.'_users.last_mess_date as last_mess_date, '.PT.'_users.groupe AS  groupe, '.PT.'_users.nom AS  nom,'.PT.'_users.signature AS  signature , '.PT.'_users.site as site, '.PT.'_users.localisation AS localisation, '.PT.'_users.sexe AS sexe, '.PT.'_users.date_naissance AS date_naissance, '.PT.'_users.date_inscription AS date_inscription, '.PT.'_users.grades AS grades, '.PT.'_users.fuseaux AS fuseaux, '.PT.'_users.lunonlu AS lunonlu, '.PT.'_users.abonnements AS abonnements, '.PT.'_users.msn AS msn, '.PT.'_users.theme AS theme, '.PT.'_users.langue AS langue, '.PT.'_users.privacy AS privacy, '.PT.'_users.appear_offline AS appear_offline, '.PT.'_users.yahoom AS yahoom, '.PT.'_users.aim AS aim, '.PT.'_users.other_field as other_field, '.PT.'_users.format_date as format_date FROM '.PT.'_users WHERE id="'.intval($_COOKIE['id']).'"' );
	$sql_user = $Bdd->get_array ( $req_user );
	$Bdd->free_result ( $req_user );

	//question de sécurité
	$id_cookie = intval ( $_COOKIE['id'] );
	$pass_cookie  = htmlspecialchars ( $_COOKIE['pass'] , ENT_QUOTES );		

	//Chargement info users si c'est bon										
	if ( $sql_user['pass'] == $pass_cookie ){
		
		if ( $sql_user['fuseaux'] != '' ){
			$fuseaux_user_2 = explode ( ';' , $sql_user['fuseaux'] );
			
			$fuseaux_user = $fuseaux_user_2 [ 0 ] + $fuseaux_user_2 [ 1 ];
		}
		else{
			$fuseaux_user_2 = $fuseaux_def_2;
			$fuseaux_user = $fuseaux_def_2;
		}
	
		$nom = htmlspecialchars($sql_user['nom']);
		$uid = $id_cookie;
		$u_avatar = htmlspecialchars ( $sql_user['avatar'] );
		$user_password = $sql_user['pass'];
		$grade = $sql_user['grades'];
		$pseudo = htmlspecialchars($sql_user['pseudo']);
		$permissions = $sql_user['permission'];
		$u_theme = $sql_user['theme'];	
		$user_last_mess = $sql_user['last_mess_date'];
		$groupe = $sql_user['groupe'];
		$u_abo = $sql_user['abonnements'];
		$fuseaux = $fuseaux_user ;
		$lunonlu = $sql_user['lunonlu'];
		$u_lang = $sql_user['langue'];
		$u_privacy = $sql_user['privacy'];
		$appear_offline = $sql_user['appear_offline'];
		$format_date = $sql_user['format_date'];
		
		// On va fusionner les permissions que l'utilisateur possede avec celle héritée de son grade ;)
		
		// On recupere les permissions de l'utilisateur dans un array
		$permissions_user = explode ( ';' , $permissions );
		
		// On recupere celle du grade auxquel il appartient dans un autre array
		$permissions_grade = explode ( ';' , ${'grade_'.$grade}['permissions'] );
		
		// On fusionne les deux array
		$permissions_f = array_merge ( $permissions_user , $permissions_grade );
		
		// Et voila ^^.
		$permissions = implode ( ';' , $permissions_f );
		//
		
		$Bdd->sql('UPDATE '.PT.'_users SET last_ip="'.$HTTP_SERVER_VARS['REMOTE_ADDR'].'", last_activity_date="'.convertime(time()).'" WHERE id="'.$uid.'"' );
	
		//Si l'user demande d'etre connecté automatiquement on crée cookie
		if (isset($_COOKIE['auto']) AND $_COOKIE['auto'] == 'on')
		{
			setcookie ( "id" , $uid , ( time() + 31536000 ) );
			setcookie ( "pass" , $user_password , ( time() + 31536000 ) );
			setcookie ( "auto" , "on" , ( time() + 31536000 ) );
		}
		else
		{
			setcookie ( "id" , $uid , ( time() + 3600 ) );
			setcookie ( "pass" , $user_password , ( time() + 3600 ) );
			setcookie ( "auto" , "off" , ( time() + 3600 ) );
		}
	}
	else{
		setcookie ( "id" , 1 , 0 );
		setcookie ( "pass" , "" , 0 );
		setcookie ( "auto" , "" , 0 );
		$fuseaux_user = $fuseaux_def_2;
	}
}
else{
//utilisateur pas loggué
    $theme  = $default_theme  ; 
	$fuseaux = $fuseaux_def_2;
	$permissions = $grade_0['permissions'];
	setcookie ( "id" , 1 , 0 );
	setcookie ( "pass" , "" , 0 );
	setcookie ( "auto" , "" , 0 );
}

if(!isset($grade)){
	$groupe = 0;
	$uid = 1;
	$grade = 0;
	$lunonlu='';
	$fuseaux = $fuseaux_def;
	$permissions = $grade_0['permissions'];
	setcookie ( "id" , 1 , 0 );
	setcookie ( "pass" , "" , 0 );
	setcookie ( "auto" , "" , 0 );
	$u_theme= $default_theme;
	$u_lang = $default_langage;
}

if ( $u_privacy == '' )$u_privacy = '0,0,0,0,0,0,0';
// Si le thème n'existe pas, on lui donne le thème par defaut du site
if($u_theme=='' OR !file_exists('./themes/'.$u_theme.'/header.tpl'))$u_theme= $default_theme;
// Si le langage n'existe pas, on lui donne le langage par defaut du site
if($u_lang=='' OR !file_exists('./langues/'.$u_lang.'/lang.php'))$u_lang = $default_langage;
// Et si le langage par defaut du site n'existe pas ( decidemment le mec a pas de chance ), on charge la langue francaise qui est celle qui marche en general ^^
if ( !file_exists('./langues/'.$u_lang.'/lang.php') )$u_lang = 'francais';

// Si on oblige les utilisateurs a utiliser le theme du site, on leur met le theme par defaut.
if ( $default_theme_locked == 1 )$u_theme = $default_theme;
if ( $format_date == '' )$format_date = $default_format_date;
?>