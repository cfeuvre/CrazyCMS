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
if ( !defined('CCMS') || $lock_registration == 1 )die('' );

$template->set_filename ( 'haut_mods.tpl' );

$template->set_filename ( './modules/register/valid.tpl' );

if (
	$_POST['register_pseudo'] != NULL AND 
	$_POST['register_pass'] != NULL AND 
	$_POST['register_pass2'] != NULL AND 
	$_POST['register_email'] != NULL AND 
	$_POST['register_pass'] == $_POST['register_pass2'] 
){

	$pseudo = $Bdd->secure($_POST['register_pseudo']);
	if(ereg('\*',$pseudo) || strlen($pseudo) < 3 || strlen($pseudo)>20){
		$template->assign_block_vars ( 'text' , array (
		'TXT' => register_pseudo_invalid,
		'URL' => 'index.php?mods=register',
		'BACK' => back ) );
	}
	else{

		// On vérifie que le pseudo ou l'email n'est pas déja utilisé
		$query = $Bdd->sql('SELECT id FROM '.PT.'_users WHERE pseudo = "'.$Bdd->secure($_POST['register_pseudo']).'" OR email = "'.$Bdd->secure($_POST['register_email']).'"' );

			if($Bdd->get_num_rows($query)==0){

			// On vérifie si l'adresse E-Mail est valide

			if (!ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $Bdd->secure($_POST['register_email']))){
				$template->assign_block_vars ( 'text' , array (
				'TXT' => register_mail_invalid,
				'URL' => 'index.php?mods=register',
				'BACK' => back ) );
			}
			if ( $register_security_code == 1 ){
				$security = $Bdd->sql('SELECT valeur FROM '.PT.'_parametres WHERE nom="register:'.$Bdd->secure($HTTP_SERVER_VARS['REMOTE_ADDR']).'"' );
				$security = $Bdd->get_array($security);
				$security = $security['valeur'];
				$Bdd->sql('DELETE FROM '.PT.'_parametres WHERE nom="register:'.$Bdd->secure($HTTP_SERVER_VARS['REMOTE_ADDR']).'"' );
			}

			// Si le code de sécurité est correct
			if ( $_POST['register_code'] == $security || $register_security_code == 0 ){

			 $template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => congratulation ) );

				//Si l'admin ne reclame aucune validation, on active le compte immediatement
				if($users_valid==0){
					$Bdd->sql('
					INSERT INTO 
						'.PT.'_users 
						( pseudo , pass , email , permission , groupe , langue , date_inscription , grades , fuseaux , avatar, last_activity_date )
					VALUES 
						("'.$pseudo.'", "'.crypt(md5($Bdd->secure($_POST['register_pass'])),$crypt_key).'", "'.$Bdd->secure($_POST['register_email']).'", "", "",  "", "'.convertime(time()).'", "1",  "","./avatars/default.png","'.convertime(time()).'")' );

					$template->assign_block_vars ( 'text' , array (
					'TXT' => successful_inscription .' <br />'.redirection,
					'URL' => 'index.php?mods=espace_membre&page=connect',
					'BACK' => back ) );
				}
				else if($users_valid==1){
				//Validation par admin => grade -5
					$Bdd->sql('
					INSERT INTO 
						'.PT.'_users 
						( pseudo , pass , email , permission , groupe , langue , date_inscription , grades , fuseaux , avatar, last_activity_date )
					VALUES 
						("'.$pseudo.'", "'.crypt(md5($Bdd->secure($_POST['register_pass']),$crypt_key)).'", "'.$Bdd->secure($_POST['register_email']).'", "", "",  "", "'.convertime(time()).'", "-5",  "","./avatars/default.png","'.convertime(time()).'")' );

					$template->assign_block_vars ( 'text' , array (
					'TXT' => account_must_admin_activ .' <br />'.redirection,
					'URL' => 'index.php?mods=espace_membre&page=connect',
					'BACK' => back ) );
				}
				else if($users_valid==2){
					//Validation par email => grade -6
						$Bdd->sql('
						INSERT INTO 
							'.PT.'_users 
							( pseudo , pass , email , permission , groupe , langue , date_inscription , grades , fuseaux , avatar, last_activity_date )
						VALUES 
							("'.$pseudo.'", "'.crypt(md5($Bdd->secure($_POST['register_pass'])),$crypt_key).'", "'.$Bdd->secure($_POST['register_email']).'", "", "",  "", "'.convertime(time()).'", "-6",  "","./avatars/default.png","'.convertime(time()).'")' );

					// On genere le code d'activation ...
					$char = array('0' , '1' , '2' , '3' , '4' , '5' , '6' , '7' , '8' , '9' , 'a' , 'z' , 'e' , 'r' , 't' , 'y' , 'u' , 'i' , 'o' , 'p' , 'q' , 's' , 'd' , 'f' , 'g' , 'h' , 'j' , 'k' , 'l' , 'm' , 'w' , 'x' , 'c' , 'v' , 'b' , 'n' );
					$code = '';
					for($i=0;$i<=15;$i++)$code .= $char[mt_rand(0,35)];

					$Bdd->sql('DELETE FROM '.PT.'_parametres WHERE nom="activ:'.$pseudo.'"' );
					$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES("","activ:'.$pseudo.'","'.$code.'")' );

					$message = '<u>'.$pseudo.'</u><br /><br />'.your_account_on.' '.$nom_site.' '.nl2br ( how_to_activate_it ).'<br /><br /><a href="http://'.str_replace('http://' , '',preg_replace('!/$!' , '',$url_site)).'/index.php?mods=register&page=acti&i='.convertime(time()).'&code='.$code.'&pseudo='.$pseudo.'">http://'.str_replace('http://' , '',preg_replace('!/$!' , '',$url_site)).'/index.php?mods=register&page=acti&pseudo='.$pseudo.'&i='.convertime ( time() ).'&code='.$code.'</a>';

					$entete = "MIME-Version: 1.0\r\n";
					$entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$entete .= "To: ".$pseudo." <".htmlspecialchars($_POST['email'],ENT_QUOTES).">\r\n";
					$entete .= "From: \r\n";
					if(!@mail(htmlspecialchars($_POST['register_email'], ENT_QUOTES), 'Activation de votre compte sur '.$nom_site, $message, $entete)){
						$cont .= email_cant_be_send;
					}
					else {
						$template->assign_block_vars ( 'text' , array (
						'TXT' => email_sended_to_activ.' <br />'.redirection,
						'URL' => 'index.php?mods=espace_membre&page=connect',
						'BACK' => back ) );
					}
				}
			}
			else{
				$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => invalid_code ) );
				$template->assign_block_vars ( 'text' , array (
				'TXT' => code_false,
				'URL' => 'index.php?mods=register',
				'BACK' => back ) );
			}
		}
		else{
			$template->assign_block_vars ( 'text' , array (
			'TXT' => user_exist,
			'URL' => 'index.php?mods=register',
			'BACK' => back ) );
		}
	}
}
$template->set_filename ( 'bas_mods.tpl' );
?>
