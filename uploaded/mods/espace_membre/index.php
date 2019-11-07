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
	
// Si l'utilisateur n'est pas un invité, on lui affiche son espace personel
if(isset($grade) && $grade>0){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => my_infos ) );

	$template->set_filename ( './modules/espace_membre/links.tpl' );
	$template->assign_block_vars ( 'links' , array (
	'UID' => $uid,
	'PWD' => $user_password,
	'UNLOG' => unlog,
	'MY_BLOC_NOTE' => my_bloc_note,
	'MODIF_PROFIL' => modif_profil,
	'CHANGE_LANGUAGE' => change_language,
	'CHANGE_THEME' => change_theme,
	'MY_INFOS' => my_infos,
	'MY_CONFIG' => my_config ) );
	
	$template->set_filename ( './modules/espace_membre/index.tpl' );
	
	$sql = $Bdd->sql('SELECT * FROM '.PT.'_users WHERE '.PT.'_users.id="'.$uid.'"' );
	$sql = $Bdd->get_array($sql);

	// On verifie si l'utilisateur a des messages privés 
	$non_lu = 0;
	$lu = 0;
	$sql2=$Bdd->sql('SELECT * FROM '.PT.'_messagerie WHERE  '.PT.'_messagerie.destinataire="'.$uid.'" ' );
	while($compte_nb = $Bdd->get_object($sql2)){
		if($compte_nb->vu == 0){
			$lu++;
		}
		else if($compte_nb->vu ==1){
			$non_lu++;
		}
	}
	
	$template->assign_block_vars ( 'index' , array(
	'JS' =>'
	<script type="text/javascript">
		<!--
			function redir(url){
				window.location.href = url;
			}
		-->
	</script>',
	'SPACEMEMBER_HELP' => spacemember_help,
	'PERSONNAL_INFOS' => personnal_infos,
	'YOUR_FICHE' => your_fiche,
	'PSEUDO' => pseudo,
	'NAME' => name,
	'PSEUDO_VALUE' => htmlspecialchars($sql['pseudo']),
	'NAME_VALUE' => htmlspecialchars($sql['nom']),
	'MY_MAIL_ADRESS' => my_mail_adress,
	'MY_MAIL_ADRESS_VALUE' => htmlspecialchars($sql['email']),
	'INSCRIPTION_DATE' => inscription_date,
	'INSCRIPTION_DATE_VALUE' => date('d/m/Y',$sql['date_inscription']),
	'UID' => $uid,
	'MY_COMPLETE_FICHE' => my_complete_fiche,
	'PURPOSE_A_NEWS' => purpose_a_news,
	'SEE_UR_PROFILE' => see_ur_profil,
	'MESSAGERIE' => messagerie,
	'YOUR_MESSAGERIE' => your_messagerie,
	'YOU_HAVE' => you_have,
	'NON_LU' => $non_lu,
	'NEW_MP' => new_mp,
	'LU' => $lu,
	'ARCHIVED_MP' => archived_mp,
	'SEE_MY_MP' => see_my_mp,
	'SEND_A_MP' => send_a_mp ) );

	$a = 0;
	// Si l'utilisateur n'est pas un administrateur, on lui affiche une liste des sectiosn de l'administration dont il a acces
	if ( $grade != 4 ) {
		$handle = opendir ( './mods/' ); 
		while (($file = readdir())!=false) { 
			clearstatcache(); 
			if($file!=".." && $file!="." && file_exists('./mods/'.$file.'/admin.php') && substr ( $file , -5 ) != '{N-I}' )
			{
				$mod_see_admin = $file.'_grade_admin';
				$grade_see_admin = ${$mod_see_admin};
				// On affiche que module fonctionnant avec ce systeme ;)
				if ( isset ( ${$mod_see_admin} ) ) {
					$grades = explode ( ',' , $grade_see_admin );
					// Si l'utilisateur actuel a lautorisation d'administrer ce module, on lui indique un lien ;)
					if ( in_array ( $grade , $grades ) ){
						if ( $a == 0 ){
							$template->assign_block_vars ( 'index.admin' , array ( 'ADMINISTRATION' => ADMINISTRATION  ) );
						}
						$template->assign_block_vars ( 'index.admin.cat' , array ( 'FILE' => $file ) );
						$a ++;
					}
				}
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