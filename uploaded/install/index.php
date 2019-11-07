<?php
/*
Copyright CrazyCMS : Valmori Quentin, Feuvre Christophe, Haustrate Kevin.

gay_4_ever@hotmail.fr
chris_tophe2@hotmail.com
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

As a counterpart to the access to the source code and  rights to copy,
modify and redistribute granted by the license, users are provided only
with a limited warranty  and the software's author,  the holder of the
economic rights,  and the successive licensors  have only  limited
liability. 

In this respect, the user's attention is drawn to the risks associated
with loading,  using,  modifying and/or developing or reproducing the
software by the user in light of its specific status of free software,
that may mean  that it is complicated to manipulate,  and  that  also
therefore means  that it is reserved for developers  and  experienced
professionals having in-depth computer knowledge. Users are therefore
encouraged to load and test the software's suitability as regards their
requirements in conditions enabling the security of their systems and/or 
data to be ensured and,  more generally, to use and operate it in the 
same conditions as regards security. 

The fact that you are presently reading this means that you have had
knowledge of the CeCILL² license and that you accept its terms.
*/

$rep = '..';

// Chargement de la langue
if ( isset ( $_POST['langage'] ) ){
	$langue_install = htmlspecialchars($_POST['langage'],ENT_QUOTES);
}
else if ( isset ( $_GET['lang'] ) ){
	$langue_install = htmlspecialchars($_GET['lang'],ENT_QUOTES);
}
else{
	$langue_install = 'francais';
}

if ( isset ( $_GET['secu'] ) ){
	$secu = htmlspecialchars ( $_GET['secu'] );
}

// On défini les variables longues si seuleme,et les courtes sont defini et on defini les variable courtes si seulement les longues sont definis
if(!isset($HTTP_POST_VARS) AND isset($_POST)){
	$HTTP_POST_VARS = $_POST;
    $HTTP_GET_VARS = $_GET;
    $HTTP_SERVER_VARS = $_SERVER;
    $HTTP_COOKIE_VARS = $_COOKIE;
    $HTTP_POST_FILES = $_FILES;
}
else if(isset($HTTP_POST_VARS) AND !isset($_POST)){
    $_POST = $HTTP_POST_VARS;
    $_GET = $HTTP_GET_VARS;
    $_SERVER = $HTTP_SERVER_VARS;
    $_COOKIE = $HTTP_COOKIE_VARS;
    $_FILES = $HTTP_POST_FILES;
}

// Tableau de mise en page
function open_gc( $help_txt = '' )
{
echo '
<table border="0" cellpadding="0" cellspacing="0" width="95%" >
	<tr>
		<td background="../install/images/grand_cadre/gauche1.png">
			<img src="../install/images/grand_cadre/haut_gauche1.png" width="20px">
		</td>
		<td width="100%" style="background-image: url(../install/images/grand_cadre/haut1.png)"></td>
		<td background="../install/images/grand_cadre/droite1.png">
			<img src="../install/images/grand_cadre/haut_droite1.png" width="20px">
		</td>
	</tr>
	<tr align="left" valign="top"> 
		<td background="../install/images/grand_cadre/gauche1.png" ></td>
		<td bgcolor="#FFFFFF" ><div id="help" style="visibility:hidden;height:0px;">
				<table border="0" width="100%" style="border-width:1px; border-color:#E72B00; border-style:solid; background-color:#E9E7E7;">
					<tr>
						<td width="100%">
							<br />
							<center>
							<table border="0" width="90%" style="border-width:1px; border-style:inset; background-color:#F5F5F5; ">
								<tr >
									<td>
										<br />
										&nbsp;&nbsp;'.nl2br ( $help_txt ).'
										<br /><br />
									</td>
								</tr>
							</table>
							<br />
							</center>
						</td>
					</tr>
				</table><br />
			</div>
			<div>
				<a href="http://www.crazycms.com" target="_blank">
					<img src="./images/ccms_logo.png" border="0" hspace="0" align="left" alt="Logo">
				</a>
				';
}
function close_gc()
{
echo '		</div><br />
		</td>
		<td background="../install/images/grand_cadre/droite1.png" ></td>
	</tr>
	<tr>
		<td>
			<img src="../install/images/grand_cadre/bas_gauche1.png">
		</td>
		<td background="../install/images/grand_cadre/bas1.png" width="100%"></td>
		<td>
			<img src="../install/images/grand_cadre/bas_droite1.png">
		</td>
	</tr>
</table>';
}
function open_mc()
{
echo '
<table border="0" width="55%" style="border-width:1px; border-color:#E72B00; border-style:solid; background-color:#E9E7E7;">
	<tr>
		<td width="60%">
			<br />
			<center>
			<table border="0" width="90%" style="border-width:1px; border-style:inset; background-color:#F5F5F5; ">
				<tr >
					<td>
						<div>';
}
function close_mc()
{
echo '
						</div>
					</td>
				</tr>
			</table>
			<br />
			</center>
		</td>
	</tr>
</table>';
}
// On décompose l'install en plusieur partie :

$page = ( (!isset($_GET['page'])) ? ('0') : ( intval ( $_GET['page'] ) ) );

switch ( $page ){

	case 0 :
		$step = 0;
	break;	
	case 1 :
		$step = 0;
	break;	
	case 2 :
		$step = 1;
	break;	
	case 3 :
		$step = 2;
	break;	
	case 4 :
		$step = 3;
	break;	
	case 5 :
		$step = 3;
	break;	
	case 6 :
		$step = 4;
	break;	
	case 7 :
		$step = 4;
	break;	
	case 8 :
		$step = 5;
	break;	
	case 9 :
		$step = 5;
	break;

}

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<style type="text/css">

form input, form textarea{
	border: 1px solid #999;
	-moz-border-radius: 4px;
}
body{
    font-size: 0.8em;
    font-family:Tahoma, sans-serif;
}
h3{
	font-size: 1.2em;
    font-family:Tahoma, sans-serif;
	color : #3366CC;
	margin-left: 5px;
	text-decoration: underline;
}
input[type=text]:focus, textarea:focus{
	border: 1.8px solid;
}
a {
	color:#0000; 
	background:transparent; 
	text-decoration:none;
}
a:link{
	color:#0000; 
	background:transparent; 
	text-decoration:none;
	
}
a:visited{
	color:#0000; 
	background:transparent; 
	text-decoration:none;
}
a:hover{
	color:#0000; 
	background:transparent; 
	text-decoration:none;
}

