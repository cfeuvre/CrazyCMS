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

if($grade == 4){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array (
	'TITRE' => OPTION_SITE) );
	$template->set_filename ( './modules/admin/gen.tpl' );

	// Update des enregistrements en cas de validation
	if (isset ($_POST['nom_site']))
	{
	
		$logs->add_event ( HAS_UPDATED_GEN_CONFIG , GEN_ADMIN );

		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['be_log']).'" WHERE nom="be_log"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['default_theme_locked']).'" WHERE nom="default_theme_locked"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['lock_registration']).'" WHERE nom="lock_registration"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['security_code']).'" WHERE nom="register_security_code"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['use_wysi']).'" WHERE nom="use_wysiwyg"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['maintenance_mod']).'" WHERE nom="maintenance_mod"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['copyright']).'" WHERE nom="copyright"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['contenu']).'" WHERE nom="edito"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['titre_edito']).'" WHERE nom="titre_edito"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['mot_clef']).'" WHERE nom="mot_clef"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['descriptif']).'" WHERE nom="descriptif"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['nom_site']).'" WHERE nom="nom_site"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['message_new_mdp']).'" WHERE nom="message_new_mdp"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['message_regen']).'" WHERE nom="message_regen"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['users_valid'],ENT_QUOTES).'" WHERE nom="users_valid"' );
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure($_POST['maintenance_mess']).'" WHERE nom="maintenance_mess"' );
		
	
		$valid=false;
		$handle = opendir("./langues/"); 
			while (($file = readdir())!=false) { 
				clearstatcache(); 
				if($file!=".." && $file!="." && is_dir('./langues/'.$file.'/') && file_exists('./langues/'.$file.'/lang.php'))
				{
					if($file==$_POST['default_langue'])$valid=true;
				}
			}
		closedir($handle); 
		if($valid===true){
			$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.htmlspecialchars($_POST['default_langue'],ENT_QUOTES).'" WHERE nom="default_langage"' );
		}
		$valid=false;
		$handle = opendir("./themes/"); 
			while (($file = readdir())!=false) { 
				clearstatcache(); 
				if($file!=".." && $file!="." && is_dir('./themes/'.$file.'/') && file_exists('./themes/'.$file.'/header.tpl'))
				{
					if($file==$_POST['default_theme'])$valid=true;
				}
			}
		closedir($handle); 
		if($valid===true){
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.htmlspecialchars($_POST['default_theme'],ENT_QUOTES).'" WHERE nom="default_theme"' );
		}
		$Bdd->delete_cached_data('config' );
		
		$template->assign_block_vars ( 'text' , array (
		'TXT' => successfully_updated,
		'URL' => '',
		'BACK' => back ) );
	}
	else{
		$template->assign_block_vars ( 'index' , array (
		'MAIN_OPTIONS' => MAIN_OPTIONS,
		'NOM_SITE' => NOM_SITE,
		'SITENAME' => stripslashes ( htmlspecialchars ( $nom_site ) ),
		'DESC' => DESC,
		'DESCRIPTIF' => stripslashes ( htmlspecialchars ( $descriptif ) ),
		'MC' => MC,
		'KEYWORDS' => stripslashes ( htmlspecialchars ( $mot_clef ) ),
		'DEFAULT_LANGUAGE' => DEFAULT_LANGUAGE,
		'DEFAULT_THEME' => DEFAULT_THEME, 
		'RESET' => RESET,
		'BACK' => back,
		'VALID' => valid,
		'FORM_EDITO' => default_form ( FALSE , NULL , to_html ( $edito ) ),
		'CONTENU' => contenu,
		'EDITO_TITLE' => stripslashes ( htmlspecialchars ( $titre_edito ) ),
		'TITLE' => TITLE,
		'EDITO' => EDITO,
		'COPY' => stripslashes ( htmlspecialchars ( $copyright ) ),
		'COPYRIGHTS' => COPYRIGHTS,
		'MAIL2' => stripslashes ( htmlspecialchars ( $message_new_mdp ) ),
		'RECUP_PASS_MAIL_2' => MAIL_NEW_MDP,
		'MAIL' => stripslashes ( htmlspecialchars ( $message_regen ) ),
		'RECUP_PASS_MAIL' => RECUP_PASS_MAIL,
		'LOGO' => LOGO,
		'LOGO_VALUE' => stripslashes ( htmlspecialchars ( $logo ) ),
		'SECONDARY_OPTIONS' => SECONDARY_OPTIONS,
		'MAINTENANCE_MESS' => stripslashes ( $maintenance_mess ),
		'MAINTENANCE_NOTES' => MAINTENANCE_NOTES,
		'MAINT_MOD' => ( ( $maintenance_mod == 1 ) ? ( '' ) : ( 'visibility:hidden;height:0px;' ) ),
		'NO' => NO,
		'YES' => YES,
		'MAINT_NO' => ( ( $maintenance_mod == 0 ) ? ( 'checked="checked"' ) : ('') ),
		'MAINT_YES' => ( ( $maintenance_mod == 1 ) ? ( 'checked="checked"' ) : ('') ),
		'ENABLE_MAINT' => ENABLE_MAINT,
		'USE_DEFAULT_THEME' => USE_DEFAULT_THEME,
		'USER_VALIDATION' => USER_VALIDATION,
		'CLOSE_REGISTRATION' => CLOSE_REGISTRATION,
		'FORCE_LOGIN' => FORCE_LOGIN,
		'FORMTYPE' => FORMTYPE,
		'SECU_CODE' => SECU_CODE,
		'LOCK_REG_0' => ( ($lock_registration==0) ? ('checked="checked"') : ('') ),
		'LOCK_REG_1' => ( ($lock_registration==1) ? ('checked="checked"') : ('') ),
		'ENABLED' => ENABLED,
		'BBFORM' => BB_FORM,
		'BE_LOG_0' => ( ($be_log==0) ? ('checked="checked"') : ('') ),
		'BE_LOG_1' => ( ($be_log==1) ? ('checked="checked"') : ('') ),
		'WISYFORM' => WISY_FORM,
		'WISY_0' => ( ($use_wysiwyg==0) ? ('checked="checked"') : ('') ),
		'WISY_1' => ( ($use_wysiwyg==1) ? ('checked="checked"') : ('') ),
		'DISABLED' => DISABLED,
		'ONLY_ACTIVATE_IF_PICTURE' => ONLY_ACTIVATE_IF_PICTURE,
		'SEC_0' => ( ($register_security_code==0) ? ('checked="checked"') : ('') ),
		'SEC_1' => ( ($register_security_code==1) ? ('checked="checked"') : ('') ),
		'NONE' => NONE,
		'USERS_VALID_0' => ( ($users_valid==0) ? ('checked="checked"') : ('') ),
		'USERS_VALID_1' => ( ($users_valid==1) ? ('checked="checked"') : ('') ),
		'USERS_VALID_2' => ( ($users_valid==2) ? ('checked="checked"') : ('') ),
		'ADMIN_VALID' => ADMIN_VALID,
		'EMAIL_VALID' => EMAIL_VALID,
		'LOCK_THEME_0' => ( ($default_theme_locked==0) ? ('checked="checked"') : ('') ),
		'LOCK_THEME_1' => ( ($default_theme_locked==1) ? ('checked="checked"') : ('') ),) );
	
		$handle = opendir("./langues/"); 
		while ( ( $file = readdir() ) != FALSE ){
			if($file!=".." && $file!="." && is_dir('./langues/'.$file.'/') && file_exists('./langues/'.$file.'/lang.php')){
				$template->assign_block_vars ( 'index.lang' , array (
				'FILE' => $file,
				'SELECTED' => ( ( $default_langage == $file ) ? ('selected="selected"') : ('') ),
				'FFILE' => ucfirst($file) ) );
			}
		}
		closedir($handle); 

		$handle = opendir("./themes/"); 
			while (($file = readdir())!=false) { 
				if($file!=".." && $file!="." && is_dir('./themes/'.$file.'/') && file_exists('./themes/'.$file.'/header.tpl'))
				{
					$template->assign_block_vars ( 'index.theme' , array (
					'FILE' => $file,
					'SELECTED' => ( ( $default_theme == $file ) ? ('selected="selected"') : ('') ),
					'FFILE' => ucfirst($file) ) );
				}
			}
		closedir($handle);
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>