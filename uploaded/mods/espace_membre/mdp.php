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
if(!defined('CCMS'))die('' );

if ( $grade == 0 ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => found_his_password ) );

	$template->set_filename ( './modules/espace_membre/mdp.tpl' );
	
	if(isset($_GET['regenerer'])){
		$query = $Bdd->sql('SELECT id FROM '.PT.'_parametres WHERE nom="regeneration:'.str_replace('%20' , '',$Bdd->secure($_GET['pseudo'])).'" AND valeur="'.$Bdd->secure($_GET['regenerer']).'"' );
		if(mysql_num_rows($query)==0){
			$template->assign_block_vars ( 'text' , array (
			'TXT' => verif_error_retry,
			'BACK' => back ) );
		}
		else{
			$entete = "MIME-Version: 1.0\r\n";
			$entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$entete .= "To: ".htmlspecialchars($_GET['pseudo'],ENT_QUOTES)." <".htmlspecialchars($_GET['email'],ENT_QUOTES).">\r\n";
			$entete .= "From: $nom_site\r\n";
			$char = array('0' , '1' , '2' , '3' , '4' , '5' , '6' , '7' , '8' , '9' , 'a' , 'z' , 'e' , 'r' , 't' , 'y' , 'u' , 'i' , 'o' , 'p' , 'q' , 's' , 'd' , 'f' , 'g' , 'h' , 'j' , 'k' , 'l' , 'm' , 'w' , 'x' , 'c' , 'v' , 'b' , 'n' );
			$new_pass = '';
			for($i=0;$i<=6;$i++)$new_pass .= $char[mt_rand(0,35)];
			$array = array('{pseudo}' => htmlspecialchars($_GET['pseudo'],ENT_QUOTES), '{pass}' => $new_pass);
			foreach ( $array as $key => $val )$message_new_mdp = str_replace($key,$val,$message_new_mdp);
			if(!@mail(htmlspecialchars($_GET['email'],ENT_QUOTES), your_new_password, $message_new_mdp, $entete)){
				$template->assign_block_vars ( 'text' , array (
				'TXT' => email_cant_be_send,
				'BACK' => back ) );
			}
			else {
				$template->assign_block_vars ( 'text' , array (
				'TXT' => PWD_RESENDED,
				'BACK' => back ) );
				//On met a jour l'utilisateur avec son nouveau mot de passe
				$Bdd->sql('UPDATE '.PT.'_users SET pass="'.crypt(md5($new_pass),$crypt_key).'" WHERE pseudo="'.$Bdd->secure($_GET['pseudo']).'" AND email="'.$Bdd->secure($_GET['email']).'"' );
			}
			$Bdd->sql('DELETE FROM '.PT.'_parametres WHERE nom="regeneration:'.$Bdd->secure($_GET['pseudo']).'"' );
		}
	}
	else{
		if(isset($_POST['email'])){
			//On cherche l'utilisateur avec cette adresse E-mail
			// Si il existe on lui envoi un mail pour avoir la confirmation qu'il veut changer son mdp ;)
			$query = $Bdd->sql('SELECT pseudo FROM '.PT.'_users WHERE email="'.$Bdd->secure($_POST['email']).'"' );
			if($Bdd->get_num_rows($query)!=0){
				$sql = $Bdd->get_array($query);

				$url = str_replace('http://' , '',preg_replace('!/$!' , '',$url_site));
				$char = array('0' , '1' , '2' , '3' , '4' , '5' , '6' , '7' , '8' , '9' , 'a' , 'z' , 'e' , 'r' , 't' , 'y' , 'u' , 'i' , 'o' , 'p' , 'q' , 's' , 'd' , 'f' , 'g' , 'h' , 'j' , 'k' , 'l' , 'm' , 'w' , 'x' , 'c' , 'v' , 'b' , 'n' );
				$code = '';
				for($i=0;$i<=15;$i++)$code .= $char[mt_rand(0,35)];
				$lien = 'http://'.$url.'/index.php?mods=espace_membre&page=mdp&regenerer='.$code.'&pseudo='.$sql['pseudo'].'&email='.htmlspecialchars($_POST['email']);
				$Bdd->sql('DELETE FROM '.PT.'_parametres WHERE nom="regeneration:'.$sql['pseudo'].'"' );
				$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES("","regeneration:'.$sql['pseudo'].'","'.$code.'")' );
				$array = array('{pseudo}' => $sql['pseudo'], '{lien}' => $lien);
				foreach ( $array as $key => $val )$message_regen = str_replace($key,$val,$message_regen);
				$entete = "MIME-Version: 1.0\r\n";
				$entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$entete .= "To: ".$sql['pseudo']." <".htmlspecialchars($_POST['email'],ENT_QUOTES).">\r\n";
				$entete .= "From: $nom_site\r\n";
				if(!@mail(htmlspecialchars($_POST['email'],ENT_QUOTES), update_pass_request, $message_regen, $entete)){
					$template->assign_block_vars ( 'text' , array (
					'TXT' => email_cant_be_send,
					'BACK' => back ) );
				}
				else {
					$template->assign_block_vars ( 'text' , array (
					'TXT' => email_sended_1,
					'BACK' => back ) );
				}
			}
			else{
				$template->assign_block_vars ( 'text' , array (
				'TXT' => none_users_with_it,
				'BACK' => back ) );
			}
		}
		else{
			$template->assign_block_vars ( 'index' , array (
			'ENTER_MAIL' => please_enter_your_mail_addr,
			'VALID' => valid ) );
		}
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => already_connected ) );
}
?>