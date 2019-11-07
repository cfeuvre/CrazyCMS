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

AJAX DU MOD TCHAT
*/
header('Content-type: text/html; charset=iso-8859-15' ); 

/*
LANGUE TEMP
*/

if(!isset($_GET['smil'])){
	if ( file_exists ( '../../mods/tchat/langues/'.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['langue'] ).'.php' ) )
		include( '../../mods/tchat/langues/'.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['langue'] ).'.php' );
	if ( file_exists ( '../../langues/'.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['langue'] ).'/lang.php' ) )
		include( '../../langues/'.preg_replace ( '#([^a-zA-Z0-9-_]+)#' , '' , $_POST['langue'] ).'/lang.php' );
}
// Recuperation des smileys
if(isset($_GET['smil'])){

	$handle = opendir("../../smileys/"); 
	$a = 0;
	echo "
	<table border=\"0\">
		<tr>";
	while (($file = readdir($handle))!=false) { 	
			if($file!=".." && $file!=".")
			{	
				$bal = substr($file,0,strlen($file)-4);
				echo "
			<td>
				<a href=\"javascript:smi('".addslashes($bal)."')\">
					<img src=\"./smileys/$file\" border=\"0\" alt=\"$file\" />
				</a>
			</td>";
				if($a == 5){
					echo '
		</tr>
		<tr>';
					$a = 1;
				}
			}
			$a ++ ;
		}
	closedir($handle); 
	
}
else if( isset($_GET['verif']) ){

	include('../../includes/fonctions.php' );
	clearstatcache();
	
	$salon = htmlspecialchars($_POST['salon'],ENT_QUOTES);
	// On recupere les informations de connection de l'utilisateur ainsi que celle du salon ou il se trouve
	$uid = intval($_POST['uid']);
	$password = htmlspecialchars(base64_decode(str_replace('egaletoreplace' , '=',$_POST['password'])));
	$salon_pwd = htmlspecialchars(base64_decode(str_replace('egaletoreplace' , '=',$_POST['salonpwd'])));
	
	// On recupere les informations de l'utilisateur que ce gentil utilisateur a laisse dans le fichier users.ini ;)	
	$users = parse_ini_file('./config/users.ini',true);
	$arpseudo = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['pseudo']));
	$arpassword = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['password']));
	$permissions = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['permissions']));
	$grade = $users[$uid]['grade'];
	
	
	if($password == $arpassword){
		// Si l\'utilisateur est bien identifie, on verifie ses permissions .
		if( ereg("view_chat;",$permissions) || $grade == 4)
		{
			if ( $salon == 'defaut' ){
				$salon = './salons/default.ini';
				$pwd = false;
			}
			else{
				if ( substr ( $salon , 0 , 4 ) == 'pub-'){
					$salon = './salons/public/'.substr ( $salon , 4 , strlen ( $salon ) ).'.ini';
					$pwd = false;
				}
				else if ( substr ( $salon , 0 , 4 ) == 'pri-'){
					$salon = './salons/prive/'.substr ( $salon , 4 , strlen ( $salon ) ).'.ini';
					$pwd = true;
				}
			}
			// On charge le salon
			$message = parse_ini_file ( $salon , TRUE );
			
			// Si le salon est prive, on verifie que l'user a lautorisation dy acceder ;)
			if ( ( $pwd === false ) || ( $message['config']['salon_password'] == $salon_pwd ) ) {
			
				// On va juste regarder la configuration du salon pour voir la date dernier message et mettre a jour les utilisateurs connectes
				if ( intval($_POST['last_our_mess']) < $message['config']['lastdate'] ){
					echo 'new|*|';
				}
				else {
					echo 'none|*|';
				}
					
				// On recupere tous les users present :
				$all_users = $message['config']['actual_users'];
				$all_users = explode ( ' , ' , $all_users );
				$users_liste = '';
				$liste_user_print = '';
				$uncrypt_liste = '';
				foreach( $all_users as $user ){
					if($user != ''){
						$user = explode ( ':' , $user );
						if ( $user[1] > ( time() - 12 ) ){
							// On cree array qui contient liste users non crypte
							$uncrypt_liste .= base64_decode ( str_replace ( 'egaletoreplace' , '=' , $user[0] ) ).' , ';
							// Liste des users crypte pour mettre a jour liste des connectes ;)
							$users_liste .= $user[0].':'.$user[1].' , ';
							$liste_user_print .= base64_decode ( str_replace ( 'egaletoreplace' , '=' , $user[0] ) ).';;';
						}
					}
				}
				$liste_user_print = explode ( ';;' , $liste_user_print );
				asort ( $liste_user_print );
				foreach ( $liste_user_print as $user ){
					echo '<br />'.str_replace ( '|*|' , '|¤|' , $user );
				}
				echo '|*|';
				
				foreach ( $liste_user_print as $user ){
					echo str_replace ( '|*|' , '|¤|' , $user ).' , ';
				}
				echo '|*|';
				
				// On met a jour la liste user en nous ( re ) mettant dedans :
				$nous = str_replace( '=' , 'egaletoreplace' , base64_encode( $arpseudo ) );				
				$users_liste = preg_replace ( '!'.$nous.':[0-9]+ ,?!' , '' , $users_liste );	
				$uncrypt_liste = str_replace ( $arpseudo , '' , $uncrypt_liste );
				$users_liste .= str_replace( '=' , 'egaletoreplace' , base64_encode( $arpseudo ) ).':'.time();
				$uncrypt_liste .= $arpseudo;
				
				$ini = '';
				$file = fopen( $salon , 'r' );
				while ( !feof ( $file ) ){
					$ini .= fgets ( $file , 4096 );
				}
				fclose ( $file );
				$ini = preg_replace ( '!actual_users =[ ]+'.$message['config']['actual_users'].';!' , 'actual_users = '.$users_liste.';' , $ini );
				$file = fopen ( $salon , 'w' );
					fputs ( $file , $ini );
				fclose ( $file );
				//
	
				$last_liste = utf8_decode(htmlspecialchars($_POST['liste'],ENT_QUOTES));
				// On recupere les anciens connectes et connectes actuels dans arrays pour faire difference
				$last_array = explode ( ' , ' , $last_liste );

				$new_array = explode ( ' , ' , $uncrypt_liste );
				
				
	
				$new_user = array_diff ( $new_array , $last_array );
				$arrivee = '';
				foreach ( $new_user as $new ){
					if ( $new != '' ){
						$arrivee .= $new.' , ';
					}
				}
				echo $arrivee.'|*|';
	
				$lost_user = array_diff ( $last_array , $new_array );
				$depart = '';
				foreach ( $lost_user as $lost ){
					if ( $lost != '' ){
						$depart .= $lost.', ';
					}
				}
	
				echo $depart.'|*|';
			}
			else{
				echo CHAT_ERREUR_PERMISSION;
			}
		}
		else{
			echo CHAT_ERREUR_PERMISSION;
		}
	}
	else{
		echo CHAT_ERREUR_PERMISSION;
	}
}
else if( isset($_GET['load'])){

	$format_date = htmlspecialchars ( $_POST [ 'format_date' ] );
	$format_date = str_replace ( 'plustoreplace' , '+' , str_replace ( 'andtoreplace' , '&' , str_replace ( 'egaletoreplace' ,  '=' , $format_date ) ) );
	include('../../includes/fonctions.php' );
	
	include('../../includes/class.template.php' );
	$template = new Template( '../../themes/'.htmlspecialchars($_POST['theme'],ENT_QUOTES) , TRUE );
	$template->set_filename ( './modules/tchat/ajax.tpl' );
	
	define ( 'CCMS' , TRUE );
	
	clearstatcache();
	
	if($_POST['salon']=='defaut'){
		$salon = 'defaut';
	}
	else{
		$salon = htmlspecialchars($_POST['salon'],ENT_QUOTES);
	}
	// On recupere les informations de connection de l'utilisateur ainsi que celle du salon ou il se trouve
	$uid = intval($_POST['uid']);
	$password = htmlspecialchars(base64_decode(str_replace('egaletoreplace' , '=',$_POST['password'])));
	$salon_pwd = htmlspecialchars(base64_decode(str_replace('egaletoreplace' , '=',$_POST['salonpwd'])));
	
	// On recupere les informations de l'utilisateur que ce gentil utilisateur a laisse dans le fichier users.ini ;)	
	$users = parse_ini_file('./config/users.ini',true);
	$arpseudo = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['pseudo']));
	$arpassword = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['password']));
	$permissions = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['permissions']));
	$grade = $users[$uid]['grade'];
	if($password == $arpassword){
		// Si l\'utilisateur est bien identifie, on verifie ses permissions .
		if( ereg("view_chat;",$permissions) || $grade == 4)
		{
			if ( $salon == 'defaut' ){
				$salon = './salons/default.ini';
				$pwd = false;
			}
			else{
				if ( substr ( $salon , 0 , 4 ) == 'pub-'){
					$salon = './salons/public/'.substr ( $salon , 4 , strlen ( $salon ) ).'.ini';
					$pwd = false;
				}
				else if ( substr ( $salon , 0 , 4 ) == 'pri-'){
					$salon = './salons/prive/'.substr ( $salon , 4 , strlen ( $salon ) ).'.ini';
					$pwd = true;
				}
			}
			// On charge le salon
			$messages = parse_ini_file ( $salon , TRUE );
			// Si le salon est prive, on verifie que l'user a lautorisation dy acceder ;)
			if ( ( $pwd === false ) || ( $messages['config']['salon_password'] == $salon_pwd ) ) {
				
				// On recuperer le nombre de message a charger :
				$config = parse_ini_file ( './config/config.ini' );
				$nbre_mess = $config['nbre_mess'];
				
				$mess = '';
				
				// On charge les messages du chat
				foreach ( $messages as $nom => $array ) {
					if ( $nom != 'config' ) {
						$mess .= $array['pseudo'].'|**|'.$array['message'].'|**|'.$array['date'].'|*-*|';
					}				
				}

				 $array = explode ( '|*-*|' , $mess );
				 
				 $a = 0;
				 $nbre_mess = count ( $array ) - $nbre_mess;
				 $last_pseudo = 'Aucun';
				 foreach ( $array as $actuel ) {
					if($actuel != ''){
						$a ++;
						if ( $a >= $nbre_mess ){
							$actuel = explode ( '|**|' , $actuel );
							if ( $a == 1 )$last_pseudo = $actuel[0];
							$template->assign_block_vars ( 'messages' , array (
							'POST_BY' => POST_BY,
							'PSEUDO' => base64_decode ( str_replace ( 'egaletoreplace' , '=' , $actuel[0] ) ),
							'THE' => THE,
							'DATE' => ccmsdate( intval ( $_POST['fuseau'] ) , $actuel[2] ),
							'CONTENU' => str_replace ( 'varandtoreplace' , '&' , str_replace ( 'varplustoreplace' , '+' , to_html ( utf8_decode ( base64_decode ( str_replace ( 'egaletoreplace' , '=' , $actuel[1] ) ) ) , '../..' ) ) ) ) );
						}
					}
				}
				$template->gen();
				
				 if ( $a == 0 ){
				 echo NONE_MESSAGE_SALON;
				 }
				 echo '|*|'.time().'|*|'.$last_pseudo.'|*|'.stripslashes ( base64_decode ( str_replace ( 'egaletoreplace' , '=' , $messages['config']['welcome'] ) ) ).'<br />';
			}
			else{
				echo CHAT_ERREUR_PERMISSION;
			}
		}
		else{
			echo CHAT_ERREUR_PERMISSION;
		}
	}
	else{
		echo CHAT_ERREUR_PERMISSION;
	}
}
else if(isset($_GET['add'])){

	include('../../includes/fonctions.php' );
	clearstatcache();
	
	if($_POST['salon']=='defaut'){
		$salon = 'defaut';
	}
	else{
		$salon = htmlspecialchars($_POST['salon'],ENT_QUOTES);
	}

	// On recupere les informations de connection de l'utilisateur ainsi que celle du salon ou il se trouve
	$uid = intval($_POST['uid']);
	$password = htmlspecialchars(base64_decode(str_replace('egaletoreplace' , '=',$_POST['password'])));
	$salon_pwd = htmlspecialchars(base64_decode(str_replace('egaletoreplace' , '=',$_POST['salonpwd'])));
	
	// On recupere les informations de l'utilisateur que ce gentil utilisateur a laisse dans le fichier users.ini ;)	
	$users = parse_ini_file('./config/users.ini',true);
	$arpseudo = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['pseudo']));
	$arpassword = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['password']));
	$permissions = base64_decode(str_replace('egaletoreplace' , '=',$users[$uid]['permissions']));
	$grade = $users[$uid]['grade'];
	
	if($password == $arpassword){
		// Si l\'utilisateur est bien identifie, on verifie ses permissions .
		if( ereg("post_chat;",$permissions) || $grade == 4)
		{
			if ( $salon == 'defaut' ){
				$salon = './salons/default.ini';
				$pwd = false;
			}
			else{
				if ( substr ( $salon , 0 , 4 ) == 'pub-'){
					$salon = './salons/public/'.substr ( $salon , 4 , strlen ( $salon ) ).'.ini';
					$pwd = false;
				}
				else if ( substr ( $salon , 0 , 4 ) == 'pri-'){
					$salon = './salons/prive/'.substr ( $salon , 4 , strlen ( $salon ) ).'.ini';
					$pwd = true;
				}
			}
			
			// On charge le salon
			$messages = parse_ini_file ( $salon , TRUE );
			
			// Si le salon est prive, on verifie que l'user a lautorisation dy acceder ;)
			if ( ( $pwd === false ) || ( $messages['config']['salon_password'] == $salon_pwd ) ) {
			
				if(isset($_POST['message']) && strlen($_POST['message'])>=1 && ereg('[a-zA-Z0-9=.+^]',$_POST['message'])){
					// On met a jour la date de dernier message du salon
					$ini = '';
					$last = '';
					$file = fopen( $salon , 'r' );
					while ( !feof ( $file ) ){
						$ini .= $ligne = fgets ( $file , 4096 );
						if ( eregi ( '\[message:[0-9]+\]' , $ligne ) ) $last = $ligne;
					}
					fclose ( $file );
				
					$ini = str_replace ( 'lastdate = '.$messages['config']['lastdate'] , 'lastdate = '.time() , $ini );
				
					if ( $last == '' ) {
						$name = '[message:1]';
					}
					else{
						$id = preg_replace ( '!\[message:(.+)\]!' , '$1' , $last );
						$name = '[message:'.($id+1).']';
					}
				
					$ini .= '
				
					'.$name.'
						pseudo = '.$users[$uid]['pseudo'].';
						date = '.convertime(time()).';
						message = '.str_replace ( '=' , 'egaletoreplace' , base64_encode ( htmlspecialchars ( $_POST['message'] ) ) ).';';	
					$file = fopen ( $salon , 'w' );
						fputs ( $file , $ini );
					fclose ( $file );
				}
			}
		}
	}
}
else if ( isset ( $_GET['redir'] ) ) {
// Pour rediriger les users vers salons prives ( Ca na rien a voir avec le ajax mais je vais pas creer un fichier pour trois ligne ^^ )
	$pass = md5 ( htmlspecialchars ( $_GET['pass'] , ENT_QUOTES ) );
	header ( 'Location : index.php?mods=tchat&prive&salon='.htmlspecialchars ( $_GET['salon'] , ENT_QUOTES ).'&pass='.$pass );
	echo '
	<script type="text/javascript">
		window.location.href = "index.php?mods=tchat&prive&salon='.htmlspecialchars ( $_GET['salon'] , ENT_QUOTES ).'&pass='.$pass.'";
	</script>';
}

?>