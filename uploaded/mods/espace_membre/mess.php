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
if($grade>0){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => messagerie ) );

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
	
	$template->set_filename ( './modules/espace_membre/mess.tpl' );
	
	if (isset ($_POST['envoyer'])){
		if ($_POST['sujet'] == '')$_POST['sujet'] = no_titre;
		$destinataire = explode ( ';', str_replace ( ' ' , '' , $Bdd->secure ( $_POST["destinataire"] ) ) , 15 );
		// On recupere les id des destinataires
		$query = 'SELECT id, pseudo FROM '.PT.'_users WHERE ';
		$a = false;
		foreach ( $destinataire as $pseudo ){
			if ( $pseudo != '' ){
				if ( $a != false )$query .= ' OR ';
				$query .= 'pseudo="'.$Bdd->secure ( $pseudo ).'"';
				$a = true;
			}
		}
		
		$query = $Bdd->sql ( $query ) ;
		while ( $sql = $Bdd->get_array ( $query ) ){
			$Bdd->sql('INSERT INTO '.PT.'_messagerie VALUES ("","'.$sql['id'].'","'.$uid.'","'.$Bdd->secure($_POST['sujet']).'","'.$Bdd->secure($_POST['contenu']).'","'.convertime(time()).'","1")' );
		}
		
		$template->assign_block_vars ( 'valid' , array (
		'CONFIRMATION' => confirmation,
		'MESSAGE_SENDED' => message_sended ) );
	}
	else{

		if ( isset ( $_GET['to'] ) )
			$to_value = $users_infos[intval($_GET['to'])]['pseudo'];
		else
			$to_value = '';
					
		$template->assign_block_vars ( 'index' , array (
		'JS' => '
		<script type="text/javascript">
			<!--
				function upd_field(){
					document.getElementById(\'dest\').value += document.getElementById(\'destin\').value + ";";
				}
				setTimeout("redir()",2500);
			-->
		</script>',
		'SEND_MP' => send_mp,
		'DESTINATAIRE' => Destinataire,
		'TO_VALUE' => $to_value,
		'U_CAN_SEND_MULTY' => u_can_send_multy,
		'AUTHOR' => Author,
		'TOPIC' => Topic,
		'CONTENT' => Content,
		'FORM' => default_form ( FALSE , NULL , your_content ),
		'VALID' => valid ) );

		if(!isset($_GET['to'])){
			$template->assign_block_vars ( 'index.to' , array (
			'MEMBERLIST' => memberlist ) );
			
			$sql=$Bdd->sql('SELECT id,pseudo FROM '.PT.'_users WHERE id != 1 AND grades > 0 ORDER BY pseudo' );
			while ($mess=$Bdd->get_array($sql))
			{
				$template->assign_block_vars ( 'index.to.user' , array (
				'PSEUDO' => htmlspecialchars($mess['pseudo']) ) );
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