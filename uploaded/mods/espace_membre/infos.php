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

if ( $grade > 0 ){

	$template->set_filename ( 'haut_mods.tpl' );

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
	
	$template->set_filename ( './modules/espace_membre/infos.tpl' );

	// Update des champs
	if(isset($_POST['pass'])){
		if(strlen($_POST['pass'])<=4 AND strlen($_POST['pass'])>0){
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => warning ) );
			$template->assign_block_vars ( 'text' , array (
			'TXT' => please_enter_password_more_4,
			'URL' => 'index.php?mods=espace_membre&amp;page=infos',
			'BACK' => back ) );
		}
		else{

			switch($_POST['modif_avatar']){
				case 0 :
					$avatar = $Bdd->secure($_POST['last_avatar']);
				break;
				case 1 :
					$avatar = $Bdd->secure($_POST['local_avatar']);
				break;
				case 2 :
					$avatar = $Bdd->secure($_POST['externe_avatar']);

			}

			$date = explode('/',$_POST['date']);
			if ( strlen ( $date[0] ) == 0 )
				$date[0] = '00';
			else if ( strlen ( $date[0] ) == 1 )
				$date[0] = '0'.$date[0];
			if ( strlen ( $date[1] ) == 0 )
				$date[1] = '00';
			else if ( strlen ( $date[1] ) == 1 )
				$date[1] = '0'.$date[1];
			if ( strlen ( $date[2] ) == 0 )
				$date[2] = '0000';
			else if ( strlen ( $date[2] ) == 1 )
				$date[2] = '200'.$date[2];				
			else if ( strlen ( $date[2] ) == 2 )
				$date[2] = '19'.$date[2];
			else if ( strlen ( $date[2] ) == 3 )
				$date[2] = '0'.$date[2];

			$date = $Bdd->secure ( implode ( '' , $date ) );
				
			$sexe = ( ( isset ( $_POST['sexe'] ) ) ? ( intval( $_POST['sexe'] ) ) : ( '' ) );
			$Bdd->sql('UPDATE '.PT.'_users  SET pseudo="'.$Bdd->secure($_POST['pseudo']).'", nom="'.$Bdd->secure($_POST['nom']).'",yahoom="'.$Bdd->secure($_POST['yahoom']).'",email="'.$Bdd->secure($_POST['email']).'" , sexe="'.$sexe.'" ,localisation="'.$Bdd->secure($_POST['localisation']).'" , icq="'.$Bdd->secure($_POST['icq']).'" ,msn="'.$Bdd->secure($_POST['msn']).'" , aim="'.$Bdd->secure($_POST['aim']).'" ,date_naissance="'.$date.'" , signature="'.$Bdd->secure($_POST['contenu']).'" , '.( (strlen($_POST['pass'])>0) ?('pass="'.crypt(md5($Bdd->secure($_POST['pass'])),$crypt_key).'",') : ('') ).' site="'.$Bdd->secure($_POST['site']).'", avatar="'.$avatar.'" WHERE id="'.$uid.'"' );
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => successfully_updated ) );
		
			$template->assign_block_vars ( 'text' , array (
			'TXT' => profil_updated_sucessfully,
			'URL' => 'index.php?mods=espace_membre&amp;page=infos',
			'BACK' => back ) );

			$Bdd->delete_cached_data('config' );
		}
	}
	else{
		// Chargement
		$sql_req = $Bdd->sql('SELECT * FROM '.PT.'_users WHERE '.PT.'_users.id="'.$uid.'"' );
		$sql = $Bdd->get_array($sql_req);
		$annif = preg_replace('!([0-9]{2})([0-9]{2})([0-9]{4})!' , '$1/$2/$3',$sql['date_naissance']);

		// Modification profil
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => update_profil ) );

		if($sql['avatar']==''){
			$img = './avatars/none.png';
		}
		else{
			$img = htmlspecialchars($sql['avatar'],ENT_QUOTES);
		}

		$template->assign_block_vars ( 'index' , array (
		'JS' => '
		<script type="text/javascript">
			<!--
				// Fonction pour verifier le password
				function verif_pass(){
					var pass = document.getElementById(\'pass\').value;
					var pass1 = document.getElementById(\'pass1\').value;
					if(pass == ""){
						document.getElementById(\'different\').innerHTML = "<span style=\"color:red;\">'.please_complete_password.'</span>";
					}
					else{
						if(pass == pass1){
							if(pass.length<=4){
								document.getElementById(\'different\').innerHTML = "<span style=\"color:red;\">'.please_enter_password_more_4.'</span>";
							}
							else{
								document.getElementById(\'different\').innerHTML = "<span style=\"color:green;\">'.same_password.'</span>";
							}
						}
						else{
							document.getElementById(\'different\').innerHTML = "<span style=\"color:red;\">'.wrong_password.'</span>";
						}
					}
				}
				
				// Fonction pour verifier l\'email
				function verif_email(){
					var reg=new RegExp("^(.+)[@](.+)[.][a-zA-Z0-9]+$","g");

					if (reg.test(document.getElementById(\'email\').value)) {
						document.getElementById(\'different_email\').innerHTML = "<span style=\"color:green;\">'.valid_email.'</span>";
						//document.getElementById(\'email\').value = "good";
					}
					else {
						document.getElementById(\'different_email\').innerHTML = "<span style=\"color:red;\">'.not_valid_email.'</span>";
						//document.getElementById(\'email\').value = "false";
					}
				}
		
				function update_img(id){
					if ( id == "rien" ){
						document.getElementById(\'img\').src = "'.$img.'";
					}
					else{
						document.getElementById(\'img\').src = document.getElementById(id).value;
					}
				}

				function lch_rad(id){
					document.getElementById(id).checked = true;
				}
			-->
		</script>
		',
		'PERSONNAL_INFOS' => personnal_infos,
		'PSEUDO' => pseudo,
		'PSEUDO_VALUE' => $pseudo,
		'PASSWORD' => password,
		'CONFIRM_PASSWORD' => confirm_password,
		'EMAIL' => email,
		'EMAIL_VALUE' => $sql['email' ],
		'AVATAR' => avatar,
		'NE_PAS_MODIFIER' => ne_pas_modifier,
		'IMG' => $img,
		'CHOOSE_LOCAL_AVATAR' => choose_local_avatar,
		'CHOOSE' => choose,
		'YOUR_ACTUAL_AVATAR' => your_actual_avatar,
		'CHOOSE_EXTERNE_AVATAR' => choose_externe_avatar,
		'YOUR_NEW_AVATAR' => your_new_avatar,
		'UPLOAD_FROM_COMPUTER' => upload_from_computer,
		'USER_INFO' => user_info,
		'NAME' => name,
		'FIRST_NAME' => first_name,
		'NAME_VALUE' => $sql['nom'],
		'LOCALIZATION' => localization,
		'LOCA_VALUE' => $sql['localisation'],
		'SEX' => sex,
		'SEX_CHECK0' => ( ($sql['sexe']==1) ? ('checked="checked"') : ('') ),
		'SEX_CHECK1' => ( ($sql['sexe']==2) ? ('checked="checked"') : ('') ),
		'MAN' => man,
		'WOMAN' => woman,
		'DATE_OF_BIRTH' => date_of_birth,
		'ANNIF' => $annif,
		'MY_MESS' => my_mess,
		'ADRESS_ICQ' => adress_icq,
		'ADRESS_MSN' => adress_msn,
		'ADRESS_AIM' => adress_aim,
		'ADRESS_YAHOOM' => adress_yahoom,
		'MSN_VALUE' => $sql['msn'],
		'ICQ_VALUE' => $sql['icq'],
		'AIM_VALUE' => $sql['aim'],
		'YAHOOM_VALUE' => $sql['yahoom'],
		'OTHER' => other,
		'WEB_SITE' => web_site,
		'SITE_VALUE' => $sql['site'],
		'SIGNATURE' => signature,
		'FORM' => default_form ( FALSE , NULL , to_html ( $sql['signature'] ) , 150 ),
		'VALID' => valid ) );

		$dir = opendir('./avatars' );
		while(($file = readdir($dir))!=false){
			if(is_file('./avatars/'.$file) AND $file!='.' AND $file!='..' AND $file!='.htaccess' AND $file != 'index.html' ){
				$template->assign_block_vars ( 'index.option' , array (
				'VALUE' => './avatars/'.$file,
				'NAME' => ucfirst ( substr ( $file , 0 , strrpos( $file , '.' ) ) ) ) );
			}
		}
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>