</style>
<script type="text/javascript">
	<!--
		function redir(url){
			window.location.href = url;
		}
		
		function help ( ){
			if ( document.getElementById ( \'help\' ).style.visibility == "visible" ){
				document.getElementById ( \'help\' ).style.visibility = "hidden";
				document.getElementById ( \'help\' ).style.height = "0px";
			}
			else{
				document.getElementById ( \'help\' ).style.height = "";	
				document.getElementById ( \'help\' ).style.visibility = "visible";				
			}
		}
	-->
</script>
	

</head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Installation de CrazyCMS'.( ( isset ( $_GET['update'] ) ) ? ( '' ) : ( ' | '.$step .' / 5') ).'</title>
<link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
</head>
<body style="margin-top:0">
<center>';

if ( isset ( $_GET['update'] ) ){

	include('../langues/'.$langue_install.'/install.php' );
	
	if ( isset ( $_GET['do'] ) ){
	
		open_gc ( UPDATE_HELP );
		
		open_mc ();
		
		$not_found = FALSE;
		
		if ( $file = @fopen ( '../includes/config.php' , 'r+' ) ){
		
			$conf = '';
			while ( !@feof ( $file ) ){
				$conf .= @fgets ( $file );
			}
			fclose ( $file );
			
			if ( strpos ( $conf , 'Mysql') === FALSE ){
				$already = FALSE;
			}
			else{
				$already = TRUE;
			}
		
		}
		else{
			$already = FALSE;
		}
		
		if ( $already === TRUE ){
		
			include_once ( '../includes/config.php' );
			
			$query = $Bdd->sql ( 'SELECT id FROM '.PT.'_blocs LIMIT 0,1' );
			if ( $Bdd->get_num_rows ( $query ) == 0 ){
				$not_found = TRUE;
			}
			$Bdd->free_result ( $query );
		
			
		}
		else{
		
			$not_found = TRUE;
		
		}

		if ( $not_found ){
		
			echo '<br />'.UPDATE_ERROR_CONFIG.'<br /><br />
			<table border="0" style="width:100%; text-align:center;">
				<tr>
					<td>
						<a href="index.php?page=1&lang='.$langue_install.'">
							<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="'.INSTALL_NEXT_STEP.'" />
							<br />'.STEP_0_5.'
						</a>
					</td>
					<td>
						<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" onclick="help();" src="./images/int.png" alt="?" />
					</td>
				</tr>
			</table>
			<br /><br />';
		
		}
		else{
		
			// O,n verifie que le mise a jour n'a pas encore été effectué 
			$q = $Bdd->sql ( 'SELECT id FROM '.PT.'_parametres WHERE nom = "forum_rules"' );
			if ( $Bdd->get_num_rows ( $q ) == 0 ){
		
			include_once ( '../mods/forum/langues/'.$langue_install.'.php' );
		
			// Ajout de Parametres :
			$Bdd->sql ( 'INSERT INTO '.PT.'_parametres VALUES 
				("", "forum_rules",""),
				(NULL , "new_reply_posted_mail", "'.FORUM_INSTALL_MAIL_REPLY.'"),
				(NULL , "new_topic_posted_mail", "'.FORUM_INSTALL_MAIL_TOPIC.'"),
				(NULL , "portal_version", "1.0RC+3")' );
				
			// Mise à jour des structures des tables
			$Bdd->sql ( 'ALTER TABLE `'.PT.'_blocs` ADD `colonne` VARCHAR( 5 ) NOT NULL ;' );
			$Bdd->sql ( 'UPDATE '.PT.'_blocs SET colonne="left" ' );
			$Bdd->sql ( 'ALTER TABLE `'.PT.'_forum_for` ADD `cat_parent` INT( 11 ) NOT NULL ;' );
			$Bdd->sql ( 'ALTER TABLE `'.PT.'_forum_topic` 
			ADD `lastreply_date` INT( 11 ) NOT NULL ,
			ADD `cat_parent` INT( 11 ) NOT NULL ;' );
				
			// On met a jour tous les forums et sujet en leur assignant leur catégorie parent ;)
			$query = $Bdd->sql ( 'SELECT id FROM '.PT.'_forum_cat' );
			while ( $sql = $Bdd->get_array ( $query ) ){
				$cat = $sql['id'];
				// On recupere les forum directement directement sous la cat
				$query_for = $Bdd->sql ( 'SELECT id FROM '.PT.'_forum_for WHERE parent="'.$cat.'" AND is_sub="0"' );
				$Bdd->sql ( 'UPDATE '.PT.'_forum_for SET cat_parent="'.$cat.'" WHERE parent="'.$cat.'" AND is_sub="0"' );
				while ( $sql_for = $Bdd->get_array ( $query_for ) ){
					// On récupère tous les topics de ce forum
					$Bdd->sql ( 'UPDATE '.PT.'_forum_topic SET cat_parent="'.$cat.'" WHERE parent="'.$sql_for['id'].'"' );
					// On récupère tous les forums enfant et leurs topics ;)
					$boucle = TRUE;
					$parent = array ( $sql_for['id'] );
					while ( $boucle ){
						$ffrm = '(';
						foreach ( $parent AS $pr ){
							$ffrm .= $pr.',';
						}
						$ffrm = substr ( $ffrm , 0 , strlen ( $ffrm ) - 1 );
						$ffrm .= ')';
						$sqq = $Bdd->sql ( 'SELECT id, is_sub FROM '.PT.'_forum_for WHERE parent IN '.$ffrm.' AND is_sub="1"' );
						if ( $Bdd->get_num_rows ( $sqq ) == 0 ){
							$boucle = FALSE;
						}
						else{
							$parent = array();
							while ( $sqqq = $Bdd->get_array ( $sqq ) ){
								$parent[] = $sqqq['id'];
								$Bdd->sql ( 'UPDATE '.PT.'_forum_for SET cat_parent="'.$cat.'" WHERE id="'.$sqqq['id'].'"' );
								$Bdd->sql ( 'UPDATE '.PT.'_forum_topic SET cat_parent="'.$cat.'" WHERE parent="'.$sqqq['id'].'"' );
							}
						}
					}
				}
			}
			
			// On définit comme non installe les modules partenaires et download
			@rename('../mods/partenaires/' , '../mods/partenaires{N-I}/' );
			@rename('../mods/download/' , '../mods/download{N-I}/' );

			// Vidage du Cache
			$dir = opendir ( '../cache/cache/' );
			
			while ( $file = readdir ( $dir ) ){
			
				if ( $file != '..' AND $file != '.' AND is_dir ( '../cache/cache/'.$file.'/' ) ){
				
					$f = opendir ( '../cache/cache/'.$file.'/' );
					while ( $c = readdir ( $f ) ){
						if ( $c != '.' AND $c != '..' )
							@unlink ( '../cache/cache/'.$file.'/'.$c );
					}
					closedir ( $f );
				
				}
			
			}
			closedir ( $dir );
			
			// Vidage du Cache des tpl
			$dir = opendir ( '../cache/templates/' );
			
			while ( $file = readdir ( $dir ) ){	
				if ( $file != '..' AND $file != '.' ){
					@unlink ( '../cache/templates/'.$file );
				}
			}
			closedir ( $dir );
		
			echo '<br />
			'.UPDATE_SUCCESFULLY_DONE.'
				<br /><br />
				<a href="../index.php">
					'.BACK_TO_WEBSITE.'
				</a><br /><br />';
				unlink( './index.php' );
		
			}
			else{
			
				echo '<br />
				'.UPDATE_ALREADY_DONE.'
				<br /><br />
				<a href="../index.php">
					'.BACK_TO_WEBSITE.'
				</a><br /><br />';
			
			}
			$Bdd->free_result ( $q );
		
		}
		
		close_mc ();
	
	}
	else{
	
		$last_version = 'RC+2';
		$new_version = 'RC+3' ;

		
		open_gc ( '' );
		
		open_mc ();
		
		echo '<br />'.nl2br ( str_replace ( '{LAST_VERSION}' , $last_version , str_replace ( '{NEW_VERSION}' , $new_version , WELCOME_UPDATE ) ) ).'<br /><br />
		<table border="0" style="width:100%; text-align:center;">
					<tr>
						<td>
							<a href="index.php?page=1&lang='.$langue_install.'">
								<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="'.INSTALL_NEXT_STEP.'" />
								<br />'.STEP_0_5.'
							</a>
						</td>
						<td>
							<a href="index.php?update&lang='.$langue_install.'&do">
								<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'" />
								<br />'.DO_UPDATE.'
							</a>
						</td>
					</tr>
		</table>';
		
		close_mc ();
	
	}
}
else if ( !isset ( $_GET ['page'] ) ){
open_gc();
open_mc();
echo '
<form method="post" action="index.php?page=1">
<h3>Choisissez votre langue / Choose your language : ( 0 / 5 )</h3>
<br /><br />
<center>
	<select name="langage">';
	
	$handle = opendir('../langues/' ); 
		while (($file = readdir($handle))!=false) { 
				
			if($file!=".." AND $file!="." AND is_dir('../langues/'.$file) AND file_exists('../langues/'.$file.'/install.php'))
			{
				echo '<option value="'.$file.'"';
				if($file=='francais')echo ' selected="selected"';
				echo '>'.ucfirst($file).'</option>';
			}
		}
	closedir($handle); 	
	
echo '	
	</select>
</center>
	
	<input align="right" type="image" src="./images/af.png" />
	<br />
	
</form>';
close_mc();
}
else if ( $_GET ['page'] ==1 ){

include('../langues/'.$langue_install.'/install.php' );
open_gc( STEP_1_HELP );
// Explication des differentes etapes et informations
open_mc();

echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;'.nl2br ( INSTALL_DEF ).'
<br /><br /><hr />
<table border="0" style="width:100%; text-align:center;">
	<tr>
		<td>
			<a href="index.php">
				<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt=""/>
				<br />'.STEP_0.'
			</a>
		</td>
		<td>
			<img onclick="help();" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/int.png" alt="?" />
		</td>
		<td>
			<table border="0" style="width:100%; text-align:center;">
				<tr>
					<td>
						<a href="index.php?page=2&lang='.$langue_install.'">
							<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'" />
							<br />'.STEP_1.'<br /><br />
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href="index.php?update&lang='.$langue_install.'">
							<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'" />
							<br />'.GO_TO_UPDATE.'
						</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
close_mc();
}
else if ( $_GET ['page'] ==2 ){
include('../langues/'.$langue_install.'/install.php' );
open_gc( STEP_2_HELP );
// Acceptation de la licence
open_mc();
echo '<h3>'.STEP_1.' ( 1 / 5 ) </h3>&nbsp;&nbsp;'.ACCEPT_LICENSE.' :<br />
<br />
<form method="post" action="index.php?page=3&lang='.$langue_install.'">
<table>
	<tr>
		<td>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="licence" value="1" />
		</td>
		<td>
			'.ACCEPT_TERMS.'
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="licence" value="0" checked="checked" />
		</td>
		<td>
			'.REFFUSE_TERMS.'
		</td>
	</tr>
</table>
<hr />
<table border="0" style="width:100%; text-align:center;">
	<tr>
		<td>
			<a href="index.php?page=1&lang='.$langue_install.'">
				<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
			</a>
		</td>
		<td>
			<img src="./images/int.png" onclick="help();" alt="?" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
		</td>
		<td>
			<input style="border-color : #D3D3D3;" type="image" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'"/>
			<br />'.STEP_2.'
		</td>
	</tr>
</table>
</form>';
close_mc();
echo' <br /><br /><br /><br />
<iframe width="100%" 
src="http://www.cecill.fr/licences/Licence_CeCILL_V2-fr.html"
height="400"
width="700">
</iframe>

';
}
else if ( $_GET ['page'] ==3 ){
	include('../langues/'.$langue_install.'/install.php' );
	open_gc( STEP_3_HELP );
	// Verification de la compatibilite du serveur
	if( ( isset($_POST['licence']) AND $_POST['licence']==1 ) OR ( isset ( $_GET['licence'] ) AND $_GET['licence'] == true ) ){

	$continue = true;

	open_mc();
	echo '<h3>'.STEP_2.' ( 2 / 5 )</h3>
	<fieldset>
		<legend><b>'.INSTALL_MAIN_FUNCTIONS.'</b></legend>
	<table width="100%" border="0" cellpading="0" cellspacing="0">
		<tr bgcolor="#E5E5E5">
			<td>'.INSTALL_PHP_VERSION.' : </td><td>';
	//Verification de la compatibilite du serveur : 
		if(phpversion() > 4.2){
			echo '<font color="green">'.INSTALL_COMPATIBLE.'</font></td><td align="left"><img src="../install/images/yes.png"></td></tr>';
		}
		else{
			echo '<font color="red">'.INSTALL_INCOMPATIBLE.'</font></td><td align="left"><img src="../install/images/no.png"></td></tr>';
			$continue = false;
		}
		
	echo '<tr bgcolor="#F1F1F1"><td>'.INSTALL_SQL_BASE.' : </td><td>';
	//Verification de la compatibilite du serveur : 
		if(function_exists("mysql_connect")){
			echo '<font color="green">'.INSTALL_ACTIVATED.'</font></td><td align="left"><img src="../install/images/yes.png"></td></tr>';
		}
		else{
			echo '<font color="red">'.INSTALL_UNACTIVATED.'</font></td><td align="left"><img src="../install/images/no.png"></td></tr>';
			$continue = false;
		}

	echo '<tr bgcolor="#E5E5E5"><td>'.INSTALL_FILE_UPLOAD.' : </td><td>';
	//Verification de la compatibilite du serveur : 
		if(ini_get("file_uploads")){
			echo '<font color="green">'.INSTALL_ACTIVATED.'</font></td><td align="left"><img src="../install/images/yes.png"></td></tr>';
			$up = true;
		}
		else{
			echo '<font color="red">'.INSTALL_UNACTIVATED.'</font></td><td align="left"><img src="../install/images/no.png"></td></tr>';
			$up = false;
		}

	echo '<tr bgcolor="#F1F1F1"><td>'.INSTALL_GD_LIBRARY.' : </td><td>';
	//Verification de la compatibilite du serveur : 
		if(extension_loaded('gd')){
			echo '<font color="green">'.INSTALL_ACTIVATED.'</font></td><td align="left"><img src="../install/images/yes.png"></td></tr>';
			$gd = true;
		}
		else{
			echo '<font color="red">'.INSTALL_UNACTIVATED.'</font></td><td align="left"><img src="../install/images/no.png"></td></tr>';
			$gd = false;
		}

	echo '	</table>
	</fieldset>
	<fieldset>
		<legend><b>'.INSTALL_CHMOD_777.'</b></legend>
	<table width="100%" border="0" cellpading="0" cellspacing="0">';
		// Fonction qui verifie si un fichier a un chmod suffisant
		function is_chmode($file,$chmod_req){
			$chmod = substr(sprintf('%o', @fileperms($file)), -3);
			
			$req1 = substr($chmod_req,0,1);
			$req2 = substr($chmod_req,1,1);
			$req3 = substr($chmod_req,2,2);
			
			$re1 = substr($chmod,0,1);
			$re2 = substr($chmod,1,1);
			$re3 = substr($chmod,2,2);
			
			if($req1<=$re1 AND $req2<=$re2 AND $req3<=$re3){
				return true;
			}
			else{
				return false;
			}
		}

	// Verification des chmods
	$chmod_c = true;
	$c = 0;

	$chmod = array (
		array ( 'chmod' => 644, 'file' => './install/index.php', 'chemin' => './index.php' ),
		array ( 'chmod' => 644, 'file' => './includes/config.php', 'chemin' => '../includes/config.php' ),
		array ( 'chmod' => 644, 'file' => './mods/upload/upload.php', 'chemin' => '../mods/upload/upload.php' ),
		array ( 'chmod' => 644, 'file' => './includes/class.mysql.php', 'chemin' => '../includes/class.mysql.php' ),
		array ( 'chmod' => 644, 'file' => './mods/tchat/admin.php', 'chemin' => '../mods/tchat/admin.php' ),
		array ( 'chmod' => 644, 'file' => './mods/tchat/ajax.php', 'chemin' => '../mods/tchat/ajax.php' ),
		array ( 'chmod' => 644, 'file' => './mods/admin/modules.php', 'chemin' => '../mods/admin/modules.php' ),
		array ( 'chmod' => 644, 'file' => './mods/free_page/admin.php', 'chemin' => '../mods/free_page/admin.php' ),
		array ( 'chmod' => 700, 'file' => './cache/cache/', 'chemin' => '../cache/cache/' ),
		array ( 'chmod' => 700, 'file' => './avatars/', 'chemin' => '../avatars/' ),
		array ( 'chmod' => 700, 'file' => './cache/templates/', 'chemin' => '../cache/templates/' ),
	);

	foreach ( $chmod as $id => $arr ){
		++$c;
		
			echo '<tr bgcolor="'.( ( $c%2 ) ? ('#E5E5E5') : ('#F1F1F1') ).'"><td>['.$arr['chmod'].'] '.$arr['file'].' : </td><td>';
			if(is_chmode( $arr['chemin'] , $arr['chmod'] )){
				echo '<font color="green">'.INSTALL_YES.'</font></td><td align="left"><img src="../install/images/yes.png"></td></tr>';
			}
			else{
				echo '<font color="red">'.INSTALL_NO.'</font></td><td align="left"><img src="../install/images/no.png"></td></tr>';
				$continue = false;
				$chmod_c = false;
			}
		
	}
		
		if($chmod_c===false){
		
			echo '</table></fieldset><br /><fieldset><label>'.CHMOD_ERROR.'</label>
		
			<br />'.CHMOD_ERROR_STOP.'
		
			<br /></fieldset>';
			close_mc();
		
		}
		else{
			
			echo '</table></fieldset>';

			if($continue===true){
				echo '
				<br /><br />
				<table border="0" style="width:100%; text-align:center;">'.( ( $gd === true ) ? ('') : ( nl2br ( GD_DISABLED ).'<br /><br />' ) ).( ( $up === true ) ? ('') : ( nl2br ( UP_DISABLED ).'<br /><br />' ) ).'
					<tr>
						<td>
							<a href="index.php?page=2&lang='.$langue_install.'">
								<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
								<br />'.STEP_1.'
							</a>
						</td>
						<td>
							<img onclick="help();" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/int.png" alt="?" />
						</td>
						<td>
							<a href="index.php?page=4&lang='.$langue_install.'">
								<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'" />
								<br />'.STEP_3.'
							</a>
						</td>
					</tr>
				</table>';
			}
			else{
				echo '
				<br />
				<center>
					<table cellspacing="0" style="border-width:1px; border-style:dashed;">
						<tr>
							<td align="center" >
								<strong>
									&nbsp;'.nl2br ( INSTALL_CANT_INSTALL ).'&nbsp;<img alt="!" src="./images/!.png" />&nbsp;
									<br /><br />
								</strong>
							</td>
						</tr>
					</table>
				</center>';
			}
		
			close_mc();
			
		}
	}
	else{
	open_mc();
	echo '<br />&nbsp;&nbsp;'.MUST_ACCEPT_LICENSE.'
	<br /><br /><hr />
	<table border="0" style="width:100%; text-align:center;">
		<tr>
			<td>
				<a href="index.php?page=2&lang='.$langue_install.'">
					<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
					<br />'.STEP_1.'
				</a>
			</td>
		</tr>
	</table>';
	close_mc();
	}
}
else if ( $_GET ['page'] ==4 ){
include('../langues/'.$langue_install.'/install.php' );
open_gc( STEP_4_HELP );
// Recuperation de la configuration du site
open_mc();
echo '<h3>'.STEP_3.' ( 3 / 5 )</h3>
<fieldset><legend>'.INSTALL_SQL_CONNECTION.'</legend>
<form method="post" action="index.php?page=5&lang='.$langue_install.'">
<table>
	<tr>
		<td>
			'.INSTALL_SQL_SERVER_NAME.'
		</td>
		<td>
			<input type="text" name="sql_serveur" />
		</td>
	</tr>
	<tr>
		<td>
			'.INSTALL_SQL_USER_NAME.'
		</td>
		<td>
			<input type="text" name="sql_user" />
		</td>
	</tr>
	<tr>
		<td>
			'.INSTALL_SQL_USER_PASS.'
		</td>
		<td>
			<script type="text/javascript">
				function show_pwd(){
					if ( document.getElementById(\'pwd_check\').checked == true ){
				
						 document.getElementById(\'pwd\').type = "text";
					}
					else{
						document.getElementById(\'pwd\').type = "password";
					}
				}
			</script>
			<input type="password" id="pwd" name="sql_pass" />
			<br /><input type="checkbox" id="pwd_check" onclick="show_pwd();" onload="this.checked=\'false\';" name="show_pass" /> - '.SHOW_PASSWORD.'
		</td>
	</tr>
	<tr>
		<td>
			'.INSTALL_SQL_BASE_NAME.'
		</td>
		<td>
			<input type="text" name="sql_db" />
		</td>
	</tr>
	<tr>
		<td>
			'.INSTALL_SQL_TABLE_PREFIXE.'
		</td>
		<td>
			<input type="text" name="sql_pref" />
		</td>
	</tr>
</table><br />
<hr />
<table border="0" style="width:100%; text-align:center;">
	<tr>
		<td>
			<a href="index.php?page=3&lang='.$langue_install.'&amp;licence=true">
				<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
				<br />'.STEP_2.'
			</a>
		</td>
		<td>
			<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" onclick="help();" src="./images/int.png" alt="?" />
		</td>
		<td>
			<input style="border-color:#D3D3D3;" type="image" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'" />
			<br />'.STEP_4.'
		</td>
	</tr>
</table>
</form>';
close_mc();
}
else if ( $_GET ['page'] ==5 ){
include('../langues/'.$langue_install.'/install.php' );
open_gc( STEP_5_HELP );
// Création du fichier de configuration du site

$serv = ( ( isset ( $_POST['sql_serveur'] ) ) ? ( htmlspecialchars($_POST['sql_serveur'],ENT_QUOTES) ) : ('') );
$user = ( ( isset ( $_POST['sql_user'] ) ) ? ( htmlspecialchars($_POST['sql_user'],ENT_QUOTES) ) : ('') );
$pass = ( ( isset ( $_POST['sql_pass'] ) ) ? ( htmlspecialchars($_POST['sql_pass'],ENT_QUOTES) ) : ('') );
$db = ( ( isset ( $_POST['sql_db'] ) ) ? ( htmlspecialchars($_POST['sql_db'],ENT_QUOTES) ) : ('') );
$pref = ( ( isset ( $_POST['sql_pref'] ) ) ? ( preg_replace ( '#[^a-zA-Z0-9_]#', '' , $_POST['sql_pref'] ) ) : ('') );

//On génére une clé de cryptage aleaoire reserve a ce site ;)
$minuscules = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );

    $majuscules = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );

    $code = ''; 
	
        for ($i = 1; $i <= 12 ; $i++)
        {
  
        $type = rand(0,2);

            switch ($type)
            {
                case 0:
                     $caractere = rand(2,9);
                                 $code .= $caractere;
                break;
                
                case 1:
                     $nbre_aleatoire = rand(0, 23);
                                 $caractere = $majuscules[$nbre_aleatoire];
                                 $code .= $caractere;
                break;
                
                case 2:
                     $nbre_aleatoire = rand(0, 22);
                                 $caractere = $minuscules[$nbre_aleatoire];
                                 $code .= $caractere;
                break;
            }
        }
		// On recupere le code, si il a deja ete mis ;)
		if ( $file = @fopen('../includes/config.php' , 'r+' ) ){
		
			$cont = '';
			while ( !@feof ( $file ) ){
				$cont .= htmlspecialchars ( @fgets ( $file , 4096) );
			}
			@fclose ( $file );
			
			if ( ereg ( '\$crypt_key = ' , $cont ) ){
				$cod = preg_replace ( '!^.+\$crypt_key = \'(.+)\'.+$!isU' , '$1' , $cont );
				$code = $cod;
			}
		}

if($pref=='')$pref='ccms';

	if(!@mysql_connect($serv,$user,$pass)){
		open_mc();
			echo '<br />&nbsp;&nbsp;&nbsp;<b>'.INSTALL_COULDNT_CONNECT_SQL_SERVER.'</b>&nbsp;<img src="./images/!.png" /> <br /><br /><hr />
			<table border="0" style="width:100%; text-align:center;">
				<tr>
					<td>
						<a href="index.php?page=4&lang='.$langue_install.'">
							<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
							<br />'.STEP_3.'
						</a>
					</td>
				</tr>
			</table>';
		close_mc();
	}
	else{
	
		if(!mysql_select_db($db)){
		open_mc();
			echo INSTALL_COULDNT_SELECT_SQL_BASE.' <br /><br />
			<table border="0" style="width:100%; text-align:center;">
				<tr>
					<td>
						<a href="index.php?page=4&lang='.$langue_install.'">
							<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
							<br />'.STEP_3.'
						</a>
					</td>
				</tr>
			</table>';
		close_mc();
		}
		else{
			// On verifie que la base n'existe pas
			mysql_connect($serv,$user,$pass);
			mysql_select_db($db);
			if ( $query = mysql_query ( 'SELECT id FROM '.$pref.'_blocs LIMIT 0,1' ) ){
				$tot = mysql_num_rows ( $query );
			}
			else{
				$tot = 0;
			}
			if ( $tot == 0 ) {
			
			
				if ( $file = @fopen('../includes/config.php' , 'w+' ) ){
					@fputs($file,'<?php
require(str_replace(\'config.php\',\'\',__FILE__).\'class.mysql.php\' );

$Bdd = new Mysql("'.$serv.'","'.$user.'","'.$pass.'","'.$db.'");

define(\'PT\',\''.$pref.'\' );

$crypt_key = \''.$code.'\';

$god_user = \'1, 2\';
?>' );
					@fclose($file);
					open_mc();
					echo '<br />'.CONFIG_FILE_SUCCESSFULLY_CREATED.'<br /><br />
					<table border="0" style="width:100%; text-align:center;">
						<tr>
							<td>
								<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/int.png" onclick="help();" alt="?" />
							</td>
							<td>
								<a href="index.php?page=6&lang='.$langue_install.'&secu='.md5( $code ).'">
									<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'" />
									<br />'.STEP_4.'
								</a>
							</td>
						</tr>
					</table>';
					close_mc();
				}
				else{
					open_mc();
					echo CHMOD_ERROR.'<br /><br />
					<table border="0" style="width:100%; text-align:center;">
						<tr>
							<td>
								<a href="index.php?page=4&lang='.$langue_install.'">
									<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
									<br />'.STEP_3.'
								</a>
							</td>
						</tr>
					</table>';	
					close_mc();
				}
			}
			else{
				open_mc();
				echo nl2br ( BASE_ALREADY_EXISTS ).'<br /><br />
				<table border="0" style="width:100%; text-align:center;">
					<tr>
						<td>
							<table border="0" style="width:100%; text-align:center;">
								<tr>
									<td style="width:50%;">
										<a href="index.php?page=4&lang='.$langue_install.'">
											<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
											<br />'.STEP_3.'
										</a>
									</td>
								</tr>
							</table>
						</td>
						<td rowspan="2" style="width:50%;">
							<table border="0" style="width:100%; text-align:center;">
								<tr>								
									<td style="width:50%;">
										<a href="index.php?page=5.5&lang='.$langue_install.'&code='.base64_encode ( $code ).'&serv='.base64_encode ( $serv ).'&user='.base64_encode ( $user ).'&pass='.base64_encode ( $pass ).'&db='.base64_encode ( $db ).'&pref='.base64_encode ( $pref ).'">
											<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/af.png" alt="" />
											<br />'.nl2br ( FORCE_INSTALLATION ).'
										</a>
									</td>
								</tr>
							</table>	
						</td>
					</tr>
					<tr>
						<td>
							<table border="0" style="width:100%; text-align:center;">
								<tr>
									<td style="width:50%;">
										<a href="index.php?update&lang='.$langue_install.'">
											<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
											<br />'.GO_TO_UPDATE_SCRIPT.'
										</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

					<br /><br />';
				close_mc();
			
			}
		}
	}
}
else if ( $_GET ['page'] == 5.5 ){

	include('../langues/'.$langue_install.'/install.php' );
	open_gc( STEP_5_HELP );

	if ( $file = @fopen('../includes/config.php' , 'w+' ) ){
		@fputs($file,'<?php
	require(str_replace(\'config.php\',\'\',__FILE__).\'class.mysql.php\' );

	$Bdd = new Mysql("'.base64_decode ( $_GET['serv'] ).'","'.base64_decode ( $_GET['user'] ).'","'.base64_decode ( $_GET['pass'] ).'","'.base64_decode ( $_GET['db'] ).'");

	define(\'PT\',\''.base64_decode ( $_GET['pref'] ).'\' );

	$crypt_key = \''.base64_decode ( $_GET['code'] ).'\';

	$god_user = \'1, 2\';
	?>' );
		@fclose($file);
		open_mc();
		echo '<br />'.CONFIG_FILE_SUCCESSFULLY_CREATED.'<br /><br />
		<table border="0" style="width:100%; text-align:center;">
			<tr>
				<td>
					<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/int.png" onclick="help();" alt="?" />
				</td>
				<td>
					<a href="index.php?page=6&lang='.$langue_install.'&secu='.md5( base64_decode ( $_GET['code'] ) ).'">
						<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'" />
						<br />'.STEP_4.'
					</a>
				</td>
			</tr>
		</table>';
		close_mc();
	}
	else{
		open_mc();
		echo CHMOD_ERROR.'<br /><br />
		<table border="0" style="width:100%; text-align:center;">
			<tr>
				<td>
					<a href="index.php?page=4&lang='.$langue_install.'">
						<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
						<br />'.STEP_3.'
					</a>
				</td>
			</tr>
		</table>';	
		close_mc();
	}
}
else if ( $_GET ['page'] ==6 ){
	include('../includes/config.php' );
	include('../langues/'.$langue_install.'/install.php' );
	if ( isset ( $_GET['secu'] ) AND $_GET['secu'] == md5 ( $crypt_key ) ){
		open_gc( STEP_6_HELP );
		// Installation des modules
		open_mc();
		echo '<h3>'.STEP_4.' ( 4 / 5 )</h3><form method="post" action="index.php?page=7&lang='.$langue_install.'&secu='.$secu.'">
	<fieldset><legend><b>'.INSTALL_SITE_CONFIG.'</b></legend>
	<script type="text/javascript">
		<!--
	//	http://127.0.0.1/www42/install/index.php?page=6&lang=fran
			function get_url(){
				var reg=new RegExp("(.+)(/|\)install(/|\)index.php(.+)", "g");
				document.getElementById(\'siteurl\').value = window.location.href.replace ( reg , "$1$2" );
				document.getElementById(\'sitename\').value = window.location.host;
			}
			setTimeout ( "get_url()" , 1000 );
		-->
	</script>
	<table style="width:100%; border-width:0px;">
		<tr>
			<td width="40%">
				'.INSTALL_SITE_NAME.'
			</td>
			<td>
				<input id="sitename" type="text" size="40" name="sitename" />
		</tr>
		<tr>
			<td width="40%">
				'.INSTALL_SITE_URL.'
			</td>
			<td>
				<input id="siteurl" size="40" type="text" name="siteurl" value=""/>
		</tr>
		<tr>
			<td>
				'.INSTALL_HOUR_FUSEAUX.'
			</td>
			<td>
				<select name="fusodef">
					<option value="-12">GMT -12</option>
					<option value="-11">GMT -11</option>
					<option value="-10">GMT -10</option>
					<option value="-9">GMT -9</option>
					<option value="-8">GMT -8</option>
					<option value="-7">GMT -7</option>
					<option value="-6">GMT -6</option>
					<option value="-5">GMT -5</option>
					<option value="-4">GMT -4</option>
					<option value="-3">GMT -3</option>
					<option value="-2">GMT -2</option>
					<option value="-1">GMT -1</option>
					<option value="0">GMT</option>
					<option value="1" selected="selected">GMT +1</option>
					<option value="2">GMT +2</option>
					<option value="3">GMT +3</option>
					<option value="4">GMT +4</option>
					<option value="5">GMT +5</option>
					<option value="6">GMT +6</option>
					<option value="7">GMT +7</option>
					<option value="8">GMT +8</option>
					<option value="9">GMT +9</option>
					<option value="10">GMT +10</option>
					<option value="11">GMT +11</option>
					<option value="12">GMT +12</option>
					<option value="13">GMT +13</option>
				</select>
				&nbsp;'.INSTALL_SUMMER_HOUR.'
					<input type="checkbox" name="correction" value="1" />
			</td>
		</tr>
		</table></fieldset>
		
	<fieldset><legend><b>'.INSTALL_MODS_TO_INSTALL.'</b></legend>
	<table style="width:100%;" border="0">
		<tr bgcolor="#E6E6E6">
			<td width="40%">
				<input type="checkbox" name="gen" checked="true" disabled="true"/>
			</td>
			<td>
				'.INSTALL_PORTAL.'<br /><i>'.INSTALL_USERS_STATS.'</i>
			</td>
		</tr>';

	//On lit le dossier mods pour recuperer tous les modules contenant un install.php
		$a =1;
		$handle = opendir('../mods/' ); 
			while (($file = readdir($handle))!=false) { 
					
				if($file!=".." AND $file!="." AND is_dir('../mods/'.$file) AND file_exists('../mods/'.$file.'/install.php'))
				{
					
					$filen = str_replace ( '{N-I}' , '' , $file );
					@rename('../mods/'.$file.'/' , '../mods/'.$filen.'/' );
					$file = $filen;
					
					$a ++;
					include('../mods/'.$file.'/install_def.php' );
					echo '
					<tr bgcolor="'.( ($a%2) ? ('#E6E6E6') : ('') ).'">
						<td>
							<input type="checkbox" checked="true" name="'.$file.'" value="1"/>
						</td>
						<td>
							'.${'mod_name_'.$langue_install}.'<br />
							<i>'.${'mod_def_'.$langue_install}.'</i>
						</td>
					</tr>';
					unset ( ${'mod_name_'.$langue_install} , ${'mod_def_'.$langue_install} );
				}
			}
		closedir($handle); 	

		echo '</td></tr></table></fieldset>
		<br />
		<table border="0" style="width:100%; text-align:center;">
			<tr>
				<td>
					<a href="index.php?page=5&lang='.$langue_install.'&secu='.$secu.'">
						<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
						<br />'.STEP_3.'
					</a>
				</td>
				<td>
					<img src="./images/int.png" alt="?" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" onclick="help();"/>
				</td>
				<td>
					<input style="border-color : #D3D3D3;" type="image" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'"/>
					<br />'.STEP_4.'
				</td>
			</tr>
		</table></form>';
		close_mc();
	}
	else{
		open_gc( '' );
		open_mc();
		echo ALERT_SECURITY ;
		close_mc();
	}
}
else if ( $_GET ['page'] ==7 ){

	if(!isset($_POST['siteurl'])){
		echo '
		<script type="text/javascript">
			window.location.href= "index.php?page=6&lang='.$langue_install.'&secu='.$secu.'";
		</script>';
	}
	
	//Inclusion de la configuration prealablement configure 
	include('../includes/config.php' );
	include('../langues/'.$langue_install.'/install.php' );
	if ( isset ( $_GET['secu'] ) AND $_GET['secu'] == md5 ( $crypt_key ) ){

		include('../langues/'.$langue_install.'/lang.php' );

		open_gc( STEP_7_HELP );

		//creation des modules

		// Création des Tables du portail ( Obligatoires pour le fonctionnement general );

		// Creation de la table des bloc
		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_blocs(
		  id tinyint(3) unsigned NOT NULL auto_increment,
		  bloc varchar(25) NOT NULL,
		  tbloc varchar(100) NOT NULL,
		  afficher char(1) NOT NULL,
		  position tinyint(3) unsigned NOT NULL default "0",
		  colonne varchar(5) NOT NULL default "left",
		  PRIMARY KEY  (id)
		) ENGINE=InnoDB' );

		$Bdd->sql ( 'TRUNCATE TABLE '.PT.'_blocs ' );
		$Bdd->sql ( 'INSERT INTO '.PT.'_blocs VALUES ("", "menu", "Menu", 1, 0 ,"left")' );
		$Bdd->sql ( 'INSERT INTO '.PT.'_blocs VALUES ("", "espace_membre", "Espace Membre", 1, 1,"left")' );
		// Fin de creation de table des blocs


		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_groupe (
		  id smallint(5) unsigned NOT NULL auto_increment,
		  nom varchar(255) NOT NULL default "",
		  description text NOT NULL,
		  date int(11) NOT NULL default "0",
		  id_createur int(11) NOT NULL default "0",
		  afficher int(1) NOT NULL default "0",
		  public int(1) NOT NULL default "0",
		  nb_users mediumint(4) NOT NULL default "0",
		  PRIMARY KEY  (id)
		) ' );

		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_page (
		  id smallint(5) unsigned NOT NULL auto_increment,
		  titre text NOT NULL,
		  contenu text NOT NULL,
		  PRIMARY KEY  (id)
		)' );

		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_copy (
		  id smallint(5) unsigned NOT NULL auto_increment,
		  question text NOT NULL,
		  sujet text NOT NULL,
		  PRIMARY KEY  (id)
		)' );

		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_mbr_groupe (
		  id smallint(5) unsigned NOT NULL auto_increment,
		  id_membre int(11) NOT NULL default "0",
		  groupe int(11) NOT NULL default "0",
		  niveau int(1) NOT NULL default "0",
		  PRIMARY KEY  (id)
		)   ' );
		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_messagerie (
		  id smallint(5) unsigned NOT NULL auto_increment,
		  destinataire varchar(50) NOT NULL default "",
		  auteur varchar(50) NOT NULL default "",
		  titre text NOT NULL,
		  contenu text NOT NULL,
		  date int(11) NOT NULL default "0",
		  vu varchar(11) NOT NULL default "",
		  PRIMARY KEY  (id)
		) ' );
		$Bdd->sql ('CREATE TABLE IF NOT EXISTS '.PT.'_grades (
		id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		nbr SMALLINT ( 3 ) NOT NULL ,
		name VARCHAR( 30 ) NOT NULL ,
		permissions TEXT NOT NULL
		)');
		$Bdd->sql('TRUNCATE TABLE '.PT.'_grades ' );

		$Bdd->sql ( 'INSERT INTO '.PT.'_grades VALUES ( "" , "0" , "Invité", "view_forum;view_forum_for;view_forum_topic;view_gallery;view_comment_photo;view_chat;")' );
		$Bdd->sql ( 'INSERT INTO '.PT.'_grades VALUES ( "" , "1" , "Membre", " 	view_chat;post_chat;poster_comment;comment_photo;view_gallery;view_comment_photo;gallery_vote;view_forum;view_forum_for;view_forum_topic;post_reply;post_topic;edit_our_topics;delete_our_topics;edit_our_replys;delete_our_replys;")' );
		$Bdd->sql ( 'INSERT INTO '.PT.'_grades VALUES ( "" ,  "2" , "VIP", "view_chat;post_chat;poster_comment;comment_photo;view_gallery;view_comment_photo;gallery_vote;view_forum;view_forum_for;view_forum_topic;post_reply;post_topic;edit_our_topics;delete_our_topics;edit_our_replys;delete_our_replys;attach_topic;")' );
		$Bdd->sql ( 'INSERT INTO '.PT.'_grades VALUES ( "" , "3" , "Modérateur", "view_admin;view_admin_gene;view_chat;post_chat;poster_comment;comment_photo;view_gallery;view_comment_photo;gallery_vote;view_forum;view_forum_for;view_forum_topic;post_reply;post_topic;edit_all_topics;delete_all_topics;edit_our_topics;delete_our_topics;edit_all_replys;delete_all_replys;edit_our_replys;delete_our_replys;move_topic;lock_topic;attach_topic;")' );
		$Bdd->sql ( 'INSERT INTO '.PT.'_grades VALUES ( "" , "4" , "Administrateur", "")' );

		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_users(
		  id smallint(5) unsigned NOT NULL auto_increment,
		  pseudo varchar(255) NOT NULL default "",
		  pass varchar(255) NOT NULL default "",
		  email varchar(255) NOT NULL default "",
		  permission text NOT NULL,
		  groupe text NOT NULL,
		  nom varchar(255) NOT NULL default "",
		  signature text NOT NULL,
		  theme varchar(255) NOT NULL default "",
		  langue varchar(255) NOT NULL default "",
		  icq varchar(255) NOT NULL default "",
		  msn varchar(255) NOT NULL default "",
		  yahoom varchar(255) NOT NULL default "",
		  aim varchar(255) NOT NULL default "",
		  site varchar(255) NOT NULL default "",
		  localisation varchar(255) NOT NULL default "",
		  sexe varchar(10) NOT NULL default "",
		  date_naissance int(11) NOT NULL default "0",
		  date_inscription int(11) NOT NULL default "0",
		  grades int(11) NOT NULL default "1",
		  fuseaux char(5) NOT NULL default "",
		  lunonlu text NOT NULL,
		  abonnements text NOT NULL,
		  nb_post mediumint(5) NOT NULL default "0",
		  last_ip varchar(15) NOT NULL default "",
		  user_title varchar(30) NOT NULL default "",
		  privacy varchar(100) NOT NULL default "",
		  avatar varchar(255) NOT NULL default "",
		  reputation text NOT NULL,
		  avertissements smallint(3) NOT NULL default "0",
		  last_activity_date int(11) NOT NULL default "0",
		  last_mess_date int(11) NOT NULL default "0",
		  other_field text NOT NULL,
		  format_date varchar (50) NOT NULL default"",
		  appear_offline smallint ( 1 ) NOT NULL default "0",
		  PRIMARY KEY  (id),
		  KEY id (id)
		)' );

		$Bdd->sql('INSERT INTO '.PT.'_users ( id , pseudo , pass , date_inscription , grades , fuseaux , lunonlu , abonnements )
		VALUES ("", "'.GUEST.'", "fgdfgs1df35sg4df3xcg24f", "'.time().'", "0", "", "", "")' );

		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_note (
		  id smallint(5) unsigned NOT NULL auto_increment,
		  title varchar(100) NOT NULL,
		  contenu varchar(250) NOT NULL,
		  auteur varchar(25) NOT NULL ,
		  PRIMARY KEY  (id)
		)' );

		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_alerte (
			id smallint(5) unsigned NOT NULL auto_increment,
			auteur varchar(255) NOT NULL,
			`mod` varchar(50) NOT NULL,
			date int(11) NOT NULL,
			message text NOT NULL,
			PRIMARY KEY (id)
		)' );

		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_permissions (
		  id smallint(5) unsigned NOT NULL auto_increment,
		  name varchar(255) NOT NULL default "",
		  description text NOT NULL,
		  element varchar(50) NOT NULL default "",
		  type varchar(50) NOT NULL default "",
		  PRIMARY KEY  (id)
		)' );
		$Bdd->sql('TRUNCATE TABLE '.PT.'_permissions ' );

		// Creation de la table des parametres
		$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_parametres (
		  id smallint(5) unsigned NOT NULL auto_increment,
		  nom varchar(255) NOT NULL default "",
		  valeur text NOT NULL default "",
		   PRIMARY KEY  (id)
		  ) ' );
		$Bdd->sql('TRUNCATE TABLE '.PT.'_parametres ' );
		
		$fuso = htmlspecialchars ( $_POST['fusodef'] ).';'.( ( isset ( $_POST['correction'] ) ) ? ('1') : ('0') );

		// Insertion des parametres
		$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "portal_version","1.0RC+3"),("", "free_bloc_grade_admin","4,"), ("", "free_page_grade_admin","4,"), ("", "copyright_grade_admin","4,"), ("", "default_theme_locked","0"), ("", "use_wysiwyg","1"), ("", "groupes_grade_admin","4,"), ("", "default_format_date","d/m/y : 24:"), ("", "menu_grade_admin","4,"), ("", "logo", ""), ("", "symb1", ";black"), ("", "symb2", ";vert"), ("", "symb3", ";orange"), ("", "symb4", ";red"), ("", "maintenance_mod", "0"), ("", "be_log", "0"), ("", "mod_acc", "news"), ("", "users_valid", "0"), ("", "crypt_key", "'.$crypt_key.'"), ("", "titre_edito", "Welcome"), ("", "copyright", "Copyright CrazyCMS"), ("", "edito", "Bienvenue sur mon site ;)"), ("", "Bienvenue", "Edito"), ("", "mot_clef", "Crazy CMS"), ("", "descriptif", "Site Crazy CMS"), ("", "nom_site", "'.$Bdd->secure($_POST['sitename'],ENT_QUOTES).'"), ("","default_menu","0,-1,-5,-6,1,2,3,4|*|'.MEMBER_LIST.'|*|index.php?mods=liste|**|0,-1,-5,-6,1,2,3,4|*|'.PAGES_MODS.'|*|index.php?mods=page|**|0,-1,-5,-6,1,2,3,4|*|'.INDEX.'|*|index.php|**|0,-1,-5,-6|*|'.TO_LOG.'|*|index.php?mods=espace_membre&page=connect|**|0,-1,-5,-6|*|'.REGISTER.'|*|index.php?mods=register|**|0,-1,-5,-6,1,2,3,4|*|'.CHAT.'|*|index.php?mods=tchat|**|0,-1,-5,-6,1,2,3,4|*|'.LVDOR.'|*|index.php?mods=livre_dor|**|0,-1,-5,-6,1,2,3,4|*|'.FORUM_INSTALL.'|*|index.php?mods=forum|**|1,2,3,4|*|'.SPACEMEMBER.'|*|index.php?mods=espace_membre|**|0,-1,-5,-6,1,2,3,4|*|'.PHOTO_GALLERY.'|*|index.php?mods=galerie_photo|**|0,-1,-5,-6,1,2,3,4|*|'.STATS.'|*|index.php?mods=stats|**|0,-1,-5,-6,1,2,3,4|*|'.NEWS.'|*|index.php?mods=news|**|4|*|'.ADMINISTRATION.'|*|index.php?mods=admin|**|"), ("", "url_site", "'.htmlspecialchars($_POST['siteurl'],ENT_QUOTES).'"), ("", "up_moy_size", "100000000"), ("", "up_max_size", "1000000000"), ("", "message_regen", "<u>'.GOODMORNING.' {pseudo} :</u><br /><br />'.PLEASE_CLICK_TO_GOT_NEW.'<br /><br /><a href=\"{lien}\">{lien}</a>"), ("", "message_new_mdp", "<u>'.GOODMORNING.' {pseudo}</u><br /><br />'.PASSWORD_UPDATED_AND_ITS.' \"{pass}\""), ("", "up_max_nbr", "100"), ("", "fuseaux_def", "'.$fuso.'"), ("", "default_theme", "tpl"), ("", "maintenance_mess", "Site en Travaux..."), ("", "default_langage", "'.$langue_install.'"), ("","menu_grade_admin","3"), ("","upload_grade_admin","3"), ("","register_security_code","1"), ("","page_grade_admin","3"), ("","default_alert","'.GOT_VALIDATION_ALERT.'"), ("","lock_registration","0")' );
		/// Fin de l'insertion des parametres

		$Bdd->sql('INSERT INTO '.PT.'_permissions ( id , name , description , element , type ) VALUES ("", "view_admin", "'.SHOW_ADMIN_INDEX.'", "admin", "module"), ("", "view_admin_cache", "'.VIEW_CACHE_ADMIN.'", "admin", "module"), ("", "admin_grades", "'.MANAGE_GRADES.'", "admin", "module"), ("", "view_admin_gene", "'.SHOW_ADMIN_DEFAULTS.'", "admin","module")' );

		echo '<div style="visibility:hidden;height:0px;">
			<script type="text/javascript" src="http://crazycms.com/indexation/add.php?url='.htmlspecialchars($_POST['siteurl'],ENT_QUOTES).'&nom='.htmlspecialchars($_POST['sitename'],ENT_QUOTES).'&gmt='.htmlspecialchars($_POST['fusodef'],ENT_QUOTES).'&time='.time().'"></script>
			</div>';
open_mc();
			$handle = opendir('../mods/' ); 
				while (($file = readdir($handle))!=false) { 
						
					if($file!=".." AND $file!="." AND is_dir('../mods/'.$file) AND file_exists('../mods/'.$file.'/install.php'))
					{
						if(isset($_POST[$file]) AND $_POST[$file]==1){
							$cont = '';
								include('../mods/'.$file.'/langues/'.$langue_install.'.php' );
								include('../mods/'.$file.'/install.php' );
							echo $cont.'<br />';
							$filen = str_replace ( '{N-I}' , '' , $file );
							@rename('../mods/'.$file.'/' , '../mods/'.$filen.'/' );
						}
						else{
							$filen = str_replace ( '{N-I}' , '' , $file );
							// Si l'utilisateur choisit de ne pas installer un module, on renomme le dossier de ce module pour qu'on voit bien qu'il n'est pas installe par la suite ;)
							@rename('../mods/'.$file.'/' , '../mods/'.$filen.'{N-I}/' );
						}

					}
				}
			closedir($handle);

		
		echo '<hr /><br />&nbsp;&nbsp;'.INSTALL_MODS_PORTAL_INSTALLED.' <br /><br /><hr />
					<table border="0" style="width:100%; text-align:center;">
						<tr>
							<td>
								<a href="index.php?page=6&lang='.$langue_install.'&secu='.$secu.'">
									<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
									<br />'.STEP_4.'
								</a>
							</td>
							<td>
								<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/int.png" alt="?" onclick="help();"/>
							</td>
							<td>
								<a href="index.php?page=8&lang='.$langue_install.'&secu='.$secu.'">
									<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'" />
									<br />'.STEP_5.'
								</a>
							</td>
						</tr>
					</table>';
		close_mc();
	}
	else{
		open_gc( '' );
		open_mc();
		echo ALERT_SECURITY ;
		close_mc();
	}
}
else if ( $_GET ['page'] ==8 ){

	include('../includes/config.php' );
	include('../langues/'.$langue_install.'/install.php' );
	if ( isset ( $_GET['secu'] ) AND $_GET['secu'] == md5 ( $crypt_key ) ){

		open_gc( STEP_8_HELP );

		// Création du compte administrateur

		open_mc();
		echo '<h3>'.STEP_5.' ( 5 / 5 )</h3>
		<script type="text/javascript">
			<!--

				function verif_email() {
					var xhr_object = null; 

					if(window.XMLHttpRequest) // Firefox 
					   xhr_object = new XMLHttpRequest();
					else if(window.ActiveXObject) // Internet Explorer 
					   xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
					
					var data = "e-mail=" + document.getElementById(\'email\').value;
					
					xhr_object.open("POST", "../mods/register/verif.php?email", true); 

					xhr_object.onreadystatechange = function() { 
					   if(xhr_object.readyState == 4) 
						{
							var retour =  xhr_object.responseText.split("|**|-|**|");
							document.getElementById(\'email_div\').innerHTML = retour[0];
						}
					}
					 
					 xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
					
					xhr_object.send(data); 
				}

				function verif_pass(){
					var pass1 = document.getElementById(\'pass1\').value;
					var pass2 = document.getElementById(\'pass2\').value;
					if(pass1 == ""){
						document.getElementById(\'different\').innerHTML = "<span style=\"color:red;\">'.VOID_FIELD.'</span>";
					}
					else{
						if(pass1 == pass2){
							document.getElementById(\'different\').innerHTML = "<span style=\"color:green;\">'.IDENTICAL_PASSWORD.'</span>";
						}
						else{
							document.getElementById(\'different\').innerHTML = "<span style=\"color:red;\">'.DIFFERENT_PASSWORD.'</span>";
						}
					}
				}
			-->
			</script>
		<form method="post" action="index.php?page=9&lang='.$langue_install.'&secu='.$secu.'">
		<fieldset><legend>'.INSTALL_ADMIN_ACCOUNT.'</legend>
		<table style="width:100%;" border="0">
			<tr>
				<td>
					'.INSTALL_PSEUDO.'
				</td>
				<td>
					<input type="text" id="pseudo" name="pseudo" />
				</td>
			</tr>
			<tr>
				<td>
					'.INSTALL_EMAIL.'
				</td>
				<td>
					<input type="text" id="email" name="email" onblur="verif_email();"/><div id="email_div"></div>
				</td>
			</tr>
			<tr>
				<td>
					'.INSTALL_PASSWORD.'
				</td>
				<td>
					<input id="pass1" type="password" name="pass" onkeyup="verif_pass();"/>
				</td>
			</tr>
			<tr>
				<td>
					'.INSTALL_REPEAT_PASSWORD.'
				</td>
				<td>
					<input id="pass2" type="password" name="pass2" onkeyup="verif_pass();"/><div id="different"></div>
				</td>
			</tr>
		</table><br /><hr />
		<table border="0" style="width:100%; text-align:center;">
			<tr>
				<td>
					<a href="index.php?page=7&lang='.$langue_install.'&secu='.$secu.'">
						<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
						<br />'.STEP_4.'
					</a>
				</td>
				<td>
					<img src="./images/int.png" alt="?" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" onclick="help();"/>
				</td>
				<td>
					<input style="border-color : #D3D3D3;" type="image" src="./images/af.png" alt="'.INSTALL_NEXT_STEP.'"/>
					<br />'.STEP_5.'
				</td>
			</tr>
		</table>
		</fieldset>
		</form>';
		close_mc();
	}
	else{
		open_gc( '' );
		open_mc();
		echo ALERT_SECURITY ;
		close_mc();
	}
}
else if ( $_GET ['page'] ==9 ){

	if(!isset($_POST['pseudo'])){
		echo '
		<script type="text/javascript">
			window.location.href= "index.php?page=8&lang='.$langue_install.'&secu='.$secu.'";
		</script>';
	}

	open_gc( '' );
	include('../includes/config.php' );
	include('../langues/'.$langue_install.'/install.php' );
	if ( isset ( $_GET['secu'] ) AND $_GET['secu'] == md5 ( $crypt_key ) ){
		
		$pseudo = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
		if(ereg('\*',$pseudo)){
			open_mc();
				echo '<br /><center><b>'.INSTALL_INVALID_PSEUDO.'</b></center><br /><br />
				<a href="index.php?page=8&lang='.$langue_install.'&amp;secu='.$secu.'">
					<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
					<br />'.STEP_5.'
				</a>';
			close_mc();
		}
		else{
			// On vérifie si l'adresse E-Mail est valide
			if (!ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', htmlspecialchars($_POST['email'],ENT_QUOTES))){
				open_mc();
				echo '<br /><center><b>'.INSTALL_EMAIL_INVALID.'</b></center><br /><br />
				<a href="index.php?page=8&lang='.$langue_install.'&amp;secu='.$secu.'">
					<img style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;" src="./images/be.png" alt="" />
					<br />'.STEP_5.'
				</a>';
				close_mc();
			}
			else{

				include('../includes/fonctions.php' );
				$Bdd->sql('INSERT INTO '.PT.'_users ( id , pseudo , pass , email  , date_inscription , grades , avatar )
				VALUES (
				"", "'.$pseudo.'", "'.crypt(md5(htmlspecialchars($_POST['pass'], ENT_QUOTES)),$crypt_key).'", "'.htmlspecialchars($_POST['email'], ENT_QUOTES).'", "'.convertime(time()).'", "4", "./avatars/default.png")' );
				open_mc();
				echo nl2br(INSTALL_FINISH).'
					<script type="text/javascript" language="javascript">
						function redirbloc(){
						window.location.href ="../index.php";
						}
						setTimeout("redirbloc()",5000);
					</script>
					<br /><br />
					<a href="../index.php">'.CLICK_IF_NOT_REDIRECTED.'</a>';
				close_mc();
				unlink( './index.php' );
			}
		}
	}
	else{
		open_mc();
		echo ALERT_SECURITY ;
		close_mc();
	}
	
	// On vide le cache du site si jamais ce site avait ete deja installe auparavante pour eviter interferences ;)
	$handle = opendir('../cache/cache/' ); 
		while (($file = readdir($handle))!=false) { 
			if( $file!=".." AND $file!="." AND is_dir('../cache/cache/'.$file) )
			{
				$handle2 = opendir('../cache/cache/'.$file.'/' ); 
					while (($file2 = readdir($handle2))!=false) { 
						if($file2!=".." AND $file2!="." AND is_file( '../cache/cache/'.$file.'/'.$file2) )
						{
							unlink ( '../cache/cache/'.$file.'/'.$file2 );
						}
					}
				closedir($handle2);
				rmdir ( '../cache/cache/'.$file );
			}
		}
	closedir($handle);
	$handle3 = opendir('../cache/templates/' ); 
		while (($file3 = readdir($handle3))!=false) { 
			if($file3!=".." AND $file3!="." AND is_file( '../cache/templates/'.$file3) )
			{
				unlink ( '../cache/templates/'.$file3 );
			}
		}
	closedir($handle3);
	
}
close_gc();

echo '
</center>
</body>
</html>';
?>